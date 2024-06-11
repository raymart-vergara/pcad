<?php
include '../server_date_time.php';
require '../conn/pcad.php';
require '../conn/ircs.php';
include '../lib/emp_mgt.php';
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

// if ($method == 'get_inspection_details_good') {
//         $shift = 'DS';
//         $registlinename = 'DAIHATSU_30';
//         $shift_group = 'B';

//         $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
//         $final_process = $ircs_line_data_arr['final_process'];
//         $ip = $ircs_line_data_arr['ip'];

//         // Fetch processes and their corresponding IP addresses
//         $processesAndIpAddresses = getIpAddressesFromDatabase($registlinename, $conn_pcad);

//         if (empty($processesAndIpAddresses)) {
//                 echo '<tr>';
//                 echo '<td colspan="10" style="text-align:center; color:red;">No Record Found</td>';
//                 echo '</tr>';
//         } else {
//                 foreach ($processesAndIpAddresses as $processData) {
//                         $process = $processData['process'];
//                         $ipaddresscolumn = $processData['ipaddresscolumn'];
//                         $ipAddresses = $processData['ipAddresses'];

//                         $judgmentColumnGood = "";
//                         $judgmentColumnNG2 = "";
//                         $ipJudgementColumn = "";

//                         $search_arr = array(
//                                 'shift' => $shift,
//                                 'shift_group' => $shift_group,
//                                 'registlinename' => $registlinename,
//                                 'server_date_only' => $server_date_only,
//                                 'server_date_only_yesterday' => $server_date_only_yesterday,
//                                 'server_date_only_tomorrow' => $server_date_only_tomorrow,
//                                 'server_time' => $server_time
//                         );

//                         switch ($process) {
//                                 case "Dimension":
//                                         $ipJudgementColumn = "INSPECTION1FINISHDATETIME";
//                                         $judgmentColumnGood = "INSPECTION1FINISHDATETIME";
//                                         $judgmentColumnNG2 = "INSPECTION1JUDGMENT";
//                                         break;
//                                 case "Electric":
//                                         $ipJudgementColumn = "INSPECTION2FINISHDATETIME";
//                                         $judgmentColumnGood = "INSPECTION2FINISHDATETIME";
//                                         $judgmentColumnNG2 = "INSPECTION2JUDGMENT";
//                                         break;
//                                 case "Visual":
//                                         $ipJudgementColumn = "INSPECTION3FINISHDATETIME";
//                                         $judgmentColumnGood = "INSPECTION3FINISHDATETIME";
//                                         $judgmentColumnNG2 = "INSPECTION3JUDGMENT";
//                                         break;
//                                 case "Assurance":
//                                         $ipJudgementColumn = "INSPECTION4FINISHDATETIME";
//                                         $judgmentColumnGood = "INSPECTION4FINISHDATETIME";
//                                         $judgmentColumnNG2 = "INSPECTION4JUDGMENT";
//                                         break;
//                                 default:
//                                         break;
//                         }

//                         $processDetailsGood = array(
//                                 'process' => $process,
//                                 'ipAddressColumn' => $ipaddresscolumn,
//                                 'judgmentColumn' => $judgmentColumnGood,
//                                 'ipAddresses' => $ipAddresses
//                         );

//                         $processDetailsNG = array(
//                                 'process' => $process,
//                                 'ipJudgementColumn' => $ipJudgementColumn,
//                                 'ipAddressColumn' => $ipaddresscolumn,
//                                 'judgmentColumn' => $judgmentColumnNG2,
//                                 'ipAddresses' => $ipAddresses
//                         );

//                         $p_good = countProcessGood($search_arr, $conn_ircs, $processDetailsGood);
//                         $p_ng = countProcessNG($search_arr, $conn_ircs, $processDetailsNG, $conn_pcad);

//                         echo '<tr style="cursor:pointer;">';
//                         echo '<td style="text-align:center;">' . $p_good . '</td>';
//                         echo '<td style="text-align:center; background: #fff">' . $process . '</td>';
//                         echo '<td style="text-align:center;">' . $p_ng . '</td>';
//                         echo '</tr>';
//                 }
//         }
// }


// if ($method == 'get_inspection_details_no_good') {
//         $shift = 'DS';
//         $registlinename = 'DAIHATSU_30';
//         $shift_group = 'B';

//         $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);
//         $final_process = $ircs_line_data_arr['final_process'];
//         $ip = $ircs_line_data_arr['ip'];

//         $processesAndIpAddresses = getIpAddressesFromDatabase($registlinename, $conn_pcad);

//         foreach ($processesAndIpAddresses as $processData) {
//                 $process = $processData['process'];
//                 $ipaddresscolumn = $processData['ipaddresscolumn'];
//                 $ipAddresses = $processData['ipAddresses'];

//                 $judgmentColumnNG2 = "";
//                 $ipJudgementColumn = "";

//                 $search_arr = array(
//                         'shift' => $shift,
//                         'shift_group' => $shift_group,
//                         'registlinename' => $registlinename,
//                         'server_date_only' => $server_date_only,
//                         'server_date_only_yesterday' => $server_date_only_yesterday,
//                         'server_date_only_tomorrow' => $server_date_only_tomorrow,
//                         'server_time' => $server_time
//                 );

//                 switch ($process) {
//                         case "Dimension":
//                                 $ipJudgementColumn = "INSPECTION1FINISHDATETIME";
//                                 $judgmentColumnNG2 = "INSPECTION1JUDGMENT";
//                                 break;
//                         case "Electric":
//                                 $ipJudgementColumn = "INSPECTION2FINISHDATETIME";
//                                 $judgmentColumnNG2 = "INSPECTION2JUDGMENT";
//                                 break;
//                         case "Visual":
//                                 $ipJudgementColumn = "INSPECTION3FINISHDATETIME";
//                                 $judgmentColumnNG2 = "INSPECTION3JUDGMENT";
//                                 break;
//                         case "Assurance":
//                                 $ipJudgementColumn = "INSPECTION4FINISHDATETIME";
//                                 $judgmentColumnNG2 = "INSPECTION4JUDGMENT";
//                                 break;
//                         default:
//                                 break;
//                 }

//                 $detailedNG = array(
//                         'process' => $process,
//                         'ipJudgementColumn' => $ipJudgementColumn,
//                         'ipAddressColumn' => $ipaddresscolumn,
//                         'judgmentColumn' => $judgmentColumnNG2,
//                         'ipAddresses' => $ipAddresses
//                 );
//         }

//         $list_of_no_good_viewer = get_overall_ng($search_arr, $conn_ircs, $conn_pcad, $processDetailsNG);

//         $response_array = array(
//                 'list_of_no_good_viewer' => $list_of_no_good_viewer,
//                 'message' => 'success'
//         );

//         echo json_encode($response_array, JSON_FORCE_OBJECT);
// }

if ($method == 'get_inspection_list') {
    $shift = get_shift($server_time);
    $registlinename = $_GET['registlinename'];

    $search_arr = array(
        'shift' => $shift,
        'registlinename' => $registlinename,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time
    );

    $overall_inspection_list_arr = get_overall_inspection_list($search_arr, $conn_ircs, $conn_pcad);

    if (empty($overall_inspection_list_arr)) {
        echo '<tr>';
        echo '<td colspan="10" style="text-align:center; color:red;">No Record Found</td>';
        echo '</tr>';
    } else {
        foreach ($overall_inspection_list_arr as $inspection_list) {
            echo '<tr style="cursor:pointer;">';
            echo '<td style="text-align:center; font-size: 22px;">' . $inspection_list['p_good'] . '</td>';
            echo '<td style="text-align:center; font-size: 22px;">' . $inspection_list['process'] . '</td>';
            echo '<td style="text-align:center; font-size: 22px;">' . $inspection_list['p_ng'] . '</td>';
            echo '</tr>';
        }
    }
}

