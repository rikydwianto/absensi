<?php 
$bulan=sprintf("%02s",$_GET['bulan']);
$tahun=$_GET['tahun'];
$total_libur=mysql_query("select count(id_libur_nasional) as total from libur_nasional where tanggal_libur_nasional like '$tahun-$bulan-%'");
$total_libur=mysql_fetch_array($total_libur);
$total_libur=$total_libur['total'];
?>
<h1 align=center><?php echo cek_bulan($_GET['bulan']).' '.$tahun ?></h1></hr>
<p style='color:red' align='center'>Jika Kotak berwarna merah berarti tanggal tersebut ada Libur Nasional</p>
<p >Total Libur Nasional Pada Bulan <?php echo cek_bulan($_GET['bulan']).' dan Tahun '.$tahun ?> Adalah <b><?php echo $total_libur ?></b></p>
<div class='row'>
<?php 
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
for($i=1;$i<=$jumlah_hari;$i++){
	$tgl=sprintf("%02s",$i);
	$q=mysql_query("select * from libur_nasional where tanggal_libur_nasional='$tahun-$bulan-$tgl'");
	if(mysql_num_rows($q))
	{
		$warna='danger';
		$Rlibur=mysql_fetch_array($q);
	}
	else{
		$warna='success';
	}
	$hari = cek_hari("$tahun-$bulan-$tgl");
	
	?>
	<div class="col-md-3">
	  <div class="box box-<?php echo $warna ?> box-solid">
		<div class="box-header with-border">
		  <h3 class="box-title"><b><?php echo $tgl ." , ". $hari ?></b></h3>
		  <div class="box-tools pull-right">
		  <?php 
		  if(!mysql_num_rows($q))
		  {
			?>
			<a class="btn btn-box-tool" href='<?php echo url("index.php?mn=libur-nasional&act=tambah&tgl=$tahun-$bulan-$tgl&url=".url_ref()) ?>' ><i class="fa fa-plus"></i></a>
			<?php
		  }
		  else{
			?>
			<a class="btn btn-box-tool" href='<?php echo url("index.php?mn=libur-nasional&id=$Rlibur[id_libur_nasional]&act=edit&tgl=$tahun-$bulan-$tgl&url=".url_ref()) ?>' ><i class="fa fa-edit"></i></a>
			<a class="btn btn-box-tool" href='<?php echo url("index.php?mn=libur-nasional&id=$Rlibur[id_libur_nasional]&act=hapus&tgl=$tahun-$bulan-$tgl&url=".url_ref()) ?>' onclick='return confirm("Yakin akan menghapus Libur Nasional ini?")' ><i class="fa fa-times"></i></a>
			<?php  
		  }
		  ?>
		  </div><!-- /.box-tools -->
		</div><!-- /.box-header -->
		<div class="box-body">
		  <?php echo (mysql_num_rows($q)==0) ? "Tidak ada Libur Nasional " : @$Rlibur['keterangan_libur_nasional'] ?><br/>
		</div><!-- /.box-body -->
	  </div><!-- /.box -->
	</div><!-- /.col -->
	<?php
	$Rlibur=null;
	$hari=null;
}
?>

</div>