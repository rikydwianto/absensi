<?php include"fungsi/karyawan.php"; ?>
<?php include"fungsi/departemen.php"; ?>
<?php include"fungsi/jabatan.php"; ?>
<?php include"fungsi/absen.php"; ?>
<section class="content-header">
  <h1>
    Manage User
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=user') ?>">User</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">User</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Sembunyikan"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Tutup"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
		<a class='btn btn-success btn-flat' href='<?php echo url('index.php?mn=user') ?>'><i class='fa fa-eye'></i> Lihat</a>
		<a class='btn btn-danger btn-flat' href='<?php echo url('index.php?mn=user&act=tambah') ?>'><i class='fa fa-plus'></i> Tambah</a>
		<a class='btn btn-info btn-flat' href=''><i class='fa fa-repeat'></i> Reload</a>
	 <div class="clearfix"></div>
      <?php
	  if(isset($_GET['act']))
	  {
		@$id=aman($_GET['id']);
		$mn=$_GET['act'];
		if($mn=='hapus')
		{
			mysql_query("delete from user where id_user='$id'");
			direct(url("index.php?mn=user"));
		}
		else if($mn=='tambah')
		{
			include"view/user/tambah.php";
		}
		else if($mn=='edit')
		{
			include"view/user/edit.php";
		}
		else
			include"view/error/404biasa.php";
	  }
	  else
		include"view/user/user-tampil.php";
	?>
    </div>
	</div>
</section>