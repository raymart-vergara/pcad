<!-- Data Info Modal -->
<div class="modal fade" id="assy_out_modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h4 class="modal-title">Assembly Process Out</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="assy_out_form" onsubmit="event.preventDefault();">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-sm-12">
              <input type="text" class="form-control" id="assy_out_nameplate_value" placeholder="Scan Nameplate Here"
                autocomplete="off" maxlength="255">
            </div>
          </div>
          <div class="row mt-4 mb-2">
            <div class="col-sm-12">
              <h2 class="text-bold text-center" id="out_assy_result"></h2>
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