if ($method == 'get_inspection_list_copy') {
    $shift = get_shift($server_time);
    $registlinename = $_GET['registlinename'];

    $search_arr = array(
        'shift' => $shift,
        'registlinename' => $registlinename,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time
    );

    $overall_inspection_list_arr = get_overall_inspection_list($search_arr, $conn_ircs, $conn_pcad);

    if (empty($overall_inspection_list_arr)) {
        echo '<tr>';
        echo '<td colspan="10" style="text-align:center; color:red;">No Record Found</td>';
        echo '</tr>';
    } else {
        foreach ($overall_inspection_list_arr as $inspection_list) {
            echo '<tr style="cursor:pointer;">';
            echo '<td style="text-align:center; font-size: 16px;">' . $inspection_list['p_good'] . '</td>';
            echo '<td style="text-align:center; font-size: 16px;">' . $inspection_list['process'] . '</td>';
            echo '<td style="text-align:center; font-size: 16px;">' . $inspection_list['p_ng'] . '</td>';
            echo '</tr>';
        }
    }
}

if ($method == 'get_overall_inspection') {
    $shift = get_shift($server_time);
    $registlinename = $_GET['registlinename'];

    $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);

    $search_arr = array(
        'shift' => $shift,
        'registlinename' => $registlinename,
        'ircs_line_data_arr' => $ircs_line_data_arr,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time
    );

    $insp_overall_g = count_overall_g($search_arr, $conn_ircs);
    $insp_overall_ng = count_overall_ng($search_arr, $conn_ircs, $conn_pcad);

    $response_array = array(
        'insp_overall_g' => $insp_overall_g,
        'insp_overall_ng' => $insp_overall_ng,
        'message' => 'success'
    );

    echo json_encode($response_array, JSON_FORCE_OBJECT);
}

