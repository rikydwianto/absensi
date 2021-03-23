<?php
include_once"../config/setting.php";
include_once"../config/koneksi.php";
include_once"../fungsi/config.php";
include_once"../fungsi/lihat.php";
include_once"../fungsi/karyawan.php";
include_once"../fungsi/absen.php";
include_once"../fungsi/absen-absen.php";
$b=$_GET['bulan'];
$t=$_GET['tahun'];
$url11=$_GET['url'];
$id=aman($_GET['nik']);
$id = mysql_query("select id_karyawan from karyawan where nik='$id' ");
$id= mysql_fetch_array($id);
$id=$id['id_karyawan'];
$karyawan=detail_karyawan($id);
$b=sprintf('%02s', $b);
?>
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