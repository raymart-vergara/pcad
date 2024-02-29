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
        <title>PCAD CAROUSEL</title>

        <link rel="icon" href="dist/img/pcad_logo.ico" type="image/x-icon" />
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
                        border-radius: 2px;
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

                .value-size {
                        font-size: 40px;
                        /* font-weight: lighter; */
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
                <div class="col-12 mt-5">
                        <div class="row mb-5">
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

                        <!-- carousel -->
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                        <li style="border: 1px solid grey; background: grey"
                                                data-target="#carouselExampleIndicators" data-slide-to="0"
                                                class="active">
                                        </li>
                                        <li style="border: 1px solid grey; background: grey"
                                                data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                        <li style="border: 1px solid grey; background: grey"
                                                data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                        <li style="border: 1px solid grey; background: grey"
                                                data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                                        <li style="border: 1px solid grey; background: grey"
                                                data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                                        <li style="border: 1px solid grey; background: grey"
                                                data-target="#carouselExampleIndicators" data-slide-to="5"></li>
                                </ol>
                                <div class="carousel-inner">
                                        <div class="carousel-item active">
                                                <div class="row">
                                                        <div class="col-12">
                                                                <table style="border-bottom: none">
                                                                        <tr>
                                                                                <th colspan="3"
                                                                                        class="col-md-6 text-center">
                                                                                        YIELD</th>
                                                                                <th colspan="3"
                                                                                        class="col-md-6 text-center">
                                                                                        PPM
                                                                                </th>
                                                                        </tr>

                                                                </table>
                                                                <table style="border-top: none;">
                                                                        <tr>
                                                                                <td
                                                                                        class="col-md-2 text-center value-size">
                                                                                        95%</td>
                                                                                <th
                                                                                        class="th-normal col-md-2 text-center">
                                                                                        TARGET</th>
                                                                                <td class="col-md-2 text-center value-size"">7000
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <td class=" col-md-2 text-center value-size""
                                                                                        style="background: #fae588;">
                                                                                        89%</td>
                                                                                <th
                                                                                        class="th-normal col-md-2 text-center">
                                                                                        ACTUAL</th>
                                                                                <td class="col-md-2 text-center value-size""
                                                                                style=" background: #f38375;">
                                                                                        25000</td>
                                                                        </tr>
                                                                </table>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="carousel-item">
                                                <div class="row">
                                                        <div class="col-12">
                                                                <table>
                                                                        <tr>
                                                                                <th colspan="3" class="text-center">PLAN
                                                                                </th>
                                                                                <th colspan="3" class="text-center">
                                                                                        ACCOUNTING
                                                                                        EFFICIENCY</th>
                                                                                <th colspan="3" class="text-center">
                                                                                        HOURLY
                                                                                        OUTPUT</th>
                                                                        </tr>
                                                                        <tr>
                                                                                <th
                                                                                        class="th-normal col-md-1 text-center">
                                                                                        Target</th>
                                                                                <th
                                                                                        class="th-normal col-md-1 text-center">
                                                                                        Actual</th>
                                                                                <th
                                                                                        class="th-normal col-md-1 text-center">
                                                                                        Gap
                                                                                </th>
                                                                                <th
                                                                                        class="th-normal col-md-1 text-center">
                                                                                        Target</th>
                                                                                <th
                                                                                        class="th-normal col-md-1 text-center">
                                                                                        Actual</th>
                                                                                <th
                                                                                        class="th-normal col-md-1 text-center">
                                                                                        Gap
                                                                                </th>
                                                                                <th
                                                                                        class="th-normal col-md-1 text-center">
                                                                                        Target</th>
                                                                                <th
                                                                                        class="th-normal col-md-1 text-center">
                                                                                        Actual</th>
                                                                                <th
                                                                                        class="th-normal col-md-1 text-center">
                                                                                        Gap
                                                                                </th>
                                                                        </tr>
                                                                        <tr>
                                                                                <!-- plan value -->
                                                                                <td class="numeric-cell col-md-1 text-center value-size"
                                                                                        data-value="100">100</td>
                                                                                <td class="numeric-cell col-md-1 text-center value-size"
                                                                                        data-value="90">90</td>
                                                                                <td class="numeric-cell col-md-1 text-center value-size"
                                                                                        data-value="10">10</td>

                                                                                <!-- accounting efficiecny value -->
                                                                                <td class="numeric-cell-acct col-md-1 text-center value-size"
                                                                                        data-value="100">90%</td>
                                                                                <td class="numeric-cell-acct col-md-1 text-center value-size"
                                                                                        data-value="75">75%</td>
                                                                                <td class="numeric-cell-acct col-md-1 text-center value-size"
                                                                                        data-value="25">15%</td>

                                                                                <!-- hourly output value -->
                                                                                <td class="numeric-cell-hourly col-md-1 text-center value-size"
                                                                                        data-value="100">10</td>
                                                                                <td class="numeric-cell-hourly col-md-1 text-center value-size"
                                                                                        data-value="75">7.5</td>
                                                                                <td class="numeric-cell-hourly col-md-1 text-center value-size"
                                                                                        data-value="25">2.5</td>
                                                                        </tr>
                                                                </table>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="carousel-item">
                                                <div class="row">
                                                        <div class="col-12">
                                                                <table>
                                                                        <tr>
                                                                                <th colspan="4" class="text-center">
                                                                                        OVERALL INSPECTION
                                                                                </th>
                                                                        </tr>
                                                                        <tr>
                                                                                <th class="col-md-2 text-center">GOOD
                                                                                </th>
                                                                                <td
                                                                                        class="col-md-4 text-center value-size">
                                                                                        25</td>
                                                                                <td
                                                                                        class="col-md-4 text-center value-size">
                                                                                        4</td>
                                                                                <th class="col-md-2 text-center">NG</th>
                                                                        </tr>
                                                                </table>
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                                <table>
                                                                        <tr>
                                                                                <th class="col-md-4 text-center">
                                                                                        GOOD
                                                                                </th>
                                                                                <th class="col-md-4 text-center">
                                                                                        INSPECTION</th>
                                                                                <th class="col-md-4 text-center">
                                                                                        NG</th>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="col-md-4 text-center">
                                                                                        6</td>
                                                                                <th
                                                                                        class="th-normal col-md-4 text-center">
                                                                                        Dimension</th>
                                                                                <td class="col-md-4 text-center">
                                                                                        1</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="col-md-4 text-center">
                                                                                        3</td>
                                                                                <th
                                                                                        class="th-normal col-md-4 text-center">
                                                                                        ECT</th>
                                                                                <td class="col-md-4 text-center">
                                                                                        0</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="col-md-4 text-center">
                                                                                        7</td>
                                                                                <th
                                                                                        class="th-normal col-md-4 text-center">
                                                                                        Clamp Checking</th>
                                                                                <td class="col-md-4 text-center">
                                                                                        2</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="col-md-4 text-center">
                                                                                        3</td>
                                                                                <th
                                                                                        class="th-normal col-md-4 text-center">
                                                                                        Appearance</th>
                                                                                <td class="col-md-4 text-center">
                                                                                        0</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td class="col-md-4 text-center">
                                                                                        7</td>
                                                                                <th
                                                                                        class="th-normal col-md-4 text-center">
                                                                                        QA</th>
                                                                                <td class="col-md-4 text-center">
                                                                                        1</td>
                                                                        </tr>
                                                                </table>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="carousel-item">
                                                <div class="row">
                                                        <div class="col-12">
                                                                <div class="card" style="border: 2px solid #4E4E4E">
                                                                        <!-- <h6 class="text-center text-bold">DT / Delay / Andon</h6> -->

                                                                        <div id="chart-container">
                                                                                <canvas id="stackedBarChart"
                                                                                        height="45"></canvas>
                                                                        </div>

                                                                        <a target="_blank"
                                                                                href="http://172.25.114.167:3000/andon_system/admin/page/andonProdLogs.php"
                                                                                class="card-link"
                                                                                style="padding: 7px; text-align: right">Andon
                                                                                Details</a>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="carousel-item">
                                                <div class="row">
                                                        <div class="col-12">
                                                                <table>
                                                                        <tr>
                                                                                <th colspan="2"
                                                                                        class="col-md-3 text-center">PD
                                                                                        MANPOWER</th>
                                                                                <th colspan="2"
                                                                                        class="col-md-3 text-center">QA
                                                                                        MANPOWER</th>
                                                                                <th colspan="2"
                                                                                        class="col-md-3 text-center">
                                                                                        OTHER DETAILS</th>
                                                                        </tr>
                                                                        <tr>
                                                                                <th class="th-normal col-md-1">Plan:
                                                                                </th>
                                                                                <td class="numeric-cell col-md-1 text-center"
                                                                                        data-value="100">80</td>
                                                                                <th class="th-normal col-md-1">Plan:
                                                                                </th>
                                                                                <td class="numeric-cell col-md-1 text-center"
                                                                                        data-value="100">20</td>

                                                                                <th class="th-normal col-md-1"
                                                                                        style="font-size: 13px">Starting
                                                                                        Balance
                                                                                        Delay:</th>
                                                                                <td class="col-md-1 text-center">0</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <th class="th-normal col-md-1">Actual:
                                                                                </th>
                                                                                <td class="numeric-cell col-md-1 text-center"
                                                                                        data-value="94">74</td>
                                                                                <th class="th-normal col-md-1">Actual:
                                                                                </th>
                                                                                <td class="numeric-cell col-md-1 text-center"
                                                                                        data-value="97">17</td>

                                                                                <th class="th-normal col-md-1">Conveyor
                                                                                        Speed:
                                                                                </th>
                                                                                <td class="col-md-1 text-center">
                                                                                        00:00:00</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <th class="th-normal col-md-1">Support:
                                                                                </th>
                                                                                <td class="numeric-cell col-md-1 text-center"
                                                                                        data-value="6">6</td>
                                                                                <th class="th-normal col-md-1">Support:
                                                                                </th>
                                                                                <td class="numeric-cell col-md-1 text-center"
                                                                                        data-value="3">3</td>

                                                                                <th class="th-normal col-md-1">Takt
                                                                                        Time:</th>
                                                                                <td class="col-md-1 text-center">
                                                                                        00:00:00</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <th class="th-normal col-md-1">Total:
                                                                                </th>
                                                                                <td class="numeric-cell col-md-1 text-center"
                                                                                        data-value="100">80</td>
                                                                                <th class="th-normal col-md-1">Total:
                                                                                </th>
                                                                                <td class="numeric-cell col-md-1 text-center"
                                                                                        data-value="100">20</td>

                                                                                <th class="th-normal col-md-1"
                                                                                        style="font-size: 13px">Working
                                                                                        Time
                                                                                        Plan:</th>
                                                                                <td class="col-md-1 text-center">0</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <th class="th-normal col-md-1">Absent
                                                                                        Rate:</th>
                                                                                <td class="col-md-2 text-center"
                                                                                        style="background: #fae588">8%
                                                                                </td>
                                                                                <th class="th-normal col-md-1">Absent
                                                                                        Rate:</th>
                                                                                <td class="col-md-2 text-center"
                                                                                        style="background: #f38375;">
                                                                                        15%</td>

                                                                                <th class="th-normal col-md-1"
                                                                                        style="font-size: 13px">Working
                                                                                        Time
                                                                                        Actual:</th>
                                                                                <td class="col-md-1 text-center">0</td>
                                                                        </tr>
                                                                </table>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <a class="carousel-control-prev"
                                        href="#carouselExampleIndicators" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next"
                                        href="#carouselExampleIndicators" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                </a>
                        </div>
                </div>

                <!-- buttons for tv -->
                <div class="row mt-5">
                        <div class="col-12">
                                <!-- Buttons (Progress Counter TV) -->
                                <div class="row">
                                        <div class="col-4">
                                                <div>
                                                        <button type="button"
                                                                class="btn btn-danger btn-block btn-pause">PAUSE
                                                                <b>[ 1 ]</b></button>
                                                </div>
                                                <div>
                                                        <button type="button"
                                                                class="btn btn-info btn-block btn-resume d-none">RESUME
                                                                <b>[ 3 ]</b></button>
                                                </div>
                                        </div>
                                        <div class="col-4">
                                                <button type="button" class="btn btn-success btn-block btn-target ">END
                                                        PROCESS <b>[ 2 ]</b></button>
                                        </div>
                                        <div class="col-4">
                                                <a type="button" class="btn btn-secondary btn-block btn-menu"
                                                        href="pcs_page/index.php"> MAIN MENU <b>[ 0
                                                                ]</b></a>
                                        </div>
                                </div>
                        </div>
                </div>

                <!-- table legend -->
                <div class="row mt-3">
                        <!-- <div class="col-4"></div> -->
                        <div class="col-4">
                                <table>
                                        <tr>
                                                <th colspan="2">Legend</th>
                                        </tr>
                                        <tr>
                                                <th class="text-center">[1]</th>
                                                <th class="th-normal">Yield / PPM</th>
                                        </tr>
                                        <tr>
                                                <th class="text-center">[2]</th>
                                                <th class="th-normal">Plan / Accounting Efficiency / Hourly Output</th>
                                        </tr>
                                        <tr>
                                                <th class="text-center">[3]</th>
                                                <th class="th-normal">Overall Inspection</th>
                                        </tr>
                                        <tr>
                                                <th class="text-center">[4]</th>
                                                <th class="th-normal">DT / Delay / Andon Graph</th>
                                        </tr>
                                        <tr>
                                                <th class="text-center">[5]</th>
                                                <th class="th-normal">PD Manpower / QA Manpower / Other Details</th>
                                        </tr>
                                </table>
                        </div>
                        <!-- <div class="col-4"></div> -->
                </div>
        </div>
</body>

<!-- jQuery -->
<script src="plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Chart JS -->
<script src="node_modules/chart.js/dist/chart.umd.js"></script>

<script>
        $('.carousel').carousel({
                interval: 2500
        })

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