<?php 
include_once"fungsi/jabatan.php";
include_once"fungsi/departemen.php";
?>
<section class="content-header">
  <h1>
    Jabatan
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=jabatan') ?>">Jabatan</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Jabatan</h3>
		</div>
		<div class="box-body">
			<div >
				<a href='<?php echo url('index.php?mn=jabatan') ?>'   class='btn btn-success'><i class='fa fa-eye'></i> Tampilkan </a>
				<a href='<?php echo url('index.php?mn=jabatan&act=tambah') ?>'   class='btn btn-info'><i class='fa fa-plus'></i> Tambah </a>
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
				<a href='<?php echo url('index.php?mn=tambah-departemen') ?>' class='btn btn-danger disabled'><i class='fa fa-file-pdf-o'></i> Export PDF </a>
				<a href='<?php echo url('laporan/jabatan.php') ?>' class='btn btn-danger'><i class='fa fa-file-pdf-o'></i> Export Excel </a>
			</div>
			<br/>
			<div>
				<!-- ISI WEB -->
				<?php 
				if(isset($_GET['act']))
				{
					switch($_GET['act'])
					{
						default:
							include"view/error/404biasa.php";
						break;
						
						case"tambah":
							include"view/jabatan/tambah.php";
						break;
						case"edit":
							include"view/jabatan/edit.php";
						break;
						case"hapus":
							include"view/jabatan/hapus.php";
						break;
					}
				}
				else
					include"view/jabatan/tampil.php";
				
				?>
			</div>
		</div>
    </div>

</section>