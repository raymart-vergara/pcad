<?php 
include '../server_date_time.php';
require '../conn/ircs.php';
require '../conn/pcad.php';
include '../lib/emp_mgt.php';
include '../lib/main.php';
include '../lib/inspection_output.php';

switch (true) {
  case !isset($_GET['registlinename']):
    echo 'Query Parameters Not Set';
    exit;
}

$shift = $_GET['shift'];

$registlinename = $_GET['registlinename'];
// $registlinename = 'DAIHATSU_30';
$line_no = $_GET['line_no'];

$opt = $_GET['opt'];

$hourly_ng_date = $_GET['server_date_only'];
$hourly_ng_date_tomorrow = date('Y-m-d',(strtotime('+1 day',strtotime($hourly_ng_date))));

$delimiter = ","; 

$filename = "PCAD_NoGoodInspectionOutput_" . $server_date_only . "_" . $server_time . ".csv";
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 

// UTF-8 BOM for special character compatibility
fputs($f, "\xEF\xBB\xBF");

// Set column headers 
$f_h_blank1 = array('','','','','','','','','','','','','','','','','','','','','','','',''); 
$f_h_inspection1 = array('','','','','','','','','','','','','Inspection 1','','','','','','','','','','',''); 
$f_h_inspection2 = array('','','','','','','','','','','','','Inspection 2','','','','','','','','','','',''); 
$f_h_inspection3 = array('','','','','','','','','','','','','Inspection 3','','','','','','','','','','',''); 
$f_h_inspection4 = array('','','','','','','','','','','','','Inspection 4','','','','','','','','','','',''); 
$f_h_inspection5 = array('','','','','','','','','','','','','Inspection 5','','','','','','','','','','',''); 
$f_h_inspection6 = array('','','','','','','','','','','','','Inspection 6','','','','','','','','','','',''); 
$f_h_inspection7 = array('','','','','','','','','','','','','Inspection 7','','','','','','','','','','',''); 
$f_h_inspection8 = array('','','','','','','','','','','','','Inspection 8','','','','','','','','','','','','',''); 
$f_h_blank2 = array('','','','','',''); 
$f_h_infection = array('Infection',''); 
$f_h_check_infection = array('','','','','Check Infection','','','','',''); 
$f_h_inspection9 = array('','','','','','','','','','Inspection 9','','','','','','','','',''); 

$combined_h_fields = array_merge($f_h_blank1, $f_h_inspection1, $f_h_inspection2, $f_h_inspection3, $f_h_inspection4, $f_h_inspection5, $f_h_inspection6, $f_h_inspection7, $f_h_inspection8, $f_h_blank2, $f_h_infection, $f_h_check_infection, $f_h_inspection9);

fputcsv($f, $combined_h_fields, $delimiter); 

