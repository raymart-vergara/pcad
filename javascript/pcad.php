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
                document.getElementById('acc_eff_actual').value = response;

                var actual_accounting_efficiency = parseFloat(response);
                var gap_accounting_efficiency = (((actual_accounting_efficiency / 100) - (target_accounting_efficiency / 100)) * 100)
                // document.getElementById('gap_accounting_efficiency').innerHTML = `${gap_accounting_efficiency.toFixed(2)}%`;

                var gapCell = document.getElementById('gap_accounting_efficiency');
                gapCell.innerHTML = `${gap_accounting_efficiency.toFixed(2)}%`;

                if (gap_accounting_efficiency < 0) {
                    gapCell.style.backgroundColor = '#FD5A46'; //red if negative
                    gapCell.style.color = 'black';
                } else if (gap_accounting_efficiency > 0) {
                    gapCell.style.backgroundColor = '#FFD445'; //yellow color if positive
                    gapCell.style.color = 'black';
                } else {
                    gapCell.style.backgroundColor = '#FFD445'; //yellow color if 0
                    gapCell.style.color = 'black';
                }
            }
        });
    }

    const get_hourly_output = () => {
        let shift_group = document.getElementById('shift_group').value;
        let registlinename = document.getElementById('registlinename').value;
        let line_no = document.getElementById('line_no').value;
        let takt = document.getElementById('takt').value;
        let working_time = document.getElementById('work_time_plan').value;
        let day = localStorage.getItem("pcad_prod_server_date_only");
        let shift = localStorage.getItem("shift");

        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_hourly_output',
                shift_group: shift_group,
                registlinename: registlinename,
                line_no: line_no,
                takt: takt,
                working_time: working_time,
                day: day,
                shift: shift,
                opt: 1
            },
            success: function (response) {
                try {
                    let response_array = JSON.parse(response);
                    if (response_array.message == 'success') {
                        document.getElementById('target_hourly_output').innerHTML = response_array.target_hourly_output;
                        document.getElementById('actual_hourly_output').innerHTML = response_array.actual_hourly_output;

                        // Set localStorage for target_hourly_output
                        localStorage.setItem("target_hourly_output", response_array.target_hourly_output);

                        let gap_hourly_output_cell = document.getElementById('gap_hourly_output');
                        let gap_hourly_output = parseInt(response_array.gap_hourly_output);

                        gap_hourly_output_cell.innerHTML = response_array.gap_hourly_output;

                        if (gap_hourly_output < 0) {
                            gap_hourly_output_cell.style.backgroundColor = '#FD5A46'; //red if negative
                            gap_hourly_output_cell.style.color = 'black';
                        } else if (gap_hourly_output > 0) {
                            gap_hourly_output_cell.style.backgroundColor = '#50A363'; //green color if positive
                            gap_hourly_output_cell.style.color = 'black';
                        } else {
                            gap_hourly_output_cell.style.backgroundColor = '#50A363'; //green color if 0
                            gap_hourly_output_cell.style.color = 'black';
                        }
                    } else {
                        console.log(response);
                    }
                } catch (e) {
                    console.log('Error parsing response:', e);
                    console.log('Response:', response);
                }
            }
        });
    }

    const get_yield = () => {
        let shift_group = document.getElementById('shift_group').value;
        let registlinename = document.getElementById('registlinename').value;
        let line_no = document.getElementById('line_no').value;
        let day = localStorage.getItem("pcad_prod_server_date_only");
        let shift = localStorage.getItem("shift");

        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_yield',
                shift_group: shift_group,
                registlinename: registlinename,
                line_no: line_no,
                day: day,
                shift: shift,
                opt: 1
            },
            success: function (response) {
                document.getElementById('actual_yield').innerHTML = `${response}%`;
                document.getElementById('yield_actual').value = response;
            }
        });
    }

    const get_ppm = () => {
        let shift_group = document.getElementById('shift_group').value;
        let registlinename = document.getElementById('registlinename').value;
        let line_no = document.getElementById('line_no').value;
        let day = localStorage.getItem("pcad_prod_server_date_only");
        let shift = localStorage.getItem("shift");

        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_ppm',
                shift_group: shift_group,
                registlinename: registlinename,
                line_no: line_no,
                day: day,
                shift: shift,
                opt: 1
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