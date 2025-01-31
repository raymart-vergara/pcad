<?php
include 'plugins/header.php';
include 'plugins/preloader.php';
include 'plugins/navbar/assy_viewer_navbar.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row mb-2 ml-1 mr-1">
            <div class="col-sm-6">
                <h1 class="m-0"> Assembly Process History</h1>
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
                            <form id="assy_history_form" onsubmit="event.preventDefault();">
                                <div class="row mb-2">
                                    <div class="col-sm-3">
                                        <label>Date Time From</label>
                                        <input type="datetime-local" class="form-control" id="assy_history_date_from_search" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Date Time To</label>
                                        <input type="datetime-local" class="form-control" id="assy_history_date_to_search" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Scan Nameplate</label>
                                        <input type="text" class="form-control" id="assy_history_nameplate_value_search" maxlength="255" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-2">
                                        <label>Line No.</label>
                                        <input list="assy_history_line_no_list" class="form-control" id="assy_history_line_no_search" maxlength="255">
                                        <datalist id="assy_history_line_no_list"></datalist>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Product Name</label>
                                        <input type="text" class="form-control" id="assy_history_product_name_search" maxlength="255">
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Lot No</label>
                                        <input type="text" class="form-control" id="assy_history_lot_no_search" maxlength="255">
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Serial No.</label>
                                        <input type="text" class="form-control" id="assy_history_serial_no_search" maxlength="255">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-3 offset-sm-6">
                                        <button type="button" class="btn bg-secondary btn-block"
                                            onclick="export_assy_history('assyHistoryTable')"><i class="fas fa-download"></i> Export</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn bg-primary btn-block"><i class="fas fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                            <div id="assyHistoryTableRes" class="table-responsive"
                                style="max-height: 500px; overflow: auto; display:inline-block;">
                                <table id="assyHistoryTable"
                                    class="table table-sm table-head-fixed table-foot-fixed text-nowrap table-hover">
                                    <thead style="text-align: center;">
                                        <tr>
                                            <th>#</th>
                                            <th>Car Maker</th>
                                            <th>Car Model</th>
                                            <th>Line No.</th>
                                            <th>Product Name</th>
                                            <th>Lot No.</th>
                                            <th>Serial No.</th>
                                            <th>Assy Start Date Time</th>
                                            <th>Assy End Date Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id="assyHistoryData" style="text-align: center;">
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
include 'plugins/js/history_viewer_script.php';
?>