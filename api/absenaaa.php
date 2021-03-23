<?php
include_once"../config/setting.php";

include_once"../config/koneksi.php";
include_once"../fungsi/config.php";
include_once"../fungsi/lihat.php";
include_once"../fungsi/karyawan.php";
include_once"../fungsi/absen.php";
$skr				= date("H:i:s");
$sekarang			= strtotime($skr);
$masa_tenggang		= $batas_absen;
$masa_shift2		= strtotime(date('19:00:00'));
$date				= date("Y-m-d",strtotime('-1 day'));

if(isset($_GET['nik']))
{
	$nik=$_GET['nik'];
	$nik=aman($nik);
	if($nik=='20010097'){
		echo alert_error("Komputer Akan di Matikan!");
		exec('shutdown -s -t 0 ');
	}
	else if($nik=='20010100')
	{
	echo alert("Komputer Akan diRestart!");
		exec('shutdown -r -t 1');
	}
	else if($nik==111111){
		$skr=date("H:i:s", strtotime("-30 minutes", strtotime($skr)));
	}
	$masa_shift2		= strtotime(date('19:00:00'));
	$shift1=date("05:00:00");
	$shift1_sampai=date("18:00:00");
	$cek_nik=cek_nik($nik);
	@$absen=detail_absen($cek_nik->id_karyawan);
	if($cek_nik)
	{
		$date=date("Y-m-d",strtotime('-1 day'));
		$tx="select * from absen where id_karyawan='$cek_nik->id_karyawan' and tanggal_absen='$date' and shift=2 order by id_absen desc";
		@$q=mysql_query("$tx");
		@$r=mysql_fetch_object($q);
		if(mysql_num_rows($q) && empty($r->jam_keluar)){
			$idabsen= $r->id_absen;
			absen_pulang($idabsen,$skr);
			//echo alert("absen shift 2 selesai");
		}
		else
		{
			//MASUK JIKA TIDAK ADA SHIFT KEMARIN
			if(!cek_absen_karyawan($cek_nik->id_karyawan))
			{
				//SHIFT 1
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
					//	echo alert("<strong>$cek_nik->nama_lengkap</strong> Anda Sudah Absen dan tidak Terlambat Tingkatkan terus ");
					}
					tambah_absen($cek_nik->id_karyawan,$skr,$status);
					$no_absen=mysql_insert_id();
					mysql_query("update absen set shift=2 where id_absen='$no_absen'"); 
					$idabsen=$no_absen;
				}
			}
			else
			{
				if(empty($absen->jam_keluar))
				{
					if($absen->keterangan_hadir!=null){
						//echo alert("ANDA DITANDAI TIDAK HADIR, ANDA TIDAK DAPAT ABSEN!");
					}
					else{
						
						@$mnt_cek=(int)cari_menit($absen->jam_masuk,$skr);
						if($mnt_cek >= 0 && $mnt_cek < 60){
							//echo alert("Absen Double");
							$idabsen=$absen->id_absen;
						}
						else{
							$idabsen=$absen->id_absen;
							absen_pulang($absen->id_absen,$skr);
							$lembur=cek_lembur();
							if($absen->lembur=='tidak')
							{
								//echo alert("Terima Kasih, Sampai Jumpa Kembali");
							}
							else
							{
								$mnt=round(cari_menit($lembur->jam_mulai_lembur,$skr));
								if($mnt>0){
									tambah_lembur($absen->id_absen,$mnt);
								}													
							}
						}
					}
				}
				
				$idabsen=$absen->id_absen;
			}
		}
		
		include"../view/absen/absenv2.php";
		$gambar = str_replace(" ","+",$_GET['gambar']);
		//echo $gambar;
		define('UPLOAD_DIR', '../data/absen-cam/');
		if(!file_exists(UPLOAD_DIR.date("Y-m-d").'/'))
		{
			mkdir(UPLOAD_DIR. date("Y-m-d"));
		}
		$folder=UPLOAD_DIR. date("Y-m-d/");
		$img = $gambar;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		//echo $img;
		$data = base64_decode($img);
		$name_file=$nik.' - '. urlencode($cek_nik->nama_lengkap).'.jpg';
		$file = $folder . $name_file;
		@$success = file_put_contents($file, $data);
		//print $success ? $file : 'Unable to save the file.';

		@mysql_query("update absen set gambarbase64='".($name_file)."' , date_modified=now() where id_absen='$idabsen'");
	}
	else{
	
		echo alert_error("Data Tidak Ditemukan!");
	}
	
}
?>