<?php
function cek_karyawan($id)
{
	$q=mysql_query("select * from karyawan,user,jabatan,departemen where user.id_karyawan=karyawan.id_karyawan and jabatan.id_departemen=departemen.id_departemen and karyawan.id_jabatan=jabatan.id_jabatan and karyawan.id_karyawan='$id'") or die('Error : '. mysql_error());
	$r=mysql_fetch_object($q);
	return $r;
}

function cek_photo($id)
{
	$not="x_user.png";
	$folder="data/foto/";
	$q=mysql_query("select nik,file_foto from karyawan where id_karyawan='$id'");
	$r=mysql_fetch_object($q);
	if(!isset($r))
		return $folder.$not;
	else
	{
		if(file_exists($folder.$r->nik.'.jpg'))
		{
			if(file_exists($folder.'thumb/'.$r->nik.'.jpg'))
				return $folder.'thumb/'.$r->nik.'.jpg';
			else
				return $folder.$not;
		}
		else
		{
			return $folder.$not;
		}
	
	}
}
function cek_photo_besar($id)
{
	$not="x_user.png";
	$folder="data/foto/";
	$q=mysql_query("select nik,file_foto from karyawan where id_karyawan='$id'");
	$r=mysql_fetch_object($q);
	if(!isset($r))
		return $folder.$not;
	else
	{
		if(file_exists($folder.$r->nik.'.jpg'))
		{
			if(file_exists($folder.''.$r->nik.'.jpg'))
				return $folder.''.$r->nik.'.jpg';
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
	$folder="../data/foto/";
	$q=mysql_query("select nik,file_foto from karyawan where id_karyawan='$id'");
	$r=mysql_fetch_object($q);
	if(!isset($r))
		return $folder.$not;
	else
	{
		if(file_exists($folder.$r->nik.'.jpg'))
		{
			if(file_exists($folder.'thumb/'.$r->nik.'.jpg'))
				return $folder.'thumb/'.$r->nik.'.jpg';
			else
				return $folder.$not;
		}
		else
		{
			return $folder.$not;
		}
	
	}
}
function bulan(){
	$bln=array();
	$bln[1]='Januari';
	$bln[2]='Februari';
	$bln[3]='Maret';
	$bln[4]='April';
	$bln[5]='Mei';
	$bln[6]='Juni';
	$bln[7]='Juli';
	$bln[8]='Agustus';
	$bln[9]='September';
	$bln[10]='Oktober';
	$bln[11]='November';
	$bln[12]='Desember';
	return $bln;
}
function baca_level($level) 
{
	/*
	0 - SUPER USER 		: Dapat Mengakses semua aplikasi
	1 - CHIEF 			: Dapat mengakses aplikasi sesuai departemen nya
	2 - ADMINISTRATOR 	: Dapat Mengakses dan Mengontrol absensi seusai Dept dan Line
	3 - USER			: Dapat melihat absensi dirinya sendiri
	
	
	*/
	if($level==0)
	{
		$nm_level ="Super User";
	}
	else
	{
		if($level==1)
		{
			$nm_level="Administrator";
			
		}
		else
		{
			if($level==2)
			{
				$nm_level="Chief";
			}
			else
			{
				if($level==3)
				{
					$nm_level="User";
				}
				else
				{
					$nm_level="000";
				}
				
			}
		}
	}
	return $nm_level;
	
} 
function baca_status($status) 
{
	if($status==0)
	{
		$nm_status ="Not Active";
	}
	else
	{
		if($status==1)
		{
			$nm_status="Active";
			
		}
		else
		{
					$nm_status="000";
				
				
			
		}
	}
	return $nm_status;
	
} 
	
function format($namafile){
	$ext = end(explode('.', $namafile));
	$ext = substr(strrchr($namafile, '.'), 1);
	$ext = substr($namafile, strrpos($namafile, '.') + 1);
	$ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $namafile);

	$exts = split("[/\\.]", $namafile);
	$n    = count($exts)-1;
	$ext  = $exts[$n];
	return $ext;
}

