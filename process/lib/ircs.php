<?php

// IRCS Functions
// Must Require Database Config "../conn/ircs.php" before using this functions

// Total Output Count
function count_output($search_arr, $server_date_only, $conn_ircs) {
	//$registlinename = addslashes($search_arr['registlinename']);
    //$final_process = $search_arr['final_process'];
	//$ip = addslashes($search_arr['ip']);

    $total = 0;

	$query = "SELECT COUNT(REGISTLINENAME) AS OUTPUT 
            FROM T_PRODUCTWK WHERE REGISTLINENAME = 'SUBARU_08' 
            AND REGISTDATETIME BETWEEN TO_DATE('2024-01-31 05:59:00', 'yyyy-MM-dd HH24:MI:SS') 
            AND TO_DATE('2024-02-01 05:59:59', 'yyyy-MM-dd HH24:MI:SS') 
            AND INSPECTION3IPADDRESS = '172.25.167.226'";
    // $query = "SELECT COUNT(REGISTLINENAME) AS OUTPUT 
    //         FROM T_PRODUCTWK WHERE REGISTLINENAME = '$registlinename' 
    //         AND REGISTDATETIME BETWEEN TO_DATE('2024-01-31 05:59:00', 'yyyy-MM-dd HH24:MI:SS') 
    //         AND TO_DATE('2024-02-01 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
    // if ($final_process == 'QA') {
    //     $query = $query . "AND INSPECTION4IPADDRESS = '$ip'";
    // } else {
    //     $query = $query . "AND INSPECTION3IPADDRESS = '$ip'";
    // }

    $stmt = oci_parse($conn_ircs, $query);
	oci_execute($stmt);
	while ($row = oci_fetch_object($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $total = $row->OUTPUT;
    }
	
	return $total;
}
?>