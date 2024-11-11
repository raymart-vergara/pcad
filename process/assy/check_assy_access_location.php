<?php
// NOTE: This php file was included on specific assy page

require '../process/conn/pcad.php';

$ip = $_SERVER['REMOTE_ADDR'];
$line_no = "";

$query = "SELECT line_no FROM m_assy_access_locations 
            WHERE ip = ?";
$stmt = $conn_pcad->prepare($query);
$params = array($ip);
$stmt->execute($params);

$row = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($row) {
    $line_no = $row['line_no'];
} else {
    header('location:/pcad/assy_page/index_viewer.php');
    exit();
}