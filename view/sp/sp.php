<section class="content-header">
  <h1>
    Surat Peringatan Karyawan
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=') ?>">Karyawan </a></li>
    <li class="active">Surat Peringatan</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
	<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Surat Peringatan </h3>
		</div>
		<div class="box-body">
			<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
			<br/>
			<?php 
			@$act = $_GET['act'];
			switch($act){
				case "delete":
				break;
				default:
					include"view/sp/tampil_sp.php";
				break;
			}
			?>
		</div>
	</div>

</section>