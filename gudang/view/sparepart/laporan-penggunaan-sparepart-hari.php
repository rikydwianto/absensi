<h1 class='page-head-line'>Laporan Penggunaan Sparepart per Hari</h1>
<form>
	<input type=hidden name='mn' value='laporan-penggunaan-sparepart-hari'/>
	<select name='tgl'>
		<option value='<?php $tgl= (isset($_GET['tgl'])) ? $_GET['tgl'] : date("d") ?>'>Tanggal</option>
		<?php 
		for($d=1;$d<=31;$d++)
		{
			if($d!=$tgl)
				echo "<option value='$d'>$d</option>";
			else
				echo "<option selected value='$d'>$d</option>";
				
		}
		?>
	</select>
	<select name='bulan'>
		<?php
		$bln=bulan();
		$hitung= count($bln);
		for($i=1;$i<$hitung;$i++)
		{
			if($i==date('m') )
				$sel="selected";
			else
				$sel="";
			 echo"<option $sel value='$i'> ".cek_bulan($i)."</option>";
		}
		?>
	</select>
	<select name='tahun'>
		<?php 
		$th=date("Y");
		for($a=$th;$a>2010;$a--)
		{
			if(@$_GET['tahun']==$a)
				$ts="selected";
			else
				$ts="";
			echo "<option $ts value='$a'>$a</option>";
		}
		?>
	</select>
	<input type=submit value='Lihat'>
</form>
<table class='table'>
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Barang</th>
			<th>QTY</th>
			<th>Penggunaan</th>
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
		$tgl=sprintf("%02s",$tgl);
		$q=mysql_query("select sum(penggunaan_sparepart.qty_penggunaan_sp) as qty_penggunaan_sp1,penggunaan_sparepart.*,sparepart.nama_sparepart from penggunaan_sparepart join sparepart on penggunaan_sparepart.id_sparepart=sparepart.id_sparepart where 
		 penggunaan_sparepart.tanggal_penggunaan_sp='$tahun-$bulan-$tgl' group by penggunaan_sparepart.id_penggunaan_sp") or die(alert_error(mysql_error()));
		while($sp=mysql_fetch_array($q))
		{
			$used=$sp['qty_penggunaan_sp1'];
		?>
		<tr>
			<td><?php echo $no?></td>
			<td><?php echo $sp['nama_sparepart']?></td>
			<td><?php echo ($used==NULL)? 0 : $used?></td>
			<td><?php echo $sp['qty_sparepart']?></td>
			<td><?php echo $sp['keterangan_penggunaan_sp']?></td>
		</tr>
		<?php
		$no++;
		}
		?>
	</tbody>
</table>
