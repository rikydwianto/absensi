<?php
include"config/setting.php";
include"config/koneksi.php";
include"fungsi/config.php";
include"fungsi/lihat.php";
cek_login();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include"view/template/link-head.php"; ?>
  </head>
  <body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

      <?php include"view/template/header.php" ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include"view/template/sidebar.php"; ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <?php include"control/index.php"; ?>
		
      </div><!-- /.content-wrapper -->
      <?php include"view/template/text-footer.php"; ?>

      <!-- Control Sidebar -->
      <?php // include"view/template/control.php"; ?>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

   <?php include"view/template/footer.php";?>
   <?php 
  ?>
  </body>
</html>
