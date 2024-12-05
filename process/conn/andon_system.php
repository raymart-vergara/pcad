<?php
$servername = '172.25.114.167'; $username = 'server_114.167'; $password = 'SystemGroup@2024';

try {
    $conn_andon = new PDO ("mysql:host=$servername;dbname=andon_web",$username,$password);
    $conn_andon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}
