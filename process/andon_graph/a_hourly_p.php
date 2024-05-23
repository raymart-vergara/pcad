<?php
include '../server_date_time.php';
include '../conn/andon_system.php';
include '../lib/emp_mgt.php';

$method = $_GET['method'];

// for andon hourly graph
if ($method == 'andon_hourly') {
    $andon_line = $_GET['andon_line'];
    // $andon_line = 'DAIHATSU D92-2132';

    $data = [];

    $andon_hour_ds_array = array("06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "|");
    $andon_hour_ns_array = array("18", "19", "20", "21", "22", "23", "00", "01", "02", "03", "04", "05");
    $andon_hour_array = array_merge($andon_hour_ds_array, $andon_hour_ns_array);

    $andon_summary_array = array();

    foreach ($andon_hour_array as &$hour_row) {
        $andon_summary_array[$hour_row] = 0;
    }

    $query = "SELECT DATE_FORMAT(requestDateTime, '%H') AS hour_start, 
                 COUNT(*) AS total_count
                 FROM tblhistory
                 WHERE line = '$andon_line' 
                 AND requestDateTime BETWEEN ('$server_date_only 06:00:00') AND ('$server_date_only_tomorrow 05:59:59')
                 GROUP BY hour_start";

    $stmt = $conn_andon->prepare($query);
    $stmt->execute();

    foreach ($stmt->fetchAll() as $row) {
        $andon_summary_array[$row['hour_start']] = intval($row['total_count']);
    }

    $andon_summary_array2 = array();

    foreach ($andon_summary_array as $row) {
        $andon_summary_array2[] = $row;
    }

    $data[] = $andon_summary_array2;
    $data[] = $andon_hour_array;

    echo json_encode($data);
}

$conn_andon = NULL;
?>