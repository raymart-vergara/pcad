<?php include 'plugins/navbar.php';?>
<?php include 'plugins/sidebar/st_bar.php';?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">ST Masterlist</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="st.php">ST</a></li>
            <li class="breadcrumb-item active">ST Masterlist</li>
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
          <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#new_st"><i class="fas fa-plus-circle"></i> Add New ST</button>
        </div>
        <!-- <div class="col-sm-2">
          <a class="btn btn-dark btn-block" href="../template/st_template.csv"><i class="fas fa-download"></i> Download Template</a>
        </div> -->
        <div class="col-sm-2">
          <button type="button" class="btn btn-warning btn-block btn-file">
            <form id="file_form" enctype="multipart/form-data">
              <span class="mx-0 my-0"><i class="fas fa-upload"></i> Import ST </span><input type="file" id="file" name="file" onchange="upload_csv()" accept=".csv">
            </form>
          </button>
        </div>
        <div class="col-sm-2">
          <a class="btn btn-secondary btn-block" onclick="export_st()"><i class="fas fa-download"></i> Export ST</a>
        </div>
      </div>
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
              <div class="row mb-4">
                <div class="col-sm-4">
                  <label>Parts Name</label>
                  <input type="text" class="form-control" id="parts_name_master_search" placeholder="Search" autocomplete="off" maxlength="255">
                </div>
                <div class="col-sm-2">
                  <label>ST</label>
                  <input type="text" class="form-control" id="st_master_search" placeholder="Search" autocomplete="off" maxlength="255">
                </div>
                <div class="col-sm-2">
                  <label>&nbsp;</label>
                  <button type="button" class="btn bg-gray-dark btn-block" onclick="load_st(1)"><i class="fas fa-search"></i> Search</button>
                </div>
                <div class="col-sm-2">
                  <label>&nbsp;</label>
                  <button type="button" class="btn bg-gray-dark btn-block" onclick="print_st()"><i class="fas fa-print"></i> Print All</button>
                </div>
                <div class="col-sm-2">
                  <label>&nbsp;</label>
                  <button type="button" class="btn bg-danger btn-block" data-toggle="modal" data-target="#confirm_delete_st_selected" id="btnDeleteSelected" disabled><i class="fas fa-trash"></i> Delete Selected</button>
                </div>
              </div>
              <div id="list_of_st_res" class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                <table id="list_of_st_table" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th><input type="checkbox" name="check_all" id="check_all" onclick="select_all_func()"></th>
                      <th>#</th>
                      <th>Parts Name</th>
                      <th>ST</th>
                      <th>Date Updated</th>
                    </tr>
                  </thead>
                  <tbody id="list_of_st" style="text-align: center;">
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
                <div class="dataTables_info" id="list_of_st_info" role="status" aria-live="polite"></div>
              </div>
              <div class="d-flex justify-content-sm-center">
                <button type="button" class="btn bg-gray-dark" id="btnNextPage" style="display:none;" onclick="get_next_page()">Load more</button>
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
<?php include 'plugins/js/st_script.php'; ?>