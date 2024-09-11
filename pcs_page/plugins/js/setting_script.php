<script>
	const split_registlinename = registlinename => {
		const myArray = registlinename.split("-");
		return myArray[0];
	}

	const split_line_no = registlinename => {
		const myArray = registlinename.split("-");
		return myArray[1];
	}

	$(document).ready(function () {
		if (localStorage.getItem("registlinename") !== null) {
			var registlinename = localStorage.getItem("registlinename");
			var line_no = localStorage.getItem("pcad_line_no");
			$("#line_no").val(line_no);
			$("#registlinenameplan").val(registlinename);
			// After receiving the response, check if plans are running
			checkRunningPlans();
		}

		$(document).on('change', '#ircs_line', function () {
			localStorage.setItem("registlinename", split_registlinename($("#ircs_line").val()));
			localStorage.setItem("pcad_line_no", split_line_no($("#ircs_line").val()));
			var registlinename = localStorage.getItem("registlinename");
			var line_no = localStorage.getItem("pcad_line_no");
			$("#line_no").val(line_no);
			$("#registlinenameplan").val(registlinename);
			// After receiving the response, check if plans are running
			checkRunningPlans();
		});
	});

	//Plan
	$(document).on('keyup', '#plan', function () {
		getTakt();
	});

	$(document).on('keyup', '#secs', function () {
		getTakt();
	});

	function getTakt() {
		var plan = $("#plan").val();
		var secs = $("#secs").val();
		var takt = secs / plan;
		$("#takt_time").val(takt.toFixed());
	}

	function checkRunningPlans() {
		var registlinename = localStorage.getItem("registlinename");
		var line_no = localStorage.getItem("pcad_line_no");
		$.post('../process/pcs/setting_p.php', {
			request: 'checkRunningPlans',
			registlinename: registlinename,
			line_no: line_no
		}, function (response) {
			console.log(response);
			if (response === 'true') {
				$("#setplanBtn").addClass("d-none");
				$("#ongoingBtn").removeClass("d-none");
			} else {
				$("#setplanBtn").removeClass("d-none");
				$("#ongoingBtn").addClass("d-none");
			}
		});
	}

	document.addEventListener("keyup", function (ji) {
		// WHEN PLAY BTN PRESS SET TARGET
		if (ji.keyCode == 415 || ji.keyCode == 503 || ji.keyCode == 179) {
			$('#setplanBtn').click();
		}

		// IF STOP BTN CLICK mAIN MENU
		if (ji.keyCode == 413 || ji.keyCode == 461 || ji.keyCode == 178) {
			var url = $('#menu').prop('href');
			window.open(url, "_self");
		}
		// BACKBUTTON FOR ONGOING PROCSS
		if (ji.keyCode == 461) {
			$('#ongoingBtn').click();
		}
	});
</script>
</body>

</html>