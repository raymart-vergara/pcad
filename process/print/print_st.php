<?php 
session_name("pcad");
session_start();

require '../conn/pcad.php';

function count_st_list($search_arr, $conn_pcad) {
  $query = "SELECT count(id) AS total FROM m_st WHERE";
  if (!empty($search_arr['parts_name'])) {
    $query = $query . " parts_name LIKE '".$search_arr['parts_name']."%'";
  } else {
    $query = $query . " parts_name != ''";
  }
  if (!empty($search_arr['st'])) {
    $query = $query . " AND st LIKE '".$search_arr['st']."%'";
  }
  
  $stmt = $conn_pcad->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute();
  if ($stmt->rowCount() > 0) {
    foreach($stmt->fetchALL() as $j){
      $total = $j['total'];
    }
  }else{
    $total = 0;
  }
  return $total;
}

if (!isset($_SESSION['emp_no'])) {
  header('location:/pcad/st_page/');
  exit;
}

switch (true) {
  case !isset($_GET['parts_name']):
  case !isset($_GET['st']):
    echo 'Query Parameters Not Set';
    exit;
}

$parts_name = addslashes(trim($_GET['parts_name']));
$st = addslashes(trim($_GET['st']));

$c = 0;

$search_arr = array(
  "parts_name" => $parts_name,
  "st" => $st
);

$count_st = count_st_list($search_arr, $conn_pcad);

$query = "SELECT id, parts_name, sub_assy, final_assy, inspection, st, date_updated FROM m_st WHERE";
if (!empty($parts_name)) {
  $query = $query . " parts_name LIKE '".$parts_name."%'";
} else {
  $query = $query . " parts_name != ''";
}
if (!empty($st)) {
  $query = $query . " AND st LIKE '$st%'";
}
$stmt = $conn_pcad->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Print ST Masterlist - PCAD</title>

  <link rel="icon" href="../../dist/img/pcad_logo.ico" type="image/x-icon" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="../../dist/css/font.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-fixed">

  <div class="wrapper">
  <!-- Main content -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-gray-dark card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-file-alt"></i> ST Masterlist Table</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="list_of_st_table" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>#</th>
                      <th>Parts Name</th>
                      <th>Sub Assy ST</th>
                      <th>Final Assy ST</th>
                      <th>Inspection ST</th>
                      <th>ST</th>
                      <th>Date Updated</th>
                    </tr>
                  </thead>
                  <tbody id="list_of_st" style="text-align: center;">
                    <?php
                      if ($stmt->rowCount() > 0) {
                        foreach($stmt->fetchALL() as $row){
                          $c++;
                          echo '<tr>';
                            echo '<td>'.$c.'</td>';
                            echo '<td>'.$row['parts_name'].'</td>';
                            echo '<td>'.$row['sub_assy'].'</td>';
                            echo '<td>'.$row['final_assy'].'</td>';
                            echo '<td>'.$row['inspection'].'</td>';
                            echo '<td>'.$row['st'].'</td>';
                            echo '<td>'.$row['date_updated'].'</td>';
                          echo '</tr>';
                        }
                      }else{
                        echo '<tr>';
                          echo '<td colspan="7" style="text-align:center; color:red;">No Result !!!</td>';
                        echo '</tr>';
                      }
                    ?>
                  </tbody>
                  <tfoot style="text-align: center;">
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th>Total Rows : <?=$count_st?></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
  </div>

  <!-- jQuery -->
  <script src="../../plugins/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.js"></script>

  <script type="text/javascript">
    setTimeout(print_data, 2000);
    function print_data(){  
      window.print();
    }
  </script>

</body>
</html>