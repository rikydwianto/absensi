<?php 
if(!isset($_GET['mn']))
{
	include"view/template/awal.php";
}
else
{
	$mn=$_GET['mn'];
	if(empty($mn))
		include"view/error/404.php";
	else{
		switch($mn){
			case"departemen":
				include"view/departemen/tampil-departemen.php";
			break;
			case"tambah-departemen":
				include"view/departemen/tambah-departemen.php";
			break;
			case"hapus-departemen":
				include"view/departemen/hapus-departemen.php";
			break;
			case"edit-departemen":
				include"view/departemen/edit-departemen.php";
			break;
			
			case"jabatan":
				include"view/jabatan/jabatan.php";
			break;
			
			case"karyawan":
				include"view/karyawan/karyawan.php";
			break;
			
			case"karyawan_aktif":
				include"view/karyawan/karyawan_aktif.php";
			break;
			case"karyawan_semua":
				include"view/karyawan/semua_karyawan.php";
			break;
			
			case"detail_karyawan":
				include"view/karyawan/detail_karyawan.php";
			break;
			
			case"lembur":
				include"view/absen/lembur.php";
			break;
			
			case"absen":
				include"view/absen/absen.php";
			break;
			
			
			case"data-tidak-hadir":
				include"view/absen/data-tidak-hadir.php";
			break;
			
			case"rekap_absen":
				include"view/absen/rekap.php";
			break;
			
			case"rekap":
				include"view/absen/rekap_total.php";
			break;
			
			case"rekap-anak-baru":
				include"view/absen/rekap_anak_baru.php";
			break;
			
			case"rekap-total-range":
				include"view/absen/rekap_total_range.php";
			break;
			
			case"rekap-total-payroll":
				include"view/absen/rekap_total_payroll.php";
			break;
			
			case"keluarga":
				include"view/keluarga/keluarga.php";
			break;
			
			case"pendidikan":
				include"view/pendidikan/pendidikan.php";
			break;
			
			case"resign":
				include"view/resign/resign.php";
			break;
			
			case"daftar_resign":
				include"view/resign/daftar_resign.php";
			break;
			
			case"log":
				include"view/log/log.php";
			break;
			
			case"user":
				include"view/user/user.php";
			break;
			
			case"daftar_pendidikan":
				include"view/pendidikan/daftar_pendidikan.php";
			break;
			
			case"detail_sekolah":
				include"view/pendidikan/detail_sekolah.php";
			break;
			
			case"absen_manual":
				include"view/absen/absen-manual.php";
			break;
			
			case"berkas":
				include"view/berkas/berkas.php";
			break;
			
			case"lembur-hari":
				include"view/lembur/lembur-hari.php";
			break;
			
			case"report-per-karyawan":
				include"view/absen/report-karyawan.php";
			break;
			
			case"libur-nasional":
				include"view/libur_nasional/libur-nasional.php";
			break;
			
			case"administrasi":
				include"view/administrasi/administrasi.php";
			break;
			
			case"grafik":
				include"view/grafik/grafik.php";
			break;
			
			case"absen_karyawan":
				include"view/absen/absen_karyawan.php";
			break;
			
			case"rekap_satpam":
				include"view/absen/rekap_satpam.php";
			break;
			
			case"rekap-grade":
				include"view/absen/rekap_grade.php";
			break;
			
			case"history":
				include"view/absen/history_absen.php";
			break;
			
			case"sp":
				include"view/sp/sp.php";
			break;
			
			
			default:
				include"view/error/404.php";
			break;
		}
	}
}
?>