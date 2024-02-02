<!DOCTYPE html>
<html class=''>
<head>
<meta charset='UTF-8'>
<meta name="viewport" content="width=device-width, initial-scale=1" http-equiv="refresh">

<link rel="stylesheet" href="dist/css/font.css">
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="dist/css/adminlte.min.css">
<link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
<title>PCAD</title>
<style type="text/css">
	a:hover{
		text-decoration: none;
	}
	h5{
		font-family: arial;
	}
	b{
		color:black;
	}
	@font-face{
		src: url('fonts/Montserrat-Medium.ttf');
		font-family:montserrat;
	}
	body{
		font-family:montserrat;
		zoom:90%;

	}
	b{
		color:#1167b1;
	}

</style>
</head>
<body class="">
<div class="pt-4 container-fluid">
	<div class="row justify-content-center">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<div class="card " style="background-color: white;border: 1px solid #2a9df4;box-shadow:5px 10px gray;min-height:100vh;">
				<h5 class="card-header" style="color:#4d6d9a;">
					<!-- <img src="img/icon.png" width="50" height="50" alt="" style="border-radius:30px;"> -->
					Production Conveyor Analysis Dashboard
				</h5>
				<div class="card-body">
					<div class="col-md-12 pb-4">
						<h2 class="text-center title-header" style="color:#86b3d1;">MAIN MENU</h2>
					</div>
					<div class="row">
						<div class="col-md-6">
							<a href="linelist.php?list=line" class="monitor">
								<div class="card main-5" style="background-color:#86b3d1;">
									<div class="card-body text-center">
										<div class="col-md-12">
											<i class="fa fa-search fa-4x"></i>
											<p>Run Counter <b>[ 1 ]</b></p>
										</div>
									</div>
								</div>
							</a>
						</div>

						<div class="col-md-6 mb-4">
							<a href="linelist.php?list=plan" class="plan">
								<div class="card main-5" style="background-color:#99ced3">
									<div class="card-body text-center">
										<div class="col-md-12">
											<i class="fa fa-bullseye fa-4x"></i>
											<p>Set Target Plan <b>[ 2 ]</b></p>
										</div>
									</div>
								</div>
							</a>
						</div>
                        

					</div>
					<!-- SECOND ROW  -->
					<!-- <div class="row"> -->
						<!-- SETTINGS -->
						<div class="col-md-6">
							<a href="settings.php">
								<div class="card main-5" style="background-color:#edb5bf;">
									<div class="card-body text-center">
										<div class="col-md-12">
											<i class="fa fa-cogs fa-4x"></i>
											<p>Settings <b>[ 3 ]</b></p>
										</div>
									</div>
								</div>
							</a>
						</div>
						<!-- HOME -->
						<!-- <div class="col-md-6">
							<a href="../index.php" id="home_btn">
								<div class="card main-5" style="background-color:#212930;">
									<div class="card-body text-center">
										<div class="col-md-12">
											<i class="fa fa-home fa-4x"></i>
											<p>Home <b style="color:white;">[ 4 ]</b></p>
										</div>
									</div>
								</div>
							</a>
						</div> -->
					<!-- </div> -->


				</div>
			</div>
		</div>
	</div>
</div>

 <?php
	// include 'src/script.php';
?> -
<!-- <script>
	window.onload = function(){
		// GETTING VALUE OF REGISTER LINE
		if (localStorage.getItem("registlinename") === null) {
			window.open("settings.php","_self");
		}
			if (localStorage.getItem("registlinename") == "null") {
				window.open("settings.php","_self");
			}
		// ADVANCE LISTENER
		document.addEventListener("contextmenu",function(e){
			e.preventDefault();
		},false);
		document.addEventListener("keypress",function(e){
			if(e.keyCode == 49 || e.keyCode == 97){
				var href = $(this).prop('href');
				if (localStorage.getItem("registlinename") === null) {
					window.open(href,"_self");
				}else{
				  	var registlinename = localStorage.getItem("registlinename");
					window.open("line.php?registlinename="+registlinename,"_self");
				}
			}
			if(e.keyCode == 50 || e.keyCode == 98){
				var href = $(this).prop('href');
				if(localStorage.getItem("registlinename") === null){
					window.open(href,"_self");
				}else{
					var registlinename = localStorage.getItem("registlinename");
					window.open("plan.php?registlinename="+registlinename,"_self");
				}
			}
			if(e.keyCode == 51 || e.keyCode == 99){
				window.open("settings.php","_self");
			}
			// HOME
			if(e.keyCode == 52 || e.keyCode == 100){
				document.querySelector('#home_btn').click();
			}
		});

	}
	// -----------------------------------------------------------------------------------------------------------------------------------
	$(document).ready(function(){
		if (localStorage.getItem("registlinename") === null) {
			window.open("settings.php","_self");
		}
		if (localStorage.getItem("registlinename") == "null") {
			window.open("settings.php","_self");
		}

		$(document).on('click', 'a.monitor', function(e){
			e.preventDefault();
			var href = $(this).prop('href');
			if (localStorage.getItem("registlinename") === null) {
				window.open(href,"_self");
			}else{
			  	var registlinename = localStorage.getItem("registlinename");
				window.open("line.php?registlinename="+registlinename,"_self");
			}
		});
		$(document).on('click', 'a.plan', function(e){
			e.preventDefault();
			var href = $(this).prop('href');
			if (localStorage.getItem("registlinename") === null) {
				window.open(href,"_self");
			}else{
			  	var registlinename = localStorage.getItem("registlinename");
				window.open("plan.php?registlinename="+registlinename,"_self");
			}
		});
	});
</script> -->
</body>
</html>