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
//error_reporting(0);
if(isset($_GET['bulan']) || isset($_GET['tahun']))
{
	$t=aman($_GET['tahun']);
	$b=aman($_GET['bulan']);
}
else{
	$b=date("m");
	$t=date("Y");
}
$b=sprintf('%02s', $b);
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $b, $t);
header('Content-Type: application/vnd.ms-excel' );
 header("Content-type: application/x-msdownload");
header('Content-Disposition: attachment;filename="Rekap Total Absen '.cek_bulan($b).' '.$t.'.xls"' );
header('Cache-Control: max-age=0');
function nama_karyawan($id)
{
	$q=mysql_query("select nama_lengkap from karyawan where id_karyawan='$id'");
	$r=mysql_fetch_array($q);
	return $r['nama_lengkap'];
}
?>
<style>

</style>
<?php 
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $b, $t);
?>
Waktu Save : <?php echo waktu(date("Y-m-d H:i:s")) ?> <br/>
Laporan Absen : <?php echo cek_bulan($b) ?> <?php echo $t ?> <br/><br/>
<?php  
$no=1;
$dep=mysql_query("select * from departemen order by kode_departemen asc") or die(mysql_error());
while($Rdep=mysql_fetch_array($dep)){

	
	$qjab=mysql_query("select * from jabatan where id_departemen='$Rdep[id_departemen]' order by nama_jabatan");
	while($Rjab=mysql_fetch_array($qjab)){
	$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $b, $t);
	$jumlah_hari1 = cal_days_in_month(CAL_GREGORIAN, $b, $t);
	$hitung_libur_nasional=hitung_libur_nasional($b,$t);
		echo "Nama Departemen : ".$Rdep['nama_departemen'].'['.$Rjab['nama_jabatan'].']'.' </br> ';
		?>
		
		<table border=1 class=' table- table-hover' style='width:100%'>
			<thead>
				<tr>
					<th colspan='14'>
						<center>
							Rekap Total <?php echo cek_bulan($b).' '.$t?> 
						</center>
					</th>
				</tr>
				<tr >
					<th rowspan=2><center>No.</center></th>
					<th rowspan=2><center>Nama </center></th>
					<th rowspan=2><center>Jabatan</center></th>
					<th >Total Hari</th>
					<th >Libur</th>
					<th colspan=3><center>Absensi</center></th>
					<th rowspan=2><center>Telat</center></th>
					<th rowspan=2><center>Lembur(Jam)</center></th>
					<th rowspan=2><center>Lembur(Hari)</center></th>
					<th colspan=3><center>Total</center></th>
				</tr>
				<tr >
					<th >Hari/bln</th>
					<th >Nasional</th>
					<th><center>S</center></th>
					<th><center>I</center></th>
					<th><center>A</center></th>
					<th>Masuk</th>
					<th>Tidak Masuk</th>
					<th>Libur</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$query="select id_karyawan,nik,nama_lengkap,nama_jabatan,datediff(curdate(),tgl_masuk) as lama_kerja,tgl_masuk,kode_departemen from karyawan,jabatan,departemen where departemen.id_departemen=jabatan.id_departemen 
			and karyawan.id_jabatan=jabatan.id_jabatan and karyawan.status_karyawan!=5 and jabatan.id_jabatan='$Rjab[id_jabatan]' order by karyawan.tgl_masuk ";
			$query=mysql_query($query);
			$jm=0;
			$no=1;
			while($Kar=mysql_fetch_array($query))
			{
				$idkaryawan=$Kar['id_karyawan'];
				$tgl_masuk=explode("-",$Kar['tgl_masuk']);
				$tgl_masuk=$tgl_masuk[2];
				if($Kar['kode_departemen']!='09'){
				
				$lembur_hari=mysql_query("SELECT count(id_karyawan) as total_lembur_hari FROM absen WHERE tanggal_absen IN (SELECT tanggal_lembur FROM lembur_hari WHERE tanggal_lembur like '$t-$b-%') and id_karyawan=$idkaryawan ") or die(alert_error("Error : ".mysql_error()));
				$lembur_hari=mysql_fetch_array($lembur_hari);
				$lembur_hari=$lembur_hari['total_lembur_hari'];
				}
				else{
					$lembur_hari=0;
				}
				
				$lama_kerja=$Kar['lama_kerja'] + 1;
				
				if($lama_kerja>=$jumlah_hari1)
				{
					$lama_per_bulan=$jumlah_hari;
					$lama_libur=$hitung_libur_nasional;	
				}
				else{
					$lama_per_bulan=$lama_kerja;
					$jumlah_libur=0;
					for($i=$tgl_masuk;$i<=$jumlah_hari1;$i++){
						$detail_libur=mysql_query("select count(id_libur_nasional) as total from libur_nasional where tanggal_libur_nasional='$t-$b-$i'") or die(mysql_error());
						$detail_libur=mysql_fetch_array($detail_libur);
						$detail_libur = $detail_libur['total'];
						if($detail_libur==1){
							$jumlah_libur=$jumlah_libur+1;
						}
					}
					$lama_libur=($jumlah_libur);
				}
				$hitung_libur_nasional = $lama_libur;
				//pulang
				$jumlah_hari=$lama_per_bulan;
				$pulang=hitung_ket_karyawan($idkaryawan,'pulang',$b,$t);
				
				?>
				<tr >
					<td ><?php echo $no; ?></td>
					<td ><?php echo $Kar['nama_lengkap'] ?>[<?php echo $Kar['nik']?>]</td>
					<td ><?php echo $Kar['nama_jabatan']?> </td>
					<td ><?php echo $jumlah_hari ?></td>
					<td ><?php echo $hitung_libur_nasional ?></td>
					<td ><center><?php echo $sakit=hitung_ket_karyawan($idkaryawan,'skd',$b,$t) ?></center></td>
					<td ><center><?php echo $izin=hitung_ket_karyawan($idkaryawan,'izin',$b,$t) ?></center></td>
					<td ><center><?php echo $alfa=hitung_ket_karyawan($idkaryawan,'alfa',$b,$t)?></center></td>
					<td ><center><?php echo $telat = hitung_telat_karyawan($idkaryawan,$b,$t) ?></center></td>
					<td><?php echo total_lembur($idkaryawan,$b,$t) ?></td>
					<td><?php echo $lembur_hari = $lembur_hari ?> Hari</td>
					<td><?php echo $total_kerja = hitung_jml_karyawan($idkaryawan,$b,$t) - $izin - ($alfa * 2) - $lembur_hari - ($pulang / 2) ?></td>
					<td><?php echo $tm =  ($alfa * 2) + $izin ?></td>
					<?php 
					//LIBUR OFF
					$total_kerja1 = hitung_jml_karyawan($idkaryawan,$b,$t) - $izin - ($alfa * 2)  - ($pulang / 2) ;
					if($lama_kerja>=$jumlah_hari1){
						$libur = $jumlah_hari - ($total_kerja1 + $tm + $hitung_libur_nasional) + $lembur_hari;
					}
					else
					{
						$jumlah=0;
						for($a=$tgl_masuk;$a<=$jumlah_hari1;$a++){
							$cek_=mysql_query("select count(id_karyawan) as total from absen where tanggal_absen='$t-$b-$a' and id_karyawan='$idkaryawan'");
							$cek_=mysql_fetch_array($cek_);
							$cek = $cek_['total'];
							if($cek==0)
							{
								$jumlah += 1;
							}
						}
						 $libur= $jumlah - $hitung_libur_nasional - ($pulang / 2) + $lembur_hari ;
						 $jumlah=0;
					}
					?>
					<td><?php echo $libur; ?> Hari</td>

				</tr>
			<?php 
			$no++;
			}
			?>
			</tbody>
			<tfoot>
				<tr align='center'>
					<th >No.</th>
					<th >Nama </th>
					<th >Jabatan</th>
					<th >Total Hari/bln</th>
					<th >Libur Nasional</th>
					<th><center>S</center></th>
					<th><center>I</center></th>
					<th><center>A</center></th>
					<th>Telat</th>
					<th>Lembur(Jam)</th>
					<th>Lembur(Hari)</th>
					<th>Masuk</th>
					<th>Tidak Masuk</th>
					<th>Libur</th>
				</tr>
			</tfoot>
		</table>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<?php
	}
}
$objPHPExcel->getActiveSheet()->setTitle('Absen Rekap Total');
  
$objPHPExcel->setActiveSheetIndex(0);
exit;

?>
