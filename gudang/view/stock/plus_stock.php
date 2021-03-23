<?php 
$id=get('id');
?>
<h1 class='page-head-line'>TAMBAH STOK </h1> <br/>
<a href='<?php echo kembali() ?>' class='btn btn-success'><i class='fa fa-angle-double-left'></i> Kembali</a>
<?php 
if(isset($_POST['tambah-stock'])){
	$style=post("style");
	$deskripsi=post("deskripsi");
	$size=post("size");
	$warna=post("warna");
	$qty=post("qty");
	$qty_tambah=post("qty_tambah");
	
	$keterangan=post("keterangan");
		$qtyinput = $qty + $qty_tambah;
		if($qty_tambah<1){
			$status = "kredit";
			$ket = "Pengurangan";
		}
		else 
		{
			$ket = "Penambahan"; 
			$status='debit';
		}
		$insert = "insert into penggunaan_bahan(id_bahan,tanggal_penggunaan_bahan,qty_penggunaan_bahan,keterangan_penggunaan_bahan,date_created,status_penggunaan)
		values('$id',curdate(),'$qty_tambah','$ket stok untuk $deskripsi sebanyak $qty_tambah <br/>$keterangan',now(),'$status')
		";
		$insert =  mysql_query($insert);
		if($insert){
			echo alert("Stok berhasil ditambhakan");
		}
		else
			echo alert_error("Gagal menambahkan stok, error : ".mysql_error());
	$satuan=post("satuan");
	$ID=$_SESSION['ID'];
	$q="update stock_aksesoris set qty='$qtyinput',date_modified=now() where id_stock='$id'";
	$q=mysql_query($q);
	if($q)
	{
		echo alert("Stok ditambahkan!");
	}
	else
	{
		echo alert_error("Error : ". mysql_error());
	}
}
$cari_stock=mysql_query("select * from stock_aksesoris where id_stock='$id'");
if(!mysql_num_rows($cari_stock)){
	direct(menu('stock'));
}
else{
	$stock=mysql_fetch_array($cari_stock);
}
?>
<form method=post>
	<table class='table'>
		<tr>
			<td>Style</td>
			<td>
				<select name=style id='select2' disabled class='form-control'>
					<option value=''>Pilih Style</option>
				<?php 
				echo $stock['nama_style'];
				$s=mysql_query("select * from style join buyer on buyer.id_buyer=style.id_buyer order by nama_style asc");
				while($style=mysql_fetch_array($s))
				{
					if($style['nama_style']==$stock['nama_style'])
						$ac='selected';
					else
						$ac='';
					?>
					<option <?php echo $ac ?> value='<?php echo $style['nama_buyer'] ?> - <?php echo $style['nama_style'] ?>'><?php echo $style['nama_buyer'] ?> - <?php echo $style['nama_style'] ?></option>
					<?php
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Deskripsi
			<br/>
			<small>Nama Barang</small>
			</td>
			<td><input type='text' disabled required name='deskripsi' value='<?php echo $stock['deskripsi']?>' class='form-control' /></td>
		</tr>
		<tr>
			<td>Size</td>
			<td><input type='text' disabled name='size' class='form-control' value='<?php echo $stock['size']?>' /></td>
		</tr>
		<tr>
			<td>Warna</td>
			<td><input type='text' disabled name='warna' class='form-control' value='<?php echo $stock['warna']?>' /></td>
		</tr>
		<tr>
			<td>QTY SEKARANG</td>
			<td>
				<span class='row col-xs-8 col-md-8'>
					<input type='hidden' name='qty' class='form-control' value='<?php echo $stock['qty']?>' />
					<input type='text' class='form-control' value='<?php echo $stock['qty']?>' disabled/>
				</span>
				<span class='col-md-4'>
					<select class='form-control' disabled name='satuan'>
						<option value=''>Pilih Satuan</option>
						<?php
						$satuan1=$stock['satuan'];
						$Qsatuan=mysql_query("select * from satuan order by satuan asc");
						while($satuan=mysql_fetch_array($Qsatuan))
						{
							if($satuan1==$satuan['satuan'])
								$active='selected';
							else
								$active='';
							echo"<option $active value='$satuan[satuan]'>$satuan[satuan]</option>";
						}
						?>
					</select>
				</span>
			</td>
		</tr>
		<tr>
			<td>TAMBAH STOCK</td>
			<td>
				<input type='text' name='qty_tambah' class='form-control' value='' />
			</td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td><textarea name='keterangan' class='form-control'></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type='submit' name='tambah-stock' class='btn btn-info' value='SIMPAN' />
				<input type='reset' name='' class='btn btn-danger' value='Reset' />
			
			</td>
		</tr>
	</table>
</form>
