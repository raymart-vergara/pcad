<?php
$servername = '172.25.113.8'; $username = 'server_113.8'; $password = 'SystemGroup@2024';

try {
    $conn_emp_mgt = new PDO ("mysql:host=$servername;dbname=live_fg_picking",$username,$password);
    $conn_emp_mgt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}
