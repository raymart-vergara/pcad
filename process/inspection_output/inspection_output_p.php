<?php
include '../server_date_time.php';
require '../conn/ircs.php';
require '../conn/pcad.php';
include '../lib/main.php';
include '../lib/inspection_output.php';

$method = $_GET['method'];

if ($method == 'get_overall_inspection') {
        $shift = 'DS';
        $registlinename = 'DAIHATSU_30';
        $shift_group = 'B';
        $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
        $final_process = $ircs_line_data_arr['final_process'];
        $ip = $ircs_line_data_arr['ip'];

        $search_arr = array(
                'shift' => $shift,
                'shift_group' => $shift_group,
                'registlinename' => $registlinename,
                'final_process' => $final_process,
                'ip' => $ip,
                'server_date_only' => $server_date_only,
                'server_date_only_yesterday' => $server_date_only_yesterday,
                'server_date_only_tomorrow' => $server_date_only_tomorrow,
                'server_time' => $server_time
        );

        $insp_overall_g = count_overall_g($search_arr, $conn_ircs);
        $insp_overall_ng = count_overall_ng($search_arr, $conn_ircs);

        $dimension_p = count_dimension($search_arr, $conn_ircs);
        $dimension_p_ng = count_dimension_ng($search_arr, $conn_ircs);

        $ect_p = count_ect($search_arr, $conn_ircs);
        $ect_p_ng = count_ect_ng($search_arr, $conn_ircs);

        $assurance_p = count_assurance($search_arr, $conn_ircs);
        $assurance_p_ng = count_assurance_ng($search_arr, $conn_ircs);

        $response_array = array(
                'insp_overall_g' => $insp_overall_g,
                'insp_overall_ng' => $insp_overall_ng,

                'dimension_p' => $dimension_p,
                'dimension_p_ng' => $dimension_p_ng,

                'ect_p' => $ect_p,
                'ect_p_ng' => $ect_p_ng,

                'assurance_p' => $assurance_p,
                'assurance_p_ng' => $assurance_p_ng,
                'message' => 'success'
        );

        echo json_encode($response_array, JSON_FORCE_OBJECT);
}

oci_close($conn_ircs);
$conn_pcad = NULL;
?>