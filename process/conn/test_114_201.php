<?php
$servername = '172.25.114.201'; $username = 'server_114.201'; $password = 'SystemGroup@2024';

try {
    $conn_emp_mgt = new PDO ("mysql:host=$servername;dbname=cpms_db",$username,$password);
    $conn_emp_mgt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}
?>