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

	switch ($opt) {
		case 1:
			$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
			$day_tomorrow = date('Y-m-d', (strtotime('+1 day', strtotime($day))));
			$shift = get_shift($server_time);
			break;
		case 2:
			$day = $_GET['day'];
			$day_tomorrow = date('Y-m-d', (strtotime('+1 day', strtotime($day))));
			$shift = $_GET['shift'];
			break;
		default:
			$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
			$day_tomorrow = date('Y-m-d', (strtotime('+1 day', strtotime($day))));
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

	switch ($opt) {
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
		echo '<td class="process-sub-title">' . $result['process'] . '</td>';
		echo '<td class="process-content">' . $result['total'] . '</td>';
		echo '<td class="process-content">' . $result['total_present'] . '</td>';
		echo '</tr>';
	}
}

// if ($method == 'get_present_employees') {
// 	$line_no = $_GET['line_no'];
// 	$shift_group = $_GET['shift_group'];

// 	$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
// 	$shift = get_shift($server_time);

// 	$search_arr = array(
// 		'day' => $day,
// 		'shift' => $shift,
// 		'shift_group' => $shift_group,
// 		'line_no' => $line_no
// 	);

// 	$results = get_present_employees($search_arr, $conn_emp_mgt);
// 	// $results = get_present_employees2($search_arr, $conn_emp_mgt);
// 	// echo var_dump($results);

// 	foreach ($results as &$result) {
// 		echo '<tr>';
// 		echo '<td><img src="'.htmlspecialchars($result['file_url']).'" alt="'.htmlspecialchars($result['emp_no']).'" height="50" width="50"></td>';
// 		echo '<td>'.$result['full_name'].'</td>';
// 		echo '<td>'.$result['process'].'</td>';
// 		echo '</tr>';
// 	}
// }

if ($method == 'get_present_employees') {
	$line_no = $_GET['line_no'] ?? '';
	$shift_group = $_GET['shift_group'] ?? '';

	$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
	$shift = get_shift($server_time);

	$search_arr = [
		'day' => $day,
		'shift' => $shift,
		'shift_group' => $shift_group,
		'line_no' => $line_no
	];

	$results = get_present_and_absent_employees($search_arr, $conn_emp_mgt);
	$grouped_results = [];

	foreach ($results as $result) {
		$process = $result['process'] ?? 'Unknown Process';

		if (!isset($grouped_results[$process])) {
			$grouped_results[$process] = [];
		}

		// ✅ Include status (present or absent)
		$grouped_results[$process][] = [
			'file_url' => $result['file_url'] ?? '',
			'emp_no' => $result['emp_no'] ?? '',
			'full_name' => $result['full_name'] ?? '',
			'status' => $result['status'] ?? 'absent' // Default to 'absent' if not found
		];
	}

	header('Content-Type: application/json');
	echo json_encode($grouped_results, JSON_PRETTY_PRINT);

	if (json_last_error() !== JSON_ERROR_NONE) {
		die(json_encode(['error' => 'Invalid JSON generated']));
	}
}

// if ($method == 'get_present_employees') {
// 	$line_no = $_GET['line_no'];
// 	$shift_group = $_GET['shift_group'];

// 	$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
// 	$shift = get_shift($server_time);

// 	$search_arr = array(
// 		'day' => $day,
// 		'shift' => $shift,
// 		'shift_group' => $shift_group,
// 		'line_no' => $line_no
// 	);

// 	// $results = get_present_employees($search_arr, $conn_emp_mgt);

// 	// foreach ($results as &$result) {

