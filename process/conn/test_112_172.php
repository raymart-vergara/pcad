<?php
$servername = '172.25.112.172'; $username = 'server_112.172'; $password = 'SystemGroup@2024';

try {
    $conn_emp_mgt = new PDO ("mysql:host=$servername;dbname=live_hris",$username,$password);
    $conn_emp_mgt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}
