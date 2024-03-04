<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PCAD | Andon Details</title>

    <link rel="icon" href="../dist/img/pcad_logo.ico" type="image/x-icon" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="../dist/css/font.min.css">
    <!-- Font Awesome -->
    <script src="../node_modules/chart.js/dist/chart.umd.js"></script>

    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../plugins/ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="../plugins/sweetalert2/dist/sweetalert2.min.css">
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #536A6D;
            width: 50px;
            height: 50px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            cursor: inherit;
            display: block;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(1080deg);
            }
        }
    </style>
</head>

<body class="">
    <div class="card-body">
        <h2 class="text-center">Andon Details</h2>
        <table class="table table-head-fixed text-nowrap table-bordered table-hover">
            <thead class="text-center">
                <tr><th>#</th>
                    <th>Production</th>
                    <th>Line</th>
                    <th>Machine</th>
                    <th>Machine No.</th>
                    <th>Process</th>
                    <th>Problem</th>
                    <th>Production Acct.</th>
                    <th>Call Date Time</th>
                    <th>Waiting Time (mins.)</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Fixing Time Duration (mins.)</th>
                    <th>Technician</th>
                    <th>Department</th>
                    <th>Solution</th>
                    <th>Serial Number</th>
                    <th>Jig Name</th>
                    <th>Circuit Location</th>
                    <th>Lot Number</th>
                    <th>Product Number</th>
                    <th>Fixing Status</th>
                    <th>Backup Request Time</th>
                    <th>Backup Comment</th>
                    <th>Backup Technician</th>
                    <th>Backup Confirmation Date Time</th>
                </tr>
            </thead>
            <tbody id="andon_details" style="text-align:center;"></tbody>
        </table>
    </div>
    <!-- /.row -->

    <?php include 'plugins/footer.php'; ?>
    <?php
    include 'plugins/js/a_graph_script.php';
    ?>