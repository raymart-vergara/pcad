<script>
	$(document).ready(function () {
		var day = '<?= get_day($server_time, $server_date_only, $server_date_only_yesterday) ?>';
		var shift = '<?= get_shift($server_time) ?>';
		sessionStorage.setItem("day", day);
		sessionStorage.setItem("shift", shift);
		document.getElementById("day").value = day;
		document.getElementById("shift").value = shift;

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

	const check_opt = () => {
		let day = sessionStorage.getItem("day");
		let shift = sessionStorage.getItem("shift");
		let opt = document.getElementsByName('opt');
		if (opt[0].checked) {
			document.getElementById("day").setAttribute('disabled', true);
			document.getElementById("shift").setAttribute('disabled', true);
			document.getElementById("day").value = day;
			document.getElementById("shift").value = shift;
		} else if (opt[1].checked) {
			document.getElementById("day").removeAttribute('disabled');
			document.getElementById("shift").removeAttribute('disabled');
			document.getElementById("day").value = '';
			document.getElementById("shift").value = '';
		}
	}
</script>
</body>

</html>