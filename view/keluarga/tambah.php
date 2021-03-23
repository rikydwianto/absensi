<?php

if(isset($_POST['tambah-keluarga']))
{
	$id=aman($_GET['id']);
	$nama_keluarga=aman($_POST['nm_keluarga']);
	$tgl=ubah_tanggal($_POST['tgl']);
	$status=aman($_POST['status']);
	$kerja=aman($_POST['kerja']);
	$catatan=aman($_POST['catatan']);
	$q=mysql_query("
	insert into keluarga(id_karyawan,nama_lengkap,tgl_lahir,status,pekerjaan,catatan)
	values('$id','$nama_keluarga','$tgl','$status','$kerja','$catatan')
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
			<td>Nama Keluarga</td>
			<td>
				<input type=text name='nm_keluarga' class='form-control'>
			</td>
		</tr>
		<tr>
			<td>Tanggal Lahir</td>
			<td><input class='form-control' required type=text id='tgl1' name='tgl'/></td>
		</tr>
		<tr>
			<td>Status</td>
			<td><input class='form-control' type=text name='status'/></td>
		</tr>
		<tr>
			<td>Pekerjaan</td>
			<td><input type=text name='kerja' class='form-control'/></td>
		</tr>
		<tr>
			<td>Catatan</td>
			<td><textarea class='form-control' name='catatan'></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type=submit class='btn btn-info' value='Simpan' name='tambah-keluarga'/>
				<input type=reset class='btn btn-danger' value='Reset' />
			
			</td>
		</tr>
	</table>
</form>