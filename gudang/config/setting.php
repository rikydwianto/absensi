<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
//error_reporting(0);
$host	 = "localhost";
$user	 = "root";
$pass	 = "";
$dabname = "ptlsg_baru";

$foldername="sim_lsg";
$folder_data="data";
$folder_foto= $folder_data."/foto";
$folder_berkas= $folder_data."/berkas";
// Hari


$batas_absen=strtotime(date("06:45:59"));



$title="PT Lydia Sola Gracia";
$nm_aplikasi="GUDANG";
$path_web=$_SERVER['DOCUMENT_ROOT']."/".$foldername."/";
$label_footer="Sistem Informasi Kepegawaian " . $title ;
?>