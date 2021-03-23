<?php
include_once"../config/setting.php";
//LOG KHUSUS
$gambar = str_replace(" ","+",$_POST['gambar']);
$folder = '../../rekam/';
if(!file_exists($folder.date("Y-m-d").'/'))
{
	mkdir($folder. date("Y-m-d"));
}
$folder=$folder. date("Y-m-d/");
$img = $gambar;
$img = str_replace('data:image/jpeg;base64,', '', $img);
$data = base64_decode($img);
@$name_file=time().'.jpg';
$name_file=preg_replace('/[^A-Za-z0-9 _ .-]/', '', $name_file);
$file = $folder . $name_file;
// @$success = file_put_contents($file, $data);
$skr				= date("H:i:s");
$d					= date("Y-m-d");
$sekarang			= strtotime($skr);
$masa_tenggang		= $batas_absen;
$masa_shift2		= strtotime(date('20:00:00'));
$date				= date("Y-m-d",strtotime('-1 day'));
$hari				= date("l",strtotime($d));
//if($sekarang == strtotime(date("18:11:16"))){
	//exec('shutdown -s -t 0 ');
}
?>