<?php
function tampil_departemen()
{
	$q=mysql_query("select * from departemen ");
	return $q;
}
function hitung_departemen()
{
	$q=mysql_query("select count(*) as hitung from departemen ") or die("error : ".mysql_error());
	$r=mysql_fetch_object($q);
	return $r->hitung;
}

function tambah_departemen($kode,$departemen,$des)
{
	$q=mysql_query("insert into departemen(kode_departemen,nama_departemen,deskripsi_departemen,date_created,date_modified)
	values('$kode','$departemen','$des',now(),now())
	") ;
	return $q;
}

function edit_dep($id,$kode,$departemen,$des)
{
	$q=mysql_query("
		update departemen set
		kode_departemen ='$kode',
		nama_departemen	= '$departemen',
		deskripsi_departemen = '$des',
		date_modified=now()
		where id_departemen='$id'
	");
	return $q;
	
}
function hapus_dep($id)
{
	$q=mysql_query("delete from departemen where id_departemen='$id'");
	return $q;
}
function cari_dep($id)
{
	$q=mysql_query("select * from departemen where id_departemen='$id'");
	$r=mysql_fetch_object($q);
	return $r;
}
function cari_depkode($kd)
{
	$q=mysql_query("select count(*) as hitung from departemen where kode_departemen='$kd'");
	$r=mysql_fetch_object($q);
	return $r->hitung;
}

?>