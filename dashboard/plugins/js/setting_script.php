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
			});
		});
	});
</script>
</body>

</html>