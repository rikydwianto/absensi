<?php 
include"../config/setting.php";
include"../config/koneksi.php";
include"../fungsi/config.php";
include"../fungsi/lihat.php";
include"../fungsi/karyawan.php";
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
header('Content-Disposition: attachment;filename="Data Karyawan.xls"' );
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
} 
	table tr td{
		vertical-align: text-top;
		padding:0;
	}
</style>
<table border=1  >
	<thead>
		<tr>
			<th>No</th>
			<th>ID</th>
			<th>No KTP</th>
			<th>NIK</th>
			<th>Nama</th>
			<th>Panggilan</th>
			<th>Jenis Kelamin</th>
			<th>Departemen</th>
			<th>Jabatan</th>
			<th>Lama Kerja</th>
			<th>Status Karyawan</th>
			<th>Tempat Lahir</th>
			<th>Tanggal Lahir</th>
			<th>Agama</th>
			<th>Warga Negara</th>
			<th>Status Nikah</th>
			<th>Jumlah Anak</th>
			<th>Nama Ayah</th>
			<th>Nama Ibu</th>
			<th>Alamat Rumah</th>
			<th>Alamat Tinggal</th>
			<th>Telepon 1</th>
			<th>Telepon 2</th>
			<th>Email</th>
			<th>Tanggal Masuk</th>
			<th>Tanggal Keluar</th>
			<th>Catatan</th>
			<th>Pendidikan</th>
			<th>Riwayat Kerja</th>
			<th>Keluarga</th>
			<th>Diinput</th>
			<th>Diedit</th>
		</tr>
	</thead>
	<tbody>
<?php
$no=1;
$q=mysql_query("select * from karyawan,jabatan,departemen where departemen.id_departemen=jabatan.id_departemen and karyawan.id_jabatan=jabatan.id_jabatan order by karyawan.nama_lengkap");
echo mysql_error();
while($karyawan=mysql_fetch_object($q))
{
	if($karyawan->tgl_keluar==null)
		$tgl=date("Y-m-d");
	else
		$tgl=$karyawan->tgl_keluar;
	$lama=lama_kerja($karyawan->tgl_masuk,$tgl);
?>
	<tr>
		<td valign='top'><?php echo $no ?></td>
		<td valign='top'><?php echo $karyawan->id_karyawan ?></td>
		<td valign='top'>'<?php echo $karyawan->no_ktp?></td>
		<td valign='top'>'<?php echo $karyawan->nik?></td>
		<td valign='top'><?php echo $karyawan->nama_lengkap?></td>
		<td valign='top'><?php echo $karyawan->nama_panggilan?></td>
		<td valign='top'><?php echo jk($karyawan->jenis_kelamin)?></td>
		<td valign='top'><?php echo $karyawan->nama_departemen?></td>
		<td valign='top'><?php echo $karyawan->nama_jabatan?></td>
		<td valign='top'>
			<?php echo ($lama['years']==0) ? "" : $lama['years']." Tahun," ?> <?php echo ($lama['months']==0) ? "" : $lama['months']." Bulan," ?> <?php echo $lama['days'] ?> hari
		</td>
		<td valign='top'><?php echo status_karyawan($karyawan->status_karyawan)?></td>
		<td valign='top'><?php echo $karyawan->tpt_lahir?></td>
		<td valign='top'><?php echo ($karyawan->tgl_lahir)?></td>
		<td valign='top'><?php echo $karyawan->agama?></td>
		<td valign='top'><?php echo $karyawan->warganegara?></td>
		<td valign='top'><?php echo status($karyawan->status_nikah)?></td>
		<td valign='top'><?php echo $karyawan->jml_anak?></td>
		<td valign='top'><?php echo $karyawan->nama_ayah?></td>
		<td valign='top'><?php echo $karyawan->nama_ibu?></td>
		<td valign='top'><?php echo $karyawan->alamat_rumah?></td>
		<td valign='top'><?php echo $karyawan->alamat_tinggal?></td>
		<td valign='top'>'<?php echo $karyawan->tlp_1?></td>
		<td valign='top'>'<?php echo $karyawan->tlp_2?></td>
		<td valign='top'><?php echo $karyawan->email?></td>
		<td valign='top'><?php echo $karyawan->tgl_masuk?></td>
		<td valign='top'><?php echo $karyawan->tgl_keluar?></td>
		<td valign='top'><?php echo $karyawan->catatan?></td>
		<td valign='top'>
			<?php 
			$sekolah=mysql_query("select nama_pendidikan from riwayat_pendidikan where id_karyawan='$karyawan->id_karyawan'");
			while($sk=mysql_fetch_object($sekolah)){
				echo"- $sk->nama_pendidikan <br/>";
			}
			?>
		</td>
		<td valign='top'>
			<?php 
			$kerja=mysql_query("select nama_perusahaan,jabatan from riwayat_kerja where id_karyawan='$karyawan->id_karyawan'");
			while($Rkerja=mysql_fetch_object($kerja)){
				echo"- $Rkerja->nama_perusahaan($Rkerja->jabatan) <br/>";
			}
			?>
		</td>
		<td valign='top'>
			<?php 
			$kel=mysql_query("select nama_lengkap from keluarga where id_karyawan='$karyawan->id_karyawan'");
			while($Keluarga=mysql_fetch_object($kel)){
				echo"- $Keluarga->nama_lengkap <br/>";
			}
			?>
		</td>
		<td valign='top'><?php echo @nama_karyawan($karyawan->inputby)?></td>
		<td valign='top'><?php echo @nama_karyawan($karyawan->editby)?></td>
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
