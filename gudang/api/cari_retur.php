<?php include_once"../config/setting.php"; ?>
<?php include_once"../config/koneksi.php"; ?>
<?php include_once"../fungsi/config.php"; ?>
<?php
if(isset($_POST['nik']))
{
	$nik=aman(post("nik"));
	//echo $nik;
	$id_input=$_SESSION['ID'];
	$nik=mysql_query("select * from karyawan join jabatan on jabatan.id_jabatan=karyawan.id_jabatan join departemen on departemen.id_departemen=jabatan.id_departemen where nik='$nik'") or die(alert_error("Error : ".mysql_error()));
	$nik=mysql_fetch_array($nik);
	if(!empty($nik['id_karyawan'])){
		$q=mysql_query("insert into ambilan(id_karyawan,tanggal_ambilan,keterangan_ambilan,status_ambilan,date_created) values('$nik[id_karyawan]',curdate(),'$ket','belum selesai',now())");
		$_SESSION['id_input']=mysql_insert_id();
		$qq=mysql_query("
		insert into loading_aksesoris(id_karyawan,id_karyawan_2,kode_departemen,keterangan_loading_aksesoris,tanggal_loading_aksesoris,status_loading)
		values('$id_input','$nik[id_karyawan]','$nik[kode_departemen]','',curdate(),'belum selesai')
		");
		$_SESSION['id_input_bahan']=mysql_insert_id();
		if($q ){
			
			$_SESSION['id_input_user']=$nik['id_karyawan'];
			
			$idinput = $_SESSION['id_input'];
			$gambar = str_replace(" ","+",post("gambar"));
			define('UPLOAD_DIR', '../data/foto-ambilan/');
			if(!file_exists(UPLOAD_DIR.date("Y-m-d")))
			{
				mkdir(UPLOAD_DIR. date("Y-m-d"));
			}
			$folder=UPLOAD_DIR. date("Y-m-d/");
			$img = $gambar;
			$img = str_replace('data:image/jpeg;base64,', '', $img);
			$data = base64_decode($img);
			
			$name_file=$nik['nik'].' - '.$nik['nama_lengkap'].' - '.$idinput.'.jpg';
			$name_file=preg_replace('/[^A-Za-z0-9 _ .-]/', '', $name_file);
			$file = $folder . $name_file;
			@$success = file_put_contents($file, $data);
			//print $success ? $file : 'Unable to save the file.';
			mysql_query("update ambilan set photo_ambilan='$name_file' where id_ambilan_sp='$idinput'");
			mysql_query("update loading_aksesoris set bukti_loading_aksesoris='$name_file' where id_loading_aksesoris='$_SESSION[id_input_bahan]'");
		}
		else{
			echo alert_error("Gagal, Koneksi/database error : ". mysql_error());
		}
	}
	else
	{
		echo "tidak";
	}
}
?>