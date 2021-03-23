<?php 
if(isset($_POST['banyak_act'])){
	$id_ = $_POST['id'];
	$num = count($id_);
	$ket_har = $_POST['pilihan'];
	for($i=0;$i<$num;$i++){
		$q=mysql_query("select count(*) as hitung from absen where id_karyawan='$id_[$i]' and tanggal_absen='$tgl'");
		$hitung=mysql_fetch_object($q);
		if($hitung->hitung==0)
		{
			mysql_query("insert into absen (id_karyawan,tanggal_absen,keterangan_hadir,date_created,jam_masuk,jam_keluar)values
			('$id_[$i]','$tgl','$ket_har',now(),'00:00:00','00:00:00')") or die(alert_error(mysql_error()));	
		}
	}
}
?>
<form method=post>
<select name='pilihan'>
	<option value=''>Hadir</option>
	<option value='skd'>SAKIT</option>
	<option value='izin'>IZIN</option>
	<option value='libur'>LIBUR</option>
	<option value='alfa'>ALFA</option>
	<option value='out'>OUT</option>
	<option value='spd'>SPD</option>
	<option value='pulang'> IZIN Setengah Hari</option>
	<option value='pulang_libur'> LIBUR Setengah Hari</option>
</select>
<input type="submit" name="banyak_act" value='Terapkan Aksi'/>
<div class='table-responsive' id=''>
	
	<table style='width:100%' class='table-hover'>
		<thead>
		<tr>
			<td colspan=5>
				
			</td>
		</tr>
		<tr>
			<th>No.</th>
			<th>ID.</th>
			<th>NIK</th>
			<th>Nama</th>
			<th>Departemen</th>
			<th>Jabatan</th>
			<th>#</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$no=1;
		$q=tidak_hadir($id_jabatan,$tgl);
		while($r=mysql_fetch_object($q)){
			?>
		<tr>
			<td><?php echo $no; ?>. </td>
			<td><input type=checkbox name='id[]' value='<?php echo $r->id_karyawan ?>'/> <?php echo $r->id_karyawan ?></td>
			<td><?php echo $r->nik ?></td>
			<td><?php echo $r->nama_lengkap ?></td>
			<td><?php echo @$r->nama_departemen ?></td>
			<td><?php echo @$r->nama_jabatan ?></td>
			<td>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' onclick='return tanya()' class='btn bg-blue btn-flat btn-xs'>D</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=skd&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' onclick='return tanya()' class='btn btn-success btn-flat btn-xs'>SKD</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=izin&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' onclick='return tanya()' class='btn btn-info btn-flat btn-xs'>I</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=alfa&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' onclick='return tanya()' class='btn btn-danger btn-flat btn-xs'>A</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=libur&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' onclick='return tanya()'  class='btn btn-danger btn-flat btn-xs'>LIBUR</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=out&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' onclick='return tanya()' class='btn btn-danger btn-flat btn-xs'>OUT</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=spd&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' onclick='return tanya()' class='btn btn-black btn-flat  btn-xs'>SPD</a>
		</td>
		</tr>
			<?php
		$no++;
		}
		?>
		</tbody>
	</table>
</div>
</form>
<script type="text/javascript">
function tanya(){
	var s = confirm("Apa anda yakin akan melanjutkan proses ini??");
	if(s == true)
		return true;
	else
		return false;
}
</script>
