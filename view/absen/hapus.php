<?php 
$id=aman($_GET['id']);
$q=hapus_lembur($id);
if($q)
{
	echo alert("Berhasi dihapus");
}
else
{
	echo alert_error(" Gagal dihapus! Error : ".mysql_error());
}
direct(urldecode($_GET['url']));
?>
