<?php 
$id=aman($_GET['id_kel']);
$q=hapus_keluarga($id);
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
