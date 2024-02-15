<?php
include 'process/server_date_time.php';
require 'process/conn/emp_mgt.php';
include 'process/lib/emp_mgt.php';
require 'process/conn/pcad.php';



// $line_no = '2132';
// $line_no = $_GET['line_no'];
// $registlinename = '';
$registlinename = $_GET['registlinename']; // IRCS LINE (PCS)


$processing = false;
if (isset($_GET['registlinename'])) {
    $registlinename = $_GET['registlinename'];
    $q = "SELECT * FROM t_plan WHERE IRCS_Line = :registlinename AND Status = 'Pending'";
    $stmt = $conn_pcad->prepare($q);
    $stmt->bindParam(':registlinename', $registlinename);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($res) {
        $started = $res['actual_start_DB'];
        $takt = $res['takt_secs_DB'];
        $last_takt = $res['last_takt_DB'];
        $last_update_DB = $res['last_update_DB'];
        $is_paused = $res['is_paused'];
        $line_no = $res['Line'];

        $sql = "SELECT * FROM m_ircs_line WHERE ircs_line = :registlinename";
        $stmt = $conn_pcad->prepare($sql);
        $stmt->bindParam(':registlinename', $registlinename);
        $stmt->execute();
        $line_data = $stmt->fetch(PDO::FETCH_ASSOC);
        $line_no = $line_data['line_no'];
        $andon_line = $line_data['andon_line'];
        

        $processing = true;
        $secs_diff = strtotime(date('Y-m-d H:i:s')) - strtotime($last_update_DB);
        $added_takt_plan = ($takt > 0) ? floor($secs_diff / $takt) : 0;
    }
}

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
    <title>PCAD - ST</title>

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

</head>

