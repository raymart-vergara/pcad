<?php

// Employee Management System Functions (EmpMgtSys)
// Must Require Database Config "../conn/emp_mgt.php" before using this functions

function get_shift($server_time)
{
	if ($server_time >= '06:00:00' && $server_time < '18:00:00') {
		return 'DS';
	} else if ($server_time >= '18:00:00' && $server_time <= '23:59:59') {
		return 'NS';
	} else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
		return 'NS';
	}
}

function get_day($server_time, $server_date_only, $server_date_only_yesterday)
{
	if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
		return $server_date_only;
	} else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
		return $server_date_only_yesterday;
	}
}

function get_section($line_no, $conn_emp_mgt)
{
	$line_no = addslashes($line_no);
	$section = "";
	// MySQL
	// $query = "SELECT section FROM m_access_locations WHERE line_no = '$line_no' LIMIT 1";
	// MS SQL Server
	$query = "SELECT TOP 1 section FROM m_access_locations WHERE line_no = '$line_no'";
	$stmt = $conn_emp_mgt->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $row) {
			$section = $row['section'];
		}
	}
	return $section;
}

// Total Employee Count (Resigned Not Included, Unregistered Employee Included)
function count_emp($search_arr, $conn_emp_mgt)
{
	$dept = addslashes($search_arr['dept']);
	$section = addslashes($search_arr['section']);
	$line_no = addslashes($search_arr['line_no']);
	$shift_group = addslashes($search_arr['shift_group']);
	$query = "SELECT count(id) AS total FROM m_employees WHERE resigned = 0";

	if (!empty($search_arr['dept'])) {
		$query = $query . " AND dept = '$dept'";
	}

	if (!empty($search_arr['section'])) {
		$query = $query . " AND section LIKE '$section%'";
	}

	if (!empty($search_arr['line_no'])) {
		$query = $query . " AND line_no LIKE '$line_no%'";
	}
	$query = $query . " AND shift_group = '$shift_group'";

	$stmt = $conn_emp_mgt->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $row) {
			$total = intval($row['total']);
		}
	} else {
		$total = 0;
	}
	return $total;
}

// Total Present Employee Count (Resigned Not Included, Unregistered Employee Included)
function count_emp_tio($search_arr, $conn_emp_mgt)
{
	$day = addslashes($search_arr['day']);
	$shift_group = addslashes($search_arr['shift_group']);
	$dept = addslashes($search_arr['dept']);
	$section = addslashes($search_arr['section']);
	$line_no = addslashes($search_arr['line_no']);
	$sql = "SELECT count(emp.emp_no) AS total FROM m_employees emp
			LEFT JOIN t_time_in_out tio ON tio.emp_no = emp.emp_no
			WHERE emp.resigned = 0 AND tio.day = '$day' AND emp.shift_group = '$shift_group'";

	if (!empty($search_arr['dept'])) {
		$sql = $sql . " AND emp.dept = '$dept'";
	}

	if (!empty($search_arr['section'])) {
		$sql = $sql . " AND emp.section = '$section'";
	}

	if (!empty($search_arr['line_no'])) {
		$sql = $sql . " AND emp.line_no = '$line_no'";
	}

	$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $row) {
			$total = intval($row['total']);
		}
	} else {
		$total = 0;
	}
	return $total;
}

// Total Employee Line Support Count (Resigned Not Included, Unregistered Employee Included)
function count_emp_line_support_to($search_arr, $conn_emp_mgt)
{
	$dept = addslashes($search_arr['dept']);
	$day = addslashes($search_arr['day']);
	$shift = addslashes($search_arr['shift']);
	$line_no = addslashes($search_arr['line_no']);

	$query = "SELECT count(lsh.emp_no) AS total 
		FROM t_line_support_history lsh
		LEFT JOIN m_employees emp ON emp.emp_no = lsh.emp_no
		WHERE lsh.day = '$day' AND lsh.shift = '$shift' AND lsh.line_no_to LIKE '$line_no%' AND lsh.status = 'accepted'";

	if (!empty($search_arr['dept'])) {
		$query = $query . " AND emp.dept = '$dept'";
	} else {
		$query = $query . " AND emp.dept != ''";
	}

	// $query = "SELECT count(emp.id) AS total FROM m_employees emp
	// 		LEFT JOIN t_line_support_history ls
	// 		ON emp.emp_no = ls.emp_no";

	// $query = $query . " WHERE ls.day = '$day' AND ls.shift = '$shift'";

	// if (!empty($search_arr['line_no'])) {
	// 	$query = $query . " AND ls.line_no_to LIKE '$line_no%'";
	// } else {
	// 	$query = $query . " AND ls.line_no_to IS NULL OR ls.line_no_to = ''";
	// }

	// $query = $query . " AND ls.status = 'accepted'";

	// if (!empty($search_arr['dept'])) {
	// 	$query = $query . " AND emp.dept = '$dept'";
	// }

	$stmt = $conn_emp_mgt->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $row) {
			$total = intval($row['total']);
		}
	} else {
		$total = 0;
	}
	return $total;
}

// Total Employee Line Support Count (Resigned Not Included, Unregistered Employee Included)
function count_emp_line_support_from($search_arr, $conn_emp_mgt)
{
	$dept = addslashes($search_arr['dept']);
	$day = addslashes($search_arr['day']);
	$shift = addslashes($search_arr['shift']);
	$line_no = addslashes($search_arr['line_no']);

	$query = "SELECT count(lsh.emp_no) AS total 
		FROM t_line_support_history lsh
		LEFT JOIN m_employees emp ON emp.emp_no = lsh.emp_no
		WHERE lsh.day = '$day' AND lsh.shift = '$shift' AND lsh.line_no_from LIKE '$line_no%' AND lsh.status = 'accepted'";

	if (!empty($search_arr['dept'])) {
		$query = $query . " AND emp.dept = '" . $dept . "'";
	} else {
		$query = $query . " AND emp.dept != ''";
	}

	// $query = "SELECT count(emp.id) AS total FROM m_employees emp
	// 		LEFT JOIN t_line_support_history ls
	// 		ON emp.emp_no = ls.emp_no";

	// $query = $query . " WHERE ls.day = '$day' AND ls.shift = '$shift'";

	// if (!empty($search_arr['line_no'])) {
	// 	$query = $query . " AND ls.line_no_from LIKE '$line_no%'";
	// } else {
	// 	$query = $query . " AND ls.line_no_from IS NULL OR ls.line_no_from = ''";
	// }

	// $query = $query . " AND ls.status = 'accepted'";

	// if (!empty($search_arr['dept'])) {
	// 	$query = $query . " AND emp.dept = '$dept'";
	// }

	$stmt = $conn_emp_mgt->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $row) {
			$total = intval($row['total']);
		}
	} else {
		$total = 0;
	}
	return $total;
}

