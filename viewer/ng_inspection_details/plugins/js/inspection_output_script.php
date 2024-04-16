<script type="text/javascript">
    let chart; //declare chart variable globally

    document.addEventListener("DOMContentLoaded", () => {
        get_inspection_details_no_good();

        get_ng_hourly_output_per_process();
        setInterval(get_ng_hourly_output_per_process, 30000);

        ng_graph();
        setInterval(ng_graph, 30000);
    });

    const get_inspection_details_no_good = () => {
        let registlinename = localStorage.getItem("registlinename");

        $.ajax({
            url: '../../process/inspection_output/inspection_output_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_inspection_details_no_good',
                registlinename: registlinename
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

    const export_no_good_record_viewer = () => {
        let registlinename = localStorage.getItem("registlinename");
        window.open('../../process/export/exp_no_good_insp.php?registlinename=' + registlinename, '_blank');
    }

    // ===============================
    const get_ng_hourly_output_per_process = () => {
        let registlinename = localStorage.getItem("registlinename");

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
        let registlinename = localStorage.getItem("registlinename");

        $.ajax({
            url: '../../process/inspection_output/inspection_output_p.php',
            type: 'GET',
            cache: false,
            dataType: 'json',
            data: {
                method: 'ng_graph',
                registlinename: registlinename
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