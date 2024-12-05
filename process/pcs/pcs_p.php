<?php
session_name("pcad");
session_start();

require '../../process/conn/pcad.php';

$method = $_POST['method'];

// PCS Masterlist

function count_pcs_list($search_arr, $conn_pcad)
{
	// MySQL
	// $query = "SELECT count(id) AS total FROM m_ircs_line WHERE 1";
	// MS SQL Server
	$query = "SELECT count(id) AS total FROM m_ircs_line WHERE 1=1";

	if (!empty($search_arr['line_no'])) {
		$query .= " AND line_no LIKE '" . $search_arr['line_no'] . "%'";
	} elseif (!empty($search_arr['ircs_line'])) {
		$query .= " AND ircs_line LIKE '" . $search_arr['ircs_line'] . "%'";
	} elseif (!empty($search_arr['andon_line'])) {
		$query .= " AND andon_line LIKE '" . $search_arr['andon_line'] . "%'";
	} elseif (!empty($search_arr['ip_address'])) {
		$query .= " AND ip LIKE '" . $search_arr['ip_address'] . "%'";
	}

	$stmt = $conn_pcad->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
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


if ($method == 'count_pcs_list') {
	$line_no = addslashes($_POST['line_no']);
	$ircs_line = addslashes($_POST['ircs_line']);
	$andon_line = addslashes($_POST['andon_line']);
	$ip_address = addslashes($_POST['ip_address']);

	$search_arr = array(
		"line_no" => $line_no,
		"ircs_line" => $ircs_line,
		"andon_line" => $andon_line,
		"ip_address" => $ip_address
	);

	echo count_pcs_list($search_arr, $conn_pcad);
}

if ($method == 'pcs_list_last_page') {
	$line_no = addslashes($_POST['line_no']);
	$ircs_line = addslashes($_POST['ircs_line']);
	$andon_line = addslashes($_POST['andon_line']);
	$ip_address = addslashes($_POST['ip_address']);

	$search_arr = array(
		"line_no" => $line_no,
		"ircs_line" => $ircs_line,
		"andon_line" => $andon_line,
		"ip_address" => $ip_address
	);

	$results_per_page = 20;

	$number_of_result = intval(count_pcs_list($search_arr, $conn_pcad));

	//determine the total number of pages available  
	$number_of_page = ceil($number_of_result / $results_per_page);

	echo $number_of_page;

}

if ($method == 'pcs_list') {
	$line_no = addslashes($_POST['line_no']);
	$ircs_line = addslashes($_POST['ircs_line']);
	$andon_line = addslashes($_POST['andon_line']);
	$ip_address = addslashes($_POST['ip_address']);

	$current_page = intval($_POST['current_page']);
	$c = 0;

	$results_per_page = 20;
	//determine the sql LIMIT starting number for the results on the displaying page
	$page_first_result = ($current_page - 1) * $results_per_page;
	$c = $page_first_result;

	$query = "SELECT id, car_maker, car_model, line_no, ircs_line, andon_line, final_process, ip FROM m_ircs_line WHERE";
	if (!empty($line_no)) {
		$query = $query . " line_no LIKE '" . $line_no . "%'";
	} else {
		$query = $query . " line_no != ''";
	}
	if (!empty($ircs_line)) {
		$query = $query . " AND ircs_line LIKE '$ircs_line%'";
	}
	if (!empty($andon_line)) {
		$query = $query . " AND andon_line LIKE '$andon_line%'";
	}
	if (!empty($ip_address)) {
		$query = $query . " AND ip LIKE '$ip_address%'";
	}

	// MySQL
	// $query = $query . " LIMIT " . $page_first_result . ", " . $results_per_page;
	// MS SQL Server
	$query .= " ORDER BY ircs_line ASC";
	$query .= " OFFSET " . $page_first_result . " ROWS FETCH NEXT " . $results_per_page . " ROWS ONLY";

	$stmt = $conn_pcad->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $j) {
			$c++;
			echo '<tr>';
			echo '<td><p class="mb-0"><label class="mb-0"><input type="checkbox" class="singleCheck" value="' . $j['id'] . '" onclick="get_checked_length()" /><span></span></label></p></td>';
			echo '<td style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#updatepcs" onclick="get_pcs_details(&quot;' . $j['id'] . '~!~' . $j['car_maker'] . '~!~' . $j['car_model'] . '~!~' . $j['line_no'] . '~!~' . $j['ircs_line'] . '~!~' . $j['andon_line'] . '~!~' . $j['final_process'] . '~!~' . $j['ip'] . '&quot;)">' . $c . '</td>';
			echo '<td>' . $j['car_maker'] . '</td>';
			echo '<td>' . $j['car_model'] . '</td>';
			echo '<td>' . $j['line_no'] . '</td>';
			echo '<td>' . $j['ircs_line'] . '</td>';
			echo '<td>' . $j['andon_line'] . '</td>';
			echo '<td>' . $j['final_process'] . '</td>';
			echo '<td>' . $j['ip'] . '</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="6" style="text-align:center; color:red;">No Result !!!</td>';
		echo '</tr>';
	}
}

