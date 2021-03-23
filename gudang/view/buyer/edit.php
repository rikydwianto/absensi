<?php 
$id=get("id_buyer");
if(isset($_POST['simpan']))
{
	$nama=post("nama_sup");
	$telp=post("telp");
	$alamat=post("alamat");
	$instansi=post("instansi");
	$keterangan=post("keterangan");
	$q=mysql_query("update buyer set nama_buyer='$nama',instansi_buyer='$instansi',telepon_buyer='$telp',alamat_buyer='$alamat',keterangan_buyer='$keterangan'
	where id_buyer='$id'");
	if($q)
		echo alert("Berhasil di simpan");
	else
		echo alert_error("Error : ".mysql_error());
}
$q=mysql_query("select * from buyer where id_buyer='$id'");
$r=mysql_fetch_array($q);
?>

<h1 class='page-head-line'>Edit buyer</h1>
<a href='<?php echo kembali() ?>'>Kembali</a>
<form method=post>
	<table class='table'>
		<tr>
			<td>Nama buyer</td>
			<td><input type=text name='nama_sup' value='<?php echo $r['nama_buyer'] ?>' class='form-control'></td>
		</tr>
		<tr>
			<td>Instansi</td>
			<td><input type=text name='instansi' value='<?php echo $r['instansi_buyer'] ?>' class='form-control'></td>
		</tr>
		<tr>
			<td>Telepon buyer</td>
			<td><input type=text name='telp' value='<?php echo $r['telepon_buyer'] ?>'class='form-control'></td>
		</tr>
		<tr>
			<td>Alamat buyer</td>
			<td><input type=text name='alamat' class='form-control' value='<?php echo $r['alamat_buyer'] ?>' /></td>
		</tr>
		<tr>
			<td>Keterangan buyer</td>
			<td><textarea name='keterangan' class='form-control'><?php echo $r['keterangan_buyer'] ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type=submit name='simpan' value='Simpan' class='btn btn-danger'/></td>
		</tr>
	</table>
</form>
<h2 class='page-head-line'>Style</h2>