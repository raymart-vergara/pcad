<?php
include 'process/server_date_time.php';
require 'process/conn/emp_mgt.php';
include 'process/lib/emp_mgt.php';

$line_no = '2132';
// $line_no = $_GET['line_no'];
$registlinename = '';
// $registlinename = $_GET['registlinename']; // IRCS LINE (PCS)
$dept_pd = 'PD2';
$dept_qa = 'QA';
$section_pd = get_section($line_no, $conn_emp_mgt);
$section_qa = 'QA';
$shift = get_shift($server_time);
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PCAD DESIGN II</title>

        <link rel="icon" href="dist/img/logo.ico" type="image/x-icon" />
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="dist/css/font.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="plugins/ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Sweet Alert -->
        <link rel="stylesheet" href="plugins/sweetalert2/dist/sweetalert2.min.css">

        <style>
                table {
                        /* border-collapse: collapse; */
                        border-collapse: separate;
                        border-spacing: 0;
                        border: 2px solid #4E4E4E;
                        border-radius: 4px;
                        width: 100%;
                }

                th,
                td {
                        border: 1px solid #ddd;
                        padding: 3px;
                        text-align: left;
                }

                td {
                        background: #F6F6F6;
                }

                .th-normal {
                        font-weight: normal;
                }

                .numeric-cell {
                        position: relative;
                }

                .numeric-cell-acct {
                        position: relative;
                }

                .numeric-cell-hourly {
                        position: relative;
                }
        </style>

</head>

