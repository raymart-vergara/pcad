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

if ($request == "addTarget") {
    $registlinename = $_POST['registlinenameplan'];

        $sql_get_line = "SELECT * FROM m_ircs_line WHERE ircs_line = :registlinename";
        $stmt_get_line = $conn_pcad->prepare($sql_get_line);
        $stmt_get_line->bindParam(':registlinename', $registlinename);
        $stmt_get_line->execute();


        if ($stmt_get_line->execute()) {
            header("location: ../../design_tv3.php?registlinename=" . $registlinename);
            // header("location: ../../index.php?registlinename=" . $registlinename);
        } else {
            echo "Failed to insert data into t_plan.";
        }
     }
    elseif ($_POST['request'] == "mainMenu") {
        // Redirect to the main menu without adding target
        header("Location: ../../pcs_page/index.php");
        exit();
    }
}
?>