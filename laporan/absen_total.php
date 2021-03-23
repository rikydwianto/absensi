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
error_reporting(0);
if(isset($_GET['cr']))
{
	$t=aman($_GET['tahun']);
	$b=aman($_GET['bulan']);
	$id_jabatan=aman($_GET['jab']);
}
else{
	$b=date("m");
	$t=date("Y");
	$id_jabatan=null;
}
$b=sprintf('%02s', $b);
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $b, $t);
// header('Content-Type: applicatio n/vnd.ms-excel' );
// header('Content-Disposition: attachment;filename="Rekap Absen '.cek_bulan($b).' '.$t.'.xls"' );
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
Waktu Save : <?php echo waktu(date("Y-m-d H:i:s")) ?> <br/>
Laporan Absen : <?php echo cek_bulan($b) ?> <?php echo $t ?> <br/>

<table border=1 class=' table- table-hover' >
	<thead>
	<tr>
		<th colspan='<?php echo $jumlah_hari + 2 + 6  ?>' >
			<center><?php echo cek_bulan($b) ?> <?php echo $t?></center>
		</th>
	</tr>
	<tr>
		<th >No</th>
		<th >Nama</th>
		<th >Departemen</th>
		<th >Jabatan</th>
		<?php 
		for($i=1;$i<=$jumlah_hari;$i++){
			$m= date("l",strtotime(date("$t-$b-$i")));
			if($m=='Sunday')
				$minggu="style='background:#ff9999'";
			else
				$minggu='';
			echo"<th $minggu width='25'><center>$i</center></th>";
		}
		?>
		
		<th width='25' ><center>A</center></th>
		<th width='25'><center>S</center></th>
		<th width='25'><center>I</center></th>
		<th width='25'><center>TM</center></th>
		<th width='25'><center>P</center></th>
		<th width='25'><center>Jml</center></th>
	</thead>
	<tbody>
	<?php 
	$no=1;
	$query="select id_karyawan,nik,nama_lengkap,nama_departemen,nama_jabatan from karyawan,departemen,jabatan where 
	departemen.id_departemen=jabatan.id_departemen and karyawan.id_jabatan=jabatan.id_jabatan  order by departemen.id_departemen,jabatan.id_jabatan,karyawan.tgl_masuk asc";
	#and departemen.id_departemen='$id_jabatan'
	$query=mysql_query($query) or die(alert_error("Error : ".mysql_error()));
	$jm=0;
	while($Kar=mysql_fetch_object($query))
	{
		?>
	<tr>
		<td class=''>
		<?php echo $no ?>
		</td>
		<td><?php echo $Kar->nama_lengkap ?></td>
		<td><?php echo $Kar->nama_departemen ?></td>
		<td><?php echo $Kar->nama_jabatan ?></td>
		<?php 
		for($i=1;$i<=$jumlah_hari;$i++){
			$ket = absen_tgl($Kar->id_karyawan,$i,$b,$t);
			$m= date("l",strtotime(date("$t-$b-$i")));
			if($m=='Sunday')
				$minggu="style='background:#ff9999'";
			else
				$minggu='';
			if(is_int($ket)){
				if($ket=='-1'){
					$ket="<b style='color:red'>$ket</b>";
				}
				else
					$ket=$ket;//'class="bg-red"';
			}
			else
				if($ket=='S'){
					$ket="<b style='color:green'>$ket</b>";
				}
				else if($ket=='I'){
					$ket="<b style='color:blue'>$ket</b>";
					
				}
			echo "<td $minggu style='width:7px'><center>".$ket.'</center></td>';
			$total_kerja = hitung_jml_karyawan($Kar->id_karyawan,$b,$t);
		}
		?>
		<td class='bg-red'><center><?php echo $alfa=hitung_ket_karyawan($Kar->id_karyawan,'alfa',$b,$t)?></center></td>
		<td class='bg-green'><center><?php echo $sakit=hitung_ket_karyawan($Kar->id_karyawan,'sakit',$b,$t) ?></center></td>
		<td class='bg-blue'><center><?php echo $izin=hitung_ket_karyawan($Kar->id_karyawan,'izin',$b,$t) ?></center></td>
		<td class='bg-yellow'><center><?php echo $jumlah_hari - $total_kerja + ($alfa * 2) + $sakit + $izin?></center></td>
		<td class='bg-yellow'><center><?php echo $pulang = hitung_ket_karyawan($Kar->id_karyawan,'pulang',$b,$t) ?></center></td>
		<td class='bg-black'><center><?php echo $total_kerja - ($alfa * 2)- $izin - ($pulang / 2)?></center></td>
	</tr>
		<?php
	$no++;
	}
	?>
	</tbody>
</table>
<?php

exit;

?>
