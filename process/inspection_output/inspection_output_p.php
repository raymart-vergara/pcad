<?php
include '../server_date_time.php';
require '../conn/ircs.php';
require '../conn/pcad.php';
include '../lib/main.php';
include '../lib/inspection_output.php';

$method = $_GET['method'];

// if ($method == 'get_inspection_details_good') {
//         $shift = 'DS';
//         $registlinename = 'DAIHATSU_30';
//         $shift_group = 'B';

//         $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
//         $final_process = $ircs_line_data_arr['final_process'];
//         $ip = $ircs_line_data_arr['ip'];

//         $search_arr = array(
//                 'shift' => $shift,
//                 'shift_group' => $shift_group,
//                 'registlinename' => $registlinename,
//                 'final_process' => $final_process,
//                 'ip' => $ip,
//                 'server_date_only' => $server_date_only,
//                 'server_date_only_yesterday' => $server_date_only_yesterday,
//                 'server_date_only_tomorrow' => $server_date_only_tomorrow,
//                 'server_time' => $server_time
//         );

//         $list_of_good_viewer = get_overall_g($search_arr, $conn_ircs);

//         $response_array = array(
//                 'list_of_good_viewer' => $list_of_good_viewer,
//                 'message' => 'success'
//         );

//         echo json_encode($response_array, JSON_FORCE_OBJECT);
// }

if ($method == 'get_inspection_details_good') {
        $shift = 'DS';
        $registlinename = 'DAIHATSU_30';
        $shift_group = 'B';

        $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
        $final_process = $ircs_line_data_arr['final_process'];
        $ip = $ircs_line_data_arr['ip'];

        // Fetch processes and their corresponding IP addresses
        $processesAndIpAddresses = getIpAddressesFromDatabase($registlinename, $conn_pcad);

        if (empty($processesAndIpAddresses)) {
                echo '<tr>';
                echo '<td colspan="10" style="text-align:center; color:red;">No Record Found</td>';
                echo '</tr>';
        } else {
                foreach ($processesAndIpAddresses as $processData) {
                        $process = $processData['process'];
                        $ipaddresscolumn = $processData['ipaddresscolumn'];
                        $ipAddresses = $processData['ipAddresses'];

                        $judgmentColumnGood = "";
                        $judgmentColumnNG2 = "";
                        $ipJudgementColumn = "";

                        $search_arr = array(
                                'shift' => $shift,
                                'shift_group' => $shift_group,
                                'registlinename' => $registlinename,
                                'server_date_only' => $server_date_only,
                                'server_date_only_yesterday' => $server_date_only_yesterday,
                                'server_date_only_tomorrow' => $server_date_only_tomorrow,
                                'server_time' => $server_time
                        );

                        switch ($process) {
                                case "Dimension":
                                        $ipJudgementColumn = "INSPECTION1FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION1FINISHDATETIME";
                                        $judgmentColumnNG2 = "INSPECTION1JUDGMENT";
                                        break;
                                case "Electric":
                                        $ipJudgementColumn = "INSPECTION2FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION2FINISHDATETIME";
                                        $judgmentColumnNG2 = "INSPECTION2JUDGMENT";
                                        break;
                                case "Visual":
                                        $ipJudgementColumn = "INSPECTION3FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION3FINISHDATETIME";
                                        $judgmentColumnNG2 = "INSPECTION3JUDGMENT";
                                        break;
                                case "Assurance":
                                        $ipJudgementColumn = "INSPECTION4FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION4FINISHDATETIME";
                                        $judgmentColumnNG2 = "INSPECTION4JUDGMENT";
                                        break;
                                default:
                                        break;
                        }

                        $processDetailsGood = array(
                                'process' => $process,
                                'ipAddressColumn' => $ipaddresscolumn,
                                'judgmentColumn' => $judgmentColumnGood,
                                'ipAddresses' => $ipAddresses
                        );

                        $processDetailsNG = array(
                                'process' => $process,
                                'ipJudgementColumn' => $ipJudgementColumn,
                                'ipAddressColumn' => $ipaddresscolumn,
                                'judgmentColumn' => $judgmentColumnNG2,
                                'ipAddresses' => $ipAddresses
                        );

                        $p_good = countProcessGood($search_arr, $conn_ircs, $processDetailsGood);
                        $p_ng = countProcessNG($search_arr, $conn_ircs, $processDetailsNG, $conn_pcad);

                        echo '<tr style="cursor:pointer;">';
                        echo '<td style="text-align:center;">' . $p_good . '</td>';
                        echo '<td style="text-align:center; background: #fff">' . $process . '</td>';
                        echo '<td style="text-align:center;">' . $p_ng . '</td>';
                        echo '</tr>';
                }
        }
}


