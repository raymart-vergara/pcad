<?php
include '../process/server_date_time.php';
include '../process/conn/pcad.php';
include '../process/lib/emp_mgt.php';
include 'plugins/head.php';

$ircs_lines = array();
$query = "SELECT * FROM m_ircs_line ORDER BY ircs_line ASC";
$result = $conn_pcad->query($query);

if ($result) {
    $ircs_lines = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    $errorInfo = $conn_pcad->errorInfo();
    echo "Error: " . $errorInfo[2];
}
?>

<div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-lg-7 col-md-7 col-sm-7 form-container">
        <form method="post" action="../process/pcs/dashboard_setting_p.php">
            <input type="hidden" name="request" value="addTarget">
            <div class="row g-0">
                <div class="col-lg-6 col-md-12 p-0 d-flex align-items-center">
                    <div class="img-container d-flex align-items-center justify-content-center">
                        <img src="../dist/img/tech.png" alt="pcad_cover" class="img-fluid rounded-left">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 p-5">
                    <div class="text-right mb-2">
                        <h2 class="form-header">Settings</h2>
                    </div>
                    <div class="form-group mb-4">
                        <label class="d-block m-0 p-0" style="color: #003D9E;">Options</label>
                        <div class="form-check form-check-inline mr-4">
                            <input class="form-check-input" type="radio" id="opt_1" name="opt" value="1"
                                onclick="check_opt()" checked>
                            <label class="form-check-label" for="opt_1">Live</label>
                        </div>
                        <div class="form-check form-check-inline ml-5">
                            <input class="form-check-input" type="radio" id="opt_2" name="opt" value="2"
                                onclick="check_opt()">
                            <label class="form-check-label" for="opt_2">History</label>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="day" class="m-0 p-0">Day</label>
                        <input type="date" name="day" id="day" class="form-control" required disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label for="shift" class="m-0 p-0">Shift</label>
                        <select name="shift" id="shift" class="form-control" required disabled>
                            <option value="DS">DS</option>
                            <option value="NS">NS</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="ircs_line" class="m-0 p-0">Select Line No.</label>
                        <select name="registlinename" id="ircs_line" class="form-control bg-color" required>
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
                    <div class="form-group mb-4">
                        <label for="group" class="m-0 p-0">Group</label>
                        <select name="group" id="group" class="form-control bg-color" required>
                            <option value="" disabled selected>Select Group</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                        </select>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn form-button">
                                Proceed &ensp;<i class="fas fa-arrow-right"></i>
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