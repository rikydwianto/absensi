<option value=''>Pilih Nama Karyawan/Nomor Induk Karyawan</option>
<?php
include_once"../config/setting.php";
include_once"../config/koneksi.php";
include_once"../fungsi/config.php";
include_once"../fungsi/lihat.php";
include_once"../fungsi/karyawan.php";
include_once"../fungsi/absen.php";
include_once"../fungsi/absen-absen.php";
$id=aman($_GET['nik']);
$qdep = mysql_query("select * from departemen join jabatan on jabatan.id_departemen=departemen.id_departemen");
while($dep = mysql_fetch_array($qdep)){
	$sel = mysql_query("select * from karyawan where id_jabatan='$dep[id_jabatan]' order by nama_lengkap asc") or die(mysql_error());
	?>
	<optgroup label="<?php echo $dep['nama_departemen'] ?> - <?php echo $dep['nama_jabatan'] ?>">
	<?php
	while($r=mysql_fetch_array($sel)){
		if($r['nik']==$id)
			$a='selected';
		else $a='';
		?>
		<option <?php echo $a ?> value='<?php echo $r['nik'] ?>'><?php echo $r['nama_lengkap'] ?> - <?php echo $r['nik'] ?></option>
		<?php
		
	}
	echo "</optgroup>";
}

?>