<?php
$karyawan=mysql_query("select nama_lengkap,nik,file_foto,id_karyawan,id_jabatan,tgl_masuk,tgl_keluar  from karyawan where id_karyawan='$cek_nik->id_karyawan'");
$karyawan=mysql_fetch_object($karyawan);
$jabatan = mysql_query("select * from jabatan join departemen on departemen.id_departemen=jabatan.id_departemen where id_jabatan='$karyawan->id_jabatan' ") or die(alert_error("Error : ". mysql_error()));
$jabatan=mysql_fetch_array($jabatan);
if($karyawan->tgl_keluar==null)
	$tgl=date("Y-m-d");
else
	$tgl=$karyawan->tgl_keluar;
$lama=lama_kerja($karyawan->tgl_masuk,$tgl);
?>
<center>
<table style='width:100%'>
	<tr>
		<th colspan=3 >
			<center>
				<img src='<?php echo url(cek_photo1($karyawan->id_karyawan))?>' class='img img-responsive' style='width:120px;;text-align:center'/>
			</center>
		</th>
	</tr>
	<tr>
		<td>NIK </td>
		<td>:</td>
		<td><b><?php echo $karyawan->nik ?></b></td>
	</tr>
	<tr>
		<td>Nama </td>
		<td>:</td>
		<td><b><?php echo $karyawan->nama_lengkap ?></b></td>
	</tr>
	<tr>
		<td>Lama Kerja </td>
		<td>:</td>
		<td><b><?php echo ($lama['years']==0) ? "" : $lama['years']." Tahun," ?> <?php echo ($lama['months']==0) ? "" : $lama['months']." Bulan," ?> <?php echo $lama['days'] ?> hari</b></td>
	</tr>
	<tr>
		<td>Departemen </td>
		<td>:</td>
		<td><b><?php echo $jabatan['nama_departemen'] ?></b></td>
	</tr>
	<tr>
		<td>Jabatan </td>
		<td>:</td>
		<td><b><?php echo $jabatan['nama_jabatan'] ?></b></td>
	</tr>
	
</table>
</center>
