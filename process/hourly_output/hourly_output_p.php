<?php
include '../server_date_time.php';
require '../conn/pcad.php';
require '../conn/ircs.php';
include '../lib/emp_mgt.php';
include '../lib/main.php';
include '../lib/inspection_output.php';

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
        $query = $query . "AND T_PRODUCTWK.$date_column BETWEEN TO_DATE('$hourly_output_date 06:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                            AND TO_DATE('$hourly_output_date 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
    } else if ($shift == 'NS') {
        $query = $query . "AND T_PRODUCTWK.$date_column BETWEEN TO_DATE('$hourly_output_date 18:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                            AND TO_DATE('$hourly_output_date_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
    } else {
        $query = $query . "AND T_PRODUCTWK.$date_column BETWEEN TO_DATE('$hourly_output_date 06:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                            AND TO_DATE('$hourly_output_date_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
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


function get_cell_color($process, $target_output, $actual_output) {
    $row_class_arr = array('bg-success', 'bg-warning', 'bg-danger');
    $row_class = "";

    if ($process != 'Hour') {
        $gap_output = $target_output - $actual_output;

        if ($gap_output < 1) {
            $row_class = $row_class_arr[0];
        } else if ($gap_output > 0 && $actual_output < $target_output) {
            if ($actual_output < 1) {
                $row_class = $row_class_arr[2];
            } else {
                $row_class = $row_class_arr[1];
            }
        }
    }

    return $row_class;
}


// http://172.25.112.131/pcad/process/hourly_output/hourly_output_p.php?method=get_hourly_output_per_process
if ($method == 'get_hourly_output_per_process') {
    $registlinename = $_GET['registlinename'];
    $hourly_output_date = $_GET['hourly_output_date'];
    $target_output = intval($_GET['target_output']);

    // $registlinename = 'DAIHATSU_30';
    // $target_output = 13;

    $hourly_output_hour_ds_array = array('06'=>"06",'07'=>"07",'08'=>"08",'09'=>"09",'10'=>"10",'11'=>"11",'12'=>"12",'13'=>"13",'14'=>"14",'15'=>"15",'16'=>"16",'17'=>"17");
    $hourly_output_hour_ns_array = array('18'=>"18",'19'=>"19",'20'=>"20",'21'=>"21",'22'=>"22",'23'=>"23",'00'=>"00",'01'=>"01",'02'=>"02",'03'=>"03",'04'=>"04",'05'=>"05");
    $hourly_output_hour_array = $hourly_output_hour_ds_array + $hourly_output_hour_ns_array;

    $insp_overall_g = array();

    // Fetch processes and their corresponding IP addresses
    $processesAndIpAddresses = getIpAddressesFromDatabase($registlinename, $conn_pcad);

    if (!empty($processesAndIpAddresses)) {
        foreach ($processesAndIpAddresses as $processData) {
            $process = $processData['process'];
            $ipaddresscolumn = $processData['ipaddresscolumn'];
            $ipAddresses = $processData['ipAddresses'];

            $hourly_output_summary_process_array = array();

            $date_column = "";

            $search_arr = array(
                'registlinename' => $registlinename,
                'server_date_only' => $hourly_output_date,
                'server_date_only_yesterday' => $server_date_only_yesterday,
                'server_date_only_tomorrow' => $server_date_only_tomorrow,
                'server_time' => $server_time
            );

            switch ($process) {
                case "Dimension":
                    $date_column = "INSPECTION1FINISHDATETIME";
                    break;
                case "Electric":
                    $date_column = "INSPECTION2FINISHDATETIME";
                    break;
                case "Visual":
                    $date_column = "INSPECTION3FINISHDATETIME";
                    break;
                case "Assurance":
                    $date_column = "INSPECTION4FINISHDATETIME";
                    break;
                default:
                    break;
            }

            $processDetailsGood = array(
                'date_column' => $date_column,
                'ipAddressColumn' => $ipaddresscolumn,
                'ipAddresses' => $ipAddresses
            );

            $p_good = count_actual_hourly_output_process($search_arr, $conn_ircs, $conn_pcad, $processDetailsGood);

            $hourly_output_summary_process_array["process"] = $process;

            foreach ($hourly_output_hour_array as &$hour_row) {
                $hourly_output_summary_process_array[$hour_row] = 0;
            }

            foreach ($p_good as $row) {
                $hourly_output_summary_process_array[$row["HOUR"]] = $row["TOTAL"];
            }

            $insp_overall_g[] = $hourly_output_summary_process_array;
        }

        $hour_label_array = array("process" => "Hour");
        // $overall_hour_label_array = array_merge($hour_label_array, $hourly_output_hour_array);
        $overall_hour_label_array = $hour_label_array + $hourly_output_hour_array;

        $insp_overall_g[] = $overall_hour_label_array;
    }

    // echo '<table><tbody>';

    foreach ($insp_overall_g as &$row) {
        $table_cell_type = "";
        if ($row['process'] == 'Hour') {
            $table_cell_type = "th";
        } else {
            $table_cell_type = "td";
        }
        echo '<tr>';
        echo '<th>' . $row['process'] . '</th>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['06'])).'">' . $row['06'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['07'])).'">' . $row['07'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['08'])).'">' . $row['08'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['09'])).'">' . $row['09'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['10'])).'">' . $row['10'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['11'])).'">' . $row['11'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['12'])).'">' . $row['12'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['13'])).'">' . $row['13'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['14'])).'">' . $row['14'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['15'])).'">' . $row['15'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['16'])).'">' . $row['16'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['17'])).'">' . $row['17'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['18'])).'">' . $row['18'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['19'])).'">' . $row['19'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['20'])).'">' . $row['20'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['21'])).'">' . $row['21'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['22'])).'">' . $row['22'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['23'])).'">' . $row['23'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['00'])).'">' . $row['00'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['01'])).'">' . $row['01'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['02'])).'">' . $row['02'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['03'])).'">' . $row['03'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['04'])).'">' . $row['04'] . '</'.$table_cell_type.'>';
        echo '<'.$table_cell_type.' class="'.get_cell_color($row['process'], $target_output, intval($row['05'])).'">' . $row['05'] . '</'.$table_cell_type.'>';
        echo '</tr>';
    }

    // echo '</tbody></table>';

    // echo json_encode($hourly_output_hour_array, JSON_FORCE_OBJECT);
    // echo json_encode($insp_overall_g, JSON_FORCE_OBJECT);
}

// http://172.25.112.131/pcad/process/hourly_output/hourly_output_p.php?method=get_hourly_output_graph
if ($method == 'get_hourly_output_graph') {
    $registlinename = $_GET['registlinename'];
    $hourly_output_date = $_GET['hourly_output_date'];

    // $registlinename = 'DAIHATSU_30';

    $data = [];

    // $hourly_output_hour_ds_array = array("06","07","08","09","10","11","12","13","14","15","16","17");
    // $hourly_output_hour_ns_array = array("18","19","20","21","22","23","00","01","02","03","04","05");
    // $hourly_output_hour_array = array_merge($hourly_output_hour_ds_array, $hourly_output_hour_ns_array);

    $hourly_output_hour_array = array();

    $hourly_output_summary_array = array();

    // foreach ($hourly_output_hour_array as &$hour_row) {
    //     $hourly_output_summary_array[] = 0;
    // }

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

    // $hourly_output_date = $server_date_only;
    $hourly_output_date_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($hourly_output_date))));

    $c = 0;

    $query = "SELECT DAY, HOUR, COUNT(*) AS TOTAL FROM (
                SELECT TO_CHAR(T_PRODUCTWK.$date_column, 'YYYY-MM-DD HH24') AS DATE_TIME,
                TO_CHAR(T_PRODUCTWK.$date_column, 'YYYY-MM-DD') AS DAY,
                TO_CHAR(T_PRODUCTWK.$date_column, 'HH24') AS HOUR, REGISTLINENAME 
                FROM T_PRODUCTWK
                WHERE REGISTLINENAME = '$registlinename'";

    if (!empty($ipAddresses)) {
        $query = $query . " AND $ipaddresscolumn IN ($ipAddressesString)";
    }
    
    $query = $query . "AND T_PRODUCTWK.$date_column BETWEEN TO_DATE('$hourly_output_date 06:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                            AND TO_DATE('$hourly_output_date_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";

    $query = $query . ") GROUP BY REGISTLINENAME, DAY, HOUR, DATE_TIME ORDER BY DATE_TIME";

    $stmt = oci_parse($conn_ircs, $query);
	oci_execute($stmt);

	while ($row = oci_fetch_assoc($stmt)) {
        $hourly_output_summary_array[] = intval($row['TOTAL']);
        $hourly_output_hour_array[] = $row['HOUR'];
    }

    $data[] = $hourly_output_summary_array;
    $data[] = $hourly_output_hour_array;

    echo json_encode($data);
}

oci_close($conn_ircs);
$conn_pcad = NULL;
?>