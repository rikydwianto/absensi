<?php 
include"fungsi/absen.php";
include"fungsi/karyawan.php";
?>
<section class="content-header">
  <h1>
    Absen Manual
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=absen_manual') ?>">Absen</a></li>
    <li class="active">Manual</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Absen Manual</h3>
    </div>
    <div class="box-body">
	<br/>
	<div>
	<form method=post>
		<table class='table'>
			<tr>
				<td>NIK</td>
				<td><input class='form-control' required placeholder='NIK ...' autofocus type=text name='nik'></td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td><input class='form-control' id='tgl4' value='<?php echo date("Y-m-d") ?>' type=text name='tanggal'></td>
			</tr>
			<tr>
				<td>Jam Masuk</td>
				<td><input class='form-control' value='<?php echo date("H:i:s") ?>' type=text name='masuk'></td>
			</tr>
			<tr>
				<td>Jam Keluar</td>
				<td><input class='form-control' type=text name='keluar'></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input class='btn btn-info btn-flat' type=submit value='Absen' name='absen'>
					<input class='btn btn-danger btn-flat' type=reset value='Hapus'>
				</td>
			</tr>
		</table>
	</form>
    </div>
<?php 
if(isset($_POST['absen']))
{
	$nik=aman($_POST['nik']);
	$nik=cek_nik($nik);
	if($nik){
		$idkaryawan=$nik->id_karyawan;
		$masuk=$_POST['masuk'];
		$tanggal=$_POST['tanggal'];
		$keluar=$_POST['keluar'];
		$tx="insert into absen(id_karyawan,tanggal_absen,jam_masuk) values($idkaryawan,'$tanggal','$masuk')";
		$q=mysql_query("$tx");
		$id=mysql_insert_id();
		if(empty($keluar))
			mysql_query("update absen set jam_keluar=NULL where id_absen='$id'");
		else
			mysql_query("update absen set jam_keluar='$keluar' where id_absen='$id'");

		if($q)
			echo alert("$nik->nama_lengkap Berhasil Absen");
		else
			echo alert_error("Error : ". mysql_error());
	}
	else
	{
		echo alert_error("NIK TIDAK DITEMUKAN");
	}
}
?>
</section>