if ($method == 'add_pcs') {
	$car_maker = addslashes($_POST['car_maker']);
	$car_model = addslashes($_POST['car_model']);
	$line_no = addslashes($_POST['line_no']);
	$ircs_line = addslashes($_POST['ircs_line']);
	$andon_line = addslashes($_POST['andon_line']);
	$final_process = addslashes($_POST['final_process']);
	$ip = addslashes($_POST['ip']);

	$query = "INSERT INTO m_ircs_line (car_maker,car_model,line_no, ircs_line, andon_line, final_process, ip) VALUES ('$car_maker','$car_model','$line_no','$ircs_line','$andon_line','$final_process','$ip')";

	$stmt = $conn_pcad->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	} else {
		echo 'error';
	}
}

if ($method == 'update_pcs') {
	$id = $_POST['id'];
	$car_maker = addslashes(trim($_POST['car_maker']));
	$car_model = addslashes(trim($_POST['car_model']));
	$line_no = addslashes(trim($_POST['line_no']));
	$ircs_line = addslashes($_POST['ircs_line']);
	$andon_line = addslashes($_POST['andon_line']);
	$final_process = addslashes($_POST['final_process']);
	$ip = addslashes($_POST['ip']);

	$query = "UPDATE m_ircs_line SET car_maker = '$car_maker', car_model = '$car_model',  line_no = '$line_no', ircs_line = '$ircs_line', andon_line = '$andon_line', final_process = '$final_process', ip = '$ip' WHERE id = '$id'";

	$stmt = $conn_pcad->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	} else {
		echo 'error';
	}
}

if ($method == 'delete_pcs') {
	$id = $_POST['id'];

	$query = "DELETE FROM m_ircs_line WHERE id = '$id'";
	$stmt = $conn_pcad->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	} else {
		echo 'error';
	}
}

if ($method == 'delete_pcs_selected') {
	$id_arr = [];
	$id_arr = $_POST['id_arr'];
	$count = 0;

	foreach ($id_arr as $id) {
		$query = "DELETE FROM m_ircs_line WHERE id='$id'";
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

if ($method == 'final_process') {
	$final_process = array();
	$query = "SELECT DISTINCT finishdatetime FROM m_final_process";

	$stmt = $conn_pcad->query($query);

	$final_process = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if ($final_process) {
		foreach ($final_process as $i => $ircs) {
			echo '<option value="' . $ircs['finishdatetime'] . '">' . $ircs['finishdatetime'] . '</option>';
		}
	} else {
		echo '<option> - - - </option>';
	}
}

// if ($method == 'final_process') {
// 	$ip_address_col = array();
// 	$query = "SELECT ipaddresscolumn FROM m_final_process";

// 	$stmt = $conn_pcad->query($query);

// 	$ip_address_col = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 	if ($ip_address_col) {
// 		echo '<option value="">Select IP address column</option>';
// 		foreach ($ip_address_col as $i => $ircs) {
// 			echo '<option value="' . $ircs['ipaddresscolumn'] . '">' . $ircs['ipaddresscolumn'] . '</option>';
// 		}
// 	} else {
// 		echo '<option> - - - - </option>';
// 	}
// }

$conn_pcad = NULL;
