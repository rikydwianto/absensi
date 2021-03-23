<?php 
include_once"fungsi/absen-absen.php";
include_once"fungsi/karyawan.php";
include_once"fungsi/departemen.php";
include_once"fungsi/jabatan.php";
$breadcrumd=$_GET['mn'];
@$url1=($_GET['url'] == '' ) ? url('index.php?mn=lembur-hari') : $_GET['url'];
@$tahun=$_GET['tahun'];
if(empty($tahun))
	$tahun=date("Y");
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


<section class="content-header">
  <h1>
    Grafik
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Grafik</a></li>
    <li class="active"><?php echo (@$_GET['grafik']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Grafik </h3>
		</div>
		<div class="box-body">
			<div >
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
			</div>
			<br/>
			<div class='col-sm-4 pull-right'>
			</div><br/><br/>
			<div>
			<!-- TAMPIL BULAN -->
				<?php 
				if(isset($_GET['grafik'])){
					$menu=$_GET['grafik'];
					if($menu=='jk')
						include_once"view/grafik/jenis_kelamin.php";
					else if($menu=='tambah')
						include_once"view/lembur/tambah-lembur.php";
				}
				else
				{
					?>
				<a>Garafik Jenis Kelamin</a>
				<a>Garafik Kehadiran</a>
				<a>Garafik Kehadiran</a>
					<?php
				}
				?>
			</div>
			
		</div>
    </div>

</section>
