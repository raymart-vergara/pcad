<?php 
include '../server_date_time.php';
require '../conn/ircs.php';
require '../conn/emp_mgt.php';
require '../conn/pcad.php';
include '../lib/emp_mgt.php';
include '../lib/inspection_output.php';
include '../lib/main.php';

switch (true) {
  case !isset($_GET['registlinename']):
  case !isset($_GET['day']):
  case !isset($_GET['shift']):
    echo 'Query Parameters Not Set';
    exit;
}

$registlinename = trim($_GET['registlinename']);

$day = $_GET['day'];
$shift = $_GET['shift'];

$day_yesterday = date('Y-m-d',(strtotime('-1 day',strtotime($day))));
$day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));

// Plan Data (Yield, PPM, Accounting Efficiency, Production Plan)

$plan_data_done_arr = get_plan_data($registlinename, $day, $shift, $conn_pcad, 2);
$ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);

// Employee Management System Data

$dept_pd = 'PD2';
$dept_qa = 'QA';
$section_pd = get_section($plan_data_done_arr['line_no'], $conn_emp_mgt);
$section_qa = get_section($plan_data_done_arr['line_no'], $conn_emp_mgt);
// $section_qa = 'QA';

$search_arr = array(
  'day' => $day,
  'day_tomorrow' => $day_tomorrow,
  'shift' => $shift,
  'shift_group' => $plan_data_done_arr['shift_group'],
  'dept_pd' => $dept_pd,
	'dept_qa' => $dept_qa,
	'section_pd' => $section_pd,
	'section_qa' => $section_qa,
  'line_no' => $plan_data_done_arr['line_no'],
  'registlinename' => $registlinename,
  'ircs_line_data_arr' => $ircs_line_data_arr,
  'server_date_only' => $day,
  'server_date_only_yesterday' => $day_yesterday,
  'server_date_only_tomorrow' => $day_tomorrow,
  'server_time' => $plan_data_done_arr['plan_datetime'],
  'opt' => 2
);

// Hourly Output

$takt = intval($plan_data_done_arr['takt']);
$working_time = intval($plan_data_done_arr['work_time_plan']);

$target_hourly_output = compute_target_hourly_output($takt, $working_time);
$actual_hourly_output = count_actual_hourly_output($search_arr, $conn_ircs, $conn_pcad);
$gap_hourly_output = $actual_hourly_output - $target_hourly_output;

// Overall Inspection

$insp_overall_g = count_overall_g($search_arr, $conn_ircs);
$insp_overall_ng = count_overall_ng($search_arr, $conn_ircs, $conn_pcad);

$overall_inspection_list_arr = get_overall_inspection_list($search_arr, $conn_ircs, $conn_pcad);

// Manpower Count (Plan, Actual, Absent, Support, Absent Rate)

$manpower_count_arr = get_manpower_count_per_line($search_arr, $conn_emp_mgt);

// Process Design

$process_design_results = get_process_design($search_arr, $conn_emp_mgt, $conn_pcad);


// Export CSV

$delimiter = ",";

$filename = "PCAD_ExecPlanDataDone_" . $plan_data_done_arr['line_no'] . "_" . $day . "_" . $shift . ".csv";
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 

// UTF-8 BOM for special character compatibility
fputs($f, "\xEF\xBB\xBF");


// Header for Line Information
$fields = array('Car Maker / Car Model', 'Line No.', 'Shift', 'Date'); 
fputcsv($f, $fields, $delimiter); 

// Line Information
$lineData = array($plan_data_done_arr['carmodel'], $plan_data_done_arr['line_no'], $shift, $day); 
fputcsv($f, $lineData, $delimiter); 

$fields = array(''); 
fputcsv($f, $fields, $delimiter);


// Header for Production Plan, Accounting Efficiency, Hourly Output
$fields = array('Plan', '', '', '','Accounting Efficiency','','','','Hourly Output'); 
fputcsv($f, $fields, $delimiter); 

$fields = array('Target', 'Actual', 'Gap', '','Target','Actual','Gap','','Target','Actual','Gap'); 
fputcsv($f, $fields, $delimiter);

