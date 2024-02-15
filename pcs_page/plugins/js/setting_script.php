<script>
	$(document).ready(function() {
		if (localStorage.getItem("registlinename") !== null) {
			var registlinename = localStorage.getItem("registlinename");
			$.post('../process/pcs/setting_p.php', {
				request: 'getLineNo',
				registlinename: registlinename
			}, function(response) {
				console.log(response);
				$("#line_no").val(response.trim());
				$("#andon_line").val(response.trim());
				$("#registlinenameplan").val(registlinename);
				// After receiving the response, check if plans are running
				checkRunningPlans();
			});
		}
	

	function validateAndCheckRunningPlans() {
    var ircsLine = document.getElementById("ircs_line").value;
    var plan = document.getElementById("plan").value;
    var taktTime = document.getElementById("takt_time").value;

    // Check the status of registlinename
    var registlinename = localStorage.getItem("registlinename");
    $.post('../process/pcs/setting_p.php', {
        request: 'checkRunningPlans',
        registlinename: registlinename
    }, function(response) {
        console.log(response);
        if (response === 'true') {
            // If registlinename is pending or ongoing, show the ongoing button
            $("#setplanBtn").addClass("d-none");
            $("#ongoingBtn").removeClass("d-none");
        } else {
            // If registlinename is not pending or ongoing, check if plan, takt time, and target plan are filled
            if (ircsLine !== "" && plan !== "" && taktTime !== "") {
                // If all required fields are filled, show the ongoing button
                $("#setplanBtn").addClass("d-none");
                $("#ongoingBtn").removeClass("d-none");
            } else {
                // If any required field is empty, show the set plan button
                $("#setplanBtn").removeClass("d-none");
                $("#ongoingBtn").addClass("d-none");
            }
        }
    });
}

// Call validateAndCheckRunningPlans on input events
document.getElementById("ircs_line").addEventListener("change", validateAndCheckRunningPlans);
document.getElementById("plan").addEventListener("input", validateAndCheckRunningPlans);
document.getElementById("takt_time").addEventListener("input", validateAndCheckRunningPlans);

	// Function to check running plans
	function checkRunningPlans() {
		var registlinename = localStorage.getItem("registlinename");
		$.post('../process/pcs/setting_p.php', {
			request: 'checkRunningPlans',
			registlinename: registlinename
		}, function(response) {
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

	$(document).on('change', '#ircs_line', function() {
		localStorage.setItem("registlinename", $("#ircs_line").val());
		var registlinename = localStorage.getItem("registlinename");
		$.post('../process/pcs/setting_p.php', {
			request: 'getLineNo',
			registlinename: registlinename
		}, function(response) {
			// console.log(response);
			// console.log(registlinename);
			$("#line_no").val(response.trim());
			$("#registlinenameplan").val(registlinename);
			// After receiving the response, check if plans are running
			checkRunningPlans();
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
});

});

</script>
</body>

</html> -