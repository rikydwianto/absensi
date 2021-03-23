<?php 
$tgl=aman($_GET['tgl']);
?>
<h2>Tambah Libur Nasional</h2>
<form method=post>
<table class='table'>
	<tr>
		<td>Tanggal</td>
		<td><?php echo tanggal($tgl) ?></td>
	</tr>
	<tr>
		<td>Keterangan Libur Nasional</td>
		<td><textarea class='form-control' name='keterangan'></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type='submit' name='tambah_libur' value='Tambah Libur' class='btn btn-danger'/></td>
	</tr>
</table>
</form>
<?php 
if(isset($_POST['tambah_libur']))
{
	$cari=mysql_query("select (id_libur_nasional) as total from libur_nasional where tanggal_libur_nasional='$tgl'");
	if(!mysql_num_rows($cari)){
		$keterangan=aman($_POST['keterangan']);
		$q=mysql_query("insert into libur_nasional(tanggal_libur_nasional,keterangan_libur_nasional,date_created) values('$tgl','$keterangan',now())");
		if($q)
			echo alert("Libur Nasional Berhasil ditambahkan!");
		else
			echo alert_error("Error Mysql Query : ".mysql_error());
	}
	else{
		echo alert_error("Gagal disimpan, Libur Nasional pada : ". tanggal($tgl).' Sudah disetting sebelumnya!' );
	}
}
?>