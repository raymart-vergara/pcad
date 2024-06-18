<script type="text/javascript">
    let chartHourlyOutput; // Declare chart variable globally

    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById('hourly_output_date_search').value = '<?= $server_date_only ?>';
        get_hourly_output();
        // get_hourly_output_per_process();
        setInterval(get_hourly_output_per_process, 30000);
        // get_hourly_output_chart();
        setInterval(get_hourly_output_chart, 30000);
    });

    const get_hourly_output_chart = () => {
        let registlinename = localStorage.getItem("registlinename");
        let hourly_output_date = '<?= $server_date_only ?>';
        let target_output = parseInt(localStorage.getItem('target_hourly_output'));
        let opt = parseInt(localStorage.getItem("pcad_exec_opt"));

        $.ajax({
            url: '../../process/hourly_output/hourly_output_p.php',
            type: 'GET',
            dataType: 'json',
            cache: false, // Disable browser caching for this request
            data: {
                method: 'get_hourly_output_graph',
                registlinename: registlinename,
                hourly_output_date: hourly_output_date,
                opt: opt
            },
            success: function (data) {
                let hourly_output_summary = data[0];
                let hour_label = data[1];

                let ctx = document.querySelector("#hourly_output_summary_chart");

                let options = {
                    series: [{
                        name: 'Hourly Inspection Output',
                        data: hourly_output_summary
                    }],
                    chart: {
                        type: 'bar',
                        height: 400,
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
                        align: 'center',
                        margin: 20,
                        offsetX: 0,
                        offsetY: 0,
                        floating: false,
                        style: {
                            fontSize: '25px',
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

    const get_hourly_output_per_process = () => {
        let registlinename = sessionStorage.getItem('line_no_search');
        let hourly_output_date = sessionStorage.getItem('hourly_output_date_search');
        let target_output = sessionStorage.getItem('target_output_search');

        $.ajax({
            url: '../../process/hourly_output/hourly_output_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_hourly_output_per_process',
                registlinename: registlinename,
                hourly_output_date: hourly_output_date,
                target_output: target_output
            },
            success: function (response) {
                document.getElementById("hourlyOutputProcessData").innerHTML = response;
            }
        });
    }

    const get_hourly_output = () => {
        let registlinename = '';
        let shift = '';
        let target_output = '';

        let registlinename1 = document.getElementById('line_no_search').value;
        let shift1 = document.getElementById('shift_search').value;
        let target_output1 = document.getElementById('target_output_search').value;

        if (registlinename1 != '') {
            registlinename = registlinename1;
        } else {
            registlinename = localStorage.getItem("registlinename");
        }

        if (shift1 != '') {
            shift = shift1;
        } else {
            shift = localStorage.getItem("shift");
        }

        if (target_output1 != '') {
            target_output = target_output1;
        } else {
            target_output = localStorage.getItem("target_hourly_output");
        }

        let hourly_output_date = document.getElementById('hourly_output_date_search').value;

        $.ajax({
            url: '../../process/hourly_output/hourly_output_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_hourly_output',
                registlinename: registlinename,
                hourly_output_date: hourly_output_date,
                shift: shift,
                target_output: target_output
            },
            beforeSend: () => {
                var loading = `<tr id="loading"><td colspan="7" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
                document.getElementById("hourlyOutputData").innerHTML = loading;
            },
            success: function (response) {
                $('#loading').remove();
                document.getElementById("hourlyOutputData").innerHTML = response;
                sessionStorage.setItem('line_no_search', registlinename);
                sessionStorage.setItem('hourly_output_date_search', hourly_output_date);
                sessionStorage.setItem('shift_search', shift);
                sessionStorage.setItem('target_output_search', target_output);
                get_hourly_output_per_process();
                get_hourly_output_chart();
            }
        });
    }

    const export_hourly_output = () => {
        let registlinename = sessionStorage.getItem('line_no_search');
        let hourly_output_date = sessionStorage.getItem('hourly_output_date_search');
        let shift = sessionStorage.getItem('shift_search');
        let target_output = sessionStorage.getItem('target_output_search');
        window.open('../../process/export/exp_hourly_output.php?registlinename=' + registlinename + "&shift=" + shift + "&target_output=" + target_output + "&hourly_output_date=" + hourly_output_date, '_blank');
    }
</script>