<?php
include '../server_date_time.php';
require '../conn/emp_mgt.php';
require '../conn/pcad.php';
include '../lib/main.php';
include '../lib/emp_mgt.php';

$method = $_GET['method'];

// Employee Management System

if ($method == 'count_emp') {
	$dept_pd = $_GET['dept_pd'];
	$dept_qa = $_GET['dept_qa'];
	$section_pd = $_GET['section_pd'];
	$section_qa = $_GET['section_qa'];
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

	$search_arr = array(
		'day' => $day,
		'day_tomorrow' => $day_tomorrow,
		'shift' => $shift,
		'shift_group' => $shift_group,
		'dept_pd' => $dept_pd,
		'dept_qa' => $dept_qa,
		'section_pd' => $section_pd,
		'section_qa' => $section_qa,
		'line_no' => $line_no,
		'opt' => $opt
	);

	$response_arr = get_manpower_count_per_line($search_arr, $conn_emp_mgt);

	echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'get_process_design') {
	$registlinename = $_GET['registlinename'];
	$line_no = $_GET['line_no'];
	$shift_group = $_GET['shift_group'];
	
	$opt = $_GET['opt'];

	$day = '';

    switch($opt) {
		case 1:
			$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
			break;
		case 2:
			$day = $_GET['day'];
			break;
		default:
            $day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
			break;
	}

	$search_arr = array(
		'registlinename' => $registlinename,
		'day' => $day,
		'shift_group' => $shift_group,
		'line_no' => $line_no
	);

	$results = get_process_design($search_arr, $conn_emp_mgt, $conn_pcad);

	foreach ($results as &$result) {

		$total = intval($result['total']);
		$total_present = intval($result['total_present']);

		echo '<tr>';
		echo '<td class="process-sub-title">'.$result['process'].'</td>';
		echo '<td class="process-content">'.$result['total'].'</td>';
		echo '<td class="process-content">'.$result['total_present'].'</td>';
		echo '</tr>';
	}
}

if ($method == 'get_present_employees') {
	$line_no = $_GET['line_no'];
	$shift_group = $_GET['shift_group'];

	$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
	$shift = get_shift($server_time);

	$search_arr = array(
		'day' => $day,
		'shift' => $shift,
		'shift_group' => $shift_group,
		'line_no' => $line_no
	);

	$results = get_present_employees($search_arr, $conn_emp_mgt);
	// $results = get_present_employees2($search_arr, $conn_emp_mgt);
	// echo var_dump($results);

	foreach ($results as &$result) {
		echo '<tr>';
		echo '<td><img src="'.htmlspecialchars($result['file_url']).'" alt="'.htmlspecialchars($result['emp_no']).'" height="50" width="50"></td>';
		// echo '<td>'.$result['emp_no'].'</td>';
		echo '<td>'.$result['full_name'].'</td>';
		// echo '<td>'.$result['provider'].'</td>';
		// echo '<td>'.$result['dept'].'</td>';
		echo '<td>'.$result['process'].'</td>';
		echo '</tr>';
	}
}

$conn_emp_mgt = NULL;
$conn_pcad = NULL;
