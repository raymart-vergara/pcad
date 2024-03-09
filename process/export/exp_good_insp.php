<?php 
include '../server_date_time.php';
require '../conn/ircs.php';
require '../conn/pcad.php';
include '../lib/emp_mgt.php';
include '../lib/main.php';
include '../lib/inspection_output.php';

// switch (true) {
//   case !isset($_GET['registlinename']):
//     echo 'Query Parameters Not Set';
//     exit;
// }

$shift = get_shift($server_time);

// $registlinename = addslashes(trim($_GET['registlinename']));
$registlinename = 'DAIHATSU_30';

$delimiter = ","; 

$filename = "PCAD_GoodInspectionOutput_" . $server_date_only . "_" . $server_time . ".csv";
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 

// UTF-8 BOM for special character compatibility
fputs($f, "\xEF\xBB\xBF");

// Set column headers 
$f_h_register = array('','','','','','Register','','','','',''); 
$f_h_inspection1 = array('','','','','Inspection 1','','',''); 
$f_h_inspection2 = array('','','','','Inspection 2','','',''); 
$f_h_inspection3 = array('','','','','Inspection 3','','',''); 
$f_h_inspection4 = array('','','','','Inspection 4','','',''); 
$f_h_inspection5 = array('','','','','Inspection 5','','',''); 
$f_h_inspection6 = array('','','','','Inspection 6','','',''); 
$f_h_inspection7 = array('','','','','Inspection 7','','',''); 
$f_h_inspection8 = array('','','','','Inspection 8','','',''); 
$f_h_blank = array('','','','','','','',''); 
$f_h_inspection9 = array('','','','','Inspection 9','','',''); 
$f_h_inspection10 = array('','','','Inspection 10','',''); 

$combined_h_fields = array_merge($f_h_register, $f_h_inspection1, $f_h_inspection2, $f_h_inspection3, $f_h_inspection4, $f_h_inspection5, $f_h_inspection6, $f_h_inspection7, $f_h_inspection8, $f_h_blank, $f_h_inspection9, $f_h_inspection10);

fputcsv($f, $combined_h_fields, $delimiter); 

// Set column headers 
$f_c_register = array('Date Time','Company Code','Department','Line Name','Process','Device ID','IP Address','Operator ID','Parts Name','Lot No.','Serial No.'); 
$f_c_inspection1 = array('Period','Operator ID','IP Address','Start Date/Time','Finished Date/Time','Judgement','Packing Check Code','Packing Check Judgement'); 
$f_c_inspection2 = array('Period','Operator ID','IP Address','Start Date/Time','Finished Date/Time','Judgement','Packing Check Code','Packing Check Judgement');
$f_c_inspection3 = array('Period','Operator ID','IP Address','Start Date/Time','Finished Date/Time','Judgement','Packing Check Code','Packing Check Judgement');
$f_c_inspection4 = array('Period','Operator ID','IP Address','Start Date/Time','Finished Date/Time','Judgement','Packing Check Code','Packing Check Judgement');
$f_c_inspection5 = array('Period','Operator ID','IP Address','Start Date/Time','Finished Date/Time','Judgement','Packing Check Code','Packing Check Judgement');
$f_c_inspection6 = array('Period','Operator ID','IP Address','Start Date/Time','Finished Date/Time','Judgement','Packing Check Code','Packing Check Judgement');
$f_c_inspection7 = array('Period','Operator ID','IP Address','Start Date/Time','Finished Date/Time','Judgement','Packing Check Code','Packing Check Judgement');
$f_c_inspection8 = array('Period','Operator ID','IP Address','Start Date/Time','Finished Date/Time','Judgement','Packing Check Code','Packing Check Judgement');
$f_c_blank = array('Last Repair Card Number','Repair Result','Reset Supervisor ID','Reset Supervisor Name','Now Mode','Message Code','Final Inspection Name','Final Inspection Judgement'); 
$f_c_inspection9 = array('Period','Operator ID','IP Address','Start Date/Time','Finished Date/Time','Judgement','Packing Check Code','Packing Check Judgement');
$f_c_inspection10 = array('Period','Operator ID','IP Address','Start Date/Time','Finished Date/Time','Judgement'); 

$combined_c_fields = array_merge($f_c_register, $f_c_inspection1, $f_c_inspection2, $f_c_inspection3, $f_c_inspection4, $f_c_inspection5, $f_c_inspection6, $f_c_inspection7, $f_c_inspection8, $f_c_blank, $f_c_inspection9, $f_c_inspection10);

fputcsv($f, $combined_c_fields, $delimiter); 

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