if ($method == 'get_inspection_details_no_good') {
    $shift = get_shift($server_time);
    $registlinename = $_GET['registlinename'];
    // $shift_group = $_GET['shift_group'];

    // $shift = 'DS';
    // $registlinename = 'DAIHATSU_30';
    // $shift_group = 'B';

    $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);

    $search_arr = array(
        'shift' => $shift,
        'registlinename' => $registlinename,
        'ircs_line_data_arr' => $ircs_line_data_arr,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time
    );

    $list_of_no_good_viewer = get_rows_overall_ng($search_arr, $conn_ircs, $conn_pcad);

    $c = 0;

    echo '<thead>
        <tr>
                <th rowspan="2" style="background: #B071CD; color: #fff; font-weight: normal; vertical-align: middle;">#</th>
                <th colspan="24" style="background: #B071CD;"></th>
                <th colspan="24" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 1</th>
                <th colspan="24" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 2</th>
                <th colspan="24" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 3</th>
                <th colspan="24" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 4</th>
                <th colspan="24" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 5</th>
                <th colspan="24" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 6</th>
                <th colspan="24" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 7</th>
                <th colspan="26" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 8</th>
                <th colspan="6" style="background: #B071CD;"></th>
                <th colspan="2" style="background: #B071CD; color: #fff; font-weight: normal;">Infection</th>
                <th colspan="10" style="background: #B071CD; color: #fff; font-weight: normal;">Check Infection</th>
                <th colspan="19" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 9</th>
        </tr>
        <tr>
                <th class="table-header">Repair Card Number</th>
                <th class="table-header">Repair Start Date Time</th>
                <th class="table-header">Repair Finish Date Time</th>
                <th class="table-header">Repair Device ID</th>
                <th class="table-header">Operator ID</th>
                <th class="table-header">Repair Judgement</th>
                <th class="table-header">Discovery Process</th>
                <th class="table-header">NG Content</th>
                <th class="table-header">NG Content Detail</th>
                <th class="table-header">Repair Content</th>
                <th class="table-header">Outbreak Process</th>
                <th class="table-header">Outbreak Operator</th>
                <th class="table-header">Registered Date Time</th>
                <th class="table-header">Registered Company Code</th>
                <th class="table-header">Registered Department Code</th>
                <th class="table-header">Registered Line Name</th>
                <th class="table-header">Registered Process</th>
                <th class="table-header">Registered Device ID</th>
                <th class="table-header">IP Address</th>
                <th class="table-header">Registered Operator ID</th>
                <th class="table-header">Parts Name</th>
                <th class="table-header">Lot</th>
                <th class="table-header">Serial</th>
                <th class="table-header">Read Name</th>

                <!-- Inspection 1 -->
                <th class="table-header">Inspection 1 Process</th>
                <th class="table-header">Inspection 1 Period</th>
                <th class="table-header">Inspection 1 Operator ID</th>
                <th class="table-header">Inspection 1 IP Address</th>
                <th class="table-header">Inspection 1 Start Date Time</th>
                <th class="table-header">Inspection 1 Finish Date Time</th>
                <th class="table-header">Inspection 1 Judgement</th>
                <th class="table-header">Inspection 1 ReadOp 1 Name</th>
                <th class="table-header">Inspection 1 ReadOp 1 Name Judgement</th>
                <th class="table-header">Inspection 1 ReadOp 2 Name</th>
                <th class="table-header">Inspection 1 ReadOp 2 Name Judgement</th>
                <th class="table-header">Inspection 1 ReadOp 3 Name</th>
                <th class="table-header">Inspection 1 ReadOp 3 Name Judgement</th>
                <th class="table-header">Inspection 1 ReadOp 4 Name</th>
                <th class="table-header">Inspection 1 ReadOp 4 Name Judgement</th>
                <th class="table-header">Inspection 1 Seal Rubber Detect Judgement</th>
                <th class="table-header">Inspection 1 F1 Judgement</th>
                <th class="table-header">Inspection 1 F2 Judgement</th>
                <th class="table-header">Inspection 1 F3 Judgement</th>
                <th class="table-header">Inspection 1 F4 Judgement</th>
                <th class="table-header">Inspection 1 F5 Judgement</th>
                <th class="table-header">Inspection 1 F6 Judgement</th>
                <th class="table-header">Inspection 1 Packing Check Code</th>
                <th class="table-header">Inspection 1 Packing Check Judgement</th>

                <!-- Inspection 2 -->
                <th class="table-header">Inspection 2 Process</th>
                <th class="table-header">Inspection 2 Period</th>
                <th class="table-header">Inspection 2 Operator ID</th>
                <th class="table-header">Inspection 2 IP Address</th>
                <th class="table-header">Inspection 2 Start Date Time</th>
                <th class="table-header">Inspection 2 Finish Date Time</th>
                <th class="table-header">Inspection 2 Judgement</th>
                <th class="table-header">Inspection 2 ReadOp 1 Name</th>
                <th class="table-header">Inspection 2 ReadOp 1 Name Judgement</th>
                <th class="table-header">Inspection 2 ReadOp 2 Name</th>
                <th class="table-header">Inspection 2 ReadOp 2 Name Judgement</th>
                <th class="table-header">Inspection 2 ReadOp 3 Name</th>
                <th class="table-header">Inspection 2 ReadOp 3 Name Judgement</th>
                <th class="table-header">Inspection 2 ReadOp 4 Name</th>
                <th class="table-header">Inspection 2 ReadOp 4 Name Judgement</th>
                <th class="table-header">Inspection 2 Seal Rubber Detect Judgement</th>
                <th class="table-header">Inspection 2 F1 Judgement</th>
                <th class="table-header">Inspection 2 F2 Judgement</th>
                <th class="table-header">Inspection 2 F3 Judgement</th>
                <th class="table-header">Inspection 2 F4 Judgement</th>
                <th class="table-header">Inspection 2 F5 Judgement</th>
                <th class="table-header">Inspection 2 F6 Judgement</th>
                <th class="table-header">Inspection 2 Packing Check Code</th>
                <th class="table-header">Inspection 2 Packing Check Judgement</th>

                <!-- Inspection 3 -->
                <th class="table-header">Inspection 3 Process</th>
                <th class="table-header">Inspection 3 Period</th>
                <th class="table-header">Inspection 3 Operator ID</th>
                <th class="table-header">Inspection 3 IP Address</th>
                <th class="table-header">Inspection 3 Start Date Time</th>
                <th class="table-header">Inspection 3 Finish Date Time</th>
                <th class="table-header">Inspection 3 Judgement</th>
                <th class="table-header">Inspection 3 ReadOp 1 Name</th>
                <th class="table-header">Inspection 3 ReadOp 1 Name Judgement</th>
                <th class="table-header">Inspection 3 ReadOp 2 Name</th>
                <th class="table-header">Inspection 3 ReadOp 2 Name Judgement</th>
                <th class="table-header">Inspection 3 ReadOp 3 Name</th>
                <th class="table-header">Inspection 3 ReadOp 3 Name Judgement</th>
                <th class="table-header">Inspection 3 ReadOp 4 Name</th>
                <th class="table-header">Inspection 3 ReadOp 4 Name Judgement</th>
                <th class="table-header">Inspection 3 Seal Rubber Detect Judgement</th>
                <th class="table-header">Inspection 3 F1 Judgement</th>
                <th class="table-header">Inspection 3 F2 Judgement</th>
                <th class="table-header">Inspection 3 F3 Judgement</th>
                <th class="table-header">Inspection 3 F4 Judgement</th>
                <th class="table-header">Inspection 3 F5 Judgement</th>
                <th class="table-header">Inspection 3 F6 Judgement</th>
                <th class="table-header">Inspection 3 Packing Check Code</th>
                <th class="table-header">Inspection 3 Packing Check Judgement</th>

                <!-- Inspection 4 -->
                <th class="table-header">Inspection 4 Process</th>
                <th class="table-header">Inspection 4 Period</th>
                <th class="table-header">Inspection 4 Operator ID</th>
                <th class="table-header">Inspection 4 IP Address</th>
                <th class="table-header">Inspection 4 Start Date Time</th>
                <th class="table-header">Inspection 4 Finish Date Time</th>
                <th class="table-header">Inspection 4 Judgement</th>
                <th class="table-header">Inspection 4 ReadOp 1 Name</th>
                <th class="table-header">Inspection 4 ReadOp 1 Name Judgement</th>
                <th class="table-header">Inspection 4 ReadOp 2 Name</th>
                <th class="table-header">Inspection 4 ReadOp 2 Name Judgement</th>
                <th class="table-header">Inspection 4 ReadOp 3 Name</th>
                <th class="table-header">Inspection 4 ReadOp 3 Name Judgement</th>
                <th class="table-header">Inspection 4 ReadOp 4 Name</th>
                <th class="table-header">Inspection 4 ReadOp 4 Name Judgement</th>
                <th class="table-header">Inspection 4 Seal Rubber Detect Judgement</th>
                <th class="table-header">Inspection 4 F1 Judgement</th>
                <th class="table-header">Inspection 4 F2 Judgement</th>
                <th class="table-header">Inspection 4 F3 Judgement</th>
                <th class="table-header">Inspection 4 F4 Judgement</th>
                <th class="table-header">Inspection 4 F5 Judgement</th>
                <th class="table-header">Inspection 4 F6 Judgement</th>
                <th class="table-header">Inspection 4 Packing Check Code</th>
                <th class="table-header">Inspection 4 Packing Check Judgement</th>

                <!-- Inspection 5 -->
                <th class="table-header">Inspection 5 Process</th>
                <th class="table-header">Inspection 5 Period</th>
                <th class="table-header">Inspection 5 Operator ID</th>
                <th class="table-header">Inspection 5 IP Address</th>
                <th class="table-header">Inspection 5 Start Date Time</th>
                <th class="table-header">Inspection 5 Finish Date Time</th>
                <th class="table-header">Inspection 5 Judgement</th>
                <th class="table-header">Inspection 5 ReadOp 1 Name</th>
                <th class="table-header">Inspection 5 ReadOp 1 Name Judgement</th>
                <th class="table-header">Inspection 5 ReadOp 2 Name</th>
                <th class="table-header">Inspection 5 ReadOp 2 Name Judgement</th>
                <th class="table-header">Inspection 5 ReadOp 3 Name</th>
                <th class="table-header">Inspection 5 ReadOp 3 Name Judgement</th>
                <th class="table-header">Inspection 5 ReadOp 4 Name</th>
                <th class="table-header">Inspection 5 ReadOp 4 Name Judgement</th>
                <th class="table-header">Inspection 5 Seal Rubber Detect Judgement</th>
                <th class="table-header">Inspection 5 F1 Judgement</th>
                <th class="table-header">Inspection 5 F2 Judgement</th>
                <th class="table-header">Inspection 5 F3 Judgement</th>
                <th class="table-header">Inspection 5 F4 Judgement</th>
                <th class="table-header">Inspection 5 F5 Judgement</th>
                <th class="table-header">Inspection 5 F6 Judgement</th>
                <th class="table-header">Inspection 5 Packing Check Code</th>
                <th class="table-header">Inspection 5 Packing Check Judgement</th>

                <!-- Inspection 6 -->
                <th class="table-header">Inspection 6 Process</th>
                <th class="table-header">Inspection 6 Period</th>
                <th class="table-header">Inspection 6 Operator ID</th>
                <th class="table-header">Inspection 6 IP Address</th>
                <th class="table-header">Inspection 6 Start Date Time</th>
                <th class="table-header">Inspection 6 Finish Date Time</th>
                <th class="table-header">Inspection 6 Judgement</th>
                <th class="table-header">Inspection 6 ReadOp 1 Name</th>
                <th class="table-header">Inspection 6 ReadOp 1 Name Judgement</th>
                <th class="table-header">Inspection 6 ReadOp 2 Name</th>
                <th class="table-header">Inspection 6 ReadOp 2 Name Judgement</th>
                <th class="table-header">Inspection 6 ReadOp 3 Name</th>
                <th class="table-header">Inspection 6 ReadOp 3 Name Judgement</th>
                <th class="table-header">Inspection 6 ReadOp 4 Name</th>
                <th class="table-header">Inspection 6 ReadOp 4 Name Judgement</th>
                <th class="table-header">Inspection 6 Seal Rubber Detect Judgement</th>
                <th class="table-header">Inspection 6 F1 Judgement</th>
                <th class="table-header">Inspection 6 F2 Judgement</th>
                <th class="table-header">Inspection 6 F3 Judgement</th>
                <th class="table-header">Inspection 6 F4 Judgement</th>
                <th class="table-header">Inspection 6 F5 Judgement</th>
                <th class="table-header">Inspection 6 F6 Judgement</th>
                <th class="table-header">Inspection 6 Packing Check Code</th>
                <th class="table-header">Inspection 6 Packing Check Judgement</th>

                <!-- Inspection 7 -->
                <th class="table-header">Inspection 7 Process</th>
                <th class="table-header">Inspection 7 Period</th>
                <th class="table-header">Inspection 7 Operator ID</th>
                <th class="table-header">Inspection 7 IP Address</th>
                <th class="table-header">Inspection 7 Start Date Time</th>
                <th class="table-header">Inspection 7 Finish Date Time</th>
                <th class="table-header">Inspection 7 Judgement</th>
                <th class="table-header">Inspection 7 ReadOp 1 Name</th>
                <th class="table-header">Inspection 7 ReadOp 1 Name Judgement</th>
                <th class="table-header">Inspection 7 ReadOp 2 Name</th>
                <th class="table-header">Inspection 7 ReadOp 2 Name Judgement</th>
                <th class="table-header">Inspection 7 ReadOp 3 Name</th>
                <th class="table-header">Inspection 7 ReadOp 3 Name Judgement</th>
                <th class="table-header">Inspection 7 ReadOp 4 Name</th>
                <th class="table-header">Inspection 7 ReadOp 4 Name Judgement</th>
                <th class="table-header">Inspection 7 Seal Rubber Detect Judgement</th>
                <th class="table-header">Inspection 7 F1 Judgement</th>
                <th class="table-header">Inspection 7 F2 Judgement</th>
                <th class="table-header">Inspection 7 F3 Judgement</th>
                <th class="table-header">Inspection 7 F4 Judgement</th>
                <th class="table-header">Inspection 7 F5 Judgement</th>
                <th class="table-header">Inspection 7 F6 Judgement</th>
                <th class="table-header">Inspection 7 Packing Check Code</th>
                <th class="table-header">Inspection 7 Packing Check Judgement</th>

                <!-- Inspection 8 -->
                <th class="table-header">Inspection 8 Process</th>
                <th class="table-header">Inspection 8 Period</th>
                <th class="table-header">Inspection 8 Operator ID</th>
                <th class="table-header">Inspection 8 IP Address</th>
                <th class="table-header">Inspection 8 Start Date Time</th>
                <th class="table-header">Inspection 8 Finish Date Time</th>
                <th class="table-header">Inspection 8 Finish Date</th>
                <th class="table-header">Inspection 8 Finish Time</th>
                <th class="table-header">Inspection 8 Judgement</th>
                <th class="table-header">Inspection 8 ReadOp 1 Name</th>
                <th class="table-header">Inspection 8 ReadOp 1 Name Judgement</th>
                <th class="table-header">Inspection 8 ReadOp 2 Name</th>
                <th class="table-header">Inspection 8 ReadOp 2 Name Judgement</th>
                <th class="table-header">Inspection 8 ReadOp 3 Name</th>
                <th class="table-header">Inspection 8 ReadOp 3 Name Judgement</th>
                <th class="table-header">Inspection 8 ReadOp 4 Name</th>
                <th class="table-header">Inspection 8 ReadOp 4 Name Judgement</th>
                <th class="table-header">Inspection 8 Seal Rubber Detect Judgement</th>
                <th class="table-header">Inspection 8 F1 Judgement</th>
                <th class="table-header">Inspection 8 F2 Judgement</th>
                <th class="table-header">Inspection 8 F3 Judgement</th>
                <th class="table-header">Inspection 8 F4 Judgement</th>
                <th class="table-header">Inspection 8 F5 Judgement</th>
                <th class="table-header">Inspection 8 F6 Judgement</th>
                <th class="table-header">Inspection 8 Packing Check Code</th>
                <th class="table-header">Inspection 8 Packing Check Judgement</th>

                <!--  -->
                <th class="table-header">Last Repair Card Number</th>
                <th class="table-header">Repair Result</th>
                <th class="table-header">Reset Supervisor ID</th>
                <th class="table-header">Reset Supervisor Name</th>
                <th class="table-header">Now Mode</th>
                <th class="table-header">Message Code</th>

                <!-- Infection -->
                <th class="table-header">Infection Start Date Time</th>
                <th class="table-header">Infection Finish Date Time</th>

                <!-- Check Infection -->
                <th class="table-header">Check Infection Shipped</th>
                <th class="table-header">Check Infection Completed</th>
                <th class="table-header">Check Infection Inspection</th>
                <th class="table-header">Check Infection Assy</th>
                <th class="table-header">Check Infection Sub</th>
                <th class="table-header">Check Infection Shikakari</th>
                <th class="table-header">Check Infection Parts</th>
                <th class="table-header">Check Infection Judgement</th>
                <th class="table-header">Check Infection Supervisor ID</th>
                <th class="table-header">Check Infection Supervisor Name</th>

                <!-- Inspection 9 -->
                <th class="table-header">Inspection 9 Process</th>
                <th class="table-header">Inspection 9 Period</th>
                <th class="table-header">Inspection 9 Operator ID</th>
                <th class="table-header">Inspection 9 IP Address</th>
                <th class="table-header">Inspection 9 Start Date Time</th>
                <th class="table-header">Inspection 9 Finish Date Time</th>
                <th class="table-header">Inspection 9 Judgement</th>
                <th class="table-header">Inspection 9 ReadOp 1 Name</th>
                <th class="table-header">Inspection 9 ReadOp 1 Name Judgement</th>
                <th class="table-header">Inspection 9 ReadOp 2 Name</th>
                <th class="table-header">Inspection 9 ReadOp 2 Name Judgement</th>
                <th class="table-header">Inspection 9 ReadOp 3 Name</th>
                <th class="table-header">Inspection 9 ReadOp 3 Name Judgement</th>
                <th class="table-header">Inspection 9 ReadOp 4 Name</th>
                <th class="table-header">Inspection 9 ReadOp 4 Name Judgement</th>
                <th class="table-header">Inspection 9 Seal Rubber Detect Judgement</th>
                <th class="table-header">Inspection 9 F1 Judgement</th>
                <th class="table-header">Inspection 9 F2 Judgement</th>
                <th class="table-header">Inspection 9 F3 Judgement</th>
        </tr>
