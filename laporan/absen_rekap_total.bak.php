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
	@$id_jabatan=aman($_GET['jab']);
}
else{
	$b=date("m");
	$t=date("Y");
	@$id_jabatan=null;
}
$b=sprintf('%02s', $b);
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $b, $t);
header('Content-Type: applicatio n/vnd.ms-excel' );
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
table {
    table-layout: fixed;
	 border-collapse: collapse;
} 
	table tr td{
		vertical-align: text-top;
		padding:0;
	}
</style>
<?php 
error_reporting(0);
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $b, $t);
$jab=cari_jabatan($id_jab_dep);
$dep=cari_dep($id_jabatan);
?>
Waktu Save : <?php echo waktu(date("Y-m-d H:i:s")) ?> <br/>
Laporan Absen : <?php echo cek_bulan($b) ?> <?php echo $t ?> <br/>
Nama Departemen : Semua Departemen<br/>

<table border=1 class=' table' style='width:100%'>
	<thead>
		<tr>
			<th colspan='12'>
				<center>
					Rekap Total <?php echo cek_bulan($b).' '.$t?> 
				</center>
			</th>
		</tr>
		<tr >
			<th rowspan=2><center>No.</center></th>
			<th rowspan=2><center>Nama </center></th>
			<th rowspan=2><center>Departemen</center></th>
			<th rowspan=2><center>Jabatan</center></th>
			<th >Total Hari</th>
			<th colspan=3><center>Absensi</center></th>
			<th rowspan=2><center>Telat</center></th>
			<th rowspan=2><center>Lembur(Jam)</center></th>
			<th rowspan=2><center>Lembur(Hari)</center></th>
			<th colspan=2><center>Total</center></th>
		</tr>
		<tr >
			<th >Hari/bln</th>
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
	$query="select id_karyawan,nik,nama_lengkap,nama_jabatan,nama_departemen,datediff(curdate(),tgl_masuk) as lama_kerja,kode_departemen from karyawan,jabatan,departemen where departemen.id_departemen=jabatan.id_departemen 
	and karyawan.id_jabatan=jabatan.id_jabatan order by departemen.id_departemen,jabatan.id_jabatan,karyawan.tgl_masuk asc  ";
	$query=mysql_query($query) or die("Error : ".mysql_error());
	$jm=0;
	$no=1;
	$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $b, $t);
	while($Kar=mysql_fetch_object($query))
	{
		if($Kar->kode_departemen!='09'){
		
		$lembur_hari=mysql_query("SELECT count(id_karyawan) as total_lembur_hari FROM absen WHERE tanggal_absen IN (SELECT tanggal_lembur FROM lembur_hari WHERE tanggal_lembur like '$t-$b-%') and id_karyawan=$Kar->id_karyawan ") or die(alert_error("Error : ".mysql_error()));
		$lembur_hari=mysql_fetch_array($lembur_hari);
		$lembur_hari=$lembur_hari['total_lembur_hari'];
		}
		else{
			$lembur_hari=0;
		}
		
		$lama_kerja=$Kar->lama_kerja;
		if($lama_kerja>=$jumlah_hari)
			$lama_per_bulan=$jumlah_hari;
		else
			$lama_per_bulan=$lama_kerja;
		?>
		<tr >
			<td ><?php echo $no; ?></td>
			<td ><?php echo $Kar->nama_lengkap ?></td>
			<td ><?php echo $Kar->nama_departemen ?> </td>
			<td ><?php echo $Kar->nama_jabatan ?> </td>
			<td ><?php echo $lama_per_bulan ?></td>
			<td ><center><?php echo $sakit=hitung_ket_karyawan($Kar->id_karyawan,'sakit',$b,$t) ?></center></td>
			<td ><center><?php echo $izin=hitung_ket_karyawan($Kar->id_karyawan,'izin',$b,$t) ?></center></td>
			<td ><center><?php echo $alfa=(int) hitung_ket_karyawan($Kar->id_karyawan,'alfa',$b,$t)?></center></td>
			<td ><center><?php echo hitung_telat_karyawan($Kar->id_karyawan,$b,$t) ?></center></td>
			<td><?php echo total_lembur($Kar->id_karyawan,$b,$t) ?></td>
			<td><?php echo $lembur_hari ?> Hari</td>
			<td><?php echo $total_kerja = hitung_jml_karyawan($Kar->id_karyawan,$b,$t) - ($alfa * 2) - $izin - $lembur_hari ?></td>
			<td><?php echo $tm = $lama_per_bulan - $total_kerja   ?></td>
		</tr>
	<?php 
	$no++;
	}
	?>
	</tbody>
	<tfoot>
		<tr >
			<th >No.</th>
			<th >Nama </th>
			<th >Departemen</th>
			<th >Jabatan</th>
			<th >Total Hari/bln</th>
			<th><center>S</center></th>
			<th><center>I</center></th>
			<th><center>A</center></th>
			<th>Telat</th>
			<th>Lembur(Jam)</th>
			<th>Lembur(Hari)</th>
			<th>Masuk</th>
			<th>Tidak Masuk</th>
		</tr>
	</tfoot>
</table>
<?php  
$objPHPExcel->getActiveSheet()->setTitle('Absen Rekap Total');
  
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->save('php://output');
exit;

?>
