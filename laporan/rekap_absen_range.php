<?php 
include"../config/setting.php";
include"../config/koneksi.php";
include"../fungsi/config.php";
include"../fungsi/lihat.php";
include"../fungsi/karyawan.php";
include"../fungsi/absen-absen.php";
include"../fungsi/jabatan.php";
include"../fungsi/departemen.php";
require_once('../library/excel/PHPExcel.php');
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("PT Lydia Sola Gracia")
->setLastModifiedBy("PT Lydia Sola Gracia")
->setTitle("Laporan PT Lydia Sola Gracia")
->setSubject("Laporan Karyawan")
->setDescription("Data karyawan ")
->setKeywords("karyawan")
->setCategory("Laporan");

@$tgllama=($_GET['tgl'] == "" ) ? date("01/m/Y - t/m/Y") : $_GET['tgl'];
@$tgl=($_GET['tgl'] == "" ) ? date("01/m/Y - t/m/Y") : $_GET['tgl'];
@$tgl=(explode("-",$tgl));
$tglawal = (ubah_tanggal(trim($tgl[0])));
$tglakhir = (ubah_tanggal(trim($tgl[1])));
$total_range=date_diff(date_create($tglawal),date_create($tglakhir));
$total_range=$total_range->format("%d") + 1;
$jumlah_hari=$total_range;
$b=$tglawal;
$t=$tglakhir;
@$hari=explode('-',$b);
@$hari=$hari[2];
function banding_tgl($awal,$akhir){
	$q=mysql_query("SELECT DATEDIFF('$awal','$akhir') as date_difference");
	$r=mysql_fetch_array($q);
	return abs($r['date_difference']) + 1;
	
}
$jumlah_hari =  banding_tgl($tglawal,$tglakhir);
$filter_dep="";
if(isset($_GET['filter'])){
	$filter_id=$_GET['filter'];
	$filter_dep="where id_departemen='$filter_id'";
}
error_reporting(0);
// header('Content-Type: application/vnd.ms-excel' );
 // header("Content-type: application/x-msdownload");
// header('Content-Disposition: attachment;filename="Rekap Total Absen dari '.$tglawal.' s/d '.$tglakhir.'.xls"' );
// header('Cache-Control: max-age=0');

$dep=mysql_query("select * from departemen $filter_dep order by kode_departemen asc");

