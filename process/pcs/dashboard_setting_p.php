<?php
include '../server_date_time.php';
include '../conn/pcad.php';
include '../conn/ircs.php';
include '../lib/emp_mgt.php';
include '../lib/main.php';
include '../lib/inspection_output.php';

function TimeToSec($time)
{
    $sec = 0;
    foreach (array_reverse(explode(':', $time)) as $k => $v) $sec += pow(60, $k) * $v;
    return $sec;
}

if (isset($_POST['request'])) {
    $request = $_POST['request'];
   if ($request == "getPlanLine") {
        $shift = get_shift($server_time);

        $IRCS_Line = $_POST['registlinename'];

        $last_takt = $_POST['last_takt'];
        $sql = " 
        SELECT *
        FROM t_plan 
        WHERE IRCS_Line = '" . $IRCS_Line . "' 
        AND Status = 'Pending' 
    ";
        $stmt = $conn_pcad->prepare($sql);
        $stmt->bindParam(':IRCS_Line', $IRCS_Line);
        $stmt->execute();
        $line = $stmt->fetch(PDO::FETCH_ASSOC);

        $lot_no = explode(',', $line['lot_no']);
        $Target = $line['Target'];
        $IRCS_IP = $line['IP_address'];
        $takt = $line['takt_secs_DB'];
        $started = $line['actual_start_DB'];

        $ircs_line_data_arr = get_ircs_line_data($IRCS_Line, $conn_pcad);

        $search_arr = array(
            'shift' => $shift,
            'registlinename' => $IRCS_Line,
            'ircs_line_data_arr' => $ircs_line_data_arr,
            'server_date_only' => $server_date_only,
            'server_date_only_yesterday' => $server_date_only_yesterday,
            'server_date_only_tomorrow' => $server_date_only_tomorrow,
            'server_time' => $server_time
        );

        $Actual_Target = count_overall_g($search_arr, $conn_ircs);
        $Remaining_Target = $Actual_Target - $Target;

        if (!$Target) {
            $Target = 0;
        }

        $lots = array();
        $q = "SELECT DISTINCT LOT
        FROM IRCS.T_PACKINGWK 
        WHERE (REGISTLINENAME LIKE '" . $IRCS_Line . "' OR IPADDRESS = '" . $IRCS_IP . "') AND REGISTDATETIME >= TO_DATE('" . $started . "', 'yyyy-MM-dd HH24:MI:SS') AND PACKINGBOXCARDJUDGMENT = '1'";

        $stid = oci_parse($conn_ircs, $q);
        oci_execute($stid);
        while ($row = oci_fetch_object($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $lots[] = $row->LOT;
        }

        $lot_nos = implode(',', array_unique(array_merge($lots, $lot_no)));

        $p = array(
            "plan" => $Target,
            "actual" => $Actual_Target,
            "remaining" => $Remaining_Target,
            "takt" => $takt,
            "started" => $started,
            "lot" => $lot_nos
        );
        //UPDATE PLAN
        $added_target_formula = "FLOOR(TIME_TO_SEC(TIMEDIFF(NOW(), last_update_DB)) / takt_secs_DB)";
        $sql = "UPDATE t_plan SET Target = Target + $added_target_formula, Actual_Target = :Actual_Target, Remaining_Target = :Remaining_Target, last_takt_DB = :last_takt, last_update_DB = NOW(), lot_no = :lot_nos WHERE IRCS_Line = :IRCS_Line AND Status = 'Pending' AND is_paused = 'NO'";

        $stmt = $conn_pcad->prepare($sql);
        $stmt->bindParam(':Actual_Target', $Actual_Target);
        $stmt->bindParam(':Remaining_Target', $Remaining_Target);
        $stmt->bindParam(':last_takt', $last_takt);
        $stmt->bindParam(':lot_nos', $lot_nos);
        $stmt->bindParam(':IRCS_Line', $IRCS_Line);

        if ($stmt->execute()) {
            header("content-type: application/json");
            echo json_encode($p);
        } else {
            // Handle the case when the query fails
            echo "Failed to update plan.";
        }
    } else if ($request == "updateTakt") {
        $IRCS_Line = $_POST['registlinename'];
        $added_takt_plan = $_POST['added_takt_plan'];
        $sql = "UPDATE t_plan SET Target = (Target + 1) WHERE IRCS_Line = :IRCS_Line AND Status = 'Pending'";
        $stmt = $conn_pcad->prepare($sql);
        $stmt->bindParam(':IRCS_Line', $IRCS_Line);
        if ($stmt->execute()) {
            echo 'true';
        } else {
            echo 'false';
        }
    } else if ($request == "addTarget") {
        $registlinename = $_POST['registlinename'];
        $group = $_POST['group'];
    
        $sql_get_line = "SELECT * FROM t_plan WHERE IRCS_Line = :registlinename AND `group` = :group";

        $stmt_get_line = $conn_pcad->prepare($sql_get_line);
        $stmt_get_line->bindParam(':registlinename', $registlinename);
        $stmt_get_line->bindParam(':group', $group);
    
        if ($stmt_get_line->execute()) {
            header("location: ../../index_IV.php?registlinename=" . $registlinename);
        } else {
            echo "Failed to execute the query.";
        }
    }
    
     else if ($request == "getLineNo") {
        $registlinename = $_POST['registlinename'];
        $q = "SELECT * FROM m_ircs_line WHERE ircs_line = :registlinename ";
        $stmt = $conn_pcad->prepare($q);
        $stmt->bindParam(':registlinename', $registlinename);
        $stmt->execute();
        $line = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($line) {
            echo $line['line_no'];
        } else {
            echo "Line not found";
        }
    } 
}



