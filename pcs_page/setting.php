<?php
    include 'plugins/head.php';
?>

<div class="pt-4 container-fluid">
	<div class="row justify-content-center">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<div class="card " style="background-color: white;border: 1px solid #2a9df4;box-shadow:5px 10px gray;">
				<h5 class="card-header" style="color:#4d6d9a;">
					Production Conveyor Analysis
				</h5>
				<div class="card-body">
					<div class="col-lg-12 pb-2">
									<table>
										<tbody>
											<tr>
												<td class="text-right font-weight-bold fz-25">Select Line no.</td>
												<td>
													<select name="" id="a" class="form-control ml-4 fz-25" style="width: 250px">
														<option value="">- - -</option>
													</select>
												</td>
											</tr>
											<tr>
												<td class="text-right font-weight-bold fz-25">Selected Line No.</td>
												<td>
													<input type="text" readonly class="ml-4 fz-25 form-control-plaintext" id="b">
												</td>
											</tr>
										</tbody>
									</table>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<?php
	include 'plugins/script.php';
?>
</body>
</html>