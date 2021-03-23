<?php
include"config/setting.php";
include"config/koneksi.php";
include"fungsi/config.php";
include"fungsi/lihat.php";

cek_login();
$id =  $_POST['id_karyawan'];
$grade =  $_POST['grade'];
$revisi =  $_POST['revisi'];
$revisi =  $_POST['revisi'];
@$bulan=($_GET['bulan'] == "" ) ? date("m") : $_GET['bulan'];
$b = $bulan;
$bulan=sprintf('%02s', $bulan);
@$tahun=($_GET['tahun'] == "" ) ? date("Y") : $_GET['tahun'];
$url =  urldecode($_POST['url']);
for($i=0;$i<count($id);$i++){
	$cek_grade = mysql_query("select * from grade where id_karyawan='$id[$i]' and bulan='$bulan' and tahun='$tahun'");
	if(!mysql_num_rows($cek_grade)){
		mysql_query("insert into grade(id_karyawan,bulan,tahun,grade,revisi_grade) values('$id[$i]','$bulan','$tahun','$grade[$i]','$revisi[$i]')");
		echo "inpi";
	}
	else{
		echo "upd";
		mysql_query("update grade set grade='$grade[$i]',revisi_grade='$revisi[$i]' where id_karyawan='$id[$i]' and bulan='$bulan' and tahun='$tahun'");
		echo mysql_error();
	}
}
 direct($url);
?>