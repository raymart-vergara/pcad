<script type="text/javascript">
    const andon_d_sum = () => {
        let andon_line =document.getElementById('andon_line').value
        $.ajax({
            url: 'process/andon_graph/a_graph_p.php',
            type: 'POST',
            dataType: 'json',
            cache: false, // Disable browser caching for this request
            data: {
                method: 'a_down_time',
                andon_line : andon_line
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
                let ctx = document.getElementById('hourly_chart').getContext('2d');
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
                        }
                    },
                    data: {
                        labels: machinename, // Use machine names as the primary labels
                        datasets: [{
                            label: 'Waiting Time',
                            backgroundColor: 'rgba(1, 56, 99, 1)',
                            borderColor: 'rgba(1, 56, 99, 1)',
                            borderWidth: 2,
                            data: Waiting_Time,
                            yAxisID: 'y',
                        }, {
                            label: 'Fixing Time',
                            backgroundColor: 'rgba(23, 162, 184, 0.5)',
                            borderColor: 'rgba(23, 162, 184, 1)',
                            borderWidth: 1,
                            data: Fixing_Time,
                            yAxisID: 'y',
                        }],
                    },
                };
                // Set department labels as sub-labels for each machine
                configuration.data.labels = machinename.map((machine, index) => [machine, department[index]]);
                // Destroy previous chart instance before creating a new one
                if (chart) {
                    chart.destroy();
                }
                chart = new Chart(ctx, configuration);
            },
        });
    }
</script>