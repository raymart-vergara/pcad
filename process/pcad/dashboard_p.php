<?php
include 'process/server_date_time.php';
require 'process/conn/emp_mgt.php';
include 'process/lib/emp_mgt.php';
require 'process/conn/pcad.php';

$opt = $_GET['opt'];

$day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
$shift = get_shift($server_time);

if ($opt == 2) {
    if (isset($_GET['day']) && isset($_GET['shift'])) {
        $day = $_GET['day'];
        $shift = $_GET['shift'];
    }
}

$server_date_only = $day;

$registlinename = $_GET['registlinename']; // IRCS LINE NAME (PCS)
$line_no = $_GET['line_no']; // IRCS LINE NO
$shift_group = '';

$processing = false;

if (isset($_GET['registlinename'])) {
    $registlinename = $_GET['registlinename'];

    $q = "SELECT * FROM t_plan WHERE IRCS_Line = :registlinename AND Line = :line_no";

    switch($opt) {
        case 1:
            $q .= " AND Status = 'Pending'";
            break;
        case 2:
            $start_date = '';
            $end_date = '';

            if ($shift == 'DS') {
                $start_date = date('Y-m-d H:i:s',(strtotime("$day 06:00:00")));
                $end_date = date('Y-m-d H:i:s',(strtotime("$day 17:59:59")));
            } else if ($shift == 'NS') {
                $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
                $start_date = date('Y-m-d H:i:s',(strtotime("$day 18:00:00")));
                $end_date = date('Y-m-d H:i:s',(strtotime("$day_tomorrow 05:59:59")));
            }

            $q .= " AND Status = 'Done' AND (datetime_DB >= '$start_date' AND datetime_DB <= '$end_date')";
            break;
        default:
            $q .= " AND Status = 'Pending'";
            break;
    }

    $stmt = $conn_pcad->prepare($q, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->bindParam(':registlinename', $registlinename);
    $stmt->bindParam(':line_no', $line_no);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($res) {
        $started = $res['actual_start_DB'];
        $takt = $res['takt_secs_DB'];
        $last_takt = $res['last_takt_DB'];
        $last_update_DB = $res['last_update_DB'];
        $is_paused = $res['is_paused'];
        $line_no = $res['Line'];
        $shift_group = $res['group'];
        $Carmodel = $res['Carmodel'];
        
        $start_bal_delay = $res['start_bal_delay'];
        $work_time_plan = $res['work_time_plan'];
        $daily_plan = $res['daily_plan'];

        // Plan
        $plan_target = $res['Target'];
        $plan_actual = $res['Actual_Target'];
        $plan_gap = $res['Remaining_Target'];

        // Accounting Efficiency
        $acc_eff = $res['acc_eff'];
        $acc_eff_actual = $res['acc_eff_actual'];
        if (empty($acc_eff_actual)) {
            $acc_eff_actual = 0;
        }
        $acc_eff_gap = ((floatval($acc_eff_actual) / 100) - (intval($acc_eff) / 100)) * 100;

        // Yield
        $yield_target = $res['yield_target'];
        $yield_actual = $res['yield_actual'];
        if (empty($yield_actual)) {
            $yield_actual = 0;
        }

        // PPM
        $ppm_target = $res['ppm_target'];
        $ppm_actual = $res['ppm_actual'];
        if (empty($ppm_actual)) {
            $ppm_actual = 0;
        }

        // Hourly Output

        // m_ircs_line Data

        $sql = "SELECT line_no, andon_line, final_process FROM m_ircs_line 
                WHERE ircs_line = :registlinename AND line_no = :line_no";
        $stmt = $conn_pcad->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->bindParam(':registlinename', $registlinename);
        $stmt->bindParam(':line_no', $line_no);
        $stmt->execute();
        $line_data = $stmt->fetch(PDO::FETCH_ASSOC);
        $line_no = $line_data['line_no'];
        $andon_line = $line_data['andon_line'];
        $final_process = $line_data['final_process'];


        if ($res) {
            $processing = true;
        }
        $secs_diff = strtotime(date('Y-m-d H:i:s')) - strtotime($last_update_DB);
        if ($takt > 0) {
            $added_takt_plan = floor($secs_diff / $takt);
        } else {
            $added_takt_plan = 0;
        }
    } else {
        $started = '';
        $takt = 270;
        $last_takt = '';
        $last_update_DB = '';
        $is_paused = 'YES';
        $line_no = '';
        $shift_group = '';
        $Carmodel = '';
        $yield_target = 90;
        $ppm_target = 9000;
        $acc_eff = 70;
        $start_bal_delay = 0;
        $work_time_plan = 450;
        $daily_plan = 100;

        $added_takt_plan = 0;
        $andon_line = '';
        $final_process = '';
    }
}

// Employee Management System Data
$dept_pd = 'PD2';
$dept_qa = 'QA';
$section_pd = get_section($line_no, $conn_emp_mgt);
$section_qa = get_section($line_no, $conn_emp_mgt);
// $section_qa = 'QA';
?>