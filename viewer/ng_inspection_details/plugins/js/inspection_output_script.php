<script type="text/javascript">
    let chart; //declare chart variable globally

    document.addEventListener("DOMContentLoaded", () => {
        get_inspection_details_good();
        get_inspection_details_no_good();

        get_ng_hourly_output_per_process();
        setInterval(get_ng_hourly_output_per_process, 30000);

        document.getElementById('hourly_output_date_search').value = '<?= $server_date_only ?>';

        ng_graph();
        setInterval(ng_graph, 30000);
    });

    const get_inspection_details_good = () => {
        $.ajax({
            url: '../../process/inspection_output/inspection_output_p.php',
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
            url: '../../process/inspection_output/inspection_output_p.php',
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
            url: '../../process/inspection_output/inspection_output_p.php',
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
            url: '../../process/inspection_output/inspection_output_p.php',
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

    const export_good_record_viewer = () => {
        window.open('../../process/export/exp_good_insp.php', '_blank');
    }

    const export_no_good_record_viewer = () => {
        window.open('../../process/export/exp_no_good_insp.php', '_blank');
    }

    // ===============================
    const get_ng_hourly_output_per_process = () => {
        let registlinename = sessionStorage.getItem('line_no_search');

        $.ajax({
            url: '../../process/inspection_output/inspection_output_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_ng_hourly_output_per_process',
                registlinename: registlinename
            },
            success: function (response) {
                document.getElementById("ngHourlyOutputProcessData").innerHTML = response;
            }
        });
    }
    // 

    const ng_graph = () => {
        $.ajax({
            url: '../../process/inspection_output/inspection_output_p.php',
            type: 'GET',
            cache: false,
            dataType: 'json',
            data: {
                method: 'ng_graph'
            },
            success: function (data) {
                let hourly_ng_summary = data[0];
                let hour_label = data[1];

                let barChartData = {
                    labels: hour_label,
                    datasets: [{
                        label: 'NG Output per Hour',
                        backgroundColor: 'rgba(202, 63, 63, 0.5)',
                        borderColor: 'rgba(202, 63, 63)',
                        borderWidth: 1,
                        data: hourly_ng_summary
                    }]
                };

                // Get the canvas element
                let ctx = document.getElementById('ng_summary_chart').getContext('2d');

                // Create the bar chart
                let configuration = {
                    type: 'bar',
                    data: barChartData,
                    options: {
                        scales: {
                            y: {
                                ticks: {
                                    autoSkip: false,
                                }
                            },
                            x: {
                                ticks: {
                                    autoSkip: false,
                                }
                            },
                        }
                    }
                };

                // Destroy previous chart instance before creating a new one
                if (chart) {
                    chart.destroy();
                }
                chart = new Chart(ctx, configuration);
            }

        });
    }

</script>