<?php
$url=$_GET['url'];
$id=aman($_GET['id']);
$q=mysql_query("delete from libur_nasional where id_libur_nasional='$id'");
if($q){
	echo alert("Libur Nasional pada ".tanggal($_GET['tgl'])." Berasil dihapus!");
}
else
	echo alert_error("Error Mysql query : ". mysql_error());
direct($url);
?>