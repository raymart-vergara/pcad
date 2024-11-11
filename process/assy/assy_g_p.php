<?php
require '../conn/pcad.php';
require '../conn/finex_master.php';

$method = $_GET['method'];

if ($method == 'get_car_maker') {
    $query = "SELECT DISTINCT car_maker FROM m_nameplate_config ORDER BY car_maker ASC";
    $stmt = $conn_finex_master->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option value="" disabled selected>Select Car Maker</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option>' . htmlspecialchars($row['car_maker']) . '</option>';
        }
    } else {
        echo '<option value="">No Car Makers Available</option>';
    }
}

if ($method == 'get_car_model' && isset($_GET['car_maker'])) {
    $car_maker = $_GET['car_maker'];
    $query = "SELECT DISTINCT car_model FROM m_nameplate_config WHERE car_maker = ? ORDER BY car_model ASC";
    $stmt = $conn_finex_master->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $params = array($car_maker);
    $stmt->execute($params);

    if ($stmt->rowCount() > 0) {
        echo '<option value="" disabled selected>Select Car Model Setting</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option>' . htmlspecialchars($row['car_model']) . '</option>';
        }
    } else {
        echo '<option value="">No Car Models Available</option>';
    }
}

if ($method == 'get_nameplate_config' && isset($_GET['car_model'])) {
    $car_model = $_GET['car_model'];
    $query = "SELECT total_length, product_name_start, product_name_length, 
                    lot_no_start, lot_no_length, serial_no_start, serial_no_length 
                FROM m_nameplate_config 
                WHERE car_model = ?";
    $stmt = $conn_finex_master->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $params = array($car_model);
    $stmt->execute($params);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row); 
    } else {
        echo json_encode([]); 
    }
}

if ($method == 'get_recent_assy_in') {
    $line_no = $_GET['line_no'];

    $c = 0;

    $sql = "SELECT car_maker, car_model, line_no, product_name, lot_no, serial_no, assy_start_date_time
            FROM t_assy
            WHERE line_no = ?
            ORDER BY assy_start_date_time DESC";
    
    $stmt = $conn_pcad->prepare($sql);
    $params = array($line_no);
    $stmt->execute();

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $c++;

        echo '<tr>';
        echo '<td>'.$c.'</td>';
        echo '<td>'.$row['car_maker'].'</td>';
        echo '<td>'.$row['car_model'].'</td>';
        echo '<td>'.$row['line_no'].'</td>';
        echo '<td>'.$row['product_name'].'</td>';
        echo '<td>'.$row['lot_no'].'</td>';
        echo '<td>'.$row['serial_no'].'</td>';
        echo '<td>'.$row['assy_start_date_time'].'</td>';
        echo '</tr>';
    }
}

$conn_finex_master = NULL;
$conn_pcad = NULL;
