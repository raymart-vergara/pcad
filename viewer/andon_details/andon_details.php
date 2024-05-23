<?php
include '../../process/server_date_time.php';
include 'plugins/header.php';
include 'plugins/preloader.php';
include 'plugins/navbar/andon_details_navbar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row mb-2 ml-1 mr-1">
            <div class="col-sm-6">
                <h1 class="m-0"> Andon Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/pcad/">PCAD</a></li>
                    <li class="breadcrumb-item active">Andon Details</li>
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
                    <div class="card card-outline" style="border-top: 3px solid #334C69;">
                        <div class="card-header">
                            <h3 class="card-title"><img src="../../dist/img/dashboard.png"
                                    style="height:28px;">&ensp;Andon Details Table</h3>
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
                            <div class="row mb-4 mt-2">
                                <div class="col-sm-3">
                                    <button type="button" class="btn btn-block"
                                        style="background: #334C69;  color: #FFF;"
                                        onmouseover="this.style.backgroundColor='#22354A'; this.style.color='#fff';"
                                        onmouseout="this.style.backgroundColor='#334C69'; this.style.color='#fff';"
                                        onclick="location.replace('../../process/andon_graph/andon_export_p.php')">
                                        <i class="fas fa-download"></i> Export Andon Details
                                    </button>
                                </div>
                            </div>

                            <div id="" class="table-responsive"
                                style="max-height: 500px; overflow: auto; display:inline-block;">
                                <table class="table table-head-fixed text-nowrap table-bordered table-hover">
                                    <thead class="text-center">
                                        <tr>
                                            <th>#</th>
                                            <th>Production</th>
                                            <th>Line</th>
                                            <th>Machine</th>
                                            <th>Machine No.</th>
                                            <th>Process</th>
                                            <th>Problem</th>
                                            <th>Production Acct.</th>
                                            <th>Call Date Time</th>
                                            <th>Waiting Time (mins.)</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Fixing Time Duration (mins.)</th>
                                            <th>Technician</th>
                                            <th>Department</th>
                                            <th>Solution</th>
                                            <th>Serial Number</th>
                                            <th>Jig Name</th>
                                            <th>Circuit Location</th>
                                            <th>Lot Number</th>
                                            <th>Product Number</th>
                                            <th>Fixing Status</th>
                                            <th>Backup Request Time</th>
                                            <th>Backup Comment</th>
                                            <th>Backup Technician</th>
                                            <th>Backup Confirmation Date Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id="andon_details" style="text-align:center;"></tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <div class="card card-outline" style="border-top: 3px solid #334C69;">
                        <div class="card-header">
                            <h3 class="card-title"><img src="../../dist/img/bar.png" style="height:28px;">&ensp;Andon
                                Hourly Graph</h3>
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
                                        <!-- <canvas id="andon_hourly_chart" height="70"></canvas> -->
                                        <div id="andon_hourly_chart" height="70"></div>
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
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include 'plugins/footer.php';
include 'plugins/js/a_graph_script.php';
?>