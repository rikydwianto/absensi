<?php 
$id=get("id_satuan");

?>
<?php
if(isset($_POST['simpan']))
{
	$nama=post("satuan");
	$keterangan=post("keterangan");
	$q=mysql_query("update satuan set satuan='$nama',keterangan_satuan='$keterangan' where id_satuan='$id'");
	if($q)
		echo alert("Berhasil di simpan");
	else
		echo alert_error("Error : ".mysql_error());
}
$q=mysql_query("select * from satuan where id_satuan='$id'");
$r=mysql_fetch_array($q);
 ?>
<h1 class='page-head-line'>Edit Satuan</h1>
<form method=post>
	<table class='table'>
		<tr>
			<td>Nama Satuan</td>
			<td><input type=text name='satuan' value="<?php echo $r["satuan"] ?>" required class='form-control'></td>
		</tr>
		<tr>
			<td>Keterangan Satuan</td>
			<td><textarea name='keterangan' class='form-control'><?php echo $r["keterangan_satuan"] ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type=submit name='simpan' value='Simpan' class='btn btn-danger'/></td>
		</tr>
	</table>
</form>
