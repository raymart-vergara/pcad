<script type="text/javascript">
    const andon_hourly_graph = () => {
        let andon_line = localStorage.getItem("andon_line");

        $.ajax({
            url: 'process/andon_graph/a_hourly_p.php',
            type: 'GET',
            dataType: 'json',
            cache: false,
            data: {
                method: 'andon_hourly',
                andon_line: andon_line
            },
            success: function (data) {
                let countsData = data[0];
                let hourLabels = data[1];

                // Map the counts to align with the hour labels
                let total_counts = hourLabels.map(hour => countsData[hour]);

                let andonChartData = {
                    labels: hourLabels,
                    datasets: [{
                        label: 'Andon Hourly Count',
                        backgroundColor: 'rgba(1, 56, 99, 1)',
                        borderWidth: 2,
                        data: total_counts,
                        yAxisID: 'y-axis-0',
                    }],
                }

                let ctx = document.getElementById('andon_hourly_chart').getContext('2d');

                let configuration = {
                    type: 'bar',
                    data: andonChartData,
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    maxTicksLimit: 5,
                                    fontSize: 17,
                                    beginAtZero: true,
                                    // stepSize: 5,
                                    callback: function (value, index, values) {
                                        return parseInt(value);
                                    }
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'pcs per hour',
                                    fontSize: 15,
                                    fontFamily: 'Montserrat',
                                    fontStyle: 'normal',
                                }
                            }],
                            xAxes: [{
                                stacked: true,
                                ticks: {
                                    fontSize: 17,
                                    autoSkip: false,
                                },
                                gridLines: {
                                    display: false,
                                },
                            }],
                        },
                        layout: {
                            padding: 20
                        },
                        plugins: {
                            annotation: {
                                annotations: {
                                    line1: {
                                        type: 'line',
                                        mode: 'vertical',
                                        scaleID: 'x-axis-0',
                                        value: 17.5,
                                        borderColor: 'red',
                                        borderWidth: 2,
                                    }
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Hourly Andon Count',
                            fontSize: 30,
                            fontFamily: 'Montserrat',
                            align: 'center',
                        },
                    }
                };


                // Destroy previous chart instance before creating a new one
                if (chartAndonHourly) {
                    chartAndonHourly.destroy();
                }
                chartAndonHourly = new Chart(ctx, configuration);
            }
        });
    }

    // version 3.9.1
    // const andon_hourly_graph = () => {
    //     let andon_line = localStorage.getItem("andon_line");

    //     $.ajax({
    //         url: 'process/andon_graph/a_hourly_p.php',
    //         type: 'GET',
    //         dataType: 'json',
    //         cache: false,
    //         data: {
    //             method: 'andon_hourly',
    //             andon_line: andon_line
    //         },
    //         success: function (data) {
    //             let total_counts = data[0];
    //             let hour_starts = data[1];

    //             let ctx = document.getElementById('andon_hourly_chart').getContext('2d');

    //             let configuration = {
    //                 type: 'bar',
    //                 options: {
    // plugins: {
    //     annotation: {
    //         annotations: {
    //             line1: {
    //                 type: 'line',
    //                 xMin: "|",
    //                 xMax: "|",
    //                 borderColor: 'rgb(255, 193, 7)',
    //                 borderWidth: 2,
    //             }
    //         }
    //     },
    //                         title: {
    //                             display: true,
    //                             text: 'Hourly Andon Count',
    //                             font: {
    //                                 size: 30,
    //                                 family: 'Montserrat',
    //                             },
    //                             align: 'center',
    //                         }
    //                     },
    //                     scales: {
    //                         y: {
    //                             stacked: true,
    //                             ticks: {
    //                                 autoSkip: false,
    //                                 font: {
    //                                     size: 17
    //                                 },
    //                                 callback: function (value, index, values) {
    //                                     // Check if the value is a whole number
    //                                     if (value % 1 === 0) {
    //                                         // Return the whole number without decimal point
    //                                         return value;
    //                                     } else {
    //                                         // Return an empty string for non-whole numbers
    //                                         return '';
    //                                     }
    //                                 },
    //                             },
    //                             title: {
    //                                 display: true,
    //                                 text: 'pcs per hour',
    //                                 font: {
    //                                     size: 15,
    //                                     family: 'Montserrat',
    //                                     weight: 'normal'
    //                                 },
    //                             }
    //                         },
    //                         x: {
    //                             stacked: true,
    //                             ticks: {
    //                                 autoSkip: false,
    //                                 font: {
    //                                     size: 17
    //                                 },
    //                             },
    //                             grid: {
    //                                 display: false,
    //                             },
    //                         },
    //                     },
    //                     layout: {
    //                         padding: 20
    //                     }
    //                 },
    //                 data: {
    //                     labels: hour_starts, // Use hour starts as labels
    //                     datasets: [{
    //                         label: 'Andon Hourly Count',
    //                         backgroundColor: 'rgba(1, 56, 99, 1)',
    //                         borderWidth: 2,
    //                         data: total_counts, // Use total counts as data
    //                         yAxisID: 'y',
    //                     }],
    //                 },
    //             };

    //             // Destroy previous chart instance before creating a new one
    //             if (chartAndonHourly) {
    //                 chartAndonHourly.destroy();
    //             }
    //             chartAndonHourly = new Chart(ctx, configuration);
    //         }
    //     });
    // }

    const get_hourly_output_chart = () => {
        let registlinename = localStorage.getItem("registlinename");
        let hourly_output_date = '<?= $server_date_only ?>';
        let target_output = parseInt(localStorage.getItem('target_hourly_output'));

        $.ajax({
            url: 'process/hourly_output/hourly_output_p.php',
            type: 'GET',
            dataType: 'json',
            cache: false,
            data: {
                method: 'get_hourly_output_graph',
                registlinename: registlinename,
                hourly_output_date: hourly_output_date
            },
            success: function (data) {
                let hourly_output_summary_count = data[0];
                let hour_label = data[1];

                let hourly_output_summary = hour_label.map(hour => hourly_output_summary_count[hour])

                let hourlyChartData = {
                    labels: hour_label,
                    datasets: [{
                        label: 'Hourly Inspection Output',
                        backgroundColor: 'rgba(11, 143, 80, 1)',
                        borderWidth: 1,
                        data: hourly_output_summary,
                        yAxisID: 'y-axis-0',
                    }],
                }

                let ctx = document.getElementById('hourly_output_summary_chart').getContext('2d');

                let configuration = {
                    type: 'bar',
                    data: hourlyChartData,
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    maxTicksLimit: 5,
                                    fontSize: 17,
                                    beginAtZero: true,
                                    // stepSize: 5,
                                    callback: function (value, index, values) {
                                        return parseInt(value);
                                    }
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'pcs per hour',
                                    fontSize: 15,
                                    fontFamily: 'Montserrat',
                                    fontStyle: 'normal',
                                }
                            }],
                            xAxes: [{
                                stacked: true,
                                ticks: {
                                    autoSkip: false,
                                    fontSize: 17,
                                },
                                gridLines: {
                                    display: false,
                                },
                            }],
                        },
                        layout: {
                            padding: 20
                        },
                        plugins: {
                            // datalabels: {
                            //     display: true,
                            //     anchor: 'top', 
                            //     align: 'center', 
                            //     color: '#fff', 
                            //     font: {
                            //         weight: 'bold'
                            //     }
                            // },
                            annotation: {
                                annotations: {
                                    line1: {
                                        type: 'line',
                                        mode: 'horizontal',
                                        scaleID: 'y-axis-0',
                                        value: target_output,
                                        borderColor: 'rgb(255, 99, 132)',
                                        borderWidth: 2,
                                    },
                                    line2: {
                                        type: 'line',
                                        mode: 'vertical',
                                        scaleID: 'x-axis-0',
                                        value: '|',
                                        borderColor: 'rgb(255, 193, 7)',
                                        borderWidth: 2,
                                    }
                                }
                            },
                        },
                        title: {
                            display: true,
                            text: 'Hourly Inspection Output',
                            fontSize: 30,
                            fontFamily: 'Montserrat',
                            fontWeight: 'normal',
                            align: 'center',
                        },
                    },
                };

                // Destroy previous chart instance before creating a new one
                if (chartHourlyOutput) {
                    chartHourlyOutput.destroy();
                }
                chartHourlyOutput = new Chart(ctx, configuration);
            },
        });
    }

    // version 3.9.1
    // const get_hourly_output_chart = () => {
    //     // let registlinename = sessionStorage.getItem('line_no_search');
    //     let registlinename = localStorage.getItem("registlinename");
    //     let hourly_output_date = '<?= $server_date_only ?>';
    //     let target_output = parseInt(localStorage.getItem('target_hourly_output'));

    //     $.ajax({
    //         url: 'process/hourly_output/hourly_output_p.php',
    //         type: 'GET',
    //         dataType: 'json',
    //         cache: false, // Disable browser caching for this request
    //         data: {
    //             method: 'get_hourly_output_graph',
    //             registlinename: registlinename,
    //             hourly_output_date: hourly_output_date
    //         },
    //         success: function (data) {
    //             let hourly_output_summary = data[0];
    //             let hour_label = data[1];

    //             let ctx = document.getElementById('hourly_output_summary_chart').getContext('2d');

    //             let configuration = {
    //                 type: 'bar',
    //                 options: {
    //                     scales: {
    //                         y: {
    //                             stacked: true,
    //                             ticks: {
    //                                 autoSkip: false,
    //                                 font: {
    //                                     size: 17
    //                                 },
    //                                 callback: function (value, index, values) {
    //                                     // Check if the value is a whole number
    //                                     if (value % 1 === 0) {
    //                                         // Return the whole number without decimal point
    //                                         return value;
    //                                     } else {
    //                                         // Return an empty string for non-whole numbers
    //                                         return '';
    //                                     }
    //                                 },
    //                             },
    //                             title: {
    //                                 display: true,
    //                                 text: 'pcs per hour',
    //                                 font: {
    //                                     size: 15,
    //                                     family: 'Montserrat',
    //                                     weight: 'normal'
    //                                 },
    //                             }
    //                         },
    //                         x: {
    //                             stacked: true,
    //                             ticks: {
    //                                 autoSkip: false,
    //                                 font: {
    //                                     size: 17
    //                                 },
    //                             },
    //                             grid: {
    //                                 display: false,
    //                             },
    //                         },
    //                     },
    //                     layout: {
    //                         padding: 20
    //                     },
    //                     // Add annotation here
    //                     plugins: {
    //                         annotation: {
    //                             annotations: {
    //                                 line1: {
    //                                     type: 'line',
    //                                     yMin: target_output,
    //                                     yMax: target_output,
    //                                     borderColor: 'rgb(255, 99, 132)',
    //                                     borderWidth: 2,
    //                                 },
    //                                 line2: {
    //                                     type: 'line',
    //                                     xMin: "|",
    //                                     xMax: "|",
    //                                     borderColor: 'rgb(255, 193, 7)',
    //                                     borderWidth: 2,
    //                                 }
    //                             }
    //                         },
    //                         title: {
    //                             display: true,
    //                             text: 'Hourly Inspection Output',
    //                             font: {
    //                                 size: 30,
    //                                 family: 'Montserrat',
    //                                 weight: 'normal'
    //                             },
    //                             align: 'center',
    //                         },
    //                     }
    //                 },
    //                 data: {
    //                     labels: hour_label, // Use machine names as the primary labels
    //                     datasets: [{
    //                         label: 'Hourly Inspection Output',
    //                         backgroundColor: 'rgba(11, 143, 80, 1)',
    //                         borderWidth: 1,
    //                         data: hourly_output_summary,
    //                         yAxisID: 'y',
    //                     }],
    //                 },
    //             };

    //             // Destroy previous chart instance before creating a new one
    //             if (chartHourlyOutput) {
    //                 chartHourlyOutput.destroy();
    //             }
    //             chartHourlyOutput = new Chart(ctx, configuration);
    //         },
    //     });
    // }

    const ng_graph = () => {
        let registlinename = localStorage.getItem("registlinename");

        $.ajax({
            url: 'process/inspection_output/inspection_output_p.php',
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
                        label: 'Defect Hourly',
                        backgroundColor: 'rgba(202, 63, 63, 1)',
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
                            yAxes: [{
                                ticks: {
                                    maxTicksLimit: 5,
                                    fontSize: 17,
                                    beginAtZero: true,
                                    // stepSize: 5,
                                    callback: function (value, index, values) {
                                        return parseInt(value);
                                    }
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'pcs per hour',
                                    fontSize: 15,
                                    fontFamily: 'Montserrat',
                                    fontStyle: 'normal'
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    autoSkip: false,
                                    fontSize: 17
                                },
                                gridLines: {
                                    display: false
                                }
                            }]
                        },
                        layout: {
                            padding: 20
                        },
                        plugins: {
                            // datalabels: {
                            //     display: true,
                            //     anchor: 'top',
                            //     align: 'center',
                            //     color: '#fff',
                            //     font: {
                            //         weight: 'bold'
                            //     }
                            // },
                            annotation: {
                                annotations: {
                                    line1: {
                                        type: 'line',
                                        mode: 'horizontal',
                                        scaleID: 'y-axis-0',
                                        value: 0,
                                        borderColor: 'rgb(255, 193, 7)',
                                        borderWidth: 2,
                                    }
                                }
                            },
                        },
                        title: {
                            display: true,
                            text: 'Defect Hourly',
                            fontSize: 30,
                            fontFamily: 'Montserrat',
                            fontStyle: 'normal',
                            textAlign: 'center'
                        },
                    }
                };

                // Destroy previous chart instance before creating a new one
                if (chartNGhourly) {
                    chartNGhourly.destroy();
                }
                chartNGhourly = new Chart(ctx, configuration);
            }
        });
    }


    // version 3.9.1
    // const ng_graph = () => {
    //     let registlinename = localStorage.getItem("registlinename");

    //     $.ajax({
    //         url: 'process/inspection_output/inspection_output_p.php',
    //         type: 'GET',
    //         cache: false,
    //         dataType: 'json',
    //         data: {
    //             method: 'ng_graph',
    //             registlinename: registlinename
    //         },
    //         success: function (data) {
    //             let hourly_ng_summary = data[0];
    //             let hour_label = data[1];

    //             let barChartData = {
    //                 labels: hour_label,
    //                 datasets: [{
    //                     label: 'Defect Hourly',
    //                     backgroundColor: 'rgba(202, 63, 63, 1)',
    //                     borderWidth: 1,
    //                     data: hourly_ng_summary
    //                 }]
    //             };

    //             // Get the canvas element
    //             let ctx = document.getElementById('ng_summary_chart').getContext('2d');

    //             // Create the bar chart
    //             let configuration = {
    //                 type: 'bar',
    //                 data: barChartData,
    //                 options: {
    //                     scales: {
    //                         y: {
    //                             ticks: {
    //                                 autoSkip: false,
    //                                 font: {
    //                                     size: 17
    //                                 },
    //                             },
    //                             title: {
    //                                 display: true,
    //                                 text: 'pcs per hour',
    //                                 font: {
    //                                     size: 15,
    //                                     family: 'Montserrat',
    //                                     weight: 'normal'
    //                                 },
    //                             }
    //                         },
    //                         x: {
    //                             ticks: {
    //                                 autoSkip: false,
    //                                 font: {
    //                                     size: 17
    //                                 },
    //                             },
    //                             grid: {
    //                                 display: false,
    //                             },
    //                         },
    //                     },
    //                     layout: {
    //                         padding: 20
    //                     },
    //                     plugins: {
    //                         annotation: {
    //                             annotations: {
    //                                 line1: {
    //                                     type: 'line',
    //                                     xMin: "|",
    //                                     xMax: "|",
    //                                     borderColor: 'rgb(255, 193, 7)',
    //                                     borderWidth: 2,
    //                                 }
    //                             }
    //                         },
    //                         title: {
    //                             display: true,
    //                             text: 'Defect Hourly',
    //                             font: {
    //                                 size: 30,
    //                                 family: 'Montserrat',
    //                                 weight: 'normal'
    //                             },
    //                             align: 'center',
    //                         },
    //                     }
    //                 }
    //             };

    //             // Destroy previous chart instance before creating a new one
    //             if (chartNGhourly) {
    //                 chartNGhourly.destroy();
    //             }
    //             chartNGhourly = new Chart(ctx, configuration);
    //         }

    //     });
    // }
</script>