// Total Employee Line Support Count (Resigned Not Included, Unregistered Employee Included)
function count_emp_line_support_from_rejected($search_arr, $conn_emp_mgt)
{
	$dept = addslashes($search_arr['dept']);
	$day = addslashes($search_arr['day']);
	$shift = addslashes($search_arr['shift']);
	$line_no = addslashes($search_arr['line_no']);

	$query = "SELECT count(lsh.emp_no) AS total 
		FROM t_line_support_history lsh
		LEFT JOIN m_employees emp ON emp.emp_no = lsh.emp_no
		WHERE lsh.day = '$day' AND lsh.shift = '$shift' AND lsh.line_no_from LIKE '$line_no%' AND lsh.status = 'rejected'";

	if (!empty($search_arr['dept'])) {
		$query = $query . " AND emp.dept = '" . $dept . "'";
	} else {
		$query = $query . " AND emp.dept != ''";
	}

	// $query = "SELECT count(emp.id) AS total FROM m_employees emp
	// 		LEFT JOIN t_line_support_history ls
	// 		ON emp.emp_no = ls.emp_no";

	// $query = $query . " WHERE ls.day = '$day' AND ls.shift = '$shift'";

	// if (!empty($search_arr['line_no'])) {
	// 	$query = $query . " AND ls.line_no_from LIKE '$line_no%'";
	// } else {
	// 	$query = $query . " AND ls.line_no_from IS NULL OR ls.line_no_from = ''";
	// }

	// $query = $query . " AND ls.status = 'accepted'";

	// if (!empty($search_arr['dept'])) {
	// 	$query = $query . " AND emp.dept = '$dept'";
	// }

	$stmt = $conn_emp_mgt->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $row) {
			$total = intval($row['total']);
		}
	} else {
		$total = 0;
	}
	return $total;
}

// Total Employee Time Out Line Support Count (Resigned Not Included, Unregistered Employee Included)
function count_emp_out_line_support_to($search_arr, $time_out_range, $is_null, $conn_emp_mgt)
{
	$day = addslashes($search_arr['day']);
	$day_tomorrow = addslashes($search_arr['day_tomorrow']);
	$shift = addslashes($search_arr['shift']);
	$line_no = addslashes($search_arr['line_no']);

	$time_out_day = '';

	if ($shift == 'DS') {
		$time_out_day = $day;
	} else if ($shift == 'NS') {
		$time_out_day = $day_tomorrow;
	}

	$query = "SELECT count(tio.emp_no) AS total 
		FROM t_time_in_out tio
		LEFT JOIN t_line_support_history lsh ON lsh.emp_no = tio.emp_no AND lsh.day = '$day' 
		WHERE tio.day = '$day'";

	if ($is_null == false) {
		$time_out_from = addslashes($time_out_range['time_out_from']);
		$time_out_to = addslashes($time_out_range['time_out_to']);

		$query = $query . " AND tio.time_out BETWEEN '$time_out_day $time_out_from' AND '$time_out_day $time_out_to'";
	} else {
		$query = $query . " AND tio.time_out IS NULL";
	}

	$query = $query . " AND lsh.shift = '$shift' AND lsh.line_no_to LIKE '$line_no%' AND lsh.status = 'accepted'";

	$stmt = $conn_emp_mgt->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $row) {
			$total = intval($row['total']);
		}
	} else {
		$total = 0;
	}
	return $total;
}

// Total Employee Time Out Line Support Count (Resigned Not Included, Unregistered Employee Included)
function count_emp_out_line_support_from($search_arr, $time_out_range, $is_null, $conn_emp_mgt)
{
	$day = addslashes($search_arr['day']);
	$day_tomorrow = addslashes($search_arr['day_tomorrow']);
	$shift = addslashes($search_arr['shift']);
	$line_no = addslashes($search_arr['line_no']);

	$time_out_day = '';

	if ($shift == 'DS') {
		$time_out_day = $day;
	} else if ($shift == 'NS') {
		$time_out_day = $day_tomorrow;
	}

	$query = "SELECT count(tio.emp_no) AS total 
		FROM t_time_in_out tio
		LEFT JOIN t_line_support_history lsh ON lsh.emp_no = tio.emp_no AND lsh.day = '$day' 
		WHERE tio.day = '$day'";

	if ($is_null == false) {
		$time_out_from = addslashes($time_out_range['time_out_from']);
		$time_out_to = addslashes($time_out_range['time_out_to']);

		$query = $query . " AND tio.time_out BETWEEN '$time_out_day $time_out_from' AND '$time_out_day $time_out_to'";
	} else {
		$query = $query . " AND tio.time_out IS NULL";
	}

	$query = $query . " AND lsh.shift = '$shift' AND lsh.line_no_from LIKE '$line_no%' AND lsh.status = 'accepted'";

	$stmt = $conn_emp_mgt->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $row) {
			$total = intval($row['total']);
		}
	} else {
		$total = 0;
	}
	return $total;
}

// Total Employee Time Out Line Support Count (Resigned Not Included, Unregistered Employee Included)
function count_emp_out_line_support_from_rejected($search_arr, $time_out_range, $is_null, $conn_emp_mgt)
{
	$day = addslashes($search_arr['day']);
	$day_tomorrow = addslashes($search_arr['day_tomorrow']);
	$shift = addslashes($search_arr['shift']);
	$line_no = addslashes($search_arr['line_no']);

	$time_out_day = '';

	if ($shift == 'DS') {
		$time_out_day = $day;
	} else if ($shift == 'NS') {
		$time_out_day = $day_tomorrow;
	}

	$query = "SELECT count(tio.emp_no) AS total 
		FROM t_time_in_out tio
		LEFT JOIN t_line_support_history lsh ON lsh.emp_no = tio.emp_no AND lsh.day = '$day' 
		WHERE tio.day = '$day'";

	if ($is_null == false) {
		$time_out_from = addslashes($time_out_range['time_out_from']);
		$time_out_to = addslashes($time_out_range['time_out_to']);

		$query = $query . " AND tio.time_out BETWEEN '$time_out_day $time_out_from' AND '$time_out_day $time_out_to'";
	} else {
		$query = $query . " AND tio.time_out IS NULL";
	}

	$query = $query . " AND lsh.shift = '$shift' AND lsh.line_no_from LIKE '$line_no%' AND lsh.status = 'rejected'";

	$stmt = $conn_emp_mgt->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $row) {
			$total = intval($row['total']);
		}
	} else {
		$total = 0;
	}
	return $total;
}

