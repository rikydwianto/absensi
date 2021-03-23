<?php 
include"../config/setting.php";
include"../config/koneksi.php";
include"../fungsi/config.php";
include"../fungsi/lihat.php";
$id= aman($_GET['id']);
?>
<?php include_once"../fungsi/jabatan.php"; ?>
<?php 
if(!empty($id))
{
	?>
<select name='jabatan' class="select2 form-control" style="width: 100%;border-radius:none" required>
	<option value='' >-- Jabatan --</option>
	<?php
	$q=jabatan_departemen($id);
	while($r=mysql_fetch_object($q))
	{
		echo "<option value='$r->id_jabatan'>$r->nama_jabatan</option>";
	}
	?>
</select>
<?php 
}
else
{
	?>
	<select name='jabatan' class="select2 form-control" style="width: 100%;border-radius:none" required>
	<option value='' disabled>Pilih Departemen</option>
	</select>
	<?php
}
	?>