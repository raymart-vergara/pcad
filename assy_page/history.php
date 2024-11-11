<?php
// check ip
include '../process/assy/check_assy_access_location.php';
include 'plugins/header.php';
include 'plugins/preloader.php';
include 'plugins/navbar/assy_navbar.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row mb-2 ml-1 mr-1">
            <div class="col-sm-6">
                <h1 class="m-0"> Assembly Process History (Line <?=$line_no?>)</h1>
                <input type="hidden" id="assy_page_line_no" value="<?=$line_no?>">
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/pcad/assy_page/">PCAD</a></li>
                    <li class="breadcrumb-item active">Assembly Process History</li>
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
                            <h3 class="card-title">Assembly Process History Table</h3>
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
                                    <select id="line_no_search" class="form-control" disabled>
                                        <option value="">
                                            - - - -
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label>Date</label>
                                    <input type="date" class="form-control" id="hourly_output_date_search" disabled>
                                </div>
                                <div class="col-sm-3">
                                    <label>Shift</label>
                                    <select class="form-control" id="shift_search" style="width: 100%;" disabled>
                                        <option value="DS">DS</option>
                                        <option value="NS">NS</option>
                                        <option selected value="">All</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label>Target Output</label>
                                    <input type="number" class="form-control" id="target_output_search" disabled>
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
                                        onclick="get_hourly_output()" disabled><i class="fas fa-search"></i> Search</button>
                                </div>
                            </div>
                            <div id="hourlyOutputTableRes" class="table-responsive"
                                style="max-height: 500px; overflow: auto; display:inline-block;">
                                <table id="hourlyOutputTable"
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
include 'plugins/js/history_script.php';
?>