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
<section class="content-header">
  <h1>
    Lembur Hari
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Lembur Hari</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Lembur Hari </h3>
		</div>
		<div class="box-body">
			<div >
				<a href='<?php echo $url1; ?>' class='btn btn-danger'><i class='fa fa-angle-double-left'></i> Kembali </a>
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
			</div>
			<br/>
			<h2>Lembur Hari </h2></hr>
			<b>Pilih Tahun, Kemudian pilih Bulan</b>
			<div class='col-sm-4 pull-right'>
				<form method=get>
					<input type=hidden name='mn' value='lembur-hari'/>
					<div class="input-group">
					  <select name='tahun' class='form-control' aria-describedby="basic-addon1">
							<?php 
							$th=date("Y");
							for($a=$th;$a>2010;$a--)
							{
								if(@$_GET['tahun']==$a)
									$ts="selected";
								else
									$ts="";
								echo "<option $ts value='$a'>$a</option>";
							}
							?>
						</select>
					  <span class="input-group-btn" id="basic-addon1">
						<input type=submit value='Lihat Bulan' class='form-control' id="search-btn"  class=' btn-flat btn-sm btn-danger' name='lihat'/>
					  </span>
					</div>
						
					<input type=hidden value='<?php echo $url1 ?>' name='url'/>
					
				</form>
			</div><br/><br/>
			<div>
			<!-- TAMPIL BULAN -->
				<?php 
				if(isset($_GET['act'])){
					$menu=$_GET['act'];
					if($menu=='lihat_lembur')
						include_once"view/lembur/lihat_lembur_hari.php";
					else if($menu=='tambah')
						include_once"view/lembur/tambah-lembur.php";
					else if($menu=='hapus')
						include_once"view/lembur/hapus-lembur.php";
					else if($menu=='edit')
						include_once"view/lembur/edit-lembur.php";
				}
				else
					include"view/lembur/pilih_bulan.php";
				?>
			</div>
			
		</div>
    </div>

</section>