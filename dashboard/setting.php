<?php
include '../process/server_date_time.php';
include '../process/conn/pcad.php';
include '../process/lib/emp_mgt.php';
include 'plugins/head.php';

$ircs_lines = array();
$query = "SELECT * FROM m_ircs_line ORDER BY ircs_line ASC";
$result = $conn_pcad->query($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

if ($result) {
    $ircs_lines = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    $errorInfo = $conn_pcad->errorInfo();
    echo "Error: " . $errorInfo[2];
}
?>

<div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-6" style="border-radius: 10px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.15);">
        <form method="post" action="../process/pcs/dashboard_setting_p.php">
            <input type="hidden" name="request" value="addTarget">
            <div class="row">
                <div class="col-lg-6 col-md-12 m-0 p-0">
                    <img src="../dist/img/tech.png" alt="pcad_cover" class="img-fluid"
                        style="border-radius: 10px 0px 0px 10px;">
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="row mb-3">
                        <div class="col-12 text-right pr-lg-5 pr-md-4 pr-sm-3 pt-lg-4 pt-md-3 pt-sm-2"
                            style="color: #003D9E; font-size: 22px;">
                            Settings
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6 px-lg-5 px-md-4 px-sm-3">
                            Option <br>
                            <div class="form-group mb-0">
                                <input type="radio" id="opt_1" name="opt" value="1" onclick="check_opt()" checked>
                                <label class="h6" for="opt_1">Live</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 px-lg-5 px-md-4 px-sm-3">
                            <br>
                            <div class="form-group mb-0">
                                <input type="radio" id="opt_2" name="opt" value="2" onclick="check_opt()">
                                <label class="h6" for="opt_2">History</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 px-lg-5 px-md-4 px-sm-3">
                            Day <br>
                            <input type="date" name="day" id="day" class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 px-lg-5 px-md-4 px-sm-3">
                            Shift <br>
                            <select name="shift" id="shift" class="form-control" required disabled>
                                <option value="DS">DS</option>
                                <option value="NS">NS</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 px-lg-5 px-md-4 px-sm-3">
                            Select Line No. <br>
                            <select name="registlinename" id="ircs_line" class="form-control" required>
                                <option value="">Select Line No.</option>
                                <?php
                                if ($ircs_lines) {
                                    foreach ($ircs_lines as $i => $ircs) {
                                        echo '<option value="' . $ircs['ircs_line'] . '">' . $ircs['ircs_line'] . ' (' . $ircs['line_no'] . ')</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12 px-lg-5 px-md-4 px-sm-3">
                            Group <br>
                            <select name="group" id="group" class="form-control" required>
                                <option value="" disabled selected>Select Group </option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 px-lg-5 px-md-4 px-sm-3 d-flex justify-content-center">
                            <button type="submit"
                                style="width: 75%; border-radius: 20px; background-color: #003D9E; color: #FFF"
                                onmouseover="this.style.backgroundColor='#021253'; this.style.color='#fff';"
                                onmouseout="this.style.backgroundColor='#003D9E'; this.style.color='#fff';"
                                class="btn btn-hover" id="runcounterbtn" name="request" value="addTarget">
                                <a class="small-box-footer monitor" style="color: #FFF;">Proceed &ensp;<i
                                        class="fas fa-arrow-right"></i>
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
include 'plugins/footer.php';
include 'plugins/js/setting_script.php';
?>