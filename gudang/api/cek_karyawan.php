<?php include"../config/setting.php"?>
<?php include"../config/koneksi.php"?>
<?php include"../fungsi/config.php"?>
<?php 
$nik=post('nik');
if(empty($nik))
{
	echo"silahkan isi nik ...";
}
else{
		
	$q=mysql_query("select id_karyawan,nama_lengkap,nama_departemen  from karyawan join jabatan on karyawan.id_jabatan=jabatan.id_jabatan join departemen on departemen.id_departemen=jabatan.id_departemen where nik='$nik'") or die(alert_error("Error : ". mysql_error()));
	if(!mysql_num_rows($q))
	{
		echo"Karyawan Tidak Ditemukan!";
	}
	else
	{
		$r=mysql_fetch_array($q);
		echo $r['nama_lengkap'] .' dari departemen '.$r['nama_departemen'].' ?';
	}
}
?>