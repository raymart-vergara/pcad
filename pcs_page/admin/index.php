<?php require '../../process/pcs/login.php';

if (isset($_SESSION['emp_id'])) {
  header('location: pcs.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PCAD - ST</title>

  <link rel="icon" href="../../dist/img/pcad_logo.ico" type="image/x-icon" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="../../dist/css/font.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <img src="../../dist/img/logo.webp" style="height:100px;">
      <h2><b>PCAD - PCS</b></h2>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg"><b>Scan QR Code or Type your ID Number</b></p>

        <form action="" method="POST" id="login_form">
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="emp_id" name="emp_id" placeholder="ID Number" autocomplete="off" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>   
          <!-- /.col -->
          <div class="input-group mb-3">
            <button type="submit" class="btn btn-dark btn-block" name="login_pcs_btn" value="login">Sign In</button>
          </div>
          <!-- /.col -->
        </form>
      </div>
    </div>
  </div>
</body>

<!-- jQuery -->
<script src="../../plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

<script>
  // DOMContentLoaded function
  document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("emp_id").focus();
  });

</script>

</body>
</html>
