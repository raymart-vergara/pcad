<script type="text/javascript">
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

                        // Set localStorage for target_hourly_output
                        localStorage.setItem("target_hourly_output", response_array.target_hourly_output);

                        let gap_hourly_output_cell = document.getElementById('gap_hourly_output');
                        let gap_hourly_output = parseInt(response_array.gap_hourly_output);

                        gap_hourly_output_cell.innerHTML = response_array.gap_hourly_output;

                        if (gap_hourly_output < 0) {
                            gap_hourly_output_cell.style.backgroundColor = '#FD5A46'; //red if negative
                            gap_hourly_output_cell.style.color = 'black';
                        } else if (gap_hourly_output > 0) {
                            gap_hourly_output_cell.style.backgroundColor = '#38C578'; //green color if positive
                            gap_hourly_output_cell.style.color = 'black';
                        } else {
                            gap_hourly_output_cell.style.backgroundColor = '#38C578'; //green color if 0
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

    const get_plan_data = () => {
        let registlinename = document.getElementById('registlinename').value;
        let day = localStorage.getItem("pcad_exec_server_date_only");
        let shift = localStorage.getItem("shift");
        let opt = parseInt(localStorage.getItem("pcad_exec_opt"));

        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_plan_data',
                registlinename: registlinename,
                day: day,
                shift: shift,
                opt: opt
            },
            success: function (response) {
                try {
                    let response_array = JSON.parse(response);
                    document.getElementById('shift').value = response_array.shift;
                    document.getElementById('shift_label').innerHTML = response_array.shift;
                    document.getElementById('started').value = response_array.started;
                    document.getElementById('takt').value = response_array.takt;
                    document.getElementById('last_takt').value = response_array.last_takt;
                    document.getElementById('is_paused').value = response_array.is_paused;
                    document.getElementById('added_takt_plan').value = response_array.added_takt_plan;
                    document.getElementById('line_no').value = response_array.line_no;
                    document.getElementById('line_no_label').innerHTML = response_array.line_no;
                    document.getElementById('shift_group').value = response_array.shift_group;
                    document.getElementById('carmodel_label').innerHTML = response_array.carmodel;
                    document.getElementById('start_bal_delay').value = response_array.start_bal_delay;
                    document.getElementById('start_bal_delay_label').innerHTML = response_array.start_bal_delay;
                    document.getElementById('work_time_plan').value = response_array.work_time_plan;
                    document.getElementById('work_time_plan_label').innerHTML = response_array.work_time_plan;
                    document.getElementById('daily_plan').value = response_array.daily_plan;
                    document.getElementById('daily_plan_label').innerHTML = response_array.daily_plan;
                    document.getElementById('plan_target').innerHTML = response_array.plan_target;
                    document.getElementById('plan_actual').innerHTML = response_array.plan_actual;
                    document.getElementById('plan_gap').innerHTML = response_array.plan_gap;
                    document.getElementById('acc_eff').value = response_array.acc_eff;
                    document.getElementById('target_accounting_efficiency').innerHTML = `${response_array.acc_eff}%`;
                    document.getElementById('actual_accounting_efficiency').innerHTML = `${response_array.acc_eff_actual}%`;
                    document.getElementById('yield_target').value = response_array.yield_target;
                    document.getElementById('yield_target_label').innerHTML = `${response_array.yield_target}%`;
                    document.getElementById('actual_yield').innerHTML = `${response_array.yield_actual}%`;
                    document.getElementById('ppm_target').value = response_array.ppm_target;
                    document.getElementById('ppm_target_label').innerHTML = response_array.ppm_target_formatted;
                    document.getElementById('actual_ppm').innerHTML = response_array.ppm_actual_formatted;
                    document.getElementById('andon_line').value = response_array.andon_line;

                    // Plan

                    var plan_target_value = $('.plan_target_value');
                    plan_target_value.text(parseInt(response_array.plan_target));
                    if (parseInt(plan_target_value.text()) != response_array.plan_target) {
                        plan_target_value.addClass('reloadedLine');
                    }

                    var plan_actual_value = $('.plan_actual_value');
                    plan_actual_value.text(parseInt(response_array.plan_actual));
                    if (parseInt(plan_actual_value.text()) != response_array.plan_actual) {
                        plan_actual_value.addClass('reloadedLine');
                    }

                    var plan_gap_value = $('.plan_gap_value');
                    plan_gap_value.text(response_array.plan_gap);
                    if (parseInt(plan_gap_value.text()) < 0) {
                        plan_gap_value.css('background-color', '#FD5A46'); //red if negative
                        plan_gap_value.css('color', '#000');
                    } else if (parseInt(plan_gap_value.text()) > 0) {
                        plan_gap_value.css('background-color', '#569BE2');
                        plan_gap_value.css('color', '#000');
                    } else {
                        plan_gap_value.css('background-color', '#569BE2');
                        plan_gap_value.css('color', '#000');
                    }
                    if (parseInt(plan_gap_value.text()) != response_array.plan_gap) {
                        plan_gap_value.addClass('reloadedLine');
                    }

                    // Accounting Efficiency

                    var gap_accounting_efficiency = response_array.acc_eff_gap;
                    var gapCell = document.getElementById('gap_accounting_efficiency');
                    gapCell.innerHTML = `${gap_accounting_efficiency.toFixed(2)}%`;

                    if (gap_accounting_efficiency < 0) {
                        gapCell.style.backgroundColor = '#FD5A46'; //red if negative
                        gapCell.style.color = 'black';
                    } else if (gap_accounting_efficiency > 0) {
                        gapCell.style.backgroundColor = '#F6DB7F'; //yellow color if positive
                        gapCell.style.color = 'black';
                    } else {
                        gapCell.style.backgroundColor = '#F6DB7F'; //yellow color if 0
                        gapCell.style.color = 'black';
                    }
                } catch (e) {
                    console.log(response);
                }
            }
        });
    }

    const set_plan_data_format = () => {

        // Plan

        var plan_gap_value = $('.plan_gap_value');
        if (parseInt(plan_gap_value.text()) < 0) {
            plan_gap_value.css('background-color', '#FD5A46'); //red if negative
            plan_gap_value.css('color', '#000');
        } else if (parseInt(plan_gap_value.text()) > 0) {
            plan_gap_value.css('background-color', '#569BE2');
            plan_gap_value.css('color', '#000');
        } else {
            plan_gap_value.css('background-color', '#569BE2');
            plan_gap_value.css('color', '#000');
        }

        // Accounting Efficiency

        var gap_accounting_efficiency = parseFloat(document.getElementById('gap_accounting_efficiency').innerHTML);
        var gapCell = document.getElementById('gap_accounting_efficiency');

        if (gap_accounting_efficiency < 0) {
            gapCell.style.backgroundColor = '#FD5A46'; //red if negative
            gapCell.style.color = 'black';
        } else if (gap_accounting_efficiency > 0) {
            gapCell.style.backgroundColor = '#F6DB7F'; //yellow color if positive
            gapCell.style.color = 'black';
        } else {
            gapCell.style.backgroundColor = '#F6DB7F'; //yellow color if 0
            gapCell.style.color = 'black';
        }
    }

    const export_plan_data_pending = () => {
        let registlinename = document.getElementById('registlinename').value;
        window.open('process/export/exp_plan_data_pending.php?registlinename=' + registlinename, '_blank');
    }
</script>