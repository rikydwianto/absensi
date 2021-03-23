<?php 
include_once"fungsi/departemen.php";
include_once"fungsi/jabatan.php";
include_once"fungsi/karyawan.php";
$breadcrumd=$_GET['mn'];
?>
<section class="content-header">
  <h1>
    Berkas Karyawan
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Berkas</a></li>
    <li class="active">Karyawan</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Berkas Karyawan</h3>
		</div>
		<div class="box-body">
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
							include"view/berkas/tambah.php";
						break;
						case"edit":
							include"view/berkas/edit.php";
						break;
						case"hapus":
							include"view/berkas/hapus.php";
						break;
						case"hapus-semua":
							include"view/berkas/hapus-semua.php";
						break;
					}
				}
				else
					include"view/berkas/tampil.php";
				
				?>
			</div>
		</div>
    </div>

</section>


