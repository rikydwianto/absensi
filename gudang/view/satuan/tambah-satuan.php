<h1 class='page-head-line'>Tambah Suplier</h1>
<form method=post>
	<table class='table'>
		<tr>
			<td>Nama Satuan</td>
			<td><input type=text name='satuan' required class='form-control'></td>
		</tr>
		<tr>
			<td>Keterangan Satuan</td>
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
	$nama=post("satuan");
	$keterangan=post("keterangan");
	$q=mysql_query("insert into satuan (satuan,keterangan_satuan) 
	values('$nama','$keterangan')");
	if($q)
		echo alert("Berhasil di simpan");
	else
		echo alert_error("Error : ".mysql_error());
}
 ?>