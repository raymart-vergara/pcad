<script type="text/javascript">
        $(document).ready(function () {
                get_inspection_details_good();
                get_inspection_details_no_good();
        });

        const get_inspection_details_good = () => {
                $.ajax({
                        url: '../process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_inspection_details_good'
                        },
                        success: function (response) {
                                // Inject the HTML directly into the table
                                $('#inspection_good_table').html(response);

                                // Initialize DataTable
                                $('#inspection_good_table').DataTable({
                                        "scrollX": true
                                });
                                $('.dataTables_length').addClass('bs-select');
                        }
                });
        }

        const get_inspection_details_no_good = () => {
                $.ajax({
                        url: '../process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_inspection_details_no_good'
                        },
                        success: function (response) {
                                // Inject the HTML directly into the table
                                $('#inspection_no_good_table').html(response);

                                // Initialize DataTable
                                $('#inspection_no_good_table').DataTable({
                                        "scrollX": true
                                });
                                $('.dataTables_length').addClass('bs-select');
                        }
                });
        }

        const get_inspection_list = () => {
                $.ajax({
                        url: '../process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_inspection_list'
                        },
                        success: function (response) {
                                $('#inspection_process_list').html(response);
                                $('#spinner').fadeOut();
                        }
                })
        }


        const get_overall_inspection = () => {
                $.ajax({
                        url: '../process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_overall_inspection'
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

        const get_specific_inspection_good = () => {
                $.ajax({
                        url: '../process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_specific_inspection_good'
                        },
                        success: function (response) {
                                try {
                                        let response_array = JSON.parse(response);
                                        if (response_array.message === 'success') {
                                                const getElementById = (id) => document.getElementById(id);

                                                getElementById('dimension_p_g').innerHTML = response_array.dimension_p_g;
                                                getElementById('electric_p_g').innerHTML = response_array.electric_p_g;
                                                getElementById('visual_p_g').innerHTML = response_array.visual_p_g;
                                                getElementById('assurance_p_g').innerHTML = response_array.assurance_p_g;
                                        } else {
                                                console.error('Unexpected response:', response);
                                        }
                                } catch (e) {
                                        console.error('Error parsing JSON:', e);
                                        console.log('Actual response:', response);
                                }
                        }
                });
        };

        const get_specific_inspection_no_good = () => {
                $.ajax({
                        url: '../process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_specific_inspection_no_good',
                        },
                        success: function (response) {
                                try {
                                        let response_array = JSON.parse(response);
                                        if (response_array.message === 'success') {
                                                const getElementById = (id) => document.getElementById(id);

                                                getElementById('dimension_p_ng').innerHTML = response_array.dimension_p_ng;
                                                getElementById('electric_p_ng').innerHTML = response_array.electric_p_ng;
                                                getElementById('visual_p_ng').innerHTML = response_array.visual_p_ng;
                                                getElementById('assurance_p_ng').innerHTML = response_array.assurance_p_ng;
                                        } else {
                                                console.error('Unexpected response:', response);
                                        }
                                } catch (e) {
                                        console.error('Error parsing JSON:', e);
                                        console.log('Actual response:', response);
                                }
                        }
                });
        };
</script>