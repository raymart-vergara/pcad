<?php

include '../server_date_time.php';
require '../conn/pcad.php';
require '../conn/ircs.php';
require '../conn/emp_mgt.php';
require '../lib/ircs.php';
include '../lib/inspection_output.php';
include '../lib/st.php';
include '../lib/emp_mgt.php';
include '../lib/main.php';

$method = $_GET['method'];

// PCAD

// Accounting Efficiency
// http://172.25.112.131/pcad/process/pcad/pcad_p.php?method=get_accounting_efficiency
if ($method == 'get_accounting_efficiency') {
    // Working Time X Manpower Declaration
    // $day = '2024-02-02';
	$shift = get_shift($server_time);
    $day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
	// $line_no = '2132';
    // $day = $_GET['day'];
	// $shift = $_GET['shift'];
	$line_no = $_GET['line_no'];
    
    // Total ST Per Line Declaration
    // $registlinename = 'DAIHATSU_30';
    // $shift_group = 'A';
    $registlinename = $_GET['registlinename'];
    $shift_group = $_GET['shift_group'];
    $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
    $final_process = $ircs_line_data_arr['final_process'];
    $ip = $ircs_line_data_arr['ip'];

    $search_arr = array(
        'day' => $day,
		'shift' => $shift,
        'shift_group' => $shift_group,
        'dept' => "",
        'section' => "",
		'line_no' => $line_no,
        'registlinename' => $registlinename,
		'final_process' => $final_process,
    	'ip' => $ip,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time
    );

    $wt_x_mp_arr = get_wt_x_mp_arr($search_arr, $server_time, $conn_emp_mgt);
    $wt_x_mp = $wt_x_mp_arr['wt_x_mp'];
    $total_st_per_line = get_total_st_per_line($search_arr, $conn_ircs, $conn_pcad);
    $accounting_efficiency = compute_accounting_efficiency($total_st_per_line, $wt_x_mp);

    // echo var_dump($search_arr);
    // echo var_dump($wt_x_mp_arr);

    // $response_arr = array(
    //     'total_st_per_line' => $total_st_per_line,
	// 	'wt_x_mp' => $wt_x_mp,
    //     'accounting_efficiency' => $accounting_efficiency
    // );

    // echo var_dump($response_arr);

    echo $accounting_efficiency;
}

// Yield
// http://172.25.112.131/pcad/process/pcad/pcad_p.php?method=get_yield
if ($method == 'get_yield') {
    $shift = get_shift($server_time);
    $registlinename = $_GET['registlinename'];
    $shift_group = $_GET['shift_group'];
    $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
    $final_process = $ircs_line_data_arr['final_process'];
    $ip = $ircs_line_data_arr['ip'];

    $search_arr = array(
		'shift' => $shift,
        'shift_group' => $shift_group,
        'registlinename' => $registlinename,
		'final_process' => $final_process,
    	'ip' => $ip,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time
    );

    $qa_output = count_output($search_arr, $conn_ircs);
    $input_ng = count_overall_ng($search_arr, $conn_ircs, $conn_pcad);
    $yield = compute_yield($qa_output, $input_ng);

    echo $yield;
}

// PPM
// http://172.25.112.131/pcad/process/pcad/pcad_p.php?method=get_ppm
if ($method == 'get_ppm') {
    $shift = get_shift($server_time);
    $registlinename = $_GET['registlinename'];
    $shift_group = $_GET['shift_group'];
    $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
    $final_process = $ircs_line_data_arr['final_process'];
    $ip = $ircs_line_data_arr['ip'];

    $search_arr = array(
		'shift' => $shift,
        'shift_group' => $shift_group,
        'registlinename' => $registlinename,
		'final_process' => $final_process,
    	'ip' => $ip,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time
    );

    $output = count_output($search_arr, $conn_ircs);
    $ng = count_overall_ng($search_arr, $conn_ircs, $conn_pcad);
    $ppm = compute_ppm($ng, $output);

    echo number_format($ppm);
}

// Hourly Output
// http://172.25.112.131/pcad/process/pcad/pcad_p.php?method=get_hourly_output
if ($method == 'get_hourly_output') {
    $shift = get_shift($server_time);
    $registlinename = $_GET['registlinename'];
    $shift_group = $_GET['shift_group'];

    $search_arr = array(
		'shift' => $shift,
        'shift_group' => $shift_group,
        'registlinename' => $registlinename,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time
    );

    $takt = intval($_GET['takt']);
    
    if ($takt != 0) {
        $plan = 27000 / $takt;
    } else {
        $plan = 0;
    }

    $working_time = intval($_GET['working_time']);
    $working_time_hr = $working_time / 60;

    $target_hourly_output = compute_hourly_output($plan, $working_time_hr);
    $actual_hourly_output = count_actual_hourly_output($search_arr, $conn_ircs, $conn_pcad);
    $gap_hourly_output = $target_hourly_output - $actual_hourly_output;

    $response_arr = array(
		'target_hourly_output' => $target_hourly_output,
		'actual_hourly_output' => $actual_hourly_output,
        'gap_hourly_output' => $gap_hourly_output,
		'message' => 'success'
	);

	echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

// Conveyor Speed

if ($method == 'get_conveyor_speed') {
    $taktime = 27000;
    // $taktime = $_GET['taktime'];

    $conveyor_speed = compute_conveyor_speed($taktime);
    echo $conveyor_speed;
}

oci_close($conn_ircs);
$conn_emp_mgt = NULL;
$conn_pcad = NULL;
?>