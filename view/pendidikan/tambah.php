<?php

if(isset($_POST['tambah-pendidikan']))
{
	$id=aman($_GET['id']);
	$nama_pendidikan=aman($_POST['nama_pendidikan']);
	$alamat=aman($_POST['alamat_pendidikan']);
	$masuk=aman($_POST['masuk']);
	$lulus=aman($_POST['lulus']);
	$ket=aman($_POST['catatan']);
	$q=mysql_query("
	INSERT INTO `riwayat_pendidikan` (`id_riwayat_pendidikan`, `id_karyawan`, `nama_pendidikan`, `alamat_pendidikan`, `thn_masuk`, `thn_lulus`, `keterangan`, `date_created`)
	VALUES (NULL, '$id', '$nama_pendidikan', '$alamat', '$masuk', '$lulus', '$ket', now());
	");
	if($q)
	{
		echo alert("Berhasil Ditambahkan");
	}
	else
	{
		echo alert_error("Error : ". mysql_error());
	}
	
}

?>

<form method=post>
	<table class='table'>
		<tr>
			<td>Nama Pendidikan</td>
			<td>
				<input type=text required name='nama_pendidikan' class='form-control'>
			</td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td><textarea name='alamat_pendidikan' class='form-control'></textarea></td>
		</tr>
		<tr>
			<td>Masuk - Lulus</td>
			<td>
				<input class='' type=number name='masuk'/>
				<input class='' type=number name='lulus'/>
			</td>
		</tr>
		<tr>
			<td>Catatan</td>
			<td><textarea class='form-control' name='catatan'></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type=submit class='btn btn-info' value='Simpan' name='tambah-pendidikan'/>
				<input type=reset class='btn btn-danger' value='Reset' />
			
			</td>
		</tr>
	</table>
</form>