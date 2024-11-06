<script type="text/javascript">
    let chartAndonHourly; // Declare chart variable globally

    $(document).ready(function () {
        andon_detail();
        setInterval(andon_detail, 30000);

        andon_hourly();
        setInterval(andon_hourly, 30000);
    });

    const andon_detail = () => {
        let andon_line = localStorage.getItem("andon_line");
        let server_date_only = localStorage.getItem("pcad_exec_server_date_only");
        let shift = localStorage.getItem("shift");
        let opt = parseInt(localStorage.getItem("pcad_exec_opt"));

        $.ajax({
            url: '../../process/andon_graph/a_graph_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'andon_detail',
                andon_line: andon_line,
                server_date_only: server_date_only,
                shift: shift,
                opt: opt
            }, success: function (response) {
                $('#andon_details').html(response);
            }
        });
    }

    const andon_hourly = () => {
        let andon_line = localStorage.getItem("andon_line");
        let opt = parseInt(localStorage.getItem("pcad_exec_opt"));
        let server_date_only = localStorage.getItem("pcad_exec_server_date_only");

        $.ajax({
            url: '../../process/andon_graph/a_hourly_p.php',
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
                    series: [{
                        name: 'Andon Hourly Count',
                        data: total_counts
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

    const export_andon = () => {
        let andon_line = localStorage.getItem("andon_line");
        let server_date_only = localStorage.getItem("pcad_exec_server_date_only");
        let shift = localStorage.getItem("shift");
        let opt = parseInt(localStorage.getItem("pcad_exec_opt"));
        window.open('../../process/andon_graph/andon_export_p.php?andon_line=' + andon_line + "&shift=" + shift + "&server_date_only=" + server_date_only + "&opt=" + opt, '_blank');
    }
</script>