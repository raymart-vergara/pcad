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
                <div class="container-fluid">
                        <div class="row">
                                <div class="col-md-12 m-0 p-0">
                                        <div class="card" style="border-top: 3px solid #226f54;"
                                                id="proceed_to_good_table">
                                                <div class="card-header">
                                                        <h3 class="card-title"><img src="../dist/img/view.png"
                                                                        style="height:28px;">&ensp;Good Inspection
                                                                Output Table</h3>
                                                        <div class="card-tools">
                                                                <button type="button" class="btn btn-tool"
                                                                        data-card-widget="collapse">
                                                                        <i class="fas fa-minus"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-tool"
                                                                        data-card-widget="maximize">
                                                                        <i class="fas fa-expand"></i>
                                                                </button>
                                                        </div>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="row">
                                                        <div class="col-sm-12">
                                                                <div class="card card-light"
                                                                        style="background: #fcfcfc;">
                                                                        <div class="m-4">
                                                                                <!-- main content -->
                                                                                <div class="row mt-2 mb-4">
                                                                                        <div class="col-sm-3 col-md-3">
                                                                                                <!-- export button -->
                                                                                                <button class="btn btn-block"
                                                                                                        style="background: #226f54; color: #fff;"
                                                                                                        onmouseover="this.style.backgroundColor='#174B39'; this.style.color='#fff';"
                                                                                                        onmouseout="this.style.backgroundColor='#226f54'; this.style.color='#fff';"
                                                                                                        id="export_good_record_viewer"
                                                                                                        onclick="export_good_record_viewer()"><i
                                                                                                                class="fas fa-download">
                                                                                                        </i>&nbsp;&nbsp;Export
                                                                                                        Good Inspection
                                                                                                        Details
                                                                                                </button>
                                                                                        </div>
                                                                                </div>
                                                                                <div
                                                                                        class="row table-responsive m-0 p-0">
                                                                                        <table class="table col-12 table-head-fixed text-nowrap table-bordered table-hover table-header"
                                                                                                id="inspection_good_table"
                                                                                                style="background: #F9F9F9;">
                                                                                                <tbody class="mb-0"
                                                                                                        id="list_of_good_viewer">
                                                                                                </tbody>
                                                                                        </table>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </section>
</div>


<?php
include 'plugins/footer.php';
include 'plugins/js/inspection_output_script.php';
?>