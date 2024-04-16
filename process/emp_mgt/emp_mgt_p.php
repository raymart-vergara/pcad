<?php
include '../server_date_time.php';
require '../conn/emp_mgt.php';
require '../conn/pcad.php';
include '../lib/main.php';
include '../lib/emp_mgt.php';

$method = $_GET['method'];

// Employee Management System

if ($method == 'count_emp') {
	$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
	$shift = get_shift($server_time);

	$dept_pd = $_GET['dept_pd'];
	$dept_qa = $_GET['dept_qa'];
	$section_pd = $_GET['section_pd'];
	$section_qa = $_GET['section_qa'];
	$line_no = $_GET['line_no'];

	$shift_group = $_GET['shift_group'];

	$search_arr = array(
		'day' => $day,
		'shift' => $shift,
		'shift_group' => $shift_group,
		'dept' => $dept_pd,
		'section' => $section_pd,
		'line_no' => $line_no
	);

	$total_pd_mp = count_emp($search_arr, $conn_emp_mgt);
	$total_present_pd_mp = count_emp_tio($search_arr, $conn_emp_mgt);

	// For PD shift group ADS
	if ($shift == 'DS') {
		$search_pd_ads_arr = array(
			'day' => $day,
			'shift' => $shift,
			'shift_group' => "ADS",
			'dept' => $dept_pd,
			'section' => $section_pd,
			'line_no' => $line_no
		);

		$total_pd_ads_mp = count_emp($search_pd_ads_arr, $conn_emp_mgt);
		$total_present_pd_ads_mp = count_emp_tio($search_pd_ads_arr, $conn_emp_mgt);
		$total_pd_mp += $total_pd_ads_mp;
		$total_present_pd_mp += $total_present_pd_ads_mp;
	}
	
	$total_pd_mp_line_support_from = count_emp_line_support_from($search_arr, $conn_emp_mgt);
	$total_present_pd_mp -= $total_pd_mp_line_support_from;
	$total_pd_mp_line_support_to = count_emp_line_support_to($search_arr, $conn_emp_mgt);
	$total_absent_pd_mp = $total_pd_mp - $total_present_pd_mp;
	$absent_ratio_pd_mp = compute_absent_ratio($total_absent_pd_mp, $total_pd_mp);

	$search_arr = array(
		'day' => $day,
		'shift' => $shift,
		'shift_group' => $shift_group,
		'dept' => $dept_qa,
		'section' => $section_qa,
		'line_no' => $line_no
	);

	$total_qa_mp = count_emp($search_arr, $conn_emp_mgt);
	$total_present_qa_mp = count_emp_tio($search_arr, $conn_emp_mgt);

	// For QA shift group ADS
	if ($shift == 'DS') {
		$search_qa_ads_arr = array(
			'day' => $day,
			'shift' => $shift,
			'shift_group' => "ADS",
			'dept' => $dept_qa,
			'section' => $section_qa,
			'line_no' => $line_no
		);
	
		$total_qa_ads_mp = count_emp($search_qa_ads_arr, $conn_emp_mgt);
		$total_present_qa_ads_mp = count_emp_tio($search_qa_ads_arr, $conn_emp_mgt);
		$total_qa_mp += $total_qa_ads_mp;
		$total_present_qa_mp += $total_present_qa_ads_mp;
	}

	$total_qa_mp_line_support_from = count_emp_line_support_from($search_arr, $conn_emp_mgt);
	$total_present_qa_mp -= $total_qa_mp_line_support_from;
	$total_qa_mp_line_support_to = count_emp_line_support_to($search_arr, $conn_emp_mgt);
	$total_absent_qa_mp = $total_qa_mp - $total_present_qa_mp;
	$absent_ratio_qa_mp = compute_absent_ratio($total_absent_qa_mp, $total_qa_mp);

	$response_arr = array(
		'total_pd_mp' => $total_pd_mp,
		'total_present_pd_mp' => $total_present_pd_mp,
		'total_absent_pd_mp' => $total_absent_pd_mp,
		'total_pd_mp_line_support_to' => $total_pd_mp_line_support_to,
		'absent_ratio_pd_mp' => $absent_ratio_pd_mp,
		'total_qa_mp' => $total_qa_mp,
		'total_present_qa_mp' => $total_present_qa_mp,
		'total_absent_qa_mp' => $total_absent_qa_mp,
		'total_qa_mp_line_support_to' => $total_qa_mp_line_support_to,
		'absent_ratio_qa_mp' => $absent_ratio_qa_mp,
		'message' => 'success'
	);

	echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'get_process_design') {
	$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);

	$registlinename = $_GET['registlinename'];
	// $registlinename = 'DAIHATSU_30';
	
	$line_no = $_GET['line_no'];
	// $line_no = '2132';
	
	$shift_group = $_GET['shift_group'];
	// $shift_group = 'B';

	$search_arr = array(
		'registlinename' => $registlinename,
		'day' => $day,
		'shift_group' => $shift_group,
		'line_no' => $line_no
	);

	$results = get_process_design($search_arr, $conn_emp_mgt, $conn_pcad);

	// echo '<table><thead><tr><th>Process</th><th>Target</th><th>Actual</th></tr></thead><tbody>';

	foreach ($results as &$result) {

		$total = intval($result['total']);
		$total_present = intval($result['total_present']);
		// $total_absent = $total - $total_present;

		echo '<tr>';
		echo '<td class="process-sub-title">'.$result['process'].'</td>';
		echo '<td class="process-content">'.$result['total'].'</td>';
		echo '<td class="process-content">'.$result['total_present'].'</td>';
		// echo '<td>'.$total_absent.'</td>';

		echo '</tr>';
	}

	// echo '</tbody></table>';

	// echo var_dump($results);
}

$conn_emp_mgt = NULL;
?>