<?php
include 'process/pcs/index.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>PCAD | TV Dashboard</title>

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

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.css">

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
         background: #2F323C;
         border-radius: 10px;
      }

      /* Handle on hover */
      ::-webkit-scrollbar-thumb:hover {
         background: #332D2D;
      }

      @font-face {
         font-family: 'Norwester';
         src: url('dist/font/norwester/norwester.otf') format('opentype');
      }

      @font-face {
         font-family: 'Montserrat';
         src: url('dist/font/montserrat/Montserrat-Bold.ttf') format('truetype');
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

      body,
      html {
         /* background: #03045e; */
         color: #fff;
         font-family: 'Montserrat', sans-serif;
         height: 100%;
         margin: 0;
         overflow-x: hidden;
      }

      .tv-background {
         background-image: url('dist/img/tv-background.png');
         /* height: 100%; */
         min-height: 100vh;
         background-position: center;
         background-repeat: no-repeat;
         background-size: cover;
         overflow-x: hidden;

         /* position: relative;
            z-index: 1; */
      }

      .table-container {
         position: relative;
         z-index: 2;
      }

      .table-container table {
         position: relative;
         border-collapse: separate;
         border-spacing: 10px;
         border: none;
         width: 100%;
         z-index: 1;
      }

      .carousel {
         position: relative;
         z-index: 2;
         margin-left: 20px;
         margin-right: 20px;
      }

      tr:hover {
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
         font-size: 90px;
         font-family: 'Norwester', sans-serif;
      }

      .value-size2 {
         font-size: 100px;
         font-family: 'Norwester', sans-serif;
         /* text-align: center; */
      }

      .value-size {
         font-size: 30px;
         font-family: 'Norwester', sans-serif;
      }

      /* for inspection output scroll */
      table.scrolldown {
         width: 100%;
         border-collapse: collapse;
         border-spacing: 0;
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
         font-size: 45px;
         font-family: 'Montserrat', sans-serif;
      }

      .equal-plan-acct-hr {
         width: 25%;
      }

      .equal-py {
         width: 50%;
         font-size: 35px;
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
      }

      .table th,
      .table td {
         border: none;
      }

      .font-plan {
         font-size: 50px;
         width: 33.33%;
         padding-left: 10px;
      }

      .font-plan-sub {
         font-size: 60px;
      }

      .font-others {
         font-size: 25px;
         padding-left: 10px;
      }

      .font-others-value {
         font-size: 35px;
         font-family: 'Norwester', sans-serif;
         padding-left: 20px;
      }

      .table-bg {
         background-color: rgba(0, 0, 0, 0.50);
         border-radius: 3px;
      }
   </style>
</head>

<body class="tv-background">
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

   <!-- Actual (Needed on updateTakt function) -->
   <input type="hidden" id="yield_actual" name="yield_actual" value="">
   <input type="hidden" id="ppm_actual" name="ppm_actual" value="">
   <input type="hidden" id="acc_eff_actual" name="acc_eff_actual" value="">

   <div class="container-fluid">
      <?php
      if ($processing) {
         ?>

         <?php

      } else {
         ?>
         <input type="hidden" id="processing" value="0">
         <div class="modal fade darkest-modal" id="plannotset" tabindex="-1" aria-labelledby="plannotsetLabel"
            aria-hidden="true" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static"
            data-keyboard="false">
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

      <div id="carouselExampleIndicators" class="carousel slide mx-3" data-ride="carousel">
         <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
            </li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="7"></li>
         </ol>
         <div class="carousel-inner">
            <div class="carousel-item active" style="height: 650px; margin-top: 10px;">
               <table class="table table-container">
                  <tbody>
                     <tr>
                        <td scope="col" class="equal-width p-3 table-bg" id="carmodel_label"
                           style="vertical-align: middle;">
                           Car Maker / Model:
                           <?= $Carmodel ?> <br>
                           Line:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;
                           <?= $line_no ?>
                        </td>
                        <td scope="col" class="equal-width p-3 table-bg" id="server_date_only_label"
                           style="vertical-align: middle;">Date:
                           &emsp;
                           <?= $server_date_only ?> <br>
                           Shift:&emsp;&ensp;
                           <?= $shift ?>
                        </td>
                     </tr>
                  </tbody>
               </table>

               <table class="table text-center m-0 p-4 table-bg" style="border-bottom: 1px solid #E6E6E6">
                  <thead>
                     <tr style="height: 90px;">
                        <td colspan="3" class="equal-py"
                           style="vertical-align: middle; border-right: 1px solid #E6E6E6;">YIELD</td>
                        <td colspan="3" class="equal-py" style="vertical-align: middle;">PPM</td>
                     </tr>
                  </thead>
               </table>
               <table class="table text-center m-0 p-4 table-bg">
                  <tbody style="height: 400px;">
                     <tr style="border-bottom: 1px solid #E6E6E6">
                        <td scope="col" class="value-size1">
                           <?= $yield_target; ?>%
                        </td>
                        <td scope="col" style="vertical-align: middle; font-size: 40px;">
                           TARGET</td>
                        <td scope="col" class="value-size1">
                           <?= number_format($ppm_target); ?>
                        </td>
                     </tr>
                     <tr>
                        <td scope="col" class="value-size1" id="actual_yield" style="background: #FFD445; color: #000;">
                        </td>
                        <td scope="col" style="vertical-align: middle; font-size: 40px;">
                           ACTUAL</td>
                        <td scope="col" class="value-size1" id="actual_ppm" style="background: #FD5A46; color: #000;">
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="carousel-item" style="height: 650px; margin-top: 10px;">
               <table class="table-bg" style="width: 100%;">
                  <tbody class="text-center">
                     <tr style="height: 60px; border-bottom: 1px solid #E6E6E6">
                        <td scope="col"></td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Target
                        </td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Actual
                        </td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Gap
                        </td>
                     </tr>
                  </tbody>
                  <tbody class="text-center">
                     <tr style="border-bottom: 1px solid #E6E6E6">
                        <input type="hidden" id="processing" value="1">
                        <td scope="col" class="font-plan equal-plan-acct-hr">
                           Plan</td>
                        <td scope="col" id="plan_target" class="plan_target_value value-size2 equal-plan-acct-hr"
                           style="background: #569BE2; color: #000;">
                        </td>
                        <td scope="col" id="plan_actual" class="plan_actual_value value-size2 equal-plan-acct-hr"
                           style="background: #569BE2; color: #000;">
                        </td>
                        <td scope="col" id="plan_gap" class="plan_gap_value value-size2 equal-plan-acct-hr">
                        </td>
                     </tr>
                     <tr style="border-bottom: 1px solid #E6E6E6">
                        <td scope="col" class="font-plan equal-plan-acct-hr">
                           Accounting Efficiency</td>
                        <td scope="col" id="target_accounting_efficiency" class="value-size2 equal-plan-acct-hr"
                           style="background: #FFD445; color: #000;">
                           <?= $acc_eff; ?>%
                        </td>
                        <td scope="col" id="actual_accounting_efficiency" class="value-size2 equal-plan-acct-hr"
                           style="background: #FFD445; color: #000;"></td>
                        <td scope="col" id="gap_accounting_efficiency" class="value-size2 equal-plan-acct-hr"
                           style="background: #FFD445; color: #000;"></td>
                     </tr>
                     <tr style="border-bottom: 1px solid #E6E6E6">
                        <td scope="col" class="font-plan equal-plan-acct-hr">
                           Hourly Output</td>
                        <td scope="col" id="target_hourly_output" class="value-size2 equal-plan-acct-hr"
                           style="background: #50A363; color: #000;"></td>
                        <td scope="col" id="actual_hourly_output" class="value-size2 equal-plan-acct-hr"
                           style="background: #50A363; color: #000;"></td>
                        <td scope="col" id="gap_hourly_output" class="value-size2 equal-plan-acct-hr"></td>
                     </tr>
                  </tbody>
               </table>
            </div>

            <div class="carousel-item" style="height: 650px; margin-top: 10px;">
               <table class="table-bg" style="width: 100%;">
                  <tbody class="text-center">
                     <tr style="height: 60px; border-bottom: 1px solid #E6E6E6">
                        <td scope="col"></td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Target
                        </td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Actual
                        </td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Gap
                        </td>
                     </tr>
                  </tbody>
                  <tbody class="text-center">
                     <tr style="border-bottom: 1px solid #E6E6E6">
                        <input type="hidden" id="processing" value="1">
                        <td scope="col" class="font-plan equal-plan-acct-hr">
                           Plan</td>
                        <td scope="col" id="plan_target" class="plan_target_value value-size2 equal-plan-acct-hr"
                           style="background: #569BE2; color: #000;">
                        </td>
                        <td scope="col" id="plan_actual" class="plan_actual_value value-size2 equal-plan-acct-hr"
                           style="background: #569BE2; color: #000;">
                        </td>
                        <td scope="col" id="plan_gap" class="plan_gap_value value-size2 equal-plan-acct-hr">
                        </td>
                     </tr>
                  </tbody>
               </table>

               <table class="table-bg text-center mb-2 mt-3" style="width: 100%">
                  <thead>
                     <tr>
                        <td colspan="4"
                           style="vertical-align: middle; border-bottom: 1px solid #E6E6E6; font-size: 30px;">
                           OVERALL INSPECTION
                        </td>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <th scope="col" class="equal-insp th-normal" style="font-size: 30px;">GOOD
                        </th>
                        <td scope="col" id="insp_overall_g" class=""
                           style="background: #50A363; color: #000; font-size: 60px;">
                        </td>
                        <td scope="col" id="insp_overall_ng" class=""
                           style="background: #FD5A46; color: #000; font-size: 60px;">
                        </td>
                        <th scope="col" class="equal-insp th-normal" style="font-size: 30px;">NG
                        </th>
                     </tr>
                  </tbody>
               </table>

               <div class="table-responsive m-0 p-0" style="max-height: 215px; overflow-y: auto;">
                  <table class="table-bg m-0 p-0 table-head-fixed text-nowrap" style="width: 100%;">
                     <thead style="text-align: center; position: sticky; top: 0; z-index: 1;">
                        <tr style="border-bottom: 1px solid #E6E6E6;">
                           <td class="equal-insp-info" style="font-size: 30px;">GOOD</td>
                           <td class="equal-insp-info" style="font-size: 30px;">INSPECTION</td>
                           <td class="equal-insp-info" style="font-size: 30px;">NG</td>
                        </tr>
                     </thead>
                     <tbody class="mb-0" id="inspection_process_list"></tbody>
                  </table>
               </div>
            </div>

            <div class="carousel-item" style="height: 650px; margin-top: 10px;">
               <table class="table-bg" style="width: 100%;">
                  <tbody class="text-center">
                     <tr style="height: 60px; border-bottom: 1px solid #E6E6E6">
                        <td scope="col"></td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Target
                        </td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Actual
                        </td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Gap
                        </td>
                     </tr>
                  </tbody>
                  <tbody class="text-center">
                     <tr style="border-bottom: 1px solid #E6E6E6">
                        <input type="hidden" id="processing" value="1">
                        <td scope="col" class="font-plan equal-plan-acct-hr">
                           Plan</td>
                        <td scope="col" id="plan_target" class="plan_target_value value-size2 equal-plan-acct-hr"
                           style="background: #569BE2; color: #000;">
                        </td>
                        <td scope="col" id="plan_actual" class="plan_actual_value value-size2 equal-plan-acct-hr"
                           style="background: #569BE2; color: #000;">
                        </td>
                        <td scope="col" id="plan_gap" class="plan_gap_value value-size2 equal-plan-acct-hr">
                        </td>
                     </tr>
                  </tbody>
               </table>

               <div class="row mt-3">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="card">
                        <!-- <canvas id="hourly_chart" height="55"></canvas> -->
                        <canvas id="hourly_chart" height="90"></canvas>
                     </div>
                  </div>
               </div>
            </div>

            <div class="carousel-item" style="height: 650px; margin-top: 10px;">
               <table class="table-bg" style="width: 100%;">
                  <tbody class="text-center">
                     <tr style="height: 60px; border-bottom: 1px solid #E6E6E6">
                        <td scope="col"></td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Target
                        </td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Actual
                        </td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Gap
                        </td>
                     </tr>
                  </tbody>
                  <tbody class="text-center">
                     <tr style="border-bottom: 1px solid #E6E6E6">
                        <input type="hidden" id="processing" value="1">
                        <td scope="col" class="font-plan equal-plan-acct-hr">
                           Plan</td>
                        <td scope="col" id="plan_target" class="plan_target_value value-size2 equal-plan-acct-hr"
                           style="background: #569BE2; color: #000;">
                        </td>
                        <td scope="col" id="plan_actual" class="plan_actual_value value-size2 equal-plan-acct-hr"
                           style="background: #569BE2; color: #000;">
                        </td>
                        <td scope="col" id="plan_gap" class="plan_gap_value value-size2 equal-plan-acct-hr">
                        </td>
                     </tr>
                  </tbody>
               </table>

               <div class="row mt-3">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="card">
                        <!-- <canvas id="andon_hourly_chart" height="55"></canvas> -->
                        <canvas id="andon_hourly_chart" height="90"></canvas>
                     </div>
                  </div>
               </div>
            </div>

            <div class="carousel-item" style="height: 650px; margin-top: 10px;">
               <table class="table-bg" style="width: 100%;">
                  <tbody class="text-center">
                     <tr style="height: 60px; border-bottom: 1px solid #E6E6E6">
                        <td scope="col"></td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Target
                        </td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Actual
                        </td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Gap
                        </td>
                     </tr>
                  </tbody>
                  <tbody class="text-center">
                     <tr style="border-bottom: 1px solid #E6E6E6">
                        <input type="hidden" id="processing" value="1">
                        <td scope="col" class="font-plan equal-plan-acct-hr">
                           Plan</td>
                        <td scope="col" id="plan_target" class="plan_target_value value-size2 equal-plan-acct-hr"
                           style="background: #569BE2; color: #000;">
                        </td>
                        <td scope="col" id="plan_actual" class="plan_actual_value value-size2 equal-plan-acct-hr"
                           style="background: #569BE2; color: #000;">
                        </td>
                        <td scope="col" id="plan_gap" class="plan_gap_value value-size2 equal-plan-acct-hr">
                        </td>
                     </tr>
                  </tbody>
               </table>

               <div class="row mt-3">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="card">
                        <!-- <canvas id="hourly_output_summary_chart" height="55"></canvas> -->
                        <canvas id="hourly_output_summary_chart" height="90"></canvas>
                     </div>
                  </div>
               </div>
            </div>

            <div class="carousel-item" style="height: 650px; margin-top: 10px;">
               <table class="table-bg" style="width: 100%;">
                  <tbody class="text-center">
                     <tr style="height: 60px; border-bottom: 1px solid #E6E6E6">
                        <td scope="col"></td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Target
                        </td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Actual
                        </td>
                        <td scope="col" class="equal-plan-acct-hr font-plan-sub">Gap
                        </td>
                     </tr>
                  </tbody>
                  <tbody class="text-center">
                     <tr style="border-bottom: 1px solid #E6E6E6">
                        <input type="hidden" id="processing" value="1">
                        <td scope="col" class="font-plan equal-plan-acct-hr">
                           Plan</td>
                        <td scope="col" id="plan_target" class="plan_target_value value-size2 equal-plan-acct-hr"
                           style="background: #569BE2; color: #000;">
                        </td>
                        <td scope="col" id="plan_actual" class="plan_actual_value value-size2 equal-plan-acct-hr"
                           style="background: #569BE2; color: #000;">
                        </td>
                        <td scope="col" id="plan_gap" class="plan_gap_value value-size2 equal-plan-acct-hr">
                        </td>
                     </tr>
                  </tbody>
               </table>

               <div class="row mt-3">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="card">
                        <!-- <canvas id="ng_summary_chart" height="55""></canvas> -->
                        <canvas id="ng_summary_chart" height="90""></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" carousel-item" style="height: 650px; margin-top: 10px;">
                           <table class="table-bg" style="width: 100%;">
                              <tbody class="text-center">
                                 <tr style="height: 60px; border-bottom: 1px solid #E6E6E6">
                                    <td scope="col"></td>
                                    <td scope="col" class="equal-plan-acct-hr font-plan-sub">Target
                                    </td>
                                    <td scope="col" class="equal-plan-acct-hr font-plan-sub">Actual
                                    </td>
                                    <td scope="col" class="equal-plan-acct-hr font-plan-sub">Gap
                                    </td>
                                 </tr>
                              </tbody>
                              <tbody class="text-center">
                                 <tr style="border-bottom: 1px solid #E6E6E6">
                                    <input type="hidden" id="processing" value="1">
                                    <td scope="col" class="font-plan equal-plan-acct-hr">
                                       Plan</td>
                                    <td scope="col" id="plan_target"
                                       class="plan_target_value value-size2 equal-plan-acct-hr"
                                       style="background: #569BE2; color: #000;">
                                    </td>
                                    <td scope="col" id="plan_actual"
                                       class="plan_actual_value value-size2 equal-plan-acct-hr"
                                       style="background: #569BE2; color: #000;">
                                    </td>
                                    <td scope="col" id="plan_gap" class="plan_gap_value value-size2 equal-plan-acct-hr">
                                    </td>
                                 </tr>
                              </tbody>
                           </table>

                           <table class="table-bg mt-3" style="width: 100%;">
                              <thead style="border-bottom: 1px solid #E6E6E6;">
                                 <tr class="text-center">
                                    <td colspan="2" class="equal-details" style="font-size: 35px;">PD
                                       MANPOWER</td>
                                    <td colspan="2" class="equal-details" style="font-size: 35px;">QA
                                       MANPOWER</th>
                                    <td colspan="2" class="equal-details" style="font-size: 35px;">OTHER
                                       DETAILS</td>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <th class="th-normal equal-sub-details text-left font-others">
                                       Plan:
                                    </th>
                                    <td id="total_pd_mp" class="equal-sub-details text-left font-others-value"
                                       style="background: #ABD2FA; border-right: 1px solid #E6E6E6; color: #000;">
                                    </td>
                                    <th class="th-normal equal-sub-details text-left font-others">
                                       Plan:
                                    </th>
                                    <td id="total_qa_mp" class="equal-sub-details text-left font-others-value"
                                       style="background: #ABD2FA; border-right: 1px solid #E6E6E6; color: #000;">
                                    </td>
                                    <th class="th-normal equal-sub-details text-left font-others">
                                       Starting Balance Delay:</th>
                                    <td class="equal-sub-details text-left font-others-value"
                                       style="background: #CFCFCF; color: #000;">
                                       <?= $start_bal_delay; ?>
                                    </td>
                                 </tr>
                                 <tr>
                                    <th class="th-normal text-left font-others">Actual:</th>
                                    <td id="total_present_pd_mp" class="text-left font-others-value"
                                       style="background: #ABD2FA; border-right: 1px solid #E6E6E6; color: #000;">
                                    </td>
                                    <th class="th-normal text-left font-others">Actual:</th>
                                    <td id="total_present_qa_mp" class="text-left font-others-value"
                                       style="background: #ABD2FA; border-right: 1px solid #E6E6E6; color: #000;">
                                    </td>
                                    <th class="th-normal text-left font-others">Conveyor
                                       Speed:</th>
                                    <td id="taktset" class="text-left font-others-value"
                                       style="background: #CFCFCF; color: #000;">
                                    </td>
                                 </tr>
                                 <tr>
                                    <th class="th-normal text-left font-others">Absent:</th>
                                    <td id="total_absent_pd_mp" class="text-left font-others-value"
                                       style="background: #ABD2FA; border-right: 1px solid #E6E6E6; color: #000;">
                                    </td>
                                    <th class="th-normal text-left font-others">Absent:</th>
                                    <td id="total_absent_qa_mp" class="text-left font-others-value"
                                       style="background: #ABD2FA; border-right: 1px solid #E6E6E6; color: #000;">
                                    </td>
                                    <th class="th-normal takt-label text-left font-others">
                                       Takt Time:</th>
                                    <td class="takt-value text-left font-others-value"
                                       style="background: #CFCFCF; color: #000;"></td>
                                 </tr>
                                 <tr>
                                    <th class="th-normal text-left font-others">Support:
                                    </th>
                                    <td id="total_pd_mp_line_support_to" class="text-left font-others-value"
                                       style="background: #ABD2FA; border-right: 1px solid #E6E6E6; color: #000;">
                                    </td>
                                    <th class="th-normal text-left font-others">Support:
                                    </th>
                                    <td id="total_qa_mp_line_support_to" class="text-left font-others-value"
                                       style="background: #ABD2FA; border-right: 1px solid #E6E6E6; color: #000;">
                                    </td>
                                    <th class="th-normal text-left font-others">Working Time
                                       Plan:</th>
                                    <td class="text-left font-others-value" style="background: #CFCFCF; color: #000;">
                                       <?= $work_time_plan; ?>
                                    </td>
                                 </tr>
                                 <tr>
                                    <th class="th-normal text-left font-others">Absent Rate:
                                    </th>
                                    <td id="absent_ratio_pd_mp" class="text-left font-others-value"
                                       style="background: #ABD2FA; border-right: 1px solid #E6E6E6; color: #000;">
                                    </td>
                                    <th class="th-normal text-left font-others">Absent Rate:
                                    </th>
                                    <td id="absent_ratio_qa_mp" class="text-left font-others-value"
                                       style="background: #ABD2FA; border-right: 1px solid #E6E6E6; color: #000;">
                                    </td>
                                    <th class="th-normal text-left font-others">Daily Plan:</th>
                                    <td class="text-left font-others-value" style="background: #CFCFCF; color: #000;">
                                       <?= $daily_plan; ?>
                                    </td>
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
               <div class="row ml-2 mr-2 mt-3">
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
</body>

<!-- jQuery -->
<script src="plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- mdb -->
<!-- <script src="plugins/mdb/js/mdb.min.js"></script> -->
<!-- <script src="plugins/mdb/js/mdb.js"></script> -->
<!-- Chart JS -->
<!-- <script src="node_modules/chart.js/dist/chart.umd.js"></script> -->

<!-- v-2.9.4 -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script
   src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.7/chartjs-plugin-annotation.min.js"></script>

<!-- data labels -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script> -->


<!-- <script src="plugins/chart.js/3.9.1/chart.umd.js"></script> -->
<!-- <script src="plugins/chart.js/annotation/chartjs-plugin-annotation-1.0.2.js"></script> -->

<!--Moment JS -->
<script src="plugins/moment-js/moment.min.js"></script>
<script src="plugins/moment-js/moment-duration-format.min.js"></script>

<script>
   // Chart Variables
   let chart; // for andon only
   let chartAndonHourly;
   let chartHourlyOutput;
   let chartNGhourly;

   // Set LocalStorage for these variables
   localStorage.setItem("andon_line", $("#andon_line").val());
   localStorage.setItem("shift", $("#shift").val());

   // Interval Variables
   let realtime_get_accounting_efficiency;
   let realtime_get_hourly_output;
   let realtime_get_yield;
   let realtime_get_ppm;
   let realtime_get_inspection_list;
   let realtime_get_overall_inspection;
   let realtime_count_emp;
   let realtime_andon_d_sum;
   let realtime_andon_hourly_graph;
   let realtime_get_hourly_output_chart;
   let realtime_ng_graph;

   // Recursive setTimeout Functions
   const recursive_realtime_get_accounting_efficiency = () => {
      get_accounting_efficiency();
      realtime_get_accounting_efficiency = setTimeout(recursive_realtime_get_accounting_efficiency, 30000);
   }
   const recursive_realtime_get_hourly_output = () => {
      get_hourly_output();
      realtime_get_hourly_output = setTimeout(recursive_realtime_get_hourly_output, 30000);
   }
   const recursive_realtime_get_yield = () => {
      get_yield();
      realtime_get_yield = setTimeout(recursive_realtime_get_yield, 30000);
   }
   const recursive_realtime_get_ppm = () => {
      get_ppm();
      realtime_get_ppm = setTimeout(recursive_realtime_get_ppm, 30000);
   }
   const recursive_realtime_get_inspection_list = () => {
      get_inspection_list();
      realtime_get_inspection_list = setTimeout(recursive_realtime_get_inspection_list, 30000);
   }
   const recursive_realtime_get_overall_inspection = () => {
      get_overall_inspection();
      realtime_get_overall_inspection = setTimeout(recursive_realtime_get_overall_inspection, 30000);
   }
   const recursive_realtime_count_emp = () => {
      count_emp();
      realtime_count_emp = setTimeout(recursive_realtime_count_emp, 30000);
   }
   const recursive_realtime_andon_d_sum = () => {
      andon_d_sum();
      realtime_andon_d_sum = setTimeout(recursive_realtime_andon_d_sum, 30000);
   }
   const recursive_realtime_andon_hourly_graph = () => {
      andon_hourly_graph();
      realtime_andon_hourly_graph = setTimeout(recursive_realtime_andon_hourly_graph, 30000);
   }
   const recursive_realtime_get_hourly_output_chart = () => {
      get_hourly_output_chart();
      realtime_get_hourly_output_chart = setTimeout(recursive_realtime_get_hourly_output_chart, 30000);
   }
   const recursive_realtime_ng_graph = () => {
      ng_graph();
      realtime_ng_graph = setTimeout(recursive_realtime_ng_graph, 30000);
   }

   // Carousel Variables
   let slide_number = 1;

   $('.carousel').carousel({
      interval: 60000
   });

   // Fire Event on Carousel
   $('.carousel').bind('slide.bs.carousel', e => {
      console.log(`slide number:${slide_number}`);

      if (e.direction == 'left') {
         if (slide_number == 8) {
            slide_number = 0;
         }
         slide_number++;
      } else if (e.direction == 'right') {
         if (slide_number == 1) {
            slide_number = 9;
         }
         slide_number--;
      }

      console.log(`slide number:${slide_number}`);
      console.log(e.direction);

      switch (slide_number) {
         case 1:
            clearTimeout(realtime_count_emp);
            clearTimeout(realtime_get_accounting_efficiency);
            clearTimeout(realtime_get_hourly_output);
            recursive_realtime_get_yield();
            recursive_realtime_get_ppm();
            break;
         case 2:
            clearTimeout(realtime_get_yield);
            clearTimeout(realtime_get_ppm);
            clearTimeout(realtime_get_inspection_list);
            clearTimeout(realtime_get_overall_inspection);
            recursive_realtime_get_accounting_efficiency();
            recursive_realtime_get_hourly_output();
            break;
         case 3:
            clearTimeout(realtime_get_accounting_efficiency);
            clearTimeout(realtime_get_hourly_output);
            clearTimeout(realtime_andon_d_sum);
            recursive_realtime_get_inspection_list();
            recursive_realtime_get_overall_inspection();
            break;
         case 4:
            clearTimeout(realtime_get_inspection_list);
            clearTimeout(realtime_get_overall_inspection);
            clearTimeout(realtime_andon_hourly_graph);
            recursive_realtime_andon_d_sum();
            break;
         case 5:
            clearTimeout(realtime_andon_d_sum);
            clearTimeout(realtime_get_hourly_output_chart);
            recursive_realtime_andon_hourly_graph();
            break;
         case 6:
            clearTimeout(realtime_andon_hourly_graph);
            clearTimeout(realtime_ng_graph);
            recursive_realtime_get_hourly_output_chart();
            break;
         case 7:
            clearTimeout(realtime_get_hourly_output_chart);
            clearTimeout(realtime_count_emp);
            recursive_realtime_ng_graph();
            break;
         case 8:
            clearTimeout(realtime_ng_graph);
            clearTimeout(realtime_get_yield);
            clearTimeout(realtime_get_ppm);
            recursive_realtime_count_emp();
            break;
         default:
      }
   });

   // Initialization for Charts (Included due to Recursive SetInterval Functions)
   const init_charts = () => {
      var configuration = {};
      // Andon
      var ctx = document.getElementById('hourly_chart').getContext('2d');
      chart = new Chart(ctx, configuration);
      // Andon Hourly
      var ctx = document.getElementById('andon_hourly_chart').getContext('2d');
      chartAndonHourly = new Chart(ctx, configuration);
      // Hourly Output
      var ctx = document.getElementById('hourly_output_summary_chart').getContext('2d');
      chartHourlyOutput = new Chart(ctx, configuration);
      // NG Summary
      var ctx = document.getElementById('ng_summary_chart').getContext('2d');
      chartNGhourly = new Chart(ctx, configuration);
   }

   $(document).ready(function () {
      // Load data for first slide
      recursive_realtime_get_yield();
      recursive_realtime_get_ppm();
      get_accounting_efficiency(); // added due to updateTakt functionality
      get_hourly_output(); // added to set target_hourly_output

      init_charts();
   });
</script>

<?php
include 'javascript/pcs.php';
include 'javascript/pcad.php';
include 'javascript/emp_mgt.php';
include 'javascript/andon.php';
include 'javascript/hourly_graph_tv.php';
include 'javascript/inspection_output.php';
?>

</html>
<!-- /.navbar -->