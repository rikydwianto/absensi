<h1 class='page-head-line'>Laporan Penggunaan Sparepart Sepanjang Waktu</h1>
<table class='table'>
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Barang</th>
			<th>Total Penggunaan</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if(isset($_GET['tahun']) && isset($_GET['bulan']))
		{
			$bulan=$_GET['bulan'];
			$tahun=$_GET['tahun'];
		}
		else{
			$bulan=date("m");
			$tahun=date("Y");
		}
		$no=1;
		$bulan=sprintf("%02s",$bulan);
		$q=mysql_query("select * from sparepart where berbayar='tidak'");
		while($sp=mysql_fetch_array($q))
		{
			$used=mysql_query("select sum(qty_penggunaan_sp) as total from penggunaan_sparepart where id_sparepart='$sp[id_sparepart]'
			#and tanggal_penggunaan_sp like '$tahun-%-%'
			") or die(alert_error("Error : ". mysql_error()));
			$used=mysql_fetch_array($used);
			$used=$used['total'];
		?>
		<tr>
			<td><?php echo $no?></td>
			<td><?php echo $sp['nama_sparepart']?></td>
			<td><?php echo ($used==NULL)? 0 : $used?></td>
		</tr>
		<?php
		$no++;
		}
		?>
	</tbody>
</table>
