<div class="modal fade bd-example-modal-lg" id="new_insp" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                    <div class="col-3">
                        <label>IRCS Line</label>
                        <input type="text" id="ircs_line_insp_master" class="form-control" autocomplete="off">
                    </div>
                    <div class="col-3">
                        <label>Process</label>
                        <select id="process_insp_master" class="form-control" maxlength="255" autocomplete="off">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-3">
                        <label>IP Address Column</label>
                        <select id="ip_address_column_insp_master" class="form-control" maxlength="255"
                            autocomplete="off">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-3">
                        <label>IP Address 1</label>
                        <input type="text" id="ip_address_1_insp_master" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-3">
                        <label>IP Address 2</label>
                        <input type="text" id="ip_address_2_insp_master" class="form-control" autocomplete="off">
                    </div>
                    <div class="col-3">
                        <label>Finish Date Time</label>
                        <select id="finish_date_time_insp_master" class="form-control" maxlength="255"
                            autocomplete="off">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-3">
                        <label>Judgement</label>
                        <select id="judgement_insp_master" class="form-control" maxlength="255"
                            autocomplete="off">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <br>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="float-right">
                            <a href="#" class="btn btn-success" onclick="add_insp()">Add Inspection IP</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>