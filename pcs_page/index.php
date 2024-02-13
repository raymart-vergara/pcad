<?php
include 'plugins/head.php';
?>
<div class="pt-4 container-fluid">
	<div class="row justify-content-center">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<div class="card" style="background-color: white;border: 1px solid #2a9df4;box-shadow:5px 10px gray;min-height:8vh;">
				<h5 class="card-header" style="color:#4d6d9a;">
					Production Conveyor Analysis
				</h5>
				<div class="card-body">
					<div class="row">
						<!-- SETTINGS -->
						<div class="col-lg-6 col-10 ">
							<div class="small-box bg-info">
								<div class="inner">
									<h3>[ 1 ]</h3>
									<p>Settings</p>
								</div>
								<div class="icon">
								<i class="fa fa-cogs fa-4x"></i>
								</div>
								<a href="setting.php" class="small-box-footer">Proceed<i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<!-- RUN COUNTER -->
						<div class="col-lg-6 col-10 ">
							<div class="small-box bg-primary">
								<div class="inner">
									<h3>[ 2 ]</h3>
									<p>Run Counter</p>
								</div>
								<div class="icon">
								<i class="fa fa-play fa-4x"></i>
								</div>
								<a href="../index.php?line_no=$line_no" class="small-box-footer">Proceed<i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include 'plugins/footer.php';
?>
