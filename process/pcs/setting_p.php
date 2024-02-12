<?php
include '../../process/conn/pcad.php';

$method = $_POST['method'];

if ($method == 'fetch_ircs_line') {
    $ircs_lines = array();
    $query = "SELECT * FROM m_ircs_line ORDER BY ircs_line ASC";
    
    $stmt = $conn_pcad->query($query);
    
    $ircs_lines = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($ircs_lines) {
        foreach ($ircs_lines as $i => $ircs) {
            echo '<option value='.$ircs['ircs_line'].'>'.$ircs['ircs_line'].'</option>';
        }
    } else {
        echo '<option> - - - </option>';
    }
}

if ($method == "getLineNo") {
    $registlinename = $_POST['registlinename'];
    $query = "SELECT * FROM m_ircs_line WHERE ircs_line = :registlinename";
    $stmt = $conn_pcad->prepare($query);
    $stmt->bindParam(':registlinename', $registlinename, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $line_no = $result['line_no'];
        echo $line_no;
    } else {
        echo "Line not found";
    }
}

?>
