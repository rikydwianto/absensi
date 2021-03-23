<?php
error_reporting(0);
$id=aman($_GET['id']);
$detail=detail_karyawan($id);
$jab=cari_jabatan($detail->id_jabatan);
$dep=cari_dep($jab->id_departemen);
echo mysql_error();
?>
<h2><?php echo $detail->nama_lengkap ?></h2>
<a href='<?php echo url("index.php?mn=detail_karyawan&id=$detail->id_karyawan&nik=$detail->nik&url=".url_ref()) ?>'>Detail</a><br/>
<label for='dep'><h4>Nik : <?php echo $detail->nik ?> </h4></label><br/>
<label for='dep'><h4>Departemen : <?php echo $dep->nama_departemen ?> </h4></label><br/>
<label><h4>Jabatan : <?php echo $jab->nama_jabatan?></h4></label>

<?php 
if(isset($_POST['ganti_jab']))
{
	$nik_asal=$detail->nik;
	$dep_asal=$dep->nama_departemen;
	$jab_asal=$jab->nama_jabatan;
	$departemen=aman($_POST['departemen']);
	$jabatan=aman($_POST['jabatan']);
	$keterangan=aman($_POST['keterangan']);
	$tgl_pindah=ubah_tanggal($_POST['tgl']);
	
	$tgl_masuk=date($detail->tgl_masuk);
	$tgl_masuk=date("d/m/Y",strtotime($tgl_masuk));
	$nik = (buat_nik($tgl_masuk,$departemen,$jabatan));
	$nik = $nik_asal;
	$q=edit_jabatan_karyawan($id,$jabatan,$nik);
	if($q){
		mysql_query("insert into riwayat_jabatan(id_karyawan,nik_asal,jabatan_asal,departemen_asal,keterangan,tanggal_pindah_jabatan,date_created)
		values('$id','$nik_asal','$jab_asal','$dep_asal','$keterangan','$tgl_pindah',now());
		");
		echo alert("Berhasil pindah jabatan");
	}
	else
		echo alert_error("Gagal, Error : ".mysql_error());
}
?>
<form method='post'>
<table class='table'>
	<tr>
		<tr>
			<th colspan=2><center>Ganti Jabatan</center><th>
		</tr>
	</tr>
	<tr>
		<td>Departemen</td>
		<td>
			<select name='departemen' id='dept' class="select2 form-control" style="width: 100%;" required>
				<option value='' >-- Departemen --</option>
				<?php
				$q=tampil_departemen();
				while($r=mysql_fetch_object($q))
				{
					if($r->id_departemen==$dep->id_departemen)
						$s="selected";
					else
						$s="";
					echo "<option $s value='$r->id_departemen'>$r->nama_departemen</option>";
					
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Jabatan</td>
		<td>
			<select name='jabatan' id='jabatan' class="select2 form-control" style="width: 100%;border-radius:none" required>
				<?php 
				$a=jabatan_departemen($dep->id_departemen);
				while($jab_ =  mysql_fetch_object($a))
				{
					if($jab_->id_jabatan==$jab->id_jabatan)
						$sele="selected";
					else
						$sele='';
					echo"<option value='$jab_->id_jabatan' $sele>$jab_->nama_jabatan</option>";
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Tanggal</td>
		<td>
			<input type=text class='form-control' required id='tgl2' value='<?php echo date("d/m/Y") ?>' name='tgl' data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
		</td>
	</tr>
	<tr>
		<td>Catatan</td>
		<td>
			<textarea name='keterangan' class='form-control'></textarea>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<button type='submit' name='ganti_jab' class='btn btn-flat btn-danger'>
				<i class='fa fa-exchange'></i> Ganti
			</button>
		</td>
	</tr>
</table>
</form>