<?php include 'plugins/navbar.php';?>
<?php include 'plugins/sidebar/pcs_bar.php';?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">PCS Masterlist</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="pcs.php">PCS</a></li>
            <li class="breadcrumb-item active">PCS Masterlist</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-sm-2">
          <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#new_pcs"><i class="fas fa-plus-circle"></i> Add New PCS</button>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-file-alt"></i> PCS Masterlist Table</h3>
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
              <div class="row mb-4">
                <div class="col-sm-2">
                  <label>Line No.</label>
                  <input type="text" class="form-control" id="line_no_search" placeholder="Search" autocomplete="off" maxlength="255">
                </div>
                <div class="col-sm-3">
                  <label>IRCS Line</label>
                  <input type="text" class="form-control" id="ircs_search" placeholder="Search" autocomplete="off" maxlength="255">
                </div>
                <div class="col-sm-3">
                  <label>Andon Line</label>
                  <input type="text" class="form-control" id="andon_search" placeholder="Search" autocomplete="off" maxlength="255">
                </div>
                <div class="col-sm-2">
                  <label>&nbsp;</label>
                  <button type="button" class="btn bg-primary btn-block" onclick="load_pcs(1)"><i class="fas fa-search"></i> Search</button>
                </div>
                <div class="col-sm-2">
                  <label>&nbsp;</label>
                  <button type="button" class="btn bg-danger btn-block" data-toggle="modal" data-target="#delete_pcs_selected" id="btnDeleteSelected" disabled><i class="fas fa-trash"></i> Delete Selected</button>
                </div>
              </div>
              <div id="list_of_pcs_res" class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                <table id="list_of_pcs_table" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th><input type="checkbox" name="check_all" id="check_all" onclick="select_all_func()"></th>
                      <th>#</th>
                      <th>Line No.</th>
                      <th>IRCS Line</th>
                      <th>Andon Line</th>
                      <th>Final Process</th>
                      <th>IP Address</th>
                    </tr>
                  </thead>
                  <tbody id="list_of_pcs" style="text-align: center;">
                    <tr>
                      <td colspan="5" style="text-align:center;">
                        <div class="spinner-border text-dark" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="d-flex justify-content-sm-end">
                <div class="dataTables_info" id="list_of_pcs_info" role="status" aria-live="polite"></div>
              </div>
              <div class="d-flex justify-content-sm-center">
                <button type="button" class="btn bg-primary" id="btnNextPage" style="display:none;" onclick="get_next_page()">Load more</button>
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
  </section>
</div>

<?php include 'plugins/footer.php';?>
<?php include 'plugins/js/pcs_script.php'; ?>