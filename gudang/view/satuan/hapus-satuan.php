<?php
$id=get("id_satuan");
$q=mysql_query("delete from satuan where id_satuan='$id'");
if($q)
	echo alert("Berhasil Dihapus");
else
	echo alert_error("Error : ". mysql_error());
direct(kembali());
?>
