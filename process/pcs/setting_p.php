<?php
set_time_limit(0);

include '../server_date_time.php';
include '../conn/pcad.php';
include '../conn/ircs.php';
include '../conn/emp_mgt.php';
include '../lib/emp_mgt.php';
include '../lib/main.php';
include '../lib/inspection_output.php';
include '../lib/st.php';

function get_shift_end_plan($start_plan_time) {
	if ($start_plan_time >= '06:00:00' && $start_plan_time < '18:00:00') {
		return 'DS';
	} else if ($start_plan_time >= '18:00:00' && $start_plan_time <= '23:59:59') {
		return 'NS';
	} else if ($start_plan_time >= '00:00:00' && $start_plan_time < '06:00:00') {
		return 'NS';
	}
}

function get_day_end_plan($start_plan_date, $start_plan_time, $server_time, $server_date_only, $server_date_only_yesterday) {
    if ($start_plan_time >= '06:00:00' && $start_plan_time < '18:00:00') {
		return $server_date_only;
	} else if ($start_plan_time >= '18:00:00' && $start_plan_time <= '23:59:59') {
        if ($server_time >= '18:00:00' && $server_time <= '23:59:59') {
            return $server_date_only;
        } else if ($server_time >= '00:00:00' && $server_time <= '06:00:00') {
            return $server_date_only_yesterday;
        }
	} else if ($start_plan_time >= '00:00:00' && $start_plan_time < '06:00:00') {
        if ($start_plan_date == $server_date_only_yesterday) {
            return $server_date_only_yesterday;
        } else {
            return $server_date_only;
        }
	}
}

function TimeToSec($time)
{
    $sec = 0;
    foreach (array_reverse(explode(':', $time)) as $k => $v) $sec += pow(60, $k) * $v;
    return $sec;
}

