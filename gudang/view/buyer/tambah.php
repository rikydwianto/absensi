<h1 class='page-head-line'>Tambah buyer</h1>
<form method=post>
	<table class='table'>
		<tr>
			<td>Nama buyer</td>
			<td><input type=text name='nama_sup' required class='form-control'></td>
		</tr>
		<tr>
			<td>Lembaga/Instansi buyer</td>
			<td><input type=text name='instansi' class='form-control'></td>
		</tr>
		<tr>
			<td>Telepon buyer</td>
			<td><input type=text name='telp' class='form-control'></td>
		</tr>
		<tr>
			<td>Alamat buyer</td>
			<td><input type=text name='alamat' class='form-control'></td>
		</tr>
		<tr>
			<td>Keterangan buyer</td>
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
	$instansi=post("instansi");
	$alamat=post("alamat");
	$keterangan=post("keterangan");
	$q=mysql_query("insert into buyer (nama_buyer,instansi_buyer,telepon_buyer,alamat_buyer,keterangan_buyer) 
	values('$nama','$instansi','$telp','$alamat','$keterangan')");
	if($q)
		echo alert("Berhasil di simpan");
	else
		echo alert_error("Error : ".mysql_error());
}
 ?>