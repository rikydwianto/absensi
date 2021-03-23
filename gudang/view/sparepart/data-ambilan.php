<?php 
$tgl1 =(isset($_GET['tgl']) ? $_GET['tgl'] : date("d/m/Y"));
$tgl = (ubah_tanggal($tgl1));
?>
<h1 class='page-head-line'>Data Ambilan</h1>
<h3>Tanggal : <?php echo tanggal($tgl);?></h3>
<form method=get>
	<input type=hidden name='mn' value='data-sparepart'/>
	<input type=text name='tgl' value='<?php echo $tgl1 ?>' id='tgl'/>
	<input type=submit value='Lihat'>
</form>
<table class='table'>
	<thead>
		<tr>
			<th>NO</th>
			<th>NIK</th>
			<th>NAMA</th>
			<th>Departmen - Jabatan</th>
			<th>Ambilan</th>
			<th>Ket</th>
			<th>#</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	
	
	$q=mysql_query("select * from ambilan 
	join karyawan on karyawan.id_karyawan=ambilan.id_karyawan 
	join jabatan on jabatan.id_jabatan=karyawan.id_jabatan 
	join departemen on departemen.id_departemen=jabatan.id_departemen 
	where tanggal_ambilan='$tgl' order by id_ambilan_sp desc");
	$no=1;
	while($ambilan=mysql_fetch_array($q)){
	?>
		<tr > 
			<td><?php echo $no ?></td>
			<td><?php echo $ambilan['nik'] ?></td>
			<td><?php echo $ambilan['nama_lengkap'] ?></td>
			<td><?php echo $ambilan['nama_departemen'] ?> - <?php echo $ambilan['nama_jabatan'] ?></td>
			<td>
				<?php 
				$qambilan=mysql_query("select * from detail_ambilan_sp join sparepart on detail_ambilan_sp.id_sparepart=sparepart.id_sparepart where detail_ambilan_sp.id_ambilan_sp='$ambilan[id_ambilan_sp]'");
				$koma=array();
				while($Rdetail=mysql_fetch_array($qambilan)){
					$koma[]=$Rdetail['nama_sparepart'].' X '.$Rdetail['qty_ambilan'];
					$total[]=$Rdetail['harga_ambilan'] * $Rdetail['qty_ambilan'];
				}
				@$gabung=implode("<br/>",$koma);
				@$sumtotal=array_sum($total);
				?>
				<a href='#' onclick='detail_ambilan(<?php echo $ambilan['id_ambilan_sp'] ?>)'><i style='font-size:10px'><?php echo $gabung; ?></i></a>
			</td>
			<td><?php echo $ambilan['status_ambilan'] ?></td>
			<td>
				<a href='javascript:void(0)' onclick='detail_ambilan(<?php echo $ambilan['id_ambilan_sp'] ?>)'>Detail</a>
				<a href='javascript:void(0)' >Edit</a>
				<a href='#<?php echo menu("hapus-ambilan&id_ambilan=$ambilan[id_ambilan_sp]&url=".url_ref()) ?>' >Hapus</a>
			</td>
		</tr>
	<?php
	$no++;
	}
	?>
	</tbody>
</table>
<hr/>
<h2>Keterangan Stok + Harga Sparepart</h2>
<table border=1>
	<thead>
		<tr>
			<th>NO</th>
			<th>SPAREPART</th>
			<th>QTY</th>
			<th>PENGGUNAAN</th>
			<th>HARGA</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$nospare=1;
	$qspare=mysql_query("select * from sparepart where berbayar='ya' order by nama_sparepart asc");
	while($rspare=mysql_fetch_array($qspare)){
		$penggunaan=mysql_query("select sum(qty_ambilan) as total from detail_ambilan_sp 
		join ambilan on ambilan.id_ambilan_sp=detail_ambilan_sp.id_ambilan_sp 
		where id_sparepart='$rspare[id_sparepart]' and ambilan.tanggal_ambilan='$tgl' and (ambilan.status_ambilan='sukses' or ambilan.status_ambilan='retur')");
		echo mysql_error();
		$penggunaan=mysql_fetch_array($penggunaan);
		?>
		<tr>
			<td><?php echo $nospare ?></td>
			<td><?php echo $rspare['nama_sparepart'] ?></td>
			<td><?php echo $rspare['stock_sparepart'] ?></td>
			<td><?php echo $penggunaan['total'] ?></td>
			<td><?php echo rupiah($rspare['harga_sparepart']) ?></td>
		</tr>
		<?php
		$nospare++;
	}
	?>
	</tbody>
</table>
<script>
function detail_ambilan(id){
	 var myWindow = window.open(laman + "detail_ambilan.php?id=" + id, "", "width=500,height=700,resizable=no,scrollbars=yes,toolbar=no,menubar=no");
}
</script>