<h1 class='page-head-line'>Edit Sparepart</h1>
<a href='<?php echo menu("sparepart") ?>' class='btn'>Data Sparepart</a>
<a href='<?php echo menu("sparepart-no") ?>' class='btn'>Aksesoris</a>
<?php 
$id=get('id_sparepart');
if(isset($_POST['kirim']))
{
	
	$kode=post('kode');
	$nama=post('nama');
	$qty=post('qty');
	$harga=post('harga');
	$ket=post('ket');
	@$bayar=post('bayar');
	$q=mysql_query("update sparepart set nama_sparepart='$nama',kode_sparepart='$kode', harga_sparepart='$harga', berbayar='$bayar', keterangan_sparepart='$ket', date_modified=now()
	where id_sparepart='$id'
	");
	if($q)
		echo alert("Berhasil disimpan!");
	else
		echo alert_error("Error : ".mysql_error());
}
?>
<?php 
$q=mysql_query("select * from sparepart where id_sparepart='$id'");
$sp=mysql_fetch_array($q);
?>
<form method=post>
	<table class='table'>
		<tr>
			<td>Kode Sparepart</td>
			<td><input type=text name='kode' class='form-control' value='<?php echo $sp['kode_sparepart']?>'/></td>
		</tr>
		<tr>
			<td>Nama Sparepart</td>
			<td><input type=text name='nama' required class='form-control' value='<?php echo $sp['nama_sparepart']?>'/></td>
		</tr>
		<!-- <tr>
			<td>QTY</td>
			<td><input type=number name='qty' class='form-control' value='<?php echo $sp['stock_sparepart']?>' /></td>
		</tr> -->
		<tr>
			<td>Berbayar?</td>
			<td>
				<select name='bayar' class='form-control'>
					<?php 
					if($sp['berbayar']=='ya'){
						echo "<option value='ya' selected>Berbayar</option>";
						echo "<option value='tidak'>Tidak Berbayar</option>";
						
					}
					else if($sp['berbayar']=='tidak'){
						echo "<option value='ya'>Berbayar</option>";
						echo "<option value='tidak' selected>Tidak Berbayar</option>";
					}
					else{
						echo "<option value='tidak' selected>Tidak Berbayar</option>";
						echo "<option value='ya'>Berbayar</option>";
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Harga</td>
			<td><input type=number name='harga' class='form-control' value='<?php echo $sp['harga_sparepart']?>' /></td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td><textarea name='ket' class='form-control'><?php echo $sp['keterangan_sparepart'] ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type=submit name='kirim' value='Simpan' class='btn' /></td>
		</tr>
		
	</table>
</form>
