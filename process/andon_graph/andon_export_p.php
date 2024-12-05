<?php
include '../server_date_time.php';
include '../conn/andon_system.php';
include '../lib/emp_mgt.php';

$andon_line = $_GET['andon_line'];
$shift = $_GET['shift'];

$opt = $_GET['opt'];

$andon_hourly_date = $_GET['server_date_only'];
$andon_hourly_date_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($andon_hourly_date))));

$start_date = '';
$end_date = '';
$start_time_ds = ' 06:00:00';
$end_time_ds = ' 17:59:59';
$start_time_ns = ' 18:00:00';
$end_time_ns = ' 05:59:59';

if ($opt == 2) {
    if ($shift == 'DS') {
        $start_date = $andon_hourly_date . $start_time_ds;
        $end_date = $andon_hourly_date . $end_time_ds;
    } else if ($shift == 'NS') {
        $start_date = $andon_hourly_date . $start_time_ns;
        $end_date = $andon_hourly_date_tomorrow . $end_time_ns;
    }
} else if ($shift == 'DS') {
    $start_date = $server_date_only . $start_time_ds;
    $end_date = $server_date_only . $end_time_ds;
} else if ($shift == 'NS') {
    if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
        $start_date = $server_date_only . $start_time_ns;
        $end_date = $server_date_only_tomorrow . $end_time_ns;
    } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
        $start_date = $server_date_only_yesterday . $start_time_ns;
        $end_date = $server_date_only . $end_time_ns;
    }
}

$c = 0;

$delimiter = ",";

$filename = 'PCAD_AndonDetails_';
if (!empty($andon_line)) {
	$filename = $filename . $andon_line . "_";
}
$filename = $filename . $andon_hourly_date."-".$shift.".csv";

// Create a file pointer 
$f = fopen('php://memory', 'w');
// Add UTF-8 BOM (For Any characters compatibility)
fputs($f, "\xEF\xBB\xBF");
// Set column headers 
$fields = array('#', 'Category', 'Line', 'Machine', 'Machine No.', 'Process', 'Problem', 'Production Acct.', 'Call Date Time', 'Waiting Time (mins.)', 'Start Time', 'End Time', 'Fixing Time Duration (mins.)', 'Technician', 'Department', 'Solution', 'Serial Number', 'Jig Name', 'Circuit Location', 'Lot Number', 'Product Number', 'Fixing Status', 'Backup Request Time', 'Backup Comment', 'Backup Technician', 'Backup Confirmation Date Time');
fputcsv($f, $fields, $delimiter);

$query = "SELECT category, line, machineName, machineNo, process, problem, operatorName, 
                requestDateTime, waitingTime, startDateTime, endDateTime, fixInterval, 
                technicianName, department, counter_measure, serial_num, jigName, circuit_location, lotNumber, productNumber, 
                fixRemarks, backupRequestTime, backupComment, backupTechnicianName, backupRequestTime 
                FROM tblhistory 
                WHERE line = '$andon_line' 
                AND requestDateTime BETWEEN ('$start_date') AND ('$end_date')";

$stmt = $conn_andon->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchALL() as $row) {
        $c++;

        $lineData = array(
            $c,
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

$conn_andon = null;
