<?php
$servername = '172.25.116.188'; $username = 'server_113.4'; $password = 'SystemGroup@2022';

try {
    $conn_repair_record = new PDO ("mysql:host=$servername;dbname=repair_record_system",$username,$password);
    $conn_repair_record->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}
