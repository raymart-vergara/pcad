<!DOCTYPE html>
<html>

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inspection Output</title>

        <link rel="icon" href="dist/img/logo.ico" type="image/x-icon" />
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="../dist/css/font.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="../plugins/ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/adminlte.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Sweet Alert -->
        <link rel="stylesheet" href="../plugins/sweetalert2/dist/sweetalert2.min.css">

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
                        /* padding: 2px; */
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

                /* .value-size {
                        font-size: 40px;
                        font-weight: lighter;
                } */
        </style>
</head>

<body>
        <div class="container-fluid">
                <div class="row mt-5">
                        <div class="col-6">
                                <!-- overall inspection -->
                                <table>
                                        <tr>
                                                <th colspan="4" class="text-center">OVERALL
                                                        INSPECTION
                                                </th>
                                        </tr>
                                        <tr>
                                                <th class="col-md-2 text-center">GOOD</th>
                                                <td id="insp_overall_g" class="col-md-4 text-center value-size"> </td>
                                                <td id="insp_overall_ng" class="col-md-4 text-center value-size"> </td>
                                                <th class="col-md-2 text-center">NG</th>
                                        </tr>
                                </table>
                        </div>
                        <div class="col-6">
                                <table class="m-0 p-0">
                                        <tr>
                                                <th class="col-md-4 text-center">GOOD</th>
                                                <th class="col-md-4 text-center">INSPECTION</th>
                                                <th class="col-md-4 text-center">NG</th>
                                        </tr>
                                        <tr>
                                                <td id="dimension_p" class="col-md-4 text-center"></td>
                                                <th class="th-normal col-md-4 text-center">Dimension</th>
                                                <td id="dimension_p_ng" class="col-md-4 text-center"></td>
                                        </tr>
                                        <tr>
                                                <td id="ect_p" class="col-md-4 text-center"></td>
                                                <th class="th-normal col-md-4 text-center">ECT</th>
                                                <td id="ect_p_ng" class="col-md-4 text-center"></td>
                                        </tr>
                                        <tr>
                                                <td id="clamp_checking_p" class="col-md-4 text-center"></td>
                                                <th class="th-normal col-md-4 text-center">Clamp Checking</th>
                                                <td id="clamp_checking_p_ng" class="col-md-4 text-center"></td>
                                        </tr>
                                        <tr>
                                                <td id="appearance_p" class="col-md-4 text-center"></td>
                                                <th class="th-normal col-md-4 text-center">Appearance</th>
                                                <td id="appearance_p_ng" class="col-md-4 text-center"></td>
                                        </tr>
                                        <tr>
                                                <td id="assurance_p" class="col-md-4 text-center"></td>
                                                <th class="th-normal col-md-4 text-center">Assurance</th>
                                                <td id="assurance_p_ng" class="col-md-4 text-center"></td>
                                        </tr>
                                </table>
                        </div>
                </div>
        </div>
</body>

<!-- jQuery -->
<script src="../plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Chart JS -->
<script src="../node_modules/chart.js/dist/chart.umd.js"></script>
<!--Moment JS -->
<script src="../plugins/moment-js/moment.min.js"></script>
<script src="../plugins/moment-js/moment-duration-format.min.js"></script>

<script>
        $(document).ready(function () {
                // Call andon_d_sum initially to load the chart
                get_overall_inspection();
                // Set interval to refresh data every 10 seconds
                setInterval(get_overall_inspection, 10000); // 10000 milliseconds = 10 seconds
        });
</script>


<?php
include 'plugins/js/inspection_output_script.php'; 
?>

</html>