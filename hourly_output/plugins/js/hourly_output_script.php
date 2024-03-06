<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById('hourly_output_date_search').value = '<?= $server_date_only ?>';
    });

    const get_hourly_output = () => {
        let registlinename = document.getElementById('line_no_search').value;
        let hourly_output_date = document.getElementById('hourly_output_date_search').value;
        let shift = document.getElementById('shift_search').value;
        let target_output = document.getElementById('target_output_search').value;

        $.ajax({
            url: '../process/hourly_output/hourly_output_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_hourly_output',
                registlinename: registlinename,
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
        })
    }

    const export_hourly_output = () => {
        let registlinename = sessionStorage.getItem('line_no_search');
        let hourly_output_date = sessionStorage.getItem('hourly_output_date_search');
        let shift = sessionStorage.getItem('shift_search');
        let target_output = sessionStorage.getItem('target_output_search');
        window.open('../process/export/exp_hourly_output.php?registlinename=' + registlinename + "&shift=" + shift + "&target_output=" + target_output + "&hourly_output_date=" + hourly_output_date, '_blank');
    }
</script>