<?php 
function tampil_keluarga($id){
	$q=mysql_query("select * from keluarga where id_karyawan='$id'");
	return $q;
}
function detail_keluarga($id){
	$q=mysql_query("select * from keluarga where id_keluarga='$id'") or die(alert_error(mysql_error()));
	return mysql_fetch_object($q);
}

function hapus_keluarga($id)
{
	$q=mysql_query("delete from keluarga where id_keluarga='$id'") or die(alert_error(mysql_error()));
	return $q;
}
?>