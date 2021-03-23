<?php
$idkel=aman($_GET['id_kel']);
if(isset($_POST['edit-keluarga']))
{
	$id=aman($_GET['id']);
	$nama_keluarga=aman($_POST['nm_keluarga']);
	$tgl=ubah_tanggal($_POST['tgl']);
	$status=aman($_POST['status']);
	$kerja=aman($_POST['kerja']);
	$catatan=aman($_POST['catatan']);
	$q=mysql_query("
	update keluarga set nama_lengkap='$nama_keluarga', tgl_lahir='$tgl',status='$status',
	pekerjaan='$kerja', catatan='$catatan', date_modified=now()
	where id_keluarga='$idkel'
	");
	if($q)
	{
		echo alert("Berhasil diedit");
	}
	else
	{
		echo alert_error("Error : ". mysql_error());
	}
	
}
$keluarga=detail_keluarga($idkel);
?>

<form method=post>
	<table class='table'>
		<tr>
			<td>Nama Keluarga</td>
			<td>
				<input type=text name='nm_keluarga' value='<?php echo $keluarga->nama_lengkap?>' class='form-control'>
			</td>
		</tr>
		<tr>
			<td>Tanggal Lahir</td>
			<td><input class='form-control'  value='<?php echo date("d/m/Y",strtotime(date( $keluarga->tgl_lahir)))?>' type=text id='tgl1' name='tgl'/></td>
		</tr>
		<tr>
			<td>Status</td>
			<td><input class='form-control' value='<?php echo  $keluarga->status ?>' type=text name='status'/></td>
		</tr>
		<tr>
			<td>Pekerjaan</td>
			<td><input type=text name='kerja' value='<?php echo  $keluarga->pekerjaan ?>' class='form-control'/></td>
		</tr>
		<tr>
			<td>Catatan</td>
			<td><textarea class='form-control' name='catatan'><?php echo  $keluarga->status ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type=submit class='btn btn-info' value='Simpan' name='edit-keluarga'/>
				<input type=reset class='btn btn-danger' value='Reset' />
			
			</td>
		</tr>
	</table>
</form>