<?php 
include '../server_date_time.php';
require '../conn/ircs.php';
require '../conn/pcad.php';
include '../lib/ircs.php';
include '../lib/st.php';
include '../lib/main.php';

$method = $_GET['method'];

// IRCS

if ($method == 'count_total_output') {
    $shift = 'DS';
    // $shift = $_GET['shift'];
    $registlinename = 'SUBARU_08';
    $line_no = '';
    // $registlinename = $_GET['registlinename'];

    $ircs_line_data_arr = get_ircs_line_data($registlinename, $line_no, $conn_pcad);

    $search_arr = array(
		'shift' => $shift,
        'registlinename' => $registlinename,
		'ircs_line_data_arr' => $ircs_line_data_arr,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time
    );

    $search_arr = array();
	echo count_overall_g($search_arr, $conn_ircs);
}

// http://172.25.112.131/pcad/process/ircs/ircs_p.php?method=compute_st_per_line
if ($method == 'compute_st_per_line') {
    // $registlinename = $_GET['registlinename'];
    // $final_process = $_GET['final_process'];
    // $ip = $_GET['ip'];
    $st_per_product = 0;
    $st_per_product_arr = array();
    
    $query = "SELECT PARTSNAME, COUNT(REGISTLINENAME) AS OUTPUT 
            FROM T_PRODUCTWK WHERE REGISTLINENAME = 'SUBARU_08' 
            AND REGISTDATETIME BETWEEN TO_DATE('2024-02-02 05:59:00', 'yyyy-MM-dd HH24:MI:SS') 
            AND TO_DATE('2024-02-03 05:59:59', 'yyyy-MM-dd HH24:MI:SS') 
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

// http://172.25.112.131/pcad/process/ircs/ircs_p.php?method=compute_st_per_line2
if ($method == 'compute_st_per_line2') {
    // Working Time X Manpower Declaration
    $day = '2024-02-02';
	$shift = 'DS';
	// $line_no = '2132';
    $line_no = '7119';
    // $day = $_POST['day'];
	// $shift = $_POST['shift'];
	// $line_no = $_POST['line_no'];

    // Total ST Per Line Declaration
    // $registlinename = 'DAIHATSU_30';
    $registlinename = 'SUBARU_08';
    $shift_group = 'A';
    // $registlinename = $_POST['registlinename'];
    // $shift_group = $_POST['shift_group'];
    
    $ircs_line_data_arr = get_ircs_line_data($registlinename, $line_no, $conn_pcad);

    $search_arr = array(
        'day' => $day,
		'shift' => $shift,
        'shift_group' => $shift_group,
        'dept' => "",
        'section' => "",
		'line_no' => $line_no,
        'registlinename' => $registlinename,
		'ircs_line_data_arr' => $ircs_line_data_arr,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time
    );

    echo get_total_st_per_line($search_arr, $conn_ircs, $conn_pcad);
}

oci_close($conn_ircs);
$conn_pcad = NULL;
?>