// Working Time X Manpower (Needed for Accounting Efficiency)
function get_wt_x_mp_arr($search_arr, $server_time, $conn_emp_mgt)
{
	$day = addslashes($search_arr['day']);
	$day_tomorrow = addslashes($search_arr['day_tomorrow']);
	$shift = addslashes($search_arr['shift']);
	$shift_group = addslashes($search_arr['shift_group']);
	$dept = addslashes($search_arr['dept']);
	$section = addslashes($search_arr['section']);
	$line_no = addslashes($search_arr['line_no']);

	$total_present_mp = 0;

	$working_time_3 = 450;
	$working_time_4 = 510;
	$working_time_5 = 570;
	$working_time_6 = 630;

	$total_mp_3 = 0;
	$total_mp_4 = 0;
	$total_mp_5 = 0;
	$total_mp_6 = 0;

	$wt_x_mp_3 = 0;
	$wt_x_mp_4 = 0;
	$wt_x_mp_5 = 0;
	$wt_x_mp_6 = 0;

	$wt_x_mp = 0;

	// If based on time out

	if ($server_time >= '03:30:00' && $server_time < '07:30:00') {

		// OUT 3
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group = '$shift_group' AND tio.time_out BETWEEN '$day_tomorrow 03:00:00' AND '$day_tomorrow 03:29:59'";
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_3 = intval($row['total']);
			}
		}

		// Update Manpower Count 3 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "03:00:00",
			"time_out_to" => "03:29:59"
		);
		$total_mp_3 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_3 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_3 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

		// OUT 4
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group = '$shift_group' AND tio.time_out BETWEEN '$day_tomorrow 03:30:00' AND '$day_tomorrow 04:29:59'";
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_4 = intval($row['total']);
			}
		}

		// Update Manpower Count 4 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "03:30:00",
			"time_out_to" => "04:29:59"
		);
		$total_mp_4 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_4 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_4 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

		// OUT 5
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group = '$shift_group' AND tio.time_out BETWEEN '$day_tomorrow 04:30:00' AND '$day_tomorrow 05:29:59'";
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_5 = intval($row['total']);
			}
		}

		// Update Manpower Count 5 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "04:30:00",
			"time_out_to" => "05:29:59"
		);
		$total_mp_5 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_5 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_5 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

		// OUT 6
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group = '$shift_group' AND tio.time_out BETWEEN '$day_tomorrow 05:30:00' AND '$day_tomorrow 06:29:59'";
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_6 = intval($row['total']);
			}
		}

		// Update Manpower Count 6 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "05:30:00",
			"time_out_to" => "06:29:59"
		);
		$total_mp_6 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_6 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_6 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

	} else if ($server_time >= '15:30:00' && $server_time < '19:30:00') {

		// OUT 3
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group IN ('$shift_group', 'ADS') AND tio.time_out BETWEEN '$day 15:00:00' AND '$day 15:29:59'";
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_3 = intval($row['total']);
			}
		}

		// Update Manpower Count 3 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "15:00:00",
			"time_out_to" => "15:29:59"
		);
		$total_mp_3 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_3 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_3 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

		// OUT 4
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group IN ('$shift_group', 'ADS') AND tio.time_out BETWEEN '$day 15:30:00' AND '$day 16:29:59'";
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_4 = intval($row['total']);
			}
		}

		// Update Manpower Count 4 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "15:30:00",
			"time_out_to" => "16:29:59"
		);
		$total_mp_4 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_4 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_4 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

		// OUT 5
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group IN ('$shift_group', 'ADS') AND tio.time_out BETWEEN '$day 16:30:00' AND '$day 17:29:59'";
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_5 = intval($row['total']);
			}
		}

		// Update Manpower Count 5 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "16:30:00",
			"time_out_to" => "17:29:59"
		);
		$total_mp_5 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_5 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_5 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

		// OUT 6
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group IN ('$shift_group', 'ADS') AND tio.time_out BETWEEN '$day 17:30:00' AND '$day 18:29:59'";
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_6 = intval($row['total']);
			}
		}

		// Update Manpower Count 6 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "17:30:00",
			"time_out_to" => "18:29:59"
		);
		$total_mp_6 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_6 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_6 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

	}

	// If based on shuttle allocation

	if (($server_time >= '03:30:00' && $server_time < '07:30:00') || ($server_time >= '15:30:00' && $server_time < '19:30:00')) {
		/*$sql = "SELECT sum(out_5) as total_out_5, sum(out_6) as total_out_6, sum(out_7) as total_out_7, sum(out_8) as total_out_8 FROM t_shuttle_allocation WHERE day = '$day' AND shift = '$shift'";
						  if (!empty($line_no)) {
							  $sql = $sql . " AND line_no = '$line_no'";
						  }

						  $stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
						  $stmt->execute();
						  if ($stmt->rowCount() > 0) {
							  foreach($stmt->fetchALL() as $row){
								  $total_mp_3 = intval($row['total_out_5']);
								  $total_mp_4 = intval($row['total_out_6']);
								  $total_mp_5 = intval($row['total_out_7']);
								  $total_mp_6 = intval($row['total_out_8']);
							  }
						  }*/
	}

	if (empty($total_mp_3) && empty($total_mp_4) && empty($total_mp_5) && empty($total_mp_6)) {
		// Present MP
		$total_present_mp = count_emp_tio($search_arr, $conn_emp_mgt);

		// For shift group ADS
		if ($shift == 'DS') {
			$search_ads_arr = array(
				'day' => $day,
				'shift' => $shift,
				'shift_group' => "ADS",
				'dept' => $dept,
				'section' => $section,
				'line_no' => $line_no
			);

			$total_present_ads_mp = count_emp_tio($search_ads_arr, $conn_emp_mgt);
			$total_present_mp += $total_present_ads_mp;
		}

		// Update Present Count Based on Line Support From and To Counts
		$total_present_mp += count_emp_line_support_to($search_arr, $conn_emp_mgt);
		// $total_present_mp += count_emp_line_support_from_rejected($search_arr, $conn_emp_mgt);
		$total_present_mp -= count_emp_line_support_from($search_arr, $conn_emp_mgt);

		// Working Time based on minutes of work
		$working_time_initial_pcad = 0;

		if ($shift == 'DS') {
			if ($server_time >= '07:00:00') {
				$working_time_initial_pcad += 60;
			}
			if ($server_time >= '08:00:00') {
				$working_time_initial_pcad += 30;
			}
			if ($server_time >= '09:00:00') {
				$working_time_initial_pcad += 60;
			}
			if ($server_time >= '10:00:00') {
				$working_time_initial_pcad += 60;
			}
			if ($server_time >= '11:00:00') {
				$working_time_initial_pcad += 60;
			}
			if ($server_time >= '12:00:00') {
				$working_time_initial_pcad += 60;
			}
			if ($server_time >= '13:00:00') {
				$working_time_initial_pcad += 30;
			}
			if ($server_time >= '14:00:00') {
				$working_time_initial_pcad += 60;
			}

			if ($server_time >= '15:00:00') {
				$working_time_initial_pcad += 30;
				$wt_x_mp_3 = $working_time_initial_pcad * $total_present_mp;
			}
			if ($server_time >= '16:00:00') {
				$working_time_initial_pcad += 60;
				$wt_x_mp_4 = $working_time_initial_pcad * $total_present_mp;
			}
			if ($server_time >= '17:00:00' && $server_time < '18:00:00') {
				$working_time_initial_pcad += 60;
				$wt_x_mp_5 = $working_time_initial_pcad * $total_present_mp;
			}
		} else if ($shift == 'NS') {
			if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
				$working_time_initial_pcad += 270;
				if ($server_time >= '00:00:00') {
					$working_time_initial_pcad += 60;
				}
				if ($server_time >= '01:00:00') {
					$working_time_initial_pcad += 30;
				}
				if ($server_time >= '02:00:00') {
					$working_time_initial_pcad += 60;
				}

				if ($server_time >= '03:00:00') {
					$working_time_initial_pcad += 30;
					$wt_x_mp_3 = $working_time_initial_pcad * $total_present_mp;
				}
				if ($server_time >= '04:00:00') {
					$working_time_initial_pcad += 60;
					$wt_x_mp_4 = $working_time_initial_pcad * $total_present_mp;
				}
				if ($server_time >= '05:00:00') {
					$working_time_initial_pcad += 60;
					$wt_x_mp_5 = $working_time_initial_pcad * $total_present_mp;
				}
			} else {
				if ($server_time >= '19:00:00') {
					$working_time_initial_pcad += 60;
				}
				if ($server_time >= '20:00:00') {
					$working_time_initial_pcad += 30;
				}
				if ($server_time >= '21:00:00') {
					$working_time_initial_pcad += 60;
				}
				if ($server_time >= '22:00:00') {
					$working_time_initial_pcad += 60;
				}
				if ($server_time >= '23:00:00') {
					$working_time_initial_pcad += 60;
				}
			}
		}
		$wt_x_mp = $working_time_initial_pcad * $total_present_mp;
	} else {
		// Present MP
		$total_present_mp = count_emp_tio($search_arr, $conn_emp_mgt);

		// For shift group ADS
		if ($shift == 'DS') {
			$search_ads_arr = array(
				'day' => $day,
				'shift' => $shift,
				'shift_group' => "ADS",
				'dept' => $dept,
				'section' => $section,
				'line_no' => $line_no
			);

			$total_present_ads_mp = count_emp_tio($search_ads_arr, $conn_emp_mgt);
			$total_present_mp += $total_present_ads_mp;
		}

		// Update Present Count Based on Line Support From and To Counts
		$total_present_mp += count_emp_line_support_to($search_arr, $conn_emp_mgt);
		// $total_present_mp += count_emp_line_support_from_rejected($search_arr, $conn_emp_mgt);
		$total_present_mp -= count_emp_line_support_from($search_arr, $conn_emp_mgt);

		// Working Time based on minutes of work
		$working_time_initial_pcad = 450;

		if (!empty($total_mp_3)) {
			$wt_x_mp_3 = $working_time_3 * $total_mp_3;
			$wt_x_mp = $wt_x_mp_3;
			$total_present_mp -= $total_mp_3;
		}

		if (!empty($total_mp_4)) {
			$wt_x_mp_4 = $working_time_4 * $total_mp_4;
			$wt_x_mp += $wt_x_mp_4;
			$total_present_mp -= $total_mp_4;
		}

		if (!empty($total_mp_5)) {
			$wt_x_mp_5 = $working_time_5 * $total_mp_5;
			$wt_x_mp += $wt_x_mp_5;
			$total_present_mp -= $total_mp_5;
		}

		if (!empty($total_mp_6)) {
			$wt_x_mp_6 = $working_time_6 * $total_mp_6;
			$wt_x_mp += $wt_x_mp_6;
			$total_present_mp -= $total_mp_6;
		}

		// If No Time Out (NULL value time_out)
		if ($total_present_mp > 0) {
			if ($server_time >= '03:30:00' && $server_time < '07:30:00') {
				if ($server_time >= '04:00:00') {
					$working_time_initial_pcad += 60;
				}
				if ($server_time >= '05:00:00' && $server_time < '06:00:00') {
					$working_time_initial_pcad += 60;
				}
			} else if ($server_time >= '15:30:00' && $server_time < '19:30:00') {
				if ($server_time >= '16:00:00') {
					$working_time_initial_pcad += 60;
				}
				if ($server_time >= '17:00:00' && $server_time < '18:00:00') {
					$working_time_initial_pcad += 60;
				}
			}

			// Update Total Present (time_out IS NULL) based on Time Out Count from Line Support
			// $time_out_range = array(
			// 	"time_out_from" => "",
			// 	"time_out_to" => ""
			// );
			// $total_present_mp += count_emp_out_line_support_to($search_arr, $time_out_range, true, $conn_emp_mgt);
			// $total_present_mp += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, true, $conn_emp_mgt);
			// $total_present_mp -= count_emp_out_line_support_from($search_arr, $time_out_range, true, $conn_emp_mgt);

			$wt_x_mp_left = $working_time_initial_pcad * $total_present_mp;
			if (!empty($total_mp_3) || !empty($total_mp_4) || !empty($total_mp_5) || !empty($total_mp_6)) {
				$wt_x_mp += $wt_x_mp_left;
			}
		}

		/*$wt_x_mp_3 = $working_time_3 * $total_mp_3;
						  $wt_x_mp_4 = $working_time_4 * $total_mp_4;
						  $wt_x_mp_5 = $working_time_5 * $total_mp_5;
						  $wt_x_mp_6 = $working_time_6 * $total_mp_6;
						  $wt_x_mp = $wt_x_mp_3 + $wt_x_mp_4 + $wt_x_mp_5 + $wt_x_mp_6 + $wt_x_mp_left;*/
	}

	$response_arr = array(
		"total_present_mp" => $total_present_mp,
		"wt_x_mp_3" => $wt_x_mp_3,
		"wt_x_mp_4" => $wt_x_mp_4,
		"wt_x_mp_5" => $wt_x_mp_5,
		"wt_x_mp_6" => $wt_x_mp_6,
		"wt_x_mp" => $wt_x_mp
	);

	return $response_arr;
}

