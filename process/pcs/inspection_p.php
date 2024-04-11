<?php
session_name("pcad");
session_start();

require '../../process/conn/pcad.php';

$method = $_POST['method'];

function count_insp_list($search_arr, $conn_pcad)
{
	$query = "SELECT count(id) AS total FROM m_inspection_ip WHERE 1";
	
	if (!empty($search_arr['ircs_line'])) {
		$query .= " AND ircs_line LIKE '" . $search_arr['ircs_line'] . "%'";
	} elseif (!empty($search_arr['process'])) { 
		$query .= " AND process LIKE '" . $search_arr['process'] . "%'";
	} 

	$stmt = $conn_pcad->prepare($query);
	$stmt->execute();
	
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchAll() as $row) {
			$total = $row['total'];
		}
	} else {
		$total = 0;
	}
	
	return $total;
}

if ($method == 'count_insp_list') {
	$ircs_line = addslashes($_POST['ircs_line']);
	$process = addslashes($_POST['process']);

	$search_arr = array(
		"ircs_line" => $ircs_line,
		"process" => $process
	);

	echo count_insp_list($search_arr, $conn_pcad);
}

if ($method == 'insp_list_last_page') {
	$ircs_line = addslashes($_POST['ircs_line']);
	$process = addslashes($_POST['process']);

	$search_arr = array(
		"ircs_line" => $ircs_line,
		"process" => $process
	);

	$results_per_page = 20;

	$number_of_result = intval(count_insp_list($search_arr, $conn_pcad));

	//determine the total number of pages available  
	$number_of_page = ceil($number_of_result / $results_per_page);

	echo $number_of_page;
}

if ($method == 'inspection_list') {
	$ircs_line = addslashes($_POST['ircs_line']);
	$process = addslashes($_POST['process']);

	$current_page = intval($_POST['current_page']);
	$c = 0;

	$results_per_page = 10;
	// Determine the SQL LIMIT starting number for the results on the displaying page
	$page_first_result = ($current_page - 1) * $results_per_page;
	$c = $page_first_result;

	$query = "SELECT id, ircs_line, process, ip_address, ip_address2, ipaddresscolumn FROM m_inspection_ip WHERE 1"; // Start with a condition that is always true
	if (!empty($ircs_line)) {
		$query .= " AND ircs_line LIKE '" . $ircs_line . "%'";
	} elseif (!empty($process)) { 
		$query .= " AND process LIKE '" . $process . "%'";
	} 

	$query .= " LIMIT " . $page_first_result . ", " . $results_per_page;

	$stmt = $conn_pcad->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchAll() as $row) {
			$c++;
			echo '<tr>';
			echo '<td><p class="mb-0"><label class="mb-0"><input type="checkbox" class="singleCheck" value="' . $row['id'] . '" onclick="get_checked_length()" /><span></span></label></p></td>';
			echo '<td style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#updatepcs" onclick="get_pcs_details(&quot;' . $row['id'] . '~!~' . $row['ircs_line'] . '~!~' . $row['process'] . '~!~' . $row['ip_address'] . '~!~' . $row['ip_address2'] . '~!~' . $row['ipaddresscolumn'] . '&quot;)">' . $c . '</td>';
			echo '<td>' . $row['ircs_line'] . '</td>';
			echo '<td>' . $row['process'] . '</td>';
			echo '<td>' . $row['ip_address'] . '</td>';
			echo '<td>' . $row['ip_address2'] . '</td>';
			echo '<td>' . $row['ipaddresscolumn'] . '</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="5" style="text-align:center; color:red;">No Result</td>';
		echo '</tr>';
	}
}

if ($method == 'add_insp') {
    
}


?>