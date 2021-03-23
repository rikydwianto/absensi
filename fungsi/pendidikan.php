<?php 
function tampil_pendidikan($id){
	$q=mysql_query("select * from riwayat_pendidikan where id_karyawan='$id'");
	return $q;
}
?>