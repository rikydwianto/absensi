<?php 
$id=aman($_GET['id']);
if(isset($_POST['tmb-karyawan']))
{
	error_reporting(0);
	$karyawan			= detail_karyawan($id);
	$id					= aman($_POST['id']);
	$departemen			= aman($_POST['departemen']);
	$jabatan 			= aman($_POST['jabatan']);
	$nik_baru			= aman($_POST['nik_baru']);
	$ktp				= aman($_POST['ktp']);
	$nama				= aman($_POST['nama']);
	$panggilan			= aman($_POST['panggilan']);
	$tempat_lahir		= aman($_POST['tempat_lahir']);
	$tgl				= ubah_tanggal($_POST['tgl']);
	$agama				= aman($_POST['agama']);
	$jk					= aman($_POST['jk']);
	$wni				= aman($_POST['wni']);
	$status				= aman($_POST['status']);
	$status_nikah		= aman($_POST['status_nikah']);
	$jumlah_anak		= aman($_POST['jumlah_anak']);
	$nama_ayah			= aman($_POST['nama_ayah']);
	$nama_ibu			= aman($_POST['nama_ibu']);
	$alamat				= aman($_POST['alamat']);
	$alamat_tinggal		= aman($_POST['alamat_tinggal']);
	$telp1				= aman($_POST['telp1']);
	$telp2				= aman($_POST['telp2']);
	$email				= aman($_POST['email']);
	
	$tgl_masuk=ubah_tanggal($_POST['tgl_masuk']);
	$tgl2=ubah_tanggal($_POST['tgl_masuk']);
	$nik = $karyawan->nik;
	@rename("data/berkas/$nik","data/berkas/$nik_baru");
	
	$catatan=$_POST['catatan'];
	//image/jpeg || image/gif || image/png
	if((@$_FILES['foto']['name']))
	{
		$type=$_FILES['foto']['type'];
		$size= ($_FILES['foto']['size']);
		// if($size<3000000000){
			// if($type=='image/jpeg' || $type=="image/png" || $type=="image/gif")
			// {
				$direktori          = "data/foto/";
				$dirthumb           = "data/foto/thumb/";
				chmod($direktori,0777);
				chmod($dirthumb,0777);
				$file               = $direktori.$nik.'.jpg';
				$thumb               = $dirthumb.$nik.'.jpg';
				$up=move_uploaded_file($_FILES['foto']['tmp_name'], $file); 
				move_uploaded_file($_FILES['foto']['tmp_name'], $thumb); 
				if($up){
					Upload($_FILES['foto'],$nik);
					// echo "Berhasil upload gambar";
				}
				else{
					// echo "gagal upload gambar";
				}
				

				$foto=$nik.".jpg";
			// }
			// else{
				// $foto=$nik.".jpg";
				// echo alert_error("Maaf Photo tidak tidak diizinkan, harus berbentuk jpg,png,gif");
			// }
		// }
		// else{
			// echo alert_error("Melebihi batas upload, Max : 3mb");
		// }
		
	}
	else
	{
		$foto=$karyawan->file_foto;
	}
	$q="UPDATE karyawan SET no_ktp = '$ktp', nik='$nik_baru' , nama_lengkap = '$nama', nama_panggilan = '$panggilan',
	tpt_lahir = '$tempat_lahir', agama = '$agama', warganegara = '$wni', file_foto='$foto',
	nama_ayah = '$nama_ayah', nama_ibu = '$nama_ibu', alamat_rumah = '$alamat', 
	alamat_tinggal = '$alamat_tinggal', tlp_1 = '$telp1', tlp_2 = '$telp2', 
	email = '$email', tgl_lahir='$tgl',jenis_kelamin='$jk',status_karyawan='$status',
	catatan = '$catatan', status_nikah='$status_nikah', jml_anak='$jumlah_anak', tgl_masuk='$tgl_masuk',
	editby='$_SESSION[id_karyawan]',
	date_modified = 'now()' WHERE id_karyawan = '$id'; ";
	//echo alert($q);
	if($status==5)
	{
		mysql_query("update karyawan set tgl_keluar=curdate() where id_karyawan='$id'");
	}
	else
	{
		mysql_query("update karyawan set tgl_keluar=null where id_karyawan='$id'");
	}

	$q=mysql_query($q);
	if($q)
		echo alert("Karyawan $nama Berhasil diedit, NIK : <b>$nik</b>");
	else
		echo alert_error("Gagal diedit, Error : ". mysql_error());
	
	$ket="$karyawan->nik - $karyawan->nama_lengkap telah diedit oleh admin dengan nama karyawan <code>$user->nama_lengkap</code>";
	
	@mysql_query("insert into record (id_karyawan,id_karyawan_input,waktu,tanggal,keterangan,date_created)
	values($id,$_SESSION[id_karyawan],now(),curdate(),'$ket',now())
	");
}

$karyawan=detail_karyawan($id);
?>
<form method=post id='fkaryawan' enctype="multipart/form-data">
<a href='<?php echo @$_GET['url'] ?>' class='btn btn-danger'><i class='fa fa-angle-double-left'></i> Kembali</a>
	<table class='table-responsive table'>
		<tr>
			<td>Foto</td>
			<td>
				<small style='color:red'>File Gambar yang diperbolehkan (.jpg/.png/.gif) max 3 mb</small>
				<input type='file' id="inputFile"  name='foto' />
				<img id="image_upload_preview" onclick="document.getElementById('kirim').submit();" src="<?php echo url(cek_photo($karyawan->id_karyawan)) ?>" class='img img-thumbnail img-responsive' style='width:200px;' />

			</td>
		</tr>
		
		<tr>
			<td>NIK</td>
			<td>
				<input type=number value='<?php echo @$karyawan->nik ?>' class='form-control' name='nik_baru' />
			</td>
		</tr>
		<tr>
			<td>NO KTP</td>
			<td>
				<input type=number value='<?php echo @$karyawan->no_ktp ?>' class='form-control' name='ktp' />
				<input type=hidden value='<?php echo @$karyawan->id_karyawan ?>' class='form-control' name='id' />
			</td>
		</tr>
		<tr>
			<td>Nama Lengkap</td>
			<td>
				<input type=text class='form-control' value='<?php echo @$karyawan->nama_lengkap ?>' name='nama'/>
			</td>
		</tr>
		<tr>
			<td>Nama Panggilan</td>
			<td>
				<input type=text class='form-control' name='panggilan' value='<?php echo @$karyawan->nama_panggilan ?>'/>
			</td>
		</tr>
		<tr>
			<td>Jenis Kelamin</td>
			<td>
				<select name='jk' class='form-control'>
				<?php 
				if(@$karyawan->jenis_kelamin==0)
					$l="selected";
				else if(@$karyawan->jenis_kelamin==1)
					$p="selected";
				?>
					<option value=''>-- Jenis Kelamin --</option>
					<option <?php  echo @$l ?> value='0'>Laki - laki</option>
					<option <?php  echo @$p ?> value='1'>Perempuan</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Tempat Lahir</td>
			<td>
				<input type=text class='form-control' name='tempat_lahir' value='<?php echo $karyawan->tpt_lahir ?>'/>
			</td>
		</tr>
		<tr>
			<td>Tanggal Lahir</td>
			<td>
				<input type=text class='form-control' name='tgl' id='tgl1' value='<?php echo date("d/m/Y",strtotime(@$karyawan->tgl_lahir)) ?>'/>
			</td>
		</tr>
		<tr>
			<td>Agama</td>
			<td>
				<select name=agama class='form-control'>
					<option value=''>-- Agama --</option>
					<?php
					$agama=$karyawan->agama;
					if($agama=="Islam")
						$islam="selected";
					else if($agama=='Kristen Protestan')
						$pros="selected";
					else if($agama=='Katolik')
						$kat="selected";
					else if($agama=='Hindu')
						$hin="selected";
					else if($agama=='Buddha')
						$bud="selected";
					else if($agama=='Kong Hu Cu')
						$kong="selected";
					else if($agama=='Lain - lain')
						$lain="selected";
					?>
					
					<option <?php echo @$islam ?> >Islam</option>
					<option <?php echo @$pros ?> >Kristen Protestan</option>
					<option <?php echo @$kat ?> >Katolik</option>
					<option <?php echo @$hin ?> >Hindu</option>
					<option <?php echo @$bud ?> >Buddha</option>
					<option <?php echo @$kong ?> >Kong Hu Cu</option>
					<option <?php echo @$lain ?> >Lain - lain</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Warganegara</td>
			<td>
				<select name=wni class='form-control'>
				<?php 
				if($karyawan->warganegara=='wni' || $karyawan->warganegara=='WNI' )
					$wni1="selected";
				else
					$wna2='selected';
				?>
					<option value=''>-- Warga Negara --</option>
					<option <?php echo @$wni1 ?>>WNI</option>
					<option <?php echo @$wna1 ?>>WNA</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Status Nikah</td>
			<td>
				<select name='status_nikah'class='form-control'>
				<?php 
				$ni=$karyawan->status_nikah;
				if($ni=='0')
					$bl="selected";
				else if($ni=='1')
					$mn="selected";
				else if($ni=='2')
					$jan="selected";
				else if($ni=='3')
					$du="selected";
				?>
					<option  value=''>-- Status --</option>
					<option <?php echo @$bl?> value='0'>Belum Menikah</option>
					<option <?php echo @$mn?> value='1'>Menikah</option>
					<option <?php echo @$jan?> value='2'>Janda</option>
					<option <?php echo @$du?> value='3'>Duda</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Jumlah Anak</td>
			<td>
				<input type=number class='form-control' name='jumlah_anak' value='<?php echo $karyawan->jml_anak ?>'/>
			</td>
		</tr>
		<tr>
			<td>Nama Ayah</td>
			<td>
				<input type=text class='form-control' name='nama_ayah' value='<?php echo $karyawan->nama_ayah ?>'/>
			</td>
		</tr>
		<tr>
			<td>Nama Ibu</td>
			<td>
				<input type=text class='form-control' name='nama_ibu' value='<?php echo @$karyawan->nama_ibu ?>'/>
			</td>
		</tr>
		
		<tr>
			<td>Alamat Rumah</td>
			<td>
				<textarea name='alamat' class='form-control'><?php echo @$karyawan->alamat_rumah ?></textarea>
			</td>
		</tr>
		
		<tr>
			<td>Alamat Tinggal</td>
			<td>
				<textarea name='alamat_tinggal' class='form-control'><?php echo $karyawan->alamat_tinggal ?></textarea>
			</td>
		</tr>
		
		<tr>
			<td>No.TLP 1</td>
			<td>
				<input type=text class='form-control' name='telp1' value='<?php echo $karyawan->tlp_1 ?>'/>
			</td>
		</tr>
		
		<tr>
			<td>No.TLP 2</td>
			<td>
				<input type=text class='form-control' name='telp2' value='<?php echo $karyawan->tlp_2 ?>'/>
			</td>
		</tr>
		
		<tr>
			<td>Email/FB</td>
			<td>
				<input type=text class='form-control' name='email' value='<?php echo $karyawan->email?>'/>
			</td>
		</tr>
		
		<tr>
			<td>Tanggal Masuk</td>
			<td>
				<input type=text class='form-control' required id='tgl2' name='tgl_masuk' value='<?php echo date("d/m/Y",strtotime(@$karyawan->tgl_masuk)) ?>'/>
			</td>
		</tr>
		
		<tr>
			<td>Status Karyawan</td>
			<td>
				<select name='status' class='form-control' >
				<?php 
				$sta=$karyawan->status_karyawan;
				if($sta==1)
					$a="selected";
				else if($sta==2)
					$b="selected";
				else if($sta==3)
					$c="selected";
				else if($sta==4)
					$d="selected";
				else if($sta==5)
					$e="selected";
				else if($sta==6)
					$f="selected";
				?>
				
					<option value=''>Status Karyawan</option>
					<option <?php echo @$a?> value='1'>Training</option>
					<option <?php echo @$b?> value='2'>Kontrak</option>
					<option <?php echo @$c?> value='3'>Tetap</option>
					<option <?php echo @$d?> value='4'>Off</option>
					<option <?php echo @$e?> value='5'>Resign</option>
					<option <?php echo @$f?> value='6'>SPD</option>
				</select>
			</td>
		</tr>
		
		
		
		<tr>
			<td>Catatan</td>
			<td>
				<textarea name='catatan' class='form-control'><?php echo @$karyawan->catatan ?></textarea>
			</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type=submit name='tmb-karyawan' id='kirim' value='Simpan' class='btn btn-info'>
				<input type=reset  value='Batal' class='btn btn-danger'>
			</td>
		</tr>
		
	</table>
</form>
