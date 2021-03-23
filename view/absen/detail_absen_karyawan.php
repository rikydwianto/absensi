<?php
//$karyawan=detail_karyawan($cek_nik->id_karyawan);
$karyawan=mysql_query("select nama_lengkap,nik,file_foto,id_karyawan  from karyawan where id_karyawan='$cek_nik->id_karyawan'");
$karyawan=mysql_fetch_object($karyawan);
$absen=mysql_query("select * from absen where id_absen='$idabsen'");
$absen=mysql_fetch_object($absen);
?>
<center>
<table style='width:100%'>
	<tr>
		<th colspan=3 >
			<center>
				<img src='<?php echo url(cek_photo($karyawan->id_karyawan))?>' class='img img-responsive' style='width:120px;;text-align:center'/>
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
	<!-- <tr>
		<td>Jam Masuk</td>
		<td>:</td>
		<td><?php echo @$absen->jam_masuk ?></td>
	</tr>
	<tr>
		<td>Jam Keluar</td>
		<td>:</td>
		<td><?php echo @$absen->jam_keluar ?></td>
	</tr>
	<tr>
		<td>Jumlah Lembur(menit)</td>
		<td>:</td>
		<td><?php echo @$absen->menit_lembur ?></td>
	</tr> -->
</table>
</center>
