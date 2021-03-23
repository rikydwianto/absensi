<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
//error_reporting(0);
$host	 = "localhost";
$user	 = "root";
$pass	 = "root";
$dabname = "ptlsg";

$foldername="sim_lsg";
$folder_data="data";
$folder_foto= $folder_data."/foto";
$folder_berkas= $folder_data."/berkas";
// Hari


$batas=10;
$batas_absen=strtotime(date("06:45:59"));



$title="PT. Lydia Sola Gracia";
$nm_aplikasi="Sistem Informasi Kepegawaian Berbasis WEB";
$path_web=$_SERVER['DOCUMENT_ROOT']."/".$foldername."/";
$label_footer="Sistem Informasi Kepegawaian " . $title ;

/* $_SESSION['user_id']		
$_SESSION['user_name']		
$_SESSION['user_pswd']		
$_SESSION['user_id_karyawan'
$_SESSION['user_level']		
$_SESSION['user_status']
$_SESSION['user_pic']=$foto; */
?>