<?php
function url($l=null)
{
	$url= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
	$url.= "://".$_SERVER['HTTP_HOST'];
	$url.= preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])).'/';

	if($l==null)
		$tambah='';
	else
		$tambah=$l;
	
	return $url.$tambah;
}
function url_sekarang()
{
	$url= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
	$url.= "://".$_SERVER['HTTP_HOST'];
	$url.=$_SERVER['REQUEST_URI'];
	return ($url);
}
function url_ref(){
	return urlencode(url_sekarang());
}
function kembali(){
	return urldecode($_GET['url']);
}
function waktu($tgl)
{
	$tgl=date($tgl);
	$hari=array('Minggu','Senin','Selasa','Rabu','Kamis',"Jum'at",'Sabtu');
	$bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$tanggal=date('Y-m-d', strtotime($tgl));
	$angka=date('w',strtotime($tgl));
	$bln=(int)date('m',strtotime($tgl));
	$day=date('d',strtotime($tgl));
	$thn=date('Y',strtotime($tgl));
	$semua=$hari[$angka].', '.$day.' '.$bulan[$bln].' '.$thn;
	return date("H:i",strtotime($tgl)).' '.$semua;
	//$wak=strtotime($time);
	//return date("H:i d-m-Y",$wak);
}

function tanggal($tgl)
{
	$tgl=date($tgl);
	$hari=array('Minggu','Senin','Selasa','Rabu','Kamis',"Jum'at",'Sabtu');
	$bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$tanggal=date('Y-m-d', strtotime($tgl));
	$angka=date('w',strtotime($tgl));
	$bln=(int)date('m',strtotime($tgl));
	$day=date('d',strtotime($tgl));
	$thn=date('Y',strtotime($tgl));
	$semua=$hari[$angka].', '.$day.' '.$bulan[$bln].' '.$thn;
	return $semua;
}

function cek_bulan($bln)
{
	$bln=(int)$bln;
	$bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$semua=$bulan[$bln];
	return $semua;
}

function aman($text){
	return mysql_real_escape_string(($text));
	
}

function menu($page){
	return url("index.php?mn=$page");
}

function alert($text)
{
	return "
	<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
			$text
	</div>
	";
}
function alert2($text)
{
	return "
	<script>
		alert('$text');
	</script>
	";
}
function alert_error($text)
{
	return "
	<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
			$text
	</div>
	";
}



function post($param){
	return aman(@$_POST["$param"]);
}


function get($param){
	return aman(@$_GET["$param"]);
}

function direct($url){
	echo "<script>window.location.href='$url';</script>";
}

function ubah_tanggal($tgl)
{
	$tgl=trim($tgl);
	$tgl=explode('/',$tgl);
	$tahun=$tgl[2];
	$bulan=$tgl[1];
	$hari=$tgl[0];
	return $tahun.'-'.$bulan.'-'.$hari;
}
function cek_login()
{
	if(!isset($_SESSION['ID']))
		direct(url("login.php?url=".url_ref()));
}

function cek_photo($id)
{
	$not="x_user.png";
	$folder="../data/foto/";
	$q=mysql_query("select file_foto from karyawan where id_karyawan='$id'");
	$r=mysql_fetch_object($q);
	if(!isset($r))
		return $folder.$not;
	else
	{
		if(file_exists($folder.$r->file_foto))
		{
			if(file_exists($folder.'thumb/'.$r->file_foto))
				return $folder.'thumb/'.$r->file_foto;
			else
				return $folder.$not;
		}
		else
		{
			return $folder.$not;
		}
	
	}
}
function cek_photo1($id)
{
	$not="x_user.png";
	$folder="../../data/foto/";
	$q=mysql_query("select file_foto from karyawan where id_karyawan='$id'");
	$r=mysql_fetch_object($q);
	if(!isset($r))
		return $folder.$not;
	else
	{
		if(file_exists($folder.$r->file_foto))
		{
			if(file_exists($folder.'thumb/'.$r->file_foto))
				return $folder.'thumb/'.$r->file_foto;
			else
				return $folder.$not;
		}
		else
		{
			return $folder.$not;
		}
	
	}
}
function rupiah($uang){
 $jadi = "Rp. " . number_format($uang,2,',','.');
	return $jadi;

}
function cari_menit($awal,$akhir)
{
	
	list($h,$m,$s) = explode(":","$awal");
	$dtAwal = mktime($h,$m,$s,"1","1","1");
	list($h,$m,$s) = explode(":","$akhir");
	$dtAkhir = mktime($h,$m,$s,"1","1","1");
	$dtSelisih = $dtAkhir-$dtAwal;

	return ($dtSelisih/60);
}
function bulan(){
$bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
return $bulan;
}

function tombol_kembali(){
	return "<a href='".kembali()."' class='btn btn-danger'><i class='fa fa-angle-double-left'></i>Kembali</a>";
}