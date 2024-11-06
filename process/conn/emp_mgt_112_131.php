<?php
$servername = '172.25.112.131'; $username = 'vince'; $password = 'SystemGroup@2024';

try {
    $conn_emp_mgt = new PDO ("mysql:host=$servername;dbname=emp_mgt_db",$username,$password);
    $conn_emp_mgt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}
