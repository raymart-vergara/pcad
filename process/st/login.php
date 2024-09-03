<?php
session_name("pcad");
session_start();

require '../process/conn/pcad.php';

if (isset($_POST['login_btn'])) {

    $emp_no = addslashes($_POST['emp_no']);

    if (empty($emp_no)) {
        echo '<script>alert("Please Scan QR Code or Enter ID Number")</script>';
    } else {
        // MySQL
        // $check = "SELECT emp_no, full_name FROM m_st_accounts WHERE BINARY emp_no = '$emp_no'";
        // MS SQL Server
        $check = "SELECT emp_no, full_name FROM m_st_accounts WHERE emp_no = '$emp_no' COLLATE SQL_Latin1_General_CP1_CS_AS";
        $stmt = $conn_pcad->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            foreach($stmt->fetchALL() as $x){
                $emp_no = $x['emp_no'];
                $full_name = $x['full_name'];
            }
            
            $_SESSION['emp_no'] = $emp_no;
            $_SESSION['full_name'] = $full_name;
            header('location: st.php');
        } else {
            echo '<script>alert("Sign In Failed. Maybe an incorrect credential or account not found")</script>';
        }
    }
}

if (isset($_POST['Logout'])) {
    session_unset();
    session_destroy();
    header('location:/pcad/st_page/');
}
?>