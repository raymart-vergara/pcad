<?php
include '../server_date_time.php';
require '../conn/pcad.php';
require '../conn/ircs.php';
include '../lib/main.php';

switch (true) {
    case !isset($_GET['registlinename']):
    case !isset($_GET['hourly_output_date']):
    case !isset($_GET['shift']):
    case !isset($_GET['target_output']):
        echo 'Query Parameters Not Set';
        exit;
}

$registlinename = $_GET['registlinename'];
$hourly_output_date = $_GET['hourly_output_date'];
$shift = $_GET['shift'];
$target_output = $_GET['target_output'];

$ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
$final_process = $ircs_line_data_arr['final_process'];
$ipaddresscolumn = $ircs_line_data_arr['ipaddresscolumn'];
$ipAddresses = $ircs_line_data_arr['ipAddresses'];

$hourly_output_date_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($hourly_output_date))));

$date_column = "INSPECTION4FINISHDATETIME";

if ($final_process == 'Assurance') {
    $date_column = "INSPECTION4FINISHDATETIME";
} else {
    $date_column = "INSPECTION3FINISHDATETIME";
}

$ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

$total_target_output = 0;
$total_actual_output = 0;
$total_gap_output = 0;

$c = 0;

$delimiter = ",";

$filename = "PCAD_HourlyOutput_" . $registlinename . "_" . $hourly_output_date . "_" . $shift . ".csv";

// Create a file pointer 
$f = fopen('php://memory', 'w');

// UTF-8 BOM for special character compatibility
fputs($f, "\xEF\xBB\xBF");

// Set column headers 
$fields = array('#', 'Line No.', 'Date', 'Hour', 'Target Output', 'Actual Output', 'Gap');
fputcsv($f, $fields, $delimiter);

$query = "SELECT REGISTLINENAME, DAY, HOUR, COUNT(*) AS TOTAL FROM (
    SELECT TO_CHAR(T_PRODUCTWK.$date_column, 'YYYY-MM-DD HH24') AS DATE_TIME,
    TO_CHAR(T_PRODUCTWK.$date_column, 'YYYY-MM-DD') AS DAY,
    TO_CHAR(T_PRODUCTWK.$date_column, 'HH24') AS HOUR, REGISTLINENAME 
    FROM T_PRODUCTWK
    WHERE REGISTLINENAME = '$registlinename'";

if (!empty($ipAddresses)) {
    $query = $query . " AND $ipaddresscolumn IN ($ipAddressesString)";
}

if ($shift == 'DS') {
    $query = $query . "AND T_PRODUCTWK.$date_column BETWEEN TO_DATE('$hourly_output_date 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$hourly_output_date 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
} else if ($shift == 'NS') {
    $query = $query . "AND T_PRODUCTWK.$date_column BETWEEN TO_DATE('$hourly_output_date 18:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$hourly_output_date_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
} else {
    $query = $query . "AND T_PRODUCTWK.$date_column BETWEEN TO_DATE('$hourly_output_date 06:00:00', 'yyyy-MM-dd HH24:MI:SS') AND TO_DATE('$hourly_output_date_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
}

$query = $query . ") GROUP BY REGISTLINENAME, DAY, HOUR, DATE_TIME ORDER BY DATE_TIME";

$stmt = oci_parse($conn_ircs, $query);
oci_execute($stmt);

// Output each row of the data, format line as csv and write to file pointer 
while ($row = oci_fetch_object($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
    $c++;

    $actual_output = intval($row->TOTAL);
    $gap_output = $target_output - $actual_output;

    $lineData = array($c, $row->REGISTLINENAME, $row->DAY, $row->HOUR, $target_output, $actual_output, $gap_output);
    fputcsv($f, $lineData, $delimiter);

    $total_target_output += $target_output;
    $total_actual_output += $actual_output;
    $total_gap_output += $gap_output;
}

$lineData = array("Total :", "", "", "", $total_target_output, $total_actual_output, $total_gap_output);
fputcsv($f, $lineData, $delimiter);

// Move back to beginning of file 
fseek($f, 0);

// Set headers to download file rather than displayed 
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');

//output all remaining data on a file pointer 
fpassthru($f);

oci_close($conn_ircs);
$conn_pcad = NULL;
?>