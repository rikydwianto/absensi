<?php
$id=get("id_suplier");
$q=mysql_query("delete from suplier where id_suplier='$id'");
if($q)
	echo alert("Berhasil Dihapus");
else
	echo alert_error("Error : ". mysql_error());
direct(kembali());
?>
