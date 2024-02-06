<?php
include '../conn/andon_system.php';
$method = $_POST['method'];

if ($method == 'a_down_time') {
    $query = "SELECT department, machinename,
   SUM(Minute(TIMEDIFF(requestDateTime,startDateTime))) as Waiting_Time,
   SUM(Minute(TIMEDIFF(startDateTime,endDateTime))) as Fixing_Time,
   SUM(Minute(TIMEDIFF(requestDateTime,startDateTime))) + SUM(Minute(TIMEDIFF(startDateTime,endDateTime))) as Total_DT
   FROM `tblhistory` 
   where line = 'SUZUKI-5111' and requestDateTime BETWEEN '2024-01-30 18:00:14' and '2024-02-01 06:00:00'
   GROUP By department,machinename";

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