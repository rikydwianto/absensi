<h1 class='page-head-line'>Data Sparepart Berbayar</h1>
<a href='<?php echo menu("tambah-sparepart&url=".url_ref())?>' class='btn btn-danger'><i class='fa fa-plus'></i> Sparepart</a>

<a href='<?php echo menu("pengambilan_sparepart&url=".url_ref()) ?>' class='btn'>Input ambilan Sparepart</a>
<a href='<?php echo menu("sparepart-no&url=".url_ref()) ?>' class='btn'>Aksesoris + Sparepart lainnya</a>
<div class='pull-right'>
	<form method=get>
		<input type=hidden name='mn' value='sparepart'/> 
		<input type=text name='cari' value='<?php echo @$_GET['cari'] ?>' placeholder='Cari Barang ...  '/> 
		<input type=submit name='kirim' value='Cari'>
	</form>
</div>
<br/>
<div class='clearfix'></div>
<table class='table' width="100%" border=1>
	<thead>
		<th>No.</th>
		<th>Nama Sparepart</th>
		<th>Stock</th>
		<th>harga</th>
		<th>Keterangan</th>
		<th>#</th>
	</thead>
	<tbody>
	<?php 
	$no=1;
	if(isset($_GET['cari'])){
		$cari=aman($_GET['cari']);
		$qtambah="and nama_sparepart like '%$cari%'";	
	}
	else{
		$qtambah='';
	}
	$q=mysql_query("select * from sparepart where berbayar='ya' $qtambah order by id_sparepart desc") or die(alert_error("Error : ".mysql_error()));
	while($sp=mysql_fetch_array($q)){
		$stock=$sp['stock_sparepart'];
		if($stock<1)
			$tr="class='danger'";
		else
			$tr="";
		?>
		<tr <?php echo $tr ?>>
			<td><?php echo $no ?></td>
			<td><?php echo $sp['nama_sparepart'] ?></td>
			<td><?php echo ($stock==NULL) ? 0 : $sp['stock_sparepart'] ?></td>
			<td><?php echo rupiah($sp['harga_sparepart']) ?></td>
			<td><?php echo $sp['keterangan_sparepart'] ?></td>
			<td>
				<a href="<?php echo menu("hapus-sparepart&id_sparepart=$sp[id_sparepart]&url=".url_ref()) ?>" onclick='return confirm("Hapus Item ini?")'><i class='fa fa-trash'></i></a> | 
				<a href="<?php echo menu("edit-sparepart&id_sparepart=$sp[id_sparepart]&url=".url_ref()) ?>" ><i class='fa fa-edit'></i></a> | 
				<a href='<?php echo menu("tambah-stock-sparepart&id_sparepart=$sp[id_sparepart]&url=".url_ref()) ?>' class='' title="Tambah Stock <?php echo $sp['nama_sparepart'] ?>"><i class='fa fa-plus'></i></a>
			</td>
		</tr>
		<?php
		$no++;
	}
	?>
	</tbody>
</table>