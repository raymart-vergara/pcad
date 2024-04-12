 <footer class="main-footer">
    <strong>Copyright &copy; 2024. Developed by: Jane Irish Bautista & AKM</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
<?php
//MODALS
include '../../modals/logoutpcs.php';
include '../../modals/addpcs.php';
include '../../modals/updatepcs.php';
include '../../modals/deletepcs.php';
include '../../modals/add_inspection.php';
include '../../modals/update_inspection.php';
include '../../modals/delete_inspection.php';
?>
<!-- jQuery -->
<script src="../../plugins/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- SweetAlert2 -->
<script type="text/javascript" src="../../plugins/sweetalert2/dist/sweetalert2.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.js"></script>

</body>
</html>