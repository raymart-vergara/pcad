<?php

// ST (PCAD) Functions
// Must Require Database Config "../conn/pcad.php" before using this functions
// Must Require Database Config "../conn/ircs.php" before using this functions

// ST Data
function get_st_data($parts_name, $conn_pcad) {
	$parts_name = addslashes($parts_name);
	$st = 0;
	$response_arr = array();
	if (!empty($parts_name)) {
		$query = "SELECT parts_name, st FROM m_st WHERE parts_name LIKE '$parts_name%'";
		$stmt = $conn_pcad->prepare($query);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach($stmt->fetchALL() as $row){
				$parts_name = $row['parts_name'];
				$st = floatval($row['st']);
			}
		}
	}
	$response_arr = array(
		'parts_name' => $parts_name,
		'st' => $st
	);
	return $response_arr;
}

// Total ST Per Line Computation
function get_total_st_per_line($search_arr, $conn_ircs, $conn_pcad) {
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

    $st_per_product = 0;
    $st_per_product_arr = array();

    $date_column = $final_process;

    // if ($final_process == 'Assurance') {
    //     $date_column = "INSPECTION4FINISHDATETIME";
    // } else {
    //     $date_column = "INSPECTION3FINISHDATETIME";
    // }

    $ipAddressesString = "'" . implode("', '", $ipAddresses) . "'";
    
    // $query = "SELECT PARTSNAME, COUNT(REGISTLINENAME) AS OUTPUT 
    //         FROM T_PRODUCTWK WHERE REGISTLINENAME = 'SUBARU_08' 
    //         AND REGISTDATETIME BETWEEN TO_DATE('2024-02-02 05:59:00', 'yyyy-MM-dd HH24:MI:SS') 
    //         AND TO_DATE('2024-02-03 05:59:59', 'yyyy-MM-dd HH24:MI:SS') 
    //         AND INSPECTION3IPADDRESS = '172.25.167.226'
    //         GROUP BY PARTSNAME, REGISTLINENAME";
    $query = "SELECT PARTSNAME, COUNT(REGISTLINENAME) AS OUTPUT 
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

    $query = $query . "GROUP BY PARTSNAME, REGISTLINENAME";

    $stmt = oci_parse($conn_ircs, $query);
	oci_execute($stmt);
	while ($row = oci_fetch_object($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $parts_name = $row->PARTSNAME;
        $output = floatval($row->OUTPUT);

        $st_data_arr = get_st_data($parts_name, $conn_pcad);
        $st = floatval($st_data_arr['st']);

        // ST Per Product Formula
        $st_per_product = $output * $st;

        array_push($st_per_product_arr, $st_per_product);
    }

    // Total ST Per Line Computation
    $total_st_per_line = array_sum($st_per_product_arr);

    return $total_st_per_line;
}
?>