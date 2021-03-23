<?php
function tampil_absen($id_jabatan=null,$id_dep=null,$tgl){
	if($id_jabatan==null)
		$jabatan=" and karyawan.id_jabatan ";
	else
		$jabatan=" and karyawan.id_jabatan='$id_jabatan'";
	if($id_dep==null)
		$departemen="";
	else
		$departemen="and departemen.id_departemen='$id_dep'";
	$q=mysql_query("SELECT absen.*, karyawan.id_karyawan,karyawan.nik,karyawan.nama_lengkap,karyawan.id_jabatan FROM
	karyawan,absen,jabatan,departemen WHERE departemen.id_departemen=jabatan.id_departemen and karyawan.id_jabatan=jabatan.id_jabatan and	
	karyawan.`id_karyawan`=absen.`id_karyawan` AND absen.tanggal_absen='$tgl' $departemen  $jabatan order by absen.jam_masuk asc ");
	return $q;
}
function hitung_absen($tgl){
	$q=mysql_query("select count(id_karyawan) as hitung from absen where tanggal_absen='$tgl'");
	$q=mysql_fetch_object($q);
	return $q->hitung;

}
function hitung_izin($tgl){
	$q=mysql_query("select count(id_karyawan) as hitung from absen where tanggal_absen='$tgl' and keterangan_hadir='izin'");
	$q=mysql_fetch_object($q);
	return $q->hitung;

}
function hitung_skd($tgl){
	$q=mysql_query("select count(id_karyawan) as hitung from absen where tanggal_absen='$tgl' and keterangan_hadir='skd'");
	$q=mysql_fetch_object($q);
	return $q->hitung;

}
function hitung_telat($tgl){
	$q=mysql_query("select count(id_karyawan) as hitung from absen where tanggal_absen='$tgl' and telat='ya'");
	$q=mysql_fetch_object($q);
	return $q->hitung;

}

function hitung_keluar($tgl){
	$q=mysql_query("select count(id_karyawan) as hitung from absen where tanggal_absen='$tgl' and jam_keluar!='' ");
	$q=mysql_fetch_object($q);
	return $q->hitung;

}
function hitung_alfa($tgl){
	$q=mysql_query("select count(id_karyawan) as hitung from absen where tanggal_absen='$tgl' and keterangan_hadir='alfa' ");
	$q=mysql_fetch_object($q);
	return $q->hitung;

}

function hitung_sakit($tgl){
	$q=mysql_query("select count(id_karyawan) as hitung from absen where tanggal_absen='$tgl' and keterangan_hadir='skd' ");
	$q=mysql_fetch_object($q);
	return $q->hitung;

}

function beri_lembur($id)
{
	$q=mysql_query("update absen set lembur='ya' where id_absen='$id'");
}
function hitung_cek_lembur()
{
	$q=mysql_query("select * from lembur_setting where tanggal_lembur=curdate() ") or die(alert_error(mysql_error()));
	return mysql_num_rows($q);
}

function tidak_hadir($id_jabatan,$tgl,$query=null){
		if($id_jabatan==null)
			$jabatan=" ";
		else
			$jabatan=" and departemen.id_departemen='$id_jabatan'";

	$q=mysql_query("select * from karyawan,departemen,jabatan where 
	karyawan.id_jabatan=jabatan.id_jabatan and departemen.id_departemen=jabatan.id_departemen and
	karyawan.id_karyawan not in (select id_karyawan from absen where tanggal_absen='$tgl') and (status_karyawan!=5) $jabatan $query ");
	return $q;
}


function absen_tgl($id,$tgl,$bln,$thn)
{
	// $t=mysql_query("SELECT * FROM total_absen WHERE id_karyawan='$id' and tanggal_absen='$thn-$bln-$tgl' ") or die(alert_error(mysql_error()));
	$data = strtotime(date("Y-m-d"));
	$date = date("$thn-$bln-$tgl");
	if($data == strtotime($date))
		$minus = "";
	else 
		$minus = "and (jam_keluar is not null and jam_masuk is not null) ";
	$t=mysql_query("SELECT count(id_absen) as total, keterangan_hadir as hadir FROM absen WHERE id_karyawan='$id' and tanggal_absen='$thn-$bln-$tgl' $minus ") or die(alert_error(mysql_error()));
	
	$q=mysql_fetch_array($t);
	if(mysql_num_rows($t)>0)
	{
		if(@$q['hadir']=='')
			$status=$q['total'];
		else if(@$q['hadir']=='sakit')
			$status="S";
		else if(@$q['hadir']=='alfa')
			$status=-1;
		else if(@$q['hadir']=='izin')
			$status="I";
		else if(@$q['hadir']=='skd')
			$status="skd";
		else if(@$q['hadir']=='spd')
			$status="spd";
		else if(@$q['hadir']=='pulang' || @$q['hadir']=='pulang_libur' || @$q['hadir']=='masuk_setengah_hari')
			$status="0.5";
		else if(@$q['hadir']=='libur')
			$status="lbr";
		else if(@$q['hadir']=='out')
			$status="out";
		else if(@$q['hadir']=='off')
			$status="off";
		else
			$status=0;

	}
	else
		$status=0;
	
	return $status;
	
	
}


function hitung_ket_karyawan($id,$ket,$bln,$thn){
	$minus = "and (jam_keluar is not null and jam_masuk is not null) ";
	$q=mysql_query("SELECT COUNT(id_karyawan) AS hitung FROM absen WHERE keterangan_hadir='$ket' and tanggal_absen like '$thn-$bln-%' AND id_karyawan='$id' $minus") or die(alert_error(mysql_error()));
	$r=mysql_fetch_object($q);
	return $r->hitung;
}
function hitung_ket_karyawan_range($id,$ket,$b,$t){
	$q=mysql_query("SELECT COUNT(id_karyawan) AS hitung FROM absen WHERE keterangan_hadir='$ket' and tanggal_absen between '$b' AND '$t' and id_karyawan='$id'") or die(alert_error(mysql_error()));
	$r=mysql_fetch_object($q);
	return $r->hitung;
}
function hitung_jml_karyawan($id,$bln,$thn){
	$minus = "and (jam_keluar is not null and jam_masuk is not null) ";
	//$q=mysql_query("call total_absen($id,$thn,$bln)") or die(alert_error(mysql_error()));
	//$q=mysql_query("SELECT * FROM total_absen WHERE tanggal_absen like '$thn-$bln-%' AND id_karyawan='$id' ") or die(alert_error(mysql_error()));
	$q=mysql_query("select id_karyawan   AS id_karyawan,  tanggal_absen AS tanggal_absen,  count(id_karyawan) AS hitung from absen  WHERE tanggal_absen like '$thn-$bln-%' AND id_karyawan='$id' $minus group by id_karyawan ") or die(alert_error(mysql_error()));
	$r=mysql_fetch_array($q);
	return $r['hitung'];
}


function hitung_jml_karyawan_range($id,$b,$t){
	$q=mysql_query("select id_karyawan   AS id_karyawan,  tanggal_absen AS tanggal_absen,  count(id_karyawan) AS hitung from absen  WHERE (tanggal_absen between '$b' and '$t') AND id_karyawan='$id' group by id_karyawan ") or die(alert_error(mysql_error()));
	$r=mysql_fetch_array($q);
	return $r['hitung'];
}


function edit_absen($id)
{
	$q=mysql_query("select * from absen where id_absen='$id'");
	$r=mysql_fetch_object($q);
	return $r;
}

function total_lembur($id,$bln,$th){
	$absen=mysql_query(" SELECT SUM(menit_lembur) AS total FROM absen WHERE id_karyawan='$id' AND tanggal_absen LIKE '$th-$bln-%'");
	$absen=mysql_fetch_object($absen);
	$lembur=$absen->total;
	return round($lembur/60,2);
}


function total_lembur_range($id,$b,$t){
	$absen=mysql_query(" SELECT SUM(menit_lembur) AS total FROM absen WHERE id_karyawan='$id' AND tanggal_absen between '$b' and '$t'");
	$absen=mysql_fetch_object($absen);
	$lembur=$absen->total;
	return round($lembur/60,1);
}

function hitung_biaya_skd($id,$b,$t){
	$absen=mysql_query(" SELECT SUM(total_berobat) AS total FROM sakit WHERE id_karyawan='$id' AND tanggal_sakit between '$b' and '$t'");
	$absen=mysql_fetch_object($absen);
	$sakit=$absen->total;
	return $sakit;
}


function tidak_absen($tgl){
	$q=mysql_query("select count(id_karyawan) as hitung from karyawan where id_karyawan not in(select id_karyawan from absen where tanggal_absen='$tgl') and status_karyawan!=5 order by id_jabatan asc");
	$r=mysql_fetch_object($q);
	return $r->hitung;
}


function hitung_telat_karyawan($id,$bln,$th){
	$q=mysql_query("select count(id_karyawan) as hitung from absen where tanggal_absen LIKE '$th-$bln-%' and telat='ya' and id_karyawan='$id'");
	$q=mysql_fetch_object($q);
	return $q->hitung;

}


function hitung_libur_nasional($bln,$th){
	$q=mysql_query("select count(id_libur_nasional) as hitung from libur_nasional where tanggal_libur_nasional LIKE '$th-$bln-%' ");
	$q=mysql_fetch_object($q);
	return $q->hitung;

}

function hitung_libur_nasional_detail($day,$bln,$th){
	$q=mysql_query("select id_libur_nasional from libur_nasional where tanggal_libur_nasional ='$th-$bln-$day' ") or die(alert_error("Error : ".mysql_error()));
	if(mysql_num_rows($q))
		return true;
	else
		return false;
}