<body>
        <input type="hidden" id="shift" value="<?= $shift ?>">
        <input type="hidden" id="dept_pd" value="<?= $dept_pd ?>">
        <input type="hidden" id="dept_qa" value="<?= $dept_qa ?>">
        <input type="hidden" id="section_pd" value="<?= $section_pd ?>">
        <input type="hidden" id="section_qa" value="<?= $section_qa ?>">
        <input type="hidden" id="line_no" value="<?= $line_no ?>">
        <!-- <input type="hidden" id="registlinename" value="<?= $registlinename ?>"> -->
        <div class="container-fluid">
                <div class="flex-column justify-content-center align-items-center">
                        <!-- <img class="animation__shake" src="dist/img/logo.webp" alt="logo" height="40" width="40"> -->
                        <!-- <span class="h6">PCAD<span> -->
                </div>
        </div>
        <div class="container-fluid">
                <h2 class="text-center m-4">Production Conveyor Analysis Dashboard</h2>
                <div class="col-12">
                        <div class="card" style="border: 3px solid #4E4E4E; border-radius: 8px;">
                                <div class="card-body">
                                        <!-- first row -->
                                        <div class="row mb-4">
                                                <div class="col-12">
                                                        <table>
                                                                <tr>
                                                                        <th class="col-md-2">Car Maker/Model:</th>
                                                                        <td class="col-md-4">Daihatsu</td>
                                                                        <th class="col-md-2">Date:</th>
                                                                        <td class="col-md-4">2024-02-17</td>
                                                                </tr>
                                                                <tr>
                                                                        <th class="col-md-2">Line:</th>
                                                                        <td class="col-md-4">2132</td>
                                                                        <th class="col-md-2">Shift:</th>
                                                                        <td class="col-md-4">DS</td>
                                                                </tr>
                                                        </table>
                                                </div>
                                        </div>
                                        <!-- second row -->
                                        <div class="row mb-4">
                                                <div class="col-4">
                                                        <!-- yield and ppm -->
                                                        <table>
                                                                <tr>
                                                                        <th colspan="3" class="col-md-6 text-center"
                                                                                style="height: 47px;">YIELD</th>
                                                                        <th colspan="3" class="col-md-6 text-center">PPM
                                                                        </th>
                                                                </tr>

                                                        </table>
                                                        <table>
                                                                <tr>
                                                                        <td class="col-md-2 text-center"
                                                                                style="height: 72px;">95%</td>
                                                                        <th class="th-normal col-md-2 text-center">
                                                                                TARGET</th>
                                                                        <td class="col-md-2 text-center">7000
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <td class="col-md-2 text-center"
                                                                                style="height: 72px; background: #fae588;">
                                                                                89%</td>
                                                                        <th class="th-normal col-md-2 text-center">
                                                                                ACTUAL</th>
                                                                        <td class="col-md-2 text-center"
                                                                                style="background: #f38375;">
                                                                                25000</td>
                                                                </tr>
                                                        </table>

                                                </div>
                                                <!-- <div class="col-1"></div> -->
                                                <div class="col-8">
                                                        <!-- plan, accnt eff, hourly output -->
                                                        <table>
                                                                <tr>
                                                                        <th colspan="3" class="text-center">PLAN</th>
                                                                        <th colspan="3" class="text-center">ACCOUNTING
                                                                                EFFICIENCY</th>
                                                                        <th colspan="3" class="text-center">HOURLY
                                                                                OUTPUT</th>
                                                                </tr>
                                                                <tr>
                                                                        <th class="th-normal col-md-1 text-center">
                                                                                Target</th>
                                                                        <th class="th-normal col-md-1 text-center">
                                                                                Actual</th>
                                                                        <th class="th-normal col-md-1 text-center">Gap
                                                                        </th>
                                                                        <th class="th-normal col-md-1 text-center">
                                                                                Target</th>
                                                                        <th class="th-normal col-md-1 text-center">
                                                                                Actual</th>
                                                                        <th class="th-normal col-md-1 text-center">Gap
                                                                        </th>
                                                                        <th class="th-normal col-md-1 text-center">
                                                                                Target</th>
                                                                        <th class="th-normal col-md-1 text-center">
                                                                                Actual</th>
                                                                        <th class="th-normal col-md-1 text-center">Gap
                                                                        </th>
                                                                </tr>
                                                                <tr>
                                                                        <!-- plan value -->
                                                                        <td class="numeric-cell col-md-1 text-center"
                                                                                style="height: 128px" data-value="100">
                                                                                100</td>
                                                                        <td class="numeric-cell col-md-1 text-center"
                                                                                data-value="90">90</td>
                                                                        <td class="numeric-cell col-md-1 text-center"
                                                                                data-value="10">10</td>

                                                                        <!-- accounting efficiecny value -->
                                                                        <td class="numeric-cell-acct col-md-1 text-center"
                                                                                data-value="100">90%</td>
                                                                        <td class="numeric-cell-acct col-md-1 text-center"
                                                                                data-value="75">75%</td>
                                                                        <td class="numeric-cell-acct col-md-1 text-center"
                                                                                data-value="25">15%</td>

                                                                        <!-- hourly output value -->
                                                                        <td class="numeric-cell-hourly col-md-1 text-center"
                                                                                data-value="100">10</td>
                                                                        <td class="numeric-cell-hourly col-md-1 text-center"
                                                                                data-value="75">7.5</td>
                                                                        <td class="numeric-cell-hourly col-md-1 text-center"
                                                                                data-value="25">2.5</td>
                                                                </tr>
                                                        </table>
                                                </div>

                                        </div>
                                        <!-- third row -->
                                        <div class="row mb-2">
                                                <div class="col-4">
                                                        <!-- overall inspection -->
                                                        <table>
                                                                <tr>
                                                                        <th colspan="4" class="text-center"
                                                                                style="height: 80px">OVERALL INSPECTION
                                                                        </th>
                                                                </tr>
                                                                <tr>
                                                                        <th class="col-md-2 text-center"
                                                                                style="height: 140px">GOOD</th>
                                                                        <td class="col-md-4 text-center">25</td>
                                                                        <td class="col-md-4 text-center">4</td>
                                                                        <th class="col-md-2 text-center">NG</th>
                                                                </tr>
                                                        </table>
                                                </div>
                                                <!-- <div class="col-1"></div> -->
                                                <div class="col-8">
                                                        <!-- dt, delay, andon graph -->
                                                        <div class="card" style="border: 2px solid #4E4E4E">
                                                                <!-- <h6 class="text-center text-bold">DT / Delay / Andon</h6> -->

                                                                <div id="chart-container">
                                                                        <canvas id="stackedBarChart"
                                                                                height="45"></canvas>
                                                                </div>

                                                                <a target="_blank"
                                                                        href="http://172.25.114.167:3000/andon_system/admin/page/andonProdLogs.php"
                                                                        class="card-link" style="padding: 7px; text-align: right">Andon Details</a>
                                                        </div>
                                                </div>
                                        </div>
                                        <!-- fourth row -->
                                        <div class="row">
                                                <div class="col-4">
                                                        <!-- inspection details -->
                                                        <table class="m-0 p-0">
                                                                <tr>
                                                                        <th class="col-md-4 text-center">GOOD</th>
                                                                        <th class="col-md-4 text-center">INSPECTION</th>
                                                                        <th class="col-md-4 text-center">NG</th>
                                                                </tr>
                                                                <tr>
                                                                        <td class="col-md-4 text-center">6</td>
                                                                        <th class="th-normal col-md-4 text-center">
                                                                                Dimension</th>
                                                                        <td class="col-md-4 text-center">1</td>
                                                                </tr>
                                                                <tr>
                                                                        <td class="col-md-4 text-center">3</td>
                                                                        <th class="th-normal col-md-4 text-center">
                                                                                ECT</th>
                                                                        <td class="col-md-4 text-center">0</td>
                                                                </tr>
                                                                <tr>
                                                                        <td class="col-md-4 text-center">7</td>
                                                                        <th class="th-normal col-md-4 text-center">
                                                                                Clamp Checking</th>
                                                                        <td class="col-md-4 text-center">2</td>
                                                                </tr>
                                                                <tr>
                                                                        <td class="col-md-4 text-center">3</td>
                                                                        <th class="th-normal col-md-4 text-center">
                                                                                Appearance</th>
                                                                        <td class="col-md-4 text-center">0</td>
                                                                </tr>
                                                                <tr>
                                                                        <td class="col-md-4 text-center">7</td>
                                                                        <th class="th-normal col-md-4 text-center">
                                                                                QA</th>
                                                                        <td class="col-md-4 text-center">1</td>
                                                                </tr>
                                                        </table>

                                                </div>
                                                <!-- <div class="col-1"></div> -->
                                                <div class="col-8">
                                                        <!-- pd qa other details -->
                                                        <table>
                                                                <tr>
                                                                        <th colspan="2" class="col-md-3 text-center">PD
                                                                                MANPOWER</th>
                                                                        <th colspan="2" class="col-md-3 text-center">QA
                                                                                MANPOWER</th>
                                                                        <th colspan="2" class="col-md-3 text-center">
                                                                                OTHER DETAILS</th>
                                                                </tr>
                                                                <tr>
                                                                        <th class="th-normal col-md-1">Plan:</th>
                                                                        <td class="numeric-cell col-md-1 text-center"
                                                                                data-value="100">80</td>
                                                                        <th class="th-normal col-md-1">Plan:</th>
                                                                        <td class="numeric-cell col-md-1 text-center"
                                                                                data-value="100">20</td>

                                                                        <th class="th-normal col-md-1"
                                                                                style="font-size: 13px">Starting Balance
                                                                                Delay:</th>
                                                                        <td class="col-md-1 text-center">0</td>
                                                                </tr>
                                                                <tr>
                                                                        <th class="th-normal col-md-1">Actual:</th>
                                                                        <td class="numeric-cell col-md-1 text-center"
                                                                                data-value="94">74</td>
                                                                        <th class="th-normal col-md-1">Actual:</th>
                                                                        <td class="numeric-cell col-md-1 text-center"
                                                                                data-value="97">17</td>

                                                                        <th class="th-normal col-md-1">Conveyor Speed:
                                                                        </th>
                                                                        <td class="col-md-1 text-center">00:00:00</td>
                                                                </tr>
                                                                <tr>
                                                                        <th class="th-normal col-md-1">Support:</th>
                                                                        <td class="numeric-cell col-md-1 text-center"
                                                                                data-value="6">6</td>
                                                                        <th class="th-normal col-md-1">Support:</th>
                                                                        <td class="numeric-cell col-md-1 text-center"
                                                                                data-value="3">3</td>

                                                                        <th class="th-normal col-md-1">Takt Time:</th>
                                                                        <td class="col-md-1 text-center">00:00:00</td>
                                                                </tr>
                                                                <tr>
                                                                        <th class="th-normal col-md-1">Total:</th>
                                                                        <td class="numeric-cell col-md-1 text-center"
                                                                                data-value="100">80</td>
                                                                        <th class="th-normal col-md-1">Total:</th>
                                                                        <td class="numeric-cell col-md-1 text-center"
                                                                                data-value="100">20</td>

                                                                        <th class="th-normal col-md-1"
                                                                                style="font-size: 13px">Working Time
                                                                                Plan:</th>
                                                                        <td class="col-md-1 text-center">0</td>
                                                                </tr>
                                                                <tr>
                                                                        <th class="th-normal col-md-1">Absent Rate:</th>
                                                                        <td class="col-md-2 text-center"
                                                                                style="background: #fae588">8%</td>
                                                                        <th class="th-normal col-md-1">Absent Rate:</th>
                                                                        <td class="col-md-2 text-center"
                                                                                style="background: #f38375;">
                                                                                15%</td>

                                                                        <th class="th-normal col-md-1"
                                                                                style="font-size: 13px">Working Time
                                                                                Actual:</th>
                                                                        <td class="col-md-1 text-center">0</td>
                                                                </tr>
                                                        </table>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>

                <!-- Buttons (Progress Counter TV) -->
                <!-- <div class="row">
                        <div class="col-6">
                                <button type="button" class="btn btn-danger btn-block"> End Process</button>
                        </div>
                        <div class="col-6">
                                <a type="button" class="btn btn-secondary btn-block" href="pcs_page/index.php"> Main
                                        Menu</a>
                        </div>
                </div> -->


        </div>
        <!-- <footer class="footer m-3" style="color: grey">
                <strong>Copyright &copy; 2024. Developed by FALP IT System Group</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                        <b>Version</b> 1.0.0
                </div>
        </footer> -->


