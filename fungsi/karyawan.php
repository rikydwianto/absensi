<?php
function tampil_karyawan($cari,$start=null,$limit=null){
	$batas=10;
	$kata=array();
	
	$pecah=explode(" ",$cari);
	for($i=0;$i < count($pecah); $i++)
	{
		$kata[$i] ="karyawan.nama_lengkap like '%$pecah[$i]%' or karyawan.nama_panggilan like '%$pecah[$i]%' ";
	}
	//$c="where ".implode(" or ",$kata)." or karyawan.nik like '%$cari%' or karyawan.no_ktp like '%$cari%' or karyawan.nama_lengkap like '%$cari%'";
	$c="where karyawan.nik like '%$cari%' or karyawan.no_ktp like '%$cari%' or karyawan.nama_lengkap like '%$cari%' or karyawan.nama_panggilan like '%$cari%' or karyawan.alamat_rumah like '%$cari%' or karyawan.tlp_1 like '%$cari%' or karyawan.tlp_2 like '%$cari%' or karyawan.email like '%$cari%' ";
	

	$txt="select * from karyawan  $c  order by id_karyawan desc limit $start , $limit";
	$q=mysql_query($txt);
	return $q;
}
function hitung_cari_karyawan($cari){
	$batas=10;
	$kata=array();
	
	// $pecah=explode(" ",$cari);
	// for($i=0;$i < count($pecah); $i++)
	// {
		// $kata[$i] ="karyawan.nama_lengkap like '%$pecah[$i]%'";
	// }
	$c="where karyawan.nama_lengkap like '%$cari%' ";
	

	$txt="select count(id_karyawan) as hitung from karyawan  $c  order by id_karyawan ";
	$q=mysql_query($txt) or die('Error : '.mysql_error());
	$r=mysql_fetch_object($q);
	return $r->hitung;
}

function hitung_karyawan()
{
	$q=mysql_query("select count(id_karyawan) as hitung from karyawan where status_karyawan!='5'") or die('Error : '. mysql_error());
	$r=mysql_fetch_object($q);
	return $r->hitung;
	
}

function detail_karyawan($id)
{
	$txt="select * from karyawan  where id_karyawan='$id'";
	$q=mysql_query($txt);
	return mysql_fetch_object($q);
}


//HAPUS KARYAWAN + PHOTO NYA

function hapus_karyawan($id){
	$det=detail_karyawan($id);
	$berkas="../data/foto/";	// (../) KARENA PEMANGGILAN DARI API AJAX.
	$foto=$det->nik.'.jpg';
	@unlink($berkas.$foto);
	@unlink($berkas.'thumb/'.$foto);
	$q=null;
	$q=mysql_query("delete from karyawan where id_karyawan='$id'");
	return $q;
}
function cek_nik($id)
{
	$txt="select nik,id_karyawan,nama_lengkap from karyawan  where nik='$id'";
	$q=mysql_query($txt);
	return mysql_fetch_object($q);
}
function buat_nik($tgl,$dep,$jab)
{
	$tgl = date($tgl);
	$tgl=explode("/",$tgl);
	$tahun=substr($tgl[2],2,2);
	
	$q=mysql_query("select kode_departemen from departemen where id_departemen='$dep'");
	$q=mysql_fetch_object($q);
	$kode_dep=$q->kode_departemen;
	$prefix= $tahun.$kode_dep;
	$t="select max(nik) as akhir from karyawan where left(nik,4) = '$prefix'";
	$r=mysql_query($t) or die(alert_error(mysql_error()));
	$r=mysql_fetch_object($r);
	$akhir= $r->akhir;

	$urut=substr($akhir,4,4);
	$urut= sprintf("%04s",$urut + 1);		
	return $prefix.$urut;
}

function edit_jabatan_karyawan($id,$jabatan,$nik)
{
	$q=mysql_query("update karyawan set id_jabatan='$jabatan', nik='$nik' where id_karyawan='$id'");
	return $q;
}


function total_jk($p){
	
	$r= mysql_fetch_array(mysql_query("select count(jenis_kelamin) as jk from karyawan where jenis_kelamin='$p'"));
	return $r['jk'];
}


function total_karyawan($p){
	
	$r= mysql_fetch_array(mysql_query("select count(id_karyawan) as id from karyawan where status_karyawan='$p'"));
	return $r['id'];
}

function tanpa_status(){
	$r= mysql_fetch_array(mysql_query("select count(id_karyawan) as id from karyawan where status_karyawan=null or status_karyawan=''"));
	return $r['id'];
}
?>