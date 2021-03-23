<?php 
include"../config/setting.php";
include"../config/koneksi.php";
include"../fungsi/config.php";
include"../fungsi/lihat.php";
include"../fungsi/jabatan.php";
include"../fungsi/departemen.php";

$id=aman($_POST['id']);
$q=mysql_query("select karyawan.tgl_masuk,karyawan.id_jabatan, karyawan.nama_lengkap,karyawan.nik,karyawan.id_karyawan, resign.* 
from karyawan, resign where karyawan.id_karyawan=resign.id_karyawan and status_karyawan=5 and resign.id_resign='$id' order by id_resign desc") or die(alert_error(mysql_error()));
$r=mysql_fetch_object($q);
$jab=cari_jabatan($r->id_jabatan);
$dep=cari_dep($jab->id_departemen);
$lama=lama_kerja($r->tgl_masuk,$r->tanggal_resign);

?>
<table class='table'>
	<tr>
		<td>Nama</td>
		<td><?php echo  $r->nama_lengkap?></td>
	</tr>
	<tr>
		<td>Jabatan</td>
		<td><?php echo  ($jab->nama_jabatan)?></td>
	</tr>
	<tr>
		<td>Departemen</td>
		<td><?php echo  ($dep->nama_departemen)?></td>
	</tr>
	<tr>
		<td>Tanggal Masuk</td>
		<td><?php echo  tanggal($r->tgl_masuk)?></td>
	</tr>
	<tr>
		<td>Tanggal Resign</td>
		<td><?php echo  tanggal($r->tanggal_resign)?></td>
	</tr>
	<tr>
		<td>Lama Kerja</td>
		<td><?php echo ($lama['years']==0) ? "" : $lama['years']." Tahun," ?> <?php echo ($lama['months']==0) ? "" : $lama['months']." Bulan," ?> <?php echo $lama['days'] ?> hari</td>
	</tr>
	
	<tr>
		<td>Alasan</td>
		<td><?php echo  $r->alasan_resign?></td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td><?php echo  $r->keterangan?></td>
	</tr>
	<tr>
		<td>input</td>
		<td><?php echo  waktu($r->date_created)?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><a href='<?php echo url('../index.php?mn=resign&act=tambah&id='.$r->id_karyawan)?>' class='btn btn-info btn-xs btn-flat'><i class='fa fa-edit'></i> Edit</a></td>
	</tr>
</table>