if ($method == 'get_inspection_details_no_good') {
        $shift = 'DS';
        $registlinename = 'DAIHATSU_30';
        $shift_group = 'B';

        $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
        $final_process = $ircs_line_data_arr['final_process'];
        $ip = $ircs_line_data_arr['ip'];

        $processesAndIpAddresses = getIpAddressesFromDatabase($registlinename, $conn_pcad);

        foreach ($processesAndIpAddresses as $processData) {
                $process = $processData['process'];
                $ipaddresscolumn = $processData['ipaddresscolumn'];
                $ipAddresses = $processData['ipAddresses'];

                $judgmentColumnNG2 = "";
                $ipJudgementColumn = "";

                $search_arr = array(
                        'shift' => $shift,
                        'shift_group' => $shift_group,
                        'registlinename' => $registlinename,
                        'server_date_only' => $server_date_only,
                        'server_date_only_yesterday' => $server_date_only_yesterday,
                        'server_date_only_tomorrow' => $server_date_only_tomorrow,
                        'server_time' => $server_time
                );

                switch ($process) {
                        case "Dimension":
                                $ipJudgementColumn = "INSPECTION1FINISHDATETIME";
                                $judgmentColumnNG2 = "INSPECTION1JUDGMENT";
                                break;
                        case "Electric":
                                $ipJudgementColumn = "INSPECTION2FINISHDATETIME";
                                $judgmentColumnNG2 = "INSPECTION2JUDGMENT";
                                break;
                        case "Visual":
                                $ipJudgementColumn = "INSPECTION3FINISHDATETIME";
                                $judgmentColumnNG2 = "INSPECTION3JUDGMENT";
                                break;
                        case "Assurance":
                                $ipJudgementColumn = "INSPECTION4FINISHDATETIME";
                                $judgmentColumnNG2 = "INSPECTION4JUDGMENT";
                                break;
                        default:
                                break;
                }

                $detailedNG = array(
                        'process' => $process,
                        'ipJudgementColumn' => $ipJudgementColumn,
                        'ipAddressColumn' => $ipaddresscolumn,
                        'judgmentColumn' => $judgmentColumnNG2,
                        'ipAddresses' => $ipAddresses
                );
        }

        $list_of_no_good_viewer = get_overall_ng($search_arr, $conn_ircs, $conn_pcad, $processDetailsNG);

        $response_array = array(
                'list_of_no_good_viewer' => $list_of_no_good_viewer,
                'message' => 'success'
        );

        echo json_encode($response_array, JSON_FORCE_OBJECT);
}





