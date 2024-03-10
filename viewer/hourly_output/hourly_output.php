<?php
include '../../process/server_date_time.php';
include '../../process/conn/pcad.php';
include 'plugins/header.php';
include 'plugins/preloader.php';
include 'plugins/navbar/hourly_output_navbar.php';

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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row mb-2 ml-1 mr-1">
            <div class="col-sm-6">
                <h1 class="m-0"> Hourly Output</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/pcad/">PCAD</a></li>
                    <li class="breadcrumb-item active">Hourly Output</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><img src="../../dist/img/clock.png" style="height:27px;">&ensp;Hourly Output Table</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-sm-3">
                                    <label>Line No.</label>
                                    <select id="line_no_search" class="form-control">
                                        <option value="">
                                            - - - -
                                        </option>
                                        <?php
                                        if ($ircs_lines) {
                                            foreach ($ircs_lines as $i => $ircs) {
                                                echo '<option value="' . $ircs['ircs_line'] . '">' . $ircs['ircs_line'] . ' (' . $ircs['line_no'] . ')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label>Date</label>
                                    <input type="date" class="form-control" id="hourly_output_date_search">
                                </div>
                                <div class="col-sm-3">
                                    <label>Shift</label>
                                    <select class="form-control" id="shift_search" style="width: 100%;" required>
                                        <option selected value="DS">DS</option>
                                        <option value="NS">NS</option>
                                        <option value="">All</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label>Target Output</label>
                                    <input type="number" class="form-control" id="target_output_search">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-3 offset-sm-6">
                                    <button type="button" class="btn bg-secondary btn-block"
                                        onclick="export_hourly_output()"><i class="fas fa-download"></i> Hourly
                                        Output</button>
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="btn bg-primary btn-block"
                                        onclick="get_hourly_output()"><i class="fas fa-search"></i> Search</button>
                                </div>
                            </div>
                            <div id="accordion_hourly_output_legend">
                                <div class="card shadow">
                                    <div class="card-header">
                                        <h4 class="card-title w-100">
                                            <a class="d-block w-100 text-dark" data-toggle="collapse"
                                                href="#collapseOneHourlyOutputLegend">
                                                Hourly Output Legend
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOneHourlyOutputLegend" class="collapse"
                                        data-parent="#accordion_hourly_output_legend">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4 col-lg-4 p-1 bg-success">
                                                    <center>Target Met</center>
                                                </div>
                                                <div class="col-sm-4 col-lg-4 p-1 bg-warning">
                                                    <center>Target Partially Met</center>
                                                </div>
                                                <div class="col-sm-4 col-lg-4 p-1 bg-danger">
                                                    <center>Target Not Met</center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="attendanceSummaryReportTableRes" class="table-responsive"
                                style="max-height: 500px; overflow: auto; display:inline-block;">
                                <table id="attendanceSummaryReportTable"
                                    class="table table-sm table-head-fixed table-foot-fixed text-nowrap table-hover">
                                    <thead style="text-align: center;">
                                        <tr>
                                            <th>#</th>
                                            <th>Line No.</th>
                                            <th>Date</th>
                                            <th>Hour</th>
                                            <th>Target Output</th>
                                            <th>Actual Output</th>
                                            <th>Gap</th>
                                        </tr>
                                    </thead>
                                    <tbody id="hourlyOutputData" style="text-align: center;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
include 'plugins/footer.php';
include 'plugins/js/hourly_output_script.php';
?>