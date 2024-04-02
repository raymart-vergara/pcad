<?php
include '../process/server_date_time.php';
include '../process/conn/pcad.php';
include 'plugins/header.php';
include 'plugins/preloader.php';
include 'plugins/navbar.php';

$ircs_lines = array();
$query = "SELECT * FROM m_ircs_line ORDER BY ircs_line ASC";
$result = $conn_pcad->query($query);

if ($result) {
        $ircs_lines = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
        $errorInfo = $conn_pcad->errorInfo();
        echo "Error: " . $errorInfo[2];
}
?>

<div class="content-wrapper" style="background: #FFF;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
                <div class="container-fluid">
                        <div class="row mb-2">
                                <div class="col-sm-6">
                                        <h1 class="m-0">Inspection Details</h1>
                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                        <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="">PCAD</a></li>
                                                <li class="breadcrumb-item active">Inspection Details</li>
                                        </ol>
                                </div><!-- /.col -->
                        </div><!-- /.row -->
                </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
                <div class="col-md-12 m-0 p-0">
                        <div class="card" style="border-top: 3px solid #313131;">
                                <div class="card-header">
                                        <h3 class="card-title"><img src="../dist/img/view.png"
                                                        style="height:28px;">&ensp;Inspection Output Table</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="row">
                                        <div class="col-sm-12">
                                                <div class="card card-light card-tabs" style="background: #fcfcfc;">
                                                        <div class="card-header p-0 border-bottom-0">
                                                                <ul class="nav nav-tabs" id="record-tab" role="tablist">
                                                                        <li class="nav-item" style="width: 320px; text-align: center;">
                                                                                <a class="nav-link active"
                                                                                        id="inspection_good_tab"
                                                                                        data-toggle="pill"
                                                                                        href="#inspection_good"
                                                                                        role="tab"
                                                                                        aria-controls="inspection_good"
                                                                                        aria-selected="true">List of Good</a>
                                                                        </li>
                                                                        <li>
                                                                                <a class="nav-link" style="width: 320px; text-align: center;"
                                                                                        id="inspection_no_good_tab"
                                                                                        data-toggle="pill"
                                                                                        href="#inspection_no_good"
                                                                                        role="tab"
                                                                                        aria-controls="inspection_no_good"
                                                                                        aria-selected="false">List of No Good</a>
                                                                        </li>
                                                                </ul>
                                                        </div>
                                                        <!-- /.card header -->
                                                        <div class="card-body">
                                                                <div class="tab-content" id="record-tabContent">
                                                                        <!-- first tab -->
                                                                        <div class="tab-pane fade show active"
                                                                                id="inspection_good" role="tabpanel"
                                                                                aria-labelledby="inspection_good_tab">
                                                                                <!-- main content -->
                                                                                <div class="row mt-2 mb-4">
                                                                                        <div class="col-sm-2">
                                                                                                <!-- export button -->
                                                                                                <button class="btn btn-block d-flex justify-content-left"
                                                                                                        id="export_good_record_viewer"
                                                                                                        onclick="export_good_record_viewer()"
                                                                                                        style="color:#fff;height:34px;border-radius:.25rem;font-size:15px;font-weight:normal; background: #226f54;"><img
                                                                                                                src="../dist/img/export.png"
                                                                                                                style="height:19px;">&nbsp;&nbsp;Export Good Inspection Details</button>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="row table-responsive m-0 p-0">
                                                                                        <table class="table col-12 table-head-fixed text-nowrap table-bordered table-hover table-header"
                                                                                                id="inspection_good_table"
                                                                                                style="background: #F9F9F9;">
                                                                                                <thead>
                                                                                                        <tr>
                                                                                                                <th rowspan="2" style="vertical-align: middle;">#</th>
                                                                                                                <th class="table-header" colspan="11">Register</th>
                                                                                                                <th class="table-header" colspan="8">Inspection 1</th>
                                                                                                                <th class="table-header" colspan="8">Inspection 2</th>
                                                                                                                <th class="table-header" colspan="8">Inspection 3</th>
                                                                                                                <th class="table-header" colspan="8">Inspection 4</th>
                                                                                                                <th class="table-header" colspan="8">Inspection 5</th>
                                                                                                                <th class="table-header" colspan="8">Inspection 6</th>
                                                                                                                <th class="table-header" colspan="8">Inspection 7</th>
                                                                                                                <th class="table-header" colspan="8">Inspection 8</th>
                                                                                                                <th class="table-header" colspan="8"></th>
                                                                                                                <th class="table-header" colspan="8">Inspection 9</th>
                                                                                                                <th class="table-header" colspan="6">Inspection 10</th>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <!-- register -->
                                                                                                                <th class="table-header">Date Time</th>
                                                                                                                <th class="table-header">Company Code</th>
                                                                                                                <th class="table-header">Department</th>
                                                                                                                <th class="table-header">Line Name</th>
                                                                                                                <th class="table-header">Process</th>
                                                                                                                <th class="table-header">Device ID</th>
                                                                                                                <th class="table-header">IP Address</th>
                                                                                                                <th class="table-header">Operator ID</th>
                                                                                                                <th class="table-header">Parts Name</th>
                                                                                                                <th class="table-header">Lot No.</th>
                                                                                                                <th class="table-header">Serial No.</th>

                                                                                                                <!-- inspection 1 -->
                                                                                                                <th class="table-header">Period</th>
                                                                                                                <th class="table-header">Operator ID</th>
                                                                                                                <th class="table-header">IP Address</th>
                                                                                                                <th class="table-header">Start Date/Time</th>
                                                                                                                <th class="table-header">Finished Date/Time</th>
                                                                                                                <th class="table-header">Judgement</th>
                                                                                                                <th class="table-header">Packing Check Code</th>
                                                                                                                <th class="table-header">Packing Check Judgement</th>

                                                                                                                <!-- inspection 2 -->
                                                                                                                <th class="table-header">Period</th>
                                                                                                                <th class="table-header">Operator ID</th>
                                                                                                                <th class="table-header">IP Address</th>
                                                                                                                <th class="table-header">Start Date/Time</th>
                                                                                                                <th class="table-header">Finished Date/Time</th>
                                                                                                                <th class="table-header">Judgement</th>
                                                                                                                <th class="table-header">Packing Check Code</th>
                                                                                                                <th class="table-header">Packing Check Judgement</th>

                                                                                                                <!-- inspection 3 -->
                                                                                                                <th class="table-header">Period</th>
                                                                                                                <th class="table-header">Operator ID</th>
                                                                                                                <th class="table-header">IP Address</th>
                                                                                                                <th class="table-header">Start Date/Time</th>
                                                                                                                <th class="table-header">Finished Date/Time</th>
                                                                                                                <th class="table-header">Judgement</th>
                                                                                                                <th class="table-header">Packing Check Code</th>
                                                                                                                <th class="table-header">Packing Check Judgement</th>

                                                                                                                <!-- inspection 4 -->
                                                                                                                <th class="table-header">Period</th>
                                                                                                                <th class="table-header">Operator ID</th>
                                                                                                                <th class="table-header">IP Address</th>
                                                                                                                <th class="table-header">Start Date/Time</th>
                                                                                                                <th class="table-header">Finished Date/Time</th>
                                                                                                                <th class="table-header">Judgement</th>
                                                                                                                <th class="table-header">Packing Check Code</th>
                                                                                                                <th class="table-header">Packing Check Judgement</th>

                                                                                                                <!-- inspection 5 -->
                                                                                                                <th class="table-header">Period</th>
                                                                                                                <th class="table-header">Operator ID</th>
                                                                                                                <th class="table-header">IP Address</th>
                                                                                                                <th class="table-header">Start Date/Time</th>
                                                                                                                <th class="table-header">Finished Date/Time</th>
                                                                                                                <th class="table-header">Judgement</th>
                                                                                                                <th class="table-header">Packing Check Code</th>
                                                                                                                <th class="table-header">Packing Check Judgement</th>

                                                                                                                <!-- inspection 6 -->
                                                                                                                <th class="table-header">Period</th>
                                                                                                                <th class="table-header">Operator ID</th>
                                                                                                                <th class="table-header">IP Address</th>
                                                                                                                <th class="table-header">Start Date/Time</th>
                                                                                                                <th class="table-header">Finished Date/Time</th>
                                                                                                                <th class="table-header">Judgement</th>
                                                                                                                <th class="table-header">Packing Check Code</th>
                                                                                                                <th class="table-header">Packing Check Judgement</th>

                                                                                                                <!-- inspection 7 -->
                                                                                                                <th class="table-header">Period</th>
                                                                                                                <th class="table-header">Operator ID</th>
                                                                                                                <th class="table-header">IP Address</th>
                                                                                                                <th class="table-header">Start Date/Time</th>
                                                                                                                <th class="table-header">Finished Date/Time</th>
                                                                                                                <th class="table-header">Judgement</th>
                                                                                                                <th class="table-header">Packing Check Code</th>
                                                                                                                <th class="table-header">Packing Check Judgement</th>

                                                                                                                <!-- inspection 8 -->
                                                                                                                <th class="table-header">Period</th>
                                                                                                                <th class="table-header">Operator ID</th>
                                                                                                                <th class="table-header">IP Address</th>
                                                                                                                <th class="table-header">Start Date/Time</th>
                                                                                                                <th class="table-header">Finished Date/Time</th>
                                                                                                                <th class="table-header">Judgement</th>
                                                                                                                <th class="table-header">Packing Check Code</th>
                                                                                                                <th class="table-header">Packing Check Judgement</th>

                                                                                                                <!--  -->
                                                                                                                <th class="table-header">Last Repair Card Number</th>
                                                                                                                <th class="table-header">Repair Result</th>
                                                                                                                <th class="table-header">Reset Supervisor ID</th>
                                                                                                                <th class="table-header">Reset Supervisor Name</th>
                                                                                                                <th class="table-header">Now Mode</th>
                                                                                                                <th class="table-header">Message Code</th>
                                                                                                                <th class="table-header">Final Inspection Name</th>
                                                                                                                <th class="table-header">Final Inspection Judgement</th>

                                                                                                                <!-- inspection 9 -->
                                                                                                                <th class="table-header">Period</th>
                                                                                                                <th class="table-header">Operator ID</th>
                                                                                                                <th class="table-header">IP Address</th>
                                                                                                                <th class="table-header">Start Date/Time</th>
                                                                                                                <th class="table-header">Finished Date/Time</th>
                                                                                                                <th class="table-header">Judgement</th>
                                                                                                                <th class="table-header">Packing Check Code</th>
                                                                                                                <th class="table-header">Packing Check Judgement</th>

                                                                                                                <!-- inspection 10 -->
                                                                                                                <th class="table-header">Period</th>
                                                                                                                <th class="table-header">Operator ID</th>
                                                                                                                <th class="table-header">IP Address</th>
                                                                                                                <th class="table-header">Start Date/Time</th>
                                                                                                                <th class="table-header">Finished Date/Time</th>
                                                                                                                <th class="table-header">Judgement</th>
                                                                                                        </tr>
                                                                                                </thead>
                                                                                                
                                                                                                <tbody class="mb-0"
                                                                                                        id="list_of_good_viewer">
                                                                                                        <!-- <tr>
                                                                                                                <td colspan="10" style="text-align: center;">
                                                                                                                        <div class="spinner-border text-dark" role="status">
                                                                                                                                <span class="sr-only">Loading...</span>
                                                                                                                        </div>
                                                                                                                </td>
                                                                                                        </tr> -->
                                                                                                </tbody>
                                                                                        </table>
                                                                                </div>
                                                                                <!-- /.end -->
                                                                        </div>
                                                                        <!-- /.first tab end -->

                                                                        <div class="tab-pane fade"
                                                                                id="inspection_no_good" role="tabpanel"
                                                                                aria-labelledby="inspection_no_good_tab">
                                                                                <!-- main content -->
                                                                                <div class="row mt-2 mb-4">
                                                                                        <div class="col-sm-2">
                                                                                                <!-- export button -->
                                                                                                <button class="btn btn-block d-flex justify-content-left"
                                                                                                        id="export_no_good_record_viewer"
                                                                                                        onclick="export_no_good_record_viewer()"
                                                                                                        style="color:#fff;height:34px;border-radius:.25rem;font-size:15px;font-weight:normal; background: #ca3f3f;"><img
                                                                                                                src="../dist/img/export.png"
                                                                                                                style="height:19px;">&nbsp;&nbsp;Export No Good Inspection Details</button>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="row table-responsive m-0 p-0">
                                                                                        <table class="table col-12 table-head-fixed text-nowrap table-bordered table-hover table-header"
                                                                                                id="inspection_no_good_table"
                                                                                                style="background: #F9F9F9;">
                                                                                                <thead>
                                                                                                        <tr>
                                                                                                                <th rowspan="2" style="vertical-align: middle;">#</th>
                                                                                                                <th class="table-header" colspan="24"></th>
                                                                                                                <th class="table-header" colspan="24">Inspection 1</th>
                                                                                                                <th class="table-header" colspan="24">Inspection 2</th>
                                                                                                                <th class="table-header" colspan="24">Inspection 3</th>
                                                                                                                <th class="table-header" colspan="24">Inspection 4</th>
                                                                                                                <th class="table-header" colspan="24">Inspection 5</th>
                                                                                                                <th class="table-header" colspan="24">Inspection 6</th>
                                                                                                                <th class="table-header" colspan="24">Inspection 7</th>
                                                                                                                <th class="table-header" colspan="26">Inspection 8</th>
                                                                                                                <th class="table-header" colspan="6"></th>
                                                                                                                <th class="table-header" colspan="2">Infection</th>
                                                                                                                <th class="table-header" colspan="10">Check Infection</th>
                                                                                                                <th class="table-header" colspan="19">Inspection 9</th>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <th class="table-header">Repair Card Number</th>
                                                                                                                <th class="table-header">Repair Start Date Time</th>
                                                                                                                <th class="table-header">Repair Finish Date Time</th>
                                                                                                                <th class="table-header">Repair Device ID</th>
                                                                                                                <th class="table-header">Operator ID</th>
                                                                                                                <th class="table-header">Repair Judgement</th>
                                                                                                                <th class="table-header">Discovery Process</th>
                                                                                                                <th class="table-header">NG Content</th>
                                                                                                                <th class="table-header">NG Content Detail</th>
                                                                                                                <th class="table-header">Repair Content</th>
                                                                                                                <th class="table-header">Outbreak Process</th>
                                                                                                                <th class="table-header">Outbreak Operator</th>
                                                                                                                <th class="table-header">Registered Date Time</th>
                                                                                                                <th class="table-header">Registered Company Code</th>
                                                                                                                <th class="table-header">Registered Department Code</th>
                                                                                                                <th class="table-header">Registered Line Name</th>
                                                                                                                <th class="table-header">Registered Process</th>
                                                                                                                <th class="table-header">Registered Device ID</th>
                                                                                                                <th class="table-header">IP Address</th>
                                                                                                                <th class="table-header">Registered Operator ID</th>
                                                                                                                <th class="table-header">Parts Name</th>
                                                                                                                <th class="table-header">Lot</th>
                                                                                                                <th class="table-header">Serial</th>
                                                                                                                <th class="table-header">Read Name</th>

                                                                                                                <!-- Inspection 1 -->
                                                                                                                <th class="table-header">Inspection 1 Process</th>
                                                                                                                <th class="table-header">Inspection 1 Period</th>
                                                                                                                <th class="table-header">Inspection 1 Operator ID</th>
                                                                                                                <th class="table-header">Inspection 1 IP Address</th>
                                                                                                                <th class="table-header">Inspection 1 Start Date Time</th>
                                                                                                                <th class="table-header">Inspection 1 Finish Date Time</th>
                                                                                                                <th class="table-header">Inspection 1 Judgement</th>
                                                                                                                <th class="table-header">Inspection 1 ReadOp 1 Name</th>
                                                                                                                <th class="table-header">Inspection 1 ReadOp 1 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 1 ReadOp 2 Name</th>
                                                                                                                <th class="table-header">Inspection 1 ReadOp 2 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 1 ReadOp 3 Name</th>
                                                                                                                <th class="table-header">Inspection 1 ReadOp 3 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 1 ReadOp 4 Name</th>
                                                                                                                <th class="table-header">Inspection 1 ReadOp 4 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 1 Seal Rubber Detect Judgement</th>
                                                                                                                <th class="table-header">Inspection 1 F1 Judgement</th>
                                                                                                                <th class="table-header">Inspection 1 F2 Judgement</th>
                                                                                                                <th class="table-header">Inspection 1 F3 Judgement</th>
                                                                                                                <th class="table-header">Inspection 1 F4 Judgement</th>
                                                                                                                <th class="table-header">Inspection 1 F5 Judgement</th>
                                                                                                                <th class="table-header">Inspection 1 F6 Judgement</th>
                                                                                                                <th class="table-header">Inspection 1 Packing Check Code</th>
                                                                                                                <th class="table-header">Inspection 1 Packing Check Judgement</th>

                                                                                                                <!-- Inspection 2 -->
                                                                                                                <th class="table-header">Inspection 2 Process</th>
                                                                                                                <th class="table-header">Inspection 2 Period</th>
                                                                                                                <th class="table-header">Inspection 2 Operator ID</th>
                                                                                                                <th class="table-header">Inspection 2 IP Address</th>
                                                                                                                <th class="table-header">Inspection 2 Start Date Time</th>
                                                                                                                <th class="table-header">Inspection 2 Finish Date Time</th>
                                                                                                                <th class="table-header">Inspection 2 Judgement</th>
                                                                                                                <th class="table-header">Inspection 2 ReadOp 1 Name</th>
                                                                                                                <th class="table-header">Inspection 2 ReadOp 1 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 2 ReadOp 2 Name</th>
                                                                                                                <th class="table-header">Inspection 2 ReadOp 2 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 2 ReadOp 3 Name</th>
                                                                                                                <th class="table-header">Inspection 2 ReadOp 3 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 2 ReadOp 4 Name</th>
                                                                                                                <th class="table-header">Inspection 2 ReadOp 4 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 2 Seal Rubber Detect Judgement</th>
                                                                                                                <th class="table-header">Inspection 2 F1 Judgement</th>
                                                                                                                <th class="table-header">Inspection 2 F2 Judgement</th>
                                                                                                                <th class="table-header">Inspection 2 F3 Judgement</th>
                                                                                                                <th class="table-header">Inspection 2 F4 Judgement</th>
                                                                                                                <th class="table-header">Inspection 2 F5 Judgement</th>
                                                                                                                <th class="table-header">Inspection 2 F6 Judgement</th>
                                                                                                                <th class="table-header">Inspection 2 Packing Check Code</th>
                                                                                                                <th class="table-header">Inspection 2 Packing Check Judgement</th>

                                                                                                                <!-- Inspection 3 -->
                                                                                                                <th class="table-header">Inspection 3 Process</th>
                                                                                                                <th class="table-header">Inspection 3 Period</th>
                                                                                                                <th class="table-header">Inspection 3 Operator ID</th>
                                                                                                                <th class="table-header">Inspection 3 IP Address</th>
                                                                                                                <th class="table-header">Inspection 3 Start Date Time</th>
                                                                                                                <th class="table-header">Inspection 3 Finish Date Time</th>
                                                                                                                <th class="table-header">Inspection 3 Judgement</th>
                                                                                                                <th class="table-header">Inspection 3 ReadOp 1 Name</th>
                                                                                                                <th class="table-header">Inspection 3 ReadOp 1 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 3 ReadOp 2 Name</th>
                                                                                                                <th class="table-header">Inspection 3 ReadOp 2 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 3 ReadOp 3 Name</th>
                                                                                                                <th class="table-header">Inspection 3 ReadOp 3 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 3 ReadOp 4 Name</th>
                                                                                                                <th class="table-header">Inspection 3 ReadOp 4 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 3 Seal Rubber Detect Judgement</th>
                                                                                                                <th class="table-header">Inspection 3 F1 Judgement</th>
                                                                                                                <th class="table-header">Inspection 3 F2 Judgement</th>
                                                                                                                <th class="table-header">Inspection 3 F3 Judgement</th>
                                                                                                                <th class="table-header">Inspection 3 F4 Judgement</th>
                                                                                                                <th class="table-header">Inspection 3 F5 Judgement</th>
                                                                                                                <th class="table-header">Inspection 3 F6 Judgement</th>
                                                                                                                <th class="table-header">Inspection 3 Packing Check Code</th>
                                                                                                                <th class="table-header">Inspection 3 Packing Check Judgement</th>

                                                                                                                <!-- Inspection 4 -->
                                                                                                                <th class="table-header">Inspection 4 Process</th>
                                                                                                                <th class="table-header">Inspection 4 Period</th>
                                                                                                                <th class="table-header">Inspection 4 Operator ID</th>
                                                                                                                <th class="table-header">Inspection 4 IP Address</th>
                                                                                                                <th class="table-header">Inspection 4 Start Date Time</th>
                                                                                                                <th class="table-header">Inspection 4 Finish Date Time</th>
                                                                                                                <th class="table-header">Inspection 4 Judgement</th>
                                                                                                                <th class="table-header">Inspection 4 ReadOp 1 Name</th>
                                                                                                                <th class="table-header">Inspection 4 ReadOp 1 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 4 ReadOp 2 Name</th>
                                                                                                                <th class="table-header">Inspection 4 ReadOp 2 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 4 ReadOp 3 Name</th>
                                                                                                                <th class="table-header">Inspection 4 ReadOp 3 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 4 ReadOp 4 Name</th>
                                                                                                                <th class="table-header">Inspection 4 ReadOp 4 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 4 Seal Rubber Detect Judgement</th>
                                                                                                                <th class="table-header">Inspection 4 F1 Judgement</th>
                                                                                                                <th class="table-header">Inspection 4 F2 Judgement</th>
                                                                                                                <th class="table-header">Inspection 4 F3 Judgement</th>
                                                                                                                <th class="table-header">Inspection 4 F4 Judgement</th>
                                                                                                                <th class="table-header">Inspection 4 F5 Judgement</th>
                                                                                                                <th class="table-header">Inspection 4 F6 Judgement</th>
                                                                                                                <th class="table-header">Inspection 4 Packing Check Code</th>
                                                                                                                <th class="table-header">Inspection 4 Packing Check Judgement</th>

                                                                                                                <!-- Inspection 5 -->
                                                                                                                <th class="table-header">Inspection 5 Process</th>
                                                                                                                <th class="table-header">Inspection 5 Period</th>
                                                                                                                <th class="table-header">Inspection 5 Operator ID</th>
                                                                                                                <th class="table-header">Inspection 5 IP Address</th>
                                                                                                                <th class="table-header">Inspection 5 Start Date Time</th>
                                                                                                                <th class="table-header">Inspection 5 Finish Date Time</th>
                                                                                                                <th class="table-header">Inspection 5 Judgement</th>
                                                                                                                <th class="table-header">Inspection 5 ReadOp 1 Name</th>
                                                                                                                <th class="table-header">Inspection 5 ReadOp 1 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 5 ReadOp 2 Name</th>
                                                                                                                <th class="table-header">Inspection 5 ReadOp 2 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 5 ReadOp 3 Name</th>
                                                                                                                <th class="table-header">Inspection 5 ReadOp 3 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 5 ReadOp 4 Name</th>
                                                                                                                <th class="table-header">Inspection 5 ReadOp 4 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 5 Seal Rubber Detect Judgement</th>
                                                                                                                <th class="table-header">Inspection 5 F1 Judgement</th>
                                                                                                                <th class="table-header">Inspection 5 F2 Judgement</th>
                                                                                                                <th class="table-header">Inspection 5 F3 Judgement</th>
                                                                                                                <th class="table-header">Inspection 5 F4 Judgement</th>
                                                                                                                <th class="table-header">Inspection 5 F5 Judgement</th>
                                                                                                                <th class="table-header">Inspection 5 F6 Judgement</th>
                                                                                                                <th class="table-header">Inspection 5 Packing Check Code</th>
                                                                                                                <th class="table-header">Inspection 5 Packing Check Judgement</th>

                                                                                                                <!-- Inspection 6 -->
                                                                                                                <th class="table-header">Inspection 6 Process</th>
                                                                                                                <th class="table-header">Inspection 6 Period</th>
                                                                                                                <th class="table-header">Inspection 6 Operator ID</th>
                                                                                                                <th class="table-header">Inspection 6 IP Address</th>
                                                                                                                <th class="table-header">Inspection 6 Start Date Time</th>
                                                                                                                <th class="table-header">Inspection 6 Finish Date Time</th>
                                                                                                                <th class="table-header">Inspection 6 Judgement</th>
                                                                                                                <th class="table-header">Inspection 6 ReadOp 1 Name</th>
                                                                                                                <th class="table-header">Inspection 6 ReadOp 1 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 6 ReadOp 2 Name</th>
                                                                                                                <th class="table-header">Inspection 6 ReadOp 2 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 6 ReadOp 3 Name</th>
                                                                                                                <th class="table-header">Inspection 6 ReadOp 3 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 6 ReadOp 4 Name</th>
                                                                                                                <th class="table-header">Inspection 6 ReadOp 4 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 6 Seal Rubber Detect Judgement</th>
                                                                                                                <th class="table-header">Inspection 6 F1 Judgement</th>
                                                                                                                <th class="table-header">Inspection 6 F2 Judgement</th>
                                                                                                                <th class="table-header">Inspection 6 F3 Judgement</th>
                                                                                                                <th class="table-header">Inspection 6 F4 Judgement</th>
                                                                                                                <th class="table-header">Inspection 6 F5 Judgement</th>
                                                                                                                <th class="table-header">Inspection 6 F6 Judgement</th>
                                                                                                                <th class="table-header">Inspection 6 Packing Check Code</th>
                                                                                                                <th class="table-header">Inspection 6 Packing Check Judgement</th>

                                                                                                                <!-- Inspection 7 -->
                                                                                                                <th class="table-header">Inspection 7 Process</th>
                                                                                                                <th class="table-header">Inspection 7 Period</th>
                                                                                                                <th class="table-header">Inspection 7 Operator ID</th>
                                                                                                                <th class="table-header">Inspection 7 IP Address</th>
                                                                                                                <th class="table-header">Inspection 7 Start Date Time</th>
                                                                                                                <th class="table-header">Inspection 7 Finish Date Time</th>
                                                                                                                <th class="table-header">Inspection 7 Judgement</th>
                                                                                                                <th class="table-header">Inspection 7 ReadOp 1 Name</th>
                                                                                                                <th class="table-header">Inspection 7 ReadOp 1 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 7 ReadOp 2 Name</th>
                                                                                                                <th class="table-header">Inspection 7 ReadOp 2 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 7 ReadOp 3 Name</th>
                                                                                                                <th class="table-header">Inspection 7 ReadOp 3 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 7 ReadOp 4 Name</th>
                                                                                                                <th class="table-header">Inspection 7 ReadOp 4 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 7 Seal Rubber Detect Judgement</th>
                                                                                                                <th class="table-header">Inspection 7 F1 Judgement</th>
                                                                                                                <th class="table-header">Inspection 7 F2 Judgement</th>
                                                                                                                <th class="table-header">Inspection 7 F3 Judgement</th>
                                                                                                                <th class="table-header">Inspection 7 F4 Judgement</th>
                                                                                                                <th class="table-header">Inspection 7 F5 Judgement</th>
                                                                                                                <th class="table-header">Inspection 7 F6 Judgement</th>
                                                                                                                <th class="table-header">Inspection 7 Packing Check Code</th>
                                                                                                                <th class="table-header">Inspection 7 Packing Check Judgement</th>

                                                                                                                <!-- Inspection 8 -->
                                                                                                                <th class="table-header">Inspection 8 Process</th>
                                                                                                                <th class="table-header">Inspection 8 Period</th>
                                                                                                                <th class="table-header">Inspection 8 Operator ID</th>
                                                                                                                <th class="table-header">Inspection 8 IP Address</th>
                                                                                                                <th class="table-header">Inspection 8 Start Date Time</th>
                                                                                                                <th class="table-header">Inspection 8 Finish Date Time</th>
                                                                                                                <th class="table-header">Inspection 8 Finish Date</th>
                                                                                                                <th class="table-header">Inspection 8 Finish Time</th>
                                                                                                                <th class="table-header">Inspection 8 Judgement</th>
                                                                                                                <th class="table-header">Inspection 8 ReadOp 1 Name</th>
                                                                                                                <th class="table-header">Inspection 8 ReadOp 1 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 8 ReadOp 2 Name</th>
                                                                                                                <th class="table-header">Inspection 8 ReadOp 2 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 8 ReadOp 3 Name</th>
                                                                                                                <th class="table-header">Inspection 8 ReadOp 3 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 8 ReadOp 4 Name</th>
                                                                                                                <th class="table-header">Inspection 8 ReadOp 4 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 8 Seal Rubber Detect Judgement</th>
                                                                                                                <th class="table-header">Inspection 8 F1 Judgement</th>
                                                                                                                <th class="table-header">Inspection 8 F2 Judgement</th>
                                                                                                                <th class="table-header">Inspection 8 F3 Judgement</th>
                                                                                                                <th class="table-header">Inspection 8 F4 Judgement</th>
                                                                                                                <th class="table-header">Inspection 8 F5 Judgement</th>
                                                                                                                <th class="table-header">Inspection 8 F6 Judgement</th>
                                                                                                                <th class="table-header">Inspection 8 Packing Check Code</th>
                                                                                                                <th class="table-header">Inspection 8 Packing Check Judgement</th>

                                                                                                                <!--  -->
                                                                                                                <th class="table-header">Last Repair Card Number</th>
                                                                                                                <th class="table-header">Repair Result</th>
                                                                                                                <th class="table-header">Reset Supervisor ID</th>
                                                                                                                <th class="table-header">Reset Supervisor Name</th>
                                                                                                                <th class="table-header">Now Mode</th>
                                                                                                                <th class="table-header">Message Code</th>

                                                                                                                <!-- Infection -->
                                                                                                                <th class="table-header">Infection Start Date Time</th>
                                                                                                                <th class="table-header">Infection Finish Date Time</th>

                                                                                                                <!-- Check Infection -->
                                                                                                                <th class="table-header">Check Infection Shipped</th>
                                                                                                                <th class="table-header">Check Infection Completed</th>
                                                                                                                <th class="table-header">Check Infection Inspection</th>
                                                                                                                <th class="table-header">Check Infection Assy</th>
                                                                                                                <th class="table-header">Check Infection Sub</th>
                                                                                                                <th class="table-header">Check Infection Shikakari</th>
                                                                                                                <th class="table-header">Check Infection Parts</th>
                                                                                                                <th class="table-header">Check Infection Judgement</th>
                                                                                                                <th class="table-header">Check Infection Supervisor ID</th>
                                                                                                                <th class="table-header">Check Infection Supervisor Name</th>

                                                                                                                <!-- Inspection 9 -->
                                                                                                                <th class="table-header">Inspection 9 Process</th>
                                                                                                                <th class="table-header">Inspection 9 Period</th>
                                                                                                                <th class="table-header">Inspection 9 Operator ID</th>
                                                                                                                <th class="table-header">Inspection 9 IP Address</th>
                                                                                                                <th class="table-header">Inspection 9 Start Date Time</th>
                                                                                                                <th class="table-header">Inspection 9 Finish Date Time</th>
                                                                                                                <th class="table-header">Inspection 9 Judgement</th>
                                                                                                                <th class="table-header">Inspection 9 ReadOp 1 Name</th>
                                                                                                                <th class="table-header">Inspection 9 ReadOp 1 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 9 ReadOp 2 Name</th>
                                                                                                                <th class="table-header">Inspection 9 ReadOp 2 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 9 ReadOp 3 Name</th>
                                                                                                                <th class="table-header">Inspection 9 ReadOp 3 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 9 ReadOp 4 Name</th>
                                                                                                                <th class="table-header">Inspection 9 ReadOp 4 Name Judgement</th>
                                                                                                                <th class="table-header">Inspection 9 Seal Rubber Detect Judgement</th>
                                                                                                                <th class="table-header">Inspection 9 F1 Judgement</th>
                                                                                                                <th class="table-header">Inspection 9 F2 Judgement</th>
                                                                                                                <th class="table-header">Inspection 9 F3 Judgement</th>
                                                                                                        </tr>
                                                                                                </thead>
                                                                                                <tbody class="mb-0"
                                                                                                        id="list_of_no_good_viewer">
                                                                                                        <!--  -->
                                                                                                </tbody>
                                                                                        </table>
                                                                                </div>
                                                                                <!-- /.end -->
                                                                        </div>
                                                                        <!-- /.second tab end -->
                                                                </div>
                                                        </div>
                                                        <!-- /.card body end -->
                                                </div>
                                        </div>
                                </div>


                        </div>
                </div>
        </section>

        <!-- return to top button -->
        <!-- <button id="back-to-top" type="button" class="return-to-top"><i class="nav-icon-top nav-icon fas fa-caret-square-up"></i></button> -->

</div>


<?php
include 'plugins/footer.php';
include 'plugins/js/inspection_output_script.php';
?>