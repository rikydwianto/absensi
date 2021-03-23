<?php 
$id=aman($_GET['id']);
if(isset($_POST['edit_lembur']))
{
	$keterangan=aman($_POST['keterangan']);
	$q=mysql_query("update lembur_hari set keterangan='$keterangan', date_modified=now() where id_lembur_hari='$id'");
	if($q)
		echo alert("Lembur Hari Berhasil disimpan!");
	else
		echo alert_error("Error Mysql Query : ".mysql_error());
}
?>
<?php 
$q=mysql_query("select * from lembur_hari where id_lembur_hari='$id'");
$Lembur=mysql_fetch_array($q);
$tgl=$Lembur['tanggal_lembur'];
$ket=$Lembur['keterangan'];
?>
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
		<td><input type='submit' name='edit_lembur' value='Simpan' class='btn btn-danger'/></td>
	</tr>
</table>
</form>
