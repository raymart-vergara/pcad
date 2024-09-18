<?php

include '../server_date_time.php';
require '../conn/pcad.php';
require '../conn/ircs.php';
require '../conn/emp_mgt.php';
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
    $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
	// $line_no = '2132';
    // $day = $_GET['day'];
	// $shift = $_GET['shift'];
	$line_no = $_GET['line_no'];
    
    // Total ST Per Line Declaration
    // $registlinename = 'DAIHATSU_30';
    // $shift_group = 'A';
    $registlinename = $_GET['registlinename'];
    $shift_group = $_GET['shift_group'];

    $plan_data_arr = get_plan_data($registlinename, $line_no, $day, $shift, $conn_pcad, 1);
    
    // $ircs_line_data_arr = get_ircs_line_data($registlinename, $line_no, $conn_pcad);

    // $search_arr = array(
    //     'day' => $day,
    //     'day_tomorrow' => $day_tomorrow,
	// 	'shift' => $shift,
    //     'shift_group' => $shift_group,
    //     'dept' => "",
    //     'section' => "",
	// 	'line_no' => $line_no,
    //     'registlinename' => $registlinename,
	// 	'ircs_line_data_arr' => $ircs_line_data_arr,
    //     'server_date_only' => $server_date_only,
    //     'server_date_only_yesterday' => $server_date_only_yesterday,
    //     'server_date_only_tomorrow' => $server_date_only_tomorrow,
    //     'server_time' => $server_time
    // );

    // $wt_x_mp_arr = get_wt_x_mp_arr($search_arr, $server_time, $conn_emp_mgt);
    // $wt_x_mp = $wt_x_mp_arr['wt_x_mp'];
    // $total_st_per_line = get_total_st_per_line($search_arr, $conn_ircs, $conn_pcad);
    // $accounting_efficiency = compute_accounting_efficiency($total_st_per_line, $wt_x_mp);

    // echo var_dump($search_arr);
    // echo var_dump($wt_x_mp_arr);

    // $response_arr = array(
    //     'total_st_per_line' => $total_st_per_line,
	// 	'wt_x_mp' => $wt_x_mp,
    //     'accounting_efficiency' => $accounting_efficiency
    // );

    // echo var_dump($response_arr);

    // echo $accounting_efficiency;

    echo $plan_data_arr['acc_eff_actual'];
}

// Yield
// http://172.25.112.131/pcad/process/pcad/pcad_p.php?method=get_yield
if ($method == 'get_yield') {
    $registlinename = $_GET['registlinename'];
    $line_no = $_GET['line_no'];
    $shift_group = $_GET['shift_group'];

    $opt = $_GET['opt'];

    $day = '';
    $day_tomorrow = '';
    $shift = '';

    switch($opt) {
		case 1:
			$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
            $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
            $shift = get_shift($server_time);
			break;
		case 2:
			$day = $_GET['day'];
            $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
            $shift = $_GET['shift'];
			break;
		default:
            $day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
            $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
            $shift = get_shift($server_time);
			break;
	}

    $plan_data_arr = get_plan_data($registlinename, $line_no, $day, $shift, $conn_pcad, $opt);

    // $ircs_line_data_arr = get_ircs_line_data($registlinename, $line_no, $conn_pcad);

    // $search_arr = array(
    //     'day' => $day,
    //     'day_tomorrow' => $day_tomorrow,
	// 	'shift' => $shift,
    //     'shift_group' => $shift_group,
    //     'registlinename' => $registlinename,
    //     'line_no' => $line_no,
    //     'ircs_line_data_arr' => $ircs_line_data_arr,
    //     'server_date_only' => $server_date_only,
    //     'server_date_only_yesterday' => $server_date_only_yesterday,
    //     'server_date_only_tomorrow' => $server_date_only_tomorrow,
    //     'server_time' => $server_time,
    //     'opt' => $opt
    // );

    // $qa_output = count_overall_g($search_arr, $conn_ircs);
    // $input_ng = count_overall_ng($search_arr, $conn_ircs, $conn_pcad);
    // $yield = compute_yield($qa_output, $input_ng);

    // echo $yield;

    echo $plan_data_arr['yield_actual'];
}

