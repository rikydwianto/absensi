<br/>
<?php 
if(isset($_POST['tambah-user']))
{
	$nik=cek_nik(aman($_POST['nik']));
	if(empty($nik))
	{
		echo alert_error("NIK Tidak Ditemukan!");
		
	}
	else
	{
		$id=$nik->id_karyawan;
		$username=aman($_POST['username']);
		$password=aman($_POST['password']);
		$cek=mysql_query("select id_karyawan from user where id_karyawan='$nik->id_karyawan' or username='$username'");
		if(mysql_num_rows($cek))
		{
			echo alert_error("$username / ".aman($_POST['nik'])." : Sudah Terdaftar sebelumnya!");
		}
		else
		{
			
			$q=mysql_query("insert into user(id_karyawan,username,password_user,date_created,lvl_user)
			values('$id','$username','$password',now(),'super user')
			");
			if($q)
			{
				$ket="Admin <code>$user->nama_lengkap</code> telah membuatkan akun untuk $_POST[nik] dengan username : $username  ";

				@mysql_query("insert into record (id_karyawan,id_karyawan_input,waktu,tanggal,keterangan,date_created)
				values($id,$_SESSION[id_karyawan],now(),curdate(),'$ket',now(),'simpeg')
				");
				echo alert("Berhasil ditambahkan!");
			}
			else
			{
				echo alert_error("Error : ". mysql_error());
			}
			
		}
			
		
	}
}
?>
<form method=post>
	<table class='table'>
		<tr>
			<td>NIK</td>
			<td>
				<input type='text' name='nik' id='nik' class='form-control' />
				<span id='ket_nik'></span>
			</td>
		</tr>
		<tr>
			<td>Username</td>
			<td>
				<input type='text' name='username' class='form-control' />
			</td>
		</tr>
		 <tr>
			<td>Password</td>
			<td>
				<input type='password' name='password' class='form-control' />
			</td>
		</tr>
		<!--<tr>
			<td>Status</td>
			<td>
			<!--
				<select name='status'>
					<option>Aktif</option>
					<option>Tidak Aktif</option>
				</select>
				
			</td>
		</tr>
		<tr>
			<td>Level</td>
			<td>
				<select name='level'>
					<option>Karyawan</option>
					<option>Chief</option>
					<option>Admin</option>
					<option>Super Admin</option>
				</select> 
			</td>
		</tr> -->
		<tr>
			<td>&nbsp;</td>
			<td>
				<input class='btn btn-flat btn-danger' type=submit name='tambah-user' value='Save' />
			</td>
		</tr>
	</table>
</form>
