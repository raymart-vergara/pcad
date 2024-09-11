<?php
include 'process/server_date_time.php';
require 'process/conn/emp_mgt.php';
include 'process/lib/emp_mgt.php';
require 'process/conn/pcad.php';

$registlinename = $_GET['registlinename']; // IRCS LINE NAME (PCS)
$line_no = $_GET['line_no']; // IRCS LINE NO
$shift_group = '';

$processing = false;

if (isset($_GET['registlinename'])) {
    $registlinename = $_GET['registlinename'];
    $q = "SELECT * FROM t_plan WHERE IRCS_Line = :registlinename AND Line = :line_no AND Status = 'Pending'";
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
        $yield_target = $res['yield_target'];
        $ppm_target = $res['ppm_target'];
        $acc_eff = $res['acc_eff'];
        $start_bal_delay = $res['start_bal_delay'];
        $work_time_plan = $res['work_time_plan'];
        $daily_plan = $res['daily_plan'];


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

$dept_pd = 'PD2';
$dept_qa = 'QA';
$section_pd = get_section($line_no, $conn_emp_mgt);
$section_qa = get_section($line_no, $conn_emp_mgt);
// $section_qa = 'QA';
$shift = get_shift($server_time);
?>