// PPM
// http://172.25.112.131/pcad/process/pcad/pcad_p.php?method=get_ppm
if ($method == 'get_ppm') {
    $registlinename = $_GET['registlinename'];
    $line_no = $_GET['line_no'];
    $shift_group = $_GET['shift_group'];

    $opt = $_GET['opt'];

    $day = '';
    $day_tomorrow = '';
    $shift = '';

    switch($opt) {
		case 1:
			$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
            $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
            $shift = get_shift($server_time);
			break;
		case 2:
			$day = $_GET['day'];
            $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
            $shift = $_GET['shift'];
			break;
		default:
            $day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
            $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
            $shift = get_shift($server_time);
			break;
	}

    $plan_data_arr = get_plan_data($registlinename, $line_no, $day, $shift, $conn_pcad, $opt);

    // $ircs_line_data_arr = get_ircs_line_data($registlinename, $line_no, $conn_pcad);

    // $search_arr = array(
    //     'day' => $day,
    //     'day_tomorrow' => $day_tomorrow,
	// 	'shift' => $shift,
    //     'shift_group' => $shift_group,
    //     'registlinename' => $registlinename,
    //     'line_no' => $line_no,
	// 	'ircs_line_data_arr' => $ircs_line_data_arr,
    //     'server_date_only' => $server_date_only,
    //     'server_date_only_yesterday' => $server_date_only_yesterday,
    //     'server_date_only_tomorrow' => $server_date_only_tomorrow,
    //     'server_time' => $server_time,
    //     'opt' => $opt
    // );

    // $output = count_overall_g($search_arr, $conn_ircs);
    // $ng = count_overall_ng($search_arr, $conn_ircs, $conn_pcad);
    // $ppm = compute_ppm($ng, $output);

    // $response_arr = array(
    //     'ppm_formatted' => number_format($ppm),
    //     'ppm' => $ppm
    // );

    $response_arr = array(
        'ppm_formatted' => $plan_data_arr['ppm_actual_formatted'],
        'ppm' => $plan_data_arr['ppm_actual']
    );

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

// Hourly Output
// http://172.25.112.131/pcad/process/pcad/pcad_p.php?method=get_hourly_output
if ($method == 'get_hourly_output') {
    $registlinename = $_GET['registlinename'];
    $line_no = $_GET['line_no'];
    $shift_group = $_GET['shift_group'];

    $opt = $_GET['opt'];

    $day = '';
    $day_tomorrow = '';
    $shift = '';

    switch($opt) {
		case 1:
			$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
            $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
            $shift = get_shift($server_time);
			break;
		case 2:
			$day = $_GET['day'];
            $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
            $shift = $_GET['shift'];
			break;
		default:
            $day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
            $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
            $shift = get_shift($server_time);
			break;
	}

    $ircs_line_data_arr = get_ircs_line_data($registlinename, $line_no, $conn_pcad);

    $search_arr = array(
        'day' => $day,
        'day_tomorrow' => $day_tomorrow,
		'shift' => $shift,
        'shift_group' => $shift_group,
        'registlinename' => $registlinename,
        'ircs_line_data_arr' => $ircs_line_data_arr,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time,
        'opt' => $opt
    );

    $takt = intval($_GET['takt']);
    $working_time = intval($_GET['working_time']);

    $target_hourly_output = compute_target_hourly_output($takt, $working_time);
    $actual_hourly_output = count_actual_hourly_output($search_arr, $conn_ircs, $conn_pcad);
    $gap_hourly_output = $actual_hourly_output - $target_hourly_output;

    $response_arr = array(
		'target_hourly_output' => $target_hourly_output,
		'actual_hourly_output' => $actual_hourly_output,
        'gap_hourly_output' => $gap_hourly_output,
		'message' => 'success'
	);

	echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

// Conveyor Speed (Unused)

if ($method == 'get_conveyor_speed') {
    $taktime = 27000;
    // $taktime = $_GET['taktime'];

    $conveyor_speed = compute_conveyor_speed($taktime);
    echo $conveyor_speed;
}

// Dashboard Data (index_exec.php) Get All t_plan Data Pending

if ($method == 'get_plan_data') {
    $registlinename = $_GET['registlinename'];
    $line_no = $_GET['line_no'];

    $opt = $_GET['opt'];

    $day = '';
    $shift = '';

    switch($opt) {
		case 1:
			$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
            $shift = get_shift($server_time);
			break;
		case 2:
			$day = $_GET['day'];
            $shift = $_GET['shift'];
			break;
		default:
            $day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
            $shift = get_shift($server_time);
			break;
	}

    $shift_arr = array(
        "shift" => $shift
    );
    $plan_data_arr = get_plan_data($registlinename, $line_no, $day, $shift, $conn_pcad, $opt);
    $ircs_line_data_arr = get_ircs_line_data($registlinename, $line_no, $conn_pcad);

    $response_arr = array_merge($shift_arr, $plan_data_arr, $ircs_line_data_arr);

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

oci_close($conn_ircs);
$conn_emp_mgt = NULL;
$conn_pcad = NULL;
?>