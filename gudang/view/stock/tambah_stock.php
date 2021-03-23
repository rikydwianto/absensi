<h1 class='page-head-line'>Tambah Stock </h1> <br/>
<?php 
if(isset($_POST['tambah-stock'])){
	$style=post("style");
	$deskripsi=post("deskripsi");
	$size=post("size");
	$warna=post("warna");
	$qty=post("qty");
	$keterangan=post("keterangan");
	$satuan=post("satuan");
	$ID=$_SESSION['ID'];
	if(isset($_GET['lebihan'])=='ya')
		$lebihan='ya';
	else
		$lebihan='tidak';
	$q="insert into stock_aksesoris(nama_style,deskripsi,size,warna,qty,keterangan,satuan,id_karyawan,tanggal_input,date_created,lebihan)
	values('$style','$deskripsi','$size','$warna','$qty','$keterangan','$satuan','$ID',curdate(),now(),'$lebihan')
	";
	$q=mysql_query($q);
	if($q)
	{
		$id=mysql_insert_id();
		$insert = "insert into penggunaan_bahan(id_bahan,tanggal_penggunaan_bahan,qty_penggunaan_bahan,keterangan_penggunaan_bahan,date_created,status_penggunaan)
		values('$id',curdate(),'$qty','Stok Awal',now(),'debit')
		";
		mysql_query($insert);

		echo alert("Berhasil ditambahkan!");
	}
	else
	{
		echo alert_error("Error : ". mysql_error());
	}
}
?>
<form method=post>
	<table class='table'>
		<tr>
			<td>Style</td>
			<td>	
				<select name=style class='form-control'>
					<option value=''>Pilih Style</option>
				<?php 
				$s=mysql_query("select * from style join buyer on buyer.id_buyer=style.id_buyer order by nama_style asc");
				while($style=mysql_fetch_array($s))
				{
					?>
					<option value='<?php echo $style['nama_buyer'] ?> - <?php echo $style['nama_style'] ?>'><?php echo $style['nama_buyer'] ?> - <?php echo $style['nama_style'] ?></option>
					<?php
				}
				?>
				</select>
				<br/>
				bisa dikosongkan jika tidak diperlukan
			</td>
		</tr>
		<tr>
			<td>Deskripsi
			<br/>
			<small>Nama Barang</small>
			</td>
			<td><input type='text' required name='deskripsi' class='form-control' /></td>
		</tr>
		<tr>
			<td>Size</td>
			<td><input type='text' name='size' class='form-control' /></td>
		</tr>
		<tr>
			<td>Warna</td>
			<td><input type='text' name='warna' class='form-control' /></td>
		</tr>
		<tr>
			<td>QTY</td>
			<td>
				<span class='row col-xs-8 col-md-8'>
					<input type='text' name='qty' class='form-control' />
				</span>
				<span class='col-md-4'>
					<select class='form-control' name='satuan'>
						<option value=''>Pilih Satuan</option>
						<?php
						$Qsatuan=mysql_query("select * from satuan order by satuan asc");
						while($satuan=mysql_fetch_array($Qsatuan))
						{
							echo"<option value='$satuan[satuan]'>$satuan[satuan]</option>";
						}
						?>
					</select>
				</span>
			</td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td><textarea name='keterangan' class='form-control'></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type='submit' name='tambah-stock' class='btn btn-info' value='Tambah' />
				<input type='reset' name='' class='btn btn-danger' value='Reset' />
			
			</td>
		</tr>
	</table>
</form>