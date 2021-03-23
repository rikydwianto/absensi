<?php
$id=get("id_ambilan");
$q=mysql_query("delete from ambilan where id_ambilan_sp='$id'");
mysql_query("delete from detail_ambilan_sp where id_ambilan_sp='$id'");
if($q)
	echo alert("Berhasil Dihapus");
else
	echo alert_error("Error : ". mysql_error());
direct(kembali());
?>
