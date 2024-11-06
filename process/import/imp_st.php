<?php
// error_reporting(0);
set_time_limit(0);

session_name("pcad");
session_start();

require '../conn/pcad.php';
require '../lib/validate.php';

if (!isset($_SESSION['emp_no'])) {
    header('location:/pcad/st_page/');
    exit;
}

// Remove UTF-8 BOM
function removeBomUtf8($s){
    if (substr($s,0,3) == chr(hexdec('EF')).chr(hexdec('BB')).chr(hexdec('BF'))) {
        return substr($s,3);
    } else {
        return $s;
    }
}

function check_csv ($file, $conn_pcad) {
    // READ FILE
    $csvFile = fopen($file,'r');

    // SKIP FIRST LINE (HEADER)
    $first_line = fgets($csvFile);
    // Remove UTF-8 BOM from First Line
    $first_line = removeBomUtf8($first_line);

    $hasError = 0; $hasBlankError = 0; $isDuplicateOnCsv = 0;
    $hasBlankErrorArr = array();
    $isDuplicateOnCsvArr = array();
    $dup_temp_arr = array();

    $row_valid_arr = array(0,0,0,0);

    $negativeSubAssyStArr = array();
    $negativeFinalAssyStArr = array();
    $negativeInspectionStArr = array();
    $negativeStArr = array();

    $message = "";
    $check_csv_row = 0;

    while (($line = fgetcsv($csvFile)) !== false) {
        // Check if the row is blank or consists only of whitespace
        if (empty(implode('', $line))) {
            continue; // Skip blank lines
        }

        $check_csv_row++;
        
        $parts_name = $line[4];
        $sub_assy = custom_trim($line[12]);
        $final_assy = custom_trim($line[13]);
        $inspection = custom_trim($line[14]);
        $st = custom_trim($line[15]);

        if ($parts_name == '' || $sub_assy == '' || $final_assy == '' || $inspection == '' || $st == '') {
            // IF BLANK DETECTED ERROR += 1
            $hasBlankError++;
            $hasError = 1;
            array_push($hasBlankErrorArr, $check_csv_row);
        }

        // CHECK ROW VALIDATION
        if (!empty($sub_assy)) {
            $sub_assy_int = intval($sub_assy);
            if ($sub_assy_int < 0) {
                $hasError = 1;
                $row_valid_arr[0] = 1;
                array_push($negativeSubAssyStArr, $check_csv_row);
            }
        }
        if (!empty($final_assy)) {
            $final_assy_int = intval($final_assy);
            if ($final_assy_int < 0) {
                $hasError = 1;
                $row_valid_arr[1] = 1;
                array_push($negativeFinalAssyStArr, $check_csv_row);
            }
        }
        if (!empty($inspection)) {
            $inspection_int = intval($inspection);
            if ($inspection_int < 0) {
                $hasError = 1;
                $row_valid_arr[2] = 1;
                array_push($negativeInspectionStArr, $check_csv_row);
            }
        }
        if (!empty($st)) {
            $st_int = intval($st);
            if ($st_int < 0) {
                $hasError = 1;
                $row_valid_arr[3] = 1;
                array_push($negativeStArr, $check_csv_row);
            }
        }
        
        // Joining all row values for checking duplicated rows
        $whole_line = join(',', $line);

        // CHECK ROWS IF IT HAS DUPLICATE ON CSV
        if (isset($dup_temp_arr[$whole_line])) {
            $isDuplicateOnCsv = 1;
            $hasError = 1;
            array_push($isDuplicateOnCsvArr, $check_csv_row);
        } else {
            $dup_temp_arr[$whole_line] = 1;
        }
    }
    
    fclose($csvFile);

    if ($hasError == 1) {
        if ($row_valid_arr[0] == 1) {
            $message = $message . 'Negative Value Initial ST on row/s ' . implode(", ", $negativeSubAssyStArr) . '. ';
        }
        if ($row_valid_arr[1] == 1) {
            $message = $message . 'Negative Value Final ST on row/s ' . implode(", ", $negativeFinalAssyStArr) . '. ';
        }
        if ($row_valid_arr[2] == 1) {
            $message = $message . 'Negative Value ST on row/s ' . implode(", ", $negativeInspectionStArr) . '. ';
        }
        if ($row_valid_arr[3] == 1) {
            $message = $message . 'Negative Value ST on row/s ' . implode(", ", $negativeStArr) . '. ';
        }

        if ($hasBlankError >= 1) {
            $message = $message . 'Blank Cell Exists on row/s ' . implode(", ", $hasBlankErrorArr) . '. ';
        }
        if ($isDuplicateOnCsv == 1) {
            $message = $message . 'Duplicated Record/s on row/s ' . implode(", ", $isDuplicateOnCsvArr) . '. ';
        }
    }
    return $message;
}

$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)) {

    if (is_uploaded_file($_FILES['file']['tmp_name'])) {

        $chkCsvMsg = check_csv($_FILES['file']['tmp_name'], $conn_pcad);

        if ($chkCsvMsg == '') {

            //READ FILE
            $csvFile = fopen($_FILES['file']['tmp_name'],'r');

            // SKIP FIRST LINE (HEADER)
            fgets($csvFile);

            // PARSE
            $error = 0;
            while (($line = fgetcsv($csvFile)) !== false) {
                // Check if the row is blank or consists only of whitespace
                if (empty(implode('', $line))) {
                    continue; // Skip blank lines
                }

                $parts_name = addslashes($line[4]);
                $sub_assy = addslashes($line[12]);
                $final_assy = addslashes($line[13]);
                $inspection = addslashes($line[14]);
                $st = addslashes(custom_trim($line[15]));
                $updated_by_no = $_SESSION['emp_no'];
                $updated_by = $_SESSION['full_name'];

                $conn_pcad->beginTransaction();

                // CHECK DATA
                $sql = "SELECT id FROM m_st WHERE parts_name = '$parts_name'";
                $stmt = $conn_pcad->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    foreach($stmt->fetchALL() as $x){
                        $id = $x['id'];
                    }
                    $sql = "UPDATE m_st SET parts_name='$parts_name',sub_assy='$sub_assy',
                            final_assy='$final_assy',inspection='$inspection',st='$st',
                            updated_by_no='$updated_by_no',updated_by='$updated_by' 
                            WHERE id = '$id'";

                    $stmt = $conn_pcad->prepare($sql);
                    if (!$stmt->execute()) {
                        $error++;
                    }
                } else {
                    $sql = "INSERT INTO m_st (parts_name, sub_assy, final_assy, inspection, st, updated_by_no, updated_by) 
                            VALUES ('$parts_name','$sub_assy','$final_assy','$inspection','$st','$updated_by_no','$updated_by')";

                    $stmt = $conn_pcad->prepare($sql);
                    if (!$stmt->execute()) {
                        $error++;
                    }
                }

                $conn_pcad->commit();
            }
            
            fclose($csvFile);

            if ($error > 0) {
                echo 'error ' . $error;
            }

        } else {
            echo $chkCsvMsg; 
        }
    } else {
        echo 'CSV FILE NOT UPLOADED!';
    }
} else {
    echo 'INVALID FILE FORMAT!';
}

// KILL CONNECTION
$conn_pcad = null;
