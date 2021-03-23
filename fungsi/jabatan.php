<?php
function tampil_jabatan(){
	$q=mysql_query("select * from jabatan, departemen where departemen.id_departemen=jabatan.id_departemen");
	return $q;
}

function tambah_jabatan($kode_dep,$kode_jab,$nama_jabatan,$des)
{
	$q=mysql_query("insert into jabatan(id_departemen,kode_jabatan,nama_jabatan,deskripsi_jabatan,date_created)
		values('$kode_dep','$kode_jab','$nama_jabatan','$des',now())
	");
	return $q;
}

function cek_jabatan($id)
{
	$q=mysql_query("select * from jabatan where kode_jabatan='$id'");
	return mysql_num_rows($q);
}
function cari_jabatan($id)
{
	$q=mysql_query("select * from jabatan where id_jabatan='$id'");
	$r=mysql_fetch_object($q);
	return $r;
}

function edit_jabatan($id,$iddep,$kode,$jabatan,$des)
{
	$q=mysql_query("update jabatan set 
		kode_jabatan='$kode',
		id_departemen='$iddep',
		nama_jabatan='$jabatan',
		deskripsi_jabatan='$des',
		date_modified=now()
		where id_jabatan='$id'
	");
	return $q;
}

function hapus_jabatan($id)
{
	$q=mysql_query("delete from jabatan where id_jabatan='$id'");
	return $q;
}
function jabatan_departemen($id){
	$q=mysql_query("select * from jabatan where id_departemen='$id'");
	return $q;
}
function cek_jabatan_departemen($id){
	$q=mysql_query("select * from jabatan where id_departemen='$id'");
	return mysql_fetch_object($q);
	
}
?>