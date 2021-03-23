<?php
$url=$_GET['url'];
$id=aman($_GET['id']);
$q=mysql_query("delete from lembur_hari where id_lembur_hari='$id'");
if($q){
	echo alert("lembur pada ".tanggal($_GET['tgl'])." Berasil dihapus!");
}
else
	echo alert_error("Error Mysql query : ". mysql_error());
direct($url);
?>