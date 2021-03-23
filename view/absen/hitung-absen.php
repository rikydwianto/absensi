<?php 
function hitung_resign(){
	$q=mysql_query("select count(id_karyawan) as total from karyawan where status_karyawan=5");
	$r=mysql_fetch_array($q);
	$r=$r['total'];
	return $r;
}
?>
<div class="row">
	<div class="col-md-3 col-sm-6 col-xs-12">
	  <div class="info-box">
		<span class="info-box-icon bg-yellow">
			<a href='<?php echo url('index.php?mn=karyawan'); ?>' style='color:white'>
				<i class="ion ion-ios-people-outline"></i>
			</a>
		</span>
		<div class="info-box-content">
		  <span class="info-box-text">Semua Karyawan</span>
		  <span class="info-box-number"><?php echo $semua= hitung_karyawan() ;#- hitung_resign()?></span>
		</div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	</div><!-- /.col -->
	<div class="col-md-3 col-sm-6 col-xs-12">
	  <div class="info-box">
		<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
		<div class="info-box-content">
		  <span class="info-box-text">Masuk</span>
		  <span class="info-box-number"><?php echo $hit_absen = hitung_absen($tgl) ?></span>
		</div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	</div><!-- /.col -->
	<div class="col-md-3 col-sm-6 col-xs-12">
	  <div class="info-box">
		<span class="info-box-icon bg-green"><i class="fa fa-sign-out"></i></span>
		<div class="info-box-content">
		  <span class="info-box-text">Pulang</span>
		  <span class="info-box-number"><?php echo hitung_keluar($tgl) ?></span>
		</div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	</div><!-- /.col -->
	<!-- fix for small devices only -->
	<div class="clearfix visible-sm-block"></div>
	
	<!-- fix for small devices only -->
	<div class="clearfix visible-sm-block"></div>

	<div class="col-md-3 col-sm-6 col-xs-12">
	  <div class="info-box">
		  <span class="info-box-text">Alfa : <?php echo hitung_alfa($tgl) ?></span>
		  <span class="info-box-text">Izin : <?php echo hitung_izin($tgl) ?></span>
		  <span class="info-box-text">SKD : <?php echo hitung_skd($tgl) ?></span>
		  <span class="info-box-text">Telat : <?php echo hitung_telat($tgl) ?></span>
		  <span class="info-box-text">Tidak Absen : <?php echo tidak_absen($tgl) ?></span>
	  </div><!-- /.info-box -->
	</div><!-- /.col -->
	
</div>