<?php 
$id=aman($_GET['id']);
$nik=aman($_GET['nik']);
$lihat=mysql_query("select * from berkas where id_berkas='$id'");
$lihat=mysql_fetch_array($lihat);
$q=mysql_query("delete from berkas where id_berkas=$id");
$folder="data/berkas/$nik/";
@unlink($folder.$lihat['file']);
if($q)
	direct($_GET['url']);
else
	echo alert_error("Error : ".mysql_error());
?>