<?php 
$id=get("id");
$cari_stock=mysql_query("select * from stock_aksesoris where id_stock='$id'");
if(!mysql_num_rows($cari_stock)){
	direct(menu('stock'));
}
else{
	$stock=mysql_fetch_array($cari_stock);
}
$sup=mysql_query("select id_suplier from order_aksesoris where id_order='$stock[id_order]'") or die(alert_error("Error : ".mysql_error()));
$sup=mysql_fetch_array($sup);
$sup=$sup['id_suplier'];
?>
<h1 class='page-head-line'>Retur Barang Ke Suplier</h1> <br/>
<a href='<?php echo kembali() ?>'>Kembali</a>
<?PHP
if(isset($_POST['retur-suplier'])){
	$tgl=ubah_tanggal(post("tgl"));
	$suplier=post("suplier");
	$ket=post("keterangan");
	$qty=post("qty");
	$qty_retur=post("qty_retur");
	$qty_total=$qty - $qty_retur;
	$q=mysql_query("insert into pengembalian_suplier(id_stock,id_suplier,tanggal_pengembalian_suplier,qty_pengembalian_suplier,keterangan_pengembalian_suplier,date_created)
	values('$id','$suplier','$tgl','$qty_retur','$ket',now())
	") or die(alert_error("Error : ".mysql_error()));
	if($q){
		echo alert("Berhasil diretur, Stok barang dikurangi $qty_retur sisa barang : $qty_total");
		mysql_query("update stock_aksesoris set qty=$qty_total , date_modified=now() where id_stock='$id'");
	}
	else{
		echo alert_error("Gagal ditambahkans");
	}
}
 ?>
<form method=post>
	<table class='table'>
		<tr>
			<td>Style</td>
			<td>
				<?php echo $stock['nama_style']; ?>
			</td>
		</tr>
		<tr>
			<td>Deskripsi
			<br/>
			<small>Nama Barang</small>
			</td>
			<td><?php echo $stock['deskripsi']; ?></td>
		</tr>
		<tr>
			<td>Size</td>
			<td><?php echo $stock['size']; ?> </td>
		</tr>
		<tr>
			<td>Suplier</td>
			<td>
				<select required name=suplier id='select2' class='form-control'>
					<option value=''>Pilih Suplier</option>
				<?php 
				$s=mysql_query("select * from suplier");
				while($suplier=mysql_fetch_array($s))
				{
					if($sup==$suplier['id_suplier'])
						$ac='selected';
					else
						$ac='';
					echo "<option $ac value='$suplier[id_suplier]'>$suplier[nama_suplier]</option>";
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Tanggal Return</td>
			<td>
				<input type=text name='tgl' id='tgl' class='form-control' />
			</td>
		</tr>
		<tr>
			<td>QTY Gudang /
			<i style='color:red'><?php echo $stock['satuan']; ?></i>
			</td>
			<td><input readonly type='text' name='qty' id='qty' class='form-control' value='<?php echo $stock['qty'] ?>' /> </td>
		</tr>
		<tr>
			<td>QTY Retur</td>
			<td><input type='number' name='qty_retur' id='qty_retur' class='form-control'  /></td>
		</tr>
		<tr>
			<td>Keterangan Retur</td>
			<td><textarea name='keterangan' class='form-control' placeholder='Keterangan dikembalikan kepada suplier ...'></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type='submit' name='retur-suplier' class='btn btn-info' value='Tambah' />
				<input type='reset' name='' class='btn btn-danger' value='Reset' />
			
			</td>
		</tr>
	</table>
</form>