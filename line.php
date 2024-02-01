<?php
include 'process/server_date_time.php';
require 'process/conn/emp_mgt.php';
include 'process/lib/emp_mgt.php';

$line_no = $_GET['line_no'];
$registlinename = '';
// $registlinename = $_GET['registlinename']; // IRCS LINE (PCS)
$dept_pd = 'PD2';
$dept_qa = 'QA';
$section = get_section($line_no, $conn_emp_mgt);
$shift = get_shift($server_time);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PCAD</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="dist/css/font.min.css">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">

	<style>
		table, tr, td, th {
			color: black;
			border: 1px solid black;
			border-width: small;
			border-collapse: collapse;
			padding: 2px;
		}
	</style>
</head>
<body>
	<input type="hidden" id="shift" value="<?=$shift?>">
	<input type="hidden" id="dept_pd" value="<?=$dept_pd?>">
	<input type="hidden" id="dept_qa" value="<?=$dept_qa?>">
	<input type="hidden" id="section" value="<?=$section?>">
	<input type="hidden" id="line_no" value="<?=$line_no?>">
	<!-- <input type="hidden" id="registlinename" value="<?=$registlinename?>"> -->
	<table>
		<thead>
			<tr>
				<th>Line No :</th>
				<th id="line_no_label"><?=$line_no?></th>
				<th>Date :</th>
				<th id="server_date_only_label"><?=$server_date_only?></th>
			</tr>
			<tr>
				<th>Shift :</th>
				<th id="shift_label"><?=$shift?></th>
				<th>Group :</th>
				<th id="shift_group_label">A/B</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="2">
					<table>
						<thead>
							<tr>
								<th></th>
								<th>Target</th>
								<th>Actual</th>
								<th>Gap</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Plan</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
							</tr>
						</tbody>
					</table>
					<table>
						<tbody>
							<tr>
								<td>Accounting Efficiency</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
							</tr>
							<tr>
								<td>Hourly Output</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td colspan="2">
					<table>
						<thead>
							<tr>
								<th></th>
								<th>Target</th>
								<th>Actual</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Yield</td>
								<td>0</td>
								<td>0</td>
							</tr>
							<tr>
								<td>PPM</td>
								<td>0</td>
								<td>0</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>Starting Balance Delay</td>
				<td>0</td>
				<td colspan="2">Inspection Output</td>
			</tr>
			<tr>
				<td colspan="2">
					<table>
						<tbody>
							<tr>
								<td>PD MP : </td>
								<td id="total_pd_mp">0</td>
								<td>Plan</td>
								<td>0</td>
								<td>Absent Ratio</td>
								<td id="absent_ratio_pd_mp">0</td>
							</tr>
							<tr>
								<td>Actual : </td>
								<td id="total_present_pd_mp">0</td>
								<td>Absent</td>
								<td id="total_absent_pd_mp">0</td>
								<td>Support</td>
								<td id="total_pd_mp_line_support_to">0</td>
							</tr>
							<tr>
								<td>QA MP : </td>
								<td id="total_qa_mp">0</td>
								<td>Plan</td>
								<td>0</td>
								<td>Absent Ratio</td>
								<td id="absent_ratio_qa_mp">0</td>
							</tr>
							<tr>
								<td>Actual : </td>
								<td id="total_present_qa_mp">0</td>
								<td>Absent</td>
								<td id="total_absent_qa_mp">0</td>
								<td>Support</td>
								<td id="total_qa_mp_line_support_to">0</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td colspan="2">
					<table>
						<thead>
							<tr>
								<th>Inspection Process</th>
								<th>Good</th>
								<th>NG</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>DIM</td>
								<td>0</td>
								<td>0</td>
							</tr>
							<tr>
								<td>ECT</td>
								<td>0</td>
								<td>0</td>
							</tr>
							<tr>
								<td>Clamp Checking</td>
								<td>0</td>
								<td>0</td>
							</tr>
							<tr>
								<td>Appearance</td>
								<td>0</td>
								<td>0</td>
							</tr>
							<tr>
								<td>QA</td>
								<td>0</td>
								<td>0</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td>Overall</td>
								<td>0</td>
								<td>0</td>
							</tr>
						</tfoot>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td colspan="2">DT/Delay/Andon - Color Coded</td>
			</tr>
			<tr>
				<td colspan="2">
					<table>
						<tbody>
							<tr>
								<td>Conveyor Speed</td>
								<td>0</td>
							</tr>
							<tr>
								<td>Takt Time</td>
								<td>0</td>
							</tr>
							<tr>
								<td>Working Time Plan</td>
								<td>0</td>
							</tr>
							<tr>
								<td>Working Time Actual</td>
								<td>0</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td colspan="2">
					Graph
				</td>
			</tr>
		</tbody>
	</table>

	<button id="btnEndProcess">End Process</button>
	<a href="pcs_page/index.php">
	<button type="button"  id="btnMainMenu">MainMenu</button>
	</a>
	

	<!-- jQuery -->
	<script src="plugins/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

	<script type="text/javascript">
		// DOMContentLoaded function
		document.addEventListener("DOMContentLoaded", () => {
			count_emp();
			setInterval(count_emp, 15000);
		});

		const count_emp = () => {
			let dept_pd = document.getElementById('dept_pd').value;
			let dept_qa = document.getElementById('dept_qa').value;
			let section = document.getElementById('section').value;
			let line_no = document.getElementById('line_no').value;
			$.ajax({
		        url:'process/emp_mgt_p.php',
		        type:'GET',
		        cache:false,
		        data:{
		            method:'count_emp',
		            dept_pd:dept_pd,
		            dept_qa:dept_qa,
		            section:section,
		            line_no:line_no
		        },
		        success:function(response){
		            try {
	                    let response_array = JSON.parse(response);
	                    if (response_array.message == 'success') {
                            document.getElementById('total_pd_mp').innerHTML = response_array.total_pd_mp;
                            document.getElementById('total_present_pd_mp').innerHTML = response_array.total_present_pd_mp;
                            document.getElementById('total_absent_pd_mp').innerHTML = response_array.total_absent_pd_mp;
                            document.getElementById('total_pd_mp_line_support_to').innerHTML = response_array.total_pd_mp_line_support_to;
                            document.getElementById('absent_ratio_pd_mp').innerHTML = `${response_array.absent_ratio_pd_mp}%`;

                            document.getElementById('total_qa_mp').innerHTML = response_array.total_qa_mp;
                            document.getElementById('total_present_qa_mp').innerHTML = response_array.total_present_qa_mp;
                            document.getElementById('total_absent_qa_mp').innerHTML = response_array.total_absent_qa_mp;
                            document.getElementById('total_qa_mp_line_support_to').innerHTML = response_array.total_qa_mp_line_support_to;
                            document.getElementById('absent_ratio_qa_mp').innerHTML = `${response_array.absent_ratio_qa_mp}%`;
	                    } else {
	                        console.log(response);
	                    }
	                } catch(e) {
	                    console.log(response);
	                }
		        }
		    });
		}
	</script>
</body>
</html>