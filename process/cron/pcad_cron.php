<?php
include '../server_date_time.php';
require '../conn/pcad.php';
require '../conn/ircs.php';
require '../conn/emp_mgt.php';
include '../lib/inspection_output.php';
include '../lib/st.php';
include '../lib/emp_mgt.php';
include '../lib/main.php';

$method = $_POST['method'];

if ($method == 'update_all_plan_pending') {
    $req_count = 0;
    $message = 'success';

    $sql = "SELECT * FROM t_plan WHERE Status = 'Pending' AND is_paused = 'NO'";
    $stmt = $conn_pcad->prepare($sql);
    $stmt->execute();

    $shift = get_shift($server_time);
    $day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
    $day_tomorrow = date('Y-m-d',(strtotime('+1 day', strtotime($day))));

    $updates = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $registlinename = $row['IRCS_Line'];
        $line_no = $row['Line'];
        $shift_group = $row['group'];
    
        // Logic for date and shift checking
        $start_plan_date = date('Y-m-d', strtotime($row['datetime_DB']));
        $start_plan_time = date('H:i:s', strtotime($row['datetime_DB']));
        $shift_pending = get_shift_end_plan($start_plan_time);
        $start_plan_date_pending = get_day_end_plan($start_plan_date, $start_plan_time, $server_time, $server_date_only, $server_date_only_yesterday);

        if ($start_plan_date == $start_plan_date_pending && $shift == $shift_pending) {
            $ircs_line_data_arr = get_ircs_line_data($registlinename, $line_no, $conn_pcad);
    
            $search_arr = array(
                'day' => $day,
                'day_tomorrow' => $day_tomorrow,
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
                'server_time' => $server_time,
                'opt' => 1
            );

            // Variables for accounting efficiency
            $wt_x_mp_arr = get_wt_x_mp_arr($search_arr, $server_time, $conn_emp_mgt);
            $wt_x_mp = $wt_x_mp_arr['wt_x_mp'];
            $total_st_per_line = get_total_st_per_line($search_arr, $conn_ircs, $conn_pcad);

            // Variables for yield and ppm
            $output = count_overall_g($search_arr, $conn_ircs);
            $ng = count_overall_ng($search_arr, $conn_ircs, $conn_pcad);

            // Get Final Actual Varibles

            // Yield
            $yield_actual = compute_yield($output, $ng);

            // PPM
            $ppm_actual = compute_ppm($ng, $output);

            // Accounting Efficiency
            $acc_eff_actual = compute_accounting_efficiency($total_st_per_line, $wt_x_mp);

            // Collect data for batch update
            $updates[] = [
                'IRCS_Line' => $registlinename,
                'line_no' => $line_no,
                'yield_actual' => $yield_actual,
                'ppm_actual' => $ppm_actual,
                'acc_eff_actual' => $acc_eff_actual,
            ];
        }
    }

    // Execute batch update if updates are collected
    if (!empty($updates)) {
        $sql = "UPDATE t_plan SET yield_actual = :yield_actual, 
            ppm_actual = :ppm_actual, acc_eff_actual = :acc_eff_actual 
            WHERE IRCS_Line = :IRCS_Line AND Line = :line_no AND Status = 'Pending'";
        $stmt = $conn_pcad->prepare($sql);
    
        foreach ($updates as $update) {
            $stmt->bindParam(':yield_actual', $update['yield_actual']);
            $stmt->bindParam(':ppm_actual', $update['ppm_actual']);
            $stmt->bindParam(':acc_eff_actual', $update['acc_eff_actual']);
            $stmt->bindParam(':IRCS_Line', $update['IRCS_Line']);
            $stmt->bindParam(':line_no', $update['line_no']);
            if (!$stmt->execute()) {
                error_log(print_r($stmt->errorInfo(), true));
                $message = 'failed';
            }

            $req_count++;
        }
    }

    $response_arr = [
        "req_count" => $req_count,
        "message" => $message
    ];
    
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response_arr);
}

oci_close($conn_ircs);
$conn_emp_mgt = NULL;
$conn_pcad = NULL;