</thead>
<tbody class="mb-0"
        id="list_of_no_good_viewer">';
    foreach ($list_of_no_good_viewer as &$row) {
        $c++;
        echo '<tr style="border:1px solid #ddd; border-collapse: collapse;">';

        echo '<td>' . $c . '</td>';
        echo '<td>' . $row['REPAIRCARDNUMBER'] . '</td>';
        echo '<td>' . $row['REPAIRSTARTDATETIME'] . '</td>';
        echo '<td>' . $row['RPAIRFINISHDATETIME'] . '</td>';
        echo '<td>' . $row['REPAIRDEVICEID'] . '</td>';
        echo '<td>' . $row['OPERATORID'] . '</td>';
        echo '<td>' . $row['REPAIRJUDGMENT'] . '</td>';
        echo '<td>' . $row['DISCOVERYPROCESS'] . '</td>';
        echo '<td>' . $row['NGCONTENT'] . '</td>';
        echo '<td>' . $row['NGCONTENTDETAIL'] . '</td>';
        echo '<td>' . $row['REPAIRCONTENT'] . '</td>';
        echo '<td>' . $row['OUTBREAKPROCESS'] . '</td>';
        echo '<td>' . $row['OUTBREAKOPERATOR'] . '</td>';
        echo '<td>' . $row['REGISTDATETIME'] . '</td>';
        echo '<td>' . $row['REGISTCAMPANYCODE'] . '</td>';
        echo '<td>' . $row['REGISTDEPARTMENTCODE'] . '</td>';
        echo '<td>' . $row['REGISTLINENAME'] . '</td>';
        echo '<td>' . $row['REGISTPROCESS'] . '</td>';
        echo '<td>' . $row['REGISTDEVICEID'] . '</td>';
        echo '<td>' . $row['IPADDRESS'] . '</td>';
        echo '<td>' . $row['REGISTOPERATORID'] . '</td>';
        echo '<td>' . $row['PARTSNAME'] . '</td>';
        echo '<td>' . $row['LOT'] . '</td>';
        echo '<td>' . $row['SERIAL'] . '</td>';
        echo '<td>' . $row['READNAME'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION1PROCESS'] . '</td>';
        echo '<td>' . $row['INSPECTION1PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION1OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION1IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION1STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION1FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION1JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION1READOP1NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION1READOP1NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION1READOP2NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION1READOP2NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION1READOP3NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION1READOP3NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION1READOP4NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION1READOP4NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION1SEALRUBBERDETECTJ'] . '</td>';
        echo '<td>' . $row['INSPECTION1F1JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION1F2JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION1F3JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION1F4JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION1F5JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION1F6JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION1PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION1PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION2PROCESS'] . '</td>';
        echo '<td>' . $row['INSPECTION2PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION2OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION2IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION2STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION2FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION2JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION2READOP1NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION2READOP1NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION2READOP2NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION2READOP2NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION2READOP3NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION2READOP3NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION2READOP4NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION2READOP4NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION2SEALRUBBERDETECTJ'] . '</td>';
        echo '<td>' . $row['INSPECTION2F1JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION2F2JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION2F3JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION2F4JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION2F5JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION2F6JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION2PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION2PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION3PROCESS'] . '</td>';
        echo '<td>' . $row['INSPECTION3PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION3OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION3IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION3STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION3FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION3JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION3READOP1NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION3READOP1NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION3READOP2NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION3READOP2NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION3READOP3NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION3READOP3NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION3READOP4NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION3READOP4NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION3SEALRUBBERDETECTJ'] . '</td>';
        echo '<td>' . $row['INSPECTION3F1JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION3F2JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION3F3JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION3F4JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION3F5JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION3F6JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION3PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION3PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION4PROCESS'] . '</td>';
        echo '<td>' . $row['INSPECTION4PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION4OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION4IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION4STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION4FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION4JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION4READOP1NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION4READOP1NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION4READOP2NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION4READOP2NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION4READOP3NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION4READOP3NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION4READOP4NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION4READOP4NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION4SEALRUBBERDETECTJ'] . '</td>';
        echo '<td>' . $row['INSPECTION4F1JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION4F2JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION4F3JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION4F4JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION4F5JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION4F6JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION4PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION4PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION5PROCESS'] . '</td>';
        echo '<td>' . $row['INSPECTION5PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION5OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION5IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION5STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION5FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION5JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION5READOP1NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION5READOP1NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION5READOP2NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION5READOP2NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION5READOP3NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION5READOP3NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION5READOP4NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION5READOP4NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION5SEALRUBBERDETECTJ'] . '</td>';
        echo '<td>' . $row['INSPECTION5F1JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION5F2JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION5F3JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION5F4JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION5F5JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION5F6JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION5PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION5PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION6PROCESS'] . '</td>';
        echo '<td>' . $row['INSPECTION6PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION6OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION6IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION6STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION6FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION6JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION6READOP1NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION6READOP1NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION6READOP2NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION6READOP2NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION6READOP3NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION6READOP3NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION6READOP4NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION6READOP4NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION6SEALRUBBERDETECTJ'] . '</td>';
        echo '<td>' . $row['INSPECTION6F1JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION6F2JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION6F3JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION6F4JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION6F5JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION6F6JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION6PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION6PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION7PROCESS'] . '</td>';
        echo '<td>' . $row['INSPECTION7PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION7OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION7IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION7STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION7FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION7JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION7READOP1NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION7READOP1NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION7READOP2NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION7READOP2NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION7READOP3NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION7READOP3NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION7READOP4NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION7READOP4NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION7SEALRUBBERDETECTJ'] . '</td>';
        echo '<td>' . $row['INSPECTION7F1JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION7F2JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION7F3JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION7F4JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION7F5JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION7F6JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION7PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION7PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION8PROCESS'] . '</td>';
        echo '<td>' . $row['INSPECTION8PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION8OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION8IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION8STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION8FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION8FINISHDATE'] . '</td>';
        echo '<td>' . $row['INSPECTION8FINISHTIME'] . '</td>';
        echo '<td>' . $row['INSPECTION8JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION8READOP1NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION8READOP1NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION8READOP2NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION8READOP2NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION8READOP3NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION8READOP3NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION8READOP4NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION8READOP4NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION8SEALRUBBERDETECTJ'] . '</td>';
        echo '<td>' . $row['INSPECTION8F1JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION8F2JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION8F3JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION8F4JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION8F5JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION8F6JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION8PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION8PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['LASTREPAIRCARDNUMBER'] . '</td>';
        echo '<td>' . $row['REPAIRRESULT'] . '</td>';
        echo '<td>' . $row['RESETSUPERVISORID'] . '</td>';
        echo '<td>' . $row['RESETSUPERVISORNAME'] . '</td>';
        echo '<td>' . $row['NOWMODE'] . '</td>';
        echo '<td>' . $row['MSGCODE'] . '</td>';
        echo '<td>' . $row['INFECTIONSTARTDATETIME'] . '</td>';
        echo '<td>' . $row['INFECTIONFINISHDATETIME'] . '</td>';
        // 
        echo '<td>' . $row['CHECKINFECTIONSHIPPED'] . '</td>';
        echo '<td>' . $row['CHECKINFECTIONCOMPLETED'] . '</td>';
        echo '<td>' . $row['CHECKINFECTIONINSPECTION'] . '</td>';
        echo '<td>' . $row['CHECKINFECTIONASSY'] . '</td>';
        echo '<td>' . $row['CHECKINFECTIONSUB'] . '</td>';
        echo '<td>' . $row['CHECKINFECTIONSHIKAKARI'] . '</td>';
        echo '<td>' . $row['CHECKINFECTIONPARTS'] . '</td>';
        echo '<td>' . $row['CHECKINFECTIONJUDGMENT'] . '</td>';
        echo '<td>' . $row['CHECKINFECTIONSUPERVISORID'] . '</td>';
        echo '<td>' . $row['CHECKINFECTIONSUPERVISORNAME'] . '</td>';
        //
        echo '<td>' . $row['INSPECTION9PROCESS'] . '</td>';
        echo '<td>' . $row['INSPECTION9PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION9OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION9IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION9STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION9FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION9JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION9READOP1NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION9READOP1NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION9READOP2NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION9READOP2NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION9READOP3NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION9READOP3NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION9READOP4NAME'] . '</td>';
        echo '<td>' . $row['INSPECTION9READOP4NAMEJ'] . '</td>';
        echo '<td>' . $row['INSPECTION9SEALRUBBERDETECTJ'] . '</td>';
        echo '<td>' . $row['INSPECTION9F1JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION9F2JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION9F3JUDGMENT'] . '</td>';

        echo '</tr>';
    }
    echo '</tbody>';
}

if ($method == 'get_inspection_details_good') {
    $shift = get_shift($server_time);
    $registlinename = $_GET['registlinename'];
    // $shift_group = $_GET['shift_group'];

    // $shift = 'DS';
    // $registlinename = 'DAIHATSU_30';
    // $shift_group = 'B';

    $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);

    $search_arr = array(
        'shift' => $shift,
        'registlinename' => $registlinename,
        'ircs_line_data_arr' => $ircs_line_data_arr,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time
    );

    $list_of_good_viewer = get_rows_overall_g($search_arr, $conn_ircs);

    $c = 0;

    echo '<thead>
        <tr>
                <th rowspan="2" style="background: #B071CD; color: #fff; vertical-align: middle; font-weight: normal;">#</th>
                <th colspan="11" style="background: #B071CD; color: #fff; font-weight: normal;">Register</th>
                <th colspan="8" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 1</th>
                <th colspan="8" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 2</th>
                <th colspan="8" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 3</th>
                <th colspan="8" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 4</th>
                <th colspan="8" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 5</th>
                <th colspan="8" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 6</th>
                <th colspan="8" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 7</th>
                <th colspan="8" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 8</th>
                <th colspan="8" style="background: #B071CD; color: #fff; font-weight: normal;"></th>
                <th colspan="8" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 9</th>
                <th colspan="6" style="background: #B071CD; color: #fff; font-weight: normal;">Inspection 10</th>
        </tr>
        <tr>
                <!-- register -->
                <th class="table-header">Date Time</th>
                <th class="table-header">Company Code</th>
                <th class="table-header">Department</th>
                <th class="table-header">Line Name</th>
                <th class="table-header">Process</th>
                <th class="table-header">Device ID</th>
                <th class="table-header">IP Address</th>
                <th class="table-header">Operator ID</th>
                <th class="table-header">Parts Name</th>
                <th class="table-header">Lot No.</th>
                <th class="table-header">Serial No.</th>

                <!-- inspection 1 -->
                <th class="table-header">Period</th>
                <th class="table-header">Operator ID</th>
                <th class="table-header">IP Address</th>
                <th class="table-header">Start Date/Time</th>
                <th class="table-header">Finished Date/Time</th>
                <th class="table-header">Judgement</th>
                <th class="table-header">Packing Check Code</th>
                <th class="table-header">Packing Check Judgement</th>

                <!-- inspection 2 -->
                <th class="table-header">Period</th>
                <th class="table-header">Operator ID</th>
                <th class="table-header">IP Address</th>
                <th class="table-header">Start Date/Time</th>
                <th class="table-header">Finished Date/Time</th>
                <th class="table-header">Judgement</th>
                <th class="table-header">Packing Check Code</th>
                <th class="table-header">Packing Check Judgement</th>

                <!-- inspection 3 -->
                <th class="table-header">Period</th>
                <th class="table-header">Operator ID</th>
                <th class="table-header">IP Address</th>
                <th class="table-header">Start Date/Time</th>
                <th class="table-header">Finished Date/Time</th>
                <th class="table-header">Judgement</th>
                <th class="table-header">Packing Check Code</th>
                <th class="table-header">Packing Check Judgement</th>

                <!-- inspection 4 -->
                <th class="table-header">Period</th>
                <th class="table-header">Operator ID</th>
                <th class="table-header">IP Address</th>
                <th class="table-header">Start Date/Time</th>
                <th class="table-header">Finished Date/Time</th>
                <th class="table-header">Judgement</th>
                <th class="table-header">Packing Check Code</th>
                <th class="table-header">Packing Check Judgement</th>

                <!-- inspection 5 -->
                <th class="table-header">Period</th>
                <th class="table-header">Operator ID</th>
                <th class="table-header">IP Address</th>
                <th class="table-header">Start Date/Time</th>
                <th class="table-header">Finished Date/Time</th>
                <th class="table-header">Judgement</th>
                <th class="table-header">Packing Check Code</th>
                <th class="table-header">Packing Check Judgement</th>

                <!-- inspection 6 -->
                <th class="table-header">Period</th>
                <th class="table-header">Operator ID</th>
                <th class="table-header">IP Address</th>
                <th class="table-header">Start Date/Time</th>
                <th class="table-header">Finished Date/Time</th>
                <th class="table-header">Judgement</th>
                <th class="table-header">Packing Check Code</th>
                <th class="table-header">Packing Check Judgement</th>

                <!-- inspection 7 -->
                <th class="table-header">Period</th>
                <th class="table-header">Operator ID</th>
                <th class="table-header">IP Address</th>
                <th class="table-header">Start Date/Time</th>
                <th class="table-header">Finished Date/Time</th>
                <th class="table-header">Judgement</th>
                <th class="table-header">Packing Check Code</th>
                <th class="table-header">Packing Check Judgement</th>

                <!-- inspection 8 -->
                <th class="table-header">Period</th>
                <th class="table-header">Operator ID</th>
                <th class="table-header">IP Address</th>
                <th class="table-header">Start Date/Time</th>
                <th class="table-header">Finished Date/Time</th>
                <th class="table-header">Judgement</th>
                <th class="table-header">Packing Check Code</th>
                <th class="table-header">Packing Check Judgement</th>

                <!--  -->
                <th class="table-header">Last Repair Card Number</th>
                <th class="table-header">Repair Result</th>
                <th class="table-header">Reset Supervisor ID</th>
                <th class="table-header">Reset Supervisor Name</th>
                <th class="table-header">Now Mode</th>
                <th class="table-header">Message Code</th>
                <th class="table-header">Final Inspection Name</th>
                <th class="table-header">Final Inspection Judgement</th>

                <!-- inspection 9 -->
                <th class="table-header">Period</th>
                <th class="table-header">Operator ID</th>
                <th class="table-header">IP Address</th>
                <th class="table-header">Start Date/Time</th>
                <th class="table-header">Finished Date/Time</th>
                <th class="table-header">Judgement</th>
                <th class="table-header">Packing Check Code</th>
                <th class="table-header">Packing Check Judgement</th>

                <!-- inspection 10 -->
                <th class="table-header">Period</th>
                <th class="table-header">Operator ID</th>
                <th class="table-header">IP Address</th>
                <th class="table-header">Start Date/Time</th>
                <th class="table-header">Finished Date/Time</th>
                <th class="table-header">Judgement</th>
        </tr>
</thead>

<tbody class="mb-0"
        id="list_of_good_viewer">';

    foreach ($list_of_good_viewer as &$row) {
        $c++;
        echo '<tr>';

        echo '<td style="text-align:center;">' . $c . '</td>';
        echo '<td>' . $row['REGISTDATETIME'] . '</td>';
        echo '<td>' . $row['REGISTCAMPANYCODE'] . '</td>';
        echo '<td>' . $row['REGISTDEPARTMENTCODE'] . '</td>';
        echo '<td>' . $row['REGISTLINENAME'] . '</td>';
        echo '<td>' . $row['REGISTPROCESS'] . '</td>';
        echo '<td>' . $row['REGISTDEVICEID'] . '</td>';
        echo '<td>' . $row['IPADDRESS'] . '</td>';
        echo '<td>' . $row['REGISTOPERATORID'] . '</td>';
        echo '<td>' . $row['PARTSNAME'] . '</td>';
        echo '<td>' . $row['LOT'] . '</td>';
        echo '<td>' . $row['SERIAL'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION1PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION1OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION1IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION1STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION1FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION1JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION1PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION1PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION2PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION2OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION2IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION2STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION2FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION2JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION2PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION2PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION3PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION3OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION3IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION3STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION3FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION3JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION3PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION3PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION4PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION4OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION4IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION4STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION4FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION4JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION4PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION4PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION5PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION5OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION5IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION5STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION5FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION5JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION5PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION5PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION6PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION6OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION6IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION6STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION6FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION6JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION6PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION6PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION7PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION7OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION7IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION7STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION7FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION7JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION7PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION7PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION8PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION8OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION8IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION8STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION8FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION8JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION8PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION8PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['LASTREPAIRCARDNUMBER'] . '</td>';
        echo '<td>' . $row['REPAIRRESULT'] . '</td>';
        echo '<td>' . $row['RESETSUPERVISORID'] . '</td>';
        echo '<td>' . $row['RESETSUPERVISORNAME'] . '</td>';
        echo '<td>' . $row['NOWMODE'] . '</td>';
        echo '<td>' . $row['MSGCODE'] . '</td>';
        echo '<td>' . $row['FINALINSPECTIONNAME'] . '</td>';
        echo '<td>' . $row['FINALINSPECTIONJUDGMENT'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION9PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION9OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION9IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION9STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION9FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION9JUDGMENT'] . '</td>';
        echo '<td>' . $row['INSPECTION9PACKINGCHECKCODE'] . '</td>';
        echo '<td>' . $row['INSPECTION9PACKINGCHECKJ'] . '</td>';
        // 
        echo '<td>' . $row['INSPECTION10PERIOD'] . '</td>';
        echo '<td>' . $row['INSPECTION10OPERATORID'] . '</td>';
        echo '<td>' . $row['INSPECTION10IPADDRESS'] . '</td>';
        echo '<td>' . $row['INSPECTION10STARTDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION10FINISHDATETIME'] . '</td>';
        echo '<td>' . $row['INSPECTION10JUDGMENT'] . '</td>';

        echo '</tr>';
    }

    echo '</tbody>';
}

function get_ng_cell_color($process, $actual_output)
{
    $target_output = 0;

    $row_class_arr = array('bg-danger', 'bg-default');
    $row_class = "";

    if ($process != 'Hour') {
        if ($actual_output > $target_output) {
            $row_class = $row_class_arr[0];
        } else {
            $row_class = $row_class_arr[1];
        }
    }
    return $row_class;
}

if ($method == 'get_ng_hourly_output_per_process') {
    $registlinename = $_GET['registlinename'];
    // $registlinename = 'DAIHATSU_30';

    $hourly_output_hour_ds_array = array('06' => "06", '07' => "07", '08' => "08", '09' => "09", '10' => "10", '11' => "11", '12' => "12", '13' => "13", '14' => "14", '15' => "15", '16' => "16", '17' => "17");
    $hourly_output_hour_ns_array = array('18' => "18", '19' => "19", '20' => "20", '21' => "21", '22' => "22", '23' => "23", '00' => "00", '01' => "01", '02' => "02", '03' => "03", '04' => "04", '05' => "05");
    $hourly_output_hour_array = $hourly_output_hour_ds_array + $hourly_output_hour_ns_array;

    $insp_overall_ng = array();

    // Fetch processes and their corresponding IP addresses
    $processesAndIpAddresses = getIpAddressesFromDatabase($registlinename, $conn_pcad);

    if (!empty($processesAndIpAddresses)) {
        foreach ($processesAndIpAddresses as $processData) {
            $process = $processData['process'];
            $ipaddresscolumn = $processData['ipaddresscolumn'];
            $ipAddresses = $processData['ipAddresses'];

            $hourly_output_summary_process_array = array();

            $judgmentColumnNG2 = $processData['judgement'];
            $date_column = $processData['finishdatetime'];

            $search_arr = array(
                'registlinename' => $registlinename,
                'server_date_only' => $server_date_only,
                'server_date_only_yesterday' => $server_date_only_yesterday,
                'server_date_only_tomorrow' => $server_date_only_tomorrow,
                'server_time' => $server_time
            );

            // switch ($process) {
            //     case "Dimension":
            //         $date_column = "INSPECTION1FINISHDATETIME";
            //         break;
            //     case "Electric":
            //         $date_column = "INSPECTION2FINISHDATETIME";
            //         break;
            //     case "Visual":
            //         $date_column = "INSPECTION3FINISHDATETIME";
            //         break;
            //     case "Assurance":
            //         $date_column = "INSPECTION4FINISHDATETIME";
            //         break;
            //     case "Components":
            //         $date_column = "INSPECTION3FINISHDATETIME";
            //         break;
            //     case "Fuse Checking":
            //         $date_column = "INSPECTION4FINISHDATETIME";
            //         break;
            //     default:
            //         break;
            // }

            $processDetailsNG = array(
                'date_column' => $date_column,
                'ipAddressColumn' => $ipaddresscolumn,
                'judgmentColumn' => $judgmentColumnNG2,
                'ipAddresses' => $ipAddresses
            );

            $p_ng = count_actual_ng_hourly_output_process($search_arr, $conn_ircs, $conn_pcad, $processDetailsNG);

            $hourly_output_summary_process_array["process"] = $process;

            foreach ($hourly_output_hour_array as &$hour_row) {
                $hourly_output_summary_process_array[$hour_row] = 0;
            }

            foreach ($p_ng as $row) {
                $hourly_output_summary_process_array[$row["HOUR"]] = $row["TOTAL"];
            }

            $insp_overall_ng[] = $hourly_output_summary_process_array;
        }

        $hour_label_array = array("process" => "Hour");
        // $overall_hour_label_array = array_merge($hour_label_array, $hourly_output_hour_array);
        $overall_hour_label_array = $hour_label_array + $hourly_output_hour_array;

        $insp_overall_ng[] = $overall_hour_label_array;
    }

    // echo '<table><tbody>';

    foreach ($insp_overall_ng as &$row) {
        $table_cell_type = "";
        if ($row['process'] == 'Hour') {
            $table_cell_type = "th";
        } else {
            $table_cell_type = "td";
        }
        echo '<tr>';
        echo '<th>' . $row['process'] . '</th>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['06'])) . '">' . $row['06'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['07'])) . '">' . $row['07'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['08'])) . '">' . $row['08'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['09'])) . '">' . $row['09'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['10'])) . '">' . $row['10'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['11'])) . '">' . $row['11'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['12'])) . '">' . $row['12'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['13'])) . '">' . $row['13'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['14'])) . '">' . $row['14'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['15'])) . '">' . $row['15'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['16'])) . '">' . $row['16'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['17'])) . '">' . $row['17'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['18'])) . '">' . $row['18'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['19'])) . '">' . $row['19'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['20'])) . '">' . $row['20'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['21'])) . '">' . $row['21'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['22'])) . '">' . $row['22'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['23'])) . '">' . $row['23'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['00'])) . '">' . $row['00'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['01'])) . '">' . $row['01'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['02'])) . '">' . $row['02'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['03'])) . '">' . $row['03'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['04'])) . '">' . $row['04'] . '</' . $table_cell_type . '>';
        echo '<' . $table_cell_type . ' class="' . get_ng_cell_color($row['process'], intval($row['05'])) . '">' . $row['05'] . '</' . $table_cell_type . '>';
        echo '</tr>';
    }

    // echo '</tbody></table>';

    // echo json_encode($hourly_output_hour_array, JSON_FORCE_OBJECT);
    // echo json_encode($insp_overall_g, JSON_FORCE_OBJECT);
}

if ($method == 'ng_graph') {
    $registlinename = $_GET['registlinename'];
    // $registlinename = 'DAIHATSU_30';

    $hour_6_array = array();
    $hour_7_array = array();
    $hour_8_array = array();
    $hour_9_array = array();
    $hour_10_array = array();
    $hour_11_array = array();
    $hour_12_array = array();
    $hour_13_array = array();
    $hour_14_array = array();
    $hour_15_array = array();
    $hour_16_array = array();
    $hour_17_array = array();
    $hour_18_array = array();
    $hour_19_array = array();
    $hour_20_array = array();
    $hour_21_array = array();
    $hour_22_array = array();
    $hour_23_array = array();
    $hour_0_array = array();
    $hour_1_array = array();
    $hour_2_array = array();
    $hour_3_array = array();
    $hour_4_array = array();
    $hour_5_array = array();

    $hourly_output_hour_ds_array = array("06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "|");
    $hourly_output_hour_ns_array = array("18", "19", "20", "21", "22", "23", "00", "01", "02", "03", "04", "05");
    $hourly_output_hour_array = array_merge($hourly_output_hour_ds_array, $hourly_output_hour_ns_array);

    $hourly_output_summary_array = array();

    $insp_overall_ng = array();

    // Fetch processes and their corresponding IP addresses
    $processesAndIpAddresses = getIpAddressesFromDatabase($registlinename, $conn_pcad);

    if (!empty($processesAndIpAddresses)) {
        foreach ($processesAndIpAddresses as $processData) {
            $process = $processData['process'];
            $ipaddresscolumn = $processData['ipaddresscolumn'];
            $ipAddresses = $processData['ipAddresses'];

            $hourly_output_summary_process_array = array();

            $judgmentColumnNG2 = $processData['judgement'];
            $date_column = $processData['finishdatetime'];

            $search_arr = array(
                'registlinename' => $registlinename,
                'server_date_only' => $server_date_only,
                'server_date_only_yesterday' => $server_date_only_yesterday,
                'server_date_only_tomorrow' => $server_date_only_tomorrow,
                'server_time' => $server_time
            );

            // switch ($process) {
            //     case "Dimension":
            //         $date_column = "INSPECTION1FINISHDATETIME";
            //         break;
            //     case "Electric":
            //         $date_column = "INSPECTION2FINISHDATETIME";
            //         break;
            //     case "Visual":
            //         $date_column = "INSPECTION3FINISHDATETIME";
            //         break;
            //     case "Assurance":
            //         $date_column = "INSPECTION4FINISHDATETIME";
            //         break;
            //     case "Components":
            //         $date_column = "INSPECTION3FINISHDATETIME";
            //         break;
            //     case "Fuse Checking":
            //         $date_column = "INSPECTION4FINISHDATETIME";
            //         break;
            //     default:
            //         break;
            // }

            $processDetailsNG = array(
                'date_column' => $date_column,
                'ipAddressColumn' => $ipaddresscolumn,
                'judgmentColumn' => $judgmentColumnNG2,
                'ipAddresses' => $ipAddresses
            );

            $p_ng = count_actual_ng_hourly_output_process($search_arr, $conn_ircs, $conn_pcad, $processDetailsNG);

            foreach ($hourly_output_hour_array as &$hour_row) {
                $hourly_output_summary_process_array[$hour_row] = 0;
            }

            foreach ($p_ng as $row) {
                switch ($row["HOUR"]) {
                    case "06":
                        $hour_6_array[] = $row["TOTAL"];
                        // $hour_6 += intval($row["TOTAL"]);
                        break;
                    case "07":
                        $hour_7_array[] = $row["TOTAL"];
                        break;
                    case "08":
                        $hour_8_array[] = $row["TOTAL"];
                        break;
                    case "09":
                        $hour_9_array[] = $row["TOTAL"];
                        break;
                    case "10":
                        $hour_10_array[] = $row["TOTAL"];
                        break;
                    case "11":
                        $hour_11_array[] = $row["TOTAL"];
                        break;
                    case "12":
                        $hour_12_array[] = $row["TOTAL"];
                        break;
                    case "13":
                        $hour_13_array[] = $row["TOTAL"];
                        break;
                    case "14":
                        $hour_14_array[] = $row["TOTAL"];
                        break;
                    case "15":
                        $hour_15_array[] = $row["TOTAL"];
                        break;
                    case "16":
                        $hour_16_array[] = $row["TOTAL"];
                        break;
                    case "17":
                        $hour_17_array[] = $row["TOTAL"];
                        break;
                    case "18":
                        $hour_18_array[] = $row["TOTAL"];
                        break;
                    case "19":
                        $hour_19_array[] = $row["TOTAL"];
                        break;
                    case "20":
                        $hour_20_array[] = $row["TOTAL"];
                        break;
                    case "21":
                        $hour_21_array[] = $row["TOTAL"];
                        break;
                    case "22":
                        $hour_22_array[] = $row["TOTAL"];
                        break;
                    case "23":
                        $hour_23_array[] = $row["TOTAL"];
                        break;
                    case "00":
                        $hour_0_array[] = $row["TOTAL"];
                        break;
                    case "01":
                        $hour_1_array[] = $row["TOTAL"];
                        break;
                    case "02":
                        $hour_2_array[] = $row["TOTAL"];
                        break;
                    case "03":
                        $hour_3_array[] = $row["TOTAL"];
                        break;
                    case "04":
                        $hour_4_array[] = $row["TOTAL"];
                        break;
                    case "05":
                        $hour_5_array[] = $row["TOTAL"];
                        break;
                    default:
                        break;
                }
            }
        }

        $hourly_output_summary_array[] = array_sum($hour_6_array);
        $hourly_output_summary_array[] = array_sum($hour_7_array);
        $hourly_output_summary_array[] = array_sum($hour_8_array);
        $hourly_output_summary_array[] = array_sum($hour_9_array);
        $hourly_output_summary_array[] = array_sum($hour_10_array);
        $hourly_output_summary_array[] = array_sum($hour_11_array);
        $hourly_output_summary_array[] = array_sum($hour_12_array);
        $hourly_output_summary_array[] = array_sum($hour_13_array);
        $hourly_output_summary_array[] = array_sum($hour_14_array);
        $hourly_output_summary_array[] = array_sum($hour_15_array);
        $hourly_output_summary_array[] = array_sum($hour_16_array);
        $hourly_output_summary_array[] = array_sum($hour_17_array);
        $hourly_output_summary_array[] = array_sum($hour_18_array);
        $hourly_output_summary_array[] = array_sum($hour_19_array);
        $hourly_output_summary_array[] = array_sum($hour_20_array);
        $hourly_output_summary_array[] = array_sum($hour_21_array);
        $hourly_output_summary_array[] = array_sum($hour_22_array);
        $hourly_output_summary_array[] = array_sum($hour_23_array);
        $hourly_output_summary_array[] = array_sum($hour_0_array);
        $hourly_output_summary_array[] = array_sum($hour_1_array);
        $hourly_output_summary_array[] = array_sum($hour_2_array);
        $hourly_output_summary_array[] = array_sum($hour_3_array);
        $hourly_output_summary_array[] = array_sum($hour_4_array);
        $hourly_output_summary_array[] = array_sum($hour_5_array);
    }

    $data[] = $hourly_output_summary_array;
    $data[] = $hourly_output_hour_array;

    echo json_encode($data);
}

oci_close($conn_ircs);
$conn_pcad = NULL;
?>