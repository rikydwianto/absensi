<?php 
include_once"fungsi/absen-absen.php";
include_once"fungsi/karyawan.php";
include_once"fungsi/lihat.php";
$breadcrumd=$_GET['mn'];
error_reporting(0);
$b=$_GET['bulan'];
$t=$_GET['tahun'];
$url11=$_GET['url'];
$id=aman($_GET['id']);
$b=sprintf('%02s', $b);			
			
$karyawan=detail_karyawan($id);
$next=mysql_query("select id_karyawan,nama_lengkap from karyawan where id_karyawan > $id and status_karyawan<>5 limit 1");
$next=mysql_fetch_array($next);
$prev=mysql_query("select id_karyawan,nama_lengkap from karyawan where id_karyawan < $id and id_karyawan > 0 and status_karyawan<>5 order by id_karyawan desc limit 1");
$prev=mysql_fetch_array($prev);
?>
<section class="content-header">
  <h1>
    Absen
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Rekap  Absen Perkaryawan</a></li>
    <li class="active"><?php echo $karyawan->nama_lengkap ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Rekap  Absen Perkaryawan</h3>
		</div>
		<div class="box-body">
			<div >
				<a href='<?php echo urldecode($url11.'#'.$id) ?>' class='btn btn-danger'><i class='fa fa-refresh'></i> Back </a>
				<a href='' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
			</div>
			<br/>
			<form method=get id='form_rinci_absen'>
			
			<input type=hidden name='mn' value='report-per-karyawan'/>
			<span id='cari_cepat'>
				<!--<input type=text name='nik' placeholder='NIK ...' value='<?php echo $karyawan->nik ?>'/> -->
				<select id='rinci_nik' name='nik' class='select2'>
					<option value=''>Pilih Nama Karyawan/Nomor Induk Karyawan</option>
					<option selected value='<?php echo $karyawan->nik ?>'><?php echo $karyawan->nama_lengkap ?></option>
				</select>
				<input type=submit value='Cari Cepat' onclick='return false' id='klik_rinci' />
			</span> <br/>
			<input type=hidden name='id' value='<?php echo $id ?>'/>
			
				<select name='bulan'>
					<?php 
					$bln=bulan();
						$hitung= count($bln);
						for($i=1;$i<=$hitung;$i++)
						{
							if($i==date('m') || @$_GET['bulan']==$i)
								$sel="selected";
							else
								$sel="";
							echo"<option $sel value='$i'>$bln[$i]</option>";
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
				<input type=hidden value='<?php echo $url11 ?>' name='url'/>
				<input type=submit value='lihat' name='lihat' onclick='submit()'/><br/>
				
				
			</form>
			<br/>
			<br/>
						
			
			<a href='<?php echo url('index.php?mn=report-per-karyawan&id='.$prev['id_karyawan']) ?>' class='btn btn-success'>< <?php echo $prev['nama_lengkap'] ?></a>
			<a href='<?php echo url('index.php?mn=report-per-karyawan&id='.$next['id_karyawan']) ?>' class='btn btn-success'> <?php echo $next['nama_lengkap'] ?> ></a> 
			<h2>Rekap  Absen Perkaryawan </h2>
			<div id='rinci_absen'>
			NIK : <b><?php echo $karyawan->nik ?></b> <br/>
			Nama : <b><?php echo $karyawan->nama_lengkap ?> </b><br/>
			Bulan : <b><?php echo cek_bulan($b) ?> </b><br/>
			<table class='table table-hover'>
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Tanggal</th>
						<th>Jam Masuk</th>
						<th>Jam Keluar</th>
						<th>Telat</th>
						<th>Lembur</th>
						<th>Keterangan Hadir</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					
					$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $b, $t);
					for($i=1;$i<=$jumlah_hari;$i++)
					{
						$q=mysql_query("select * from absen where tanggal_absen='$t-$b-$i' and id_karyawan='$id'") or die(alert_error("Error : ". mysql_error()));
						if(mysql_num_rows($q))
						{
							if(mysql_num_rows($q)>1){
								$merah = "danger";
							}
							else $merah="";
							while($report=mysql_fetch_array($q)){
								
							?>
							<tr class='<?php echo $merah ?>'>
								<td><?php echo $i ?></td>
								<td><?php echo tanggal("$t-$b-$i") ?></td>
								<td><?php echo $report['jam_masuk'] ?></td>
								<td><?php echo $report['jam_keluar'] ?></td>
								<td><?php echo $report['telat'] ?></td>
								<td><?php echo $report['menit_lembur'] ?></td>
								<td><?php echo $report['keterangan_hadir'] ?></td>
								<td><?php echo $report['keterangan'] ?></td>
							</tr>
							<?php 
							}
						}
						else
						{
							$detail_libur=hitung_libur_nasional_detail($i,$b,$t);
							if($detail_libur){
								if(mysql_num_rows($q)){
									while($report=mysql_fetch_array($q)){
										
									?>
									<tr>
										<td><?php echo $i ?></td>
										<td><?php echo tanggal("$t-$b-$i") ?></td>
										<td><?php echo $report['jam_masuk'] ?></td>
										<td><?php echo $report['jam_keluar'] ?></td>
										<td><?php echo $report['telat'] ?></td>
										<td><?php echo $report['menit_lembur'] ?></td>
										<td><?php echo $report['keterangan_hadir'] ?></td>
										<td><?php echo $report['keterangan'] ?></td>
									</tr>
									<?php 
									}
								}
								else{
									$query=mysql_query("select * from libur_nasional where tanggal_libur_nasional='$t-$b-$i'");
									$libur=mysql_fetch_array($query);
									?>
									<tr>
										<td><?php echo $i ?></td>
										<td colspan=6><?php echo $libur['keterangan_libur_nasional']?></td>
									</tr>
									<?php 
								}
							}
							else{
								?>
									<tr>
										<td><?php echo $i ?></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php 
							}
						}
					}
					?>
				</tbody>
			</table>
			</div>
		</div>
    </div>

</section>
