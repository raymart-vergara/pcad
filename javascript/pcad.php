<script type="text/javascript">
    const get_accounting_efficiency = () => {
        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_accounting_efficiency'
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
                document.getElementById('actual_hourly_output').innerHTML = response;
            }
        });
    }

    const get_yield = () => {
        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_yield'
            },
            success: function (response) {
                document.getElementById('actual_yield').innerHTML = response;
            }
        });
    }

    const get_ppm = () => {
        $.ajax({
            url: 'process/pcad/pcad_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_ppm'
            },
            success: function (response) {
                document.getElementById('actual_ppm').innerHTML = response;
            }
        });
    }
</script>