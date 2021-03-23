<?php 
$tgl=aman($_GET['tgl']);
?>
<form method=post>
<table class='table'>
	<tr>
		<td>Tanggal</td>
		<td><?php echo tanggal($tgl) ?></td>
	</tr>
	<tr>
		<td>Alasan/Keterangan Lembur</td>
		<td><textarea class='form-control' name='keterangan'></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type='submit' name='tambah_lembur' value='Tambah Lembur' class='btn btn-danger'/></td>
	</tr>
</table>
</form>
<?php 
if(isset($_POST['tambah_lembur']))
{
	$cari=mysql_query("select (id_lembur_hari) as total from lembur_hari where tanggal_lembur='$tgl'");
	if(!mysql_num_rows($cari)){
		$keterangan=aman($_POST['keterangan']);
		$q=mysql_query("insert into lembur_hari(tanggal_lembur,keterangan,date_created) values('$tgl','$keterangan',now())");
		if($q)
			echo alert("Lembur Hari Berhasil ditambahkan!");
		else
			echo alert_error("Error Mysql Query : ".mysql_error());
	}
	else{
		echo alert_error("Gagal disimpan, karena lembur pada : ". tanggal($tgl).' Sudah disetting sebelumnya!' );
	}
}
?>