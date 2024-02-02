<?php

// PCAD Functions

function compute_yield($qa_output, $input_ng) {
	$input_ng_plus_qa_output = $input_ng + $qa_output;
	if ($input_ng_plus_qa_output != 0) {
		return $qa_output / $input_ng_plus_qa_output;
	} else {
		return 0;
	}
}

function compute_accounting_efficiency($total_st_per_line, $wt_x_mp) {
	if ($wt_x_mp != 0) {
		return $total_st_per_line / $wt_x_mp;
	} else {
		return 0;
	}
}

function compute_hourly_output($plan, $working_time) {
	if ($working_time != 0) {
		return $plan / $working_time;
	} else {
		return 0;
	}
}

function compute_converyor_speed($taktime) {
	return doubleval($taktime) * 0.95;
}

function compute_ppm($ng, $output) {
	if ($output != 0) {
		return ($ng / $output) * 1000000;
	} else {
		return 0;
	}
}

function compute_absent_ratio($actual_absent, $total_active_mp) {
	if ($total_active_mp != 0) {
		return round(($actual_absent / $total_active_mp) * 100, 2);
	} else {
		return 0;
	}
}

?>