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
                        <div class="card" style="border-top: 5px solid #226f54;" id="proceed_to_good_table">
                                <div class="card-header">
                                        <h3 class="card-title"><img src="../dist/img/view.png"
                                                        style="height:28px;">&ensp;Good Inspection Output Table</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="row">
                                        <div class="col-sm-12">
                                                <div class="card card-light" style="background: #fcfcfc;">
                                                        <div class="m-4">
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

