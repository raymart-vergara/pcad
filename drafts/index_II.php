<?php
include 'process/pcs/index.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PCAD - ST</title>

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



</head>

<body>
    <input type="hidden" id="shift" value="<?= $shift ?>">
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

    <div class="container-fluid">
        <div class="flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/logo.webp" alt="logo" height="60" width="60"><span
                class="h5">PCAD<span>
        </div>
    </div>
    <div class="container-fluid">
        <h1 class='text-center'>Production Conveyor Analysis Dashboard</h1>
        <div class="col-12">
            <div class="card card-primary card-outline shadow">
                <div class="card-body">
                    <div class="row">
                        <p class="card-text col-6">
                            <label for="" id="line_no_label">Line No.: <span>
                                    <?= $line_no ?>
                                </span></label>
                            <br>
                            <label for="" id="shift_label">Shift: <span>
                                    <?= $shift ?>
                                </span></label>
                        </p>
                        <p class="card-text col-6">

                            <label for="" id="server_date_only_label">Date: <span>
                                    <?= $server_date_only ?>
                                </span></label>

                            <br>
                            <label for="" id="shift_group_label">Group: <span>
                                    <?= $group ?>
                                </span></label>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- ================== LEFT SIDE========================= -->
            <div class="col-6">
                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Target</th>
                                        <th scope="col">Actual</th>
                                        <th scope="col">Gap</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        if ($processing) {
                                            ?>
                                            <input type="hidden" id="processing" value="1">
                                            <th scope="row">Plan</th>
                                            <td class="plan_target_value" id="plan_target"></td>
                                            <td class="plan_actual_value" id="plan_actual"></td>
                                            <td class="plan_gap_value" id="plan_gap"></td>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="hidden" id="processing" value="0">
                                            <div class="modal fade show" id="plannotset" tabindex="-1"
                                                aria-labelledby="plannotsetLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content" style="background-color: white;">
                                                        <div class="modal-body">
                                                            <h5 class="modal-title display-4 text-center"
                                                                id="plannotsetLabel">Plan not set</h5>
                                                            <br>
                                                            <br>
                                                            <div class="row justify-content-center text-center">
                                                                <div class="col-3">
                                                                    <a href="pcs_page/setting.php"
                                                                        class="btn btn-lg btn-success text-white btn-close"
                                                                        id="setplanBtn">SET PLAN <b>[ 4 ]</b></a>
                                                                </div>
                                                                <div class="col-3">
                                                                    <a href="pcs_page/index.php"
                                                                        class="btn btn-lg btn-secondary text-white btn-close">MAIN
                                                                        MENU <b>[ 0 ]</b></a>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <th scope="row">Accounting Efficiency</th>
                                        <td></td>
                                        <td id="actual_accounting_efficiency"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Hourly Output</th>
                                        <td></td>
                                        <td id="actual_hourly_output"></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- ========================================================= -->
                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body">
                            <h5>Starting Balance Delay <span class="mx-5">1234</span></h5>
                            <div class="row">
                                <div class="col-4 table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">PD MP</th>
                                                <td id="total_pd_mp"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Actual</th>
                                                <td id="total_present_pd_mp"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-4">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">Plan</th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Absent</th>
                                                <td id="total_absent_pd_mp"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-4">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">Ratio</th>
                                                <td id="absent_ratio_pd_mp"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Suppport</th>
                                                <td id="total_pd_mp_line_support_to"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">QA MP</th>
                                                <td id="total_qa_mp"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Actual</th>
                                                <td id="total_present_qa_mp"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-4">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">Plan</th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Absent</th>
                                                <td id="total_absent_qa_mp"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-4">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">Ratio</th>
                                                <td id="absent_ratio_qa_mp"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Suppport</th>
                                                <td id="total_qa_mp_line_support_to"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Conveyor Speed</th>
                                        <td id="taktset"></td>
                                    </tr>
                                    <tr>
                                        <th class="takt-label" scope="row">Takt Time</th>
                                        <td class="takt-value"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Working Time Plan</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Working Time Actual</th>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Target</th>
                                        <th scope="col">Actual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Yield</th>
                                        <td></td>
                                        <td id="actual_yield"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">PPM</th>
                                        <td></td>
                                        <td id="actual_ppm"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ==================END OF LEFT SIDE========================= -->
            <!-- ==================START OF RIGHT SIDE========================= -->
            <div class="col-6">

                <!-- ========================================================= -->
                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body">
                            <h2 class="text-center">Inspection Output</h2>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Inspection Process</th>
                                        <th scope="col">GOOD</th>
                                        <th scope="col">NO GOOD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Dimension</th>
                                        <td>100</td>
                                        <td>10</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ECT</th>
                                        <td>200</td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Clamp Checking</th>
                                        <td>200</td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Appearance</th>
                                        <td>200</td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">QA</th>
                                        <td>200</td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Overall</th>
                                        <td>900</td>
                                        <td>90</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- =========================================== -->
                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body"">

                            <h3>DT / DELAY / ANDON</h3>

                            <!-- /.navbar -->
                            <div class=" container-lg my-4">
                            <div class="card rounded shadow">
                                <div id="chart-container">
                                    <canvas id="hourly_chart"></canvas>
                                </div>
                            </div>
                            <a target="_blank"
                                href="http://172.25.114.167:3000/andon_system/admin/page/andonProdLogs.php"
                                class="card-link">Andon Details</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Buttons (Progress Counter TV) -->
    <div class="row">
        <div class="col-4">
            <div>
                <button type="button" class="btn btn-danger btn-block btn-pause">PAUSE <b>[ 1 ]</b></button>
            </div>
            <div>
                <button type="button" class="btn btn-info btn-block btn-resume d-none">RESUME <b>[ 3 ]</b></button>
            </div>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-success btn-block btn-target ">END PROCESS <b>[ 2 ]</b></button>
        </div>
        <div class="col-4">
            <a type="button" class="btn btn-secondary btn-block btn-menu" href="pcs_page/index.php"> MAIN MENU <b>[ 0
                    ]</b></a>
        </div>
    </div>


    <div class="col-3">
        <a href="pcs_page/setting.php" class="btn  btn-primary btn-set d-none" id="setnewTargetBtn">SET NEW TARGET
            <b>[ 5 ]</b></a>
    </div>
    </div>
    <footer class="main-footer" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <strong>Copyright © 2024. Developed by FALP IT System Group</strong>
            All rights reserved.
        </div>

        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>

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

<script type="text/javascript">
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

        // Call count_emp initially to load the data from employee management system
        count_emp();
        // Set interval to refresh data every 15 seconds
        setInterval(count_emp, 15000); // 15000 milliseconds = 15 seconds


        // Call andon_d_sum initially to load the chart
        andon_d_sum();
        // Set interval to refresh data every 10 seconds
        setInterval(andon_d_sum, 10000); // 10000 milliseconds = 10 seconds
    });
</script>

<?php
include 'javascript/pcs.php';
include 'javascript/pcad.php';
include 'javascript/emp_mgt.php';
include 'javascript/andon.php';
?>

</html>
<!-- /.navbar -->