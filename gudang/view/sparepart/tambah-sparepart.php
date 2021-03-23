<h1 class='page-head-line'>Tambah Sparepart</h1>
<a href='<?php echo menu("sparepart") ?>' class='btn'>Data Sparepart</a>
<a href='<?php echo menu("sparepart-no") ?>' class='btn'>Aksesoris</a>
<form method=post>
	<table class='table'>
		<tr>
			<td>Kode Sparepart</td>
			<td><input type=text name='kode' class='form-control' /></td>
		</tr>
		<tr>
			<td>Nama Sparepart</td>
			<td><input type=text name='nama' required class='form-control' /></td>
		</tr>
		<!--<tr>
			<td>QTY</td>
			<td><input type=number name='qty' class='form-control' /></td>
		</tr> -->
		<?php
		@$bayar=get('no');
		if($bayar!='ya')
		{
			?>
		<tr>
			<td>Harga</td>
			<td><input type=number name='harga' class='form-control' /></td>
		</tr>
			<?php
		}
		?>
		<tr>
			<td>Keterangan</td>
			<td><textarea name='ket' class='form-control'></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type=submit name='kirim' value='Simpan' class='btn' /></td>
		</tr>
		
	</table>
</form>
<?php 
if(isset($_POST['kirim']))
{
	
	$kode=post('kode');
	$nama=post('nama');
	$qty=post('qty');
	$harga=post('harga');
	$ket=post('ket');
	@$bayar=get('no');
	if($bayar=='ya')
		$bayar='tidak';
	else
		$bayar='ya';
	$q=mysql_query("insert into sparepart(kode_sparepart,nama_sparepart,stock_sparepart,harga_sparepart,keterangan_sparepart,berbayar,date_created)
	values('$kode','$nama','$qty','$harga','$ket','$bayar',now())
	");
	if($q)
		echo alert("Berhasil disimpan!");
	else
		echo alert_error("Error : ".mysql_error());
}
?>