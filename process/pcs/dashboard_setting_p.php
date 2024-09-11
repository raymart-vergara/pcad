<?php
include '../server_date_time.php';
include '../conn/pcad.php';

if (isset($_POST['request'])) {
    $request = $_POST['request'];
    if ($request == "addTarget") {
        $opt = $_POST['opt'];
        $day = $_POST['day'];
        $shift = $_POST['shift'];
        $registlinename = $_POST['registlinenameplan'];
        $line_no = $_POST['line_no'];
        $group = $_POST['group'];

        $url = "location: ../../index_exec.php?registlinename=" . $registlinename . "&line_no=" . $line_no . "&opt=" . $opt;
        $message = "No plan has been set for the selected line. The dashboard for the selected line cannot be viewed.";

        // MySQL
        // $sql_get_line = "SELECT ID FROM t_plan WHERE IRCS_Line = :registlinename AND Line = :line_no AND `group` = :group";
        // MS SQL Server
        $sql_get_line = "SELECT ID FROM t_plan WHERE IRCS_Line = :registlinename AND Line = :line_no AND [group] = :group";

        switch($opt) {
            case 1:
                $sql_get_line .= " AND Status = 'Pending'";
                break;
            case 2:
                $url = "location: ../../index_exec.php?registlinename=" . $registlinename . "&line_no=" . $line_no . "&day=" . $day . "&shift=" . $shift . "&opt=" . $opt;
                $message = "No plan history has been set for the selected line. The dashboard for the selected line cannot be viewed.";

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
    
                $sql_get_line .= " AND Status = 'Done' AND (datetime_DB >= '$start_date' AND datetime_DB <= '$end_date')";
                break;
            default:
                $sql_get_line .= " AND Status = 'Pending'";
                break;
        }

        $stmt_get_line = $conn_pcad->prepare($sql_get_line, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt_get_line->bindParam(':registlinename', $registlinename);
        $stmt_get_line->bindParam(':line_no', $line_no);
        $stmt_get_line->bindParam(':group', $group);

        if ($stmt_get_line->execute()) {
            if ($stmt_get_line->rowCount() > 0) {
                header($url);
            } else {
                echo "<script>
                        alert('".$message."');
                        window.location.href = '../../dashboard/setting.php';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Failed to execute the query.');
                    window.location.href = '../../dashboard/setting.php';
                  </script>";
        }
    }
}
