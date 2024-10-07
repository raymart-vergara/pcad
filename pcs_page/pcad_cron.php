<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PCAD Cron</title>

  <link rel="icon" href="../dist/img/pcad_logo.ico" type="image/x-icon" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="../dist/css/font.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <img src="../dist/img/pcad_logo.png" style="height:100px;">
      <h2><b>PCAD Cron</b></h2>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <h4 class="login-box-msg"><b id="realtime"></b></h4>
        <h4 class="login-box-msg">FALP Server: <?=$_SERVER['SERVER_ADDR']?></h4>
        <p class="login-box-msg"><b>See Console for more info (Press F12)</b></p>
      </div>
    </div>
  </div>
</body>

<!-- jQuery -->
<script src="../plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

<script>
  // AJAX IN PROGRESS GLOBAL VARS
  var update_all_plan_pending_ajax_in_process = false;

  // Global Variables for Realtime Count
  var realtime_update_all_plan_pending;

  function refreshDateTime() {
    const datetimeDisplay = document.getElementById("realtime");
    const now = new Date();

    const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = now.toLocaleDateString(undefined, dateOptions);

    const timeOptions = { hour: 'numeric', minute: 'numeric', second: 'numeric' };
    const formattedTime = now.toLocaleTimeString(undefined, timeOptions);

    const formattedDateTime = `${formattedDate} | ${formattedTime}`;

    datetimeDisplay.textContent = formattedDateTime;
  }
  
  setInterval(() => {
		window.location.reload();
	}, 1000 * 60 * 60);

  const recursive_realtime_update_all_plan_pending = () => {
    update_all_plan_pending();
    realtime_update_all_plan_pending = setTimeout(recursive_realtime_update_all_plan_pending, 10000);
  }

  // DOMContentLoaded function
  document.addEventListener("DOMContentLoaded", () => {
    setInterval(refreshDateTime, 1000); 

    recursive_realtime_update_all_plan_pending();
  });

  const update_all_plan_pending = () => {
    // If an AJAX call is already in progress, return immediately
    if (update_all_plan_pending_ajax_in_process) {
      return;
    }

    // Set the flag to true as we're starting an AJAX call
    update_all_plan_pending_ajax_in_process = true;

    $.ajax({
      url: '../process/cron/pcad_cron.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'update_all_plan_pending'
      },
      success: (response) => {
        console.log(response);
        // Set the flag back to false as the AJAX call has completed
        update_all_plan_pending_ajax_in_process = false;
      }
    });
  }
</script>

</body>
</html>
