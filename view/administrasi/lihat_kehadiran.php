<?php 
$ket=($ket=='sakit') ? 'skd' : $ket;
?>
<table class='' style='width:100%' border=1>
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Dept - Jabatan</th>
			<th></th>
			<th>Edit Absen</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$no=1;
		$q=mysql_query("select * from absen join karyawan on karyawan.id_karyawan=absen.id_karyawan 
		join jabatan on jabatan.id_jabatan=karyawan.id_jabatan 
		join departemen on departemen.id_departemen=jabatan.id_departemen 
		where keterangan_hadir='$ket' and tanggal_absen='$tgl'") or die(alert_error("Query Error : ". mysql_error()));
		while($Rhadir=mysql_fetch_array($q))
		{
			$cek=mysql_query("select * from sakit where tanggal_sakit='$tgl' and id_karyawan='$Rhadir[id_karyawan]'");
			?>
		<tr>
			<td><?php echo $no ?></td>
			<td><?php echo $Rhadir['nama_lengkap'] ?></td>
			<td><?php echo $Rhadir['nama_departemen'] ?> - <?php echo $Rhadir['nama_jabatan'] ?></td>
			<td>
			<?php 
			if($ket!='skd')
			{
				echo $Rhadir['keterangan'];
			}
			else
			{
				if(!mysql_num_rows($cek)){
					?>
					<a href='<?php echo url("index.php?mn=administrasi&act=tambah_biaya&tgl=$tgl&id=$Rhadir[id_karyawan]&url=".url_ref()) ?>' class='btn btn-success'>Input Harga</a>
					<?php
				}
				else
				{
					$r=mysql_fetch_array($cek);
					?>
					<a href='<?php echo url("index.php?mn=administrasi&act=edit&id=$r[id_sakit]&url=".url_ref()) ?>' class='btn btn-info btn-flat'><i class='fa fa-edit'></i></a>
					<?php
				}
			}
			?>
			</td>
			<td>
				<a href='<?php echo url('index.php?mn=absen&act=edit&id_absen='.$Rhadir['id_absen'].'&url='.url_ref()) ?>' target=_blank>Edit</a>
			</td>
		</tr>
		<?php
		if(mysql_num_rows($cek))
		{
			?>
		<tr>
			<td colspan=5>
			<?php 
			echo "NO SKD : ". $r['no_surat_sakit'].' </br>';
			echo "Keterangan : ". $r['keterangan_sakit'].' </br>';
			echo "Total : ". $r['total_berobat'];
			?>
			</td>
		</tr>
			<?php
		}
			$no++;
		}
		?>
	</tbody>
</table>
