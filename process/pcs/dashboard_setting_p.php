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

        switch ($opt) {
            case 1:
                $sql_get_line .= " AND Status = 'Pending'";
                break;
            case 2:
                $url = "location: ../../index_exec.php?registlinename=" . $registlinename . "&line_no=" . $line_no . "&day=" . $day . "&shift=" . $shift . "&opt=" . $opt;
                $message = "No plan history has been set for the selected line. The dashboard for the selected line cannot be viewed.";

                $start_date = '';
                $end_date = '';

                if ($shift == 'DS') {
                    $start_date = date('Y-m-d H:i:s', (strtotime("$day 06:00:00")));
                    $end_date = date('Y-m-d H:i:s', (strtotime("$day 17:59:59")));
                } else if ($shift == 'NS') {
                    $day_tomorrow = date('Y-m-d', (strtotime('+1 day', strtotime($day))));
                    $start_date = date('Y-m-d H:i:s', (strtotime("$day 18:00:00")));
                    $end_date = date('Y-m-d H:i:s', (strtotime("$day_tomorrow 05:59:59")));
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
                        alert('" . $message . "');
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

$method = $_POST['method'];

// if ($method == 'analysis_list') {
//     $c = 0;

//     $query = "SELECT problem, recommendation, date_added, dri, department, prepared_by, reviewed_by FROM t_analysis ORDER BY date_updated DESC";
//     $stmt = $conn_pcad->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
//     $stmt->execute();
//     if ($stmt->rowCount() > 0) {
//         foreach ($stmt->fetchALL() as $row) {
//             $c++;
//             echo '<tr style="cursor:pointer;">';
//             echo '<td style="text-align:center">' . $c . '</td>';
//             echo '<td style="text-align:center">' . $row['problem'] . '</td>';
//             echo '<td style="text-align:center">' . $row['recommendation'] . '</td>';
//             echo '<td style="text-align:center">' . $row['date_added'] . '</td>';
//             echo '<td style="text-align:center">' . $row['dri'] . '</td>';
//             echo '<td style="text-align:center">' . $row['department'] . '</td>';
//             echo '<td style="text-align:center">' . $row['prepared_by'] . '</td>';
//             echo '<td style="text-align:center">' . $row['reviewed_by'] . '</td>';
//             echo '</tr>';
//         }
//     } else {
//         echo '<tr>';
//         echo '<td colspan="8" style="text-align:center; color:red;">No Record Found</td>';
//         echo '</tr>';
//     }
// }

if ($method == 'analysis_list') {
    // var_dump($_POST);
    $c = 0;

    // Check required parameters
    if (
        !isset($_POST['registlinename']) ||
        !isset($_POST['pcad_line_no']) ||
        !isset($_POST['pcad_exec_server_date_only']) ||
        !isset($_POST['shift']) ||
        !isset($_POST['pcad_exec_opt'])
    ) {
        echo '<tr><td colspan="8" style="text-align:center; color:red;">Missing parameters</td></tr>';
        return;
    }

    $registlinename = $_POST['registlinename'];
    $pcad_line_no = $_POST['pcad_line_no'];
    $pcad_exec_server_date_only = $_POST['pcad_exec_server_date_only'];
    $shift = $_POST['shift'];
    $pcad_exec_opt = $_POST['pcad_exec_opt'];

    // Start and end date initialization
    if ($shift == 'DS') {
        $start_date = date('Y-m-d H:i:s', strtotime("$pcad_exec_server_date_only 06:00:00"));
        $end_date = date('Y-m-d H:i:s', strtotime("$pcad_exec_server_date_only 17:59:59"));
    } elseif ($shift == 'NS') {
        $day_tomorrow = date('Y-m-d', strtotime('+1 day', strtotime($pcad_exec_server_date_only)));
        $start_date = date('Y-m-d H:i:s', strtotime("$pcad_exec_server_date_only 18:00:00"));
        $end_date = date('Y-m-d H:i:s', strtotime("$day_tomorrow 05:59:59"));
    }

    // Test query to check if data exists in t_analysis
    $sql_test = "SELECT * FROM t_analysis 
                 WHERE ircs_line = :registlinename 
                 AND line_no = :pcad_line_no 
                 AND CAST(pcad_date AS DATE) = CAST(:pcad_exec_server_date_only AS DATE) 
                 AND shift = :shift
                 AND opt = :pcad_exec_opt";
    $stmt_test = $conn_pcad->prepare($sql_test, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt_test->bindValue(':registlinename', $registlinename);
    $stmt_test->bindValue(':pcad_line_no', $pcad_line_no);
    $stmt_test->bindValue(':pcad_exec_server_date_only', $pcad_exec_server_date_only);
    $stmt_test->bindValue(':shift', $shift);
    $stmt_test->bindValue(':pcad_exec_opt', $pcad_exec_opt);
    $stmt_test->execute();

    if ($stmt_test->rowCount() > 0) {
        // echo "Records found in t_analysis for line_no: $pcad_line_no, ircs_line: $registlinename, pcad_date: $pcad_exec_server_date_only, shift: $shift, opt: $pcad_exec_opt<br>";
        foreach ($stmt_test->fetchAll() as $row) {
            // echo "ID: {$row['id']}, Problem: {$row['problem']}<br>";
        }
    } else {
        // echo "No records found in t_analysis for line_no: $pcad_line_no, ircs_line: $registlinename, pcad_date: $pcad_exec_server_date_only, shift: $shift, opt: $pcad_exec_opt.<br>";
    }

    // Prepare the SQL query with parameter placeholders for t_plan
    $sql_get_id = "SELECT * FROM t_plan 
    WHERE IRCS_Line = :registlinename 
    AND Line = :pcad_line_no 
    AND CAST(datetime_DB AS DATE) = CAST(:datetime_DB AS DATE)";

    // Prepare the statement for t_plan
    $stmt_get_id = $conn_pcad->prepare($sql_get_id, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt_get_id->bindValue(':registlinename', $registlinename);
    $stmt_get_id->bindValue(':pcad_line_no', $pcad_line_no);
    $stmt_get_id->bindValue(':datetime_DB', $pcad_exec_server_date_only);

    // Execute the query for t_plan
    $stmt_get_id->execute();

    if ($stmt_get_id->rowCount() > 0) {
        // echo "Records found in t_plan for line_no: $pcad_line_no, ircs_line: $registlinename<br>";

        // Fetching all rows to get the IDs
        $planRows = $stmt_get_id->fetchAll(PDO::FETCH_ASSOC);
        foreach ($planRows as $row) {
            // echo "ID: {$row['ID']}, IRCS Line: {$row['IRCS_Line']}, Status: {$row['Status']}, Date: {$row['datetime_DB']}<br>";
        }

        // Fetch matching records from t_analysis based on IRCS_Line, Line, and date
        $sql_analysis = "SELECT id, problem, recommendation, date_added, dri, department, prepared_by, reviewed_by 
                         FROM t_analysis 
                         WHERE ircs_line = :registlinename 
                         AND line_no = :pcad_line_no 
                         AND CAST(pcad_date AS DATE) = CAST(:pcad_exec_server_date_only AS DATE) ORDER BY date_updated DESC";
        $stmt_analysis = $conn_pcad->prepare($sql_analysis, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt_analysis->bindValue(':registlinename', $registlinename);
        $stmt_analysis->bindValue(':pcad_line_no', $pcad_line_no);
        $stmt_analysis->bindValue(':pcad_exec_server_date_only', $pcad_exec_server_date_only);

        // Execute the analysis query
        $stmt_analysis->execute();

        // Process results for t_analysis
        if ($stmt_analysis->rowCount() > 0) {
            while ($row = $stmt_analysis->fetch(PDO::FETCH_ASSOC)) {
                $c++;
                echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#update_analysis" onclick="get_analysis_details(&quot;'
                    . $row['id'] . ','
                    . $row['problem'] . ','
                    . $row['recommendation'] . ','
                    . $row['dri'] . ','
                    . $row['department'] . ','
                    . $row['date_added'] . ','
                    . $row['prepared_by'] . ','
                    . $row['reviewed_by'] . '&quot;)">';
                echo '<td style="text-align:center">' . $c . '</td>';
                echo '<td style="text-align:left; max-width: 230px; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">' . htmlspecialchars($row['problem']) . '</td>';
                echo '<td style="text-align:left; max-width: 230px; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">' . htmlspecialchars($row['recommendation']) . '</td>';
                echo '<td style="text-align:center">' . htmlspecialchars($row['date_added']) . '</td>';
                echo '<td style="text-align:center">' . htmlspecialchars($row['dri']) . '</td>';
                echo '<td style="text-align:center">' . htmlspecialchars($row['department']) . '</td>';
                echo '<td style="text-align:center">' . htmlspecialchars($row['prepared_by']) . '</td>';
                echo '<td style="text-align:center">' . htmlspecialchars($row['reviewed_by']) . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="8" style="text-align:center; color:red;">No Record Found</td></tr>';
        }
    } else {
        echo '<tr><td colspan="8" style="text-align:center; color:red;">No Matching Record Found</td></tr>';
    }
}

if ($method == 'add_analysis') {
    $problem = trim($_POST['problem']);
    $recommendation = trim($_POST['recommendation']);
    $dri = trim($_POST['dri']);
    $dept = trim($_POST['dept']);
    $prepared_by = trim($_POST['prepared_by']);
    $reviewed_by = trim($_POST['reviewed_by']);

    // Get the additional fields from POST
    $line_no = trim($_POST['line_no']);
    $ircs_line = trim($_POST['registlinename']);
    $exec_date = trim($_POST['exec_date']);
    $shift = trim($_POST['shift']);
    $opt = trim($_POST['opt']);

    $date_recorded = trim($_POST['date_recorded']);
    $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $date_recorded);

    if (!$dateTime) {
        echo 'error: invalid date format';
        return;
    }

    $formatted_date_recorded = $dateTime->format('Y-m-d H:i:s');

    $query = "INSERT INTO t_analysis (problem, recommendation, date_added, dri, department, prepared_by, reviewed_by, line_no, ircs_line, pcad_date, shift, opt)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn_pcad->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

    if ($stmt->execute([$problem, $recommendation, $formatted_date_recorded, $dri, $dept, $prepared_by, $reviewed_by, $line_no, $ircs_line, $exec_date, $shift, $opt])) {
        echo 'success';
    } else {
        echo 'error';
    }
}

if ($method == 'update_analysis') {
    $id = $_POST['id'];
    $problem = trim($_POST['problem']);
    $recommendation = trim($_POST['recommendation']);
    $dri = trim($_POST['dri']);
    $department = trim($_POST['department']);
    $prepared_by = trim($_POST['prepared_by']);
    $reviewed_by = trim($_POST['reviewed_by']);

    $date_recorded = trim($_POST['date_recorded']);
    $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $date_recorded);

    if (!$dateTime) {
        echo 'error: invalid date format';
        return;
    }

    $formatted_date_recorded = $dateTime->format('Y-m-d H:i:s');

    $query = "UPDATE t_analysis 
              SET problem = :problem, 
                  recommendation = :recommendation, 
                  dri = :dri, 
                  department = :department, 
                  date_added = :date_recorded, 
                  prepared_by = :prepared_by, 
                  reviewed_by = :reviewed_by 
              WHERE id = :id";

    $stmt = $conn_pcad->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

    $stmt->bindValue(':problem', $problem);
    $stmt->bindValue(':recommendation', $recommendation);
    $stmt->bindValue(':dri', $dri);
    $stmt->bindValue(':department', $department);
    $stmt->bindValue(':date_recorded', $formatted_date_recorded);
    $stmt->bindValue(':prepared_by', $prepared_by);
    $stmt->bindValue(':reviewed_by', $reviewed_by);
    $stmt->bindValue(':id', $id);

    try {
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    } catch (Exception $e) {
        echo 'error: ' . $e->getMessage();
    }
}






