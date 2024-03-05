<?php

// IRCS Functions
// Must Require Database Config "../conn/ircs.php" before using this functions

// Total Output Count
function count_output($search_arr, $conn_ircs) {
    $shift = $search_arr['shift'];
	$registlinename = addslashes($search_arr['registlinename']);

    $ircs_line_data_arr = $search_arr['ircs_line_data_arr'];
    $final_process = $ircs_line_data_arr['final_process'];
    $ipaddresscolumn = $ircs_line_data_arr['ipaddresscolumn'];
    $ipAddresses = $ircs_line_data_arr['ipAddresses'];

    $server_date_only = $search_arr['server_date_only'];
    $server_date_only_yesterday = $search_arr['server_date_only_yesterday'];
    $server_date_only_tomorrow = $search_arr['server_date_only_tomorrow'];
    $server_time = $search_arr['server_time'];

    $date_column = "INSPECTION4FINISHDATETIME";

    if ($final_process == 'Assurance') {
        $date_column = "INSPECTION4FINISHDATETIME";
    } else {
        $date_column = "INSPECTION3FINISHDATETIME";
    }

    $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

    $total = 0;

	// $query = "SELECT COUNT(REGISTLINENAME) AS OUTPUT 
    //         FROM T_PRODUCTWK WHERE REGISTLINENAME = 'SUBARU_08' 
    //         AND INSPECTION4FINISHDATETIME BETWEEN TO_DATE('2024-01-31 05:59:00', 'yyyy-MM-dd HH24:MI:SS') 
    //         AND TO_DATE('2024-02-01 05:59:59', 'yyyy-MM-dd HH24:MI:SS') 
    //         AND INSPECTION3IPADDRESS = '172.25.167.226'";
    $query = "SELECT COUNT(REGISTLINENAME) AS OUTPUT 
            FROM T_PRODUCTWK WHERE REGISTLINENAME = '$registlinename'";

    if (!empty($ipAddresses)) {
        $query = $query . " AND $ipaddresscolumn IN ($ipAddressesString)";
    }
    
    if ($shift == 'DS') {
        $query = $query . "AND $date_column BETWEEN TO_DATE('$server_date_only 06:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                            AND TO_DATE('$server_date_only_tomorrow 17:59:59', 'yyyy-MM-dd HH24:MI:SS')";
    } else if ($shift == 'NS') {
        if ($server_time >= '06:00:00' && $server_time <= '23:59:59') {
            $query = $query . "AND $date_column BETWEEN TO_DATE('$server_date_only 18:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                                AND TO_DATE('$server_date_only_tomorrow 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
            $query = $query . "AND $date_column BETWEEN TO_DATE('$server_date_only_yesterday 18:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                                AND TO_DATE('$server_date_only 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
        }
    }

    $stmt = oci_parse($conn_ircs, $query);
	oci_execute($stmt);
	while ($row = oci_fetch_object($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $total = $row->OUTPUT;
    }
	
	return $total;
}

function count_actual_hourly_output($search_arr, $conn_ircs, $conn_pcad) {
	$registlinename = addslashes($search_arr['registlinename']);
    
    $ircs_line_data_arr = $search_arr['ircs_line_data_arr'];
    $final_process = $ircs_line_data_arr['final_process'];
    $ipaddresscolumn = $ircs_line_data_arr['ipaddresscolumn'];
    $ipAddresses = $ircs_line_data_arr['ipAddresses'];

    $server_date_only = $search_arr['server_date_only'];

    $date_column = "INSPECTION4FINISHDATETIME";

    if ($final_process == 'Assurance') {
        $date_column = "INSPECTION4FINISHDATETIME";
    } else {
        $date_column = "INSPECTION3FINISHDATETIME";
    }

    $total = 0;

    $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";

    $server_hour = date('H');

	// SELECT COUNT(PARTSNAME) AS HOURLY_OUTPUT FROM T_PRODUCTWK
    // WHERE INSPECTION4IPADDRESS IN ('172.25.161.166','172.25.166.83')
    // AND REGISTLINENAME = 'DAIHATSU_30' 
    // AND INSPECTION4FINISHDATETIME BETWEEN TO_DATE('2024-02-29 14:00:00', 'yyyy-MM-dd HH24:MI:SS') 
    // AND TO_DATE('2024-02-29 14:59:59', 'yyyy-MM-dd HH24:MI:SS');
    $query = "SELECT COUNT(PARTSNAME) AS HOURLY_OUTPUT 
            FROM T_PRODUCTWK WHERE REGISTLINENAME = '$registlinename'";

    if (!empty($ipAddresses)) {
        $query = $query . " AND $ipaddresscolumn IN ($ipAddressesString)";
    }

    $query = $query . "AND $date_column BETWEEN TO_DATE('$server_date_only $server_hour:00:00', 'yyyy-MM-dd HH24:MI:SS') 
                        AND TO_DATE('$server_date_only $server_hour:59:59', 'yyyy-MM-dd HH24:MI:SS')";

    $stmt = oci_parse($conn_ircs, $query);
	oci_execute($stmt);
	while ($row = oci_fetch_object($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $total = $row->HOURLY_OUTPUT;
    }
	
	return $total;
}
?>