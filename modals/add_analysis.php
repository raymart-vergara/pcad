<div class="modal fade bd-example-modal-xl" id="add_analysis" tabindex="-1" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background:#f9f9f9;">
            <div class="modal-header" style="background: linear-gradient(90deg, #021253, #003d9e);">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: normal;color: #fff;"><i
                        class="fas fa-file-alt"></i>&nbsp;
                    Record Analysis
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <!-- problem -->
                        <label class="p-0 m-0" style="font-weight: normal">Problem</label>
                        <label style="color: red;">*</label>
                        <textarea type="text" id="a_problem" class="textarea form-control" maxlength="1000"
                            autocomplete="off" rows="5" placeholder="See support information (Situation) to view the PCAD RASCI"></textarea>
                    </div>
                    <div class="col-6">
                        <!-- recommendation -->
                        <label class="p-0 m-0" style="font-weight: normal">What to do?</label>
                        <label style="color: red;">*</label>
                        <textarea type="text" id="a_recommendation" class="textarea form-control" maxlength="1000"
                            autocomplete="off" rows="5" placeholder="See support information (What to do?) to view the PCAD RASCI"></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4">
                        <!-- dri -->
                        <label class="p-0 m-0" style="font-weight: normal">DRI</label>
                        <label style="color: red;">*</label>
                        <input type="text" id="a_dri" class="form-control" autocomplete="off"></input>
                    </div>
                    <div class="col-4">
                        <!-- department -->
                        <label class="p-0 m-0" style="font-weight: normal">Department</label>
                        <label style="color: red;">*</label>
                        <select name="a_department" id="a_department" autocomplete="off" class="pl-2 form-control"
                            required>
                            <option value="" disabled selected>Select department</option>
                            <option value="PD1">PD1</option>
                            <option value="PD2">PD2</option>
                            <option value="QA">QA</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <!-- datetime -->
                        <label class="p-0 m-0" style="font-weight: normal">DateTime Recorded</label>
                        <label style="color: #f9f9f9">*</label>
                        <input type="datetime-local" id="a_datetime" class="form-control" autocomplete="off" disabled></input>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4">
                        <!-- prepared by -->
                        <label class="p-0 m-0" style="font-weight: normal">Prepared by</label>
                        <label style="color: red;">*</label>
                        <input type="text" id="a_prepared_by" class="form-control" autocomplete="off"></input>
                    </div>
                    <div class="col-4">
                        <!-- reviewed by -->
                        <label class="p-0 m-0" style="font-weight: normal">Reviewed by</label>
                        <label style="color: red;">*</label>
                        <input type="text" id="a_reviewed_by" class="form-control" autocomplete="off"></input>
                    </div>
                </div>


            </div>

            <div class="modal-footer">
                <div class="col-12">
                    <div class="float-left">
                        <button class="btn btn-block" data-dismiss="modal"
                            style="color:#fff;height:34px;width:180px;border-radius:.25rem;background: #CA3F3F;font-size:15px;font-weight:normal;"
                            onmouseover="this.style.backgroundColor='#AC3737'; this.style.color='#FFF';"
                            onmouseout="this.style.backgroundColor='#CA3F3F'; this.style.color='#FFF';">Cancel</button>
                    </div>
                    <div class="float-right">
                        <button class="btn btn-block" onclick="add_analysis()"
                            style="color:#fff;height:34px;width:180px;border-radius:.25rem;background: #226F54;font-size:15px;font-weight:normal;"
                            onmouseover="this.style.backgroundColor='#1C5944'; this.style.color='#FFF';"
                            onmouseout="this.style.backgroundColor='#226F54'; this.style.color='#FFF';">Save
                            Record</button>
                    </div>
                </div>
            </div>
            <!-- end -->
        </div>
    </div>
</div>