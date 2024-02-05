<?php
include 'plugins/head.php';
include '../process/conn/pcad.php';

$ircs_lines = array();
$q = "SELECT * FROM m_ircs_line ORDER BY ircs_line ASC";
$ircs_lines = $conn_pcad->query($q)->fetchAll(PDO::FETCH_ASSOC);

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
										<select name="" id="a" class="form-control ml-4 fz-25" style="width: 250px">
											<option value="">- - -</option>
		 									<?php
											if ($ircs_lines) {
												foreach ($ircs_lines as $i => $ircs) {
													echo '<option value=' . $ircs['ircs_line'] . '>' . $ircs['ircs_line'] . ' (' . $ircs['line_no'] . ')</option>';
												}
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td class="text-right font-weight-bold fz-25">SELECTED LINE NO. </td>
									<td>
										<input type="text"  class="ml-4 fz-25 form-control-plaintext" id="b">
									</td>
								</tr>
							
								</tr>
							</tbody>
						</table>
				
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include 'plugins/footer.php';
include 'plugins/js/setting_script.php'
?>
