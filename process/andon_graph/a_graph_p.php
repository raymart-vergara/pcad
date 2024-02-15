<?php
include '../conn/andon_system.php';
include '../server_date_time.php';
$method = $_POST['method'];

function get_shift($server_time)
{
    if ($server_time >= '06:00:00' && $server_time < '18:00:00') {
        return 'DS';
    } else if ($server_time >= '18:00:00' && $server_time <= '23:59:59') {
        return 'NS';
    } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
        return 'NS';
    }
}

if ($method == 'a_down_time') {
    $andon_line = $_POST['andon_line'];
    $shift = get_shift($server_time);
    $query = "SELECT department, machinename,
   SUM(Minute(TIMEDIFF(requestDateTime,startDateTime))) as Waiting_Time,
   SUM(Minute(TIMEDIFF(startDateTime,endDateTime))) as Fixing_Time,
   SUM(Minute(TIMEDIFF(requestDateTime,startDateTime))) + SUM(Minute(TIMEDIFF(startDateTime,endDateTime))) as Total_DT
   FROM `tblhistory` 
   where line = '$andon_line' ";
    if ($shift == 'DS') {
        $query = $query . "AND requestDateTime BETWEEN ('$server_date_only 06:00:00') AND ('$server_date_only_tomorrow 17:59:59') GROUP By department,machinename";
    } else if ($shift == 'NS') {
        if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
            $query = $query . "AND requestDateTime BETWEEN ('$server_date_only 18:00:00') AND ('$server_date_only_tomorrow 05:59:59') GROUP By department,machinename";
        } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
            $query = $query . "AND requestDateTime BETWEEN ('$server_date_only_yesterday 18:00:00') AND ('$server_date_only 05:59:59') GROUP By department,machinename";
        }
    }
    $stmt = $conn_andon->prepare($query);
    $stmt->execute();
    $data = [];
    foreach ($stmt->fetchALL(PDO::FETCH_ASSOC) as $row) {
        $data[] = $row;
    }
    // Fetch data from the second table (table2)
    echo json_encode($data);

}
?>