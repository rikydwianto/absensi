<?php 
$id=get("id_suplier");
$q=mysql_query("select * from suplier where id_suplier='$id'");
$r=mysql_fetch_array($q);
?>
<h1 class='page-head-line'>Edit Suplier</h1>
<a href='<?php echo kembali() ?>'>Kembali</a>
<form method=post>
	<table class='table'>
		<tr>
			<td>Nama Suplier</td>
			<td><input type=text name='nama_sup' value='<?php echo $r['nama_suplier'] ?>' class='form-control'></td>
		</tr>
		<tr>
			<td>Telepon Suplier</td>
			<td><input type=text name='telp' value='<?php echo $r['telepon_suplier'] ?>'class='form-control'></td>
		</tr>
		<tr>
			<td>Alamat Suplier</td>
			<td><input type=text name='alamat' class='form-control' value='<?php echo $r['alamat_suplier'] ?>' /></td>
		</tr>
		<tr>
			<td>Keterangan Suplier</td>
			<td><textarea name='keterangan' class='form-control'><?php echo $r['keterangan_suplier'] ?></textarea></td>
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
	$q=mysql_query("update suplier set nama_suplier='$nama',telepon_suplier='$telp',alamat_suplier='$alamat',keterangan_suplier='$keterangan'
	where id_suplier='$id'");
	if($q)
		echo alert("Berhasil di simpan");
	else
		echo alert_error("Error : ".mysql_error());
}
 ?>