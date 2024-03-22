<?php
include 'plugins/head.php';
include '../process/conn/pcad.php';

$ircs_lines = array();
$query = "SELECT * FROM m_ircs_line ORDER BY ircs_line ASC";
$result = $conn_pcad->query($query);

if ($result) {
	$ircs_lines = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
	$errorInfo = $conn_pcad->errorInfo();
	echo "Error: " . $errorInfo[2];
}

?>
<div class="pt-4 container-fluid">
	<div class="row justify-content-center">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<div class="card" style="background-color: #FDFEFF; border: 2px solid #334C69; box-shadow: 0px 10px 10px 0px rgba(0, 0, 0, 0.25)">
				<h2 class="card-header" style="color: #334C69;"><b>Production Conveyor Analysis Settings</b></h2>
				<form method="post" action="../process/pcs/setting_p.php">
					<input type="hidden" name="request" value="addTarget">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<table>
									<tbody>
										<tr>
											<td class="text-right font-weight-bold" style="font-size: 17px;">
												SELECT LINE NO. </td>
											<td>
												<select name="registlinename" id="ircs_line" class="form-control ml-4" style="width: 250px;">
													<option value="">
														- - - -
													</option>
													<?php
													if ($ircs_lines) {
														foreach ($ircs_lines as $i => $ircs) {
															echo '<option value="' . $ircs['ircs_line'] . '">' . $ircs['ircs_line'] . ' (' . $ircs['line_no'] . ')</option>';
														}
													}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td style="height: 10px;"></td>
										</tr>
										<tr>
											<td class="text-right font-weight-bold" style="font-size: 17px;">
												SELECTED LINE NO. </td>
											<td>
												<input type="text" readonly class="ml-4 form-control" style="width: 250px;" id="line_no" value="">
											</td>
										</tr>
									</tbody>
								</table>
								<hr>
								<h4>SET YOUR TARGET PLAN</h4>
								<input type="hidden" id="registlinenameplan" name="registlinenameplan" value="">
								<div class="container-fluid">
									<h5>TAKT TIME: </h5>
									<div class="row justify-content-center">
										<div class="col-lg-2 d-none">
											<div class="form-group">
												<label for="a">Hour</label>
												<input type="text" name="hrs" class="form-control" id="hrs" placeholder="00">
											</div>
										</div>
										<div class="col-lg-2 d-none">
											<div class="form-group">
												<label for="b">Minutes</label>
												<input type="text" name="mins" class="form-control" id="mins" placeholder="00">
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label>PLAN</label>
												<input type="text" class="form-control form-control-lg" id="plan" autofocus="on" min="1">
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label>SECONDS</label>
												<input type="text" class="form-control form-control-lg" id="secs" readonly value="27000">
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label for="c">TAKT TIME</label>
												<input type="text" name="takt_time" class="form-control form-control-lg" id="takt_time" readonly placeholder="00">
											</div>
										</div>
									</div>
									<hr>
									<h5>STARTING PLAN: </h5>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label for="d">TARGET PLAN</label>
												<input type="text" name="plan" class="form-control form-control-lg" id="target_plan" placeholder="" value="0">
											</div>
										</div>
										<?php
										$dd = date('F d, Y');
										$time_range = '';
										$time_start = '';
										$time_end = '';
										$time_range = '';
										$current_time = date('h:i a');
										$startDS = "6:00 am";
										$endDS = "5:59 pm";
										$startNS = "5:00 pm";
										$endNS = "6:59 am";
										$date1 = DateTime::createFromFormat('H:i a', $current_time);
										$date2 = DateTime::createFromFormat('H:i a', $startDS);
										$date3 = DateTime::createFromFormat('H:i a', $endDS);
										$date4 = DateTime::createFromFormat('H:i a', $startNS);
										$date5 = DateTime::createFromFormat('H:i a', $endNS);
										if ($date1 > $date2 && $date1 < $date3) {
											$time_range = '06:00 AM - 5:59 PM';
											$time_start = '06:00:00';
											$time_end = '17:59:59';
											// } else if ($date1 > $date4 && $date1 < $date5){
										} else {
											$time_range = '06:00 PM - 5:59 AM';
											$time_start = '18:00:00';
											$time_end = '05:59:59';
										}
										?>
										<div class="col-lg-6">
											<div class="form-group">
												<label for="d">TIME RANGE</label>
												<input type="text" name="time_range" class="form-control form-control-lg" id="time_range" readonly value="<?php echo $time_range; ?>">
											</div>
											<input type="hidden" name="time_start" value="<?php echo $time_start; ?>">
											<input type="hidden" name="time_end" value="<?php echo $time_end; ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<!-- Additional content for the right column -->
								<table>
									<tr>
										<td class="text-right font-weight-bold" style="font-size: 17px;">GROUP</td>
										<td>
											<select name="group" id="group" class="form-control ml-4" style="width: 250px;">
												<option value="" disabled selected>Select Group </option>
												<option value="A">A</option>
												<option value="B">B</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="height: 10px;"></td>
									</tr>
									<tr>
										<td class="text-right font-weight-bold" style="font-size: 17px;">Yield (%)</td>

										<td>
											<input type="text" class="ml-4 form-control" style="width: 250px;" name="yeild_target" id="yeild_target">
										</td>
										</td>
									</tr>
									<tr>
										<td style="height: 10px;"></td>
									</tr>
									<tr>
										<td class="text-right font-weight-bold" style="font-size: 17px;">Defect Rate (PPM)</td>

										<td>
											<input type="text" class="ml-4 form-control" style="width: 250px;"  name="ppm_target" id="ppm_target">
										</td>
										</td>
									</tr>
									<tr>
										<td style="height: 10px;"></td>
									</tr>
									<tr>
										<td class="text-right font-weight-bold" style="font-size: 17px;">Accounting Efficiency (%)</td>

										<td>
											<input type="text" class="ml-4 form-control" style="width: 250px;" name="acc_eff" id="acc_eff">
										</td>
										</td>
									</tr>
									<tr>
										<td style="height: 10px;"></td>
									</tr>
									<!-- <tr>
										<td class="text-right font-weight-bold" style="font-size: 17px;">Hourly Output</td>

										<td>
											<input type="text" class="ml-4 form-control" style="width: 250px;" id="hrs_output">
										</td>
										</td>
									</tr>
									<tr>
										<td style="height: 10px;"></td>
									</tr> -->
									<tr>
										<td class="text-right font-weight-bold" style="font-size: 17px;">Starting Balance Delay (Set)</td>

										<td>
											<input type="text" class="ml-4 form-control" style="width: 250px;" name="start_bal_delay" id="start_bal_delay" value="0">
										</td>
										</td>
									</tr>
									<tr>
										<td style="height: 10px;"></td>
									</tr>
									<tr>
										<td class="text-right font-weight-bold" style="font-size: 17px;">Working Time Plan (Mins)</td>

										<td>
										<select name="work_time_plan" id="work_time_plan" class="form-control ml-4" style="width: 250px;">
												<option value="450">450</option>
												<option value="510">510</option>
												<option value="570">570</option>
												<option value="630">630</option>
											</select>
										</td>
										</td>
									</tr>
								</table>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div style="text-align: right;">
									<button type="button" style="width: 100%;" class="btn btn-danger btn-target d-none" id="ongoingBtn">ONGOING PROCESS
										<b>[BACK]</b></button>
								</div>
								<div style="text-align: right;">
									<button type="submit" style="width: 100%;" class="btn btn-success btn-target d-none" id="setplanBtn" name="request" value="addTarget" required>SET PLAN <b>[PLAY]</b></button>
								</div>
							</div>
							<div class="col-md-6">
								<button type="submit" style="width: 100%;" class="btn btn-secondary" id="menuBtn" name="request" value="mainMenu">MAIN MENU <b>[BACK]</b></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
include 'plugins/footer.php';
include 'plugins/js/setting_script.php';
?>