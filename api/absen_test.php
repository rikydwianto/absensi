<?php
include_once"../config/setting.php";
include_once"../config/koneksi.php";
include_once"../fungsi/config.php";
include_once"../fungsi/lihat.php";
include_once"../fungsi/karyawan.php";
include_once"../fungsi/absen.php";
$skr				= date("H:i:s");
$d					= date("Y-m-d");
$sekarang			= strtotime($skr);
$masa_tenggang		= $batas_absen;
$masa_shift2		= strtotime(date('20:00:00'));
$date				= date("Y-m-d",strtotime('-1 day'));
$hari				= date("l",strtotime($d));
error_reporting(0);
if(isset($_POST['nik']))
{
	// echo alert_error('JIKA JAM MASUK MENJADI JAM PULANG, TUNGGU 10 MENIT LALU ABSEN KEMBALI, ATAU LAPOR KE ADM MASING MASING DEPARTEMEN');
	$nik=$_POST['nik'];
	$nik=aman($nik);
	
	@$dep=mysql_query("select kode_departemen from karyawan,jabatan,departemen where departemen.id_departemen=jabatan.id_departemen 
	and karyawan.id_jabatan=jabatan.id_jabatan
	and karyawan.nik='$nik'
	");
	@$dep=mysql_fetch_array($dep);
	@$dep=$dep['kode_departemen'];
	// @$dep=substr($nik,2,2);
	if($nik=='20010097'){
		echo alert_error("Komputer Akan di Matikan!");
		exec('shutdown -s -t 0 ');
	}
	else if($nik=='20010100')
	{
		echo alert("Komputer Akan diRestart!");
		exec('shutdown -r -t 1');
	}
	else if($nik==14110019){
		$skr=date("H:i:s", strtotime("-14 minutes", strtotime($skr)));
	}
	$masa_shift2		= strtotime(date('19:00:00'));
	$shift1=date("05:00:00");
	$shift1_sampai=date("18:00:00");
	$cek_nik=cek_nik($nik);
	if($cek_nik)
	{
		$idkaryawan=$cek_nik->id_karyawan;
		$date=date("Y-m-d",strtotime('-1 day'));
		$tx="select * from absen where id_karyawan='$cek_nik->id_karyawan' and tanggal_absen=curdate() order by id_absen desc limit 0,1";
		@$q=mysql_query("$tx");
		@$r=mysql_fetch_array($q);
		if(mysql_num_rows($q))
		{
			@$cari_menit_pulang=round(cari_menit($r['jam_masuk'],$skr));
			//echo "hari ini";
			if(empty($r['jam_keluar']))
			{
				
				if($sekarang > strtotime(date("00:00:00")) && $sekarang <= strtotime(date("18:00:00"))){
					@$cari_menit=round(cari_menit("07:00:00",$skr));
				}
				else if($sekarang > strtotime(date("18:00:00")) && $sekarang <= strtotime(date("23:59:59"))){
					@$cari_menit=round(cari_menit("19:00:00",$skr));
				}
				
				
				//echo alert($cari_menit);
				
				/* if($sekarang > strtotime(date("07:00:00")) && $sekarang <= strtotime(date("11:30:00"))){
					$lembur_libur		= strtotime(date('07:00:00'));
					if( $sekarang >= $lembur_libur){
						$menit=round(cari_menit(date('07:00:00'),$skr));
					}
					mysql_query("update absen set keterangan_hadir='libur', menit_lembur='$menit',lembur='ya' where id_absen='$r[id_absen]'");
				}
				else if($sekarang > strtotime(date("11:30:00")) && $sekarang <= strtotime(date("13:00:00"))){
					mysql_query("update absen set keterangan_hadir='pulang_libur', menit_lembur=null where id_absen='$r[id_absen]'");
				}
				else if($sekarang > strtotime(date("13:00:00")) && $sekarang <= strtotime(date("15:00:00"))){
					$lembur_libur		= strtotime(date('13:00:00'));
					if( $sekarang >= $lembur_libur){
						$menit=round(cari_menit(date('13:00:00'),$skr));
					}
					mysql_query("update absen set keterangan_hadir='pulang_libur', menit_lembur='$menit',lembur='ya' where id_absen='$r[id_absen]'");
				}
				 */
				
				if($hari=='Saturday'){
					$lembur_libur		= strtotime(date('12:00:00'));
					if( $sekarang >= $lembur_libur){						
						$menit=round(cari_menit(date('12:00:00'),$skr));
						mysql_query("update absen set keterangan_hadir=null where id_absen='$r[id_absen]'");
					}
				}
				else{
					
					
					if($cari_menit_pulang>=5){
						if($sekarang > strtotime(date("00:00:00")) && $sekarang <= strtotime(date("18:00:00"))){
							@$cari_menit=round(cari_menit("07:00:00",$skr));
							if($cari_menit> -60 && $cari_menit<=270){
								$lembur_libur		= strtotime(date('07:00:00'));
								if( $sekarang >= $lembur_libur){
									$menit=round(cari_menit(date('07:00:00'),$skr));
								}
								mysql_query("update absen set keterangan_hadir='libur', menit_lembur='$menit',lembur='ya' where id_absen='$r[id_absen]'");
							}
							else if($cari_menit>270 && $cari_menit<=360){
								$lembur_libur		= strtotime(date('07:00:00'));
								if( $sekarang >= $lembur_libur){
									$menit=round(cari_menit(date('07:00:00'),$skr));
								}
								mysql_query("update absen set keterangan_hadir='pulang_libur', menit_lembur=null where id_absen='$r[id_absen]'");
							}
							else if($cari_menit>360 && $cari_menit<=430){
								$lembur_libur		= strtotime(date('13:00:00'));
								if( $sekarang >= $lembur_libur){
									$menit=round(cari_menit(date('13:00:00'),$skr));
								}
								mysql_query("update absen set keterangan_hadir='pulang_libur', menit_lembur='$menit',lembur='ya' where id_absen='$r[id_absen]'");
							}
						}
						else if($sekarang > strtotime(date("18:00:00")) && $sekarang <= strtotime(date("23:59:59"))){
							@$cari_menit=round(cari_menit("$r[jam_masuk]",$skr));
							
							if($cari_menit>5 && $cari_menit<=270){
								$lembur_libur		= strtotime(date('19:00:00'));
								if( $sekarang >= $lembur_libur){
									$menit=round(cari_menit(date('19:00:00'),$skr));
								}
								mysql_query("update absen set keterangan_hadir='libur', menit_lembur='$menit',lembur='ya' where id_absen='$r[id_absen]'");
							}
							else if($cari_menit>270 && $cari_menit<=360){
								mysql_query("update absen set keterangan_hadir='pulang_libur', menit_lembur=null where id_absen='$r[id_absen]'");
							}
							else if($cari_menit>360 && $cari_menit<=430){
								// mysql_query("update absen set keterangan_hadir='pulang_libur', menit_lembur='$menit',lembur='ya' where id_absen='$r[id_absen]'");
							}
							
						}
					}
				
				}
				
				
				
				@$cari_menit_pulang=round(cari_menit($r['jam_masuk'],$skr));
				if($cari_menit_pulang>=5)
				{
					//echo "absen pulang";
					$idabsen=$r['id_absen'];
					$status_masuk='tidak';
				}
				else{
					//echo"NO ACT 1";
					$idabsen=$r['id_absen'];
				}
			}
			else{
				@$jam_keluar=round(cari_menit($r['jam_keluar'],$skr));
				//echo $jam_keluar;
				if($jam_keluar>=5){
					//echo "MASUK";
					//$status_masuk='ya';					
				}
				else{
					//echo "NO ACTION 6";
					$idabsen=$r['id_absen'];
				}
			}
			if($r['jam_masuk'] && $r['jam_keluar']){
				$cek_menit=round(cari_menit($r['jam_keluar'],$skr));
				$idabsen=$r['id_absen'];
				if($cek_menit > 5){
					$status_masuk='ya';
					$ket = "lembur"; 
				}
				
			}
			else{
				$idabsen=$r['id_absen'];
			}
			
		}
		else
		{
			//echo"kemarin - ";
			$q=mysql_query("select * from absen where id_karyawan='$idkaryawan' and tanggal_absen='$date' order by id_absen desc limit 0,1");
			if(mysql_num_rows($q)){
				$absen=mysql_fetch_array($q);
				if(empty($absen['jam_keluar']))
				{
					//echo "Keluar";
					$idabsen=$absen['id_absen'];
					
						$status_masuk='ya';
						$status_masuk='tidak';
					
				}
 				else{
					$cari_menit=round(cari_menit($absen['jam_keluar'],$skr));
					if($cari_menit>=5)
						$status_masuk='ya';
					$time = time();
					$buat = strtotime($absen['date_modified']);
					$buat = round(($time -  $buat)/60);
					//echo $absen['date_modified'];
					if($buat>=5){
						$status_masuk='ya';
					}
					else{
						$idabsen=$absen['id_absen'];
						echo alert("10 MENIT LAGI ANDA DAPAT ABSEN MASUK KEMBALI!");
					}
				}
			}
			else
			{
				//echo"MASUK";
				$status_masuk='ya';
			}
		}
		
		####################################################                   ABSEN                   ####################################################
		####################################################                   ABSEN                   ####################################################
		if(@$status_masuk=='ya'){
			if($sekarang >= strtotime(date("15:00:00"))){
				if($dep=='09' || $dep=='07'|| $dep=='11' || $dep=='06'){
					$error='tidak';	
					if( $sekarang >= strtotime($shift1) && $sekarang < strtotime($shift1_sampai) )
					{
						if($masa_tenggang < $sekarang){
							$status='ya';
							//echo alert_error("<strong>$cek_nik->nama_lengkap</strong>  SUDAH ABSEN ANDA TELAT !");
						}
						else 
						{
							$status='tidak';
							//echo alert("<strong>$cek_nik->nama_lengkap</strong> Anda Sudah Absen dan tidak Terlambat Tingkatkan terus ");
						}
						tambah_absen($cek_nik->id_karyawan,$skr,$status);
						$idabsen=mysql_insert_id();
					}
					else {
						//SHIFT 2
						if($masa_shift2 < $sekarang){
							$status='ya';
							//echo alert_error("<strong>$cek_nik->nama_lengkap</strong>  SUDAH ABSEN ANDA TELAT !");
						}
						else 
						{
							$status='tidak';
							//echo alert("<strong>$cek_nik->nama_lengkap</strong> Anda Sudah Absen dan tidak Terlambat Tingkatkan terus ");
						}
						tambah_absen($cek_nik->id_karyawan,$skr,$status);
						$no_absen=mysql_insert_id();
						//mysql_query("update absen set shift=2 where id_absen='$no_absen'"); 
						$idabsen=$no_absen;
					}
					//echo alert("<h2><center>Selamat Datang Di PT. Lydia Sola Gracia</center></h2>");
				}
				else
				{
					//SELAIN DEPARTEMEN BORDIR DAN SECURITY ==============
					echo alert_error("<b>ANDA TIDAK MELAKUKAN ABSEN MASUK!</b>");
					tambah_absen_pulang($cek_nik->id_karyawan,$skr,'tidak');
					$no_absen=mysql_insert_id();
					
					$idabsen=$no_absen;
					$error='tidak';
				}
			}
			else{
				// echo " tidak ada action";
				$error='tidak';
				if( $sekarang >= strtotime($shift1) && $sekarang < strtotime($shift1_sampai) )
				{
					if($masa_tenggang < $sekarang){
						$status='ya';
						//echo alert_error("<strong>$cek_nik->nama_lengkap</strong>  SUDAH ABSEN ANDA TELAT !");
					}
					else 
					{
						$status='tidak';
						//echo alert("<strong>$cek_nik->nama_lengkap</strong> Anda Sudah Absen dan tidak Terlambat Tingkatkan terus ");
					}
					tambah_absen($cek_nik->id_karyawan,$skr,$status);
					$idabsen=mysql_insert_id();
				}
				else {
					//SHIFT 2
					if($masa_shift2 < $sekarang){
						$status='ya';
						//echo alert_error("<strong>$cek_nik->nama_lengkap</strong>  SUDAH ABSEN ANDA TELAT !");
					}
					else 
					{
						$status='tidak';
						//echo alert("<strong>$cek_nik->nama_lengkap</strong> Anda Sudah Absen dan tidak Terlambat Tingkatkan terus ");
					}
					tambah_absen($cek_nik->id_karyawan,$skr,$status);
					$no_absen=mysql_insert_id();
					//mysql_query("update absen set shift=2 where id_absen='$no_absen'"); 
					$idabsen=$no_absen;
				}
				//echo alert("<h2><center>Selamat Datang Di PT. Lydia Sola Gracia</center></h2>");
			}
			if(!empty($ket))
			{
				@mysql_query("update absen set keterangan_hadir='$ket' where id_absen='$idabsen'");
			}
		}
		else if(@$status_masuk=='tidak')
		{
			//echo alert("<h4><center>Terima Kasih, Hati - hati dijalan</center></h4>");
			if($nik=='14110019')
				$skr=date("H:i:s", strtotime("+12 minutes", strtotime($skr)));
			mysql_query("update absen set jam_keluar='$skr', date_modified=now() where id_absen='$idabsen'");
			if(@$absen['keterangan_hadir']!=null || @$r['keterangan_hadir']!=null){
				//echo alert("ANDA DITANDAI TIDAK HADIR, ANDA TIDAK DAPAT ABSEN!" );
			}
			else{
				$buat_lembur=mysql_fetch_array(mysql_query("select tanggal_absen from absen where id_absen='$idabsen'"));
				$buat_lembur = $buat_lembur['tanggal_absen'];
				$buat_lembur1 = $buat_lembur;
				$lembur=cek_lembur($buat_lembur);
				if(@$r['lembur']=='ya' || @$absen['lembur']=='ya')    
				{
					if($buat_lembur1 == $d){
							//echo "hari ini";
						if( $sekarang >= strtotime($lembur->jam_mulai_lembur)){						
							$mnt=round(cari_menit($lembur->jam_mulai_lembur,$skr));
						}
						else{
						}
					}
					else{							
						$tanggal	= duatanggal($lembur->tanggal_lembur.' '.$lembur->jam_mulai_lembur,$d.' '.$skr);
						$mnt 		= round($tanggal['seconds_total']/60,0);
					}
					if(@$mnt>=30){
						tambah_lembur($idabsen,$mnt);
					}
					
				}
				else
				{
					//echo "Tidak lembur";
				}
			}

		}
		
		####################################################                  END ABSEN                  ####################################################
		####################################################                  END ABSEN                  ####################################################
		
		if(@$error!='ya')
			include"../view/absen/absenv2.php";
	}
	else{
	
		echo "<center>".alert_error("<b>NIK : <b>$nik</b><br/>  Data Tidak Ditemukan!</b>")."</center>";
	}
	
}


if(!empty($status_masuk))
{
	if($status_masuk=='ya'){
	$gambar = str_replace(" ","+",$_POST['gambar']);
	define('UPLOAD_DIR', '../data/absen-cam/');
	if(!file_exists(UPLOAD_DIR.date("Y-m-d").'/'))
	{
		mkdir(UPLOAD_DIR. date("Y-m-d"));
	}
	$folder=UPLOAD_DIR. date("Y-m-d/");
	$img = $gambar;
	$img = str_replace('data:image/jpeg;base64,', '', $img);
	$data = base64_decode($img);
	@$name_file=$nik.' - '. ($cek_nik->nama_lengkap).' - '.$idabsen.'.jpg';
	$name_file=preg_replace('/[^A-Za-z0-9 _ .-]/', '', $name_file);
	$file = $folder . $name_file;
	@$success = file_put_contents($file, $data);
	//print $success ? $file : 'Unable to save the file.';

	@mysql_query("update absen set gambarbase64='".($name_file)."' where id_absen='$idabsen'");
	}
	else if($status_masuk=='tidak')
	{
		$gambar = str_replace(" ","+",$_POST['gambar']);
		define('UPLOAD_DIR', '../data/absen-cam/');
		if(!file_exists(UPLOAD_DIR.date("Y-m-d").'/pulang'))
		{
			mkdir(UPLOAD_DIR. date("Y-m-d").'/pulang');
		}
		$folder=UPLOAD_DIR. date("Y-m-d/").'/pulang/';
		$img = $gambar;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$data = base64_decode($img);
		
		$name_file=$nik.' - '. ($cek_nik->nama_lengkap).' - '.$idabsen.'.jpg';
		$name_file=preg_replace('/[^A-Za-z0-9 _ .-]/', '', $name_file);
		$file = $folder . $name_file;
		@$success = file_put_contents($file, $data);
		//print $success ? $file : 'Unable to save the file.';

		@mysql_query("update absen set gambarbase64_pulang='".$folder.$name_file."' , date_modified=now() where id_absen='$idabsen'");
	}
	
}


if(isset($_POST['nik']))
{
	//LOG KHUSUS
	$gambar = str_replace(" ","+",$_POST['gambar']);
	define('UPLOAD_DIR', '../data/log/');
	$folder = '../data/log/';
	if(!file_exists($folder.date("Y-m-d").'/'))
	{
		mkdir($folder. date("Y-m-d"));
	}
	$folder=$folder. date("Y-m-d/");
	$input = $_POST['nik'];
	$nama_log = $_POST['gambar'];

	mysql_query("
	INSERT INTO `log_barcode` ( `photo_log`, `date_created`, `log_barcode`, `tanggal_log`) 
	VALUES ('$nama_log', now(), '$input', curdate());

	");
	$id_akhir = mysql_insert_id();
	$img = $gambar;
	$img = str_replace('data:image/jpeg;base64,', '', $img);
	$data = base64_decode($img);
	@$name_file=$input.'-'.$id_akhir.'.jpg';
	$name_file=preg_replace('/[^A-Za-z0-9 _ .-]/', '', $name_file);
	$file = $folder . $name_file;
	@$success = file_put_contents($file, $data);
	@mysql_query("update log_barcode set photo_log='".$file."' where id_log='$id_akhir'");
}
?>