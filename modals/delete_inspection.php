<div class="modal fade bd-example-modal-xl" id="delete_insp_selected" tabindex="-1"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>Delete Selected</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <h5>Are you sure to delete selected rows?</h5>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <span id="count_delete_insp_selected"></span>
          </div>
        </div>
        <br>
        <hr>
        <div class="row">
          <div class="col-12">
            <div class="float-right">
              <a href="#" class="btn btn-danger" onclick="delete_insp_selected()">Delete Selected</a>
            </div>
          </div>
        </div>
      <!-- /.card-body -->
      </div>
    <!-- /.card -->
    </div>
  </div>
</div>
