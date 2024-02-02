<?php 
include '../server_date_time.php';
require '../conn/ircs.php';
require '../conn/pcad.php';
include '../lib/ircs.php';
include '../lib/st.php';

$method = $_GET['method'];

// IRCS

if ($method == 'count_total_output') {
    // $registlinename = $_POST['registlinename'];
    // $final_process = $_POST['final_process'];
    // $ip = $_POST['ip'];
    // $search_arr = array(
	// 	'registlinename' => $registlinename,
	// 	'final_process' => $final_process,
    // 	'ip' => $ip
	// );
    $search_arr = array();
	echo count_output($search_arr, $server_date_only, $conn_ircs);
}

if ($method == 'compute_st_per_line') {
    //$registlinename = $_POST['registlinename'];
    //$final_process = $_POST['final_process'];
    //$ip = $_POST['ip'];
    $st_per_product = 0;
    $st_per_product_arr = array();
    
    $query = "SELECT PARTSNAME, COUNT(REGISTLINENAME) AS OUTPUT 
            FROM T_PRODUCTWK WHERE REGISTLINENAME = 'SUBARU_08' 
            AND REGISTDATETIME BETWEEN TO_DATE('2024-01-31 05:59:00', 'yyyy-MM-dd HH24:MI:SS') 
            AND TO_DATE('2024-02-01 05:59:59', 'yyyy-MM-dd HH24:MI:SS') 
            AND INSPECTION3IPADDRESS = '172.25.167.226'
            GROUP BY PARTSNAME, REGISTLINENAME";
    // $query = "SELECT PARTSNAME, COUNT(REGISTLINENAME) AS OUTPUT 
    //         FROM T_PRODUCTWK WHERE REGISTLINENAME = '$registlinename' 
    //         AND REGISTDATETIME BETWEEN TO_DATE('2024-01-31 05:59:00', 'yyyy-MM-dd HH24:MI:SS') 
    //         AND TO_DATE('2024-02-01 05:59:59', 'yyyy-MM-dd HH24:MI:SS')";
    // if ($final_process == 'QA') {
    //     $query = $query . "AND INSPECTION4IPADDRESS = '$ip'";
    // } else {
    //     $query = $query . "AND INSPECTION3IPADDRESS = '$ip'";
    // }
    // $query = $query . "GROUP BY PARTSNAME, REGISTLINENAME";

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

    echo $total_st_per_line;
}

if ($method == 'compute_st_per_line2') {
    //$registlinename = $_POST['registlinename'];
    //$final_process = $_POST['final_process'];
    //$ip = $_POST['ip'];

    // $search_arr = array(
	// 	'registlinename' => $registlinename,
	// 	'final_process' => $final_process,
    // 	'ip' => $ip
	// );

    $search_arr = array();

    echo get_total_st_per_line($search_arr, $conn_ircs, $conn_pcad);
}

oci_close($conn_ircs);
$conn_pcad = NULL;
?>