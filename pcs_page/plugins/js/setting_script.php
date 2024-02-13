<script>
	$(document).ready(function() {
		if (localStorage.getItem("registlinename") !== null) {
			var registlinename = localStorage.getItem("registlinename");
			$.post('../process/pcs/setting_p.php', {
				request: 'getLineNo',
				registlinename: registlinename
			}, function(response) {
				console.log(response);
				console.log(registlinename);
				$("#line_no").val(response.trim());
				$("#registlinenameplan").val(registlinename);
				// After receiving the response, check if plans are running
				checkRunningPlans();
			});
		}
	});

	function checkRunningPlans() {
		var registlinename = localStorage.getItem("registlinename");
		$.post('../process/pcs/setting_p.php', {
			request: 'checkRunningPlans',
			registlinename: registlinename
		}, function(response) {
			console.log(response);
			if (response === 'true') {
				// If running plans are found, update $running to true
				$("#setplanBtn").hide();
				$("#ongoingBtn").show();
			} else {
				// If no running plans are found, update $running to false
				$("#setplanBtn").show();
				$("#ongoingBtn").hide();
			}
		});
	}


	$(document).on('change', '#ircs_line', function() {
		localStorage.setItem("registlinename", $("#ircs_line").val());
		var registlinename = localStorage.getItem("registlinename");
		$.post('../process/pcs/setting_p.php', {
			request: 'getLineNo',
			registlinename: registlinename
		}, function(response) {
			console.log(response);
			console.log(registlinename);
			$("#line_no").val(response.trim());
			$("#registlinenameplan").val(registlinename);
			// After receiving the response, check if plans are running
			checkRunningPlans();
		});
	});

	//Plan
	$(document).on('keyup', '#plan', function() {
		getTakt();
	});

	$(document).on('keyup', '#secs', function() {
		getTakt();
	});

	function getTakt() {
		var plan = $("#plan").val();
		var secs = $("#secs").val();
		var takt = secs / plan;
		$("#takt_time").val(takt.toFixed());

	}
</script>
</body>

</html> -