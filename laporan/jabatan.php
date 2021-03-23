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
header('Content-Type: applicatio n/vnd.ms-excel' );
header('Content-Disposition: attachment;filename="Data Jabatan.xls"' );
header('Cache-Control: max-age=0');
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
<div class='table-responsive'>
<table class='table table-responsive' border=1 id="exaample1">
	<thead>
		<tr>
			<th>ID.</th>
			<th>Kode Jabatan</th>
			<th>Departemen</th>
			<th>Jabatan</th>
			<th>Deskripsi</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$q=tampil_jabatan();
	while($r=mysql_fetch_object($q))
	{
		$dep=cari_dep($r->id_departemen);
		?>
		
		<tr>
			<td><?php echo $r->id_jabatan ?></td>
			<td><?php echo $r->kode_jabatan ?></td>
			<td><?php echo $dep->nama_departemen?></td>
			<td><?php echo $r->nama_jabatan?></td>
			<td><?php echo ($r->deskripsi_jabatan) ?></td>
		</tr>
		<?php
	}
	?>
	</tbody>
	<tfoot>
		<tr>
			<th>ID.</th>
			<th>Kode Jabatan</th>
			<th>Jabatan</th>
			<th>Deskripsi</th>
			<th>#</th>
		</tr>
	</tfoot>
</table>
</div>
<?php

exit;

?>
