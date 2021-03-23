<?php include"fungsi/departemen.php"; ?>
<?php 
$id=aman($_GET['iddep']);
$q=hapus_dep($id);
if($q)
{
	echo alert("Departemen Berhasi dihapus");
}
else
{
	echo alert_error("Departemen, Gagal dihapus! Error : ".mysql_error());
}
direct(urldecode($_GET['url']));
?>
