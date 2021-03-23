<?php 
$id=aman($_GET['id']);
$tgl = $_GET['tgl'];
$q=mysql_query("select * from karyawan 
		join jabatan on jabatan.id_jabatan=karyawan.id_jabatan 
		join departemen on departemen.id_departemen=jabatan.id_departemen 
		where id_karyawan='$id'") or die(alert_error("Query Error : ". mysql_error()));
$R=mysql_fetch_array($q);
?>
<h1>Tambah Biaya Berobat</h1>
<?php 
if(isset($_POST['tmb_biaya'])){
	$keterangan=aman($_POST['keterangan']);
	$biaya=aman($_POST['biaya']);
	$no_skd=aman($_POST['no_skd']);
	$cek=mysql_query("select * from sakit where tanggal_sakit='$tgl' and id_karyawan='$id'");
	if(mysql_num_rows($cek))
	{
		echo alert_error("Sudah pernah diinput!");
	}
	else{
		$q=mysql_query("insert into sakit(id_karyawan,no_surat_sakit,tanggal_sakit,keterangan_sakit,total_berobat) values('$id','$no_skd','$tgl','$keterangan','$biaya')");
		if($q)
			echo alert("Berhasil disimpan");
		else
			echo alert_error("Error : ". mysql_error());
		
	}
}
?>
<form method=post>
	<table class='table'>
		<tr>
			<td>NIK  </td>
			<td><?php echo $R['nik'] ?></td>
		</tr>
		<tr>
			<td>Nama  </td>
			<td><?php echo $R['nama_lengkap'] ?></td>
		</tr>
		<tr>
			<td>Tanggal  </td>
			<td><?php echo tanggal($tgl) ?></td>
		</tr>
		<tr>
			<td>No SKD</td>
			<td><input type=text name='no_skd' placeholder='00/LSG/<?php echo sprintf('%2s',date('m')).'/'.date("Y") ?>' class='form-control' /></td>
		</tr>
		<tr>
			<td>Biaya Berobat</td>
			<td><input type=number name='biaya' class='form-control' /></td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td><textarea name='keterangan' placeholder='Keterangan Sakit atau keterangan biaya...' class='form-control'></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type=submit name='tmb_biaya' value='Simpan'  class='btn btn-danger btn-flat'></td>
		</tr>
	</table>
</form>