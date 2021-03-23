<?php include"../../config/setting.php"; ?>
<?php include"../../fungsi/config.php"; ?>
<?php include"../../config/koneksi.php"; ?>
<h1 class='page-head-line'>Laporan Ambilan Sparepart</h1>
<form>
	<input type=hidden name='mn' value='laporan-sparepart'/>
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
$bulan=sprintf("%02s",$bulan);
$q=mysql_query("select * from sparepart where berbayar='ya' order by id_sparepart asc");
$cek_karyawan=mysql_query("select * from karyawan join jabatan on jabatan.id_jabatan=karyawan.id_jabatan
 where id_karyawan in (select id_karyawan from ambilan where tanggal_ambilan like '$tahun-$bulan-%') order by jabatan.id_jabatan") or die(alert_error("Query Error : ".mysql_error()));
 
 $total_kolom=mysql_num_rows($q) + 4;
?>
<a href='<?php echo url("view/laporan/ambilan_sparepart.php?tahun=$tahun&bulan=$bulan") ?>' class='btn btn-danger pull-right'><i class='fa fa-print'></i></a>
<style>
table {
    border-collapse: collapse;
}
table th{
	text-align:center
}
table #tengah{
	text-align:center
}
</style>
<h3><?php echo cek_bulan((int)$bulan).' - '. $tahun?></h3>
<table border=1 class='' style='font-size:10px;' width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>NIK</th>
			<th>Jabatan</th>
		<?php
		$idsparepart=array();
		while($spare=mysql_fetch_array($q))
		{
			$pecah=explode(" ",$spare['nama_sparepart']);
			if(count($pecah)==1)
				$hasil=$spare['nama_sparepart'];
			else{
				?>
				<style>
				hr{
					margin-top:0px;
					margin-bottom:0px;
				}
				</style>
				<?php
				$belakang=array();
				for($a=1;$a<=count($pecah);$a++)
				{
					@$belakang[]=$pecah[$a];
				}
				$B=implode(" ",$belakang);
				$hasil='<p style="margin:0px">'.$pecah[0].'</p><hr/>'.$B;
			}
			$idsparepart[]=$spare['id_sparepart'];
			?>
			<td style='font-size:px;text-align:center'><?php echo $hasil ?></td>
			<?php
		}
		?>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$no=1;
		$total_banget=0;
		while($orang=mysql_fetch_array($cek_karyawan)){
			?>
			<tr>
				<td><?php echo $no ?></td>
				<td><?php echo $orang['nama_lengkap'] ?></td>
				<td><?php echo $orang['nik'] ?></td>
				<td><?php echo $orang['nama_jabatan'] ?></td>
				<?php 
				$total_bayar=0;
				for($i=0;$i<count($idsparepart);$i++)
				{
					$cek=mysql_query("select sum(qty_ambilan) as hitung,harga_ambilan from  
					detail_ambilan_sp join ambilan on detail_ambilan_sp.id_ambilan_sp=ambilan.id_ambilan_sp 
					where id_karyawan='$orang[id_karyawan]' and detail_ambilan_sp.id_sparepart='$idsparepart[$i]'");
					echo mysql_error();
					$rsp=mysql_fetch_array($cek);
					
					?>
				<td id='tengah'><?php echo ($rsp['hitung']==0) ? '' : $rsp['hitung']?> </td>
					<?php
					$total_bayar=$total_bayar + (@$rsp['hitung'] * @$rsp['harga_ambilan']);
				}
				?>
				<td><?php $total_banget=$total_bayar + $total_banget; echo rupiah($total_bayar)?></td>
			</tr>
			<?php
			$no++;
		}
		?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="<?php echo $total_kolom ?>"><center>Total</center></th>
			<th colspan=1><?php echo rupiah($total_banget)?></th>
		</tr>
	</tfoot>
</table>
<br/>
<br/>
<br/>
<table border=1>
	<thead>
		<tr>
			<th>Nama Sparepart</th>
			<th>Harga</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$total_harga=0;
	$q=mysql_query("select * from sparepart where berbayar='ya' order by id_sparepart asc");
	while($rHarga=mysql_fetch_array($q))
	{
		$total_harga=$total_harga+$rHarga['harga_sparepart'];
		?>
	<tr>
		<td><?php echo $rHarga['nama_sparepart']?></td>
		<td><?php echo rupiah($rHarga['harga_sparepart'])?></td>
	</tr>
		<?php
	}
	?>
	</tbody>
	<tfoot>
		<th>Total</th>
		<th><?php echo rupiah($total_harga) ?></th>
	</tfoot>
</table>
<script>
window.print();
</script>