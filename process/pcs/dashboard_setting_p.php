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

        $sql = "SELECT *
                FROM t_plan 
                WHERE IRCS_Line = '" . $IRCS_Line . "' 
                AND Status = 'Pending'";

        $stmt = $conn_pcad->prepare($sql);
        $stmt->bindParam(':IRCS_Line', $IRCS_Line);
        $stmt->execute();
        $line = $stmt->fetch(PDO::FETCH_ASSOC);

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

        $p = array(
            "plan" => $Target,
            "actual" => $Actual_Target,
            "remaining" => $Remaining_Target,
            "takt" => $takt,
            "started" => $started
        );
        
        if ($stmt->execute()) {
            header("content-type: application/json");
            echo json_encode($p);
        } else {
            // Handle the case when the query fails
            echo "Failed to get plan.";
        }
    } else if ($request == "addTarget") {
        $registlinename = $_POST['registlinename'];
        $group = $_POST['group'];
    
        $sql_get_line = "SELECT * FROM t_plan WHERE IRCS_Line = :registlinename AND `group` = :group";

        $stmt_get_line = $conn_pcad->prepare($sql_get_line);
        $stmt_get_line->bindParam(':registlinename', $registlinename);
        $stmt_get_line->bindParam(':group', $group);
    
        if ($stmt_get_line->execute()) {
            header("location: ../../index_exec.php?registlinename=" . $registlinename);
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



