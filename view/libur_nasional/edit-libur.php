<?php 
$id=aman($_GET['id']);
if(isset($_POST['edit_libur']))
{
	$keterangan=aman($_POST['keterangan']);
	$q=mysql_query("update libur_nasional set keterangan_libur_nasional='$keterangan', date_modified=now() where id_libur_nasional='$id'");
	if($q)
		echo alert("Libur Nasional Berhasil disimpan!");
	else
		echo alert_error("Error Mysql Query : ".mysql_error());
}
?>
<?php 
$q=mysql_query("select * from libur_nasional where id_libur_nasional='$id'");
$Lembur=mysql_fetch_array($q);
$tgl=$Lembur['tanggal_libur_nasional'];
$ket=$Lembur['keterangan_libur_nasional'];
?>
<h2>Edit Libur Nasional</h2>
<form method=post>
<table class='table'>
	<tr>
		<td>Tanggal</td>
		<td><?php echo tanggal($tgl) ?></td>
	</tr>
	<tr>
		<td>Alasan/Keterangan Lembur</td>
		<td><textarea class='form-control' name='keterangan'><?php echo $ket ?></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type='submit' name='edit_libur' value='Simpan' class='btn btn-danger'/></td>
	</tr>
</table>
</form>
