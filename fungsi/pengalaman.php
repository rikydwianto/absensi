<?php 
function tampil_pengalaman($id){
	$q=mysql_query("select * from riwayat_kerja where id_karyawan='$id'");
	return $q;
}
?>