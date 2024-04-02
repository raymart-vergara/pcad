<script type="text/javascript">
    const andon_hourly_graph = () => {
        // let andon_line = document.getElementById('andon_line').value

        $.ajax({
            url: 'process/andon_graph/a_hourly_p.php',
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

    const get_hourly_output_chart = () => {
        let registlinename = sessionStorage.getItem('line_no_search');
        let hourly_output_date = sessionStorage.getItem('hourly_output_date_search');
        let target_output = parseInt(sessionStorage.getItem('target_output_search'));

        $.ajax({
            url: 'process/hourly_output/hourly_output_p.php',
            type: 'GET',
            dataType: 'json',
            cache: false, // Disable browser caching for this request
            data: {
                method: 'get_hourly_output_graph',
                registlinename: registlinename,
                hourly_output_date: hourly_output_date
            },
            success: function (data) {
                let hourly_output_summary = data[0];
                let hour_label = data[1];

                let ctx = document.getElementById('hourly_output_summary_chart').getContext('2d');

                let configuration = {
                    type: 'bar',
                    options: {
                        scales: {
                            y: {
                                stacked: true,
                                ticks: {
                                    autoSkip: false,
                                }
                            },
                            x: {
                                stacked: true,
                                ticks: {
                                    autoSkip: false,
                                }
                            },
                        },
                        // Add annotation here
                        plugins: {
                            annotation: {
                                annotations: {
                                    line1: {
                                        type: 'line',
                                        yMin: target_output,
                                        yMax: target_output,
                                        borderColor: 'rgb(255, 99, 132)',
                                        borderWidth: 2,
                                    }
                                }
                            }
                        }
                    },
                    data: {
                        labels: hour_label, // Use machine names as the primary labels
                        datasets: [{
                            label: 'Hourly Output',
                            backgroundColor: 'rgba(23, 162, 184, 0.5)',
                            borderColor: 'rgba(23, 162, 184, 1)',
                            borderWidth: 1,
                            data: hourly_output_summary,
                            yAxisID: 'y',
                        }],
                    },
                };

                // Destroy previous chart instance before creating a new one
                if (chart) {
                    chart.destroy();
                }
                chart = new Chart(ctx, configuration);
            },
        });
    }

    const ng_graph = () => {
        $.ajax({
            url: 'process/inspection_output/inspection_output_p.php',
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