echo mysql_error();
while($rdep=mysql_fetch_array($dep)){
	$qjab=mysql_query("select * from jabatan where id_departemen=$rdep[id_departemen] order by nama_jabatan asc");
	while($jab=mysql_fetch_array($qjab)){
		?>
		<section class="content">
		  <div class="box">
			<div class="box-body">
				<div>
					<?php 
					//error_reporting(1);
					$hitung_libur_nasional=hitung_libur_nasional($b,$t);
					?>
					Nama Departemen : <?php echo $rdep['nama_departemen'] ?><br/>
					Jabatan			: <?php echo @$jab['nama_jabatan'] ?><br/>
					Priode	 		: <?php echo tanggal($tglawal) ?> s/d <?php echo tanggal($tglakhir) ?><br/>
					Total Hari 		: <?php echo $jumlah_hari?>
					<div class='table-responsive '>
						<table border=1 class=' table- table-hover' style='width:100%'>
							<thead>
								<tr>
									<th colspan='15'>
										<center>
											Rekap Total <?php echo tanggal($tglawal)?> s/d <?php echo tanggal($tglakhir)?> 
										</center>
									</th>
								</tr>
								<tr >
									<th rowspan=2><center>No.</center></th>
									<th rowspan=2><center>NIK</center></th>
									<th rowspan=2><center>Nama </center></th>
									<th rowspan=2><center>Jabatan</center></th>
									<th >Total Hari</th>
									<th rowspan=1>Libur</th>
									<th rowspan=1>Libur / </th>
									<th colspan=3><center>Absensi</center></th>
									<th rowspan=2><center>Telat</center></th>
									<th rowspan=2><center>Lembur <br/>(Jam)</center></th>
									<th rowspan=2><center>Lembur <br/>(Hari)</center></th>
									<th colspan=2><center>Total</center></th>
									<th rowspan=2><center>Keterangan</center></th>
								</tr>
								<tr >
									<th >Kerja</th>
									<th >Nasional</th>
									<th >Off</th>
									<th><center>S</center></th>
									<th><center>I</center></th>
									<th><center>A</center></th>
									<th>Masuk</th>
									<th>Tidak Masuk</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							if(empty($id_jab_dep))
							{
								$qtam="";
							}
							else
								$qtam=" and karyawan.id_jabatan='$id_jab_dep' ";
							$query="select id_karyawan,nik,nama_lengkap,nama_jabatan,datediff(curdate(),tgl_masuk) as lama_kerja,tgl_masuk,kode_departemen,status_karyawan from karyawan,jabatan,departemen where departemen.id_departemen=jabatan.id_departemen 
							and karyawan.id_jabatan=jabatan.id_jabatan and karyawan.status_karyawan!=5 and jabatan.id_jabatan='$jab[id_jabatan]' order by karyawan.tgl_masuk ";
							$query=mysql_query($query);
							$jm=0;
							$no=1;
							while($Kar=mysql_fetch_array($query))
							{
								//JIKA TGL MASUK KURANG DARI TGL YG AWAL YG DIPILIH
								if(strtotime($b)<strtotime($Kar['tgl_masuk'])){
									$tgl_baru=$Kar['tgl_masuk'];
									$ulang=date_diff(date_create($tgl_baru),date_create($t));
									$ulang=$ulang->format("%d") + 1;
									$jumlah_hari = banding_tgl($tgl_baru,$t);
									$ket="Masuk pada tanggal $tgl_baru";
								}
								else
								{
									$tgl_baru=$b;
									$ulang=$jumlah_hari;
									$ket="";
								}
								
								//JIKA KARYAWAN SPD
								$cari_spdq=mysql_query("select id_karyawan,tanggal_absen from absen where tanggal_absen between '$tgl_baru' and '$tglakhir' and id_karyawan='$Kar[id_karyawan]' and keterangan_hadir='spd'");
								@$cari_spd=mysql_fetch_array($cari_spdq);
								if(mysql_num_rows($cari_spdq))
								{
									
									$tglakhir=$cari_spd['tanggal_absen'];
									$ulang=date_diff(date_create($tgl_baru),date_create($tglakhir));
									$ulang=$ulang->format("%d") + 1;
									$jumlah_hari =  banding_tgl($tglawal,$tglakhir);
								}
								
								
								$lama_kerja=$Kar['lama_kerja'] ;
								$idkaryawan=$Kar['id_karyawan'];
								$tgl_masuk=explode("-",$Kar['tgl_masuk']);
								$tgl_masuk=$tgl_masuk[2];
								// if($tgl_masuk[1]==$b && $tgl_masuk[0]==$t){
									// $tgl_masuk=$tgl_masuk[2];
									// $jumlah_hari=$lama_kerja;
								// }
								// else{
									$tgl_masuk=1;
									// $jumlah_hari=$jumlah_hari;
								// }
								
								
								if($Kar['kode_departemen']!='09'){
										
									$lembur_hari1=mysql_query("SELECT count(id_karyawan) as total_lembur_hari FROM absen 
									WHERE tanggal_absen IN (SELECT tanggal_lembur FROM lembur_hari WHERE tanggal_lembur BETWEEN '$tgl_baru' and '$tglakhir')
									and id_karyawan=$idkaryawan and keterangan_hadir ='pulang'
									") or die(alert_error("Error : ".mysql_error()));
									$lembur_hari1=mysql_fetch_array($lembur_hari1);
									$lembur_hari1=$lembur_hari1['total_lembur_hari'];
									
									$lembur_hari=mysql_query("SELECT count(id_karyawan) as total_lembur_hari FROM absen 
									WHERE tanggal_absen IN (SELECT tanggal_lembur FROM lembur_hari WHERE tanggal_lembur BETWEEN '$tgl_baru' and '$tglakhir')
									and id_karyawan=$idkaryawan and keterangan_hadir is null
									") or die(alert_error("Error : ".mysql_error()));
									$lembur_hari=mysql_fetch_array($lembur_hari);
									$lembur_hari=$lembur_hari['total_lembur_hari'] + ($lembur_hari1 / 2);
								}
								else{
									$lembur_hari=0;
								}
								
								$libur_nasional=mysql_query("SELECT count(tanggal_libur_nasional) as total_nasional FROM libur_nasional WHERE tanggal_libur_nasional BETWEEN '$tgl_baru' and '$tglakhir' ");
								$libur_nasional=mysql_fetch_array($libur_nasional);
								// echoecho $lama_kerja;
								$hitung_libur_nasional = $libur_nasional['total_nasional'];
								//pulang
								$pulang=hitung_ket_karyawan_range($idkaryawan,'pulang',$b,$t);
								$libur=hitung_ket_karyawan_range($idkaryawan,'libur',$b,$t);
									
									
									//LIBUR OFF
									// $total_kerja1 = hitung_jml_karyawan($idkaryawan,$b,$t) - $izin - ($alfa * 2)  - ($pulang / 2)  ;
									$hitung_jml=array();
									for($i=0;$i<$ulang;$i++)
									{
										$date=date("Y-m-d",strtotime("+$i day", strtotime($tgl_baru)));
										$tgl_tmb=mysql_query("select id_absen from absen where tanggal_absen='$date' and id_karyawan='$idkaryawan' 
										");
										$hit=mysql_num_rows($tgl_tmb);
										if(!$hit){
											$hitung_jml[]=1;
										}
										// else $hitung_jml[]=0;
										
									}
									$sakit=hitung_ket_karyawan_range($idkaryawan,'skd',$b,$t) ;
									$izin=hitung_ket_karyawan_range($idkaryawan,'izin',$b,$t) ;
									$alfa=hitung_ket_karyawan_range($idkaryawan,'alfa',$b,$t);
									$off=hitung_ket_karyawan_range($idkaryawan,'libur',$b,$t);
									$spd=hitung_ket_karyawan_range($idkaryawan,'spd',$b,$t);
									$telat = hitung_telat_karyawan($idkaryawan,$b,$t) ;
									total_lembur_range($idkaryawan,$b,$t) ;
									$libur=count($hitung_jml) - $hitung_libur_nasional + $lembur_hari + $off; 
									$total_kerja = hitung_jml_karyawan_range($idkaryawan,$b,$t) - $izin - ($alfa * 2) - $lembur_hari - ($pulang / 2) - $off + $spd;
									$tm =  ($alfa * 2) + $izin + ($pulang/2) ;
									?>
								<tr >
									<td ><?php echo $no; ?></td>
									<td ><?php echo $Kar['nik']?></td>
									<td ><?php echo $Kar['nama_lengkap'] ?></td>
									<td ><?php echo $Kar['nama_jabatan']?> </td>
									<td ><?php echo $jumlah_hari ?></td>
									<td ><?php echo $hitung_libur_nasional ?></td>
									
									<td><?php echo ($libur < 0 ) ? 0 : abs($libur); ?></td>
									<td ><center><?php echo $sakit=hitung_ket_karyawan_range($idkaryawan,'skd',$b,$t) ?></center></td>
									<td ><center><?php echo $izin=hitung_ket_karyawan_range($idkaryawan,'izin',$b,$t) ?></center></td>
									<td ><center><?php echo $alfa=hitung_ket_karyawan_range($idkaryawan,'alfa',$b,$t)?></center></td>
									<td ><center><?php echo $telat = hitung_telat_karyawan($idkaryawan,$b,$t) ?></center></td>
									<td><?php echo total_lembur_range($idkaryawan,$b,$t) ?></td>
									<td><?php echo $lembur_hari = $lembur_hari ?> </td>
									<td><?php echo $total_kerja ?></td>
									<td><?php echo $tm =  ($alfa * 2) + $izin + ($pulang/2) ?></td>
									
									<td>
										<?php 
										if(mysql_num_rows($cari_spdq))
										{
											$ket =  "Berhenti Tanggal ". $cari_spd['tanggal_absen'];
										}
										echo $ket;
										?>
									</td>
								</tr>
							<?php 
							$no++;
							}
							?>
							</tbody>
							<!--<tfoot>
								<tr >
									<th >No.</th>
									<th >Nama </th>
									<th >Jabatan</th>
									<th >Total Hari</th>
									<th >Libur Nasional</th>
									<th >Libur/Off</th>
									<th><center>S</center></th>
									<th><center>I</center></th>
									<th><center>A</center></th>
									<th>Telat</th>
									<th>Lembur(Jam)</th>
									<th>Lembur(Hari)</th>
									<th>Masuk</th>
									<th>Tidak Masuk</th>
									<th>Keterangan</th>
								</tr>
							</tfoot> -->
						</table>
					</div>
				</div>
			</div>
		</div>

		</section>
		<?php
	}
	
	echo "<hr/>";
}

echo "saved ".date("h:i:s d/M/y ");
$objPHPExcel->getActiveSheet()->setTitle('Absen Rekap Total');
  
$objPHPExcel->setActiveSheetIndex(0);
exit;

?>
