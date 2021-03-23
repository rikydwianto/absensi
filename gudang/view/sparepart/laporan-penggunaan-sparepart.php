<h1 class='page-head-line'>Laporan Penggunaan Sparepart per bulan</h1>
<form>
	<input type=hidden name='mn' value='laporan-penggunaan-sparepart'/>
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
			 echo"<option $sel value='$i'>$i - ".cek_bulan($i)."</option>";
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
		$q=mysql_query("select * from sparepart ");
		while($sp=mysql_fetch_array($q))
		{
			$used=mysql_query("select sum(qty_penggunaan_sp) as total from penggunaan_sparepart where id_sparepart='$sp[id_sparepart]'
			and tanggal_penggunaan_sp like '$tahun-$bulan-%'
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
