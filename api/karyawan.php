<?php 
include"../config/setting.php";
include"../config/koneksi.php";
include"../fungsi/config.php";
include"../fungsi/karyawan.php";
include"../fungsi/lihat.php";
$id= aman($_GET['id']);
?>
<?php include_once"../fungsi/jabatan.php"; ?>
<?php 
if(isset($_GET['mn']))
{
	$mn=$_GET['mn'];
	if($mn=='tampil')
	{
		$detail=detail_karyawan(aman($_GET['id']));
		echo $detail->nama_lengkap;
	}
	else if($mn=='hapus'){
		hapus_karyawan(aman($_GET['id']));
	}
}