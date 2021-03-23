<?php 
$id=get('id_sparepart');
$q=mysql_query("delete from sparepart where id_sparepart='$id'");
if($q)
	echo alert("Berhasil dihapus");
else
	echo alert_error("Gagal : ". mysql_error());
direct(kembali());
?>