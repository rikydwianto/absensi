<?php 
@$mn=$_GET['mn'];
if($mn=='')
	$home='class="active"';
else if($mn=='karyawan')
	$karyawan='active';
else if($mn=='karyawan_semua')
	$karyawan_rekap='active';
else if($mn=='karyawan_aktif')
	$karyawan_aktif='active';
else if($mn=='departemen')
	$departemen='active';
else if($mn=='jabatan')
	$jabatan='active';

?>
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
	  <!-- Sidebar user panel -->
	  <div class="user-panel">
		<div class="pull-left image">
		  <img src="<?php echo url(cek_photo($user->id_karyawan) ) ?>" class="img img-circle img-responsive" alt="User Image">
		</div>
		<div class="pull-left info">
		  <p><?php echo $user->nama_lengkap ?></p>
		  <small>
		  <?php echo $user->nama_jabatan ?> <br/>
		  <?php echo $user->nama_departemen ?></small>
		</div>
	  </div>
		  <br/>
	  <!-- search form -->
	  <form action="<?php echo url('index.php?mn=karyawan') ?>" method="get" class="sidebar-form">
		<div class="input-group">
		  <input type="hidden" name="mn" value='karyawan' >
		  <input type="text" name="q" class="form-control" value='<?php echo aman(@$_GET['q']) ?>' placeholder="Nik/Nama karyawan">
		  <span class="input-group-btn">
			<button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
		  </span>
		</div>
	  </form>
	  <!-- /.search form -->
	  <!-- sidebar menu: : style can be found in sidebar.less -->
	  <ul class="sidebar-menu">
		<li class="header">MAIN NAVIGATION</li>
		<li <?php echo @$home ?>>
		  <a href="<?php echo url() ?>">
			<i class="fa fa-home"></i> <span> Home</span>
		  </a>
		</li>
		<!--<li >
		  <a href="<?php echo url('absen.php') ?>" target=_blank>
			<i class="fa fa-clock-o"></i>
			<span>Mesin Absen</span>
			<i class="fa fa-angle-right pull-right"></i>
		  </a>
		</li>-->
		<li >
		  <a href="<?php echo url('camv2.php') ?>" target=_blank>
			<i class="fa fa-clock-o"></i>
			<span>Mesin Absen w/ Capture</span>
			<i class="fa fa-angle-right pull-right"></i>
		  </a>
		</li>
		<li >
		  <a href="<?php echo url('cari.php') ?>" target=_blank>
			<i class="fa fa-search"></i>
			<span>Cari Nik</span>
			<i class="fa fa-angle-right pull-right"></i>
		  </a>
		</li>
		<li >
		  <a href="<?php echo url('index.php?mn=absen_manual') ?>">
			<i class="fa fa-clock-o"></i>
			<span>Absen Manual</span>
			<i class="fa fa-angle-right pull-right"></i>
		  </a>
		</li>
		<!--<li >
		  <a href="<?php echo url('index.php?mn=administrasi&act=tambah') ?>">
			<i class="fa fa-clock-o"></i>
			<span>Absen </span>
		  </a>
		</li>-->
		<li class="treeview <?php echo @$jabatan.@$departemen ?>">
		  <a href="#">
			<i class="fa fa-database"></i>
			<span>Data Utama</span>
			<span class="fa fa-angle-left pull-right"></span>
		  </a>
		  <ul class="treeview-menu ">
			<li class='<?php echo @$departemen ?>'><a href="<?php echo url('index.php?mn=departemen') ?>"><i class="fa fa-circle-o"></i> Departemen</a></li>
			<li class='<?php echo @$jabatan ?>'><a href="<?php echo url('index.php?mn=jabatan') ?>"><i class="fa fa-circle-o"></i> Jabatan</a></li>
		  </ul>
		</li>
		<li class="treeview <?php echo @$karyawan ?>" >
		  <a href="#">
			<i class="fa fa-users"></i> <span>Karyawan</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu " >
			<li class='<?php echo @$karyawan ?>' ><a href="<?php echo url('index.php?mn=karyawan&act=tambah') ?>"><i class="fa fa-plus"></i> Tambah Karyawan</a></li>
			<li class='<?php echo @$karyawan ?>' ><a href="<?php echo url('index.php?mn=karyawan') ?>"><i class="fa fa-circle-o"></i> Data</a></li>
			<li class='<?php echo @$karyawan_aktif ?>' ><a href="<?php echo url('index.php?mn=karyawan_aktif') ?>"><i class="fa fa-circle-o"></i> Data Per Line(Aktif)</a></li>
			<li class='<?php echo @$karyawan_rekap ?>' ><a href="<?php echo url('index.php?mn=karyawan_semua') ?>"><i class="fa fa-circle-o"></i> Data(Table Matrix)</a></li>
			<!--<li><a href="<?php echo url('index.php?mn=daftar_keluarga') ?>"><i class="fa fa-circle-o"></i> Data Keluarga</a></li>-->
			<li><a href="<?php echo url('index.php?mn=daftar_pendidikan') ?>"><i class="fa fa-circle-o"></i> Riwayat Pendidikan</a></li>
			<!--<li><a href="<?php echo url('index.php?mn=daftar_riwayatkerja') ?>"><i class="fa fa-circle-o"></i> Riwayat Kerja</a></li>-->
			<!-- <li><a href="<?php echo url('index.php?mn=daftar_berkas') ?>"><i class="fa fa-circle-o"></i> Berkas</a></li> -->
		  </ul>
		</li>
		<li class="treeview">
		  <a href="#">
			<i class="fa fa-tasks"></i>
			<span>Presensi</span>
			<i class='fa fa-angle-left pull-right'></i>
			</a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo url('index.php?mn=lembur') ?>" ><i class="fa fa-circle-o"></i> Lembur</a></li>
			<li><a href="<?php echo url('index.php?mn=libur-nasional') ?>" ><i class="fa fa-circle-o"></i> Libur Nasional</a></li>
			<li><a href="<?php echo url('index.php?mn=lembur-hari') ?>" ><i class="fa fa-circle-o"></i> Lembur Hari</a></li>
			<li><a href="<?php echo url('index.php?mn=absen') ?>"><i class="fa fa-circle-o"></i> Data Absen</a></li>
			<li><a href="<?php echo url('index.php?mn=data-tidak-hadir') ?>"><i class="fa fa-circle-o"></i> Data yang tidak absen</a></li>
			<li><a href="<?php echo url('index.php?mn=rekap_absen') ?>"><i class="fa fa-circle-o"></i> Rekap Rincian Absen</a></li>
			<!--<li><a href="<?php echo url('index.php?mn=rekap') ?>"><i class="fa fa-circle-o"></i> Rekap Absen Total</a></li>-->
			<li><a href="<?php echo url('index.php?mn=rekap-total-range') ?>"><i class="fa fa-circle-o"></i> Rekap Absen Range</a></li>
			<li><a href="<?php echo url('index.php?mn=rekap-grade') ?>"><i class="fa fa-circle-o"></i> Rekap Grade Karyawan</a></li>
		  </ul>
		</li>
		<li class="treeview">
		  <a href="#">
			<i class="fa fa-book"></i> <span>Administrasi</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo url('index.php?mn=daftar_resign') ?>"><i class="fa fa-circle-o"></i> Data Resign</a></li>
			<!--<li><a href="<?php echo url('index.php?mn=sp') ?>"><i class="fa fa-circle-o"></i> Surat Peringatan</a></li>-->
			<!-- <li><a href=""><i class="fa fa-circle-o"></i> Cuti</a></li> -->
			<li><a href="<?php echo url('index.php?mn=administrasi&ket=izin') ?>"><i class="fa fa-circle-o"></i> Izin</a></li>
			<!--<li><a href="<?php echo url('index.php?mn=administrasi&ket=sakit') ?>"><i class="fa fa-circle-o"></i> Berobat</a></li>-->
		  </ul>
		</li>
		<!--<li class="treeview">
		  <a href="#">
			<i class="fa fa-bar-chart-o"></i> <span>Laporan Grafik</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo url('index.php?mn=grafik&grafik=jk') ?>"><i class="fa fa-circle-o"></i> Jenis Kelamin</a></li>
		  </ul>
		</li> -->
		<li >
		  <a href="<?php echo url('index.php?mn=user') ?>" >
			<i class="fa fa-user"></i>
			<span>User</span>
		  </a>
		</li>
		<li >
		  <a href="<?php echo url('index.php?mn=log') ?>" >
			<i class="fa fa-clock-o"></i>
			<span>Log History</span>
		  </a>
		</li>
		<li >
		  <a href="<?php echo url('index.php?mn=history') ?>" >
			<i class="fa fa-clock-o"></i>
			<span>History Absen</span>
		  </a>
		</li>
	</ul>
	</section>
<!-- /.sidebar -->
</aside>