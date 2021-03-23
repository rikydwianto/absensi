<h1 class='page-head-line'>Data Loading</h1>
<form method=get>
	<input type=hidden name='mn' value='data-loading-tanggal' />
	<input type=text name='tgl' id='tgl1' />
	<input type=hidden name='url' value='<?php echo url_ref() ?>' />

	<input type=submit name='lanjut'>

</form>
<table class='table'>
	<thead>
		<tr>
			<th rowspan=2 valign="middel"><center>No.</center></th>
			<th rowspan=2 valign="middel"><center>Tanggal</center></th>
			<th colspan=3 valign="middel"><center>Banyak Transaksi</center></th>
		</tr>
		<tr>
			<th>Selesai</th>
			<th>Retur</th>
			<th>Belum Selesai</th>
			<th>Batal</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no=1;
		$r=mysql_query("select * from hitung_loading ");
		while($tanggal=mysql_fetch_array($r))
		{
			?>
			<tr>
				<td><?php echo $no ?></td>
				<td><a href='<?php echo menu("data-loading-tanggal&tgl=".urlencode($tanggal['tanggal_loading_aksesoris']).'&url='.url_ref()) ?>'><?php echo tanggal($tanggal['tanggal_loading_aksesoris']) ?></a></td>
				<td><?php echo $tanggal['selesai'] ?></td>	
				<td><?php echo null;#$tanggal['retur']; ?></td>
				<td><?php echo $tanggal['belum_selesai'] ?></td>
				<td><?php echo $tanggal['batal'] ?></td>
			</tr>
			<?php
			$no++;
		}
		?>
	</tbody>
</table>