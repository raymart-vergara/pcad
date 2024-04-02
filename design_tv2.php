<?php
include 'process/pcs/index.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PCAD | DASHBOARD C</title>

    <!-- mdb -->
    <!-- <link rel="stylesheet" href="plugins/mdb/css/mdb.min.css"> -->

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
        @font-face {
            font-family: 'Norwester';
            src: url('dist/font/norwester/norwester.otf') format('opentype');
        }

        @font-face {
            font-family: 'Montserrat';
            src: url('dist/font/montserrat/Montserrat-Bold.ttf') format('truetype');
        }

        @media screen and (min-width: 1366px) and (max-width: 1366px) {

            /* Styles for 32 inches TV */
            .container-fluid {
                width: 100%;
            }
        }


        @media screen and (min-width: 1920px) and (max-width: 1920px) {

            /* Styles for 55 inches TV */
            .container-fluid {
                width: 100%;
            }
        }

        body {
            background: #03045e;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
        }

        table {
            /* border-collapse: collapse; */
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #515151;
            border-radius: 2px;
            width: 100%;
        }

        th,
        td {
            border-bottom: 1px solid #515151;
            padding: 3px;
            border-right: 1px solid #515151;
            ;
        }

        tr:hover {
            /* background-color: #000; */
            cursor: pointer;
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

        .value-size1 {
            font-size: 120px;
            font-family: 'Norwester', sans-serif;
        }

        .value-size2 {
            font-size: 100px;
            font-family: 'Norwester', sans-serif;
            /* text-align: center; */
        }

        .value-size {
            font-size: 50px;
            font-family: 'Norwester', sans-serif;
        }

        /* for inspection output scroll */
        table.scrolldown {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            border: 1px solid #515151;
        }

        /* To display the block as level element */
        table.scrolldown tbody,
        table.scrolldown thead {
            display: block;
        }

        thead tr th {
            height: 40px;
            line-height: 40px;
        }

        table.scrolldown tbody {
            height: 168px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .darkest-modal .modal-backdrop {
            background-color: rgba(0, 0, 0, 1);
        }

        .table-flex {
            display: flex,
                flex-direction: row,
                justify-content: space-between,
                align-items: start
        }

        .equal-width {
            width: 25%;
            font-size: 30px;
            font-family: 'Montserrat', sans-serif;
        }

        .equal-plan-acct-hr {
            width: 25%;
        }

        .equal-py {
            width: 50%;
            font-size: 40px;
            /* font-family: 'Digitalism', sans-serif; */
        }

        .equal-insp {
            width: 25%;
        }

        .equal-insp-info {
            width: 33.33%;
        }

        .equal-details {
            width: 33.33%;
            font-size: 23px;
        }

        .equal-sub-details {
            width: 16.66%;
            /* text-align: right; */
        }

        .table th,
        .table td {
            padding: 0;
            margin: 0;
        }

        .font-plan {
            font-size: 40px;
            width: 33.33%;
            padding-left: 10px;
        }

        .font-plan-sub {
            font-size: 35px;
        }

        .font-others {
            font-size: 25px;
            padding-left: 10px;
        }

        .font-others-value {
            font-size: 50px;
            font-family: 'Norwester', sans-serif;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <input type="hidden" id="shift" value="<?= $shift ?>">
    <input type="hidden" id="shift_group" value="<?= $shift_group ?>">
    <input type="hidden" id="dept_pd" value="<?= $dept_pd ?>">
    <input type="hidden" id="dept_qa" value="<?= $dept_qa ?>">
    <input type="hidden" id="section_pd" value="<?= $section_pd ?>">
    <input type="hidden" id="section_qa" value="<?= $section_qa ?>">
    <input type="hidden" id="line_no" value="<?= $line_no ?>">
    <input type="hidden" id="registlinename" value="<?= $registlinename ?>">
    <input type="hidden" id="started" value="<?= $started; ?>">
    <input type="hidden" id="takt" value="<?= $takt; ?>">
    <input type="hidden" id="last_takt" value="<?= $last_takt; ?>">
    <input type="hidden" id="added_takt_plan" value="<?= $added_takt_plan; ?>">
    <input type="hidden" id="is_paused" value="<?= $is_paused; ?>">
    <input type="hidden" id="andon_line" name="andon_line" value="<?= $andon_line; ?>">
    <input type="hidden" id="final_process" name="final_process" value="<?= $final_process; ?>">

    <input type="hidden" id="yield_target" name="yield_target" value="<?= $yield_target; ?>">
    <input type="hidden" id="ppm_target" name="ppm_target" value="<?= $ppm_target; ?>">
    <input type="hidden" id="acc_eff" name="acc_eff" value="<?= $acc_eff; ?>">
    <input type="hidden" id="start_bal_delay" name="start_bal_delay" value="<?= $start_bal_delay; ?>">
    <input type="hidden" id="work_time_plan" name="work_time_plan" value="<?= $work_time_plan; ?>">
    <div class="container-fluid">
        <div class="flex-column justify-content-center align-items-center">
            <!-- <img class="animation__shake" src="dist/img/logo.webp" alt="logo" height="40" width="40"> -->
            <!-- <span class="h6">PCAD<span> -->
        </div>
    </div>

    <div class="container-fluid">
        <?php
        if ($processing) {
            ?>

            <?php

        } else {
            ?>
            <input type="hidden" id="processing" value="0">
            <div class="modal fade darkest-modal" id="plannotset" tabindex="-1" aria-labelledby="plannotsetLabel"
                aria-hidden="true" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-xl"
                    style="border-radius: 7px; border: 2px solid #CA3F3F; box-shadow: 0px 10px 10px 0px rgba(0, 0, 0, 0.25)">
                    <div class="modal-content" style="background-color: white;">
                        <div class="modal-body">
                            <h2 class="modal-title display-4 text-center pb-3" id="plannotsetLabel" style="color: #000;">
                                <b>Plan not set</b>
                            </h2>
                            <div class="row justify-content-center text-center mb-3">
                                <div class="col-3">
                                    <a href="pcs_page/setting.php" class="btn btn-lg btn-success text-white btn-close"
                                        id="setplanBtn">SET
                                        PLAN<b>[ 4
                                            ]</b></a>
                                </div>
                                <div class="col-3">
                                    <a href="pcs_page/index.php" class="btn btn-lg btn-secondary text-white btn-close">MAIN
                                        MENU
                                        <b>[ 0
                                            ]</b></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <table class="table mt-5 mb-5" style="height: 80px;">
            <tbody class="m-0 p-0">
                <tr>
                    <td scope="col" class="equal-width pl-2" id="carmodel_label" style="vertical-align: middle;">Car
                        Maker/Model:
                    </td>
                    <th scope="col" class="equal-width pl-2" style="vertical-align: middle;">
                        <?= $Carmodel ?>
                    </th>
                    <td scope="col" class="equal-width pl-2" id="server_date_only_label"
                        style="vertical-align: middle;">Date:</td>
                    <th scope="col" class="equal-width pl-2" style="vertical-align: middle;">
                        <?= $server_date_only ?>
                    </th>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td scope="col" class="equal-width pl-2" id="line_no_label">Line:</td>
                    <th class="equal-width pl-2">
                        <?= $line_no ?>
                    </th>
                    <td scope="col" class="equal-width pl-2" id="shift_label">Shift:</td>
                    <th class="equal-width pl-2">
                        <?= $shift ?>
                    </th>
                </tr>
            </tbody>
        </table>

        <!-- carousel -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                </li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active" style="height: 640px;">
                    <table class="table text-center m-0 p-0" style="border-bottom: none;">
                        <thead>
                            <tr style="height: 90px;">
                                <td colspan="3" class="equal-py" style="vertical-align: middle;">YIELD</td>
                                <td colspan="3" class="equal-py" style="vertical-align: middle;">PPM</td>
                            </tr>
                        </thead>
                    </table>
                    <table class="table text-center m-0 p-0" style="border-top: none;">
                        <tbody style="height: 400px;">
                            <tr>
                                <td scope="col" class="value-size1">
                                    <?= $yield_target; ?>%
                                </td>
                                <td scope="col" style="vertical-align: middle; font-size: 35px;">
                                    TARGET</td>
                                <td scope="col" class="value-size1">
                                    <?= number_format($ppm_target); ?>
                                </td>
                            </tr>
                            <tr>
                                <td scope="col" class="value-size1" id="actual_yield">
                                </td>
                                <td scope="col" style="vertical-align: middle; font-size: 35px;">
                                    ACTUAL</td>
                                <td scope="col" class="value-size1" id="actual_ppm">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="carousel-item" style="height: 640px;">
                    <table>
                        <tbody class="text-center">
                            <tr style="height: 60px;">
                                <td scope="col" class="equal-plan-acct-hr"></td>
                                <td scope="col" class="equal-plan-acct-hr font-plan-sub">Target
                                </td>
                                <td scope="col" class="equal-plan-acct-hr font-plan-sub">Actual
                                </td>
                                <td scope="col" class="equal-plan-acct-hr font-plan-sub">Gap
                                </td>
                            </tr>
                        </tbody>
                        <tbody class="text-center">
                            <tr>
                                <input type="hidden" id="processing" value="1">
                                <td scope="col" class="font-plan equal-plan-acct-hr">
                                    Plan</td>
                                <td scope="col" id="plan_target"
                                    class="plan_target_value value-size2 equal-plan-acct-hr">
                                </td>
                                <td scope="col" id="plan_actual"
                                    class="plan_actual_value value-size2 equal-plan-acct-hr">
                                </td>
                                <td scope="col" id="plan_gap" class="plan_gap_value value-size2 equal-plan-acct-hr">
                                </td>
                            </tr>
                            <tr>
                                <td scope="col" class="font-plan equal-plan-acct-hr">
                                    Accounting Efficiency</td>
                                <td scope="col" id="target_accounting_efficiency"
                                    class="value-size2 equal-plan-acct-hr">
                                    <?= $acc_eff; ?>%
                                </td>
                                <td scope="col" id="actual_accounting_efficiency"
                                    class="value-size2 equal-plan-acct-hr"></td>
                                <td scope="col" id="gap_accounting_efficiency" class="value-size2 equal-plan-acct-hr">
                                </td>
                            </tr>
                            <tr>
                                <td scope="col" class="font-plan equal-plan-acct-hr">
                                    Hourly Output</td>
                                <td scope="col" id="target_hourly_output" class="value-size2 equal-plan-acct-hr"></td>
                                <td scope="col" id="actual_hourly_output" class="value-size2 equal-plan-acct-hr"></td>
                                <td scope="col" id="gap_hourly_output" class="value-size2 equal-plan-acct-hr"></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- <table class="table text-center">
                                                <thead>
                                                        <tr style="height: 60px;">
                                                                <th colspan="3" class="font-plan"
                                                                        style="vertical-align: middle;">Plan</th>
                                                                <th colspan="3" class="font-plan"
                                                                        style="vertical-align: middle">Accounting
                                                                        Efficiency</th>
                                                                <th colspan="3" class="font-plan"
                                                                        style="vertical-align: middle">Hourly Output
                                                                </th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                                <input type="hidden" id="processing" value="1">
                                                                <th scope="col" class="th-normal font-plan-sub">Target
                                                                </th>
                                                                <th scope="col" class="th-normal font-plan-sub">Actual
                                                                </th>
                                                                <th scope="col" class="th-normal font-plan-sub">Gap</th>
                                                                <th scope="col" class="th-normal font-plan-sub">Target
                                                                </th>
                                                                <th scope="col" class="th-normal font-plan-sub">Actual
                                                                </th>
                                                                <th scope="col" class="th-normal font-plan-sub">Gap</th>
                                                                <th scope="col" class="th-normal font-plan-sub">Target
                                                                </th>
                                                                <th scope="col" class="th-normal font-plan-sub">Actual
                                                                </th>
                                                                <th scope="col" class="th-normal font-plan-sub">Gap</th>
                                                        </tr>

                                                        <tr>
                                                                <td scope="col" id="plan_target"
                                                                        class="plan_target_value value-size"></td>
                                                                <td scope="col" id="plan_actual"
                                                                        class="plan_actual_value value-size"></td>
                                                                <td scope="col" id="plan_gap"
                                                                        class="plan_gap_value value-size">
                                                                </td>

                                                                <td scope="col" id="target_accounting_efficiency"
                                                                        class="value-size">
                                                                        <?= $acc_eff; ?>%
                                                                </td>
                                                                <td scope="col" id="actual_accounting_efficiency"
                                                                        class="value-size"></td>
                                                                <td scope="col" id="gap_accounting_efficiency"
                                                                        class="value-size"></td>

                                                                <td scope="col" id="target_hourly_output"
                                                                        class="value-size"></td>
                                                                <td scope="col" id="actual_hourly_output"
                                                                        class="value-size"></td>
                                                                <td scope="col" id="gap_hourly_output"
                                                                        class="value-size"></td>
                                                        </tr>
                                                </tbody>
                                        </table> -->
                </div>
                <div class="carousel-item" style="height: 640px;">
                    <table class="text-center mb-3">
                        <thead style="height: 90px;">
                            <tr>
                                <td colspan="4" class="font-plan" style="vertical-align: middle;">
                                    OVERALL INSPECTION
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="col" class="equal-insp font-plan-sub th-normal">GOOD
                                </th>
                                <td scope="col" id="insp_overall_g" class="value-size1">
                                </td>
                                <td scope="col" id="insp_overall_ng" class="value-size1">
                                </td>
                                <th scope="col" class="equal-insp font-plan-sub th-normal">NG
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <!--  -->

                    <table class="text-center table-head-fixed text-nowrap"
                        style="max-height: 200px; overflow-y: auto;">
                        <thead style="position: sticky; top: 0; z-index: 1; height: 80px;">
                            <tr>
                                <td class="equal-insp-info font-plan-sub">GOOD</td>
                                <td class="equal-insp-info font-plan-sub">INSPECTION
                                </td>
                                <td class="equal-insp-info font-plan-sub">NG</td>
                            </tr>
                        </thead>
                        <tbody class="mb-0" id="inspection_process_list">
                            <tr>
                                <!-- <td scope="col" style="text-align: center;"></td> -->
                            </tr>
                        </tbody>
                    </table>

                </div>
                <!-- <div class="carousel-item" style="height: 640px;">
                                        <div class="row">
                                                <div class="col-12">
                                                        <div class="card" style="border: 1px solid #515151;">
                                                                <div id="chart-container">
                                                                        <canvas id="hourly_chart" height="50"></canvas>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div> -->

                <div class="carousel-item" style="height: 640px;">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="card" style="border: 1px solid #515151;">
                                <div id="chart-container" style="width: 100%; height: 100%;">
                                    <canvas id="hourly_chart" height="80"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================================================================================================== -->
                <div class="carousel-item" style="height: 640px;">
                    <table>
                        <thead style="height: 90px;">
                            <tr class="text-center">
                                <td colspan="2" class="equal-details font-plan">PD
                                    MANPOWER</td>
                                <td colspan="2" class="equal-details font-plan">QA
                                    MANPOWER</th>
                                <td colspan="2" class="equal-details font-plan">OTHER
                                    DETAILS</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="th-normal equal-sub-details text-left font-others">
                                    Plan:
                                </th>
                                <td id="total_pd_mp" class="equal-sub-details text-left font-others-value">
                                </td>
                                <th class="th-normal equal-sub-details text-left font-others">
                                    Plan:
                                </th>
                                <td id="total_qa_mp" class="equal-sub-details text-left font-others-value">
                                </td>
                                <th class="th-normal equal-sub-details text-left font-others">
                                    Starting Balance Delay:</th>
                                <td class="equal-sub-details text-left font-others-value">
                                    <?= $start_bal_delay; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="th-normal text-left font-others">Actual:</th>
                                <td id="total_present_pd_mp" class="text-left font-others-value"></td>
                                <th class="th-normal text-left font-others">Actual:</th>
                                <td id="total_present_qa_mp" class="text-left font-others-value"></td>
                                <th class="th-normal text-left font-others">Conveyor
                                    Speed:</th>
                                <td id="taktset" class="text-left font-others-value">
                                </td>
                            </tr>
                            <tr>
                                <th class="th-normal text-left font-others">Absent:</th>
                                <td id="total_absent_pd_mp" class="text-left font-others-value"></td>
                                <th class="th-normal text-left font-others">Absent:</th>
                                <td id="total_absent_qa_mp" class="text-left font-others-value"></td>
                                <th class="th-normal takt-label text-left font-others">
                                    Takt Time:</th>
                                <td class="takt-value text-left font-others-value"></td>
                            </tr>
                            <tr>
                                <th class="th-normal text-left font-others">Support:
                                </th>
                                <td id="total_pd_mp_line_support_to" class="text-left font-others-value">
                                </td>
                                <th class="th-normal text-left font-others">Support:
                                </th>
                                <td id="total_qa_mp_line_support_to" class="text-left font-others-value">
                                </td>
                                <th class="th-normal text-left font-others">Working Time
                                    Plan:</th>
                                <td class="text-left font-others-value">
                                    <?= $work_time_plan; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="th-normal text-left font-others">Absent Rate:
                                </th>
                                <td id="absent_ratio_pd_mp" class="text-left font-others-value"></td>
                                <th class="th-normal text-left font-others">Absent Rate:
                                </th>
                                <td id="absent_ratio_qa_mp" class="text-left font-others-value"></td>
                                <th class="th-normal text-left font-others">Working Time
                                    Actual:
                                </th>
                                <td class="text-left font-others-value"></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <!-- buttons for tv -->
        <div class="row">
            <div class="col-4">
                <div>
                    <button type="button" class="btn btn-danger btn-block btn-pause">PAUSE <b>[ 1
                            ]</b></button>
                </div>
                <div>
                    <button type="button" class="btn btn-info btn-block btn-resume d-none">RESUME<b>[ 3
                            ]</b></button>
                </div>
            </div>
            <div class="col-4">
                <button type="button" class="btn btn-success btn-block btn-target ">END PROCESS <b>[ 2
                        ]</b></button>
            </div>
            <div class="col-4">
                <a type="button" class="btn btn-secondary btn-block btn-menu" href="pcs_page/index.php">MAIN
                    MENU <b>[ 0 ]</b></a>
            </div>
        </div>
        <div class="col-3">
            <a href="pcs_page/setting.php" class="btn  btn-primary btn-set d-none" id="setnewTargetBtn">SET
                NEW TARGET<b>[ 5 ]</b></a>
        </div>
    </div>



    <!-- table legend -->
    <!-- <div class="row mt-3">
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
                </div> -->
    </div>
</body>

<!-- jQuery -->
<script src="plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>





<!-- mdb -->
<script src="plugins/mdb/js/mdb.min.js"></script>
<script src="plugins/mdb/js/mdb.js"></script>
<!-- Chart JS -->
<script src="node_modules/chart.js/dist/chart.umd.js"></script>
<!--Moment JS -->
<script src="plugins/moment-js/moment.min.js"></script>
<script src="plugins/moment-js/moment-duration-format.min.js"></script>


<script>
    $('.carousel').carousel({
        interval: 30000
    })

    let chart; // Declare chart variable globally

    // Set LocalStorage for these variables
    localStorage.setItem("andon_line", $("#andon_line").val());
    localStorage.setItem("shift", $("#shift").val());

    $(document).ready(function () {
        // Call these functions initially to load the data from PCAD and other Systems
        // Set interval to refresh data every 30 seconds
        // 30000 milliseconds = 30 seconds
        get_accounting_efficiency();
        setInterval(get_accounting_efficiency, 30000);
        get_hourly_output();
        setInterval(get_hourly_output, 30000);
        get_yield();
        setInterval(get_yield, 30000);
        get_ppm();
        setInterval(get_ppm, 30000);

        // INSPECTION
        get_inspection_list();
        setInterval(get_inspection_list, 10000);
        get_overall_inspection();
        setInterval(get_overall_inspection, 10000);

        // Call count_emp initially to load the data from employee management system
        count_emp();
        // Set interval to refresh data every 15 seconds
        setInterval(count_emp, 15000); // 15000 milliseconds = 15 seconds

        // Call andon_d_sum initially to load the chart
        andon_d_sum();
        // Set interval to refresh data every 10 seconds
        setInterval(andon_d_sum, 30000); // 10000 milliseconds = 10 seconds
    });

    // ==========================================================================================

    // Apply gradient styles for specific cell with ID 'total_pd_mp'
    function applyGradientStyles(selector, color, dataAttribute) {
        document.querySelectorAll(selector).forEach(function (cell) {
            var value = parseInt(cell.dataset[dataAttribute]);
            var gradientValue = value + '%';
            cell.style.background = 'linear-gradient(to right, ' + color + ' ' + gradientValue + ', #f6f6f6 ' + gradientValue + ')';
        });
    }

    // Example usage:
    applyGradientStyles('.numeric-cell', '#abd2fa', 'value');
    applyGradientStyles('.numeric-cell-acct', '#ffe89c', 'value');
    applyGradientStyles('.numeric-cell-hourly', '#95d5b2', 'value');

    // Apply gradient styles for specific cell with ID 'total_pd_mp'
    var specificCell = document.getElementById('total_pd_mp');
    if (specificCell) {
        var specificValue = parseInt(specificCell.dataset.value);
        var specificGradientValue = specificValue + '%';
        specificCell.style.background = 'linear-gradient(to right, #your_specific_color ' + specificGradientValue + ', #f6f6f6 ' + specificGradientValue + ')';
    }
    // ==========================================================================================

    // Handle click event for GOOD cell
    $('#insp_overall_g').on('click', function () {
        var specificUrl = '../pcad/viewer/good_inspection_details/inspection_details.php?card=good';
        window.open(specificUrl, '_blank');
    });

    // Handle click event for NG cell
    $('#insp_overall_ng').on('click', function () {
        var specificUrl = '../pcad/viewer/ng_inspection_details/inspection_details_ng.php?card=ng';
        window.open(specificUrl, '_blank');
    });
</script>

<?php
include 'javascript/pcs.php';
include 'javascript/pcad.php';
include 'javascript/emp_mgt.php';
include 'javascript/andon.php';
include 'javascript/inspection_output.php';
?>

</html>
<!-- /.navbar -->