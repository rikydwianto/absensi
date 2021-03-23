<?php 
$cek=mysql_query("select * from resign where id_karyawan='$id'");
if(mysql_num_rows($cek))
{
	$act='edit';
}
else{
	$act='tambah';
}
if(isset($_POST['resign']))
{
	@$tgl=ubah_tanggal($_POST['tgl']);
	$alasan=aman($_POST['alasan']);
	$keterangan=aman($_POST['keterangan']);

	if($act=='tambah'){
		$q=mysql_query("
		insert into resign(id_karyawan,tanggal_resign,alasan_resign,keterangan,date_created)
		values('$id','$tgl','$alasan','$keterangan',now());
		");
	}
	else if($act=='edit')
	{
		$q=mysql_query("
		update resign set tanggal_resign='$tgl',alasan_resign='$alasan', keterangan='$keterangan' where id_karyawan='$id'
		");
		echo mysql_error();
	}
	if($q){
		mysql_query("update karyawan set status_karyawan='5', tgl_keluar='$tgl' where id_karyawan='$id'") or die(alert_error(mysql_error()));
		echo alert("Berhasil  ");
	}
	else
		echo alert_error("Error : ". mysql_error());
}
@$cek=mysql_query("select * from resign where id_karyawan='$id'");

@$r=mysql_fetch_object($cek);

?>
<form method=post>
	<table class='table' >
		<tr >
			<td>Tanggal Resign</td>
			<td><input type=text name='tgl' value='<?php echo (!empty($r)) ? date("d/m/Y",strtotime(date($r->tanggal_resign))) : date('d/m/Y')  ?>' id='tgl1' class='form-control'></td>
		</tr>
		<tr>
			<td>Alasan Resign</td>
			<td><textarea class='form-control'  name='alasan'><?php echo (!empty($r)) ? $r->alasan_resign : ""   ?></textarea></td>
		</tr>
		<tr>
			<td>File (optional)</td>
			<td>
				<input type=file name='file' class=' ' accept="*" />
			</td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td><textarea class='form-control' name='keterangan'><?php echo (!empty($r)) ? $r->keterangan : ""   ?></textarea></td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
			<?php 
			if($act=='tambah')
				echo "<input type=submit class='btn btn-info btn-flat' name='resign' value='Resign' >";
			else
				echo "<input type=submit class='btn btn-info btn-flat' name='resign' value='Simpan' >";
				
			?>
				<input type=reset class='btn btn-flat btn-danger'  value='Reset' >
			</td>
		</tr>
	</table>
</form>
