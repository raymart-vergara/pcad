<?php
include '../conn/pcad.php';


if (isset($_POST['request'])) {
    $request = $_POST['request'];
    if ($request == "addTarget") {
        $registlinename = $_POST['registlinenameplan'];
        $group = $_POST['group'];
      
        $sql_get_line = "SELECT * FROM t_plan WHERE ircs_line = '$registlinename' AND group = '$group'";
        $stmt_get_line = $conn_pcad->prepare($sql_get_line);
            if ($stmt_get_line->execute()) {
                header("location: ../../index_IV.php?registlinename=" . $registlinename);
            } else {
                echo "Failed to insert data into t_plan.";
            }
         }elseif ($request == "getLineNo") {
        $registlinename = $_POST['registlinename'];
        $q = "SELECT * FROM m_ircs_line WHERE ircs_line = '$registlinename' ";
        $stmt = $conn_pcad->prepare($q);
        $stmt->execute();
        $line = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($line) {
            echo $line['line_no'];
        } else {
            echo "Line not found";
        }
    }
}
?>