<?php include 'process/server_date_time.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PCAD - ST</title>

    <link rel="icon" href="dist/img/logo.ico" type="image/x-icon" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="dist/css/font.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="plugins/ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="plugins/sweetalert2/dist/sweetalert2.min.css">
  
</head>

<body>
    <div class="container-fluid">
        <div class="flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/logo.webp" alt="logo" height="60" width="60"><span
                class="h5">PCAD<span>
        </div>
    </div>
    <div class="container-fluid">
        <h1 class='text-center'>Production Conveyor Analysis Dashboard</h1>
        <div class="col-12">
            <div class="card card-primary card-outline shadow">
                <div class="card-body">
                    <div class="row">
                        <p class="card-text col-6">
                            <label for="">Line No. <span> 0143</span></label>
                            <br>
                            <label for="">Shift <span> DS</span></label>
                        </p>
                        <p class="card-text col-6">
                            <label for="">Date: <span>
                                    <?= $server_date_only ?>
                                </span></label>
                            <br>
                            <label for="">Group <span>6</span></label>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- ================== LEFT SIDE========================= -->
            <div class="col-6">
                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Target</th>
                                        <th scope="col">Actual</th>
                                        <th scope="col">Gap</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Plan</th>
                                        <td>100</td>
                                        <td>10</td>
                                        <td>90</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Accounting Efficiency</th>
                                        <td>200</td>
                                        <td>20</td>
                                        <td>180</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Hourly Output</th>
                                        <td>300</td>
                                        <td>30</td>
                                        <td>270</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- ========================================================= -->
                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body">
                            <h5>Starting Balance Delay <span class="mx-5">1234</span></h5>
                            <div class="row">
                                <div class="col-4 table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">PD MP</th>
                                                <td>100</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Actual</th>
                                                <td>200</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-4">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">Plan</th>
                                                <td>100</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Absent</th>
                                                <td>200</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-4">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">Ratio</th>
                                                <td>100</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Suppport</th>
                                                <td>200</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">QA MP</th>
                                                <td>100</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Actual</th>
                                                <td>200</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-4">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">Plan</th>
                                                <td>100</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Absent</th>
                                                <td>200</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-4">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">Ratio</th>
                                                <td>100</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Suppport</th>
                                                <td>200</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========================================================= -->
                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Conveyor Speed</th>
                                        <td>100</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Takt Time</th>
                                        <td>200</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Working Time Plan</th>
                                        <td>300</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Working Time Actual</th>
                                        <td>300</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ==================END OF LEFT SIDE========================= -->
            <!-- ==================START OF RIGHT SIDE========================= -->
            <div class="col-6">
                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Target</th>
                                        <th scope="col">Actual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Yield</th>
                                        <td>100</td>
                                        <td>10</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">PPM</th>
                                        <td>200</td>
                                        <td>20</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- ========================================================= -->
                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body">
                            <h2 class="text-center">Inspection Output</h2>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Inspection Process</th>
                                        <th scope="col">GOOD</th>
                                        <th scope="col">NO GOOD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Dimension</th>
                                        <td>100</td>
                                        <td>10</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ECT</th>
                                        <td>200</td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Clamp Checking</th>
                                        <td>200</td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Appearance</th>
                                        <td>200</td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">QA</th>
                                        <td>200</td>
                                        <td>20</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- =========================================== -->
                <div class="col-12">
                    <div class="card card-primary card-outline shadow">
                        <div class="card-body">
                            <h3>DT / DELAY / ANDON</h3>

                            <!-- /.navbar -->
                            <div class="container-lg my-4">
                                <div class="card rounded shadow">
                                    <div id="chart-container">
                                        <canvas id="hourly_chart"></canvas>
                                    </div>
                                </div>
                                <a target="_blank" href="http://172.25.114.167:3000/andon_system/admin/page/andonProdLogs.php"
                                    class="card-link">Andon Details</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="main-footer">
        <strong>Copyright &copy; 2024. Developed by: Vince Dale Alcantara</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>


</body>

<!-- jQuery -->
<script src="plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Chart JS -->
<script src="node_modules/chart.js/dist/chart.umd.js"></script>

<script type="text/javascript">
    let chart; // Declare chart variable globally
    $(document).ready(function () {
        // Call andon_d_sum initially to load the chart
        andon_d_sum();
        // Set interval to refresh data every 10 seconds
        setInterval(andon_d_sum, 10000); // 10000 milliseconds = 10 seconds
    });

    const andon_d_sum = () => {
        $.ajax({
            url: 'process/andon_graph/a_graph_p.php',
            type: 'POST',
            dataType: 'json',
            cache: false, // Disable browser caching for this request
            data: {
                method: 'a_down_time'
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
                        datasets: [
                            {
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
                            }
                        ],
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

</html>
<!-- /.navbar -->