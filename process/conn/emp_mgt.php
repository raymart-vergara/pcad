<?php
// Old MySql Connection
$servername = '172.25.116.188'; $username = 'server_113.4'; $password = 'SystemGroup@2022';

// MS SQL Server Connection
// $servername = '172.25.116.188'; $username = 'SA'; $password = 'SystemGroup@2022';

try {
    $conn_emp_mgt = new PDO ("mysql:host=$servername;dbname=emp_mgt_db",$username,$password);
    // $conn_emp_mgt = new PDO ("sqlsrv:Server=$servername;Database=emp_mgt_db",$username,$password);
    $conn_emp_mgt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}
?>