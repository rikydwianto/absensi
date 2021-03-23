<?php include"../config/setting.php"?>
<?php include"../config/koneksi.php"?>
<?php include"../fungsi/config.php"?>
<?php
$id= post('id_order');
$q=mysql_query("select * from order_aksesoris 
	join buyer on order_aksesoris.id_buyer=buyer.id_buyer 
	join suplier on order_aksesoris.id_suplier=suplier.id_suplier where id_order='$id'");
$r=mysql_fetch_array($q);
$status = $r['status_order'];
if($status=='pending')
	$label='warning';
else if($status=='barang kurang')
	$label='warning';
else if($status=='batal')
	$label='danger';
else if($status=='sukses')
	$label='success';
?>

<table class='table'>
	<tr>
		<td>Tanggal Order</td>
		<td><?php echo tanggal($r['tanggal_order'])?></td>
	</tr>
	<tr>
		<td>KODE</td>
		<td><?php echo $r['kode_po']?></td>
	</tr>
	<tr>
		<td>Buyer</td>
		<td><?php echo $r['nama_buyer']?> - <?php echo $r['instansi_buyer']?></td>
	</tr>
	<tr>
		<td>Suplier</td>
		<td><?php echo $r['nama_suplier']?></td>
	</tr>
	<tr>
		<td>Style</td>
		<td><?php echo $r['nama_style']?></td>
	</tr>
	<tr>
		<td>Deskripsi</td>
		<td><?php echo $r['deskripsi']?></td>
	</tr>
	<tr>
		<td>Size</td>
		<td><?php echo $r['size']?></td>
	</tr>
	<tr>
		<td>Warna</td>
		<td><?php echo $r['warna']?></td>
	</tr>
	<tr>
		<td>Status Order</td>
		<td>
			<span class="label label-<?php echo $label ?>">
				<?php echo $status ?>
			</span>
		</td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td><?php echo $r['keterangan'] ?></td>
	</tr>
	<tr>
		<td>QTY</td>
		<td><?php echo $r['qty']?></td>
	</tr>
	<tr>
		<td>Consumsion</td>
		<td><?php echo $r['cons']?></td>
	</tr>
	<tr>
		<td>Total QTY Need</td>
		<td><?php echo $r['totalqty']?> <?php echo $r['satuan']?></td>
	</tr>
</table>