<?php
include 'plugins/head.php';
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
										<select name="" id="ircsDropdown" class="form-control ml-4 fz-25" style="width: 250px">
											<option value="">- - -</option>
									
										</select>
									</td>
								</tr>
								<tr>
									<td class="text-right font-weight-bold fz-25">SELECTED LINE NO. </td>
									<td>
										<input type="text" class="ml-4 fz-25 form-control-plaintext" id="line_no">
									</td>
								</tr>
							</tbody>
						</table>
						<hr>
						<h4>SET YOUR TARGET PLAN </h4>
						<form class="pt">
							<input type="hidden" name="request" value="addTarget">
							<input type="hidden" name="registlinename" value="">
							<div class="container-fluid">
								<h4>TAKT TIME: </h4>
								<div class="row justify-content-center">
									<div class="col-lg-2 d-none">
										<div class="form-group">
											<label for="a">Hour</label>
											<input type="text" name="hrs" class="form-control" id="a" placeholder="00">
										</div>
									</div>
									<div class="col-lg-2 d-none">
										<div class="form-group">
											<label for="b">Minutes</label>
											<input type="text" name="mins" class="form-control" id="b" placeholder="00">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label>Plan</label>
											<input type="text" class="form-control form-control-lg" id="y" required autofocus="on" min="1">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label>Secs</label>
											<input type="text" class="form-control form-control-lg" id="z" required value="27000">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label for="c">TAKT TIME</label>
											<input type="text" name="secs" class="form-control form-control-lg" id="c" placeholder="00" required>
										</div>
									</div>
								</div>
								<hr>
								<h4>STARTING PLAN: </h4>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="d">TARGET PLAN</label>
											<input type="text" name="plan" class="form-control form-control-lg" id="d" placeholder="" value="0">
										</div>
									</div>


									<div class="col-lg-6">
										<div class="form-group">
											<label for="d">TIME RANGE</label>
											<input type="text" name="time_range" class="form-control form-control-lg" id="e">
										</div>
										<input type="hidden" name="time_start">
										<input type="hidden" name="time_end">
									</div>
								</div>
							</div>
						</form>
						<a href="index.php">
							<button type="button" id="btnMainMenu">MainMenu</button>
						</a>
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