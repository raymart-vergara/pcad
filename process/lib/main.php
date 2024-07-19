<?php

// PCAD Computation Functions

function compute_accounting_efficiency($total_st_per_line, $wt_x_mp)
{
	if ($wt_x_mp != 0) {
		return round(($total_st_per_line / $wt_x_mp) * 100, 2);
	} else {
		return 0;
	}
}

function compute_yield($qa_output, $input_ng)
{
	$input_ng_plus_qa_output = $input_ng + $qa_output;
	if ($input_ng_plus_qa_output != 0) {
		return round(($qa_output / $input_ng_plus_qa_output) * 100, 2);;
	} else {
		return 0;
	}
}

function compute_ppm($ng, $output)
{
	if ($output != 0) {
		return round((($ng / ($output + $ng)) * 1000000), 0);
	} else {
		return 0;
	}
}

function compute_target_hourly_output($takt, $working_time)
{
    if ($takt != 0) {
        $plan = 27000 / $takt;
    } else {
        $plan = 0;
    }

    $working_time_hr = $working_time / 60;

	if ($working_time != 0) {
		return round($plan / $working_time_hr, 0);
	} else {
		return 0;
	}
}

function compute_conveyor_speed($taktime)
{
	return doubleval($taktime) * 0.95;
}

function compute_absent_ratio($actual_absent, $total_active_mp)
{
	if ($total_active_mp != 0) {
		return round(($actual_absent / $total_active_mp) * 100, 2);
	} else {
		return 0;
	}
}

// function compute_absent_ratio($total_pd_mp, $total_active_mp) {
// 	if ($total_active_mp != 0) {
// 		return round(($total_active_mp / $total_pd_mp) * 100, 2);
// 	} else {
// 		return 0;
// 	}
// }


// PCAD Main Functions
// Must Require Database Config "../conn/pcad.php" before using this functions

// IRCS Line Data
function get_ircs_line_data($registlinename, $conn_pcad)
{
	$line_no = '';
	$registlinename = addslashes($registlinename);
	$andon_line = '';
	$final_process = '';
	$ipaddresscolumn = 'INSPECTION4IPADDRESS';
	$ipAddresses = array();
	$response_arr = array();
	
	if (!empty($registlinename)) {
		$query = "SELECT i.line_no, i.ircs_line, i.andon_line, i.final_process, insp.ip_address, insp.ip_address2, insp.ipaddresscolumn, insp.finishdatetime, insp.judgement 
				FROM m_ircs_line i
				LEFT JOIN m_inspection_ip insp
				ON i.ircs_line = insp.ircs_line AND i.final_process = insp.finishdatetime
				WHERE i.ircs_line = '$registlinename'";
		$stmt = $conn_pcad->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$line_no = $row['line_no'];
				$registlinename = $row['ircs_line'];
				$andon_line = $row['andon_line'];
				$final_process = $row['final_process'];
				$ipaddresscolumn = $row['ipaddresscolumn'];
				$finishdatetime = $row['finishdatetime'];
				$judgement = $row['judgement'];
				
				if (!empty($row['ip_address'])) {
					$ipAddresses[] = $row['ip_address'];
				}
				if (!empty($row['ip_address2'])) {
					$ipAddresses[] = $row['ip_address2'];
				}
			}
		}
	}

	// Remove duplicates and return the merged result
	$ipAddresses = array_unique($ipAddresses);

	$response_arr = array(
		'ircs_line_no' => $line_no,
		'registlinename' => $registlinename,
		'andon_line' => $andon_line,
		'final_process' => $final_process,
		'ipaddresscolumn' => $ipaddresscolumn,
		"ipAddresses" => $ipAddresses,
		'finishdatetime' => $finishdatetime,
		'judgement' => $judgement
	);
	return $response_arr;
}

// IRCS IP ADDRESS
function get_ircs_ip_address($registlinename, $conn_pcad)
{
	$registlinename = addslashes($registlinename);
	$process = '';
	$ipaddresscolumn = '';
	$response_arr = array();

	if (!empty($registlinename)) {
		try {
			$query = "SELECT ircs_line, process, ipaddresscolumn FROM m_inspection_ip WHERE ircs_line = :registlinename";
			$stmt = $conn_pcad->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->bindParam(':registlinename', $registlinename, PDO::PARAM_STR);
			$stmt->execute();

			if ($stmt->rowCount() > 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$registlinename = $row['ircs_line'];
				$process = $row['process'];
				$ipaddresscolumn = $row['ipaddresscolumn'];
			}
		} catch (PDOException $e) {
			// Handle the exception, e.g., log or print the error message.
			echo "Error: " . $e->getMessage();
		}
	}

	$response_arr = array(
		'registlinename' => $registlinename,
		'process' => $process,
		'ipaddresscolumn' => $ipaddresscolumn
	);

	return $response_arr;
}

