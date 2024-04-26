<?php 
session_name("pcad");
session_start();

require '../conn/pcad.php';
include '../lib/st.php';

$method = $_POST['method'];

// ST Masterlist

function count_st_list($search_arr, $conn_pcad) {
	$query = "SELECT count(id) AS total FROM m_st WHERE";
	if (!empty($search_arr['parts_name'])) {
		$query = $query . " parts_name LIKE '".$search_arr['parts_name']."%'";
	} else {
		$query = $query . " parts_name != ''";
	}
	if (!empty($search_arr['st'])) {
		$query = $query . " AND st LIKE '".$search_arr['st']."%'";
	}

	$stmt = $conn_pcad->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $j){
			$total = $j['total'];
		}
	}else{
		$total = 0;
	}
	return $total;
}

if ($method == 'count_st_list') {
	$parts_name = addslashes($_POST['parts_name']);
	$st = addslashes($_POST['st']);
	
	$search_arr = array(
		"parts_name" => $parts_name,
		"st" => $st
	);

	echo count_st_list($search_arr, $conn_pcad);
}

if ($method == 'st_list_last_page') {
	$parts_name = addslashes($_POST['parts_name']);
	$st = addslashes($_POST['st']);

	$search_arr = array(
		"parts_name" => $parts_name,
		"st" => $st
	);

	$results_per_page = 20;

	$number_of_result = intval(count_st_list($search_arr, $conn_pcad));

	//determine the total number of pages available  
	$number_of_page = ceil($number_of_result / $results_per_page);

	echo $number_of_page;

}

if ($method == 'st_list') {
	$parts_name = addslashes($_POST['parts_name']);
	$st = addslashes($_POST['st']);

	$current_page = intval($_POST['current_page']);
	$c = 0;

	$results_per_page = 20;

	//determine the sql LIMIT starting number for the results on the displaying page
	$page_first_result = ($current_page-1) * $results_per_page;

	$c = $page_first_result;

	$query = "SELECT id, parts_name, sub_assy, final_assy, inspection, st, date_updated FROM m_st WHERE";
	if (!empty($parts_name)) {
		$query = $query . " parts_name LIKE '".$parts_name."%'";
	} else {
		$query = $query . " parts_name != ''";
	}
	if (!empty($st)) {
		$query = $query . " AND st LIKE '$st%'";
	}

	$query = $query . " LIMIT ".$page_first_result.", ".$results_per_page;
	
	$stmt = $conn_pcad->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
			$c++;
			echo '<tr>';
			echo '<td><p class="mb-0"><label class="mb-0"><input type="checkbox" class="singleCheck" value="'.$row['id'].'" onclick="get_checked_length()" /><span></span></label></p></td>';
			echo '<td style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#update_st" onclick="get_st_details(&quot;'.$row['id'].'~!~'.$row['parts_name'].'~!~'.$row['sub_assy'].'~!~'.$row['final_assy'].'~!~'.$row['inspection'].'~!~'.$row['st'].'&quot;)">'.$c.'</td>';
			echo '<td>'.$row['parts_name'].'</td>';
			echo '<td>'.$row['sub_assy'].'</td>';
			echo '<td>'.$row['final_assy'].'</td>';
			echo '<td>'.$row['inspection'].'</td>';
			echo '<td>'.$row['st'].'</td>';
			echo '<td>'.$row['date_updated'].'</td>';
			echo '</tr>';
		}
	}else{
		echo '<tr>';
		echo '<td colspan="8" style="text-align:center; color:red;">No Result !!!</td>';
		echo '</tr>';
	}
}

if ($method == 'get_st_data') {
	$parts_name = $_POST['parts_name'];
	$response_arr = get_st_data($parts_name, $conn_pcad);

	//header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'add_st') {
	$parts_name = addslashes(trim($_POST['parts_name']));
	$sub_assy = addslashes(trim($_POST['sub_assy']));
	$final_assy = addslashes(trim($_POST['final_assy']));
	$inspection = addslashes(trim($_POST['inspection']));
	$st = addslashes(trim($_POST['st']));

	$check = "SELECT id FROM m_st WHERE parts_name = '$parts_name'";
	$stmt = $conn_pcad->prepare($check);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo 'Already Exist';
	}else{
		$stmt = NULL;

		$query = "INSERT INTO m_st (parts_name, sub_assy, final_assy, inspection, st, updated_by_no, updated_by) 
				VALUES ('$parts_name','$sub_assy','$final_assy','$inspection','$st','".$_SESSION['emp_no']."','".$_SESSION['full_name']."')";

		$stmt = $conn_pcad->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		}else{
			echo 'error';
		}
	}
}

if ($method == 'update_st') {
	$id = $_POST['id'];
	$parts_name = addslashes(trim($_POST['parts_name']));
	$sub_assy = addslashes(trim($_POST['sub_assy']));
	$final_assy = addslashes(trim($_POST['final_assy']));
	$inspection = addslashes(trim($_POST['inspection']));
	$st = addslashes(trim($_POST['st']));

	$check = "SELECT id FROM m_st WHERE parts_name = '$parts_name'";
	$stmt = $conn_pcad->prepare($check);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		$query = "UPDATE m_st SET sub_assy = '$sub_assy', final_assy = '$final_assy', 
					inspection = '$inspection', st = '$st',
					updated_by_no = '".$_SESSION['emp_no']."', updated_by = '".$_SESSION['full_name']."' 
					WHERE id = '$id'";

		$stmt = $conn_pcad->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		}else{
			echo 'error';
		}
	}else{
		$query = "UPDATE m_st SET parts_name = '$parts_name', sub_assy = '$sub_assy', 
					final_assy = '$final_assy', inspection = '$inspection', st = '$st',
					updated_by_no = '".$_SESSION['emp_no']."', updated_by = '".$_SESSION['full_name']."' 
					WHERE id = '$id'";

		$stmt = $conn_pcad->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		}else{
			echo 'error';
		}
	}
}

if ($method == 'delete_st') {
	$id = $_POST['id'];

	$query = "DELETE FROM m_st WHERE id = '$id'";
	$stmt = $conn_pcad->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	}else{
		echo 'error';
	}
}

if ($method == 'delete_st_selected') {
	$id_arr = [];
	$id_arr = $_POST['id_arr'];
	$count = 0;

	foreach ($id_arr as $id) {
		$query = "DELETE FROM m_st WHERE id='$id'";
		$stmt = $conn_pcad->prepare($query);
		if (!$stmt->execute()) {
			$count++;
		}
	}

	if ($count == 0) {
		echo 'success';
	} else {
		echo "error";
	}
}

$conn_pcad = NULL;
?>