<body>
    <input type="hidden" id="shift" value="<?= $shift ?>">
    <input type="hidden" id="dept_pd" value="<?= $dept_pd ?>">
    <input type="hidden" id="dept_qa" value="<?= $dept_qa ?>">
    <input type="hidden" id="section_pd" value="<?= $section_pd ?>">
    <input type="hidden" id="section_qa" value="<?= $section_qa ?>">
    <input type="hidden" id="line_no" value="<?= $line_no ?>">
    <input type="hidden" id="registlinename" value="<?= $registlinename ?>">
    <input type="hidden" id="started" value="<?php echo $started; ?>">
    <input type="hidden" id="takt" value="<?php echo $takt; ?>">
    <input type="hidden" id="last_takt" value="<?php echo $last_takt; ?>">
    <input type="hidden" id="added_takt_plan" value="<?php echo $added_takt_plan; ?>">
    <input type="hidden" id="is_paused" value="<?php echo $is_paused; ?>">
    <input type="hidden" id="andon_line" value="<?= $andon_line; ?>">
    <div class="container-fluid">
        <div class="flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/logo.webp" alt="logo" height="60" width="60"><span class="h5">PCAD<span>
        </div>
    </div>
    <div class="container-fluid">
        <h1 class='text-center'>Production Conveyor Analysis Dashboard</h1>
        <div class="col-12">
            <div class="card card-primary card-outline shadow">
                <div class="card-body">
                    <div class="row">
                        <p class="card-text col-6">
                            <label for="" id="line_no_label">Line No. <span> <?= $line_no ?></span></label>
                            <br>
                            <label for="" id="shift_label">Shift <span> <?= $shift ?></span></label>
                        </p>
                        <p class="card-text col-6">

                            <label for="" id="server_date_only_label">Date: <span><?= $server_date_only ?></span></label>

                            <br>
                            <label for="" id="shift_group_label">Group <span>A/B</span></label>
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
                                        <th scope="row">Plan</th>
                                        <td class="plan_target_value" id="plan_target">10</td>
                                        <td class="plan_actual_value" id="plan_actual">10</td>
                                        <td class="plan_gap_value" id="plan_gap">90</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Accounting Efficiency</th>
                                        <td>200</td>
                                        <td id="actual_accounting_efficiency">20</td>
                                        <td>180</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Hourly Output</th>
                                        <td>300</td>
                                        <td id="actual_hourly_output">30</td>
                                        <td>270</td>
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
                                                <td id="total_pd_mp">100</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Actual</th>
                                                <td id="total_present_pd_mp">200</td>
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
                                                <td>100</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Absent</th>
                                                <td id="total_absent_pd_mp">200</td>
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
                                                <td id="absent_ratio_pd_mp">100</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Suppport</th>
                                                <td id="total_pd_mp_line_support_to">200</td>
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
                                                <td id="total_qa_mp">100</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Actual</th>
                                                <td id="total_present_qa_mp">200</td>
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
                                                <td>100</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Absent</th>
                                                <td id="total_absent_qa_mp">200</td>
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
                                                <td id="absent_ratio_qa_mp">100</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Suppport</th>
                                                <td id="total_qa_mp_line_support_to">200</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========================================================= -->
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
                                        <td>100</td>
                                    </tr>
                                    <tr>
                                        <th class="takt-label" scope="row">Takt Time</th>
                                        <td class="takt-value">200</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Working Time Plan</th>
                                        <td>300</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Working Time Actual</th>
                                        <td>300</td>
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
                                        <td>100</td>
                                        <td id="actual_yield">10</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">PPM</th>
                                        <td>200</td>
                                        <td id="actual_ppm">20</td>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- =========================================== -->
                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body">
                            <h3>DT / DELAY / ANDON</h3>

                            <!-- /.navbar -->
                            <div class="container-lg my-4">
                                <div class="card rounded shadow">
                                    <div id="chart-container">
                                        <canvas id="hourly_chart"></canvas>
                                    </div>
                                </div>
                                <a target="_blank" href="http://172.25.114.167:3000/andon_system/admin/page/andonProdLogs.php" class="card-link">Andon Details</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Buttons (Progress Counter TV) -->
        <div class="row">
            <div class="col-4">
                <button type="button" class="btn btn-danger btn-block">PAUSE <b>[ 1 ]</b></button>
                <button type="button" class="btn btn-danger btn-block d-none ">RESUME <b>[ 3 ]</b></button>

            </div>
            <div class="col-4">
                <button type="button" class="btn btn-success btn-block">END PROCESS <b>[ 2 ]</b></button>
            </div>
            <div class="col-4">
                <a type="button" class="btn btn-secondary btn-block" href="pcs_page/index.php"> MAIN MENU <b>[ 0 ]</b></a>
            </div>
        </div>
    </div>
    <footer class="main-footer">
        <strong>Copyright &copy; 2024. Developed by FALP IT System Group</strong>
        All rights reserved.
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
    $(document).ready(function() {
        // Call andon_d_sum initially to load the chart
        andon_d_sum();
        // Set interval to refresh data every 10 seconds
        setInterval(andon_d_sum, 10000); // 10000 milliseconds = 10 seconds

        // Call count_emp initially to load the data from employee management system
        count_emp();
        // Set interval to refresh data every 15 seconds
        setInterval(count_emp, 15000); // 15000 milliseconds = 15 seconds

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

        var timer = 4000;
        var interval = 20;
		var barWidth = $('.bar').innerWidth() - 12;
		var processing = $('#processing').val();
		var timerTakt = $("#last_takt").val();
		var timerOn = true;
		var isPause = false;

		getDT();

		// $('.done').addClass('d-none');
		// $('.running').removeClass('d-none');
		if($('#takt').val() == 0){
			$('.btn-resume').addClass('d-none');
			$('.btn-pause').addClass('d-none');
		}

		checkPausedStatus();

		function checkPausedStatus(){
			if($("#is_paused").val() == "YES"){
				isPause = true;
				$('.btn-resume').removeClass('d-none');
				$('.btn-pause').addClass('d-none');
				$('.loading').css('background-color','#dc3545');

			}else{
				isPause = false;
				$('.btn-pause').removeClass('d-none');
				$('.btn-resume').addClass('d-none');
				$('.loading').css('background-color','#04e000');
			}

			$(".takt-value").text(moment.utc(timerTakt*1000).format('HH:mm:ss'));
			var takt = $('#takt').val();
			var taktset = moment.utc(takt*1000).format('HH:mm:ss');
			$('#taktset').text('('+taktset+')');
		}

		if(processing == 1){
			getValues();
			setInterval(function(){
				if (timerOn == true && isPause == false){
					var loadingWidth = $('.loading').width();
					if (loadingWidth >= (barWidth - 200)){
						$('.plan_target_value').removeClass('reloadedLine');
						$('.plan_actual_value').removeClass('reloadedLine');
						$('.plan_gap_value').removeClass('reloadedLine');
						$('.plan_gap_value').css('padding-top','0');
					}

					if (loadingWidth <= barWidth){
						$('.loading').css('width',(loadingWidth+7) + 'px');
					}else{
						$('.loading').css('width','0px');
						getValues();
					}
				}
			}, interval);
			
			
			function getValues() {
				var registlinename = $("#registlinename").val();
				var last_takt = $("#last_takt").val();
				var added_takt_plan = $("#added_takt_plan").val();
					// console.log(registlinename);
				$.post('process/pcs/setting_p.php',{
					request: 'getPlanLine',
					registlinename: registlinename,
					last_takt: last_takt
				}, function(response){
					fetch_digit();
					console.log(response);

					if ($('.plan_target_value').text() != response.plan){
						$('.plan_target_value').addClass('reloadedLine');
						$('.plan_target_value').css('margin-top','-100px');
							
					}

					if ($('.plan_actual_value').text() != response.actual){
						$('.plan_actual_value').addClass('reloadedLine');
						$('.plan_actual_value').css('margin-top','-100px');
					}

					if ($('.plan_gap_value').text() != response.remaining){
						$('.plan_gap_value').addClass('reloadedLine');
						$('.plan_gap_value').css('margin-top','-100px');
					}

					$('.plan_target_value').text(parseInt(response.plan));
					$('.plan_actual_value').text( parseInt(response.actual));
					$('.plan_gap_value').text(response.remaining);
		
			
					if($('.plan_gap_value').text() < 0){
						$('.plan_gap_value').css('color','#dc3545');
					}else if($('.plan_gap_value').text() > 0){
						$('.plan_gap_value').css('color','#6cfc71');
					}else{
						$('.plan_gap_value').css('color','#ffffff');
					}

				});
				
			}

			setInterval(function(){
				if (timerOn == true){
					if(isPause == false){

						var takttimer = moment.utc(timerTakt*1000).format('HH:mm:ss');
						var takt = $('#takt').val();
						var taktset = moment.utc(takt*1000).format('HH:mm:ss');
						$("#last_takt").val(timerTakt);

						if(takt != 0){
							$('.takt-value').text(takttimer);
							$('#taktset').text('('+taktset+')');
						} else{
							$('.takt-value').text('N/A');
							$('#taktset').text('(N/A)');
						}
						timerTakt++;

						if(takt != 0){
							if(timerTakt > takt){
								//update takt time
								timerTakt = 0;
								updateTakt();
							}
						}
						
					}
				}

			}, 1000);

		}else{
			$('.loading').css({
				'width':'100%',
			});
		}

		setInterval(function(){
			getDT();
		}, 1000);

		function getDT(){
			var datenow = moment().format('YYYY/MM/DD hh:mm:ss A');
			$('.datenow').text(datenow);
		}

		function updateTakt(){
			var added_takt_plan = $("#added_takt_plan").val();
			$.post('process/pcs/setting_p.php',{
				request: 'updateTakt',
				registlinename: $('#registlinename').val(),
				added_takt_plan: added_takt_plan
			}, function(response){
				if(response.trim() == "true"){
					getValues();
				}
			});
		}

		$(document).on('click', '.btn-target', function(e){
			e.preventDefault();

			$('.btn-resume').addClass('d-none');
			$('.btn-pause').addClass('d-none');

			var registlinename = $("#registlinename").val();
			$.post('process/pcs/setting_p.php',{
				request: 'endTarget',
				registlinename: registlinename
			}, function(response){
				console.log(response);

				if(response.trim() == 'true'){
					timerOn = false;
					$('.btn-set').removeClass('d-none');
					$('.btn-target').addClass('d-none');
					$('.btn-menu').addClass('d-none');
					$('.loading').css('width',(barWidth+12) + 'px');
					$('.running').addClass('d-none');
					$('.done').removeClass('d-none');
					// Revisions (Vince)
					//$('#ng_count_end_label').removeClass('d-none');
					//$('#ng_count_label').addClass('d-none');
				}
			});
		});

		$(document).on('click', '.btn-pause', function(e){
			e.preventDefault();
			var el = $(this);
			$.post('process/pcs/setting_p.php',{
				request: 'setPaused',
				registlinename: $("#registlinename").val(),
				is_paused: 'YES'
			}, function(response){
				console.log(response);
				el.addClass('d-none');
				$('.btn-resume').removeClass('d-none');
				$('.loading').css('background-color','#dc3545');
				isPause = true;
			});
		});
		$(document).on('click', '.btn-resume', function(e){
			e.preventDefault();
			var el = $(this);

			$.post('process/pcs/setting_p.php',{
				request: 'setPaused',
				registlinename: $("#registlinename").val(),
				is_paused: 'NO'
			}, function(response){
				console.log(response);
				el.addClass('d-none');
				$('.btn-pause').removeClass('d-none');
				$('.loading').css('background-color','#04e000');
				isPause = false;
			});
		});
// ---EVENT LISTENER -----------------------------------------------------------------//
		document.addEventListener("keypress",function(x){
			// PAUSE USING KEY NUMBER 1
			if(x.keyCode == 49 || x.keyCode == 97){
				var el = $(this);
			$.post('process/pcs/setting_p.php',{
				request: 'setPaused',
				registlinename: $("#registlinename").val(),
				is_paused: 'YES'
			}, function(response){
				console.log(response);
				el.addClass('d-none');
				$('.btn-pause').addClass('d-none');
				$('.btn-resume').removeClass('d-none');
				$('.loading').css('background-color','#dc3545');
				isPause = true;
			});
			}
			// END TARGET USING KEY NUMBER 2 -----------------------------------------------------------------------------
			if(x.keyCode == 50 || x.keyCode == 98){
				var x = confirm('Confirm to end the target?');
				if(x == true){
					$('.btn-resume').addClass('d-none');
					$('.btn-pause').addClass('d-none');

					var registlinename = $("#registlinename").val();
					$.post('process/pcs/setting_p.php',{
						request: 'endTarget',
						registlinename: registlinename
					}, function(response){
						console.log(response);
						if(response.trim() == 'true'){
							timerOn = false;
							$('.btn-set').removeClass('d-none');
							$('.btn-target').addClass('d-none');
							$('.btn-menu').addClass('d-none');
							$('.loading').css('width',(barWidth+12) + 'px');
							$('.running').addClass('d-none');
							$('.done').removeClass('d-none');
							// Revisions (Vince)
							//$('#ng_count_end_label').removeClass('d-none');
							//$('#ng_count_label').addClass('d-none');
						}
					});
				}else{
					// DO NOTHING
				}
			}
			// RESUME BUTTON
			if(x.keyCode == 51 || x.keyCode == 99){
				var el = $(this);
				$.post('process/pcs/setting_p.php',{
					request: 'setPaused',
					registlinename: $("#registlinename").val(),
					is_paused: 'NO'
				}, function(response){
					console.log(response);
					el.addClass('d-none');
					$('.btn-resume').addClass('d-none');
					$('.btn-pause').removeClass('d-none');
					$('.loading').css('background-color','#04e000');
					isPause = false;
				});
				}
			// MAIN MENU
			if(x.keyCode == 48 || x.keyCode == 96){
				window.open('index.php','_self');
			}
			// SET PLAN ------------------------------------------------------------------------------------------------------------
			if(x.keyCode == 52 || x.keyCode == 100){
				var url = $('#setplanBtn').prop('href');
				window.open(url,"_self");
			}
			// SET NEW TARGET
			if(x.keyCode == 53 || x.keyCode == 101){
				var url = $('#setnewTargetBtn').prop('href');
				window.open(url,"_self");
			}
		});

	
			// TIMER FOR DIGIT LENGTH CHECK
	

		function fetch_digit(){
			var plan_length = $('#plan_target').text().length;
			var actual_length = $('#plan_actual').text().length;
			var diff_length = $('#plan_gap').text().length;
			console.log(plan_length);
			console.log(actual_length);
			console.log(diff_length);

			if(plan_length >= 3 && actual_length  >= 3 && diff_length >= 3){
				$('#fit_style').html('.bar{zoom:50%;}');
			}else if(plan_length >= 3 && actual_length  >= 1 && diff_length >= 3){
				$('#fit_style').html('.bar{zoom:55%;}');
			}else if(plan_length >= 3 && actual_length  >= 3 && diff_length >= 1){
				$('#fit_style').html('.bar{zoom:55%;}');
			}else if(plan_length >=3 && actual_length >=2 && diff_length >= 2){
				$('#fit_style').html('.bar{zoom:55%;}');
			}else if(plan_length >= 3 && actual_length  >= 2 && diff_length >= 3){
				$('#fit_style').html('.bar{zoom:55%;}');
			}else if(plan_length >= 2 && actual_length  >= 2 && diff_length >= 3){
				$('#fit_style').html('.bar{zoom:65%;}');
			}
			else{
				$('#fit_style').html('.bar{zoom:65%;}');
			}
		}

    });

    const andon_d_sum = () => {
        let andon_line = document.getElementById('andon_line').value;
        $.ajax({
            url: 'process/andon_graph/a_graph_p.php',
            type: 'POST',
            dataType: 'json',
            cache: false, // Disable browser caching for this request
            data: {
                andon_line: 'andon_line',
                method: 'a_down_time'
            },
            success: function(data) {
                let department = [];
                let machinename = [];
                let Waiting_Time = [];
                let Fixing_Time = [];
                let Total_DT = [];
                for (let i = 0; i < data.length; i++) {
                    department.push(data[i].department);
                    machinename.push(data[i].machinename);
                    Waiting_Time.push(data[i].Waiting_Time);
                    Fixing_Time.push(data[i].Fixing_Time);
                    Total_DT.push(data[i].Total_DT);
                }
                let ctx = document.getElementById('hourly_chart').getContext('2d');
                let configuration = {
                    type: 'bar',
                    options: {
                        scales: {
                            y: {
                                stacked: true,
                                ticks: {
                                    autoSkip: false,
                                }
                            },
                            x: {
                                stacked: true,
                                ticks: {
                                    autoSkip: false,
                                }
                            },
                        }
                    },
                    data: {
                        labels: machinename, // Use machine names as the primary labels
                        datasets: [{
                            label: 'Waiting Time',
                            backgroundColor: 'rgba(1, 56, 99, 1)',
                            borderColor: 'rgba(1, 56, 99, 1)',
                            borderWidth: 2,
                            data: Waiting_Time,
                            yAxisID: 'y',
                        }, {
                            label: 'Fixing Time',
                            backgroundColor: 'rgba(23, 162, 184, 0.5)',
                            borderColor: 'rgba(23, 162, 184, 1)',
                            borderWidth: 1,
                            data: Fixing_Time,
                            yAxisID: 'y',
                        }],
                    },
                };
                // Set department labels as sub-labels for each machine
                configuration.data.labels = machinename.map((machine, index) => [machine, department[index]]);
                // Destroy previous chart instance before creating a new one
                if (chart) {
                    chart.destroy();
                }
                chart = new Chart(ctx, configuration);
            },
        });
    }

    const count_emp = () => {
        let dept_pd = document.getElementById('dept_pd').value;
        let dept_qa = document.getElementById('dept_qa').value;
        let section_pd = document.getElementById('section_pd').value;
        let section_qa = document.getElementById('section_qa').value;
        let line_no = document.getElementById('line_no').value;
        $.ajax({
            url: 'process/emp_mgt/emp_mgt_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'count_emp',
                dept_pd: dept_pd,
                dept_qa: dept_qa,
                section_pd: section_pd,
                section_qa: section_qa,
                line_no: line_no
            },
            success: function(response) {
                try {
                    let response_array = JSON.parse(response);
                    if (response_array.message == 'success') {
                        document.getElementById('total_pd_mp').innerHTML = response_array.total_pd_mp;
                        document.getElementById('total_present_pd_mp').innerHTML = response_array.total_present_pd_mp;
                        document.getElementById('total_absent_pd_mp').innerHTML = response_array.total_absent_pd_mp;
                        document.getElementById('total_pd_mp_line_support_to').innerHTML = response_array.total_pd_mp_line_support_to;
                        document.getElementById('absent_ratio_pd_mp').innerHTML = `${response_array.absent_ratio_pd_mp}%`;

                        document.getElementById('total_qa_mp').innerHTML = response_array.total_qa_mp;
                        document.getElementById('total_present_qa_mp').innerHTML = response_array.total_present_qa_mp;
                        document.getElementById('total_absent_qa_mp').innerHTML = response_array.total_absent_qa_mp;
                        document.getElementById('total_qa_mp_line_support_to').innerHTML = response_array.total_qa_mp_line_support_to;
                        document.getElementById('absent_ratio_qa_mp').innerHTML = `${response_array.absent_ratio_qa_mp}%`;
                    } else {
                        console.log(response);
                    }
                } catch (e) {
                    console.log(response);
                }
            }
        });
    }

    const get_accounting_efficiency = () => {
        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_accounting_efficiency'
            },
            success: function(response) {
                document.getElementById('actual_accounting_efficiency').innerHTML = `${response}%`;
            }
        });
    }

    const get_hourly_output = () => {
        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_hourly_output'
            },
            success: function(response) {
                document.getElementById('actual_hourly_output').innerHTML = response;
            }
        });
    }

    const get_yield = () => {
        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_yield'
            },
            success: function(response) {
                document.getElementById('actual_yield').innerHTML = response;
            }
        });
    }

    const get_ppm = () => {
        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_ppm'
            },
            success: function(response) {
                document.getElementById('actual_ppm').innerHTML = response;
            }
        });
    }
</script>

</html>
<!-- /.navbar -->
