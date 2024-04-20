<script>
	$(document).ready(function () {
		if (localStorage.getItem("registlinename") !== null) {
			var registlinename = localStorage.getItem("registlinename");
			$.post('../process/pcs/dashboard_setting_p.php', {
				request: 'getLineNo',
				registlinename: registlinename
			}, function (response) {
				console.log(response);
				$("#line_no").val(response.trim());
				$("#registlinenameplan").val(registlinename);
				// After receiving the response, check if plans are running
				// checkRunningPlans();
			});
		}

		$(document).on('change', '#ircs_line', function () {
			localStorage.setItem("registlinename", $("#ircs_line").val());
			var registlinename = localStorage.getItem("registlinename");
			$.post('../process/pcs/dashboard_setting_p.php', {
				request: 'getLineNo',
				registlinename: registlinename
			}, function (response) {
				// console.log(response);
				// console.log(registlinename);
				$("#line_no").val(response.trim());
				$("#registlinenameplan").val(registlinename);
				// After receiving the response, check if plans are running
				// checkRunningPlans();
			});
		});
	});

	function getValues() {
            var registlinename = $("#registlinename").val();
            var last_takt = $("#last_takt").val();
            var added_takt_plan = $("#added_takt_plan").val();
            // console.log(registlinename);
            $.post('process/pcs/dashboard_setting_p.php', {
                request: 'getPlanLine',
                registlinename: registlinename,
                last_takt: last_takt
            }, function(response) {
                fetch_digit();
                console.log(response);

                if ($('.plan_target_value').text() != response.plan) {
                    $('.plan_target_value').addClass('reloadedLine');
                    $('.plan_target_value').css('margin-top', '-100px');

                }

                if ($('.plan_actual_value').text() != response.actual) {
                    $('.plan_actual_value').addClass('reloadedLine');
                    $('.plan_actual_value').css('margin-top', '-100px');
                }

                if ($('.plan_gap_value').text() != response.remaining) {
                    $('.plan_gap_value').addClass('reloadedLine');
                    $('.plan_gap_value').css('margin-top', '-100px');
                }

                $('.plan_target_value').text(parseInt(response.plan));
                $('.plan_actual_value').text(parseInt(response.actual));
                $('.plan_gap_value').text(response.remaining);

            });

        }

	// //Plan
	// $(document).on('keyup', '#plan', function () {
	// 	getTakt();
	// });

	// $(document).on('keyup', '#secs', function () {
	// 	getTakt();
	// });

	// function getTakt() {
	// 	var plan = $("#plan").val();
	// 	var secs = $("#secs").val();
	// 	var takt = secs / plan;
	// 	$("#takt_time").val(takt.toFixed());
	// }

	// function checkRunningPlans() {
	// 	var registlinename = localStorage.getItem("registlinename");
	// 	$.post('../process/pcs/setting_p.php', {
	// 		request: 'checkRunningPlans',
	// 		registlinename: registlinename
	// 	}, function (response) {
	// 		console.log(response);
	// 		if (response === 'true') {
	// 			$("#setplanBtn").addClass("d-none");
	// 			$("#ongoingBtn").removeClass("d-none");
	// 		} else {
	// 			$("#setplanBtn").removeClass("d-none");
	// 			$("#ongoingBtn").addClass("d-none");
	// 		}
	// 	});
	// }

	// document.addEventListener("keyup", function (ji) {
	// 	// WHEN PLAY BTN PRESS SET TARGET
	// 	if (ji.keyCode == 415 || ji.keyCode == 503 || ji.keyCode == 179) {
	// 		$('#setplanBtn').click();
	// 	}

	// 	// IF STOP BTN CLICK mAIN MENU
	// 	if (ji.keyCode == 413 || ji.keyCode == 461 || ji.keyCode == 178) {
	// 		var url = $('#menu').prop('href');
	// 		window.open(url, "_self");
	// 	}
	// 	// BACKBUTTON FOR ONGOING PROCSS
	// 	if (ji.keyCode == 461) {
	// 		$('#ongoingBtn').click();
	// 	}
	// });
</script>
</body>

</html>