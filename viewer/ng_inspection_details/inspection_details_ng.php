<?php
include '../../process/server_date_time.php';
include '../../process/conn/pcad.php';
include 'plugins/header.php';
include 'plugins/preloader.php';
include 'plugins/navbar/ng_inspection_output_navbar.php';

$ircs_lines = array();
$query = "SELECT * FROM m_ircs_line ORDER BY ircs_line ASC";
$result = $conn_pcad->query($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

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
                    <h1 class="m-0">NG Inspection Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">PCAD</a></li>
                        <li class="breadcrumb-item active">NG Inspection Details</li>
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
                <div class="col-md-12">
                    <div class="card" style="border-top: 3px solid #ca3f3f;" id="proceed_to_no_good_table">
                        <div class="card-header">
                            <h3 class="card-title"><img src="../../dist/img/view.png" style="height:28px;">&ensp; No
                                Good Inspection
                                Output Table</h3>
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
                        <div class="card-body card-light" style="background: #fcfcfc;">
                            <!-- main content -->
                            <div class="row mt-2 mb-4">
                                <div class="col-sm-3 col-md-3">
                                    <!-- export button -->
                                    <button class="btn btn-block" style="background: #ca3f3f; color: #fff;"
                                        onmouseover="this.style.backgroundColor='#9F3131'; this.style.color='#fff';"
                                        onmouseout="this.style.backgroundColor='#ca3f3f'; this.style.color='#fff';"
                                        id="export_no_good_record_viewer" onclick="export_no_good_record_viewer()">
                                        <i class="fas fa-download"></i>
                                        &nbsp;&nbsp;Export No Good Inspection
                                        Details
                                    </button>
                                </div>
                            </div>
                            <div class="row table-responsive m-0 p-0">
                                <table
                                    class="table col-12 table-head-fixed text-nowrap table-bordered table-hover table-header"
                                    id="inspection_no_good_table" style="background: #F9F9F9;">
                                    <tbody class="mb-0" id="list_of_no_good_viewer">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card" style="border-top: 3px solid #ca3f3f;">
                        <div class="card-header">
                            <h3 class="card-title"><img src="../../dist/img/alert.png" style="height:28px;">&ensp;Hourly
                                Defect Count Per Process</h3>
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
                                <div class="col-sm-2" hidden>
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
                                <div class="col-sm-2" hidden>
                                    <label>Date</label>
                                    <input type="date" class="form-control" id="hourly_output_date_search">
                                </div>
                                <div class="col-sm-2" hidden>
                                    <label>Shift</label>
                                    <select class="form-control" id="shift_search" style="width: 100%;" required>
                                        <option selected value="DS">DS</option>
                                        <option value="NS">NS</option>
                                        <option value="">All</option>
                                    </select>
                                </div>
                                <div class="col-sm-2" hidden>
                                    <label>Target Output</label>
                                    <input type="number" class="form-control" id="target_output_search">
                                </div>
                                <div class="col-sm-2 offset-sm-2" hidden>
                                    <label>&ensp;</label>
                                    <button type="button" class="btn bg-primary btn-block"
                                        onclick="get_ng_hourly_output_per_process()"><i class="fas fa-search"></i>
                                        Search</button>
                                </div>
                            </div>
                            <!--  -->
                            <div id="ngHourlyOutputProcessTableRes" class="table-responsive"
                                style="max-height: 500px; overflow: auto; display:inline-block;">
                                <table id="ngHourlyOutputProcessTable"
                                    class="table table-sm table-head-fixed table-foot-fixed text-nowrap table-bordered">
                                    <tbody id="ngHourlyOutputProcessData" style="text-align: center;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card" style="border-top: 3px solid #ca3f3f;">
                        <div class="card-header">
                            <h3 class="card-title"><img src="../../dist/img/bar.png" style="height:28px;">&ensp;Hourly
                                Defect Count Graph</h3>
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
                            <div class="row">
                                <div class="col-12">
                                    <div id="chart-container">
                                        <!-- <canvas id="ng_summary_chart" height="70"></canvas> -->
                                        <div id="ng_summary_chart" height="70"></div>
                                    </div>
                                </div>
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
    </section>
</div>


<?php
include 'plugins/footer.php';
include 'plugins/js/inspection_output_script.php';
?>