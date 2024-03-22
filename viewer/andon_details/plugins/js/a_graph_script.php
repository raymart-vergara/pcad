<script type="text/javascript">
    let chart; // Declare chart variable globally

    $(document).ready(function () {
        andon_detail();
        setInterval(andon_detail, 30000);

        andon_hourly();
        setInterval(andon_hourly, 30000);
    });

    const andon_detail = () =>{
        let andon_line ='DAIHATSU D92-2132'
        $.ajax({
            url: '../../process/andon_graph/a_graph_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'andon_detail',
                andon_line:andon_line
            }, success: function (response) {
                $('#andon_details').html(response);
            }
        });
    }

    const andon_hourly = () => {
        // let andon_line = document.getElementById('andon_line').value

        $.ajax({
            url: '../../process/andon_graph/a_hourly_p.php',
            type: 'GET',
            dataType: 'json',
            cache: false,
            data: {
                method: 'andon_hourly',
                // andon_line: andon_line
            },
            success: function (data) {
                let total_counts = data[0];
                let hour_starts = data[1];

                let ctx = document.getElementById('andon_hourly_chart').getContext('2d');

                let configuration = {
                    type: 'bar',
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Hourly Andon Events Count',
                                font: {
                                    size: 30,
                                    family: 'Montserrat',
                                },
                            }
                        },
                        scales: {
                            y: {
                                stacked: true,
                                ticks: {
                                    autoSkip: false,
                                    font: {
                                        size: 17
                                    },
                                }
                            },
                            x: {
                                stacked: true,
                                ticks: {
                                    autoSkip: false,
                                    font: {
                                        size: 17
                                    },
                                }
                            },
                        },
                        layout: {
                            padding: 15
                        }
                    },
                    data: {
                        labels: hour_starts, // Use hour starts as labels
                        datasets: [{
                            label: 'Total Andon Events',
                            backgroundColor: 'rgba(1, 56, 99, 1)',
                            borderColor: 'rgba(1, 56, 99, 1)',
                            borderWidth: 2,
                            data: total_counts, // Use total counts as data
                            yAxisID: 'y',
                        }],
                    },
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
