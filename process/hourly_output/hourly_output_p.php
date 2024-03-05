<?php
include '../server_date_time.php';
require '../conn/pcad.php';
require '../conn/ircs.php';
include '../lib/main.php';

$method = $_GET['method'];

if ($method == 'get_hourly_output') {
    $registlinename = $_GET['registlinename'];
    $hourly_output_date = $_GET['hourly_output_date'];
    $shift = $_GET['shift'];
    $target_output = intval($_GET['target_output']);

    $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
    $final_process = $ircs_line_data_arr['final_process'];
    $ipaddresscolumn = $ircs_line_data_arr['ipaddresscolumn'];
    $ipAddresses = $ircs_line_data_arr['ipAddresses'];

    $date_column = "INSPECTION4FINISHDATETIME";

    if ($final_process == 'Assurance') {
        $date_column = "INSPECTION4FINISHDATETIME";
    } else {
        $date_column = "INSPECTION3FINISHDATETIME";
    }

    $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

    $hourly_output_date_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($hourly_output_date))));

    $total_target_output = 0;
    $total_actual_output = 0;
    $total_gap_output = 0;

    $c = 0;
    $row_class_arr = array('modal-trigger', 'modal-trigger bg-success', 'modal-trigger bg-warning', 'modal-trigger bg-danger');
	$row_class = $row_class_arr[0];

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
	while ($row = oci_fetch_object($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $c++;

        $actual_output = intval($row->TOTAL);
        $gap_output = $target_output - $actual_output;

        if ($gap_output < 1) {
            $row_class = $row_class_arr[1];
        } else if ($gap_output > 0 && $actual_output < $target_output) {
            $row_class = $row_class_arr[2];
        } else if ($actual_output < 1) {
            $row_class = $row_class_arr[3];
        }

        echo '<tr class="'.$row_class.'">';
        echo '<td>' . $c . '</td>';
        echo '<td>' . $row->REGISTLINENAME . '</td>';
        echo '<td>' . $row->DAY . '</td>';
        echo '<td>' . $row->HOUR . '</td>';
        echo '<td>' . $target_output . '</td>';
        echo '<td>' . $actual_output . '</td>';
        echo '<td>' . $gap_output . '</td>';
        echo '</tr>';

        $total_target_output += $target_output;
        $total_actual_output += $actual_output;
        $total_gap_output += $gap_output;
    }

    if ($total_gap_output < 1 && $total_target_output > 0) {
        $row_class = $row_class_arr[1];
    } else if ($total_gap_output > 0 && $total_actual_output < $total_target_output) {
        $row_class = $row_class_arr[2];
    } else if ($total_actual_output < 1) {
        $row_class = $row_class_arr[3];
    }

    echo '<tr class="'.$row_class.'">';
    echo '<th>Total :</th>';
    echo '<th></th>';
    echo '<th></th>';
    echo '<th></th>';
    echo '<th>' . $total_target_output . '</th>';
    echo '<th>' . $total_actual_output . '</th>';
    echo '<th>' . $total_gap_output . '</th>';
    echo '</tr>';
}

oci_close($conn_ircs);
$conn_pcad = NULL;
?>