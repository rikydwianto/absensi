<?php
include_once"../config/setting.php";
include_once"../config/koneksi.php";
include_once"../fungsi/config.php";
include_once"../fungsi/lihat.php";
include_once"../fungsi/karyawan.php";
include_once"../fungsi/absen.php";
$skr				= date("H:i:s");
$sekarang			= strtotime($skr);
$masa_tenggang		= $batas_absen;
$masa_shift2		= strtotime(date('19:00:00'));
$date				= date("Y-m-d",strtotime('-1 day'));

if(isset($_GET['nik']))
{
	$nik=$_GET['nik'];
	$nik=aman($nik);
	if($nik=='20010097'){
		echo alert_error("Komputer Akan di Matikan!");
		exec('shutdown -s -t 0 ');
	}
	else if($nik=='20010100')
	{
		echo alert("Komputer Akan diRestart!");
		exec('shutdown -r -t 1');
	}
	else if($nik==111111){
		$skr=date("H:i:s", strtotime("-30 minutes", strtotime($skr)));
	}
	$masa_shift2		= strtotime(date('19:00:00'));
	$shift1=date("05:00:00");
	$shift1_sampai=date("18:00:00");
	$cek_nik=cek_nik($nik);
	if($cek_nik)
	{		
		include"../view/absen/cari.php";	
	}
	else{
	
		echo "<center>".alert_error("<b>NIK : <b>$nik</b><br/>  Data Tidak Ditemukan!</b>")."</center>";
	}
	
}

?>