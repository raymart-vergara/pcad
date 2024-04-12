<div class="modal fade bd-example-modal-lg" id="update_modal_insp" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <b>New Inspection Masterlist</b>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <input type="hidden" id="id_insp_update" class="form-control">

                        <label>IRCS Line</label>
                        <input type="text" id="ircs_line_insp_master_update" class="form-control" autocomplete="off">
                    </div>
                    <!-- DROPDOWN!!! -->
                    <div class="col-4">
                        <label>Process</label>
                        <input type="text" id="process_insp_master_update" class="form-control" autocomplete="off">
                    </div>
                    <div class="col-4">
                        <label>IP Address Column</label>
                        <input type="text" id="ip_address_column_insp_master_update" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-4">
                        <label>IP Address 1</label>
                        <input type="text" id="ip_address_1_insp_master_update" class="form-control" autocomplete="off">
                    </div>
                    <div class="col-4">
                        <label>IP Address 2</label>
                        <input type="text" id="ip_address_2_insp_master_update" class="form-control" autocomplete="off">
                    </div>
                </div>
                <br>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <div class="float-left">
                            <a href="#" class="btn btn-danger" onclick="delete_insp()">Delete</a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="#" class="btn btn-success" onclick="update_insp()">Update</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>