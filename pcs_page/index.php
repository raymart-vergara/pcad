<?php
include 'plugins/head.php';
?>
<div class="pt-4 container-fluid">
	<div class="row justify-content-center">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<div class="card"
				style="background-color: #FDFEFF; border: 2px solid #334C69; box-shadow: 0px 10px 10px 0px rgba(0, 0, 0, 0.25)">
				<h2 class="card-header" style="color:#334C69;"><b>Production Conveyor Analysis</b></h2>
				<div class="card-body">
					<div class="row">
						<!-- SETTINGS -->
						<div class="col-lg-6 col-10">
							<div class="small-box" style="background: #3195D8;">
								<div class="inner">
									<h3 style="color: #fff; font-size: 60px">[ 1 ]
									</h3>
									<p style="color: #fff; font-size: 25px">Settings
									</p>
								</div>
								<div class="icon">
									<i class="fa fa-cogs fa-4x" style="font-size: 100px;"></i>
								</div>
								<a href="setting.php" id="settingsbtn"
									class="small-box-footer" style="font-size: 18px;">Proceed &ensp;<i class="fas fa-arrow-right"></i></a>
							</div>
						</div>
						<!-- RUN COUNTER -->
						<div class="col-lg-6 col-10 ">
							<div class="small-box" style="background: #0069B0;">
								<div class="inner">
									<h3 style="color: #fff; font-size: 60px">[ 2 ]
									</h3>
									<p style="color: #fff; font-size: 25px">Run Counter
									</p>
								</div>
								<div class="icon">
									<i class="fa fa-play fa-4x" style="font-size: 100px;"></i>
								</div>
								<a href="../design_tv3.php?registlinename=registlinename"
									id="runcounterbtn"
									class="small-box-footer monitor" style="font-size: 18px;">Proceed
									&ensp;<i class="fas fa-arrow-right"></i></a>
								<!-- <a href="../index.php?registlinename=registlinename"
									id="runcounterbtn"
									class="small-box-footer monitor" style="font-size: 18px;">Proceed
									&ensp;<i class="fas fa-arrow-right"></i></a> -->
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
<script>
	window.onload = function () {
		// GETTING VALUE OF REGISTER LINE
		if (localStorage.getItem("registlinename") === null) {
			window.open("setting.php", "_self");
		}
		if (localStorage.getItem("registlinename") == "null") {
			window.open("setting.php", "_self");
		}
		// ADVANCE LISTENER
		document.addEventListener("contextmenu", function (e) {
			e.preventDefault();
		}, false);
		document.addEventListener("keypress", function (e) {
			if (e.keyCode == 49 || e.keyCode == 97) {
				window.open("setting.php", "_self");
			}
			if (e.keyCode == 50 || e.keyCode == 98) {
				var href = $(this).prop('href');
				if (localStorage.getItem("registlinename") === null) {
					window.open(href, "_self");
				} else {
					var registlinename = localStorage.getItem("registlinename");
					window.open("../design_tv3.php?registlinename=" + registlinename, "_self");
				}
			}


		});

	}
	// -----------------------------------------------------------------------------------------------------------------------------------
	$(document).ready(function () {
		if (localStorage.getItem("registlinename") === null) {
			window.open("setting.php", "_self");
		}
		if (localStorage.getItem("registlinename") == "null") {
			window.open("setting.php", "_self");
		}

		$(document).on('click', 'a.monitor', function (e) {
			e.preventDefault();
			var href = $(this).prop('href');
			if (localStorage.getItem("registlinename") === null) {
				window.open(href, "_self");
			} else {
				var registlinename = localStorage.getItem("registlinename");
				window.open("../design_tv3.php?registlinename=" + registlinename, "_self");
			}
		});
	});
</script>
</body>

</html>