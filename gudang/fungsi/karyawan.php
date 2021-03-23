<?php 
function cek_karyawan($id){
	$q=mysql_query("select * from karyawan where id_karyawan='$id'") or die(alert_error("Error : ". mysql_error()));
	$r=mysql_fetch_array($q);
	return ($r);
}
?>