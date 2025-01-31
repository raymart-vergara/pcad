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
		var day = '<?= get_day($server_time, $server_date_only, $server_date_only_yesterday) ?>';
		var shift = '<?= get_shift($server_time) ?>';
		sessionStorage.setItem("day", day);
		sessionStorage.setItem("shift", shift);
		document.getElementById("day").value = day;
		document.getElementById("shift").value = shift;

		if (localStorage.getItem("registlinename") !== null) {
			var line_no = localStorage.getItem("pcad_line_no");
			var registlinename = localStorage.getItem("registlinename");
			$("#line_no").val(line_no);
			$("#registlinenameplan").val(registlinename);
		}

		$(document).on('change', '#ircs_line', function () {
			localStorage.setItem("registlinename", split_registlinename($("#ircs_line").val()));
			localStorage.setItem("pcad_line_no", split_line_no($("#ircs_line").val()));
			var registlinename = localStorage.getItem("registlinename");
			var line_no = localStorage.getItem("pcad_line_no");
			$("#line_no").val(line_no);
			$("#registlinenameplan").val(registlinename);
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