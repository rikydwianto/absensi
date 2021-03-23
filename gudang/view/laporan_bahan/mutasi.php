<?php 
$cari_stock=mysql_query("select * from stock_aksesoris where id_stock='$id'");
if(!mysql_num_rows($cari_stock)){
	direct(menu('stock'));
}
else{
	$stock=mysql_fetch_array($cari_stock);
}
?>
<div class='print'>
	<h1>Laporan Mutasi Barang</h1>
	<table >
		<tr>
			<td>Nama Bahan &nbsp;</td>
			<td><?php echo $stock['deskripsi'] ?></td>
		</tr>
		<tr>
			<td>Style</td>
			<td><?php echo $stock['nama_style'] ?></td>
		</tr>
		<tr>
			<td>Size</td>
			<td><?php echo $stock['size'] ?></td>
		</tr>
		<tr>
			<td>Warna</td>
			<td><?php echo $stock['warna'] ?></td>
		</tr>
		<tr>
			<td>QTY</td>
			<td><?php echo $qty = $stock['qty'] ?> <?php echo $stock['satuan'] ?></td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td><?php echo $stock['keterangan'] ?></td>
		</tr>
	</table>
	<table border=1 style='width:100%'>
		<thead>
			<tr>
				<th>NO.</th>
				<th>TANGGAL</th>
				<th>KETERANGAN</th>
				<th>DEBIT</th>
				<th>KREDIT</th>
				<th>BALANCE</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$no=1;
		$total=0;
		$total_debit = 0;
		$total_kredit=0;
		$mut = mysql_query("select * from penggunaan_bahan where id_bahan='$id' order by date_created asc");
		while($rmut=mysql_fetch_array($mut)){
		?>
			<tr>
				<td><?php echo $no ?></td>
				<td><?php echo $rmut['tanggal_penggunaan_bahan'] ?></td>
				<td><?php echo $rmut['keterangan_penggunaan_bahan'] ?></td>
				<td><center><?php echo $debit = ($rmut['status_penggunaan']=='debit') ? $rmut['qty_penggunaan_bahan'] : ''  ?></center></td>
				<td><center><?php echo $kredit = ($rmut['status_penggunaan']=='kredit') ? "-".$rmut['qty_penggunaan_bahan'] : ''  ?><?php  $kredit = ($rmut['status_penggunaan']=='kredit') ? $rmut['qty_penggunaan_bahan'] : ''  ?></center></td>
				<td><center><?php echo $total = $debit - $kredit + $total ?></center></td>
			</tr>
		<?php
		$total_debit = $total_debit + $debit;
		$total_kredit = $total_kredit + $kredit;
		$no++;
		}
		?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan=3><center>Total</center></th>
				<th colspan=1><center><?php echo $total_debit ?></center></th>
				<th colspan=1><center><?php echo $total_kredit * -1 ?></center></th>
				<th colspan=1><center><?php echo $total_debit - $total_kredit ?></center></th>
			</tr>
		</tfoot>
	</table>
</div>