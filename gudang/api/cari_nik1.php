<?php include_once"../config/setting.php"; ?>
<?php include_once"../config/koneksi.php"; ?>
<?php include_once"../fungsi/config.php"; ?>
<?php
if(isset($_POST['nik']))
{
	$nik=aman(post("nik"));
	$q=aman(post("nik"));
	//echo $nik;
	if(trim($nik)==''){
		echo "tidak boleh kosong";
	}
	else{
		
		$nik=mysql_query("select * from karyawan join jabatan on jabatan.id_jabatan=karyawan.id_jabatan 
		join departemen on departemen.id_departemen=jabatan.id_departemen 
		where nik like '%$nik%' 
		or nama_lengkap like'%$nik%'
		or jabatan.nama_jabatan like'%$nik%'
		or departemen.nama_departemen like'%$nik%'
		order by karyawan.id_jabatan,karyawan.tgl_masuk limit 0,30") or die(alert_error("Error : ".mysql_error()));
		$no=1;
		if(mysql_num_rows($nik)){
			?>
			<table class='table'>
				<thead>
					<tr>	
						<th>NO</th>
						<th>Nama</th>
						<th>NIK</th>
						<th>Departemen</th>
						<th>Jabatan</th>
						<th>Photo</th>
					</tr>
				</thead>
				<tbody>
				<?php
				while($r = mysql_fetch_array($nik))
				{
					?>
					<tr>
						<td><?php echo $no ?></td>
						<td><?php echo $r['nama_lengkap'] ?></td>
						<td><?php echo $r['nik'] ?></td>
						<td><?php echo $r['nama_departemen'] ?></td>
						<td><?php echo $r['nama_jabatan'] ?></td>
						<td> <img src='<?php echo url(cek_photo1($r['id_karyawan']))?>' width='40' /></td>
					</tr>
					<?php
				$no++;
				}
				?>
				</tbody>
			</table>
			<?php
		}
		else
		{
			echo "<b>$q</b> Tidak ditemukan ";
		}
	}
}
?>