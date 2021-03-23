<?php 
$id=aman($_GET['id_pend']);
$q=mysql_query("delete from riwayat_pendidikan where id_riwayat_pendidikan='$id' ");
if($q)
{
	echo alert("Berhasil dihapus");
}
else
{
	echo alert_error("Gagal dihapus! Error : ".mysql_error());
}
direct(urldecode($_GET['url']));
?>