</body>

<!-- jQuery -->
<script src="plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Chart JS -->
<script src="node_modules/chart.js/dist/chart.umd.js"></script>

<script>
        // Apply gradient background dynamically using JavaScript
        document.querySelectorAll('.numeric-cell').forEach(function (cell) {
                var value = parseInt(cell.dataset.value);
                var gradientValue = value + '%';
                cell.style.background = 'linear-gradient(to right, #98c3e5 ' + gradientValue + ', #f6f6f6 ' + gradientValue + ')';
        });

        document.querySelectorAll('.numeric-cell-acct').forEach(function (cell) {
                var value = parseInt(cell.dataset.value);
                var gradientValue = value + '%';
                cell.style.background = 'linear-gradient(to right, #f38375 ' + gradientValue + ', #f6f6f6 ' + gradientValue + ')';
        });

        document.querySelectorAll('.numeric-cell-hourly').forEach(function (cell) {
                var value = parseInt(cell.dataset.value);
                var gradientValue = value + '%';
                cell.style.background = 'linear-gradient(to right, #78c6a3 ' + gradientValue + ', #f6f6f6 ' + gradientValue + ')';
        });

        // Sample data
        var data = {
                labels: ['ECT Board', 'Assembly Board', 'Tape Detection Device', 'Bando Gun (EVO9)'],
                datasets: [
                        {
                                label: 'Waiting Time',
                                backgroundColor: 'rgba(26, 101, 158, 1)',
                                yAxisID: 'y',
                                data: [40, 18, 24, 11]
                        },
                        {
                                label: 'Fixing Time',
                                backgroundColor: 'rgb(163, 206, 241, 1)',
                                yAxisID: 'y',
                                data: [83, 10, 26, 27]
                        }
                ]
        };

        // Chart configuration
        var config = {
                type: 'bar',
                data: data,
                options: {
                        scales: {
                                x: { stacked: true },
                                y: { stacked: true }
                        }
                }
        };

        // Create the chart
        var myChart = new Chart(document.getElementById('stackedBarChart'), config);
</script>

</html>
<!-- /.navbar -->