// 
function getIpAddressesFromDatabase($registlinename, $conn_pcad)
{
    $ipaddresscolumn = "";
    $response_arr = array();

    // Retrieve IP addresses from the first column (ip_address) for the specified process
    $query = "SELECT process, ip_address, ip_address2, ipaddresscolumn, finishdatetime, judgement FROM m_inspection_ip WHERE ircs_line = :registlinename";
    $stmt = $conn_pcad->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->bindParam(':registlinename', $registlinename, PDO::PARAM_STR);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$ipAddresses = array();

		$process = $row['process'];

		if (!empty($row['ip_address'])) {
			$ipAddresses[] = $row['ip_address'];
		}
		if (!empty($row['ip_address2'])) {
			$ipAddresses[] = $row['ip_address2'];
		}

		$ipaddresscolumn = $row['ipaddresscolumn'];

		$finishdatetime = $row['finishdatetime'];

		$judgement = $row['judgement'];

		// Remove duplicates and return the merged result
		$ipAddresses = array_unique($ipAddresses);

		$inspection_ip_arr = array(
			"process" => $process,
			"ipaddresscolumn" => $ipaddresscolumn,
			"ipAddresses" => $ipAddresses,
			"finishdatetime" => $finishdatetime,
			"judgement" => $judgement
		);

		// Append to the response array
		$response_arr[] = $inspection_ip_arr;

		// array_push($response_arr, $inspection_ip_arr);
    }

    return $response_arr;
}

// Get t_plan Data
function get_plan_data($registlinename, $day, $shift, $conn_pcad, $opt)
{
	$response_arr = array();

    $sql = "SELECT * FROM t_plan WHERE IRCS_Line = :registlinename";

	switch($opt) {
		case 1:
			$sql .= " AND Status = 'Pending'";
			break;
		case 2:
			$start_date = '';
			$end_date = '';

			if ($shift == 'DS') {
				$start_date = date('Y-m-d H:i:s',(strtotime("$day 06:00:00")));
				$end_date = date('Y-m-d H:i:s',(strtotime("$day 17:59:59")));
			} else if ($shift == 'NS') {
				$day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
				$start_date = date('Y-m-d H:i:s',(strtotime("$day 18:00:00")));
				$end_date = date('Y-m-d H:i:s',(strtotime("$day_tomorrow 05:59:59")));
			}

			$sql .= " AND Status = 'Done' AND (datetime_DB >= '$start_date' AND datetime_DB <= '$end_date')";
			break;
		default:
			$sql .= " AND Status = 'Pending'";
			break;
	}

    $stmt = $conn_pcad->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->bindParam(':registlinename', $registlinename);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($result) {
        // Accounting Efficiency
        $acc_eff = $result['acc_eff'];
        $acc_eff_actual = $result['acc_eff_actual'];
		if (empty($acc_eff_actual)) {
            $acc_eff_actual = 0;
        }
        $acc_eff_gap = ((floatval($acc_eff_actual) / 100) - (intval($acc_eff) / 100)) * 100;

		// Yield
        $yield_actual = $result['yield_actual'];
        if (empty($yield_actual)) {
            $yield_actual = 0;
        }

        // PPM
        $ppm_actual = $result['ppm_actual'];
        if (empty($ppm_actual)) {
            $ppm_actual = 0;
        }

		// Added takt plan
		$takt = $result['takt_secs_DB'];
		$last_update_DB = $result['last_update_DB'];
		$secs_diff = strtotime(date('Y-m-d H:i:s')) - strtotime($last_update_DB);
        if ($takt > 0) {
            $added_takt_plan = floor($secs_diff / $takt);
        } else {
            $added_takt_plan = 0;
        }

		$response_arr = array(
			"plan_datetime" => $result['datetime_DB'],
			"started" => $result['actual_start_DB'],
			"takt" => $result['takt_secs_DB'],
			"last_takt" => $result['last_takt_DB'],
			"last_update_DB" => $result['last_update_DB'],
			"added_takt_plan" => $added_takt_plan,
			"is_paused" => $result['is_paused'],
			"line_no" => $result['Line'],
			"shift_group" => $result['group'],
			"carmodel" => $result['Carmodel'],
			"start_bal_delay" => $result['start_bal_delay'],
			"work_time_plan" => $result['work_time_plan'],
			"daily_plan" => $result['daily_plan'],
			"plan_target" => $result['Target'],
			"plan_actual" => $result['Actual_Target'],
			"plan_gap" => $result['Remaining_Target'],
			"acc_eff" => $result['acc_eff'],
			"acc_eff_actual" => $acc_eff_actual,
			"acc_eff_gap" => $acc_eff_gap,
			"yield_target" => $result['yield_target'],
			"yield_actual" => $yield_actual,
			"ppm_target" => $result['ppm_target'],
			"ppm_target_formatted" => number_format($result['ppm_target']),
			"ppm_actual" => $ppm_actual,
			"ppm_actual_formatted" => number_format($ppm_actual)
		);
	}

	return $response_arr;
}
?>