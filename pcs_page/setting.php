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
			<div class="card " style="background-color: white;border: 1px solid #2a9df4;box-shadow:5px 10px gray;">
				<h5 class="card-header" style="color:#4d6d9a;">
					Production Conveyor Analysis Settings
				</h5>
				<div class="card-body">
					<div class="col-md-6">
						<table>
							<tbody>
								<tr>
									<td class="text-right font-weight-bold fz-25">SELECT LINE NO. </td>
									<td>
										<select name="registlinename" id="ircs_line" class="form-control ml-4 fz-25" style="width: 250px">
											<option value="">- - -</option>
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
									<td class="text-right font-weight-bold fz-25">SELECTED LINE NO. </td>
									<td>
										<input type="text" readonly class="ml-4 fz-25 form-control-plainstext" id="line_no" value="">
									</td>
								</tr>
							</tbody>
						</table>
						<hr>
						<h4>SET YOUR TARGET PLAN</h4>
						<form  class="pt" method="post" action="../process/pcs/setting_p.php">
							<input type="hidden" name="request" value="addTarget">
							<input type="hidden" id="registlinenameplan"  name="registlinenameplan" value="">
							<div class="container-fluid">
								<h4>TAKT TIME: </h4>
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
											<label>Plan</label>
											<input type="text" class="form-control form-control-lg" id="plan" required autofocus="on" min="1">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label>Secs</label>
											<input type="text" class="form-control form-control-lg" id="secs" required value="27000">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label for="c">TAKT TIME</label>
											<input type="text" name="takt_time" class="form-control form-control-lg" id="takt_time" placeholder="00" required>
										</div>
									</div>
								</div>
								<hr>
								<h4>STARTING PLAN: </h4>
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
									$startDS = "7:50 am";
									$endDS = "7:59 pm";
									$startNS = "7:50 pm";
									$endNS = "7:59 am";
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
								<div class="row justify-content-center text-center mt-4 pt-4 pb-2">
									<div class="col-lg-4">
										<button type="button" class="btn btn-lg btn-danger btn-target d-none" id="ongoingBtn">ONGOING PROCESS <br><b>[BACK]</b></button>
										<button type="submit" class="btn btn-lg btn-success btn-target d-none" id="setplanBtn">SET PLAN <b>[1]</b></button>
									</div>
									<div class="col-lg-4">
										<a href="index.php" id="menu" class="btn btn-default btn-lg btn-target" style="background-color: #5f6366;color:white;">MAIN MENU <b>[BACK]</b></a>
									</div>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include 'plugins/footer.php';
include  'plugins/js/setting_script.php';
?>