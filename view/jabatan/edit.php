<?php
$jab=cari_jabatan(aman($_GET['id']));

if(isset($_POST['edit-jabatan']))
{
	
	$id_jabatan=aman($_POST['id_jabatan']);
	$kode_jabatan=aman($_POST['kode_jabatan']);
	$jabatan=aman($_POST['jabatan']);
	$deskripsi=aman($_POST['deskripsi']);
	$dep=aman($_POST['departemen']);
	if($jab->kode_jabatan!=$kode_jabatan)
	{
		if(cek_jabatan($kode_jabatan)>0)
		{
			echo alert_error("duplikat kode Jabatan, Harap ganti kode Jabatan!");
		}
		else
		{
			$edit=edit_jabatan($id_jabatan,$dep,$kode_jabatan,$jabatan,$deskripsi);
		}
	}
	else{
		$edit=edit_jabatan($id_jabatan,$dep,$kode_jabatan,$jabatan,$deskripsi);
	}
	
	if($edit)
	{
		echo alert("Berhasil Diedit");
	}
	else{
		echo alert_error("Jabatan Gagal diedit, Error : ".mysql_error());
	}
	
	
}
?>
<form method=post>
	<table class='table'>
		<tr>
			<td>Departemen</td>
			<td>
				<div class='form-group'>
				<select name='departemen' class="select2 form-control" style="width: 100%;border-radius:none" required>
					<option value='' >-- Departemen --</option>
					<?php
					$q=tampil_departemen();
					while($r=mysql_fetch_object($q))
					{
						if($jab->id_departemen==$r->id_departemen)
							echo "<option selected value='$r->id_departemen'>$r->nama_departemen</option>";
						else
						echo "<option value='$r->id_departemen'>$r->nama_departemen</option>";
						
					}
					?>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>Kode Jabatan</td>
			<td>
				<input class='form-control' maxlength=3 required type=text value='<?php echo $jab->kode_jabatan ?>' name='kode_jabatan'/>
				<input class='form-control' value='<?php echo $jab->id_jabatan ?>' value='' required type=hidden name='id_jabatan'/>
			</td>
		</tr>
		<tr>
			<td>Nama Jabatan</td>
			<td><input class='form-control' value='<?php echo $jab->nama_jabatan ?>' required type=text name='jabatan'/></td>
		</tr>
		<tr>
			<td>Deskripsi</td>
			<td><textarea class='form-control' name='deskripsi'><?php echo $jab->deskripsi_jabatan ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type=submit class='btn btn-info' value='Simpan' name='edit-jabatan'/>
				<input type=reset class='btn btn-danger' value='Reset' />
			
			</td>
		</tr>
	</table>
</form>