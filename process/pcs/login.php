<?php
session_name("pcad");
session_start();

require '../../process/conn/pcad.php';

if (isset($_POST['login_pcs_btn'])) {

    $emp_id = addslashes($_POST['emp_id']);

    if (empty($emp_id)) {
        echo '<script>alert("Please Scan QR Code or Enter ID Number")</script>';
    } else {
        // MySQL
        // $check = "SELECT emp_id, full_name FROM m_pcs_accounts WHERE BINARY emp_id = '$emp_id'";
        // MS SQL Server
        $check = "SELECT emp_id, full_name FROM m_pcs_accounts WHERE emp_id = '$emp_id' COLLATE SQL_Latin1_General_CP1_CS_AS";
        $stmt = $conn_pcad->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            foreach($stmt->fetchALL() as $x){
                $emp_id = $x['emp_id'];
                $full_name = $x['full_name'];
            }
            
            $_SESSION['emp_id'] = $emp_id;
            $_SESSION['full_name'] = $full_name;
            header('location: pcs.php');
        } else {
            echo '<script>alert("Sign In Failed. Maybe an incorrect credential or account not found")</script>';
        }
    }
}

if (isset($_POST['Logout'])) {
    session_unset();
    session_destroy();
    header('location:/pcad/pcs_page/admin/');
}
?>