// 	// 	//jay: visibility revision
// 	// 	//manually turning names into surname, INITIALS
// 	// 	$exploded_name = explode(" ", $result['full_name']);
// 	// 	$name_initial = $exploded_name[0];
// 	// 	foreach (array_slice($exploded_name, 1) as $value) {
// 	// 		if (strlen($value) == 2) { // skip middle initial
// 	// 			continue;
// 	// 		}
// 	// 		$name_initial .= ' ' . $value[0] . '.';
// 	// 	}
// 	// 	//default card class modified?  created 'card' look with manual style tags
// 	// 	echo '<div class="pt-2 d-flex flex-column justify-content-between grid-item w-100 h-100" style="background:white;border-radius:.35rem;">';
// 	// 	echo '<div><img src="' . htmlspecialchars($result['file_url']) . '" alt="' . htmlspecialchars($result['emp_no']) . '" height="50"></div>';
// 	// 	//echo '<div class="name" style="color:black;font-weight:700;">' . htmlspecialchars($result['full_name']) . '</div>';
// 	// 	//font color black for white background; bigger font size
// 	// 	echo '<div class="name" style="color:black;font-weight:700;font-size:125%;">' . htmlspecialchars($name_initial) . '</div>';
// 	// 	echo '<div class="process" style="color:black;">' . htmlspecialchars($result['process']) . '</div>';
// 	// 	echo '</div>';
// 	// }

// 	$results = get_present_employees($search_arr, $conn_emp_mgt);

// 	// Initialize an empty array to hold the grouped results
// 	$grouped_results = [];

// 	// Loop through the results and group them by process
// 	foreach ($results as $result) {
// 		$process = $result['process'];

// 		// If the process key doesn't exist in the grouped results, initialize it
// 		if (!isset($grouped_results[$process])) {
// 			$grouped_results[$process] = [];
// 		}

// 		// Add the current result to the corresponding process group
// 		$grouped_results[$process][] = [
// 			'file_url' => $result['file_url'],
// 			'emp_no' => $result['emp_no'],
// 			'full_name' => $result['full_name'],
// 		];
// 	}

// 	// Output the JSON
// 	header('Content-Type: application/json');
// 	echo json_encode($grouped_results);
// }

if ($method == 'get_absent_employees') {
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

	$results = get_absent_employees($search_arr, $conn_emp_mgt);

	foreach ($results as &$result) {

		//jay: visibility revision
		//manually turning names into surname, INITIALS
		$exploded_name = explode(" ", $result['full_name']);
		$name_initial = $exploded_name[0];
		foreach (array_slice($exploded_name, 1) as $value) {
			if (strlen($value) == 2) { // skip middle initial
				continue;
			}
			$name_initial .= ' ' . $value[0] . '.';
		}
		//default card class modified?  created 'card' look with manual style tags
		echo '<div class="pt-2 d-flex flex-column justify-content-between grid-item w-100 h-100" style="background:#F25C69;border-radius:.35rem;">';
		echo '<div><img src="' . htmlspecialchars($result['file_url']) . '" alt="' . htmlspecialchars($result['emp_no']) . '" height="50"></div>';
		//echo '<div class="name" style="color:black;font-weight:700;">' . htmlspecialchars($result['full_name']) . '</div>';
		//font color black for white background; bigger font size
		echo '<div class="name" style="color:black;font-weight:700;font-size:125%;">' . htmlspecialchars($name_initial) . '</div>';
		echo '<div class="process" style="color:black;">' . htmlspecialchars($result['process']) . '</div>';
		echo '</div>';
	}

	// $results = get_absent_employees($search_arr, $conn_emp_mgt);

	// // Initialize an empty array to hold the grouped results
	// $grouped_results = [];

	// // Loop through the results and group them by process
	// foreach ($results as $result) {
	// 	$process = $result['process'];

	// 	// If the process key doesn't exist in the grouped results, initialize it
	// 	if (!isset($grouped_results[$process])) {
	// 		$grouped_results[$process] = [];
	// 	}

	// 	// Add the current result to the corresponding process group
	// 	$grouped_results[$process][] = [
	// 		'file_url' => $result['file_url'],
	// 		'emp_no' => $result['emp_no'],
	// 		'full_name' => $result['full_name'],
	// 	];
	// }

	// // Convert the grouped results to JSON format
	// $json_output = json_encode($grouped_results);

	// // Output the JSON
	// header('Content-Type: application/json');
	// echo $json_output;
}

$conn_emp_mgt = NULL;
$conn_pcad = NULL;