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

// Datalist for Ongoing Assembly Process

if ($method == 'get_line_no_datalist_search') {
	$sql = "SELECT line_no FROM t_assy GROUP BY line_no ORDER BY line_no ASC";

	$stmt = $conn_pcad -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['line_no'].'">';
		}
	}
}

if ($method == 'get_product_no_datalist_search') {
	$sql = "SELECT product_name FROM t_assy WHERE 1=1";

    if (isset($_GET['line_no'])) {
        $line_no = addslashes($_GET['line_no']);
        $sql .= " AND line_no = '$line_no'";
    }

    $sql .= " GROUP BY product_name ORDER BY product_name ASC";

	$stmt = $conn_pcad -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['product_name'].'">';
		}
	}
}

if ($method == 'get_lot_no_datalist_search') {
	$sql = "SELECT lot_no FROM t_assy WHERE 1=1";

    if (isset($_GET['line_no'])) {
        $line_no = addslashes($_GET['line_no']);
        $sql .= " AND line_no = '$line_no'";
    }

    $sql .= " GROUP BY lot_no ORDER BY lot_no ASC";

	$stmt = $conn_pcad -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['lot_no'].'">';
		}
	}
}

if ($method == 'get_serial_no_datalist_search') {
	$sql = "SELECT serial_no FROM t_assy WHERE 1=1";

    if (isset($_GET['line_no'])) {
        $line_no = addslashes($_GET['line_no']);
        $sql .= " AND line_no = '$line_no'";
    }

    $sql .= " GROUP BY serial_no ORDER BY serial_no ASC";

	$stmt = $conn_pcad -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['serial_no'].'">';
		}
	}
}


// Datalist for Assembly Process History

if ($method == 'get_line_no_history_datalist_search') {
	$sql = "SELECT line_no FROM m_assy_access_locations GROUP BY line_no ORDER BY line_no ASC";

	$stmt = $conn_pcad -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['line_no'].'">';
		}
	}
}

// Get Car Maker Dropdown
if ($method == 'get_car_maker_history_dropdown_search') {
	$sql = "SELECT car_maker FROM m_nameplate_config 
			GROUP BY car_maker ORDER BY car_maker ASC";
	$stmt = $conn_finex_master -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option selected value="">All</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_maker']).'">'.htmlspecialchars($row['car_maker']).'</option>';
		}
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Car Model Dropdown
if ($method == 'get_car_model_history_dropdown_search') {
	$sql = "SELECT car_model FROM m_nameplate_config 
			GROUP BY car_model ORDER BY car_model ASC";
	$stmt = $conn_finex_master -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option selected value="">All</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_model']).'">'.htmlspecialchars($row['car_model']).'</option>';
		}
	} else {
		echo '<option selected value="">All</option>';
	}
}


if ($method == 'get_recent_assy_in') {
    $line_no = addslashes($_GET['line_no']);
    $nameplate_value = addslashes($_GET['nameplate_value']);
    $product_name = addslashes($_GET['product_name']);
    $lot_no = addslashes($_GET['lot_no']);
    $serial_no = addslashes($_GET['serial_no']);

    $c = 0;

    $sql = "SELECT car_maker, car_model, line_no, product_name, lot_no, serial_no, assy_start_date_time 
            FROM t_assy 
            WHERE 1=1";
    
    if (!empty($line_no)) {
        $sql .= " AND line_no = '$line_no'";
    }
    
    if (!empty($nameplate_value)) {
        $sql .= " AND nameplate_value = '$nameplate_value'";
    }

    if (!empty($product_name)) {
        $sql .= " AND product_name LIKE '$product_name%'";
    }

    if (!empty($lot_no)) {
        $sql .= " AND lot_no LIKE '$lot_no%'";
    }

    if (!empty($serial_no)) {
        $sql .= " AND serial_no LIKE '$serial_no%'";
    }
    
    $sql .= " ORDER BY assy_start_date_time DESC";

    $stmt = $conn_pcad->prepare($sql);
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

if ($method == 'get_assy_history') {
    $date_from = $_GET['date_from'];
    $date_to = $_GET['date_to'];
    $line_no = addslashes($_GET['line_no']);
    $nameplate_value = addslashes($_GET['nameplate_value']);
    $product_name = addslashes($_GET['product_name']);
    $lot_no = addslashes($_GET['lot_no']);
    $serial_no = addslashes($_GET['serial_no']);

    $date_time_in_from = date('Y-m-d H:i:s',(strtotime($date_from)));
    $date_time_in_to = date('Y-m-d H:i:s',(strtotime($date_to)));

    $c = 0;

    $sql = "SELECT car_maker, car_model, line_no, product_name, lot_no, serial_no, assy_start_date_time, assy_end_date_time 
            FROM t_assy_history 
            WHERE (assy_end_date_time >= ? AND assy_end_date_time <= ?)";

    if (!empty($line_no)) {
        $sql .= " AND line_no = '$line_no'";
    }
    
    if (!empty($nameplate_value)) {
        $sql .= " AND nameplate_value = '$nameplate_value'";
    }
    
    if (!empty($product_name)) {
        $sql .= " AND product_name LIKE '$product_name%'";
    }

    if (!empty($lot_no)) {
        $sql .= " AND lot_no LIKE '$lot_no%'";
    }

    if (!empty($serial_no)) {
        $sql .= " AND serial_no LIKE '$serial_no%'";
    }

    $sql .= " ORDER BY assy_end_date_time DESC";

    $stmt = $conn_pcad->prepare($sql);
    $params = array($date_time_in_from, $date_time_in_to);
    $stmt->execute($params);

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
        echo '<td>'.$row['assy_end_date_time'].'</td>';
        echo '</tr>';
    }
}

$conn_finex_master = NULL;
$conn_pcad = NULL;
