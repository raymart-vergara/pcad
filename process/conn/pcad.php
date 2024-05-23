<?php
$servername = '172.25.116.188'; $username = 'server_113.4'; $password = 'SystemGroup@2022';
// $servername = '172.25.112.131'; $username = 'vince'; $password = 'SystemGroup@2024';
try {
    $conn_pcad = new PDO ("mysql:host=$servername;dbname=pcad_db",$username,$password);
    $conn_pcad->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connection Success";
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}
?>