// Working Time X Manpower (Needed for Accounting Efficiency)
function get_wtpcad_x_mp_arr($search_arr, $server_time, $working_time_pcad, $conn_emp_mgt)
{
	$day = addslashes($search_arr['day']);
	$day_tomorrow = addslashes($search_arr['day_tomorrow']);
	$shift = addslashes($search_arr['shift']);
	$shift_group = addslashes($search_arr['shift_group']);
	$dept = addslashes($search_arr['dept']);
	$section = addslashes($search_arr['section']);
	$line_no = addslashes($search_arr['line_no']);

	$working_time_3 = 450;
	$working_time_4 = 510;
	$working_time_5 = 570;
	$working_time_6 = 630;

	$total_mp_3 = 0;
	$total_mp_4 = 0;
	$total_mp_5 = 0;
	$total_mp_6 = 0;

	$wt_x_mp_3 = 0;
	$wt_x_mp_4 = 0;
	$wt_x_mp_5 = 0;
	$wt_x_mp_6 = 0;

	$wt_x_mp = 0;

	// If based on time out

	if ($server_time >= '03:30:00' && $server_time < '07:30:00') {

		// OUT 3
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group = '$shift_group' AND tio.time_out BETWEEN '$day_tomorrow 03:00:00' AND '$day_tomorrow 03:29:59'
			AND emp.dept = '$dept'";
		if (!empty($section)) {
			$sql = $sql . " AND emp.section = '$section'";
		}
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_3 = intval($row['total']);
			}
		}

		// Update Manpower Count 3 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "03:00:00",
			"time_out_to" => "03:29:59"
		);
		$total_mp_3 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_3 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_3 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

		// OUT 4
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group = '$shift_group' AND tio.time_out BETWEEN '$day_tomorrow 03:30:00' AND '$day_tomorrow 04:29:59'
			AND emp.dept = '$dept'";
		if (!empty($section)) {
			$sql = $sql . " AND emp.section = '$section'";
		}
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_4 = intval($row['total']);
			}
		}

		// Update Manpower Count 4 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "03:30:00",
			"time_out_to" => "04:29:59"
		);
		$total_mp_4 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_4 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_4 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

		// OUT 5
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group = '$shift_group' AND tio.time_out BETWEEN '$day_tomorrow 04:30:00' AND '$day_tomorrow 05:29:59'
			AND emp.dept = '$dept'";
		if (!empty($section)) {
			$sql = $sql . " AND emp.section = '$section'";
		}
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_5 = intval($row['total']);
			}
		}

		// Update Manpower Count 5 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "04:30:00",
			"time_out_to" => "05:29:59"
		);
		$total_mp_5 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_5 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_5 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

		// OUT 6
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group = '$shift_group' AND tio.time_out BETWEEN '$day_tomorrow 05:30:00' AND '$day_tomorrow 06:29:59'
			AND emp.dept = '$dept'";
		if (!empty($section)) {
			$sql = $sql . " AND emp.section = '$section'";
		}
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_6 = intval($row['total']);
			}
		}

		// Update Manpower Count 6 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "05:30:00",
			"time_out_to" => "06:29:59"
		);
		$total_mp_6 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_6 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_6 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

	} else if ($server_time >= '15:30:00' && $server_time < '19:30:00') {

		// OUT 3
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group IN ('$shift_group', 'ADS') AND tio.time_out BETWEEN '$day 15:00:00' AND '$day 15:29:59'
			AND emp.dept = '$dept'";
		if (!empty($section)) {
			$sql = $sql . " AND emp.section = '$section'";
		}
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_3 = intval($row['total']);
			}
		}

		// Update Manpower Count 3 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "15:00:00",
			"time_out_to" => "15:29:59"
		);
		$total_mp_3 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_3 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_3 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

		// OUT 4
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group IN ('$shift_group', 'ADS') AND tio.time_out BETWEEN '$day 15:30:00' AND '$day 16:29:59'
			AND emp.dept = '$dept'";
		if (!empty($section)) {
			$sql = $sql . " AND emp.section = '$section'";
		}
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_4 = intval($row['total']);
			}
		}

		// Update Manpower Count 4 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "15:30:00",
			"time_out_to" => "16:29:59"
		);
		$total_mp_4 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_4 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_4 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

		// OUT 5
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group IN ('$shift_group', 'ADS') AND tio.time_out BETWEEN '$day 16:30:00' AND '$day 17:29:59'
			AND emp.dept = '$dept'";
		if (!empty($section)) {
			$sql = $sql . " AND emp.section = '$section'";
		}
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_5 = intval($row['total']);
			}
		}

		// Update Manpower Count 5 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "16:30:00",
			"time_out_to" => "17:29:59"
		);
		$total_mp_5 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_5 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_5 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);

		// OUT 6
		$sql = "SELECT count(tio.id) AS total FROM t_time_in_out tio
			LEFT JOIN m_employees emp
			ON tio.emp_no = emp.emp_no
			WHERE tio.day = '$day' AND emp.shift_group IN ('$shift_group', 'ADS') AND tio.time_out BETWEEN '$day 17:30:00' AND '$day 18:29:59'
			AND emp.dept = '$dept'";
		if (!empty($section)) {
			$sql = $sql . " AND emp.section = '$section'";
		}
		if (!empty($line_no)) {
			$sql = $sql . " AND emp.line_no = '$line_no'";
		}

		$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$total_mp_6 = intval($row['total']);
			}
		}

		// Update Manpower Count 6 based on Time Out Count from Line Support
		$time_out_range = array(
			"time_out_from" => "17:30:00",
			"time_out_to" => "18:29:59"
		);
		$total_mp_6 += count_emp_out_line_support_to($search_arr, $time_out_range, false, $conn_emp_mgt);
		// $total_mp_6 += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, false, $conn_emp_mgt);
		$total_mp_6 -= count_emp_out_line_support_from($search_arr, $time_out_range, false, $conn_emp_mgt);
	}

	// If based on shuttle allocation
	if (($server_time >= '03:30:00' && $server_time < '07:30:00') || ($server_time >= '15:30:00' && $server_time < '19:30:00')) {
		/*$sql = "SELECT sum(out_5) as total_out_5, sum(out_6) as total_out_6, sum(out_7) as total_out_7, sum(out_8) as total_out_8 FROM t_shuttle_allocation WHERE day = '$day' AND shift = '$shift' AND dept = '$dept'";
						  if (!empty($section)) {
							  $sql = $sql . " AND section = '$section'";
						  }
						  if (!empty($line_no)) {
							  $sql = $sql . " AND line_no = '$line_no'";
						  }

						  $stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
						  $stmt->execute();
						  if ($stmt->rowCount() > 0) {
							  foreach($stmt->fetchALL() as $row){
								  $total_mp_3 = intval($row['total_out_5']);
								  $total_mp_4 = intval($row['total_out_6']);
								  $total_mp_5 = intval($row['total_out_7']);
								  $total_mp_6 = intval($row['total_out_8']);
							  }
						  }*/
	}

	if (empty($total_mp_3) && empty($total_mp_4) && empty($total_mp_5) && empty($total_mp_6)) {
		// Present MP
		$total_present_mp = count_emp_tio($search_arr, $conn_emp_mgt);

		// For shift group ADS
		if ($shift == 'DS') {
			$search_ads_arr = array(
				'day' => $day,
				'shift' => $shift,
				'shift_group' => "ADS",
				'dept' => $dept,
				'section' => $section,
				'line_no' => $line_no
			);

			$total_present_ads_mp = count_emp_tio($search_ads_arr, $conn_emp_mgt);
			$total_present_mp += $total_present_ads_mp;
		}

		// Update Present Count Based on Line Support From and To Counts
		$total_present_mp += count_emp_line_support_to($search_arr, $conn_emp_mgt);
		// $total_present_mp += count_emp_line_support_from_rejected($search_arr, $conn_emp_mgt);
		$total_present_mp -= count_emp_line_support_from($search_arr, $conn_emp_mgt);

		if ($working_time_pcad < $working_time_3) {
			$wt_x_mp = $working_time_pcad * $total_present_mp;
		} else if ($working_time_pcad < $working_time_4) {
			$wt_x_mp_3 = $working_time_pcad * $total_present_mp;
			$wt_x_mp = $wt_x_mp_3;
		} else if ($working_time_pcad < $working_time_5) {
			$wt_x_mp_4 = $working_time_pcad * $total_present_mp;
			$wt_x_mp = $wt_x_mp_4;
		} else if ($working_time_pcad < $working_time_6) {
			$wt_x_mp_5 = $working_time_pcad * $total_present_mp;
			$wt_x_mp = $wt_x_mp_5;
		}
	} else {
		// Present MP
		$total_present_mp = count_emp_tio($search_arr, $conn_emp_mgt);

		// For shift group ADS
		if ($shift == 'DS') {
			$search_ads_arr = array(
				'day' => $day,
				'shift' => $shift,
				'shift_group' => "ADS",
				'dept' => $dept,
				'section' => $section,
				'line_no' => $line_no
			);

			$total_present_ads_mp = count_emp_tio($search_ads_arr, $conn_emp_mgt);
			$total_present_mp += $total_present_ads_mp;
		}

		// Update Present Count Based on Line Support From and To Counts
		$total_present_mp += count_emp_line_support_to($search_arr, $conn_emp_mgt);
		// $total_present_mp += count_emp_line_support_from_rejected($search_arr, $conn_emp_mgt);
		$total_present_mp -= count_emp_line_support_from($search_arr, $conn_emp_mgt);

		if (!empty($total_mp_3)) {
			$wt_x_mp_3 = $working_time_3 * $total_mp_3;
			$wt_x_mp = $wt_x_mp_3;
			$total_present_mp -= $total_mp_3;
		}

		if (!empty($total_mp_4)) {
			$wt_x_mp_4 = $working_time_4 * $total_mp_4;
			$wt_x_mp += $wt_x_mp_4;
			$total_present_mp -= $total_mp_4;
		}

		if (!empty($total_mp_5)) {
			$wt_x_mp_5 = $working_time_5 * $total_mp_5;
			$wt_x_mp += $wt_x_mp_5;
			$total_present_mp -= $total_mp_5;
		}

		if (!empty($total_mp_6)) {
			$wt_x_mp_6 = $working_time_6 * $total_mp_6;
			$wt_x_mp += $wt_x_mp_6;
			$total_present_mp -= $total_mp_6;
		}

		// If No Time Out (NULL value time_out)
		if ($total_present_mp > 0) {
			// Update Total Present (time_out IS NULL) based on Time Out Count from Line Support
			// $time_out_range = array(
			// 	"time_out_from" => "",
			// 	"time_out_to" => ""
			// );
			// $total_present_mp += count_emp_out_line_support_to($search_arr, $time_out_range, true, $conn_emp_mgt);
			// $total_present_mp += count_emp_out_line_support_from_rejected($search_arr, $time_out_range, true, $conn_emp_mgt);
			// $total_present_mp -= count_emp_out_line_support_from($search_arr, $time_out_range, true, $conn_emp_mgt);

			$wt_x_mp_left = $working_time_pcad * $total_present_mp;
			if (!empty($total_mp_3) || !empty($total_mp_4) || !empty($total_mp_5) || !empty($total_mp_6)) {
				$wt_x_mp += $wt_x_mp_left;
			}
		}

		//$wt_x_mp = $wt_x_mp_3 + $wt_x_mp_4 + $wt_x_mp_5 + $wt_x_mp_6 + $wt_x_mp_left;
	}

	$response_arr = array(
		"wt_x_mp_3" => $wt_x_mp_3,
		"wt_x_mp_4" => $wt_x_mp_4,
		"wt_x_mp_5" => $wt_x_mp_5,
		"wt_x_mp_6" => $wt_x_mp_6,
		"wt_x_mp" => $wt_x_mp
	);

	return $response_arr;
}