//Output each row of the data, format line as csv and write to file pointer 
foreach ($list_of_good_viewer as &$row) {

        // $lineData = array($row['parts_name'], $row['st']); 
        $data_register = array($row['REGISTDATETIME'],$row['REGISTCAMPANYCODE'],$row['REGISTDEPARTMENTCODE'],$row['REGISTLINENAME'],$row['REGISTPROCESS'],$row['REGISTDEVICEID'],$row['IPADDRESS'],$row['REGISTOPERATORID'],$row['PARTSNAME'],$row['LOT'],$row['SERIAL']);
        $data_inspection1 = array($row['INSPECTION1PERIOD'],$row['INSPECTION1OPERATORID'],$row['INSPECTION1IPADDRESS'],$row['INSPECTION1STARTDATETIME'],$row['INSPECTION1FINISHDATETIME'],$row['INSPECTION1JUDGMENT'],$row['INSPECTION1PACKINGCHECKCODE'],$row['INSPECTION1PACKINGCHECKJ']);
        $data_inspection2 = array($row['INSPECTION2PERIOD'],$row['INSPECTION2OPERATORID'],$row['INSPECTION2IPADDRESS'],$row['INSPECTION2STARTDATETIME'],$row['INSPECTION2FINISHDATETIME'],$row['INSPECTION2JUDGMENT'],$row['INSPECTION2PACKINGCHECKCODE'],$row['INSPECTION2PACKINGCHECKJ']);
        $data_inspection3 = array($row['INSPECTION3PERIOD'],$row['INSPECTION3OPERATORID'],$row['INSPECTION3IPADDRESS'],$row['INSPECTION3STARTDATETIME'],$row['INSPECTION3FINISHDATETIME'],$row['INSPECTION3JUDGMENT'],$row['INSPECTION3PACKINGCHECKCODE'],$row['INSPECTION3PACKINGCHECKJ']);
        $data_inspection4 = array($row['INSPECTION4PERIOD'],$row['INSPECTION4OPERATORID'],$row['INSPECTION4IPADDRESS'],$row['INSPECTION4STARTDATETIME'],$row['INSPECTION4FINISHDATETIME'],$row['INSPECTION4JUDGMENT'],$row['INSPECTION4PACKINGCHECKCODE'],$row['INSPECTION4PACKINGCHECKJ']);
        $data_inspection5 = array($row['INSPECTION5PERIOD'],$row['INSPECTION5OPERATORID'],$row['INSPECTION5IPADDRESS'],$row['INSPECTION5STARTDATETIME'],$row['INSPECTION5FINISHDATETIME'],$row['INSPECTION5JUDGMENT'],$row['INSPECTION5PACKINGCHECKCODE'],$row['INSPECTION5PACKINGCHECKJ']);
        $data_inspection6 = array($row['INSPECTION6PERIOD'],$row['INSPECTION6OPERATORID'],$row['INSPECTION6IPADDRESS'],$row['INSPECTION6STARTDATETIME'],$row['INSPECTION6FINISHDATETIME'],$row['INSPECTION6JUDGMENT'],$row['INSPECTION6PACKINGCHECKCODE'],$row['INSPECTION6PACKINGCHECKJ']);
        $data_inspection7 = array($row['INSPECTION7PERIOD'],$row['INSPECTION7OPERATORID'],$row['INSPECTION7IPADDRESS'],$row['INSPECTION7STARTDATETIME'],$row['INSPECTION7FINISHDATETIME'],$row['INSPECTION7JUDGMENT'],$row['INSPECTION7PACKINGCHECKCODE'],$row['INSPECTION7PACKINGCHECKJ']);
        $data_inspection8 = array($row['INSPECTION8PERIOD'],$row['INSPECTION8OPERATORID'],$row['INSPECTION8IPADDRESS'],$row['INSPECTION8STARTDATETIME'],$row['INSPECTION8FINISHDATETIME'],$row['INSPECTION8JUDGMENT'],$row['INSPECTION8PACKINGCHECKCODE'],$row['INSPECTION8PACKINGCHECKJ']);
        $data_blank = array($row['LASTREPAIRCARDNUMBER'],$row['REPAIRRESULT'],$row['RESETSUPERVISORID'],$row['RESETSUPERVISORNAME'],$row['NOWMODE'],$row['MSGCODE'],$row['FINALINSPECTIONNAME'],$row['FINALINSPECTIONJUDGMENT']);
        $data_inspection9 = array($row['INSPECTION9PERIOD'],$row['INSPECTION9OPERATORID'],$row['INSPECTION9IPADDRESS'],$row['INSPECTION9STARTDATETIME'],$row['INSPECTION9FINISHDATETIME'],$row['INSPECTION9JUDGMENT'],$row['INSPECTION9PACKINGCHECKCODE'],$row['INSPECTION9PACKINGCHECKJ']);
        $data_inspection10 = array($row['INSPECTION10PERIOD'],$row['INSPECTION10OPERATORID'],$row['INSPECTION10IPADDRESS'],$row['INSPECTION10STARTDATETIME'],$row['INSPECTION10FINISHDATETIME'],$row['INSPECTION10JUDGMENT']);

        $combined_good_data = array_merge($data_register, $data_inspection1, $data_inspection2, $data_inspection3, $data_inspection4, $data_inspection5, $data_inspection6, $data_inspection7, $data_inspection8, $data_blank, $data_inspection9, $data_inspection10);
        
        fputcsv($f, $combined_good_data, $delimiter); 
        
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