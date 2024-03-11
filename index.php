<?php
include 'process/pcs/index.php';
include 'dist/js/adminlte.miin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PCAD | Dashboard</title>

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
                        border: 1px solid #DDD;
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

                /* for inspection output scroll */
                table.scrolldown {
                        width: 100%;

                        /* border-collapse: collapse; */
                        border-spacing: 0;
                        border: 2px solid black;
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
        <div class="container-fluid mt-5">
                <!-- <h2 class="text-center m-4">Production Conveyor Analysis Dashboard</h2> -->
                <div class="col-12">
                        <div class="card" style="border: 2px solid #4E4E4E; border-radius: 5px;">
                                <div class="card-body">
                                        <!-- first row -->
                                        <div class="row mb-4">
                                                <div class="col-12">
                                                        <table>
                                                                <tr>
                                                                        <th class="col-md-2" id="carmodel_label">Car
                                                                                Maker/Model:</th>
                                                                        <td class="col-md-4">
                                                                                <?= $Carmodel ?>
                                                                        </td>
                                                                        <th class="col-md-2"
                                                                                id="server_date_only_label">Date:</th>
                                                                        <td class="col-md-4">
                                                                                <?= $server_date_only ?>
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <th class="col-md-2" id="line_no_label">Line:
                                                                        </th>
                                                                        <td class="col-md-4">
                                                                                <?= $line_no ?>
                                                                        </td>
                                                                        <th class="col-md-2" id="shift_label">Shift:
                                                                        </th>
                                                                        <td class="col-md-4">
                                                                                <?= $shift ?>
                                                                        </td>
                                                                </tr>
                                                        </table>
                                                </div>
                                        </div>
                                        <!-- second row -->
                                        <div class="row mb-4">
                                                <div class="col-4">
                                                        <!-- yield and ppm -->
                                                        <table style="border-bottom: none">
                                                                <tr>
                                                                        <th colspan="3" class="col-md-6 text-center">
                                                                                YIELD</th>
                                                                        <th colspan="3" class="col-md-6 text-center">PPM
                                                                        </th>
                                                                </tr>

                                                        </table>
                                                        <table style="border-top: none; height: 135px">
                                                                <tr>
                                                                        <td class="col-md-2 text-center value-size">
                                                                                <?= $yield_target; ?>%
                                                                        </td>
                                                                        <th class="th-normal col-md-2 text-center">
                                                                                TARGET</th>
                                                                        <td class="col-md-2 text-center value-size">
                                                                                <?= number_format($ppm_target); ?>
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <td class=" col-md-2 text-center value-size""
                                                                                style=" background: #ffe89c;"
                                                                                id="actual_yield"></td>
                                                                        <th class="th-normal col-md-2 text-center">
                                                                                ACTUAL</th>
                                                                        <td class="col-md-2 text-center value-size""
                                                                                style=" background: #f38375;"
                                                                                id="actual_ppm"></td>
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
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'
                                                                                colspan="3" class="text-center">HOURLY
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
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'
                                                                                class="th-normal col-md-1 text-center">
                                                                                Target</th>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'
                                                                                class="th-normal col-md-1 text-center">
                                                                                Actual</th>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'
                                                                                class="th-normal col-md-1 text-center">
                                                                                Gap
                                                                        </th>
                                                                </tr>
                                                                <tr>
                                                                        <!-- plan value -->
                                                                        <?php
                                                                        if ($processing) {
                                                                                ?>
                                                                                <input type="hidden" id="processing" value="1">

                                                                                <td class="plan_target_value numeric-cell col-md-1 text-center value-size"
                                                                                        data-value="100" style="height: 107px"
                                                                                        id="plan_target"></td>
                                                                                <td class="plan_actual_value numeric-cell col-md-1 text-center value-size"
                                                                                        data-value="100" id="plan_actual"></td>
                                                                                <td class="plan_gap_value numeric-cell col-md-1 text-center value-size"
                                                                                        data-value="100" id="plan_gap"></td>
                                                                                <?php

                                                                        } else {
                                                                                ?>
                                                                                <input type="hidden" id="processing" value="0">
                                                                                <div class="modal fade darkest-modal"
                                                                                        id="plannotset" tabindex="-1"
                                                                                        aria-labelledby="plannotsetLabel"
                                                                                        aria-hidden="true" role="dialog"
                                                                                        aria-labelledby="exampleModalLabel"
                                                                                        aria-hidden="true"
                                                                                        data-backdrop="static"
                                                                                        data-keyboard="false">
                                                                                        <div class="modal-dialog modal-xl"
                                                                                                style="border-radius: 7px; border: 2px solid #CA3F3F; box-shadow: 0px 10px 10px 0px rgba(0, 0, 0, 0.25)">
                                                                                                <div class="modal-content"
                                                                                                        style="background-color: white;">
                                                                                                        <div class="modal-body">
                                                                                                                <h2 class="modal-title display-4 text-center pb-3"
                                                                                                                        id="plannotsetLabel">
                                                                                                                        <b>Plan not
                                                                                                                                set</b>
                                                                                                                </h2>
                                                                                                                <div
                                                                                                                        class="row justify-content-center text-center mb-3">
                                                                                                                        <div
                                                                                                                                class="col-3">
                                                                                                                                <a href="pcs_page/setting.php"
                                                                                                                                        class="btn btn-lg btn-success text-white btn-close"
                                                                                                                                        id="setplanBtn">SET
                                                                                                                                        PLAN<b>[ 4
                                                                                                                                                ]</b></a>
                                                                                                                        </div>
                                                                                                                        <div
                                                                                                                                class="col-3">
                                                                                                                                <a href="pcs_page/index.php"
                                                                                                                                        class="btn btn-lg btn-secondary text-white btn-close">MAIN
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

                                                                        <!-- accounting efficiecny value -->
                                                                        <td class="numeric-cell-acct col-md-1 text-center value-size"
                                                                                data-value="100"
                                                                                id="target_accounting_efficiency">
                                                                                <?= $acc_eff; ?>%
                                                                        </td>
                                                                        <td class="numeric-cell-acct col-md-1 text-center value-size"
                                                                                data-value="100"
                                                                                id="actual_accounting_efficiency"></td>
                                                                        <td class="numeric-cell-acct col-md-1 text-center value-size"
                                                                                data-value="100"
                                                                                id="gap_accounting_efficiency"></td>

                                                                        <!-- hourly output value -->
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'
                                                                                class="numeric-cell-hourly col-md-1 text-center value-size"
                                                                                data-value="100"
                                                                                id="target_hourly_output"></td>
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'
                                                                                class="numeric-cell-hourly col-md-1 text-center value-size"
                                                                                data-value="100"
                                                                                id="actual_hourly_output"></td>
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'
                                                                                class="numeric-cell-hourly col-md-1 text-center value-size"
                                                                                data-value="100" id="gap_hourly_output">
                                                                        </td>
                                                                </tr>
                                                        </table>
                                                </div>

                                        </div>
                                        <!-- third row -->
                                        <div class="row mb-3">
                                                <div class="col-4">
                                                        <!-- overall inspection -->

                                                        <table style="min-height:225px;">
                                                                <tr>
                                                                        <th colspan="4" class="text-center">OVERALL
                                                                                INSPECTION
                                                                        </th>
                                                                </tr>
                                                                <tr>
                                                                        <a target="_blank"
                                                                                href="../pcad/viewer/good_inspection_details/inspection_details.php"
                                                                                style="color: #000; cursor: pointer;">
                                                                                <th class="col-md-2 text-center">GOOD
                                                                                </th>
                                                                                <td id="insp_overall_g"
                                                                                        class="col-md-4 text-center value-size"
                                                                                        style="height: 190px; background: #95d5b2; cursor: pointer;">
                                                                                </td>
                                                                        </a>

                                                                        <a target="_blank"
                                                                                href="../pcad/viewer/ng_inspection_details/inspection_details_ng.php"
                                                                                style="color: #000">
                                                                                <td id="insp_overall_ng"
                                                                                        class="col-md-4 text-center value-size"
                                                                                        style="background: #f38375; cursor: pointer;">
                                                                                </td>
                                                                                <th class="col-md-2 text-center">NG</th>
                                                                        </a>
                                                                </tr>
                                                        </table>
                                                </div>
                                                <!-- <div class="col-1"></div> -->
                                                <div class="col-8">
                                                        <!-- dt, delay, andon graph -->
                                                        <div class="card" style="border: 2px solid #4E4E4E">
                                                                <!-- <h6 class="text-center text-bold">DT / Delay / Andon</h6> -->

                                                                <a target="_blank"
                                                                        href="../pcad/viewer/andon_details/andon_details.php"
                                                                        class="card-link">
                                                                        <div id="chart-container">
                                                                                <canvas id="hourly_chart"
                                                                                        height="54"></canvas>
                                                                        </div>
                                                                </a>
                                                        </div>
                                                </div>
                                        </div>
                                        <!-- fourth row -->
                                        <div class="row">
                                                <div class="col-4 table-responsive">
                                                        <!-- inspection details -->
                                                        <div class="table-responsive m-0 p-0"
                                                                style="max-height: 172px; overflow-y: auto;">
                                                                <table
                                                                        class="m-0 p-0 table-head-fixed text-nowrap table-hover">
                                                                        <thead
                                                                                style="text-align: center; position: sticky; top: 0; background-color: #fff; z-index: 1; height: 55px">
                                                                                <th class="col-md-4 text-center">GOOD
                                                                                </th>
                                                                                <th class="col-md-4 text-center">
                                                                                        INSPECTION</th>
                                                                                <th class="col-md-4 text-center">NG</th>
                                                                        </thead>
                                                                        <tbody class="mb-0"
                                                                                id="inspection_process_list">
                                                                                <tr>
                                                                                        <td colspan="3"
                                                                                                style="text-align: center;">
                                                                                        </td>
                                                                                </tr>
                                                                        </tbody>
                                                                </table>
                                                        </div>
                                                </div>
                                                <!-- <div class="col-1"></div> -->
                                                <div class="col-8">
                                                        <!-- pd qa other details -->
                                                        <table>
                                                                <tr>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                colspan="2"
                                                                                class="col-md-3 text-center">PD
                                                                                MANPOWER</th>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                colspan="2"
                                                                                class="col-md-3 text-center">QA
                                                                                MANPOWER</th>
                                                                        <th colspan="2" class="col-md-3 text-center">
                                                                                OTHER DETAILS</th>
                                                                </tr>
                                                                <tr>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="th-normal col-md-1">Plan:</th>
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="numeric-cell col-md-1 text-center"
                                                                                data-value="100" id="total_pd_mp"></td>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="th-normal col-md-1">Plan:</th>
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="numeric-cell col-md-1 text-center"
                                                                                data-value="100" id="total_qa_mp"></td>

                                                                        <th class="th-normal col-md-1"
                                                                                style="font-size: 13px">Starting Balance
                                                                                Delay:</th>
                                                                        <td class="col-md-1 text-center">
                                                                                <?= $start_bal_delay; ?>
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="th-normal col-md-1">Actual:</th>
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="numeric-cell col-md-1 text-center"
                                                                                data-value="94"
                                                                                id="total_present_pd_mp"></td>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="th-normal col-md-1">Actual:</th>
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="numeric-cell col-md-1 text-center"
                                                                                data-value="97"
                                                                                id="total_present_qa_mp"></td>

                                                                        <th class="th-normal col-md-1">Conveyor Speed:
                                                                        </th>
                                                                        <td class="col-md-1 text-center" id="taktset">
                                                                        </td>
                                                                        </td>
                                                                </tr>

                                                                <tr>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="th-normal col-md-1">Absent:</th>
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="numeric-cell col-md-1 text-center"
                                                                                data-value="100"
                                                                                id="total_absent_pd_mp"></td>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="th-normal col-md-1">Absent:</th>
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="numeric-cell col-md-1 text-center"
                                                                                data-value="100"
                                                                                id="total_absent_qa_mp"></td>

                                                                        <th class="th-normal col-md-1 takt-label">Takt
                                                                                Time:</th>
                                                                        <td class="col-md-1 text-center takt-value">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="th-normal col-md-1">Support:</th>
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="numeric-cell col-md-1 text-center"
                                                                                data-value="6"
                                                                                id="total_pd_mp_line_support_to"></td>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="th-normal col-md-1">Support:</th>
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="numeric-cell col-md-1 text-center"
                                                                                data-value="3"
                                                                                id="total_qa_mp_line_support_to"></td>

                                                                        <th class="th-normal col-md-1"
                                                                                style="font-size: 13px">Working Time
                                                                                Plan:</th>
                                                                        <td class="col-md-1 text-center">
                                                                                <?= $work_time_plan; ?>
                                                                        </td>
                                                                </tr>
                                                                <tr>

                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="th-normal col-md-1">Absent Rate:
                                                                        </th>
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="col-md-2 text-center"
                                                                                style="background: #fae588"
                                                                                id="absent_ratio_pd_mp"></td>
                                                                        <th style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="th-normal col-md-1">Absent Rate:
                                                                        </th>
                                                                        <td style="cursor:pointer;"
                                                                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'
                                                                                class="col-md-2 text-center"
                                                                                style="background: #f38375;"
                                                                                id="absent_ratio_qa_mp"></td>

                                                                        <th class="th-normal col-md-1"
                                                                                style="font-size: 13px">Working Time
                                                                                Actual:</th>
                                                                        <td class="col-md-1 text-center"></td>
                                                                </tr>
                                                        </table>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>

                <!-- Buttons (Progress Counter TV) -->
                <div class="row">
                        <div class="col-4">
                                <div>
                                        <button type="button" class="btn btn-danger btn-block btn-pause">PAUSE <b>[ 1
                                                        ]</b></button>
                                </div>
                                <div>
                                        <button type="button" class="btn btn-info btn-block btn-resume d-none">RESUME
                                                <b>[ 3 ]</b></button>
                                </div>
                        </div>
                        <div class="col-4">
                                <button type="button" class="btn btn-success btn-block btn-target ">END PROCESS <b>[ 2
                                                ]</b></button>
                        </div>
                        <div class="col-4">
                                <a type="button" class="btn btn-secondary btn-block btn-menu" href="pcs_page/index.php">
                                        MAIN MENU <b>[ 0
                                                ]</b></a>
                        </div>
                </div>

                <div class="col-3">
                        <a href="pcs_page/setting.php" class="btn  btn-primary btn-set d-none" id="setnewTargetBtn">SET
                                NEW TARGET
                                <b>[ 5 ]</b></a>
                </div>

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
<!--Moment JS -->
<script src="plugins/moment-js/moment.min.js"></script>
<script src="plugins/moment-js/moment-duration-format.min.js"></script>

<script>
        let chart; // Declare chart variable globally

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
                setInterval(andon_d_sum, 10000); // 10000 milliseconds = 10 seconds
        });
        // Apply gradient background dynamically using JavaScript
        document.querySelectorAll('.numeric-cell').forEach(function (cell) {
                var value = parseInt(cell.dataset.value);
                var gradientValue = value + '%';
                cell.style.background = 'linear-gradient(to right, #abd2fa ' + gradientValue + ', #f6f6f6 ' + gradientValue + ')';
        });

        document.querySelectorAll('.numeric-cell-acct').forEach(function (cell) {
                var value = parseInt(cell.dataset.value);
                var gradientValue = value + '%';
                cell.style.background = 'linear-gradient(to right, #ffe89c ' + gradientValue + ', #f6f6f6 ' + gradientValue + ')';
        });

        document.querySelectorAll('.numeric-cell-hourly').forEach(function (cell) {
                var value = parseInt(cell.dataset.value);
                var gradientValue = value + '%';
                cell.style.background = 'linear-gradient(to right, #95d5b2 ' + gradientValue + ', #f6f6f6 ' + gradientValue + ')';
        });

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