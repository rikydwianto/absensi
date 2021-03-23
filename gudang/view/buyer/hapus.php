<?php
$id=get("id_buyer");
$q=mysql_query("delete from buyer where id_buyer='$id'");
if($q)
	echo alert("Berhasil Dihapus");
else
	echo alert_error("Error : ". mysql_error());
direct(kembali());
?>
