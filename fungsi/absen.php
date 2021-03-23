<?php
function cek_absen_karyawan($id){
	$q=mysql_query("select * from absen where id_karyawan='$id' and tanggal_absen=curdate() ");
	$r = mysql_num_rows($q);
	return $r;
}
function detail_absen($id)
{
	$q=mysql_query("select * from absen where id_karyawan='$id' and tanggal_absen=curdate() ");
	return mysql_fetch_object($q);
}

function tambah_absen($id,$jam_masuk,$status)
{
	$q=mysql_query("insert into absen (id_karyawan,tanggal_absen,jam_masuk,telat,lembur,date_created,date_modified,keterangan_hadir)
		values('$id',curdate(),'$jam_masuk','$status','tidak',now(),now(),null)
	") or die(alert(mysql_error()));
	return $q;
}
function tambah_absen_pulang($id,$jam_masuk,$status)
{
	$q=mysql_query("insert into absen (id_karyawan,tanggal_absen,jam_masuk,telat,lembur,date_created,keterangan)
		values('$id',curdate(),'$jam_masuk','$status','tidak',now(),'Tidak melakukan absen jam masuk')
	") or die(alert(mysql_error()));
	return $q;
}
function absen_pulang($id,$waktu)
{
	$q=mysql_query("update absen set jam_keluar='$waktu',date_modified=now() where id_absen='$id' ") or die(alert_error(mysql_error()));
	return $q;
}
function cek_lembur($tgl)
{
	$q=mysql_query("select * from lembur_setting where tanggal_lembur='$tgl' ") or die(alert_error(mysql_error()));
	return mysql_fetch_object($q);
}
function tambah_lembur($id,$menit){
	$q=mysql_query("update absen set lembur='ya', menit_lembur='$menit',date_modified=now() where id_absen='$id' ") or die(alert_error(mysql_error()));
	return $q;
}

function input_lembur($tgl,$mulai,$selesai=null,$ket){
	$q=mysql_query("insert into lembur_setting(tanggal_lembur,jam_mulai_lembur,jam_selesai_lembur,keterangan,date_created)
	values('$tgl','$mulai','$selesai','$ket',now())
	");
	return $q;
}

function data_lembur($bulan,$tahun)
{
	$q=mysql_query("SELECT * FROM lembur_setting WHERE tanggal_lembur LIKE '$tahun-$bulan-%'");

	return $q;
}

function lembur_hari($tgl)
{
	$q=mysql_query("select * from lembur_setting where tanggal_lembur='$tgl' order by tanggal_lembur asc");
	return $q;
}


function hapus_lembur($id)
{
	$q=mysql_query("delete from lembur_setting where id_lembur_setting='$id'");
	return $q;
}
function edit_lembur($id){
	$q=mysql_query("select * from lembur_setting where id_lembur_setting='$id'");
	$r=mysql_fetch_object($q);
	return $r;
}
function update_lembur($id,$tgl,$jam,$ket)
{
	$q=mysql_query("update lembur_setting set tanggal_lembur='$tgl',jam_mulai_lembur='$jam',keterangan='$ket',date_modified=now() where id_lembur_setting='$id'
	
	");
	return $q;
}
