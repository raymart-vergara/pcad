
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PCAD - ST</title>

  <link rel="icon" href="../dist/img/logo.ico" type="image/x-icon" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="../dist/css/font.min.css">
  <!-- Font Awesome -->
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
      0% { transform: rotate(0deg); }
      100% { transform: rotate(1080deg); }
    } 
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">

  <!-- /.navbar -->
<section class="container-fluid m-0 p-0">
    <!-- Content Wrapper. Contains page content -->
    <div class="CenterMain content-wrapper bg-white">
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="row">
            <div class="CenterDiv container-fluid">
                <!-- /.card-header -->
                <section class="container-lg mt-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="cardHead card widget-user shadow">
                                <div class="SPoint widget-user-header text-white"
                                    style="background: url('../../../dist/img/bgstart.jpg') center center;">
                                </div>
                                <a href="start_point.php">
                                    <div class="widget-user-image">
                                        <img class="img-circle elevation-2" src="../../../dist/img/play.png"
                                            alt="User Avatar">
                                    </div>
                                </a>
                                <div class="card-footer text-center bg-primary">
                                    <span class="h5"><b>S t a r t &nbsp;P o i n t</b></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="cardHead card card-widget widget-user shadow">
                                <div class="SPoint widget-user-header text-white"
                                    style="background: url('../../../dist/img/bgmass.jpg') center center;">
                                </div>
                                <a href="mass_production.php">
                                    <div class="widget-user-image">
                                        <img class="img-circle elevation-2" src="../../../dist/img/growth.png"
                                            alt="User Avatar">
                                    </div>
                                </a>
                                <div class="card-footer text-center bg-teal">
                                    <span class="h5"><b>M a s s &nbsp;P r o d u c t i o n</b></span>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="cardHead card card-widget widget-user shadow">
                                <div class="SPoint widget-user-header text-white"
                                    style="background: url('../../../dist/img/bgend.jpg') center center;">
                                </div>
                                <a href="end_point.php">
                                    <div class="widget-user-image">
                                        <img class="img-circle elevation-2" src="../../../dist/img/stop.png"
                                            alt="User Avatar">
                                    </div>
                                </a>
                                <div class="card-footer text-center bg-warning">
                                    <span class="h5 text-white"><b>E n d &nbsp;P o i n t</b></span>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>

<!-- /.row -->

<?php include 'plugins/footer.php'; ?>