<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        // get_hourly_output();
    });

    const get_hourly_output = () => {
        let registlinename = '';
        let shift = '';
        let target_output = '';

        let registlinename1 = document.getElementById('line_no_search').value;
        let shift1 = document.getElementById('shift_search').value;
        let target_output1 = document.getElementById('target_output_search').value;

        if (registlinename1 != '') {
            registlinename = registlinename1;
        } else {
            registlinename = localStorage.getItem("registlinename");
        }

        if (shift1 != '') {
            shift = shift1;
        } else {
            shift = localStorage.getItem("shift");
        }

        if (target_output1 != '') {
            target_output = target_output1;
        } else {
            target_output = localStorage.getItem("target_hourly_output");
        }

        let hourly_output_date = document.getElementById('hourly_output_date_search').value;

        let line_no = localStorage.getItem("pcad_line_no");

        $.ajax({
            url: '../process/hourly_output/hourly_output_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_hourly_output',
                registlinename: registlinename,
                line_no: line_no,
                hourly_output_date: hourly_output_date,
                shift: shift,
                target_output: target_output
            },
            beforeSend: () => {
                var loading = `<tr id="loading"><td colspan="7" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
                document.getElementById("hourlyOutputData").innerHTML = loading;
            },
            success: function (response) {
                $('#loading').remove();
                document.getElementById("hourlyOutputData").innerHTML = response;
                sessionStorage.setItem('line_no_search', registlinename);
                sessionStorage.setItem('hourly_output_date_search', hourly_output_date);
                sessionStorage.setItem('shift_search', shift);
                sessionStorage.setItem('target_output_search', target_output);
            }
        });
    }

    const export_hourly_output = () => {
        let registlinename = sessionStorage.getItem('line_no_search');
        let line_no = localStorage.getItem("pcad_line_no");
        let hourly_output_date = sessionStorage.getItem('hourly_output_date_search');
        let shift = sessionStorage.getItem('shift_search');
        let target_output = sessionStorage.getItem('target_output_search');
        window.open('../process/export/exp_hourly_output.php?registlinename=' + registlinename + '&line_no=' + line_no + "&shift=" + shift + "&target_output=" + target_output + "&hourly_output_date=" + hourly_output_date, '_blank');
    }
</script>