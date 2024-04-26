<?php
include 'plugins/head.php';
include '../process/conn/pcad.php';

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
    <div class="card col-5" style="border-radius: 10px;">
        <form method="post" action="../process/pcs/dashboard_setting_p.php">
            <input type="hidden" name="request" value="addTarget">
            <div class="row" style="height: 500px;">
                <div class="col-5 m-0 p-0 d-flex justify-content-center align-items-center"
                    style="background: #0D2D5E; color: #FFF; border-radius: 10px 0px 0px 10px;">
                    <div class="d-flex flex-column justify-content-center align-items-left"
                        style="margin: 0; padding: 0;">
                        <div class="row">
                            <div class="col-12">
                                <p class="mb-0 pcad-title">
                                    Production <br>
                                    Conveyor <br>
                                    Analysis <br>
                                    Dashboard
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7" style="">
                    <div class="row">
                        <div class="col-12 text-right p-5 mt-3" style="color: #0069B0; font-size: 22px;">
                            Settings
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 px-5 mt-3">
                            Select Line No. <br>
                            <select name="registlinename" id="ircs_line" class="form-control" style="width: 100%;"
                                required>
                                <option value="">
                                    Select Line No.
                                </option>
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
                    <div class="row mt-4">
                        <div class="col-12 px-5">
                            Group <br>
                            <select name="group" id="group" class="form-control" style="width: 100%;" required>
                                <option value="" disabled selected>Select Group </option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 px-5 d-flex justify-content-center align-items-center">
                            <button type="submit"
                                style="width: 75%; border-radius: 20px; background-color: #0069B0; color: #FFF"
                                onmouseover="this.style.backgroundColor='#00538B'; this.style.color='#fff';"
                                onmouseout="this.style.backgroundColor='#0069B0'; this.style.color='#fff';"
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