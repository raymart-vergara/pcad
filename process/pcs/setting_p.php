<?php
include '../conn/pcad.php';
include '../conn/ircs.php';

function TimeToSec($time) {
    $sec = 0;
    foreach (array_reverse(explode(':', $time)) as $k => $v) $sec += pow(60, $k) * $v;
    return $sec;
}

if(isset($_POST['request'])){
$request = $_POST['request'];   
if($request == "getPlan"){
    $carmaker = $_POST['carmaker'];
    $sql = " SELECT * FROM t_plan  WHERE Carmodel  LIKE '%".$carmaker."%' AND Status = 'Pending' ";
    $stmt = $conn_pcad->prepare($sql);
    $stmt->bindValue(':carmaker', '%' . $carmaker . '%', PDO::PARAM_STR);
    $stmt->execute();
    $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($plans) {
        foreach ($plans as $i => $p) {
                $IRCS_Line = $p['IRCS_Line'];
                $Actual_Target = 0;
                $IRCS_IP = $p['IP_address'];
                $started = $p['actual_start_DB'];
                $q = "
                    SELECT COUNT(*) AS c
                    FROM IRCS.T_PACKINGWK 
                    WHERE (REGISTLINENAME LIKE '".$IRCS_Line."' OR IPADDRESS = '".$IRCS_IP."') 
                    AND REGISTDATETIME >= TO_DATE('".$started."', 'yyyy-MM-dd HH24:MI:SS') AND PACKINGBOXCARDJUDGMENT = '1'";
                $stid = oci_parse($conn_ircs, $q);
                oci_execute($stid);
                while ($row = oci_fetch_object($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    $Actual_Target = $row->C;
                }
                $Target = $p['Target'];
                $Remaining_Target = $Target - $Actual_Target;
                $class = '';
                if($Actual_Target > $Target){
                    $Remaining_Target = '+'.abs($Target - $Actual_Target);
                }else{
                    $Remaining_Target = $Target - $Actual_Target;
                }
                if($Actual_Target >= $Target){
                    $class = 'tr-met';
                }else{
                    $class = 'tr-unmet';
                }
                echo '<tr class="'.$class.' tr-click" data-id="'.$p['ID'].'">';
                echo '<td>'.$p['Line'].'</td>';
                echo '<td>'.$p['Target'].'</td>';
                echo '<td>'.$Actual_Target.'</td>';
                echo '<td>'.$Remaining_Target.'</td>';
                echo '</tr>';
        }
    }
}else if($request == "getPlanLine"){
    $IRCS_Line = $_POST['registlinename'];
    $last_takt = $_POST['last_takt'];
    $sql = " 
        SELECT *
        FROM t_plan 
        WHERE IRCS_Line = '".$IRCS_Line."' 
        AND Status = 'Pending' 
    ";
    $stmt = $conn_pcad->prepare($sql);
    $stmt->bindParam(':IRCS_Line', $IRCS_Line);
    $stmt->execute();
    $line = $stmt->fetch(PDO::FETCH_ASSOC);

    $lot_no = explode(',', $line['lot_no']);
    $Target = $line['Target'];
    $IRCS_IP = $line['IP_address'];
    $Actual_Target = 0;
    $takt = $line['takt_secs_DB'];
    $started = $line['actual_start_DB'];
    $q = "SELECT COUNT(*) AS c
        FROM IRCS.T_PACKINGWK 
        WHERE (REGISTLINENAME LIKE '".$IRCS_Line."' OR IPADDRESS = '".$IRCS_IP."') AND REGISTDATETIME >= TO_DATE('".$started."', 'yyyy-MM-dd HH24:MI:SS') AND PACKINGBOXCARDJUDGMENT = '1'";

    $stid = oci_parse($conn_ircs, $q);
    oci_execute($stid);
    while ($row = oci_fetch_object($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $Actual_Target = $row->C;
    }

    $Remaining_Target = $Actual_Target - $Target;

    if(!$Target){
        $Target = 0;
    }

    $lots = array();
     $q = "SELECT DISTINCT LOT
        FROM IRCS.T_PACKINGWK 
        WHERE (REGISTLINENAME LIKE '".$IRCS_Line."' OR IPADDRESS = '".$IRCS_IP."') AND REGISTDATETIME >= TO_DATE('".$started."', 'yyyy-MM-dd HH24:MI:SS') AND PACKINGBOXCARDJUDGMENT = '1'";

    $stid = oci_parse($conn_ircs, $q);
    oci_execute($stid);
    while ($row = oci_fetch_object($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $lots[] = $row->LOT;
    }

    $lot_nos = implode(',', array_unique(array_merge($lots,$lot_no)));

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
    
    
}else if($request == "updateTakt"){
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
    
}else if($request == "endTarget"){
    $IRCS_Line = $_POST['registlinename'];
    $sql = "UPDATE t_plan SET Status = 'Done', ended_DB = NOW() WHERE IRCS_Line = :IRCS_Line AND Status = 'Pending'";
    $stmt = $conn_pcad->prepare($sql);
    $stmt->bindParam(':IRCS_Line', $IRCS_Line);
    if ($stmt->execute()) {
        echo 'true';
    } else {
        echo 'false';
    }
    
}else if ($request == "addTarget") {
    $takt_time = $_POST['takt_time'];
    $registlinename = $_POST['registlinenameplan'];
    $time_start = date('Y-m-d') . ' ' . $_POST['time_start'];

    $sql_check_pending = "SELECT COUNT(*) AS count_pending FROM t_plan WHERE IRCS_Line = :registlinename AND Status = 'Pending'";
    $stmt_check_pending = $conn_pcad->prepare($sql_check_pending);
    $stmt_check_pending->bindParam(':registlinename', $registlinename);
    $stmt_check_pending->execute();
    $count_pending = $stmt_check_pending->fetchColumn();

    if ($count_pending > 0) {
        echo "Cannot add target plan. There is already a pending record for this IRCS Line.";
    } else {
        if (strtotime($_POST['time_start']) < strtotime('07:50:00')) {
            $date_now = date('Y-m-d');
            $new_date_to = new DateTime($date_now);
            $new_date_to->modify("-1 day");
            $to = $new_date_to->format("Y-m-d");
            $date_actual_start = $to . ' ' . $_POST['time_start'];
        } else {
            $date_actual_start = date('Y-m-d') . ' ' . $_POST['time_start'];
        }
        $plan = $_POST['plan'];
        $hrs = str_pad($_POST['hrs'], 2, '0', STR_PAD_LEFT);
        $mins = str_pad($_POST['mins'], 2, '0', STR_PAD_LEFT);
        $secs = str_pad($_POST['secs'], 2, '0', STR_PAD_LEFT);
        if ($hrs == "") {
            $hrs = "00";
        }
        if ($mins == "") {
            $mins = "00";
        }
        if ($secs == "") {
            $secs = "00";
        }
        $sql_get_line = "SELECT * FROM m_ircs_line WHERE ircs_line = :registlinename";
        $stmt_get_line = $conn_pcad->prepare($sql_get_line);
        $stmt_get_line->bindParam(':registlinename', $registlinename);
        $stmt_get_line->execute();
        $line = $stmt_get_line->fetch(PDO::FETCH_ASSOC);
        $line_no = $line['line_no'];
        $IP_address = $line['ip'];
        $car_maker_name = explode('_', $registlinename);
        $car_maker = $car_maker_name[0];
        $takt_secs = TimeToSec($takt_time);
        $status = "Pending";
        $sql_insert_plan = "INSERT INTO t_plan 
        (Carmodel, Line, Target, Status, IRCS_Line, datetime_DB, takt_secs_DB, actual_start_DB, last_update_DB, IP_address) VALUES 
        (:car_maker, :line_no, :plan, :status, :registlinename, NOW(), :takt_secs, :date_actual_start, NOW(), :IP_address)";
        $stmt_insert_plan = $conn_pcad->prepare($sql_insert_plan);
        $stmt_insert_plan->bindParam(':car_maker', $car_maker);
        $stmt_insert_plan->bindParam(':line_no', $line_no);
        $stmt_insert_plan->bindParam(':plan', $plan);
        $stmt_insert_plan->bindParam(':status', $status);
        $stmt_insert_plan->bindParam(':registlinename', $registlinename);
        $stmt_insert_plan->bindParam(':takt_secs', $takt_secs);
        $stmt_insert_plan->bindParam(':date_actual_start', $date_actual_start);
        $stmt_insert_plan->bindParam(':IP_address', $IP_address);

        if ($stmt_insert_plan->execute()) {
            header("location: ../../index.php?registlinename=".$registlinename);
        } else {
            echo "Failed to insert data into t_plan.";
        }
    }
}else if ($request == "getLineNo") {
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
}elseif ($request == "checkRunningPlans") {
    $registlinename = $_POST['registlinename'];
    $sql = "SELECT * FROM t_plan WHERE IRCS_Line = :registlinename AND Status = 'Pending'";
    $stmt = $conn_pcad->prepare($sql);
    $stmt->bindParam(':registlinename', $registlinename);
    $stmt->execute();
    $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($plans) {
        echo 'true';
    } else {
        echo 'false';
    }
}else if($request == "setPaused"){
    $registlinename = $_POST['registlinename'];
    $is_paused = $_POST['is_paused'];
    $sql = "UPDATE t_plan SET is_paused = :is_paused, last_update_DB = NOW() WHERE IRCS_Line = :registlinename AND Status = 'Pending'";
    $stmt = $conn_pcad->prepare($sql);
    $stmt->bindParam(':is_paused', $is_paused);
    $stmt->bindParam(':registlinename', $registlinename);
    if ($stmt->execute()) {
        echo 'true';
    } else {
        echo 'false';
    }
}    

}





