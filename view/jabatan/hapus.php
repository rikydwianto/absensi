<?php 
$id=aman($_GET['id']);
$q=hapus_jabatan($id);
if($q)
{
	echo alert("Berhasil dihapus");
}
else
{
	echo alert_error("Jabatan, Gagal dihapus! Error : ".mysql_error());
}
direct(urldecode($_GET['url']));
?>
