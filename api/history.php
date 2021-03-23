<?php
include_once"../config/setting.php";
include_once"../config/koneksi.php";
include_once"../fungsi/config.php";
include_once"../fungsi/lihat.php";
include_once"../fungsi/karyawan.php";
include_once"../fungsi/absen.php";
header('Content-Type: application/json');
$q = mysql_query("select * from absen join karyawan on karyawan.id_karyawan=absen.id_karyawan order by absen.date_modified desc limit 0,100");
echo mysql_error();
$a = array();
while($absen  = mysql_fetch_array($q)){
	$a['nik']=$absen['nik'] ;
	$a['nama_lengkap']=$absen['nama_lengkap'] ;
	$a['tanggal_absen']=$absen['tanggal_absen'];
	$a['jam_masuk']=$absen['jam_masuk'];
	$a['jam_keluar']=$absen['jam_keluar'];
	$a['menit_lembur']=$absen['menit_lembur'];
	$a['keterangan_hadir']=$absen['keterangan_hadir'];
}
	echo json_encode($a);
?>
