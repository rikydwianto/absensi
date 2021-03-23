<?php 
$bulan=sprintf("%02s",$_GET['bulan']);
$tahun=$_GET['tahun'];
$total_lembur=mysql_query("select count(id_lembur_hari) as total from lembur_hari where tanggal_lembur like '$tahun-$bulan-%'") or die(alert_error("Error : ". mysql_error()));
$total_lembur=mysql_fetch_array($total_lembur);
$total_lembur=$total_lembur['total'];

?>
<h1 align=center><?php echo cek_bulan($_GET['bulan']).' '.$tahun ?></h1></hr>
<p style='color:red' align='center'>Jika Kotak berwarna merah berarti tanggal tersebut ada lembur hari</p>
<p >Total Lembur Hari Pada Bulan <?php echo cek_bulan($_GET['bulan']).' dan Tahun '.$tahun ?> Adalah <b><?php echo $total_lembur ?></b></p><br/>
<div class='row'>
<?php 
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
for($i=1;$i<=$jumlah_hari;$i++){
	$tgl=sprintf("%02s",$i);
	$q=mysql_query("select * from lembur_hari where tanggal_lembur='$tahun-$bulan-$tgl'");
	if(mysql_num_rows($q))
	{
		$warna='danger';
		$Rlembur=mysql_fetch_array($q);
	}
	else{
		$warna='success';
	}
	$hari = cek_hari("$tahun-$bulan-$tgl");
	
	?>
	<div class="col-md-4">
	  <div class="box box-<?php echo $warna ?> box-solid">
		<div class="box-header with-border ">
		  <h3 class="box-title"><b><?php echo $tgl ." , ". $hari ?></b></h3>
		  <div class="box-tools pull-right">
		  <?php 
		  if(!mysql_num_rows($q))
		  {
			?>
			<a class="btn btn-box-tool" href='<?php echo url("index.php?mn=lembur-hari&act=tambah&tgl=$tahun-$bulan-$tgl&url=".url_ref()) ?>' ><i class="fa fa-plus"></i></a>
			<?php
		  }
		  else{
			?>
			<a class="btn btn-box-tool" href='<?php echo url("index.php?mn=lembur-hari&id=$Rlembur[id_lembur_hari]&act=edit&tgl=$tahun-$bulan-$tgl&url=".url_ref()) ?>' ><i class="fa fa-edit"></i></a>
			<a class="btn btn-box-tool" href='<?php echo url("index.php?mn=lembur-hari&id=$Rlembur[id_lembur_hari]&act=hapus&tgl=$tahun-$bulan-$tgl&url=".url_ref()) ?>' onclick='return confirm("Yakin akan menghapus lembur ini?")' ><i class="fa fa-times"></i></a>
			<?php  
		  }
		  ?>
		  </div><!-- /.box-tools -->
		</div><!-- /.box-header -->
		<div class="box-body">
		  <?php echo (mysql_num_rows($q)==0) ? "Tidak ada Lembur " : @$Rlembur['keterangan'] ?><br/>
		</div><!-- /.box-body -->
	  </div><!-- /.box -->
	</div><!-- /.col -->
	<?php
	$Rlembur=null;
	$hari=null;
}
?>

</div>