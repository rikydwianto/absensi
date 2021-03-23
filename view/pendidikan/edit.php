<?php
$id=aman($_GET['id_pend']);
$id_karyawan=aman($_GET['id']);
if(isset($_POST['edit-pendidikan']))
{
	$id=aman($_GET['id_pend']);
	$id_karyawan=aman($_GET['id']);
	$nama_pendidikan=aman($_POST['nama_pendidikan']);
	$alamat=aman($_POST['alamat_pendidikan']);
	$masuk=aman($_POST['masuk']);
	$lulus=aman($_POST['lulus']);
	$ket=aman($_POST['catatan']);
	$q="update riwayat_pendidikan set nama_pendidikan='$nama_pendidikan', alamat_pendidikan='$alamat', thn_masuk='$masuk', 
	thn_lulus='$lulus', keterangan='$ket', date_modified=now()
	where id_riwayat_pendidikan='$id' 
	";
	echo $q;
	$q=mysql_query("$q") ;
	if($q)
	{
		echo alert("Berhasil DIedit");
	}
	else
	{
		echo alert_error("Error : ". mysql_error());
	}
	
}

$q=mysql_query("select * from riwayat_pendidikan where id_riwayat_pendidikan='$id' and id_karyawan='$id_karyawan'") or die(alert_error(mysql_error()));
$pen=mysql_fetch_object($q);
?>

<form method=post>
	<table class='table'>
		<tr>
			<td>Nama Pendidikan</td>
			<td>
				<input type=text required value='<?php echo $pen->nama_pendidikan ?>' name='nama_pendidikan' class='form-control'>
			</td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td><textarea name='alamat_pendidikan' class='form-control'><?php echo $pen->alamat_pendidikan ?></textarea></td>
		</tr>
		<tr>
			<td>Masuk - Lulus</td>
			<td>
				<input class='' type=number name='masuk' value='<?php echo $pen->thn_masuk ?>'/>
				<input class='' type=number name='lulus' value='<?php echo $pen->thn_lulus ?>'/>
			</td>
		</tr>
		<tr>
			<td>Catatan</td>
			<td><textarea class='form-control' name='catatan'><?php echo $pen->keterangan ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type=submit class='btn btn-info' value='Simpan' name='edit-pendidikan'/>
				<input type=reset class='btn btn-danger' value='Reset' />
			
			</td>
		</tr>
	</table>
</form>