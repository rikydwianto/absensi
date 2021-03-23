<?php 
include"../config/setting.php";
include"../config/koneksi.php";
include"../fungsi/config.php";
$id= aman($_GET['id']);
$r=mysql_query("select * from absen where id_absen='$id'");
$r=mysql_fetch_object($r);

?>
Photo Absen Masuk
<?php 
if(!empty($r->gambarbase64))
{
?>	<img src='data/absen-cam/<?php echo $r->tanggal_absen ?>/<?php echo $r->gambarbase64 ?>' class='img' style='width:100%'/> 
<?php
}
?>
<?php 
if(!empty($r->gambarbase64_pulang))
{
	?>
	Photo Absen Keluar
	<img src='<?php echo str_replace('../','',$r->gambarbase64_pulang) ?>' class='img' style='width:100%'/> 	
	<?php
}
?>
<table>
	<tr>
		<td>Absen No </td>
		<td>#<?php echo $r->id_absen ?></td>
	</tr>
	<tr>
		<td>Tanggal</td>
		<td><?php echo $r->tanggal_absen ?></td>
	</tr>
	<tr>
		<td>Jam Masuk</td>
		<td><?php echo $r->keterangan_hadir ?> <?php echo $r->jam_masuk ?></td>
	</tr>
	<tr>
		<td>Jam Keluar</td>
		<td><?php echo $r->jam_keluar ?></td>
	</tr>
	<tr>
		<td>Telat</td>
		<td><?php echo $r->telat ?></td>
	</tr>
	<tr>
		<td>Lembur</td>
		<td><?php echo $r->lembur ?>[<?php echo $r->menit_lembur ?>]</td>
	</tr>
	<?php
	if(@$_SESSION['username']=='riky_ab'){
		?>
		<tr>
			<td>Dibuat</td>
			<td><?php echo $r->date_created ?></td>
		</tr>
		<tr>
			<td>Diedit</td>
			<td><?php echo $r->date_modified ?></td>
		</tr>
		<?php
	}
	?>
	
	<tr>
		<td>Keterangan</td>
		<td><?php echo $r->keterangan ?></td>
	</tr>
</table>


<a href='#' data-dismiss='modal' class='btn btn-danger pull-right'>Tutup</a>