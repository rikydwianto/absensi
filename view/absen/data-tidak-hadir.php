<?php 
include_once"fungsi/absen-absen.php";
include_once"fungsi/karyawan.php";
include_once"fungsi/departemen.php";
include_once"fungsi/jabatan.php";
$breadcrumd=$_GET['mn'];
?>
<section class="content-header">
  <h1>
    Absen
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Tidak Absen/Tidak Hadir</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Belum absen/Tidak Hadir </h3>
		</div>
		<div class="box-body">
			<div >
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
			</div>
			<br/>
			<?php 
			if(isset($_GET['cr']))
			{
				$tgl=$_GET['tgl'];
				$ex=explode("/",$tgl);
				$tgl=$ex[2].'-'.$ex[1].'-'.$ex[0];
				$id_jabatan=aman($_GET['jab']);
			}
			else
			{	
				$id_jabatan=null;
				$tgl=date("Y-m-d");
			}
			?>
			<h2>Data Tidak hadir <?php echo tanggal($tgl) ?></h2>
			<form method=get>
			Pilih  : 
			<input type=hidden name='mn' value='data-tidak-hadir' id=''/>
			<input type=text name='tgl' value='<?php echo date("d/m/Y",strtotime(@$tgl)) ?>' id='tgl1' data-inputmask="'alias': 'dd/mm/yyyy'" data-mask />
				<select name='jab' id='dept' class='sel1ect2'>
					<option value=''>Tampilkan Semua </option>
					<?php 
					$Qdep=tampil_departemen();
					while($rDep=mysql_fetch_object($Qdep))
					{
						if($rDep->id_departemen==$id_jabatan)
							echo "<option selected value='$rDep->id_departemen'>$rDep->nama_departemen</option>";
						else
							echo "<option value='$rDep->id_departemen'>$rDep->nama_departemen</option>";
						
					}
					?>
				</select>
				<input type=submit value='Cari' class='' name='cr'/>

			</form>
			<?php 
				if(isset($_GET['ket']))
				{
					$status=aman($_GET['ket']);
					$tanggal=date("Y-m-d",strtotime(date($_GET['tanggal'])));
					$id=aman($_GET['id']);
					$q=mysql_query("select count(*) as hitung from absen where id_karyawan='$id' and tanggal_absen='$tanggal'");
					$hitung=mysql_fetch_object($q);
					if($hitung->hitung==0)
					{
						mysql_query("insert into absen (id_karyawan,tanggal_absen,keterangan_hadir,date_created,jam_masuk,jam_keluar)values
						('$id','$tanggal','$status',now(),'00:00:00','00:00:00')") or die(alert_error(mysql_error()));	
					}
					direct(urldecode($_GET['url']));
				}
				else
					include"view/absen/data-tidak-hadir-tampil.php";
				
				?>
		</div>
    </div>

</section>