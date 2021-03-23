<h1 class='page-head-line'>Tambah style</h1>
<?php echo tombol_kembali() ?>
<form method=post>
	<table class='table'>
		<tr>
			<td>Kode style</td>
			<td><input type=text name='kode_style' required class='form-control'></td>
		</tr>
		<tr>
			<td>Nama Style</td>
			<td><input type=text name='style' class='form-control'></td>
		</tr>
		<tr>
			<td>Keterangan style</td>
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
	$id=get("id_buyer");
	$kode=post("kode_style");
	$nama=post("style");
	$keterangan=post("keterangan");
	$q=mysql_query("insert into style (id_buyer,kode_style,nama_style,keterangan_style) 
	values('$id','$kode','$nama','$keterangan')");
	if($q)
		echo alert("Berhasil di simpan");
	else
		echo alert_error("Error : ".mysql_error());
}
 ?>