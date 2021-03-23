<?php 
include_once"fungsi/absen.php";
$breadcrumd=$_GET['mn'];
?>
<section class="content-header">
  <h1>
    Lemburan
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Lemburan</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Lemburan</h3>
		</div>
		<div class="box-body">
			<div >
				<a href='<?php echo url('index.php?mn=lembur') ?>' class='btn btn-success'><i class='fa fa-eye'></i> Data Lemburan</a>
				<a href='<?php echo url('index.php?mn=lembur&act=setting') ?>' class='btn btn-danger'><i class='fa fa-plus'></i> Lembur </a>
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
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
						
						case"setting":
							include"view/absen/lembur-setting.php";
						break;
						case"edit":
							include"view/absen/edit.php";
						break;
						case"hapus":
							include"view/absen/hapus.php";
						break;
					}
				}
				else
					include"view/absen/data-lembur.php";
				
				?>
			</div>
		</div>
    </div>

</section>