<div class="modal fade bd-example-modal-xl" id="new_st" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>New ST</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="new_st_form">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-8">
              <label>Parts Name</label><label style="color: red;">*</label>
              <input type="text" id="parts_name_master" class="form-control" maxlength="255" autocomplete="off" required>
            </div>
            <div class="col-4">
              <label>ST</label><label style="color: red;">*</label>
              <input type="number" id="st_master" class="form-control" step="0.0001" autocomplete="off" required>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label>Sub Assy ST</label><label style="color: red;">*</label>
              <input type="number" id="sub_assy_master" class="form-control" step="0.0001" autocomplete="off" required>
            </div>
            <div class="col-4">
              <label>Final Assy ST</label><label style="color: red;">*</label>
              <input type="number" id="final_assy_master" class="form-control" step="0.0001" autocomplete="off" required>
            </div>
            <div class="col-4">
              <label>Inspection ST</label><label style="color: red;">*</label>
              <input type="number" id="inspection_master" class="form-control" step="0.0001" autocomplete="off" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnAddSt" name="btn_add_st" class="btn btn-success">Add ST</button>
        </div>
      </form>
    </div>
  </div>
</div>