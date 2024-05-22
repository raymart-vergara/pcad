<script type="text/javascript">
    const andon_detail = () => {
        let andon_line = document.getElementById('andon_line').value
        $.ajax({
            url: '../process/andon_graph/a_graph_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'andon_detail',
                andon_line: andon_line
            }, success: function (response) {
                $('#andon_details').html(response);
            }
        });
    }

    const andon_d_sum = () => {
        let andon_line = document.getElementById('andon_line').value
        $.ajax({
            url: 'process/andon_graph/a_graph_p.php',
            type: 'POST',
            dataType: 'json',
            cache: false, // Disable browser caching for this request
            data: {
                method: 'a_down_time',
                andon_line: andon_line
            },
            success: function (data) {
                let department = [];
                let machinename = [];
                let Waiting_Time = [];
                let Fixing_Time = [];
                let Total_DT = [];
                for (let i = 0; i < data.length; i++) {
                    department.push(data[i].department);
                    machinename.push(data[i].machinename);
                    Waiting_Time.push(data[i].Waiting_Time);
                    Fixing_Time.push(data[i].Fixing_Time);
                    Total_DT.push(data[i].Total_DT);
                }
                let ctx = document.querySelector("#hourly_chart");

                let options = {
                    series: [{
                        name: 'Waiting Time',
                        data: Waiting_Time
                    }, {
                        name: 'Fixing Time',
                        data: Fixing_Time
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        stacked: true,
                        toolbar: {
                            show: true
                        },
                        zoom: {
                            enabled: true
                        }
                    },
                    colors:['rgba(1, 56, 99, 1)', 'rgba(23, 162, 184, 1)'],
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
                                        fontFamily: 'Montserrat',
                                        fontWeight: 'normal',
                                        colors: ['rgba(0, 0, 0, 1)']
                                    }
                                }
                            }
                        },
                    },
                    xaxis: {
                        type: 'string',
                        categories: machinename,
                        title: {
                            text: 'Machine - Department',
                            align: 'center',
                            margin: 50,
                            offsetX: 0,
                            offsetY: 0,
                            floating: false,
                            style: {
                                fontSize:  '15px',
                                fontWeight:  'normal',
                                fontFamily:  'Montserrat'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Minutes',
                            align: 'center',
                            margin: 50,
                            offsetX: 0,
                            offsetY: 0,
                            floating: false,
                            style: {
                                fontSize:  '15px',
                                fontWeight:  'normal',
                                fontFamily:  'Montserrat'
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
                        text: 'DT / Delay / Andon',
                        align: 'center',
                        margin: 30,
                        offsetX: 0,
                        offsetY: 0,
                        floating: false,
                        style: {
                            fontSize:  '25px',
                            fontWeight:  'bold',
                            fontFamily:  'Montserrat'
                        }
                    }
                };

                // Set department labels as sub-labels for each machine
                options.xaxis.categories = machinename.map((machine, index) => [machine, department[index]]);
        
                // Destroy previous chart instance before creating a new one
                if (chart) {
                    chart.destroy();
                }
                chart = new ApexCharts(ctx, options);
                chart.render();
            },
        });
    }
</script>