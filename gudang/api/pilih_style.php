<?php include"../config/setting.php"?>
<?php include"../config/koneksi.php"?>
<?php include"../fungsi/config.php"?>
<?php 
$id=post("id_buyer");
?>
<select name='style' required class='form-control'>
	<option value=''>Pilih Style</option>
	<?php 
	$q=mysql_query("select * from style where id_buyer='$id'");
	while($r=mysql_fetch_array($q))
	{
		echo "<option value='$r[nama_style]'>$r[nama_style]</option>";
	}
	?>
</select>