<?php 
error_reporting(0);
if(isset($_POST['tmb-karyawan']))
{
	$departemen=aman($_POST['departemen']);
	$jabatan=aman($_POST['jabatan']);
	$ktp=aman($_POST['ktp']);
	$nama=aman($_POST['nama']);
	$panggilan=aman($_POST['panggilan']);
	$tempat_lahir=aman($_POST['tempat_lahir']);
	$tgl=ubah_tanggal($_POST['tgl']);
	$agama=aman($_POST['agama']);
	$jk=aman($_POST['jk']);
	$wni=($_POST['wni']);
	$status=aman($_POST['status']);
	$status_nikah=aman($_POST['status_nikah']);
	$jumlah_anak=aman($_POST['jumlah_anak']);
	$nama_ayah=aman($_POST['nama_ayah']);
	$nama_ibu=aman($_POST['nama_ibu']);
	$alamat=aman($_POST['alamat']);
	$alamat_tinggal=aman($_POST['alamat_tinggal']);
	$telp1=aman($_POST['telp1']);
	$telp2=aman($_POST['telp2']);
	$email=aman($_POST['email']);
	$tgl_masuk=($_POST['tgl_masuk']);
	$tgl2=ubah_tanggal($_POST['tgl_masuk']);
	$nik = (buat_nik($tgl_masuk,$departemen,$jabatan));
	
	$catatan=$_POST['catatan'];
	if(!empty($_FILES['foto']['tmp_name']))
	{
		$type=$_FILES['foto']['type'];
		$size= ($_FILES['foto']['size']);
		// if($size<30000000){
			// if($type=='image/jpeg' || $type=="image/png" || $type=="image/gif")
			// {
				$direktori          = "data/foto/";
				$dirthumb           = "data/foto/thumb/";
				$file               = $direktori.$nik.'.jpg';
				$up=move_uploaded_file($_FILES['foto']['tmp_name'], $file); 
				if($up){
					Upload($_FILES['foto'],$nik);
					//echo "Berhasil upload gambar";
				}
				else{
					//echo "gagal upload gambar";
				}
				//Upload($_FILES['foto'],$nik);
				$foto=$nik.".jpg";
			// }
			// else
				// echo alert_error("Maaf Photo tidak tidak diizinkan, harus berbentuk jpg,png,gif");
		// }
		// else{
			// echo alert_error("Melebihi batas upload, Max : 3mb");
		// }
	}
	else
	{
		$foto="x_user.png";
	}
	$q="INSERT INTO karyawan (id_karyawan, no_ktp, nik, nama_lengkap, nama_panggilan, jenis_kelamin, tpt_lahir, tgl_lahir, agama, warganegara, status_nikah, jml_anak, nama_ayah, nama_ibu, alamat_rumah, alamat_tinggal, tlp_1, tlp_2, email, tgl_masuk, tgl_keluar, id_jabatan, status_karyawan, file_foto, catatan, date_created, date_modified, inputby) VALUES 
	(NULL, '$ktp', '$nik', '$nama', '$panggilan', '$jk', '$tempat_lahir', '$tgl', '$agama', '$wni', '$status_nikah', '$jml_anak', '$nama_ayah', '$nama_ibu', '$alamat', '$alamat_tinggal', '$telp1', '$telp2', '$email', '$tgl2', NULL, '$jabatan', '$status', '$foto', '$catatan', now(), NULL,'$_SESSION[id_karyawan]'); ";
	//image/jpeg || image/gif || 
	$type=$_FILES['foto']['type'];
	// if($type=='image/jpeg' || $type=="image/png" || $type=="image/gif")
	// {
		$q=mysql_query($q);
		if($q)
			echo alert("Karyawan Baru Berhasil Disimpan dalam database, dengan NIK : <b>$nik</b>");
		else
			echo alert_error("Gagal Ditambahkan, Error : ". mysql_error());
	// }
	$ket="$nik - $nama telah dibuat oleh admin  <code>$user->nama_lengkap</code>";

	@$id=mysql_insert_id();
	@mysql_query("insert into record (id_karyawan,id_karyawan_input,waktu,tanggal,keterangan,date_created)
	values($id,$_SESSION[id_karyawan],now(),curdate(),'$ket',now())
	");

}
?>
<form method=post id='fkaryawan' enctype='multipart/form-data'>

	<table class='table-responsive table'>
		<tr>
			<td>Departemen</td>
			<td>
				<div class='form-group'>
				<select name='departemen' id='dept' class="select2 form-control" style="width: 100%;" required>
					<option value='' >-- Departemen --</option>
					<?php
					$q=tampil_departemen();
					while($r=mysql_fetch_object($q))
					{
						echo "<option value='$r->id_departemen'>$r->nama_departemen [$r->kode_departemen]</option>";
						
					}
					?>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>
				<div class='form-group' id=''>
					<select name='jabatan' id='jabatan' class="select2 form-control" style="width: 100%;border-radius:none" required>
						<option value='' >-- Pilih Departemen terlebih dahulu --</option>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>NO KTP</td>
			<td>
				<input type=number value='<?php echo @$_POST['ktp'] ?>' class='form-control' name='ktp' />
			</td>
		</tr>
		<tr>
			<td>Nama Lengkap</td>
			<td>
				<input type=text class='form-control' value='<?php echo @$_POST['nama'] ?>' name='nama'/>
			</td>
		</tr>
		<tr>
			<td>Nama Panggilan</td>
			<td>
				<input type=text class='form-control' name='panggilan' value='<?php echo @$_POST['panggilan'] ?>'/>
			</td>
		</tr>
		<tr>
			<td>Jenis Kelamin</td>
			<td>
				<select name='jk' class='form-control'>
					<option value=''>-- Jenis Kelamin --</option>
					<option value='0'>Laki - laki</option>
					<option value='1'>Perempuan</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Tempat Lahir</td>
			<td>
				<input type=text class='form-control' name='tempat_lahir' value='<?php echo @$_POST['tempat_lahir'] ?>'/>
			</td>
		</tr>
		<tr>
			<td>Tanggal Lahir</td>
			<td>
				<input type=text class='form-control' name='tgl' id='tgl1' value='<?php echo @$_POST['tgl'] ?>' data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
			</td>
		</tr>
		<tr>
			<td>Agama</td>
			<td>
				<select name=agama class='form-control'>
					<option value=''>-- Agama --</option>
					<option>Islam</option>
					<option>Kristen Protestan</option>
					<option>Katolik</option>
					<option>Hindu</option>
					<option>Buddha</option>
					<option>Kong Hu Cu</option>
					<option>Lain - lain</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Warganegara</td>
			<td>
				<select name=wni class='form-control'>
					<option value=''>-- Warga Negara --</option>
					<option>WNI</option>
					<option>WNA</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Status Nikah</td>
			<td>
				<select name='status_nikah'class='form-control'>
					<option value=''>-- Status --</option>
					<option value='0'>Belum Menikah</option>
					<option value='1'>Menikah</option>
					<option value='2'>Janda</option>
					<option value='3'>Duda</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Jumlah Anak</td>
			<td>
				<input type=number class='form-control' name='jumlah_anak' value='<?php echo @$_POST['jumlah_anak'] ?>'/>
			</td>
		</tr>
		<tr>
			<td>Nama Ayah</td>
			<td>
				<input type=text class='form-control' name='nama_ayah' value='<?php echo @$_POST['nama_ayah'] ?>'/>
			</td>
		</tr>
		<tr>
			<td>Nama Ibu</td>
			<td>
				<input type=text class='form-control' name='nama_ibu' value='<?php echo @$_POST['nama_ibu'] ?>'/>
			</td>
		</tr>
		
		<tr>
			<td>Alamat Rumah</td>
			<td>
				<textarea name='alamat' class='form-control'><?php echo @$_POST['alamat'] ?></textarea>
			</td>
		</tr>
		
		<tr>
			<td>Alamat Tinggal</td>
			<td>
				<textarea name='alamat_tinggal' class='form-control'><?php echo @$_POST['alamat_tinggal'] ?></textarea>
			</td>
		</tr>
		
		<tr>
			<td>No.TLP 1</td>
			<td>
				<input type=text class='form-control' name='telp1' value='<?php echo @$_POST['telp1'] ?>'/>
			</td>
		</tr>
		
		<tr>
			<td>No.TLP 2</td>
			<td>
				<input type=text class='form-control' name='telp2' value='<?php echo @$_POST['telp2'] ?>'/>
			</td>
		</tr>
		
		<tr>
			<td>Email</td>
			<td>
				<input type=email class='form-control' name='email' value='<?php echo @$_POST['email'] ?>'/>
			</td>
		</tr>
		
		<tr>
			<td>Tanggal Masuk</td>
			<td>
				<input type=text class='form-control' required id='tgl2' data-inputmask="'alias': 'dd/mm/yyyy'" data-mask name='tgl_masuk' value='<?php echo @$_POST['tgl_masuk'] ?>'/>
			</td>
		</tr>
		
		<tr>
			<td>Status Karyawan</td>
			<td>
				<select name='status' class='form-control'>
					<option value=''>Status Karyawan</option>
					<option value='1'>Training</option>
					<option value='2'>Kontrak</option>
					<option value='3'>Tetap</option>
					<option value='4'>Off</option>
					<option value='5'>Resign</option>
				</select>
			</td>
		</tr>
		
		<tr>
			<td>Foto</td>
			<td>
				<small style='color:red'>File Gambar yang diperbolehkan (.jpg/.png/.gif) max : 3mb</small>
				<input requiwsred type='file' id="inputFile" accept="image/*"  name='foto' />
				<img id="image_upload_preview" src="<?php echo url('data/foto/x_user.png') ?>" class='img img-thumbnail img-responsive' style='width:200px;' />

			</td>
		</tr>
		
		<tr>
			<td>Catatan</td>
			<td>
				<textarea name='catatan' class='form-control'><?php echo $_POST['catatan'] ?></textarea>
			</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type=submit name='tmb-karyawan' value='Simpan' class='btn btn-info'>
				<input type=reset  value='Batal' class='btn btn-danger'>
			</td>
		</tr>
		
	</table>
</form>