// Set column headers 
$f_c_blank1 = array('Repair Card Number','Repair Start Date Time','Repair Finish Date Time','Repair Device ID','Operator ID','Repair Judgement','Discovery Process','NG Content','NG Content Detail','Repair Content','Outbreak Process','Outbreak Operator','Registered Date Time','Registered Company Code','Registered Department Code','Registered Line Number','Registered Process','Registered Device ID','IP Address','Registered Operator ID','Parts Name','Lot','Serial','Read Name'); 
$f_c_inspection1 = array('Inspection 1 Process','Inspection 1 Period','Inspection 1 Operator ID','Inspection 1 IP Address','Inspection 1 Start Date Time','Inspection 1 Finish Date Time','Inspection 1 Judgement','Inspection 1 ReadOp 1 Name','Inspection 1 ReadOp 1 Name Judgement','Inspection 1 ReadOp 2 Name','Inspection 1 ReadOp 2 Name Judgement','Inspection 1 ReadOp 3 Name','Inspection 1 ReadOp 3 Name Judgement','Inspection 1 ReadOp 4 Name','Inspection 1 ReadOp 4 Name Judgement','Inspection 1 Seal Rubber Detect Judgement','Inspection 1 F1 Judgement','Inspection 1 F2 Judgement','Inspection 1 F3 Judgement','Inspection 1 F4 Judgement','Inspection 1 F5 Judgement','Inspection 1 F6 Judgement','Inspection 1 Packing Check Code','Inspection 1 Packing Check Judgement'); 
$f_c_inspection2 = array('Inspection 2 Process','Inspection 2 Period','Inspection 2 Operator ID','Inspection 2 IP Address','Inspection 2 Start Date Time','Inspection 2 Finish Date Time','Inspection 2 Judgement','Inspection 2 ReadOp 1 Name','Inspection 2 ReadOp 1 Name Judgement','Inspection 2 ReadOp 2 Name','Inspection 2 ReadOp 2 Name Judgement','Inspection 2 ReadOp 3 Name','Inspection 2 ReadOp 3 Name Judgement','Inspection 2 ReadOp 4 Name','Inspection 2 ReadOp 4 Name Judgement','Inspection 2 Seal Rubber Detect Judgement','Inspection 2 F1 Judgement','Inspection 2 F2 Judgement','Inspection 2 F3 Judgement','Inspection 2 F4 Judgement','Inspection 2 F5 Judgement','Inspection 2 F6 Judgement','Inspection 2 Packing Check Code','Inspection 2 Packing Check Judgement'); 
$f_c_inspection3 = array('Inspection 3 Process','Inspection 3 Period','Inspection 3 Operator ID','Inspection 3 IP Address','Inspection 3 Start Date Time','Inspection 3 Finish Date Time','Inspection 3 Judgement','Inspection 3 ReadOp 1 Name','Inspection 3 ReadOp 1 Name Judgement','Inspection 3 ReadOp 2 Name','Inspection 3 ReadOp 2 Name Judgement','Inspection 3 ReadOp 3 Name','Inspection 3 ReadOp 3 Name Judgement','Inspection 3 ReadOp 4 Name','Inspection 3 ReadOp 4 Name Judgement','Inspection 3 Seal Rubber Detect Judgement','Inspection 3 F1 Judgement','Inspection 3 F2 Judgement','Inspection 3 F3 Judgement','Inspection 3 F4 Judgement','Inspection 3 F5 Judgement','Inspection 3 F6 Judgement','Inspection 3 Packing Check Code','Inspection 3 Packing Check Judgement');
$f_c_inspection4 = array('Inspection 4 Process','Inspection 4 Period','Inspection 4 Operator ID','Inspection 4 IP Address','Inspection 4 Start Date Time','Inspection 4 Finish Date Time','Inspection 4 Judgement','Inspection 4 ReadOp 1 Name','Inspection 4 ReadOp 1 Name Judgement','Inspection 4 ReadOp 2 Name','Inspection 4 ReadOp 2 Name Judgement','Inspection 4 ReadOp 3 Name','Inspection 4 ReadOp 3 Name Judgement','Inspection 4 ReadOp 4 Name','Inspection 4 ReadOp 4 Name Judgement','Inspection 4 Seal Rubber Detect Judgement','Inspection 4 F1 Judgement','Inspection 4 F2 Judgement','Inspection 4 F3 Judgement','Inspection 4 F4 Judgement','Inspection 4 F5 Judgement','Inspection 4 F6 Judgement','Inspection 4 Packing Check Code','Inspection 4 Packing Check Judgement');
$f_c_inspection5 = array('Inspection 5 Process','Inspection 5 Period','Inspection 5 Operator ID','Inspection 5 IP Address','Inspection 5 Start Date Time','Inspection 5 Finish Date Time','Inspection 5 Judgement','Inspection 5 ReadOp 1 Name','Inspection 5 ReadOp 1 Name Judgement','Inspection 5 ReadOp 2 Name','Inspection 5 ReadOp 2 Name Judgement','Inspection 5 ReadOp 3 Name','Inspection 5 ReadOp 3 Name Judgement','Inspection 5 ReadOp 4 Name','Inspection 5 ReadOp 4 Name Judgement','Inspection 5 Seal Rubber Detect Judgement','Inspection 5 F1 Judgement','Inspection 5 F2 Judgement','Inspection 5 F3 Judgement','Inspection 5 F4 Judgement','Inspection 5 F5 Judgement','Inspection 5 F6 Judgement','Inspection 5 Packing Check Code','Inspection 5 Packing Check Judgement');
$f_c_inspection6 = array('Inspection 6 Process','Inspection 6 Period','Inspection 6 Operator ID','Inspection 6 IP Address','Inspection 6 Start Date Time','Inspection 6 Finish Date Time','Inspection 6 Judgement','Inspection 6 ReadOp 1 Name','Inspection 6 ReadOp 1 Name Judgement','Inspection 6 ReadOp 2 Name','Inspection 6 ReadOp 2 Name Judgement','Inspection 6 ReadOp 3 Name','Inspection 6 ReadOp 3 Name Judgement','Inspection 6 ReadOp 4 Name','Inspection 6 ReadOp 4 Name Judgement','Inspection 6 Seal Rubber Detect Judgement','Inspection 6 F1 Judgement','Inspection 6 F2 Judgement','Inspection 6 F3 Judgement','Inspection 6 F4 Judgement','Inspection 6 F5 Judgement','Inspection 6 F6 Judgement','Inspection 6 Packing Check Code','Inspection 6 Packing Check Judgement'); 
$f_c_inspection7 = array('Inspection 7 Process','Inspection 7 Period','Inspection 7 Operator ID','Inspection 7 IP Address','Inspection 7 Start Date Time','Inspection 7 Finish Date Time','Inspection 7 Judgement','Inspection 7 ReadOp 1 Name','Inspection 7 ReadOp 1 Name Judgement','Inspection 7 ReadOp 2 Name','Inspection 7 ReadOp 2 Name Judgement','Inspection 7 ReadOp 3 Name','Inspection 7 ReadOp 3 Name Judgement','Inspection 7 ReadOp 4 Name','Inspection 7 ReadOp 4 Name Judgement','Inspection 7 Seal Rubber Detect Judgement','Inspection 7 F1 Judgement','Inspection 7 F2 Judgement','Inspection 7 F3 Judgement','Inspection 7 F4 Judgement','Inspection 7 F5 Judgement','Inspection 7 F6 Judgement','Inspection 7 Packing Check Code','Inspection 7 Packing Check Judgement');
$f_c_inspection8 = array('Inspection 8 Process','Inspection 8 Period','Inspection 8 Operator ID','Inspection 8 IP Address','Inspection 8 Start Date Time','Inspection 8 Finish Date Time','Inspection 8 Finish Date','Inspection 8 Finish Time','Inspection 8 Judgement','Inspection 8 ReadOp 1 Name','Inspection 8 ReadOp 1 Name Judgement','Inspection 8 ReadOp 2 Name','Inspection 8 ReadOp 2 Name Judgement','Inspection 8 ReadOp 3 Name','Inspection 8 ReadOp 3 Name Judgement','Inspection 8 ReadOp 4 Name','Inspection 8 ReadOp 4 Name Judgement','Inspection 8 Seal Rubber Detect Judgement','Inspection 8 F1 Judgement','Inspection 8 F2 Judgement','Inspection 8 F3 Judgement','Inspection 8 F4 Judgement','Inspection 8 F5 Judgement','Inspection 8 F6 Judgement','Inspection 8 Packing Check Code','Inspection 8 Packing Check Judgement'); 
$f_c_blank2 = array('Last Repair Card Number','Repair Result','Reset Supervisor ID','Reset Supervisor Name','Now Mode','Message Code'); 
$f_c_infection = array('Infection Start Date Time','Infection Finish Date Time'); 
$f_c_check_infection = array('Check Infection Shipped','Check Infection Completed','Check Infection Inspection','Check Infection Assy','Check Infection Sub','Check Infection Shikakari','Check Infection Parts','Check Infection Judgement','Check Infection Supervisor ID','Check Infection Supervisor Name'); 
$f_c_inspection9 = array('Inspection 9 Process','Inspection 9 Period','Inspection 9 Operator ID','Inspection 9 IP Address','Inspection 9 Start Date Time','Inspection 9 Finish Date Time','Inspection 9 Judgement','Inspection 9 ReadOp 1 Name','Inspection 9 ReadOp 1 Name Judgement','Inspection 9 ReadOp 2 Name','Inspection 9 ReadOp 2 Name Judgement','Inspection 9 ReadOp 3 Name','Inspection 9 ReadOp 3 Name Judgement','Inspection 9 ReadOp 4 Name','Inspection 9 ReadOp 4 Name Judgement','Inspection 9 Seal Rubber Detect Judgement','Inspection 9 F1 Judgement','Inspection 9 F2 Judgement','Inspection 9 F3 Judgement'); 

