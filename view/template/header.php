<?php 

$id=aman($_SESSION['id_karyawan']);
@$user=cek_karyawan($id);
$idUser=$_SESSION['id_user'];
//error_reporting(0);
?>
<header class="main-header">
	<!-- Logo -->
	<a href="<?php echo url() ?>" class="logo">
	  <!-- mini logo for sidebar mini 50x50 pixels -->
	  <span class="logo-mini">LSG</span>
	  <!-- logo for regular state and mobile devices -->
	  <span class="logo-lg"><?php echo $title ?></span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
	  <!-- Sidebar toggle button-->
	  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
	  </a>
	  <div class="navbar-custom-menu">
		<ul class="nav navbar-nav">
		  <!-- Notifications: style can be found in dropdown.less -->
		  <!-- Tasks: style can be found in dropdown.less -->
		  <!-- User Account: style can be found in dropdown.less -->
		  <li class="dropdown user user-menu">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
			  <img src="<?php echo url(cek_photo($user->id_karyawan)) ?>" class="user-image" alt="User Image">
			  <span class="hidden-xs"> <?php echo $user->nama_lengkap ?> </span>
			</a>
			<ul class="dropdown-menu">
			  <!-- User image -->
			  <li class="user-header">
				<img src="<?php echo url(cek_photo($user->id_karyawan) ) ?>" class="img-circle" alt="User Image">
				<p>
				  <?php echo $user->nama_lengkap ?> -  <?php echo $user->nama_jabatan ?>
				  <small> <?php echo $user->nama_departemen ?></small>

				</p>
			  <!-- Menu Body -->
			  <!-- Menu Footer-->
			  <li class="user-footer">
				<div class="pull-left">
				  <a href="<?php echo url("index.php?mn=detail_karyawan&id=".$user->id_karyawan."&nik=".$user->nik.'&url='.url_ref())?>" class="btn btn-default btn-flat">Profile</a>
				  <a href="<?php echo url("index.php?mn=user&act=edit&id=".$idUser.'&url='.url_ref())?>" class="btn btn-default btn-flat"><i class='fa fa-gears'></i> Setting</a>
				</div>
				<div class="pull-right">
				  <a href="<?php echo url('logout.php') ?>" class="btn btn-default btn-flat">Sign out</a>
				</div>
			  </li>
			</ul>
		  </li>
		</ul>
	  </div>
	</nav>
  </header>