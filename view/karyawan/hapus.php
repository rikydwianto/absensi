<?php 
$id=aman($_GET['id']);
$q=hapus_jabatan($id);
if($q)
{
	echo alert("Berhasil dihapus");
	$ket="User $id telah dihapsus oleh admin  <code>$user->nama_lengkap</code>";

	@mysql_query("insert into record (id_karyawan,id_karyawan_input,waktu,tanggal,keterangan,date_created)
	values($id,$_SESSION[id_karyawan],now(),curdate(),'$ket',now())
	");
}
else
{
	echo alert_error("Jabatan, Gagal dihapus! Error : ".mysql_error());
}
direct(urldecode($_GET['url']));
?>