// Get Overall Manpower Count (PD2 & QA) (Plan, Actual, Absent, Support, Absent Rate)
function get_manpower_count_per_line($search_arr, $conn_emp_mgt)
{
	$search_mp_arr = array(
		'day' => $search_arr['day'],
		'shift' => $search_arr['shift'],
		'shift_group' => $search_arr['shift_group'],
		'dept' => $search_arr['dept_pd'],
		'section' => $search_arr['section_pd'],
		'line_no' => $search_arr['line_no']
	);

	$total_pd_mp = count_emp($search_mp_arr, $conn_emp_mgt);
	$total_present_pd_mp = count_emp_tio($search_mp_arr, $conn_emp_mgt);

	// For PD shift group ADS
	if ($search_arr['shift'] == 'DS') {
		$search_pd_ads_arr = array(
			'day' => $search_arr['day'],
			'shift' => $search_arr['shift'],
			'shift_group' => "ADS",
			'dept' => $search_arr['dept_pd'],
			'section' => $search_arr['section_pd'],
			'line_no' => $search_arr['line_no']
		);

		$total_pd_ads_mp = count_emp($search_pd_ads_arr, $conn_emp_mgt);
		$total_present_pd_ads_mp = count_emp_tio($search_pd_ads_arr, $conn_emp_mgt);
		$total_pd_mp += $total_pd_ads_mp;
		$total_present_pd_mp += $total_present_pd_ads_mp;
	}

	$total_pd_mp_line_support_to = count_emp_line_support_to($search_mp_arr, $conn_emp_mgt);
	// $total_pd_mp += $total_pd_mp_line_support_to;
	// $total_present_pd_mp += $total_pd_mp_line_support_to;
	// $total_pd_mp_line_support_from_rejected = count_emp_line_support_from_rejected($search_arr, $conn_emp_mgt);
	// $total_pd_mp += $total_pd_mp_line_support_from_rejected;
	// $total_present_pd_mp += $total_pd_mp_line_support_from_rejected;
	// $total_pd_mp_line_support_from = count_emp_line_support_from($search_arr, $conn_emp_mgt);
	// $total_pd_mp -= $total_pd_mp_line_support_from;
	// $total_present_pd_mp -= $total_pd_mp_line_support_from;
	$total_absent_pd_mp = $total_pd_mp - $total_present_pd_mp;
	$absent_ratio_pd_mp = compute_absent_ratio($total_absent_pd_mp, $total_pd_mp);

	$search_mp_arr = array(
		'day' => $search_arr['day'],
		'shift' => $search_arr['shift'],
		'shift_group' => $search_arr['shift_group'],
		'dept' => $search_arr['dept_qa'],
		'section' => $search_arr['section_qa'],
		'line_no' => $search_arr['line_no']
	);

	$total_qa_mp = count_emp($search_mp_arr, $conn_emp_mgt);
	$total_present_qa_mp = count_emp_tio($search_mp_arr, $conn_emp_mgt);

	// For QA shift group ADS
	if ($search_arr['shift'] == 'DS') {
		$search_qa_ads_arr = array(
			'day' => $search_arr['day'],
			'shift' => $search_arr['shift'],
			'shift_group' => "ADS",
			'dept' => $search_arr['dept_qa'],
			'section' => $search_arr['section_qa'],
			'line_no' => $search_arr['line_no']
		);

		$total_qa_ads_mp = count_emp($search_qa_ads_arr, $conn_emp_mgt);
		$total_present_qa_ads_mp = count_emp_tio($search_qa_ads_arr, $conn_emp_mgt);
		$total_qa_mp += $total_qa_ads_mp;
		$total_present_qa_mp += $total_present_qa_ads_mp;
	}

	$total_qa_mp_line_support_to = count_emp_line_support_to($search_mp_arr, $conn_emp_mgt);
	// $total_qa_mp += $total_qa_mp_line_support_to;
	// $total_present_qa_mp += $total_qa_mp_line_support_to;
	// $total_qa_mp_line_support_from_rejected = count_emp_line_support_from_rejected($search_arr, $conn_emp_mgt);
	// $total_qa_mp += $total_qa_mp_line_support_from_rejected;
	// $total_present_qa_mp += $total_qa_mp_line_support_from_rejected;
	// $total_qa_mp_line_support_from = count_emp_line_support_from($search_arr, $conn_emp_mgt);
	// $total_qa_mp -= $total_qa_mp_line_support_from;
	// $total_present_qa_mp -= $total_qa_mp_line_support_from;
	$total_absent_qa_mp = $total_qa_mp - $total_present_qa_mp;
	$absent_ratio_qa_mp = compute_absent_ratio($total_absent_qa_mp, $total_qa_mp);

	$response_arr = array(
		'total_pd_mp' => $total_pd_mp,
		'total_present_pd_mp' => $total_present_pd_mp,
		'total_absent_pd_mp' => $total_absent_pd_mp,
		'total_pd_mp_line_support_to' => $total_pd_mp_line_support_to,
		'absent_ratio_pd_mp' => round($absent_ratio_pd_mp, 2),
		'total_qa_mp' => $total_qa_mp,
		'total_present_qa_mp' => $total_present_qa_mp,
		'total_absent_qa_mp' => $total_absent_qa_mp,
		'total_qa_mp_line_support_to' => $total_qa_mp_line_support_to,
		'absent_ratio_qa_mp' => round($absent_ratio_qa_mp, 2),
		'message' => 'success'
	);

	return $response_arr;
}

