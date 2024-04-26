<?php
include 'process/pcs/index.php';
include 'dist/js/adminlte.miin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PCAD | Managerial Dashboard</title>

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
        ::-webkit-scrollbar {
            width: 8px;
            height: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #383B46;
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #332D2D;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('dist/font/poppins/Poppins-Regular.ttf') format('truetype');
        }

        @media screen and (min-width: 1366px) and (max-width: 1366px) {
            .container-fluid {
                width: 100%;
            }
        }

        @media screen and (min-width: 1920px) and (max-width: 1920px) {
            .container-fluid {
                width: 100%;
            }
        }

        body {
            /* background: #292C35; */
            font-family: 'Poppins', sans-serif;

            /* for toggle mode */
            background-color: #FDFDFD;
            min-height: 100vh;
            margin: 0;
            transition: background 0.2s linear;
            cursor: pointer;
        }

        table {
            border-collapse: separate;
            border-spacing: 10px;
            width: 100%;
        }

        /* for inspection output scroll */
        table.scrolldown {
            width: 100%;
            border-spacing: 0;
            border: 2px solid black;
        }

        /* To display the block as level element */
        table.scrolldown tbody,
        table.scrolldown thead {
            display: block;
        }

        table.scrolldown tbody {
            height: 168px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .darkest-modal .modal-backdrop {
            background-color: rgba(0, 0, 0, 1);
        }

        /* =============== ADDITIONAL CSS FOR NEW LAYOUT*/
        .icon-h1,
        .icon-h2,
        .icon-h3,
        .icon-h4 {
            width: 45px;
        }

        .header-width {
            width: 25%;
        }

        .header-div {
            display: flex;
        }

        .header-div-2 {
            width: 20%;
            display: grid;
            place-content: center;
        }

        .header-div-3 {
            width: 80%;
        }

        .header-title {
            margin: 0;
            padding-top: 10px;
            font-size: 18px;
        }

        .header-content {
            margin: 0;
            padding-right: 30px;
            font-size: 35px;
            font-weight: bold;
            text-align: right;
        }

        /*  */
        .plan-div {
            display: flex;
            justify-content: space-between;
        }

        .plan-container {
            width: 33%;
        }

        .acc-eff-container {
            width: 33%;
        }

        .hourly-container {
            width: 33%;
        }

        .plan-title {
            text-align: left;
            font-size: 20px;
            padding-left: 10px;
            background: #F4F4F4;
            border: 1px solid #F4F4F4;
            border-radius: 5px;
            height: 40px;
        }

        .plan-sub-title {
            text-align: center;
            font-size: 18px;
            width: 33%;
        }

        .plan-content {
            text-align: center;
            font-size: 45px;
            font-weight: bold;
        }

        /*  */
        .yield-div {
            display: flex;
            /* justify-content: space-between; */
        }

        .yield-container {
            width: 33%;
        }

        .inspection-container {
            width: 67%;
            margin-left: 11px;

            display: flex;
            flex-direction: row;
        }

        .inspection-container-2 {
            width: 35%;
        }

        .inspection-container-3 {
            width: 65%;
        }

        .yield-title {
            text-align: center;
            font-size: 20px;
            width: 50%;
        }

        .yield-sub-title {
            text-align: center;
            font-size: 18px;
            width: 33%;
        }

        .yield-content {
            text-align: center;
            font-size: 45px;
            font-weight: bold;
            width: 33%;
        }

        .inspection-title {
            text-align: left;
            padding-left: 10px;
            font-size: 20px;
        }

        .inspection-sub-title {
            text-align: center;
            font-size: 18px;
            width: 50%;

            background: #F4F4F4;
            border: 1px solid #F4F4F4;
            border-radius: 50px;
            height: 50px;
        }

        .inspection-sub-title-2 {
            text-align: center;
            font-size: 18px;
            width: 33%;

            background: #F4F4F4;
            border: 1px solid #F4F4F4;
            border-radius: 5px;
            height: 50px;
        }

        .inspection-content {
            text-align: center;
            font-size: 45px;
            font-weight: bold;
            width: 50%;
        }

        .icon-2 {
            width: 15px;
        }

        /*  */
        .manpower-div {
            display: flex;
            justify-content: space-between;
        }

        .pd-container {
            width: 33%;
        }

        .qa-container {
            width: 33%;
        }

        .other-container {
            width: 33%;
        }

        .manpower-title {
            text-align: center;
            font-size: 20px;
            background: #F4F4F4;
            border: 1px solid #F4F4F4;
            border-radius: 5px;
            height: 40px;
        }

        .manpower-content {
            font-size: 16px;
            padding-left: 15px;
            width: 50%;
        }

        .manpower-content-2 {
            font-size: 20px;
            width: 50%;
        }

        /*  */
        .process-design-div {
            display: flex;
        }

        .process-container {
            width: 33%;

        }

        .graphs-container {
            width: 67%;
            margin-left: 11px;
        }

        .process-title {
            text-align: left;
            padding-left: 10px;
            font-size: 20px;
            background: #F4F4F4;
            border: 1px solid #F4F4F4;
            border-radius: 5px;
            height: 40px;
        }

        .process-sub-title {
            font-size: 16px;
            padding-left: 15px;
        }

        .process-content {
            font-size: 20px;
            text-align: center;
        }

        .andon-container,
        .good-container,
        .ng-container {
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 10px;
        }

        .blue-bg {
            background: #569BE2;
        }

        .yellow-bg {
            background: #F6DB7F;
        }

        .green-bg {
            background: #38C578;
        }

        .red-bg {
            background: #DD6A5B;
        }

        .grey-bg {
            background: #EAEAEA;
        }

        .for-btn {
            background: #f4f4f4;
            border: none;
            color: #000;
        }

        .row-btn {
            background: #FBFBFB;
            height: 60px;
            border-radius: 4px;
        }

        /* ================================================== */
        body[light-mode=dark] {
            background-color: #212529;
            color: #FFF;
        }

        body[light-mode="dark"] .card {
            background-color: #343a40;
            color: #FFF;
        }

        body[light-mode="dark"] .plan-title,
        body[light-mode="dark"] .inspection-sub-title,
        body[light-mode="dark"] .inspection-sub-title-2,
        body[light-mode="dark"] .manpower-title,
        body[light-mode="dark"] .process-title {
            background-color: #495057;
            color: #FFF;
            border: none;
        }

        body[light-mode="dark"] .icon-h1 {
            content: url('dist/img/car-light.png');
        }

        body[light-mode="dark"] .icon-h2 {
            content: url('dist/img/setting-light.png');
        }

        body[light-mode="dark"] .icon-h3 {
            content: url('dist/img/clock-light.png');
        }

        body[light-mode="dark"] .icon-h4 {
            content: url('dist/img/calendar-light.png');
        }

        body[light-mode="dark"] .icon-2 {
            content: url('dist/img/expand-light.png');
        }

        body[light-mode="dark"] .nav-icon-top {
            content: url('dist/img/up-arrow-light.png');
        }

        body[light-mode="dark"] .blue-bg {
            background-color: #26496C;
        }

        body[light-mode="dark"] .yellow-bg {
            background-color: #CFAC33;
        }

        body[light-mode="dark"] .green-bg {
            background-color: #237C4B;
        }

        body[light-mode="dark"] .red-bg {
            background-color: #B13D2F;
        }

        body[light-mode="dark"] .grey-bg {
            background-color: #666666;
        }

        body[light-mode=dark] .for-btn {
            background: #3D414F;
            color: #fff;
        }

        body[light-mode=dark] .row-btn {
            background: #495057;
            color: #fff;
        }

        .checkbox {
            opacity: 0;
            position: absolute;
        }

        .checkbox-label {
            background-color: #111;
            width: 50px;
            height: 26px;
            border-radius: 50px;
            position: relative;
            padding: 5px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .fa-moon {
            color: #f1c40f;
        }

        .fa-sun {
            color: #f39c12;
        }

        .checkbox-label .ball {
            background-color: #fff;
            width: 22px;
            height: 22px;
            position: absolute;
            left: 2px;
            top: 2px;
            border-radius: 50%;
            transition: transform 0.2s linear;
        }

        .checkbox:checked+.checkbox-label .ball {
            transform: translateX(24px);
        }

        .support {
            position: absolute;
            right: 20px;
            bottom: 20px;
        }

        .support a {
            color: #292c35;
            font-size: 32px;
            backface-visibility: hidden;
            display: inline-block;
            transition: transform 0.2s ease;
        }

        .support a:hover {
            transform: scale(1.1);
        }

        /* ================================================== */
        .return-to-top {
            position: fixed;
            right: 15px;
            bottom: 15px;
            border: none;
            background: none;
            border-radius: 15%;
        }

        .return-to-top:hover {
            border: none;
        }

        .nav-icon-top {
            cursor: pointer;
            height: 50px;
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
    <input type="hidden" id="daily_plan" name="daily_plan" value="<?= $daily_plan; ?>">

    <div class="container-fluid mt-3">
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
                                        PLAN<b>[ 4 ]</b></a>
                                </div>
                                <div class="col-3">
                                    <a href="pcs_page/index.php" class="btn btn-lg btn-secondary text-white btn-close">MAIN
                                        MENU
                                        <b>[ 0 ]</b></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <!-- ===================== LIGHT/DARK MODE TOGGLE AND RETURN TO SETTING-->
        <div class="row">
            <div class="col-6">
                <div class="float-left mb-3 ml-2">
                    <a href="../pcad/dashboard/setting.php">
                        <button class="btn btn-secondary return-btn"
                            style="background: #f4f4f4; border: none; color: #000;"
                            onmouseover="this.style.backgroundColor='#383B46'; this.style.color='#FFF';"
                            onmouseout="this.style.backgroundColor='#f4f4f4'; this.style.color='#000';"><i
                                class="fas fa-arrow-left" style="width"></i>&ensp;&ensp;Return to Setting</button>
                    </a>
                </div>
            </div>
            <div class="col-6">
                <div class="float-right mb-3 mr-2">
                    <input type="checkbox" class="checkbox" id="checkbox" onclick="toggle_light_mode()">
                    <label for="checkbox" class="checkbox-label">
                        <i class="fas fa-moon"></i>
                        <i class="fas fa-sun"></i>
                        <span class="ball"></span>
                    </label>
                </div>
                <div class="float-right mb-3 mr-2">
                    <button class="btn btn-secondary" style="background: #f4f4f4; border: none; color: #000;"
                        onmouseover="this.style.backgroundColor='#383B46'; this.style.color='#FFF';"
                        onmouseout="this.style.backgroundColor='#f4f4f4'; this.style.color='#000';"
                        onclick="window.location.reload();">
                        <i class="fas fa-sync"></i>&ensp;&ensp;Refresh</button>
                </div>
            </div>
        </div>

        <div class="card">
            <!-- ==========HEADER CONTENT -->
            <table class="col-12">
                <tbody>
                    <tr>
                        <td class="header-width col-3 col-md-3" style="border-right: 1px solid #E0E0E0;">
                            <div class="header-div">
                                <div class="header-div-2">
                                    <img class="icon-h1" src="dist/img/car-dark.png"
                                        data-light-src="dist/img/car-light.png" data-dark-src="dist/img/car-dark.png">
                                </div>
                                <div class="header-div-3">
                                    <p class="header-title">Car Maker / Car Model</p>
                                    <p class="header-content">
                                        <?= $Carmodel ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="header-width col-3 col-md-3" style="border-right: 1px solid #E0E0E0;">
                            <div class="header-div">
                                <div class="header-div-2">
                                    <img class="icon-h2" src="dist/img/setting-dark.png"
                                        data-light-src="dist/img/setting-light.png"
                                        data-dark-src="dist/img/setting-dark.png">
                                </div>
                                <div class="header-div-3">
                                    <p class="header-title">Line No.</p>
                                    <p class="header-content">
                                        <?= $line_no ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="header-width col-3 col-md-3" style="border-right: 1px solid #E0E0E0;">
                            <div class="header-div">
                                <div class="header-div-2">
                                    <img class="icon-h3" src="dist/img/clock-dark.png"
                                        data-light-src="dist/img/clock-light.png"
                                        data-dark-src="dist/img/clock-dark.png">
                                </div>
                                <div class="header-div-3">
                                    <p class="header-title">Shift</p>
                                    <p class="header-content">
                                        <?= $shift ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="header-width col-3 col-md-3">
                            <div class="header-div">
                                <div class="header-div-2">
                                    <img class="icon-h4" src="dist/img/calendar-dark.png"
                                        data-light-src="dist/img/calendar-light.png"
                                        data-dark-src="dist/img/calendar-dark.png">
                                </div>
                                <div class="header-div-3">
                                    <p class="header-title">Date</p>
                                    <p class="header-content">
                                        <?= $server_date_only ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="plan-div">
            <!-- ==========PLAN, ACCOUNTING EFFICIENCY, AND HOURLY OUTPUT-->
            <div class="card plan-container">
                <!-- PLAN -->
                <table>
                    <input type="hidden" id="processing" value="1">
                    <thead>
                        <tr>

                            <td colspan="3" class="plan-title">Plan</td>
                        </tr>
                        <tr>
                            <td class="plan-sub-title">Target</td>
                            <td class="plan-sub-title">Actual</td>
                            <td class="plan-sub-title">Gap</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="plan-content plan_target_value blue-bg" id="plan_target"></td>
                            <td class="plan-content plan_actual_value blue-bg" id="plan_actual"></td>
                            <td class="plan-content plan_gap_value blue-bg" id="plan_gap"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card acc-eff-container">
                <!-- ACCOUNTING EFFICIENCY -->
                <table>
                    <thead>
                        <tr>
                            <td colspan="3" class="plan-title">Accounting Efficiency</td>
                        </tr>
                        <tr>
                            <td class="plan-sub-title">Target</td>
                            <td class="plan-sub-title">Actual</td>
                            <td class="plan-sub-title">Gap</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="plan-content yellow-bg" id="target_accounting_efficiency">
                                <?= $acc_eff; ?>%
                            </td>
                            <td class="plan-content yellow-bg" id="actual_accounting_efficiency"></td>
                            <td class="plan-content yellow-bg" id="gap_accounting_efficiency"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card hourly-container">
                <!-- HOURLY OUTPUT -->
                <table>
                    <thead>
                        <tr>
                            <td colspan="3" class="plan-title">Hourly Output</td>
                        </tr>
                        <tr>
                            <td class="plan-sub-title"
                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'>
                                <div class="pl-2 pr-2"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <span>Target</span>
                                    <img class="icon-2" src="dist/img/expand-dark.png"
                                        data-light-src="dist/img/expand-light.png"
                                        data-dark-src="dist/img/expand-dark.png">
                                </div>
                            </td>
                            <td class="plan-sub-title"
                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span>Actual</span>
                                    <img class="icon-2" src="dist/img/expand-dark.png"
                                        data-light-src="dist/img/expand-light.png"
                                        data-dark-src="dist/img/expand-dark.png">
                                </div>
                            </td>
                            <td class="plan-sub-title"
                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span>Gap</span>
                                    <img class="icon-2" src="dist/img/expand-dark.png"
                                        data-light-src="dist/img/expand-light.png"
                                        data-dark-src="dist/img/expand-dark.png">
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="plan-content green-bg" id="target_hourly_output"
                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'>
                            </td>
                            <td class="plan-content green-bg" id="actual_hourly_output"
                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'>
                            </td>
                            <td class="plan-content green-bg" id="gap_hourly_output"
                                onclick='window.open("viewer/hourly_output/hourly_output.php","_blank")'></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="yield-div">
            <!-- ========== YIELD/PPM, INSPECTION OUTPUT-->
            <div class="card yield-container">
                <!-- yield, ppm -->
                <table>
                    <thead>
                        <tr>
                            <td colspan="3" class="yield-title" style="border-right: 1px solid #E0E0E0;">Yield</td>
                            <td colspan="3" class="yield-title">PPM</td>
                        </tr>
                    </thead>
                </table>
                <table>
                    <tbody>
                        <tr>
                            <td class="grey-bg yield-content">
                                <?= $yield_target; ?>%
                            </td>
                            <td class="yield-sub-title">Target</td>
                            <td class="yield-content grey-bg">
                                <?= number_format($ppm_target); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="yield-content yellow-bg" id="actual_yield"></td>
                            <td class="yield-sub-title">Actual</td>
                            <td class="yield-content red-bg" id="actual_ppm"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card inspection-container">
                <!-- overall inspection, inspection details -->
                <div class="inspection-container-2">
                    <!-- overall inspection -->
                    <table>
                        <thead>
                            <tr>
                                <td class="inspection-title pt-1">Overall Inspection</td>
                            </tr>
                        </thead>
                    </table>
                    <table>
                        <tbody>
                            <tr>
                                <td class="inspection-sub-title"
                                    onclick='window.open("viewer/good_inspection_details/inspection_details.php","_blank")'>
                                    <div class="pl-4 pr-4"
                                        style="display: flex; justify-content: space-between; align-items: center;">
                                        <span>Good</span>
                                        <img class="icon-2" src="dist/img/expand-dark.png"
                                            data-light-src="dist/img/expand-light.png"
                                            data-dark-src="dist/img/expand-dark.png">
                                    </div>
                                </td>
                                <td class="inspection-sub-title"
                                    onclick='window.open("viewer/ng_inspection_details/inspection_details_ng.php","_blank")'>
                                    <div class="pl-4 pr-4"
                                        style="display: flex; justify-content: space-between; align-items: center;">
                                        <span>NG</span>
                                        <img class="icon-2" src="dist/img/expand-dark.png"
                                            data-light-src="dist/img/expand-light.png"
                                            data-dark-src="dist/img/expand-dark.png">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="inspection-content green-bg" id="insp_overall_g"></td>
                                <td class="inspection-content red-bg" id="insp_overall_ng"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="inspection-container-3 table-responsive m-0 p-0"
                    style="max-height: 215px; overflow-y: auto;">
                    <!-- inspection details -->
                    <table class="m-0 p-0 table-head-fixed text-nowrap">
                        <thead style="text-align: center; position: sticky; top: 0; z-index: 1; height: 55px">
                            <td class="inspection-sub-title-2">Good</td>
                            <td class="inspection-sub-title-2">Inspection</td>
                            <td class="inspection-sub-title-2">NG</td>
                        </thead>
                        <tbody id="inspection_process_list_copy">
                            <tr></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="manpower-div">
            <!-- ========== PD MANPOWER, QA MANPOWER, OTHER DETAILS -->
            <div class="card pd-container">
                <!-- pd manpower -->
                <table>
                    <thead>
                        <tr>
                            <td colspan="2" class="manpower-title"
                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'>
                                <div class="pl-2 pr-2"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <span>PD Manpower</span>
                                    <img class="icon-2" src="dist/img/expand-dark.png"
                                        data-light-src="dist/img/expand-light.png"
                                        data-dark-src="dist/img/expand-dark.png">
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="manpower-content">Plan:</td>
                            <td class="manpower-content-2 pl-5" id="total_pd_mp"></td>
                        </tr>
                        <tr>
                            <td class="manpower-content">Actual:</td>
                            <td class="manpower-content-2 pl-5" id="total_present_pd_mp"></td>
                        </tr>
                        <tr>
                            <td class="manpower-content">Absent:</td>
                            <td class="manpower-content-2 pl-5" id="total_absent_pd_mp"></td>
                        </tr>
                        <tr>
                            <td class="manpower-content">Support:</td>
                            <td class="manpower-content-2 pl-5" id="total_pd_mp_line_support_to"></td>
                        </tr>
                        <tr>
                            <td class="manpower-content">Absent Rate:</td>
                            <td class="manpower-content-2 pl-5" id="absent_ratio_pd_mp"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card qa-container">
                <!-- qa manpower -->
                <table>
                    <thead>
                        <tr>
                            <td colspan="2" class="manpower-title"
                                onclick='window.open("http://172.25.116.188:3000/emp_mgt/viewer/dashboard.php","_blank")'>
                                <div class="pl-2 pr-2"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <span>QA Manpower</span>
                                    <img class="icon-2" src="dist/img/expand-dark.png"
                                        data-light-src="dist/img/expand-light.png"
                                        data-dark-src="dist/img/expand-dark.png">
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="manpower-content">Plan:</td>
                            <td class="manpower-content-2 pl-5" id="total_qa_mp"></td>
                        </tr>
                        <tr>
                            <td class="manpower-content">Actual:</td>
                            <td class="manpower-content-2 pl-5" id="total_present_qa_mp"></td>
                        </tr>
                        <tr>
                            <td class="manpower-content">Absent:</td>
                            <td class="manpower-content-2 pl-5" id="total_absent_qa_mp"></td>
                        </tr>
                        <tr>
                            <td class="manpower-content">Support:</td>
                            <td class="manpower-content-2 pl-5" id="total_qa_mp_line_support_to"></td>
                        </tr>
                        <tr>
                            <td class="manpower-content">Absent Rate:</td>
                            <td class="manpower-content-2 pl-5" id="absent_ratio_qa_mp"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card other-container">
                <!-- other details -->
                <table>
                    <thead>
                        <tr>
                            <td colspan="2" class="manpower-title">
                                <div class="pl-2 pr-2"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <span>Other Details</span>
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="manpower-content">Starting Balance Delay:</td>
                            <td class="manpower-content-2 pl-5">
                                <?= $start_bal_delay; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="manpower-content">Conveyor Speed:</td>
                            <td class="manpower-content-2 pl-5" id="taktset"></td>
                        </tr>
                        <!-- <tr>
                            <td class="manpower-content">Takt Time:</td>
                            <td class="takt-value manpower-content-2 pl-5"></td>
                        </tr> -->
                        <tr>
                            <td class="manpower-content">Working Time Plan:</td>
                            <td class="manpower-content-2 pl-5">
                                <?= $work_time_plan; ?>
                            </td>
                        </tr>
                        <tr>
                            <!-- <td class="manpower-content">Working Time Actual:</td> -->
                            <td class="manpower-content"></td>
                            <td class="manpower-content-2 pl-5"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="process-design-div">
            <!-- ========== PROCESS DESIGN, HOURLY GRAPHS -->
            <div class="card process-container table-responsive m-0 p-0" style="max-height: 500px; overflow-y: auto;">
                <!-- process design -->
                <table class="m-0 p-0 table-head-fixed text-nowrap">
                    <thead style="position: sticky; top: 0; z-index: 1; height: 40px;">
                        <tr>
                            <td class="process-title" colspan="2">Process Design</td>
                            <td class="process-title">Actual</td>
                        </tr>
                    </thead>
                    <tbody id="process_design_data"></tbody>
                </table>
            </div>

            <div class="card graphs-container">
                <!-- andon count graph -->
                <div id="chart-container1">
                    <a target="_blank" href="../pcad/viewer/andon_details/andon_details.php">
                        <canvas id="andon_hourly_chart" height="70"></canvas>
                    </a>
                </div>

                <!-- good hourly count graph -->
                <div id="chart-container2">
                    <a target="_blank" href="../pcad/viewer/hourly_output/hourly_output.php">
                        <canvas id="hourly_output_summary_chart" height="70"></canvas>
                    </a>
                </div>

                <!-- ng hourly count graph -->
                <div id="chart-container3">
                    <a target="_blank" href="../pcad/viewer/ng_inspection_details/inspection_details_ng.php">
                        <canvas id="ng_summary_chart" height="70"></canvas>
                    </a>
                </div>

                <div class="row mx-1 my-1 row-btn">
                    <div class="col-12 my-auto">
                        <a target="_blank" href="../pcad/viewer/andon_details/andon_details.php">
                            <button class="btn btn-secondary ml-1 for-btn"
                                onmouseover="this.style.backgroundColor='#005BA3'; this.style.color='#FFF';"
                                onmouseout="this.style.backgroundColor='#f4f4f4'; this.style.color='#000';">View Hourly Andon Details
                            </button>
                        </a>
                        &ensp;&ensp;&ensp;
                        <a target="_blank" href="../pcad/viewer/hourly_output/hourly_output.php">
                            <button class="btn btn-secondary ml-1 for-btn"
                                onmouseover="this.style.backgroundColor='#10BA68'; this.style.color='#FFF';"
                                onmouseout="this.style.backgroundColor='#f4f4f4'; this.style.color='#000';">View Hourly Inspection Output Details
                            </button>
                        </a>
                        &ensp;&ensp;&ensp;
                        <a target="_blank" href="../pcad/viewer/ng_inspection_details/inspection_details_ng.php">
                            <button class="btn btn-secondary ml-1 for-btn"
                                onmouseover="this.style.backgroundColor='#E14747'; this.style.color='#FFF';"
                                onmouseout="this.style.backgroundColor='#f4f4f4'; this.style.color='#000';">View Hourly Defect Count Details</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- return to top -->
        <button id="back-to-top" type="button" class="return-to-top"><img class="nav-icon-top nav-icon"
                src="dist/img/up-arrow-dark.png" data-light-src="dist/img/up-arrow-light.png"
                data-dark-src="dist/img/up-arrow-dark.png"></button>
    </div>
</body>

<!-- jQuery -->
<script src="plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Chart JS -->
<script src="node_modules/chart.js/dist/chart.umd.js"></script>
<script src="plugins/chart.js/annotation/chartjs-plugin-annotation-1.0.2.js"></script>
<!--Moment JS -->
<script src="plugins/moment-js/moment.min.js"></script>
<script src="plugins/moment-js/moment-duration-format.min.js"></script>

<script>
    let chartAndonHourly;
    let chartHourlyOutput;
    let chartNGhourly;

    // Set LocalStorage for these variables
    localStorage.setItem("andon_line", $("#andon_line").val());
    localStorage.setItem("shift", $("#shift").val());

    $(document).ready(function () {
        // Call these functions initially to load the data from PCAD and other Systems
        // 1000 milliseconds = 1 second
        get_accounting_efficiency();
        get_hourly_output();
        get_yield();
        get_ppm();

        // INSPECTION
        get_inspection_list_copy();
        get_overall_inspection();
        count_emp();

        // =====hourly graphs=====
        andon_hourly_graph();
        get_hourly_output_chart();
        ng_graph();
        get_process_design();
    });

    // return to top button
    (function ($) {
        /*--Scroll Back to Top Button Show--*/
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });

        //Click event scroll to top button jquery
        $('#back-to-top').click(function () {
            $('html, body').animate({ scrollTop: 0 }, 600);
            return false;
        });
    })(jQuery);

    // toggle mode
    function toggle_light_mode() {
        var app = document.getElementsByTagName("BODY")[0];
        if (localStorage.lightMode == "dark") {
            localStorage.lightMode = "light";
            app.setAttribute("light-mode", "light");

            updateChartColors('light');
        } else {
            localStorage.lightMode = "dark";
            app.setAttribute("light-mode", "dark");

            updateChartColors('dark');
        }
    }

    function toggleDarkMode(isDarkMode) {
        var buttons = document.querySelectorAll(".for-btn");
        buttons.forEach(function (button) {
            if (isDarkMode) {
                // Dark mode styles
                button.style.backgroundColor = '#3D414F';
                button.style.color = '#fff';
            } else {
                // Light mode styles
                button.style.backgroundColor = '#f4f4f4';
                button.style.color = '#000';
            }
        });
    }

    // for chart dark mode
    function updateChartColors(mode) {
        var chart1 = document.getElementById('andon_hourly_chart');
        if (chart1) {
            var chartInstance1 = Chart.getChart(chart1);
            if (chartInstance1) {
                if (mode === 'dark') {
                    // Set dark mode colors for chart elements
                    chartInstance1.options.scales.y.ticks.color = '#DDD';
                    chartInstance1.options.scales.y.grid.color = '#555';
                    chartInstance1.options.scales.x.ticks.color = '#DDD';
                    chartInstance1.options.scales.x.grid.color = '#555';
                    chartInstance1.options.plugins.title.color = '#FFF';
                    chartInstance1.options.scales.y.title.color = '#FFF';
                } else {
                    // Set light mode colors for chart elements
                    chartInstance1.options.scales.y.ticks.color = '#000';
                    chartInstance1.options.scales.y.grid.color = '#ddd';
                    chartInstance1.options.scales.x.ticks.color = '#000';
                    chartInstance1.options.scales.x.grid.color = '#ddd';
                    chartInstance1.options.plugins.title.color = '#000';
                    chartInstance1.options.scales.y.title.color = '#000';
                }
                chartInstance1.update();
            }
        }

        var chart2 = document.getElementById('hourly_output_summary_chart');
        if (chart2) {
            var chartInstance2 = Chart.getChart(chart2);
            if (chartInstance2) {
                if (mode === 'dark') {
                    // Set dark mode colors for chart elements
                    chartInstance2.options.scales.y.ticks.color = '#DDD';
                    chartInstance2.options.scales.y.grid.color = '#555';
                    chartInstance2.options.scales.x.ticks.color = '#DDD';
                    chartInstance2.options.scales.x.grid.color = '#555';
                    chartInstance2.options.plugins.title.color = '#FFF';
                    chartInstance2.options.scales.y.title.color = '#FFF';
                } else {
                    // Set light mode colors for chart elements
                    chartInstance2.options.scales.y.ticks.color = '#000';
                    chartInstance2.options.scales.y.grid.color = '#ddd';
                    chartInstance2.options.scales.x.ticks.color = '#000';
                    chartInstance2.options.scales.x.grid.color = '#ddd';
                    chartInstance2.options.plugins.title.color = '#000';
                    chartInstance2.options.scales.y.title.color = '#000';
                }
                chartInstance2.update();
            }
        }

        var chart3 = document.getElementById('ng_summary_chart');
        if (chart3) {
            var chartInstance3 = Chart.getChart(chart3);
            if (chartInstance3) {
                if (mode === 'dark') {
                    // Set dark mode colors for chart elements
                    chartInstance3.options.scales.y.ticks.color = '#DDD';
                    chartInstance3.options.scales.y.grid.color = '#555';
                    chartInstance3.options.scales.x.ticks.color = '#DDD';
                    chartInstance3.options.scales.x.grid.color = '#555';
                    chartInstance3.options.plugins.title.color = '#FFF';
                    chartInstance3.options.scales.y.title.color = '#FFF';
                } else {
                    // Set light mode colors for chart elements
                    chartInstance3.options.scales.y.ticks.color = '#000';
                    chartInstance3.options.scales.y.grid.color = '#ddd';
                    chartInstance3.options.scales.x.ticks.color = '#000';
                    chartInstance3.options.scales.x.grid.color = '#ddd';
                    chartInstance3.options.plugins.title.color = '#000';
                    chartInstance3.options.scales.y.title.color = '#000';
                }
                chartInstance3.update();
            }
        }
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
include 'dashboard/plugins/js/andon.php';
include 'dashboard/plugins/js/emp_mgt.php';
include 'dashboard/plugins/js/hourly_graph.php';
include 'dashboard/plugins/js/inspection_output.php';
include 'dashboard/plugins/js/pcad.php';
include 'dashboard/plugins/js/pcs.php';
?>

</html>
<!-- /.navbar -->