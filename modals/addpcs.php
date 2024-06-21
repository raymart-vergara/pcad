<div class="modal fade bd-example-modal-xl" id="new_pcs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>New Masterlist</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-3">
            <label>Car Maker</label>
            <select type="text" id="car_maker_master" class="form-control" maxlength="255" autocomplete="off">
              <option value="" disabled selected>Select Car Maker</option>
              <option value="MAZDA">MAZDA</option>
              <option value="DAIHATSU">DAIHATSU</option>
              <option value="HONDA">HONDA</option>
              <option value="TOYOTA">TOYOTA</option>
              <option value="SUZUKI">SUZUKI</option>
              <option value="NISSAN">NISSAN</option>
              <option value="SUBARU">SUBARU</option>
            </select>
          </div>
          <div class="col-3">
            <label>Car Model</label>
            <input type="text" id="car_model_master" class="form-control" maxlength="255" autocomplete="off">
          </div>
          <div class="col-3">
            <label>Line No.</label>
            <input type="text" id="line_no_master" class="form-control" maxlength="255" autocomplete="off">
          </div>
          <div class="col-3">
            <label>IRCS Line</label>
            <input type="text" id="ircs_line_master" class="form-control" autocomplete="off">
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-3">
            <label>Andon Line</label>
            <input type="text" id="andon_line_master" class="form-control" autocomplete="off">
          </div>
          <div class="col-3">
            <label for="final_process_master">Final Process</label>
            <select id="final_process_master" class="form-control" maxlength="255" autocomplete="off">
              <option value="" disabled selected>Select Final Process</option>
            </select>
          </div>
          <div class="col-3">
            <label>IP Address</label>
            <input type="text" id="ip_master" class="form-control" autocomplete="off">
          </div>
        </div>
        <br>
        <hr>
        <div class="row">
          <div class="col-12">
            <div class="float-right">
              <a href="#" class="btn btn-success" onclick="add_pcs()">Add Line</a>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>