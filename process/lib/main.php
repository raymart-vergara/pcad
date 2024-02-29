<?php

// PCAD Computation Functions

function compute_accounting_efficiency($total_st_per_line, $wt_x_mp) {
	if ($wt_x_mp != 0) {
		return round(($total_st_per_line / $wt_x_mp) * 100, 2);
	} else {
		return 0;
	}
}

function compute_yield($qa_output, $input_ng) {
	$input_ng_plus_qa_output = $input_ng + $qa_output;
	if ($input_ng_plus_qa_output != 0) {
		return round(($qa_output / $input_ng_plus_qa_output) * 100, 2);;
	} else {
		return 0;
	}
}

function compute_ppm($ng, $output) {
	if ($output != 0) {
		return round((($ng / $output) * 1000000), 0);
	} else {
		return 0;
	}
}

function compute_hourly_output($plan, $working_time) {
	if ($working_time != 0) {
		return round($plan / $working_time, 0);
	} else {
		return 0;
	}
}

function compute_converyor_speed($taktime) {
	return doubleval($taktime) * 0.95;
}

function compute_absent_ratio($actual_absent, $total_active_mp) {
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
function get_ircs_line_data($registlinename, $conn_pcad) {
	$registlinename = addslashes($registlinename);
	$final_process = '';
	$ip = '';
	$response_arr = array();
	if (!empty($registlinename)) {
		$query = "SELECT ircs_line, final_process, ip FROM m_ircs_line WHERE ircs_line = '$registlinename'";
		$stmt = $conn_pcad->prepare($query);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach($stmt->fetchALL() as $row){
				$registlinename = $row['ircs_line'];
				$final_process = $row['final_process'];
				$ip = $row['ip'];
			}
		}
	}
	$response_arr = array(
		'registlinename' => $registlinename,
		'final_process' => $final_process,
		'ip' => $ip
	);
	return $response_arr;
}
?>