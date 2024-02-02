<div class="modal fade bd-example-modal-xl" id="update_st" tabindex="-1"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>Update ST Details</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-8">
            <input type="hidden" id="id_st_master_update" class="form-control">
            <label>Parts Name</label>
            <input type="text" id="parts_name_master_update" class="form-control" maxlength="255" autocomplete="off">
          </div>
          <div class="col-4">
            <label>ST</label>
            <input type="text" id="st_master_update" class="form-control" autocomplete="off">
          </div>
        </div>
        <br>
        <hr>
        <div class="row">
          <div class="col-8">
            <div class="float-left">
              <a href="#" class="btn btn-danger" onclick="delete_st()">Delete ST</a>
            </div>
          </div>
          <div class="col-4">
            <div class="float-right">
              <a href="#" class="btn btn-success" onclick="update_st()">Update ST</a>
            </div>
          </div>
        </div>
      <!-- /.card-body -->
      </div>
    <!-- /.card -->
    </div>
  </div>
</div>
