<?php
date_default_timezone_set('Asia/Manila');

$server_date_time = date('Y-m-d H:i:s');
$server_date_only = date('Y-m-d');
$server_date_only_yesterday = date('Y-m-d',(strtotime('-1 day',strtotime($server_date_only))));
$server_time = date('H:i:s');
$server_time_a = date('h:i:s A');
?>