function sum_process_design_plan($search_arr, $conn_pcad)
{
	$registlinename = $search_arr['registlinename'];
	$shift_group = addslashes($search_arr['shift_group']);

	// Sum total process_design (process) and registlinename on m_process_design
	$sql = "";

	if ($shift_group == 'A') {
		$sql = $sql . "SELECT SUM(mp_count_a) AS total ";
	} else if ($shift_group == 'B') {
		$sql = $sql . "SELECT SUM(mp_count_b) AS total ";
	} else {
		$sql = $sql . "SELECT SUM(mp_count_a) AS total ";
	}

	$sql = $sql . "FROM m_process_design WHERE ircs_line = '$registlinename'";

	$stmt = $conn_pcad->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$total = intval($row['total']);
		}
	} else {
		$total = 0;
	}
	return $total;
}

function get_process_design($search_arr, $conn_emp_mgt, $conn_pcad)
{
	$results = array();

	$registlinename = $search_arr['registlinename'];
	$day = $search_arr['day'];
	$shift_group = addslashes($search_arr['shift_group']);
	$line_no = addslashes($search_arr['line_no']);

	// Get Process by m_employees
	// MySQL
	// $sql = "SELECT IFNULL(process, 'No Process') AS process1, 
	// 		COUNT(emp_no) AS total 
	// 	FROM m_employees 
	// 	WHERE shift_group = '$shift_group' AND dept != ''";
	// MS SQL Server
	$sql = "SELECT ISNULL(process, 'No Process') AS process1, 
		COUNT(emp_no) AS total 
	FROM m_employees 
	WHERE shift_group = '$shift_group' AND dept != ''";

	if ($line_no == 'No Line') {
		$sql = $sql . " AND line_no IS NULL";
	} else if (!empty($line_no)) {
		$sql = $sql . " AND line_no LIKE '$line_no%'";
	} else {
		$sql = $sql . " AND (line_no = '' OR line_no IS NULL)";
	}

	// MySQL
	// $sql = $sql . " AND (resigned_date IS NULL OR resigned_date = '0000-00-00' OR resigned_date >= '$day')";
	// MS SQL Server
	$sql = $sql . " AND (resigned_date IS NULL OR resigned_date >= '$day')";
	$sql = $sql . " GROUP BY process";

	$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($row['process1'] == '') {
				array_push($results, array('process' => 'No Process', 'total_present' => 0, 'total' => $row['total']));
			} else {
				array_push($results, array('process' => $row['process1'], 'total_present' => 0, 'total' => $row['total']));
			}
		}
	}

	// Get Total Present per Process by joining t_time_in_out on m_employees
	// MySQL
	// $sql = "SELECT IFNULL(emp.process, 'No Process') AS process1, 
	// 		COUNT(tio.emp_no) AS total_present 
	// 	FROM t_time_in_out tio 
	// 	LEFT JOIN m_employees emp 
	// 	ON tio.emp_no = emp.emp_no 
	// 	WHERE tio.day = '$day' AND emp.shift_group = '$shift_group' AND emp.dept != ''";
	// MS SQL Server
	$sql = "SELECT ISNULL(emp.process, 'No Process') AS process1, 
			COUNT(tio.emp_no) AS total_present 
		FROM t_time_in_out tio 
		LEFT JOIN m_employees emp 
		ON tio.emp_no = emp.emp_no 
		WHERE tio.day = '$day' AND emp.shift_group = '$shift_group' AND emp.dept != ''";

	if ($line_no == 'No Line') {
		$sql = $sql . " AND line_no IS NULL";
	} else if (!empty($line_no)) {
		$sql = $sql . " AND line_no LIKE '$line_no%'";
	} else {
		$sql = $sql . " AND (line_no = '' OR line_no IS NULL)";
	}
	// MySQL
	// $sql = $sql . " AND (emp.resigned_date IS NULL OR emp.resigned_date = '0000-00-00' OR emp.resigned_date >= '$day')";
	// MS SQL Server
	$sql = $sql . " AND (emp.resigned_date IS NULL OR emp.resigned_date >= '$day')";
	$sql = $sql . " GROUP BY emp.process";

	$stmt = $conn_emp_mgt->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			foreach ($results as &$result) {
				if ($result['process'] == $row['process1']) {
					$result['total_present'] = $row['total_present'];
					break; // exit the loop once you've found and updated the process
				}
			}
			unset($result); // unset reference to last element
		}
	}

	// Get total by process_design (process) and registlinename on m_process_design
	$sql = "SELECT process_design";

	if ($shift_group == 'A') {
		$sql = $sql . ", mp_count_a AS mp_count ";
	} else if ($shift_group == 'B') {
		$sql = $sql . ", mp_count_b AS mp_count ";
	} else {
		$sql = $sql . ", mp_count_a AS mp_count ";
	}

	$sql = $sql . "FROM m_process_design WHERE ircs_line = '$registlinename'";

	$stmt = $conn_pcad->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			foreach ($results as &$result) {
				if ($result['process'] == $row['process_design']) {
					$result['total'] = $row['mp_count'];
					break; // exit the loop once you've found and updated the process
				}
			}
			unset($result); // unset reference to last element
		}
	}
	return $results;
}

