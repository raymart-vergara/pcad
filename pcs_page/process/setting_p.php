<?php

include '../../process/conn/pcad.php';

if (isset($_POST['line_no'])) {
	if ($line_no = "getLineName") {
		$line_no = $_POST['line_no'];
		$q = "SELECT * FROM m_ircs_line WHERE ircs_line = line_no";
		$stmt = $conn_pcad->prepare($q);
		$stmt->bindParam(':line_no', $line_no, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result) {
			$line_no = $result['line_no'];
			echo $line_no;
		} else {
			echo "No matching record found";
		}
	}
}

?>
