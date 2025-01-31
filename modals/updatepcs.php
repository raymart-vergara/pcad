<div class="modal fade bd-example-modal-xl" id="updatepcs" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>Update PCS Details</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-3">
            <input type="hidden" id="id_update" class="form-control">
            <label>Car Maker</label>
            <input type="text" id="car_maker_update" class="form-control" maxlength="255" autocomplete="off">
          </div>
          <div class="col-3">
            <label>Car Model</label>
            <input type="text" id="car_model_update" class="form-control" maxlength="255" autocomplete="off">
          </div>
          <div class="col-3">
            <label>Line No.</label>
            <input type="text" id="line_no_update" class="form-control" maxlength="255" autocomplete="off">
          </div>
          <div class="col-3">
            <label>IRCS Line</label>
            <input type="text" id="ircs_line_update" class="form-control" autocomplete="off">
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-3">
            <label>Andon Line</label>
            <input type="text" id="andon_line_update" class="form-control" autocomplete="off">
          </div>
          <div class="col-3">
            <input type="hidden" id="id_update" class="form-control">
            <label>Final Process</label>
            <input type="text" id="final_process_update" class="form-control" maxlength="255" autocomplete="off">
          </div>
          <div class="col-3">
            <label>IP Address</label>
            <input type="text" id="ip_update" class="form-control" autocomplete="off">
          </div>
        </div>
        <br>
        <hr>
        <div class="row">
          <div class="col-8">
            <div class="float-left">
              <a href="#" class="btn btn-danger" onclick="delete_pcs()">Delete</a>
            </div>
          </div>
          <div class="col-4">
            <div class="float-right">
              <a href="#" class="btn btn-success" onclick="update_pcs()">Update</a>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>