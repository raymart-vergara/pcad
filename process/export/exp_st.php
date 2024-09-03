<?php 
session_name("pcad");
session_start();

include '../server_date_time.php';
require '../conn/pcad.php';

if (!isset($_SESSION['emp_no'])) {
  header('location:/pcad/st_page/');
  exit;
}

switch (true) {
  case !isset($_GET['parts_name']):
  case !isset($_GET['st']):
    echo 'Query Parameters Not Set';
    exit;
}

$parts_name = addslashes(trim($_GET['parts_name']));
$st = addslashes(trim($_GET['st']));

$delimiter = ","; 

$filename = "PCAD_STMasterlist_" . $server_date_only . "_" . $server_time . ".csv";
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 

// UTF-8 BOM for special character compatibility
fputs($f, "\xEF\xBB\xBF");

// Set column headers 
$fields = array('Parts Name', 'Sub Assy ST', 'Final Assy ST', 'Inspection ST', 'ST'); 
fputcsv($f, $fields, $delimiter); 

$query = "SELECT parts_name, sub_assy, final_assy, inspection, st FROM m_st WHERE";
if (!empty($parts_name)) {
  $query = $query . " parts_name LIKE '".$parts_name."%'";
} else {
  $query = $query . " parts_name != ''";
}
if (!empty($st)) {
  $query = $query . " AND st LIKE '$st%'";
}

$stmt = $conn_pcad->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stmt->execute();


if ($stmt -> rowCount() > 0) {

    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 

        $lineData = array($row['parts_name'], $row['sub_assy'], $row['final_assy'], $row['inspection'], $row['st']); 
        fputcsv($f, $lineData, $delimiter); 
	    
    }

} else {

	// Output each row of the data, format line as csv and write to file pointer 
    $lineData = array("NO DATA FOUND"); 
    fputcsv($f, $lineData, $delimiter); 

}

// Move back to beginning of file 
fseek($f, 0); 
 
// Set headers to download file rather than displayed 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
 
//output all remaining data on a file pointer 
fpassthru($f); 

$conn_pcad = null;
?>