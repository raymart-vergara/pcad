<?php
require '../conn/pcad.php';

$method = $_POST['method'];

if ($method == 'assy_in') {
    $nameplate_value = $_POST['nameplate_value'];
    $car_maker = $_POST['car_maker'];
    $car_model = $_POST['car_model'];
    $line_no = $_POST['line_no'];
    $product_name = $_POST['product_name'];
    $lot_no = $_POST['lot_no'];
    $serial_no = $_POST['serial_no'];

    $sql = "SELECT id FROM t_assy WHERE nameplate_value = ? AND car_maker = ? AND car_model = ?";
    $stmt = $conn_pcad->prepare($sql);
    $params = array($nameplate_value, $car_maker, $car_model);
    $stmt->execute();

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $isTransactionActive = false;

        try {
            if (!$isTransactionActive) {
                $conn->beginTransaction();
                $isTransactionActive = true;
            }

            $sql = "INSERT INTO t_assy (car_maker, car_model, line_no, 
                        nameplate_value, product_name, lot_no, serial_no) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn -> prepare($sql);
            $params = array($car_maker, $car_model, $line_no, $nameplate_value, $product_name, $lot_no, $serial_no);
            $stmt -> execute($params);

            $conn->commit();
            $isTransactionActive = false;
            echo 'success';
        } catch (Exception $e) {
            if ($isTransactionActive) {
                $conn->rollBack();
                $isTransactionActive = false;
            }
            echo 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
            exit();
        }
    } else {
        $sql = "SELECT id FROM t_assy_history WHERE nameplate_value = ? AND car_maker = ? AND car_model = ?";
        $stmt = $conn_pcad->prepare($sql);
        $params = array($nameplate_value, $car_maker, $car_model);
        $stmt->execute();

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo 'Wire Harness Nameplate Already Out';
        } else {
            echo 'Wire Harness Nameplate Already In';
        }
    }
}

if ($method == 'assy_out') {
    $nameplate_value = $_POST['nameplate_value'];
    $car_maker = $_POST['car_maker'];
    $car_model = $_POST['car_model'];
    $line_no = $_POST['line_no'];
    $product_name = $_POST['product_name'];
    $lot_no = $_POST['lot_no'];
    $serial_no = $_POST['serial_no'];

    $sql = "SELECT id FROM t_assy WHERE nameplate_value = ? AND car_maker = ? AND car_model = ?";
    $stmt = $conn_pcad->prepare($sql);
    $params = array($nameplate_value, $car_maker, $car_model);
    $stmt->execute();

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $id = $row['id'];

        $isTransactionActive = false;

        try {
            if (!$isTransactionActive) {
                $conn->beginTransaction();
                $isTransactionActive = true;
            }

            $sql = "INSERT INTO t_assy_history (car_maker, car_model, line_no, 
                        nameplate_value, product_name, lot_no, serial_no, assy_start_date_time) 
                    SELECT car_maker, car_model, line_no, 
                        nameplate_value, product_name, lot_no, serial_no, assy_start_date_time 
                    FROM t_assy WHERE id = ?";
            $stmt = $conn -> prepare($sql);
            $params = array($id);
            $stmt -> execute($params);

            $sql = "DELETE FROM t_assy WHERE id = ?";
            $stmt = $conn -> prepare($sql);
            $params = array($id);
            $stmt -> execute($params);

            $conn->commit();
            $isTransactionActive = false;
            echo 'success';
        } catch (Exception $e) {
            if ($isTransactionActive) {
                $conn->rollBack();
                $isTransactionActive = false;
            }
            echo 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
            exit();
        }
    } else {
        $sql = "SELECT id FROM t_assy_history WHERE nameplate_value = ? AND car_maker = ? AND car_model = ?";
        $stmt = $conn_pcad->prepare($sql);
        $params = array($nameplate_value, $car_maker, $car_model);
        $stmt->execute();

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo 'Wire Harness Nameplate Already Out';
        } else {
            echo 'Wire Harness Nameplate Not Scanned for Assy In';
        }
    }
}

$conn_pcad = NULL;
