<script type="text/javascript">
        $(document).ready(function () {
                get_inspection_details_good();
                get_inspection_details_no_good();
        });

        const get_inspection_details_good = () => {
                $.ajax({
                        url: 'process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_inspection_details_good'
                        },
                        success: function (response) {
                                $('#list_of_good_viewer').html(response);
                                $('#spinner').fadeOut();
                        }
                });
        }

        const get_inspection_details_no_good = () => {
                $.ajax({
                        url: 'process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_inspection_details_no_good'
                        },
                        success: function (response) {
                                $('#list_of_no_good_viewer').html(response);
                        }
                });
        }

        const get_inspection_list = () => {
                let shift_group = document.getElementById('shift_group').value;
                let registlinename = document.getElementById('registlinename').value;                
                $.ajax({
                        url: 'process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_inspection_list',
                                shift_group: shift_group,
                                registlinename: registlinename
                        },
                        success: function (response) {
                                $('#inspection_process_list').html(response);
                        }
                });
        }

        const get_overall_inspection = () => {
                let shift_group = document.getElementById('shift_group').value;
                let registlinename = document.getElementById('registlinename').value;
                $.ajax({
                        url: 'process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_overall_inspection',
                                shift_group: shift_group,
                                registlinename: registlinename
                        },
                        success: function (response) {
                                try {
                                        let response_array = JSON.parse(response);
                                        if (response_array.message == 'success') {
                                                document.getElementById('insp_overall_g').innerHTML = response_array.insp_overall_g;
                                                document.getElementById('insp_overall_ng').innerHTML = response_array.insp_overall_ng;
                                        }
                                        else {
                                                console.log(response);
                                        }
                                } catch (e) {
                                        console.log(response);
                                }
                        }
                });
        }
</script>