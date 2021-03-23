<?php
$id=aman($_GET['id']);
$karyawan=detail_karyawan($id);
$Qberkas=mysql_query("select * from berkas where id_karyawan='$id'");
$nik= $karyawan->nik;
$folder="data/berkas/$nik/";
while($berkas=mysql_fetch_array($Qberkas)){
	@unlink($folder.$berkas['file']);
}
$q=mysql_query("delete from berkas where id_karyawan='$id'");
if($q)
	echo alert("Semua berkas berhasil dihapus!");
else
	echo alert_error("Error : ". mysql_error());
direct(url('index.php?mn=berkas&id='.$id));
?>