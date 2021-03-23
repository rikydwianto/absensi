<div class='row'>
	<?php
	$bulan=bulan();
	$warna=array('',"green",'yellow','blue','red','aqua','navy',"yellow",'green','navy','red','aqua','blue');
	for($i=1;$i<=count($bulan);$i++)
	{
		$b=sprintf('%02s', $i);
		$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $i, $tahun);
		$libur_nasional=mysql_query("select count(id_libur_nasional) as total from libur_nasional where tanggal_libur_nasional like '$tahun-$b-%'") or die(alert_error(mysql_error())	);
		$libur_nasional=mysql_fetch_array($libur_nasional);
		$libur_nasional=$libur_nasional['total'];
		?>
	<div class="col-lg-3 col-xs-6">
	  <!-- small box -->
	  <div class="small-box bg-<?php echo $warna[$i] ?> ">
		<div class="inner">
		  <h3><a href="<?php echo url("index.php?mn=libur-nasional&act=lihat&tahun=$tahun&bulan=$b&url=".url_ref()) ?>" style='color:white'><?php echo @$bulan[$i] ?></a> </h3>
		  <h3><?php echo $jumlah_hari ?> </h3>
		  <p>Hari</p>
		</div>
		<div class="inner">
		  <h3><?php echo @$libur_nasional ?> </h3>
		  <p>Libur Nasional Hari</p>
		</div>
		<div class="icon">
		  <i class="fa fa-calendar-o"></i>
		</div>
		<a href="<?php echo url("index.php?mn=libur-nasional&act=lihat&tahun=$tahun&bulan=$b&url=".url_ref()) ?>" class="small-box-footer">
		  Lihat Libur Nasional <i class="fa fa-arrow-circle-right"></i>
		</a>
	  </div>
	</div><!-- ./col -->
		<?php
	}
	?>
</div>