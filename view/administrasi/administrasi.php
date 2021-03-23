<?php 
$breadcrumd=$_GET['mn'];
@$ket=$_GET['ket'];
@$url1=($_GET['url'] == '' ) ? url('index.php?mn=administrasi&ket=sakit') : $_GET['url'];
@$tahun=$_GET['tahun'];
if(!isset($_GET['tgl'])) 
	$tgl = date('Y-m-d') ;
else
{
	@$tgl=$_GET['tgl'];
	@$ex=explode("/",$tgl);
	@$tgl=$ex[2].'-'.$ex[1].'-'.$ex[0];
}

?>
<section class="content-header">
  <h1>
    Administrasi
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd.'&ket='.$ket) ?>">Administrasi</a></li>
    <li class="active"><?php echo (@$ket) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Administrasi </h3>
		</div>
		<div class="box-body">
			<div >
				<a href='<?php echo $url1; ?>' class='btn btn-danger'><i class='fa fa-angle-double-left'></i> Kembali </a>
				<a href='<?php echo url('index.php?mn=administrasi&ket='.$ket)?>' class='btn btn-info'><i class='fa fa-calendar'></i> Hari ini </a>
				<a href='<?php echo url('index.php?mn=administrasi&act=tambah')?>' class='btn btn-success'><i class='fa fa-plus'></i> Tambah Absen </a>
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
			</div>
			<br/>
			<h2>Administrasi - <?php echo strtoupper($ket) ?> </h2></hr>
			<h3>Tanggal : <?php echo (isset($_GET['act'])) ? '' : tanggal($tgl) ?> </h3></hr>
			<form method='get'>
				<input type=hidden name='mn' value='administrasi' />
				<input type=hidden name='ket' value='<?php echo $ket ?>' />
				<input type=text name='tgl' required value='<?php echo @$_GET['tgl'] ?>' id='tgl1' placeholder='DD/MM/YYYY'/>
				<input type=submit  value='Lihat' />
				
			</form>
			<div>
			<!-- TAMPIL BULAN -->
				<?php 
				if(isset($_GET['act'])){
					$menu=$_GET['act'];
					if($menu=='tambah_biaya')
						include_once"view/administrasi/tambah_biaya.php";	
					else if($menu=='tambah')
						include_once"view/administrasi/tambah.php";				
				}	
				else
					include"view/administrasi/lihat_kehadiran.php";
				?>
			</div>
			
		</div>
    </div>

</section>