if (isset($_POST['request'])) {
    $request = $_POST['request'];
    if ($request == "getPlan") {
        $carmaker = $_POST['carmaker'];
        $sql = " SELECT * FROM t_plan  WHERE Carmodel  LIKE '%" . $carmaker . "%' AND Status = 'Pending' ";
        $stmt = $conn_pcad->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->bindValue(':carmaker', '%' . $carmaker . '%', PDO::PARAM_STR);
        $stmt->execute();
        $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($plans) {
            $day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
            $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
            $shift = get_shift($server_time);

            foreach ($plans as $i => $p) {
                $IRCS_Line = $p['IRCS_Line'];

                $ircs_line_data_arr = get_ircs_line_data($IRCS_Line, $conn_pcad);

                $search_arr = array(
                    'day' => $day,
                    'day_tomorrow' => $day_tomorrow,
                    'shift' => $shift,
                    'registlinename' => $IRCS_Line,
                    'ircs_line_data_arr' => $ircs_line_data_arr,
                    'server_date_only' => $server_date_only,
                    'server_date_only_yesterday' => $server_date_only_yesterday,
                    'server_date_only_tomorrow' => $server_date_only_tomorrow,
                    'server_time' => $server_time,
                    'opt' => 1
                );

                $Actual_Target = count_overall_g($search_arr, $conn_ircs);

                // $IRCS_IP = $p['IP_address'];
                // $started = $p['actual_start_DB'];
                // $q = "
                //     SELECT COUNT(*) AS c
                //     FROM IRCS.T_PACKINGWK 
                //     WHERE (REGISTLINENAME LIKE '" . $IRCS_Line . "' OR IPADDRESS = '" . $IRCS_IP . "') 
                //     AND REGISTDATETIME >= TO_DATE('" . $started . "', 'yyyy-MM-dd HH24:MI:SS') AND PACKINGBOXCARDJUDGMENT = '1'";
                // $stid = oci_parse($conn_ircs, $q);
                // oci_execute($stid);
                // while ($row = oci_fetch_object($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                //     $Actual_Target = $row->C;
                // }
                
                $Target = $p['Target'];
                $Remaining_Target = $Target - $Actual_Target;
                $class = '';
                if ($Actual_Target > $Target) {
                    $Remaining_Target = '+' . abs($Target - $Actual_Target);
                } else {
                    $Remaining_Target = $Target - $Actual_Target;
                }
                if ($Actual_Target >= $Target) {
                    $class = 'tr-met';
                } else {
                    $class = 'tr-unmet';
                }
                echo '<tr class="' . $class . ' tr-click" data-id="' . $p['ID'] . '">';
                echo '<td>' . $p['Line'] . '</td>';
                echo '<td>' . $p['Target'] . '</td>';
                echo '<td>' . $Actual_Target . '</td>';
                echo '<td>' . $Remaining_Target . '</td>';
                echo '</tr>';
            }
        }
    } else if ($request == "getPlanLine") {
        $day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
        $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
        $shift = get_shift($server_time);

        $IRCS_Line = $_POST['registlinename'];

        $last_takt = $_POST['last_takt'];

        $sql = "SELECT *
                FROM t_plan 
                WHERE IRCS_Line = '" . $IRCS_Line . "' 
                AND Status = 'Pending'";
        $stmt = $conn_pcad->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->bindParam(':IRCS_Line', $IRCS_Line);
        $stmt->execute();
        $line = $stmt->fetch(PDO::FETCH_ASSOC);

        $Target = $line['Target'];
        $IRCS_IP = $line['IP_address'];
        $takt = $line['takt_secs_DB'];
        $started = $line['actual_start_DB'];

        $Actual_Target2 = $line['Actual_Target'];

        $start_plan_date = date('Y-m-d', strtotime($line['datetime_DB']));
        $start_plan_time = date('H:i:s', strtotime($line['datetime_DB']));
        $shift_pending = get_shift_end_plan($start_plan_time);
        $start_plan_date_pending = get_day_end_plan($start_plan_date, $start_plan_time, $server_time, $server_date_only, $server_date_only_yesterday);

        if ($start_plan_date == $start_plan_date_pending && $shift == $shift_pending) {
            $ircs_line_data_arr = get_ircs_line_data($IRCS_Line, $conn_pcad);

            $search_arr = array(
                'day' => $day,
                'day_tomorrow' => $day_tomorrow,
                'shift' => $shift,
                'registlinename' => $IRCS_Line,
                'ircs_line_data_arr' => $ircs_line_data_arr,
                'server_date_only' => $server_date_only,
                'server_date_only_yesterday' => $server_date_only_yesterday,
                'server_date_only_tomorrow' => $server_date_only_tomorrow,
                'server_time' => $server_time,
                'opt' => 1
            );

            $Actual_Target = count_overall_g($search_arr, $conn_ircs);

            // $q = "SELECT COUNT(*) AS c
            // FROM IRCS.T_PACKINGWK 
            // WHERE (REGISTLINENAME LIKE '" . $IRCS_Line . "' OR IPADDRESS = '" . $IRCS_IP . "') AND REGISTDATETIME >= TO_DATE('" . $started . "', 'yyyy-MM-dd HH24:MI:SS') AND PACKINGBOXCARDJUDGMENT = '1'";

            // $stid = oci_parse($conn_ircs, $q);
            // oci_execute($stid);
            // while ($row = oci_fetch_object($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            //     $Actual_Target = $row->C;
            // }

            $Remaining_Target = $Actual_Target - $Target;

            if (!$Target) {
                $Target = 0;
            }

            $p = array(
                "plan" => $Target,
                "actual" => $Actual_Target,
                "remaining" => $Remaining_Target,
                "takt" => $takt,
                "started" => $started
            );
            //UPDATE PLAN
            $added_target_formula = "FLOOR(TIME_TO_SEC(TIMEDIFF(NOW(), last_update_DB)) / takt_secs_DB)";
            $sql = "UPDATE t_plan SET Target = Target + $added_target_formula, Actual_Target = :Actual_Target, Remaining_Target = :Remaining_Target, last_takt_DB = :last_takt, last_update_DB = NOW() WHERE IRCS_Line = :IRCS_Line AND Status = 'Pending' AND is_paused = 'NO'";

            $stmt = $conn_pcad->prepare($sql);
            $stmt->bindParam(':Actual_Target', $Actual_Target);
            $stmt->bindParam(':Remaining_Target', $Remaining_Target);
            $stmt->bindParam(':last_takt', $last_takt);
            $stmt->bindParam(':IRCS_Line', $IRCS_Line);

            if ($stmt->execute()) {
                header("content-type: application/json");
                echo json_encode($p);
            } else {
                // Handle the case when the query fails
                echo "Failed to update plan.";
            }
        } else {
            $Remaining_Target = $Actual_Target2 - $Target;

            if (!$Target) {
                $Target = 0;
            }

            $p = array(
                "plan" => $Target,
                "actual" => $Actual_Target2,
                "remaining" => $Remaining_Target,
                "takt" => $takt,
                "started" => $started
            );

            header("content-type: application/json");
            echo json_encode($p);
        }
    } else if ($request == "updateTakt") {
        $IRCS_Line = $_POST['registlinename'];
        $added_takt_plan = $_POST['added_takt_plan'];

        // Actual Variables
        $yield_actual = floatval($_POST['yield_actual']);
        $ppm_actual = intval($_POST['ppm_actual']);
        $acc_eff_actual = floatval($_POST['acc_eff_actual']);

        $shift = get_shift($server_time);

        $sql = "SELECT datetime_DB FROM t_plan 
                WHERE IRCS_Line = '$IRCS_Line' AND Status = 'Pending'";
        $stmt = $conn_pcad->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $start_plan_date = date('Y-m-d', strtotime($result['datetime_DB']));
        $start_plan_time = date('H:i:s', strtotime($result['datetime_DB']));
        $shift_pending = get_shift_end_plan($start_plan_time);
        $start_plan_date_pending = get_day_end_plan($start_plan_date, $start_plan_time, $server_time, $server_date_only, $server_date_only_yesterday);

        if ($start_plan_date == $start_plan_date_pending && $shift == $shift_pending) {
            $sql = "UPDATE t_plan SET Target = (Target + 1), yield_actual = :yield_actual, 
                ppm_actual = :ppm_actual, acc_eff_actual = :acc_eff_actual 
                WHERE IRCS_Line = :IRCS_Line AND Status = 'Pending'";
            $stmt = $conn_pcad->prepare($sql);
            $stmt->bindParam(':yield_actual', $yield_actual);
            $stmt->bindParam(':ppm_actual', $ppm_actual);
            $stmt->bindParam(':acc_eff_actual', $acc_eff_actual);
            $stmt->bindParam(':IRCS_Line', $IRCS_Line);
            if ($stmt->execute()) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            echo 'true';
        }
    } else if ($request == "endTarget") {
        $registlinename = $_POST['registlinename'];

        $line_no = $_POST['line_no'];
        $shift_group = $_POST['shift_group'];
        $shift = get_shift($server_time);
        $day = get_day($server_time, $server_date_only, $server_date_only_yesterday);
        $day_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($day))));
        $work_time_plan = $_POST['work_time_plan'];

        $sql = "SELECT datetime_DB FROM t_plan 
                WHERE IRCS_Line = '$registlinename' AND `group` = '$shift_group' AND Status = 'Pending'";
        $stmt = $conn_pcad->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $start_plan_date = date('Y-m-d', strtotime($result['datetime_DB']));
        $start_plan_time = date('H:i:s', strtotime($result['datetime_DB']));
        $shift_pending = get_shift_end_plan($start_plan_time);
        $start_plan_date_pending = get_day_end_plan($start_plan_date, $start_plan_time, $server_time, $server_date_only, $server_date_only_yesterday);

        if ($start_plan_date == $start_plan_date_pending && $shift == $shift_pending) {
            $ircs_line_data_arr = get_ircs_line_data($registlinename, $conn_pcad);

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
            $wtpcad_x_mp_arr = get_wtpcad_x_mp_arr($search_arr, $server_time, $work_time_plan, $conn_emp_mgt);
            $wt_x_mp = $wtpcad_x_mp_arr['wt_x_mp'];
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

            // Update t_plan
            $sql = "UPDATE t_plan SET Status = 'Done', ended_DB = NOW(), 
                    yield_actual = :yield_actual, ppm_actual = :ppm_actual, acc_eff_actual = :acc_eff_actual 
                    WHERE IRCS_Line = :IRCS_Line AND Status = 'Pending'";
            $stmt = $conn_pcad->prepare($sql);
            $stmt->bindParam(':yield_actual', $yield_actual);
            $stmt->bindParam(':ppm_actual', $ppm_actual);
            $stmt->bindParam(':acc_eff_actual', $acc_eff_actual);
            $stmt->bindParam(':IRCS_Line', $registlinename);
            if ($stmt->execute()) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            // Update t_plan
            $sql = "UPDATE t_plan SET Status = 'Done', ended_DB = NOW()
                    WHERE IRCS_Line = :IRCS_Line AND Status = 'Pending'";
            $stmt = $conn_pcad->prepare($sql);
            $stmt->bindParam(':IRCS_Line', $registlinename);
            if ($stmt->execute()) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    } else if ($request == "addTarget") {
        $takt_time = $_POST['takt_time'];
        $registlinename = $_POST['registlinenameplan'];
        $time_start = date('Y-m-d') . ' ' . $_POST['time_start'];
        $shift = get_shift($server_time);
        $group = $_POST['group'];
        $yield_target = $_POST['yield_target'];
        $ppm_target = $_POST['ppm_target'];
        $acc_eff = $_POST['acc_eff'];
        // $hrs_output = $_POST['hrs_output'];
        $start_bal_delay = $_POST['start_bal_delay'];
        $work_time_plan = $_POST['work_time_plan'];

            if (strtotime($_POST['time_start']) < strtotime('05:50:00')) {
                $date_now = date('Y-m-d');
                $new_date_to = new DateTime($date_now);
                $new_date_to->modify("-1 day");
                $to = $new_date_to->format("Y-m-d");
                $date_actual_start = $to . ' ' . $_POST['time_start'];
                $date_only_actual_start = $to;
            } else {
                $date_actual_start = date('Y-m-d') . ' ' . $_POST['time_start'];
                $date_only_actual_start = date('Y-m-d');
            }
            $daily_plan = $_POST['daily_plan'];
            $plan = $_POST['plan'];
            $hrs = str_pad($_POST['hrs'], 2, '0', STR_PAD_LEFT);
            $mins = str_pad($_POST['mins'], 2, '0', STR_PAD_LEFT);
            $secs = str_pad($_POST['secs'], 2, '0', STR_PAD_LEFT);
            if ($hrs == "") {
                $hrs = "00";
            }
            if ($mins == "") {
                $mins = "00";
            }
            if ($secs == "") {
                $secs = "00";
            }
            $sql_get_line = "SELECT * FROM m_ircs_line WHERE ircs_line = :registlinename";
            $stmt_get_line = $conn_pcad->prepare($sql_get_line, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt_get_line->bindParam(':registlinename', $registlinename);
            $stmt_get_line->execute();
            $line = $stmt_get_line->fetch(PDO::FETCH_ASSOC);
            $line_no = $line['line_no'];
            $IP_address = $line['ip'];
            $car_maker_name = explode('_', $registlinename);
            $car_maker = $car_maker_name[0];
            $takt_secs = TimeToSec($takt_time);
            $status = "Pending";

            if ($shift == 'DS') {
                $time_only_actual_start = '06:00:00';
                $time_only_actual_end = '17:59:59';
                $date_only_actual_end = $date_only_actual_start;
            } else if ($shift == 'NS') {
                $time_only_actual_start = '18:00:00';
                $time_only_actual_end = '05:59:59';
                if ($server_time >= '18:00:00' && $server_time <= '23:59:59') {
                    $date_only_actual_end = $server_date_only_tomorrow;
                } else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
                    $date_only_actual_end = $server_date_only;
                }
            }

            // Check existing done or pending plan
            // MySQL
            $sql = "SELECT id FROM t_plan WHERE 
                    (datetime_DB >= '$date_only_actual_start $time_only_actual_start' AND datetime_DB <= '$date_only_actual_end $time_only_actual_end') 
                    AND IRCS_Line='$registlinename' ORDER BY id DESC LIMIT 1";
            // MS SQL Server
            // $sql = "SELECT TOP 1 id FROM t_plan WHERE 
            //         (datetime_DB >= '$date_only_actual_start $time_only_actual_start' AND datetime_DB <= '$date_only_actual_end $time_only_actual_end') 
            //         AND IRCS_Line='$registlinename' ORDER BY id DESC";
            
            $stmt = $conn_pcad->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                foreach($stmt->fetchALL() as $row){
                    $id = $row['id'];
                }

                $sql = "UPDATE t_plan SET Carmodel = '$car_maker', Line = '$line_no', Target = '$plan', Status = '$status', IRCS_Line = '$registlinename', 
                        datetime_DB = NOW(), ended_DB = null, takt_secs_DB = '$takt_secs', actual_start_DB = '$date_actual_start', last_update_DB = NOW(), 
                        IP_address = '$IP_address', `group` = '$group',  yield_target = '$yield_target', ppm_target = '$ppm_target', acc_eff = '$acc_eff', 
                        start_bal_delay = '$start_bal_delay', work_time_plan = '$work_time_plan', daily_plan = '$daily_plan' WHERE id = '$id'";
                $stmt = $conn_pcad->prepare($sql);

                if ($stmt->execute()) {
                    header("location: ../../index_prod.php?registlinename=" . $registlinename);
                } else {
                    echo "Failed to update existing data into t_plan.";
                }
            } else {
                $sql_insert_plan = "INSERT INTO t_plan (Carmodel, Line, Target, Status, IRCS_Line, datetime_DB, takt_secs_DB, actual_start_DB, last_update_DB, IP_address, `group`, yield_target, ppm_target, acc_eff, start_bal_delay, work_time_plan, daily_plan) 
                VALUES (:car_maker, :line_no, :plan, :status, :registlinename, NOW(), :takt_secs, :date_actual_start, NOW(), :IP_address, :group, :yield_target, :ppm_target, :acc_eff, :start_bal_delay, :work_time_plan, :daily_plan)";

                $stmt_insert_plan = $conn_pcad->prepare($sql_insert_plan);
                $stmt_insert_plan->bindParam(':car_maker', $car_maker);
                $stmt_insert_plan->bindParam(':line_no', $line_no);
                $stmt_insert_plan->bindParam(':plan', $plan);
                $stmt_insert_plan->bindParam(':status', $status);
                $stmt_insert_plan->bindParam(':registlinename', $registlinename);
                $stmt_insert_plan->bindParam(':takt_secs', $takt_secs);
                $stmt_insert_plan->bindParam(':date_actual_start', $date_actual_start);
                $stmt_insert_plan->bindParam(':IP_address', $IP_address);
                $stmt_insert_plan->bindParam(':group', $group);
                $stmt_insert_plan->bindParam(':yield_target', $yield_target);
                $stmt_insert_plan->bindParam(':ppm_target', $ppm_target);
                $stmt_insert_plan->bindParam(':acc_eff', $acc_eff);
                $stmt_insert_plan->bindParam(':start_bal_delay', $start_bal_delay);
                $stmt_insert_plan->bindParam(':work_time_plan', $work_time_plan);
                $stmt_insert_plan->bindParam(':daily_plan', $daily_plan);

                if ($stmt_insert_plan->execute()) {
                    header("location: ../../index_prod.php?registlinename=" . $registlinename);
                } else {
                    echo "Failed to insert data into t_plan.";
                }
            }
         }
        elseif ($_POST['request'] == "mainMenu") {
            // Redirect to the main menu without adding target
            header("Location: ../../pcs_page/index.php");
            exit();
        } else if ($request == "getLineNo") {
        $registlinename = $_POST['registlinename'];
        $q = "SELECT * FROM m_ircs_line WHERE ircs_line = :registlinename ";
        $stmt = $conn_pcad->prepare($q, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->bindParam(':registlinename', $registlinename);
        $stmt->execute();
        $line = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($line) {
            echo $line['line_no'];
        } else {
            echo "Line not found";
        }
    } elseif ($request == "checkRunningPlans") {
        $registlinename = $_POST['registlinename'];
        $sql = "SELECT * FROM t_plan WHERE IRCS_Line = :registlinename AND Status = 'Pending'";
        $stmt = $conn_pcad->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->bindParam(':registlinename', $registlinename);
        $stmt->execute();
        $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($plans) {
            echo 'true';
        } else {
            echo 'false';
        }
    } else if ($request == "setPaused") {
        $registlinename = $_POST['registlinename'];
        $is_paused = $_POST['is_paused'];
        $sql = "UPDATE t_plan SET is_paused = :is_paused, last_update_DB = NOW() WHERE IRCS_Line = :registlinename AND Status = 'Pending'";
        $stmt = $conn_pcad->prepare($sql);
        $stmt->bindParam(':is_paused', $is_paused);
        $stmt->bindParam(':registlinename', $registlinename);
        if ($stmt->execute()) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
}

oci_close($conn_ircs);
$conn_emp_mgt = NULL;
$conn_pcad = NULL;