$combined_c_fields = array_merge($f_c_blank1, $f_c_inspection1, $f_c_inspection2, $f_c_inspection3, $f_c_inspection4, $f_c_inspection5, $f_c_inspection6, $f_c_inspection7, $f_c_inspection8, $f_c_blank2, $f_c_infection, $f_c_check_infection, $f_c_inspection9);

fputcsv($f, $combined_c_fields, $delimiter); 

$search_arr = array(
        'shift' => $shift,
        'registlinename' => $registlinename,
        'line_no' => $line_no,
        'server_date_only' => $server_date_only,
        'server_date_only_yesterday' => $server_date_only_yesterday,
        'server_date_only_tomorrow' => $server_date_only_tomorrow,
        'server_time' => $server_time,
        'hourly_ng_date' => $hourly_ng_date,
        'hourly_ng_date_tomorrow' => $hourly_ng_date_tomorrow,
        'opt' => $opt
);

$list_of_no_good_viewer = get_rows_overall_ng($search_arr, $conn_ircs, $conn_pcad);

//Output each row of the data, format line as csv and write to file pointer 
foreach ($list_of_no_good_viewer as &$row) {

        // $lineData = array($row['parts_name'], $row['st']); 
        $data_blank1 = array($row['REPAIRCARDNUMBER'],$row['REPAIRSTARTDATETIME'],$row['RPAIRFINISHDATETIME'],$row['REPAIRDEVICEID'],$row['OPERATORID'],$row['REPAIRJUDGMENT'],$row['DISCOVERYPROCESS'],$row['NGCONTENT'],$row['NGCONTENTDETAIL'],$row['REPAIRCONTENT'],$row['OUTBREAKPROCESS'],$row['OUTBREAKOPERATOR'],$row['REGISTDATETIME'],$row['REGISTCAMPANYCODE'],$row['REGISTDEPARTMENTCODE'],$row['REGISTLINENAME'],$row['REGISTPROCESS'],$row['REGISTDEVICEID'],$row['IPADDRESS'],$row['REGISTOPERATORID'],$row['PARTSNAME'],$row['LOT'],$row['SERIAL'],$row['READNAME']);
        $data_inspection1 = array($row['INSPECTION1PROCESS'],$row['INSPECTION1PERIOD'],$row['INSPECTION1OPERATORID'],$row['INSPECTION1IPADDRESS'],$row['INSPECTION1STARTDATETIME'],$row['INSPECTION1FINISHDATETIME'],$row['INSPECTION1JUDGMENT'],$row['INSPECTION1READOP1NAME'],$row['INSPECTION1READOP1NAMEJ'],$row['INSPECTION1READOP2NAME'],$row['INSPECTION1READOP2NAMEJ'],$row['INSPECTION1READOP3NAME'],$row['INSPECTION1READOP3NAMEJ'],$row['INSPECTION1READOP4NAME'],$row['INSPECTION1READOP4NAMEJ'],$row['INSPECTION1SEALRUBBERDETECTJ'],$row['INSPECTION1F1JUDGMENT'],$row['INSPECTION1F2JUDGMENT'],$row['INSPECTION1F3JUDGMENT'],$row['INSPECTION1F4JUDGMENT'],$row['INSPECTION1F5JUDGMENT'],$row['INSPECTION1F6JUDGMENT'],$row['INSPECTION1PACKINGCHECKCODE'],$row['INSPECTION1PACKINGCHECKJ']);
        $data_inspection2 = array($row['INSPECTION2PROCESS'],$row['INSPECTION2PERIOD'],$row['INSPECTION2OPERATORID'],$row['INSPECTION2IPADDRESS'],$row['INSPECTION2STARTDATETIME'],$row['INSPECTION2FINISHDATETIME'],$row['INSPECTION2JUDGMENT'],$row['INSPECTION2READOP1NAME'],$row['INSPECTION2READOP1NAMEJ'],$row['INSPECTION2READOP2NAME'],$row['INSPECTION2READOP2NAMEJ'],$row['INSPECTION2READOP3NAME'],$row['INSPECTION2READOP3NAMEJ'],$row['INSPECTION2READOP4NAME'],$row['INSPECTION2READOP4NAMEJ'],$row['INSPECTION2SEALRUBBERDETECTJ'],$row['INSPECTION2F1JUDGMENT'],$row['INSPECTION2F2JUDGMENT'],$row['INSPECTION2F3JUDGMENT'],$row['INSPECTION2F4JUDGMENT'],$row['INSPECTION2F5JUDGMENT'],$row['INSPECTION2F6JUDGMENT'],$row['INSPECTION2PACKINGCHECKCODE'],$row['INSPECTION2PACKINGCHECKJ']);
        $data_inspection3 = array($row['INSPECTION3PROCESS'],$row['INSPECTION3PERIOD'],$row['INSPECTION3OPERATORID'],$row['INSPECTION3IPADDRESS'],$row['INSPECTION3STARTDATETIME'],$row['INSPECTION3FINISHDATETIME'],$row['INSPECTION3JUDGMENT'],$row['INSPECTION3READOP1NAME'],$row['INSPECTION3READOP1NAMEJ'],$row['INSPECTION3READOP2NAME'],$row['INSPECTION3READOP2NAMEJ'],$row['INSPECTION3READOP3NAME'],$row['INSPECTION3READOP3NAMEJ'],$row['INSPECTION3READOP4NAME'],$row['INSPECTION3READOP4NAMEJ'],$row['INSPECTION3SEALRUBBERDETECTJ'],$row['INSPECTION3F1JUDGMENT'],$row['INSPECTION3F2JUDGMENT'],$row['INSPECTION3F3JUDGMENT'],$row['INSPECTION3F4JUDGMENT'],$row['INSPECTION3F5JUDGMENT'],$row['INSPECTION3F6JUDGMENT'],$row['INSPECTION3PACKINGCHECKCODE'],$row['INSPECTION3PACKINGCHECKJ']);
        $data_inspection4 = array($row['INSPECTION4PROCESS'],$row['INSPECTION4PERIOD'],$row['INSPECTION4OPERATORID'],$row['INSPECTION4IPADDRESS'],$row['INSPECTION4STARTDATETIME'],$row['INSPECTION4FINISHDATETIME'],$row['INSPECTION4JUDGMENT'],$row['INSPECTION4READOP1NAME'],$row['INSPECTION4READOP1NAMEJ'],$row['INSPECTION4READOP2NAME'],$row['INSPECTION4READOP2NAMEJ'],$row['INSPECTION4READOP3NAME'],$row['INSPECTION4READOP3NAMEJ'],$row['INSPECTION4READOP4NAME'],$row['INSPECTION4READOP4NAMEJ'],$row['INSPECTION4SEALRUBBERDETECTJ'],$row['INSPECTION4F1JUDGMENT'],$row['INSPECTION4F2JUDGMENT'],$row['INSPECTION4F3JUDGMENT'],$row['INSPECTION4F4JUDGMENT'],$row['INSPECTION4F5JUDGMENT'],$row['INSPECTION4F6JUDGMENT'],$row['INSPECTION4PACKINGCHECKCODE'],$row['INSPECTION4PACKINGCHECKJ']);
        $data_inspection5 = array($row['INSPECTION5PROCESS'],$row['INSPECTION5PERIOD'],$row['INSPECTION5OPERATORID'],$row['INSPECTION5IPADDRESS'],$row['INSPECTION5STARTDATETIME'],$row['INSPECTION5FINISHDATETIME'],$row['INSPECTION5JUDGMENT'],$row['INSPECTION5READOP1NAME'],$row['INSPECTION5READOP1NAMEJ'],$row['INSPECTION5READOP2NAME'],$row['INSPECTION5READOP2NAMEJ'],$row['INSPECTION5READOP3NAME'],$row['INSPECTION5READOP3NAMEJ'],$row['INSPECTION5READOP4NAME'],$row['INSPECTION5READOP4NAMEJ'],$row['INSPECTION5SEALRUBBERDETECTJ'],$row['INSPECTION5F1JUDGMENT'],$row['INSPECTION5F2JUDGMENT'],$row['INSPECTION5F3JUDGMENT'],$row['INSPECTION5F4JUDGMENT'],$row['INSPECTION5F5JUDGMENT'],$row['INSPECTION5F6JUDGMENT'],$row['INSPECTION5PACKINGCHECKCODE'],$row['INSPECTION5PACKINGCHECKJ']);
        $data_inspection6 = array($row['INSPECTION6PROCESS'],$row['INSPECTION6PERIOD'],$row['INSPECTION6OPERATORID'],$row['INSPECTION6IPADDRESS'],$row['INSPECTION6STARTDATETIME'],$row['INSPECTION6FINISHDATETIME'],$row['INSPECTION6JUDGMENT'],$row['INSPECTION6READOP1NAME'],$row['INSPECTION6READOP1NAMEJ'],$row['INSPECTION6READOP2NAME'],$row['INSPECTION6READOP2NAMEJ'],$row['INSPECTION6READOP3NAME'],$row['INSPECTION6READOP3NAMEJ'],$row['INSPECTION6READOP4NAME'],$row['INSPECTION6READOP4NAMEJ'],$row['INSPECTION6SEALRUBBERDETECTJ'],$row['INSPECTION6F1JUDGMENT'],$row['INSPECTION6F2JUDGMENT'],$row['INSPECTION6F3JUDGMENT'],$row['INSPECTION6F4JUDGMENT'],$row['INSPECTION6F5JUDGMENT'],$row['INSPECTION6F6JUDGMENT'],$row['INSPECTION6PACKINGCHECKCODE'],$row['INSPECTION6PACKINGCHECKJ']);
        $data_inspection7 = array($row['INSPECTION7PROCESS'],$row['INSPECTION7PERIOD'],$row['INSPECTION7OPERATORID'],$row['INSPECTION7IPADDRESS'],$row['INSPECTION7STARTDATETIME'],$row['INSPECTION7FINISHDATETIME'],$row['INSPECTION7JUDGMENT'],$row['INSPECTION7READOP1NAME'],$row['INSPECTION7READOP1NAMEJ'],$row['INSPECTION7READOP2NAME'],$row['INSPECTION7READOP2NAMEJ'],$row['INSPECTION7READOP3NAME'],$row['INSPECTION7READOP3NAMEJ'],$row['INSPECTION7READOP4NAME'],$row['INSPECTION7READOP4NAMEJ'],$row['INSPECTION7SEALRUBBERDETECTJ'],$row['INSPECTION7F1JUDGMENT'],$row['INSPECTION7F2JUDGMENT'],$row['INSPECTION7F3JUDGMENT'],$row['INSPECTION7F4JUDGMENT'],$row['INSPECTION7F5JUDGMENT'],$row['INSPECTION7F6JUDGMENT'],$row['INSPECTION7PACKINGCHECKCODE'],$row['INSPECTION7PACKINGCHECKJ']);
        $data_inspection8 = array($row['INSPECTION8PROCESS'],$row['INSPECTION8PERIOD'],$row['INSPECTION8OPERATORID'],$row['INSPECTION8IPADDRESS'],$row['INSPECTION8STARTDATETIME'],$row['INSPECTION8FINISHDATETIME'],$row['INSPECTION8FINISHDATE'],$row['INSPECTION8FINISHTIME'],$row['INSPECTION8JUDGMENT'],$row['INSPECTION8READOP1NAME'],$row['INSPECTION8READOP1NAMEJ'],$row['INSPECTION8READOP2NAME'],$row['INSPECTION8READOP2NAMEJ'],$row['INSPECTION8READOP3NAME'],$row['INSPECTION8READOP3NAMEJ'],$row['INSPECTION8READOP4NAME'],$row['INSPECTION8READOP4NAMEJ'],$row['INSPECTION8SEALRUBBERDETECTJ'],$row['INSPECTION8F1JUDGMENT'],$row['INSPECTION8F2JUDGMENT'],$row['INSPECTION8F3JUDGMENT'],$row['INSPECTION8F4JUDGMENT'],$row['INSPECTION8F5JUDGMENT'],$row['INSPECTION8F6JUDGMENT'],$row['INSPECTION8PACKINGCHECKCODE'],$row['INSPECTION8PACKINGCHECKJ']);
        $data_blank2 = array($row['LASTREPAIRCARDNUMBER'],$row['REPAIRRESULT'],$row['RESETSUPERVISORID'],$row['RESETSUPERVISORNAME'],$row['NOWMODE'],$row['MSGCODE'],$row['INFECTIONSTARTDATETIME'],$row['INFECTIONFINISHDATETIME']);
        $data_infection = array($row['INFECTIONSTARTDATETIME'],$row['INFECTIONFINISHDATETIME']);
        $data_check_infection = array($row['CHECKINFECTIONSHIPPED'],$row['CHECKINFECTIONCOMPLETED'],$row['CHECKINFECTIONINSPECTION'],$row['CHECKINFECTIONASSY'],$row['CHECKINFECTIONSUB'],$row['CHECKINFECTIONSHIKAKARI'],$row['CHECKINFECTIONPARTS'],$row['CHECKINFECTIONJUDGMENT'],$row['CHECKINFECTIONSUPERVISORID'],$row['CHECKINFECTIONSUPERVISORNAME']);
        $data_inspection9 = array($row['INSPECTION9PROCESS'],$row['INSPECTION9PERIOD'],$row['INSPECTION9OPERATORID'],$row['INSPECTION9IPADDRESS'],$row['INSPECTION9STARTDATETIME'],$row['INSPECTION9FINISHDATETIME'],$row['INSPECTION9JUDGMENT'],$row['INSPECTION9READOP1NAME'],$row['INSPECTION9READOP1NAMEJ'],$row['INSPECTION9READOP2NAME'],$row['INSPECTION9READOP2NAMEJ'],$row['INSPECTION9READOP3NAME'],$row['INSPECTION9READOP3NAMEJ'],$row['INSPECTION9READOP4NAME'],$row['INSPECTION9READOP4NAMEJ'],$row['INSPECTION9SEALRUBBERDETECTJ'],$row['INSPECTION9F1JUDGMENT'],$row['INSPECTION9F2JUDGMENT'],$row['INSPECTION9F3JUDGMENT']);
        
        $combined_no_good_data = array_merge($data_blank1,$data_inspection1, $data_inspection2, $data_inspection3, $data_inspection4, $data_inspection5, $data_inspection6, $data_inspection7, $data_inspection8, $data_blank2, $data_infection, $data_check_infection, $data_inspection9);

        fputcsv($f, $combined_no_good_data, $delimiter); 
}

// Move back to beginning of file 
fseek($f, 0); 
 
// Set headers to download file rather than displayed 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
 
//output all remaining data on a file pointer 
fpassthru($f); 

oci_close($conn_ircs);
$conn_pcad = null;
?>