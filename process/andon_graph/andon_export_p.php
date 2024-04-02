<?php
include '../server_date_time.php';
include '../conn/andon_system.php';
include '../lib/emp_mgt.php';

// $andon_line = $_POST['andon_line'];
$andon_line = 'DAIHATSU D92-2132';
$shift = get_shift($server_time);

$delimiter = ",";
$filename = 'Andon_Details.csv';
// Create a file pointer 
$f = fopen('php://memory', 'w');
// Add UTF-8 BOM (For Any characters compatibility)
fputs($f, "\xEF\xBB\xBF");
// Set column headers 
$fields = array('Category', 'Line', 'Machine', 'Machine No.', 'Process', 'Problem', 'Production Acct.', 'Call Date Time', 'Waiting Time (mins.)', 'Start Time', 'End Time', 'Fixing Time Duration (mins.)', 'Technician', 'Department', 'Solution', 'Serial Number', 'Jig Name', 'Circuit Location', 'Lot Number', 'Product Number', 'Fixing Status', 'Backup Request Time', 'Backup Comment', 'Backup Technician', 'Backup Confirmation Date Time');
fputcsv($f, $fields, $delimiter);

$query = "SELECT  category, line, machineName, machineNo, process, problem, operatorName, requestDateTime, waitingTime, startDateTime, endDateTime, fixInterval, technicianName, department, counter_measure, serial_num, jigName, circuit_location, lotNumber, productNumber, fixRemarks, backupRequestTime, backupComment,  backupTechnicianName, backupRequestTime FROM tblhistory 
    where line = '$andon_line' ";

if ($shift == 'DS') {
    $query = $query . "AND requestDateTime BETWEEN ('$server_date_only 06:00:00') 
                        AND ('$server_date_only 17:59:59') GROUP By department,machinename";
} else if ($shift == 'NS') {
    if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
        $query = $query . "AND requestDateTime BETWEEN ('$server_date_only 18:00:00') 
                            AND ('$server_date_only_tomorrow 05:59:59') GROUP By department,machinename";
    } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
        $query = $query . "AND requestDateTime BETWEEN ('$server_date_only_yesterday 18:00:00') 
                            AND ('$server_date_only 05:59:59') GROUP By department,machinename";
    }
}

$stmt = $conn_andon->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchALL() as $row) {
        $lineData = array(
            $row['category'],
            $row['line'],
            $row['machineName'],
            $row['machineNo'],
            $row['process'],
            $row['problem'],
            $row['operatorName'],
            $row['requestDateTime'],
            $row['waitingTime'],
            $row['startDateTime'],
            $row['endDateTime'],
            $row['fixInterval'],
            $row['technicianName'],
            $row['department'],
            $row['counter_measure'],
            $row['serial_num'],
            $row['jigName'],
            $row['circuit_location'],
            $row['lotNumber'],
            $row['productNumber'],
            $row['fixRemarks'],
            $row['backupRequestTime'],
            $row['backupComment'],
            $row['backupTechnicianName'],
            $row['backupRequestTime'],
        );
        fputcsv($f, $lineData, $delimiter);
    }
} else {

    // Output each row of the data, format line as csv and write to file pointer 
    $lineData = array("NO DATA FOUND");
    fputcsv($f, $lineData, $delimiter);
}
// Move back to beginning of file 
fseek($f, 0);
// Set headers to download file rather than displayed 
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
//output all remaining data on a file pointer 
fpassthru($f);

$conn = null;

?>