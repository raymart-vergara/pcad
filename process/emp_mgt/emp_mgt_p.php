<?php
include '../server_date_time.php';
require '../conn/emp_mgt.php';
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
	// $shift_group = 'A';

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

$conn = NULL;
?>