<?php
$servername = '172.25.114.165'; $username = 'server_114.165'; $password = 'SystemGroup@2024';
//$servername = '172.25.114.165'; $username = 'root'; $password = '#Sy$temGr0^p|114164';
//$servername = '172.25.114.165'; $username = 'jb'; $password = 'Jbjalla@25';

try {
    $conn_pcs = new PDO ("mysql:host=$servername;dbname=pcs_db",$username,$password);
    $conn_pcs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection Success";
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}
