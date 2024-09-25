<script type="text/javascript">
    const andon_hourly_graph = () => {
        let andon_line = localStorage.getItem("andon_line");
        let opt = parseInt(localStorage.getItem("pcad_exec_opt"));
        let server_date_only = localStorage.getItem("pcad_exec_server_date_only");

        $.ajax({
            url: 'process/andon_graph/a_hourly_p.php',
            type: 'GET',
            dataType: 'json',
            cache: false,
            data: {
                method: 'andon_hourly',
                andon_line: andon_line,
                opt: opt,
                server_date_only: server_date_only
            },
            success: function (data) {
                let total_counts = data[0];
                let hour_starts = data[1];

                let ctx = document.querySelector("#andon_hourly_chart");

                let options = {
                    responsive: true,
                    maintainAspectRatio: false,
                    series: [{
                        name: 'Andon Hourly Count',
                        data: total_counts
                    }],
                    chart: {
                        type: 'bar',
                        height: 300,
                        stacked: true,
                        toolbar: {
                            show: true
                        },
                        zoom: {
                            enabled: true
                        }
                    },
                    colors: ['rgba(1, 56, 99, 1)'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom',
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            borderRadius: 10,
                            borderRadiusApplication: 'end', // 'around', 'end'
                            borderRadiusWhenStacked: 'last', // 'all', 'last'
                            dataLabels: {
                                total: {
                                    enabled: true,
                                    style: {
                                        fontSize: '15px',
                                        fontFamily: 'Poppins',
                                        fontWeight: 400
                                    }
                                }
                            }
                        },
                    },
                    xaxis: {
                        categories: hour_starts,
                        title: {
                            text: 'Hour',
                            align: 'center',
                            margin: 15,
                            offsetX: 0,
                            offsetY: 0,
                            floating: false,
                            style: {
                                fontSize: '15px',
                                fontWeight: 'normal',
                                fontFamily: 'Poppins'
                            }
                        },
                        labels: {
                            style: {
                                fontSize: '15px',
                                fontFamily: 'Poppins',
                                fontWeight: 'normal'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'pcs per hour',
                            align: 'center',
                            margin: 15,
                            offsetX: 0,
                            offsetY: 0,
                            floating: false,
                            style: {
                                fontSize: '15px',
                                fontWeight: 'normal',
                                fontFamily: 'Poppins'
                            }
                        },
                        labels: {
                            style: {
                                fontSize: '15px',
                                fontFamily: 'Poppins',
                                fontWeight: 'normal'
                            }
                        }
                    },
                    legend: {
                        position: 'top'
                    },
                    fill: {
                        opacity: 1
                    },
                    title: {
                        text: 'Hourly Andon Count',
                        align: 'left',
                        margin: 55,
                        offsetX: 0,
                        offsetY: 0,
                        floating: false,
                        style: {
                            fontSize: '20px',
                            fontFamily: 'Poppins'
                        }
                    },
                    annotations: {
                        xaxis: [
                            {
                                x: '|',
                                borderColor: 'rgb(0, 0, 0)'
                            }
                        ]
                    }
                };

                // Destroy previous chart instance before creating a new one
                if (chartAndonHourly) {
                    chartAndonHourly.destroy();
                }
                chartAndonHourly = new ApexCharts(ctx, options);
                chartAndonHourly.render();
            }
        });
    }

    const get_hourly_output_chart = () => {
        let registlinename = localStorage.getItem("registlinename");
        let line_no = localStorage.getItem("pcad_line_no");
        let hourly_output_date = localStorage.getItem("pcad_exec_server_date_only");
        let target_output = parseInt(localStorage.getItem('target_hourly_output'));
        let opt = parseInt(localStorage.getItem("pcad_exec_opt"));

        $.ajax({
            url: 'process/hourly_output/hourly_output_p.php',
            type: 'GET',
            dataType: 'json',
            cache: false, // Disable browser caching for this request
            data: {
                method: 'get_hourly_output_graph',
                registlinename: registlinename,
                line_no: line_no,
                hourly_output_date: hourly_output_date,
                opt: opt
            },
            success: function (data) {
                let hourly_output_summary = data[0];
                let hour_label = data[1];

                let ctx = document.querySelector("#hourly_output_summary_chart");

                let options = {
                    responsive: true,
                    maintainAspectRatio: false,
                    series: [{
                        name: 'Hourly Inspection Output',
                        data: hourly_output_summary
                    }],
                    chart: {
                        type: 'bar',
                        height: 300,
                        stacked: true,
                        toolbar: {
                            show: true
                        },
                        zoom: {
                            enabled: true
                        }
                    },
                    colors: ['rgba(11, 143, 80, 1)'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom',
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            borderRadius: 10,
                            borderRadiusApplication: 'end', // 'around', 'end'
                            borderRadiusWhenStacked: 'last', // 'all', 'last'
                            dataLabels: {
                                total: {
                                    enabled: true,
                                    style: {
                                        fontSize: '15px',
                                        fontFamily: 'Poppins',
                                        fontWeight: 400
                                    }
                                }
                            }
                        },
                    },
                    xaxis: {
                        categories: hour_label,
                        title: {
                            text: 'Hour',
                            align: 'center',
                            margin: 15,
                            offsetX: 0,
                            offsetY: 0,
                            floating: false,
                            style: {
                                fontSize: '15px',
                                fontWeight: 'normal',
                                fontFamily: 'Poppins'
                            }
                        },
                        labels: {
                            style: {
                                fontSize: '15px',
                                fontFamily: 'Poppins',
                                fontWeight: 'normal'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'pcs per hour',
                            align: 'center',
                            margin: 15,
                            offsetX: 0,
                            offsetY: 0,
                            floating: false,
                            style: {
                                fontSize: '15px',
                                fontWeight: 'normal',
                                fontFamily: 'Poppins'
                            }
                        },
                        labels: {
                            style: {
                                fontSize: '15px',
                                fontFamily: 'Poppins',
                                fontWeight: 'normal'
                            }
                        }
                    },
                    legend: {
                        position: 'top'
                    },
                    fill: {
                        opacity: 1
                    },
                    title: {
                        text: 'Hourly Inspection Output',
                        align: 'left',
                        margin: 15,
                        offsetX: 0,
                        offsetY: 0,
                        floating: false,
                        style: {
                            fontSize: '20px',
                            fontFamily: 'Poppins'
                        }
                    },
                    annotations: {}
                };

                // Get Max Value from an array
                let max = hourly_output_summary.reduce((a, b) => Math.max(a, b), -Infinity);

                if (max >= target_output) {
                    options.annotations = {
                        xaxis: [
                            {
                                x: '|',
                                borderColor: 'rgb(0, 0, 0)'
                            }
                        ],
                        yaxis: [
                            {
                                y: target_output,
                                borderColor: 'rgb(0, 0, 0)'
                            }
                        ]
                    };
                } else {
                    options.annotations = {
                        xaxis: [
                            {
                                x: '|',
                                borderColor: 'rgb(0, 0, 0)'
                            }
                        ]
                    };
                }

                // Destroy previous chart instance before creating a new one
                if (chartHourlyOutput) {
                    chartHourlyOutput.destroy();
                }
                chartHourlyOutput = new ApexCharts(ctx, options);
                chartHourlyOutput.render();
            },
        });
    }

    const ng_graph = () => {
        let registlinename = localStorage.getItem("registlinename");
        let line_no = localStorage.getItem("pcad_line_no");
        let server_date_only = localStorage.getItem("pcad_exec_server_date_only");
        let opt = parseInt(localStorage.getItem("pcad_exec_opt"));

        $.ajax({
            url: 'process/inspection_output/inspection_output_p.php',
            type: 'GET',
            cache: false,
            dataType: 'json',
            data: {
                method: 'ng_graph',
                registlinename: registlinename,
                line_no: line_no,
                server_date_only: server_date_only,
                opt: opt
            },
            success: function (data) {
                let hourly_ng_summary = data[0];
                let hour_label = data[1];

                let ctx = document.querySelector("#ng_summary_chart");

                let options = {
                    responsive: true,
                    maintainAspectRatio: false,
                    series: [{
                        name: 'Defect Hourly',
                        data: hourly_ng_summary
                    }],
                    chart: {
                        type: 'bar',
                        height: 300,
                        stacked: true,
                        toolbar: {
                            show: true
                        },
                        zoom: {
                            enabled: true
                        }
                    },
                    colors: ['rgba(202, 63, 63, 1)'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom',
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            borderRadius: 10,
                            borderRadiusApplication: 'end', // 'around', 'end'
                            borderRadiusWhenStacked: 'last', // 'all', 'last'
                            dataLabels: {
                                total: {
                                    enabled: true,
                                    style: {
                                        fontSize: '15px',
                                        fontFamily: 'Poppins',
                                        fontWeight: 400
                                    }
                                }
                            }
                        },
                    },
                    xaxis: {
                        categories: hour_label,
                        title: {
                            text: 'Hour',
                            align: 'center',
                            margin: 15,
                            offsetX: 0,
                            offsetY: 0,
                            floating: false,
                            style: {
                                fontSize: '15px',
                                fontWeight: 'normal',
                                fontFamily: 'Poppins'
                            }
                        },
                        labels: {
                            style: {
                                fontSize: '15px',
                                fontFamily: 'Poppins',
                                fontWeight: 'normal'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'pcs per hour',
                            align: 'center',
                            margin: 15,
                            offsetX: 0,
                            offsetY: 0,
                            floating: false,
                            style: {
                                fontSize: '15px',
                                fontWeight: 'normal',
                                fontFamily: 'Poppins'
                            }
                        },
                        labels: {
                            style: {
                                fontSize: '15px',
                                fontFamily: 'Poppins',
                                fontWeight: 'normal'
                            }
                        }
                    },
                    legend: {
                        position: 'top'
                    },
                    fill: {
                        opacity: 1
                    },
                    title: {
                        text: 'Defect Hourly',
                        align: 'left',
                        margin: 15,
                        offsetX: 0,
                        offsetY: 0,
                        floating: false,
                        style: {
                            fontSize: '20px',
                            fontFamily: 'Poppins'
                        }
                    },
                    annotations: {
                        xaxis: [
                            {
                                x: '|',
                                borderColor: 'rgb(0, 0, 0)'
                            }
                        ]
                    }
                };

                // Destroy previous chart instance before creating a new one
                if (chartNGhourly) {
                    chartNGhourly.destroy();
                }
                chartNGhourly = new ApexCharts(ctx, options);
                chartNGhourly.render();
            }

        });
    }
</script>