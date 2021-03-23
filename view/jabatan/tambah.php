<?php
		if(isset($_POST['tambah-jabatan']))
		{
			$kode_jabatan=aman($_POST['kode_jabatan']);
			$jabatan=aman($_POST['jabatan']);
			$deskripsi=aman($_POST['deskripsi']);
			$dep=aman($_POST['departemen']);
			if(cek_jabatan($kode_jabatan))
			{
				echo alert("Duplikat Kode Jabatan");
			}
			else
			{
				$q=tambah_jabatan($dep,$kode_jabatan,$jabatan,$deskripsi);
				if($q)
				{
					echo alert("Jabatan Berhasil Diinputkan");
				}
				else
				{
					echo alert_error("Jabatan gagal diinput, Error : ". mysql_error());
				}
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
								echo "<option value='$r->id_departemen'>$r->nama_departemen</option>";
								
							}
							?>
						</select>
						</div>
					</td>
				</tr>
				<tr>
					<td>Kode Jabatan</td>
					<td><input class='form-control' required type=text name='kode_jabatan'/></td>
				</tr>
				<tr>
					<td>Nama Jabatan</td>
					<td><input class='form-control' required type=text name='jabatan'/></td>
				</tr>
				<tr>
					<td>Deskripsi</td>
					<td><textarea class='form-control' name='deskripsi'></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type=submit class='btn btn-info' value='Simpan' name='tambah-jabatan'/>
						<input type=reset class='btn btn-danger' value='Reset' />
					
					</td>
				</tr>
			</table>
		</form>