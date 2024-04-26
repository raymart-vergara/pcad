<script type="text/javascript">
    const get_accounting_efficiency = () => {
        let line_no = document.getElementById('line_no').value;
        let shift_group = document.getElementById('shift_group').value;
        let registlinename = document.getElementById('registlinename').value;
        let target_accounting_efficiency = parseInt(document.getElementById('acc_eff').value);
        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_accounting_efficiency',
                shift_group: shift_group,
                registlinename: registlinename,
                line_no: line_no
            },
            success: function (response) {
                document.getElementById('actual_accounting_efficiency').innerHTML = `${response}%`;

                var actual_accounting_efficiency = parseFloat(response);
                var gap_accounting_efficiency = (((target_accounting_efficiency / 100) - (actual_accounting_efficiency / 100)) * 100)
                document.getElementById('gap_accounting_efficiency').innerHTML = `${gap_accounting_efficiency.toFixed(2)}%`;
            }
        });
    }

    const get_hourly_output = () => {
        let shift_group = document.getElementById('shift_group').value;
        let registlinename = document.getElementById('registlinename').value;
        let takt = document.getElementById('takt').value;
        let working_time = document.getElementById('work_time_plan').value;
        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_hourly_output',
                shift_group: shift_group,
                registlinename: registlinename,
                takt: takt,
                working_time: working_time
            },
            success: function (response) {
                try {
                    let response_array = JSON.parse(response);
                    if (response_array.message == 'success') {
                        document.getElementById('target_hourly_output').innerHTML = response_array.target_hourly_output;
                        document.getElementById('actual_hourly_output').innerHTML = response_array.actual_hourly_output;
                        document.getElementById('gap_hourly_output').innerHTML = response_array.gap_hourly_output;
                        // Set LocalStorage for these variables
                        localStorage.setItem("target_hourly_output", response_array.target_hourly_output);
                    } else {
                        console.log(response);
                    }
                } catch (e) {
                    console.log(response);
                }
            }
        });
    }

    const get_yield = () => {
        let shift_group = document.getElementById('shift_group').value;
        let registlinename = document.getElementById('registlinename').value;
        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_yield',
                shift_group: shift_group,
                registlinename: registlinename
            },
            success: function (response) {
                document.getElementById('actual_yield').innerHTML = `${response}%`;
            }
        });
    }

    const get_ppm = () => {
        let shift_group = document.getElementById('shift_group').value;
        let registlinename = document.getElementById('registlinename').value;
        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_ppm',
                shift_group: shift_group,
                registlinename: registlinename
            },
            success: function (response) {
                try {
                    let response_array = JSON.parse(response);
                    document.getElementById('actual_ppm').innerHTML = response_array.ppm_formatted;
                    document.getElementById('ppm_actual').value = response_array.ppm;
                } catch (e) {
                    console.log(response);
                }
            }
        });
    }
</script>