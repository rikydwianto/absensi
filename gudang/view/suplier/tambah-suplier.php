<h1 class='page-head-line'>Tambah Suplier</h1>
<form method=post>
	<table class='table'>
		<tr>
			<td>Nama Suplier</td>
			<td><input type=text name='nama_sup' required class='form-control'></td>
		</tr>
		<tr>
			<td>Telepon Suplier</td>
			<td><input type=text name='telp' class='form-control'></td>
		</tr>
		<tr>
			<td>Alamat Suplier</td>
			<td><input type=text name='alamat' class='form-control'></td>
		</tr>
		<tr>
			<td>Keterangan Suplier</td>
			<td><textarea name='keterangan' class='form-control'></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type=submit name='simpan' value='Simpan' class='btn btn-danger'/></td>
		</tr>
	</table>
</form>
<?php
if(isset($_POST['simpan']))
{
	$nama=post("nama_sup");
	$telp=post("telp");
	$alamat=post("alamat");
	$keterangan=post("keterangan");
	$q=mysql_query("insert into suplier (nama_suplier,telepon_suplier,alamat_suplier,keterangan_suplier) 
	values('$nama','$telp','$alamat','$keterangan')");
	if($q)
		echo alert("Berhasil di simpan");
	else
		echo alert_error("Error : ".mysql_error());
}
 ?>