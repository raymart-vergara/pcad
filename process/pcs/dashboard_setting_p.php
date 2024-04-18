<?php
include '../conn/pcad.php';
if (isset($_POST['request'])) {
    $request = $_POST['request'];
    if ($request == "getLineNo") {
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

    if ($request == "getPlanLine") {
        $shift = get_shift($server_time);

        $IRCS_Line = $_POST['registlinename'];

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
    } 
}
?>