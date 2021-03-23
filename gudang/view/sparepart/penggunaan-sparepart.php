<?php 
$id=get("id_sparepart");
$barang=mysql_query("select * from sparepart where id_sparepart='$id' and berbayar='tidak'");
$barang=mysql_fetch_array($barang);
?>
<h1 class='page-head-line'>Penggunaan Sparepart perhari</h1>
<div class='col-md-6'>
	<form method=post>
		<table width='100%'>
			<tr>
				<td>Nama Sparepart</td>
				<td><?php echo $barang['nama_sparepart'] ?></td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td><input type=text id='tgl' name='tgl' class='form-control'/></td>
			</tr>
			<tr>
				<td>QTY</td>
				<td><input type=number name='qty' required class='form-control'/></td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td><textarea class='form-control' name='keterangan'></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td><input type=submit name='guna' value='Simpan' class='btn btn-danger'></td>
			</tr>
		</table>
	</form>
</div>
<div class='clearfix'></div>
<?php
if(isset($_POST['guna']))
{
	$tgl=ubah_tanggal(post("tgl"));
	$qty=post("qty");
	$ket=post("keterangan");
	$q=mysql_query("insert into penggunaan_sparepart(id_sparepart,tanggal_penggunaan_sp,qty_penggunaan_sp,keterangan_penggunaan_sp,date_created)
	values('$id','$tgl',$qty,'$ket',now())
	");
	
	if($q){
		mysql_query("update sparepart set stock_sparepart=stock_sparepart-$qty , date_modified='now()' where id_sparepart='$id' ");
		echo alert("Berhasil simpan");
		
	}
	else
		echo alert_error("Error : ". mysql_error());
}
?>