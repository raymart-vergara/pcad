<script type="text/javascript">
    let chartNGhourly; //declare chart variable globally

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

                let ctx = document.querySelector("#ng_summary_chart");

                let options = {
                    series: [{
                        name: 'Defect Hourly',
                        data: hourly_ng_summary
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
                        align: 'center',
                        margin: 15,
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
                if (chartNGhourly) {
                    chartNGhourly.destroy();
                }
                chartNGhourly = new ApexCharts(ctx, options);
                chartNGhourly.render();
            }

        });
    }
</script>