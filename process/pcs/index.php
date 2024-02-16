<?php
include 'process/server_date_time.php';
require 'process/conn/emp_mgt.php';
include 'process/lib/emp_mgt.php';
require 'process/conn/pcad.php';

// $line_no = '2132';
// $line_no = $_GET['line_no'];
// $registlinename = '';
$registlinename = $_GET['registlinename']; // IRCS LINE (PCS)

$processing = false;

if (isset($_GET['registlinename'])) {
    $registlinename = $_GET['registlinename'];
    $q = "SELECT * FROM t_plan WHERE IRCS_Line = :registlinename AND Status = 'Pending'";
    $stmt = $conn_pcad->prepare($q);
    $stmt->bindParam(':registlinename', $registlinename);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($res) {
        $started = $res['actual_start_DB'];
        $takt = $res['takt_secs_DB'];
        $last_takt = $res['last_takt_DB'];
        $last_update_DB = $res['last_update_DB'];
        $is_paused = $res['is_paused'];
        $line_no = $res['Line'];

        $sql = "SELECT * FROM m_ircs_line WHERE ircs_line = :registlinename";
        $stmt = $conn_pcad->prepare($sql);
        $stmt->bindParam(':registlinename', $registlinename);
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
    }
}

$dept_pd = 'PD2';
$dept_qa = 'QA';
$section_pd = get_section($line_no, $conn_emp_mgt);
$section_qa = 'QA';
$shift = get_shift($server_time);


?>