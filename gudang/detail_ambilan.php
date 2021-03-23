<?php include_once"config/setting.php"; ?>
<?php include_once"config/koneksi.php"; ?>
<?php include_once"fungsi/config.php"; ?>
<?php
$id=get('id');
$q=mysql_query("select * from ambilan 
	join karyawan on karyawan.id_karyawan=ambilan.id_karyawan 
	join jabatan on jabatan.id_jabatan=karyawan.id_jabatan 
	join departemen on departemen.id_departemen=jabatan.id_departemen 
	where ambilan.id_ambilan_sp='$id' order by id_ambilan_sp desc");
	$no=1;
$ambilan=mysql_fetch_array($q);
?>
<style>
@page {
    size: 4cm 5cm;
   // margin: 30mm 45mm 30mm 45mm; 
}
titlepage {
  page: blank;
}
</style>
<center>
	<h1>DETAIL AMBILAN SPAREPART </h1>
	<h3>PT. LYDIA SOLA GRACIA</h3> <hr/>
</center>
<table  style='font-size:12px'>
	<tr>
		<td>
			<table>
				<tr>
					<td>NIK</td>
					<td>:</td>
					<td><?php echo $ambilan['nik'] ?></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td><?php echo $ambilan['nama_lengkap'] ?></td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td>:</td>
					<td><?php echo tanggal($ambilan['tanggal_ambilan']) ?></td>
				</tr>
				<tr>
					<td>Waktu</td>
					<td>:</td>
					<td><?php echo waktu($ambilan['date_created']) ?></td>
				</tr>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<td>Departemen</td>
					<td>:</td>
					<td><?php echo $ambilan['nama_departemen'] ?></td>
				</tr>
				<tr>
					<td>Jabatan</td>
					<td>:</td>
					<td><?php echo $ambilan['nama_jabatan'] ?></td>
				</tr>
					<tr>
					<td>Status</td>
					<td>:</td>
					<td>
						<?php echo strtoupper($ambilan['status_ambilan']) ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

</table> <br/>
<table border=1 style='width:100%;border-collapse:collapse'>
	<thead>
		<tr>
			<th>NO</th>
			<th>SPAREPART</th>
			<th>QTY</th>
			<th>HARGA</th>
			<th>TOTAL</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$qambilan=mysql_query("select * from detail_ambilan_sp join sparepart on detail_ambilan_sp.id_sparepart=sparepart.id_sparepart where detail_ambilan_sp.id_ambilan_sp='$id'");
	$koma=array();
	$no=1;
	while($Rdetail=mysql_fetch_array($qambilan)){
		$total[]=$Rdetail['harga_ambilan'] * $Rdetail['qty_ambilan'];
		?>
		<tr>
			<td><?php echo $no ?></td>
			<td><?php echo $Rdetail['nama_sparepart'] ?></td>
			<td><?php echo $Rdetail['qty_ambilan'] ?></td>
			<td><?php echo rupiah($Rdetail['harga_ambilan']) ?></td>
			<td><?php echo rupiah($Rdetail['harga_ambilan'] * $Rdetail['qty_ambilan']) ?></td>
		</tr>
		<?php
		
	}
	@$gabung=implode("<br/>",$koma);
	@$sumtotal=array_sum($total);
	?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan=4>TOTAL HARGA</td>
			<td><?php echo rupiah($sumtotal) ?></td>
		</tr>
	</tfoot>
</table>
<img src='<?php echo url("data/foto-ambilan/$ambilan[tanggal_ambilan]/$ambilan[photo_ambilan]") ?>' style='width:100%'/>