// Production Plan, Accounting Efficiency, Hourly Output
$fields = array($plan_data_done_arr['plan_target'], $plan_data_done_arr['plan_actual'], $plan_data_done_arr['plan_gap'], '', 
          $plan_data_done_arr['acc_eff'], $plan_data_done_arr['acc_eff_actual'], $plan_data_done_arr['acc_eff_gap'], '', 
          $target_hourly_output, $actual_hourly_output, $gap_hourly_output); 
fputcsv($f, $fields, $delimiter);

$fields = array(''); 
fputcsv($f, $fields, $delimiter);


// Header for Yield, PPM, Overall Inspection
$fields = array('Yield', '','', 'PPM', '','','Overall Inspection'); 
fputcsv($f, $fields, $delimiter); 

$fields = array('Target', 'Actual', '', 'Target','Actual','','Good','NG'); 
fputcsv($f, $fields, $delimiter);

// Yield, PPM, Overall Inspection
$fields = array($plan_data_done_arr['yield_target'], $plan_data_done_arr['yield_actual'], '', 
          $plan_data_done_arr['ppm_target'], $plan_data_done_arr['ppm_actual'], '', 
          $insp_overall_g, $insp_overall_ng); 
fputcsv($f, $fields, $delimiter);

$fields = array(''); 
fputcsv($f, $fields, $delimiter);


// Header for Overall Inspection List
$fields = array('Good', 'Inspection', 'NG'); 
fputcsv($f, $fields, $delimiter);

// Yield, PPM, Overall Inspection
if (empty($overall_inspection_list_arr)) {
  $fields = array(''); 
  fputcsv($f, $fields, $delimiter);
} else {
  foreach ($overall_inspection_list_arr as $inspection_list) {
    $fields = array($inspection_list['p_good'], $inspection_list['process'], $inspection_list['p_ng']); 
    fputcsv($f, $fields, $delimiter);
  }
}

$fields = array(''); 
fputcsv($f, $fields, $delimiter);


// Header for Manpower Count, Other Details
$fields = array('PD Manpower', '','', 'QA Manpower', '', '', 'Other Details'); 
fputcsv($f, $fields, $delimiter); 

// Manpower Count, Other Details
$fields = array('Plan', $manpower_count_arr['total_pd_mp'], '', 'Plan', $manpower_count_arr['total_qa_mp'], '', 'Starting Balance Delay', $plan_data_done_arr['start_bal_delay']); 
fputcsv($f, $fields, $delimiter);

$fields = array('Actual', $manpower_count_arr['total_present_pd_mp'], '', 'Actual', $manpower_count_arr['total_present_qa_mp'], '', 'Conveyor Speed', ''); 
fputcsv($f, $fields, $delimiter);

$fields = array('Absent', $manpower_count_arr['total_absent_pd_mp'], '', 'Absent', $manpower_count_arr['total_absent_qa_mp'], '', 'Working Time Plan', $plan_data_done_arr['work_time_plan']); 
fputcsv($f, $fields, $delimiter);

$fields = array('Support', $manpower_count_arr['total_pd_mp_line_support_to'], '', 'Support', $manpower_count_arr['total_qa_mp_line_support_to'], '', 'Daily Plan', $plan_data_done_arr['daily_plan']); 
fputcsv($f, $fields, $delimiter);

$fields = array('Absent Rate', $manpower_count_arr['absent_ratio_pd_mp'], '', 'Absent Rate', $manpower_count_arr['absent_ratio_qa_mp']); 
fputcsv($f, $fields, $delimiter);

$fields = array(''); 
fputcsv($f, $fields, $delimiter);


// Header for Process Design
$fields = array('Process Design', '', 'Actual'); 
fputcsv($f, $fields, $delimiter);

// Process Design
foreach ($process_design_results as $process_design_result) {
  $fields = array($process_design_result['process'], $process_design_result['total'], $process_design_result['total_present']); 
  fputcsv($f, $fields, $delimiter);
}

$fields = array(''); 
fputcsv($f, $fields, $delimiter);


// Move back to beginning of file 
fseek($f, 0); 
 
// Set headers to download file rather than displayed 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
 
//output all remaining data on a file pointer 
fpassthru($f); 

oci_close($conn_ircs);
$conn_emp_mgt = null;
$conn_pcad = null;
?>