// PRESENT EMPLOYEES
// function get_present_employees($search_arr, $conn_emp_mgt)
// {
// 	$results = array();

// 	$day = $search_arr['day'];
// 	$shift = $search_arr['shift'];
// 	$shift_group = addslashes($search_arr['shift_group']);
// 	$line_no = addslashes($search_arr['line_no']);

// 	// Get Process by m_employees
// 	// MS SQL Server
// 	$sql = "SELECT 
//             emp.provider, emp.emp_no, emp.full_name, emp.dept, 
//             (
//                 CASE
//                     WHEN CAST(emp.process AS NVARCHAR(15)) LIKE emp.process
//                     THEN emp.process
//                     ELSE CONCAT(CAST(emp.process AS NVARCHAR(15)), '..')
//                 END
//             ) AS process,
//             pic.file_url,
//             CASE 
//                 WHEN tio.id IS NOT NULL THEN 'present'
//                 ELSE 'absent'
//             END AS status
//         FROM m_employees emp
//         LEFT JOIN t_time_in_out tio ON tio.emp_no = emp.emp_no AND tio.day = '$day'
//         LEFT JOIN m_employee_pictures pic ON pic.emp_no = emp.emp_no
//         WHERE emp.dept != ''";

// 	if ($shift == 'DS') {
// 		$sql .= " AND emp.shift_group IN ('$shift_group', 'ADS')";
// 	} else {
// 		$sql .= " AND emp.shift_group = '$shift_group'";
// 	}

// 	if ($line_no == 'No Line') {
// 		$sql .= " AND emp.line_no IS NULL";
// 	} else if (!empty($line_no)) {
// 		$sql .= " AND emp.line_no LIKE '$line_no%'";
// 	} else {
// 		$sql .= " AND (emp.line_no = '' OR emp.line_no IS NULL)";
// 	}

// 	$sql .= " AND (emp.resigned_date IS NULL OR emp.resigned_date >= '$day')";
// 	$sql .= " ORDER BY process ASC, emp.full_name ASC";


// 	// $sql = "SELECT 
// 	// 			emp.provider, emp.emp_no, emp.full_name, emp.dept, 
// 	// 			(
// 	// 				CASE
// 	// 					WHEN CAST(emp.process AS NVARCHAR(15)) LIKE emp.process
// 	// 					THEN emp.process
// 	// 					ELSE CONCAT(CAST(emp.process AS NVARCHAR(15)), '..')
// 	// 				END
// 	// 			) AS process,
// 	// 			pic.file_url 
// 	// 		FROM m_employees emp
// 	// 		RIGHT JOIN t_time_in_out tio ON tio.emp_no = emp.emp_no AND tio.day = '$day'
// 	// 		LEFT JOIN m_employee_pictures pic ON pic.emp_no = emp.emp_no
// 	// 		WHERE emp.dept != ''";
// 	// if ($shift == 'DS') {
// 	// 	$sql = $sql . " AND emp.shift_group IN ('$shift_group', 'ADS')";
// 	// } else {
// 	// 	$sql = $sql . " AND emp.shift_group = '$shift_group'";
// 	// }
// 	// if ($line_no == 'No Line') {
// 	// 	$sql = $sql . " AND emp.line_no IS NULL";
// 	// } else if (!empty($line_no)) {
// 	// 	$sql = $sql . " AND emp.line_no LIKE '$line_no%'";
// 	// } else {
// 	// 	$sql = $sql . " AND (emp.line_no = '' OR emp.line_no IS NULL)";
// 	// }
// 	// $sql = $sql . " AND (emp.resigned_date IS NULL OR emp.resigned_date >= '$day')";
// 	// $sql = $sql . " ORDER BY process ASC, emp.full_name ASC";