if ($method == 'get_inspection_list') {
        $shift = 'DS';
        $registlinename = 'DAIHATSU_30';
        $shift_group = 'B';

        $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
        $final_process = $ircs_line_data_arr['final_process'];
        $ip = $ircs_line_data_arr['ip'];

        // Fetch processes and their corresponding IP addresses
        $processesAndIpAddresses = getIpAddressesFromDatabase($registlinename, $conn_pcad);

        if (empty($processesAndIpAddresses)) {
                echo '<tr>';
                echo '<td colspan="10" style="text-align:center; color:red;">No Record Found</td>';
                echo '</tr>';
        } else {
                foreach ($processesAndIpAddresses as $processData) {
                        $process = $processData['process'];
                        $ipaddresscolumn = $processData['ipaddresscolumn'];
                        $ipAddresses = $processData['ipAddresses'];

                        $judgmentColumnGood = "";
                        $judgmentColumnNG2 = "";
                        $ipJudgementColumn = "";

                        $search_arr = array(
                                'shift' => $shift,
                                'shift_group' => $shift_group,
                                'registlinename' => $registlinename,
                                'server_date_only' => $server_date_only,
                                'server_date_only_yesterday' => $server_date_only_yesterday,
                                'server_date_only_tomorrow' => $server_date_only_tomorrow,
                                'server_time' => $server_time
                        );

                        switch ($process) {
                                case "Dimension":
                                        $ipJudgementColumn = "INSPECTION1FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION1FINISHDATETIME";
                                        $judgmentColumnNG2 = "INSPECTION1JUDGMENT";
                                        break;
                                case "Electric":
                                        $ipJudgementColumn = "INSPECTION2FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION2FINISHDATETIME";
                                        $judgmentColumnNG2 = "INSPECTION2JUDGMENT";
                                        break;
                                case "Visual":
                                        $ipJudgementColumn = "INSPECTION3FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION3FINISHDATETIME";
                                        $judgmentColumnNG2 = "INSPECTION3JUDGMENT";
                                        break;
                                case "Assurance":
                                        $ipJudgementColumn = "INSPECTION4FINISHDATETIME";
                                        $judgmentColumnGood = "INSPECTION4FINISHDATETIME";
                                        $judgmentColumnNG2 = "INSPECTION4JUDGMENT";
                                        break;
                                default:
                                        break;
                        }

                        $processDetailsGood = array(
                                'process' => $process,
                                'ipAddressColumn' => $ipaddresscolumn,
                                'judgmentColumn' => $judgmentColumnGood,
                                'ipAddresses' => $ipAddresses
                        );

                        $processDetailsNG = array(
                                'process' => $process,
                                'ipJudgementColumn' => $ipJudgementColumn,
                                'ipAddressColumn' => $ipaddresscolumn,
                                'judgmentColumn' => $judgmentColumnNG2,
                                'ipAddresses' => $ipAddresses
                        );

                        $p_good = countProcessGood($search_arr, $conn_ircs, $processDetailsGood);
                        $p_ng = countProcessNG($search_arr, $conn_ircs, $processDetailsNG, $conn_pcad);

                        echo '<tr style="cursor:pointer;">';
                        echo '<td style="text-align:center;">' . $p_good . '</td>';
                        echo '<td style="text-align:center; background: #fff">' . $process . '</td>';
                        echo '<td style="text-align:center;">' . $p_ng . '</td>';
                        echo '</tr>';
                }
        }
}

// if ($method == 'get_overall_inspection') {
//         $shift = 'DS';
//         $registlinename = 'DAIHATSU_30';
//         $shift_group = 'B';

//         $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
//         $final_process = $ircs_line_data_arr['final_process'];
//         $ip = $ircs_line_data_arr['ip'];

//         $search_arr = array(
//                 'shift' => $shift,
//                 'shift_group' => $shift_group,
//                 'registlinename' => $registlinename,
//                 'final_process' => $final_process,
//                 'ip' => $ip,
//                 'server_date_only' => $server_date_only,
//                 'server_date_only_yesterday' => $server_date_only_yesterday,
//                 'server_date_only_tomorrow' => $server_date_only_tomorrow,
//                 'server_time' => $server_time
//         );

//         $insp_overall_g = count_overall_g($search_arr, $conn_ircs);
//         $insp_overall_ng = count_overall_ng($search_arr, $conn_ircs, $conn_pcad);

//         $response_array = array(
//                 'insp_overall_g' => $insp_overall_g,
//                 'insp_overall_ng' => $insp_overall_ng,
//                 'message' => 'success'
//         );

//         echo json_encode($response_array, JSON_FORCE_OBJECT);
// }

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
        $insp_overall_ng = get_rows_overall_ng($search_arr, $conn_ircs, $conn_pcad);

        $response_array = array(
                'insp_overall_g' => $insp_overall_g,
                'insp_overall_ng' => $insp_overall_ng,
                'message' => 'success'
        );

        echo json_encode($response_array, JSON_FORCE_OBJECT);
}

oci_close($conn_ircs);
$conn_pcad = NULL;
?>