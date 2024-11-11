<!-- Data Info Modal -->
<div class="modal fade" id="assy_in_modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h4 class="modal-title">Assembly Process In</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="assy_in_form" onsubmit="event.preventDefault();">
        <div class="modal-body">
          <div class="row mb-4">
            <input type="hidden" id="assy_in_product_name" value="">
            <input type="hidden" id="assy_in_lot_no" value="">
            <input type="hidden" id="assy_in_serial_no" value="">
            <div class="col-sm-6">
              <label>Car Maker</label><label style="color: red;">*</label>
              <select class="form-control" id="assy_in_car_maker" required></select>
            </div>
            <div class="col-sm-6">
              <label>Car Model</label><label style="color: red;">*</label>
              <select class="form-control" id="assy_in_car_model" required disabled></select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-12">
              <input type="text" class="form-control" id="assy_in_nameplate_value" placeholder="Scan Nameplate Here"
                autocomplete="off" maxlength="255" required disabled>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-12">
              <span class="text-bold" id="in_assy_result"></span>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->