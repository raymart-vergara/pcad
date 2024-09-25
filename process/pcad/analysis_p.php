<?php
include 'process/conn/pcad.php';

$method = isset($_POST['method']);

if ($method == 'analysis_list') {
    $c = 0;

    $query = "SELECT problem, recommendation, date_added, dri, department, prepared_by, reviewed_by FROM t_analysis";
    $stmt = $conn_pcad->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchALL() as $row) {
            $c++;
            echo '<tr style="cursor:pointer;">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['problem'] . '</td>';
            echo '<td>' . $row['recommendation'] . '</td>';
            echo '<td>' . $row['date_added'] . '</td>';
            echo '<td>' . $row['dri'] . '</td>';
            echo '<td>' . $row['department'] . '</td>';
            echo '<td>' . $row['prepared_by'] . '</td>';
            echo '<td>' . $row['reviewed_by'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="6" style="text-align:center; color:red;">No Record Found</td>';
        echo '</tr>';
    }
}


$conn_pcad = NULL;
?>