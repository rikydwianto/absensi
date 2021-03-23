<br/>
<?php 
if(isset($_POST['tambah-user']))
{

	$id=aman($_POST['id_karyawan']);;
	$id_user=aman($_GET['id']);;
	$departemen=aman($_POST['departemen']);;
	$jabatan=aman($_POST['jabatan']);;
	$level=aman($_POST['level']);;
	$username=aman($_POST['username1']);
	$password=aman($_POST['password1']);
	if(empty($password))
	{
		$tp="";
	}
	else
	{
		$tp=", password_user='$password'";
	}
	$q=mysql_query("update user set username='$username', id_departemen='$departemen',id_jabatan='$jabatan',lvl_user='$level' $tp where id_user='$id_user'");
	if($q)
	{
		$ket="Admin <code>$user->nama_lengkap</code> telah mengedit akun  $_POST[nik] dengan username : $username  ";

		@mysql_query("insert into record (id_karyawan,id_karyawan_input,waktu,tanggal,keterangan,date_created)
		values($id,$_SESSION[id_karyawan],now(),curdate(),'$ket',now())
		");
		echo alert("Berhasil diedit!");
	}
	else
	{
		echo alert_error("Error : ". mysql_error());
	}
		
		
		
}

$id=aman($_GET['id']);
$U=mysql_query("select * from user where id_user='$id'");
$U=mysql_fetch_object($U);
$detail=detail_karyawan($U->id_karyawan);
?>
<form method=post>
	<table class='table'>
		<tr>
			<td>NIK</td>
			<td>
				<input type='text' name='' id='nik' disabled class='form-control' value='<?php echo $detail->nik?>' />
				<input type='hidden' name='nik' id='nik' class='form-control' value='<?php echo $detail->nik?>' />
				<input type='hidden' name='id_karyawan' value='<?php echo $detail->id_karyawan?>' />
				<span id='ket_nik'></span>
			</td>
		</tr>
		<tr>
			<td>Username</td>
			<td>
				<input type='text' name='username1' class='form-control' value='<?php echo $U->username?>' />
			</td>
		</tr>
		 <tr>
			<td>Password</td>
			<td>
				<input type='password' name='password1' class='form-control' />
				<small>Jika password tidak diubah maka kosongkan</small>
			</td>
		</tr>
		<tr>
			<td>Departemen</td>
			<td>
				<select name='departemen' class='form-control select2' id='dept' >
					<option>Pilih Departemen</option>
					<?php 
					$departemen = mysql_query("select * from departemen order by nama_departemen");
					while($rdep = mysql_fetch_array($departemen)){
						if($rdep['id_departemen']== $U->id_departemen)
							$seee = "selected";
						else
							$seee='';
						echo "<option $seee value='$rdep[id_departemen]'>$rdep[nama_departemen]</option>";
					}
					?>
				</select>
			</td>
		<tr>
			<td>Jabatan</td>
			<td>
				<div class='form-group' id=''>
					<select name='jabatan' id='jabatan' class="select2 form-control" style="width: 100%;border-radius:none" >
						<option value='' >-- Pilih Departemen terlebih dahulu --</option>
					</select>
				</div>
			</td>
		</tr>
		</tr>
		<tr>
			<td>Aplikasi</td>
			<td>
				<select name='level' required="">
					<option value="">Pilih Level User</option>				
					<option value='super user'>Super User</option>
					<option value="simpeg">Sistem Informasi Kepegawaian</option>
					<option value='gudang'>Aplikasi Gudang</option>
					<option value='produksi'>Produksi</option>
				</select> 
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input class='btn btn-flat btn-danger' type=submit name='tambah-user' value='Save' />
			</td>
		</tr>
	</table>
</form>