// 	$stmt = $conn_emp_mgt->prepare($sql);
// 	$stmt->execute();

// 	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 	if (count($rows) > 0) {
// 		foreach ($rows as $row) {
// 			$file_url = '';
// 			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
// 			if (!empty($row['file_url'])) {
// 				// $file_url = $protocol.$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].$row['file_url'];
// 				$file_url = 'http://172.25.116.188:3000/uploads/emp_mgt/employee_picture/' . basename($row['file_url']);
// 			} else {
// 				$file_url = $protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . '/pcad/dist/img/user.png';
// 			}
// 			// array_push($results, array(
// 			// 	'file_url' => $file_url, 
// 			// 	'emp_no' => $row['emp_no'], 
// 			// 	'full_name' => $row['full_name'], 
// 			// 	'provider' => $row['provider'], 
// 			// 	'dept' => $row['dept'], 
// 			// 	'process' => $row['process'] 
// 			// ));
// 			array_push($results, array(
// 				'file_url' => $file_url,
// 				'emp_no' => $row['emp_no'],
// 				'full_name' => $row['full_name'],
// 				'process' => $row['process']
// 			));
// 		}
// 	}
// 	return $results;
// }

function get_present_and_absent_employees($search_arr, $conn)
{
	$day = $search_arr['day'];
	$shift = $search_arr['shift'];
	$shift_group = $search_arr['shift_group'];
	$line_no = $search_arr['line_no'];

	$sql = "SELECT 
                emp.provider, emp.emp_no, emp.full_name, emp.dept, emp.process,
                pic.file_url,
                CASE 
                    WHEN tio.id IS NOT NULL THEN 'present'
                    ELSE 'absent'
                END AS status
            FROM m_employees emp
            LEFT JOIN t_time_in_out tio ON tio.emp_no = emp.emp_no AND tio.day = '$day'
            LEFT JOIN m_employee_pictures pic ON pic.emp_no = emp.emp_no
            WHERE emp.dept != ''";

	if ($shift == 'DS') {
		$sql .= " AND emp.shift_group IN ('$shift_group', 'ADS')";
	} else {
		$sql .= " AND emp.shift_group = '$shift_group'";
	}

	if ($line_no == 'No Line') {
		$sql .= " AND emp.line_no IS NULL";
	} else if (!empty($line_no)) {
		$sql .= " AND emp.line_no LIKE '$line_no%'";
	} else {
		$sql .= " AND (emp.line_no = '' OR emp.line_no IS NULL)";
	}

	$sql .= " AND (emp.resigned_date IS NULL OR emp.resigned_date >= '$day')";
	$sql .= " ORDER BY emp.process ASC, emp.full_name ASC";

	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$base_url = 'http://172.25.116.188:3000/uploads/emp_mgt/employee_picture/';
	$results = [];

	foreach ($rows as $row) {
		$file_url = '';
		// If the file URL exists, construct the full URL
		if (!empty($row['file_url'])) {
			$file_url = $base_url . basename($row['file_url']);
		} else {
			// Default image URL if no image is found
			$file_url = 'http://172.25.116.188:3000/pcad/dist/img/user.png';
		}

		// Push the data to results with the proper file_url
		array_push($results, array(
			'file_url' => $file_url,
			'emp_no' => $row['emp_no'],
			'full_name' => $row['full_name'],
			'process' => $row['process'],
			'status' => $row['status']
		));
	}

	return $results;
}

// ABSENT EMPLOYEES
function get_absent_employees($search_arr, $conn_emp_mgt)
{
	$results = array();

	$day = $search_arr['day'];
	$shift = $search_arr['shift'];
	$shift_group = addslashes($search_arr['shift_group']);
	$line_no = addslashes($search_arr['line_no']);

	// Get Process by m_employees
	// MS SQL Server
	$sql = "SELECT 
				emp.provider, emp.emp_no, emp.full_name, emp.dept, 
				(
					CASE
						WHEN CAST(emp.process AS NVARCHAR(15)) LIKE emp.process
						THEN emp.process
						ELSE CONCAT(CAST(emp.process AS NVARCHAR(15)), '..')
					END
				) AS process,
				pic.file_url 
			FROM m_employees emp
			LEFT JOIN t_time_in_out tio ON tio.emp_no = emp.emp_no AND tio.day = '$day'
			LEFT JOIN m_employee_pictures pic ON pic.emp_no = emp.emp_no
			WHERE tio.id IS NULL AND emp.dept != ''";
	if ($shift == 'DS') {
		$sql = $sql . " AND emp.shift_group IN ('$shift_group', 'ADS')";
	} else {
		$sql = $sql . " AND emp.shift_group = '$shift_group'";
	}
	if ($line_no == 'No Line') {
		$sql = $sql . " AND emp.line_no IS NULL";
	} else if (!empty($line_no)) {
		$sql = $sql . " AND emp.line_no LIKE '$line_no%'";
	} else {
		$sql = $sql . " AND (emp.line_no = '' OR emp.line_no IS NULL)";
	}
	$sql = $sql . " AND (emp.resigned_date IS NULL OR emp.resigned_date >= '$day')";
	$sql = $sql . " ORDER BY process ASC, emp.full_name ASC";

	$stmt = $conn_emp_mgt->prepare($sql);
	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (count($rows) > 0) {
		foreach ($rows as $row) {
			$file_url = '';
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
			if (!empty($row['file_url'])) {
				// $file_url = $protocol.$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].$row['file_url'];
				$file_url = 'http://172.25.116.188:3000/uploads/emp_mgt/employee_picture/' . basename($row['file_url']);
			} else {
				$file_url = $protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . '/pcad/dist/img/user.png';
			}
			// array_push($results, array(
			// 	'file_url' => $file_url, 
			// 	'emp_no' => $row['emp_no'], 
			// 	'full_name' => $row['full_name'], 
			// 	'provider' => $row['provider'], 
			// 	'dept' => $row['dept'], 
			// 	'process' => $row['process'] 
			// ));
			array_push($results, array(
				'file_url' => $file_url,
				'emp_no' => $row['emp_no'],
				'full_name' => $row['full_name'],
				'process' => $row['process']
			));
		}
	}
	return $results;
}

function get_present_employees2($search_arr, $conn_emp_mgt)
{
	$results = array();

	$line_no = addslashes($search_arr['line_no']);

	// Get Process by m_employees
	// MS SQL Server
	$sql = "EXEC [dbo].[PCAD_ATTENDANCE] @LineNo = ?";

	$stmt = $conn_emp_mgt->prepare($sql);
	$params = array($line_no);
	$stmt->execute($params);

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (count($rows) > 0) {
		foreach ($rows as $row) {
			$file_url = '';
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
			if (!empty($row['picture'])) {
				$file_url = $protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['picture'];
			} else {
				$file_url = $protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . '/pcad/dist/img/user.png';
			}
			array_push($results, array(
				'file_url' => $file_url,
				'emp_no' => $row['emp_no'],
				'full_name' => $row['full_name']
			));
		}
	}

	return $results;
}
