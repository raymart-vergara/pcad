<script type="text/javascript">
    const get_accounting_efficiency = () => {
        let line_no = document.getElementById('line_no').value;
        let shift_group = document.getElementById('shift_group').value;
        let registlinename = document.getElementById('registlinename').value;
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
            }
        });
    }

    const get_hourly_output = () => {
        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_hourly_output'
            },
            success: function (response) {
                document.getElementById('target_hourly_output').innerHTML = response;
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
                document.getElementById('actual_ppm').innerHTML = response;
            }
        });
    }
</script>