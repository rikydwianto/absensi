<h1 class='page-head-line'>Data Sparepart dan Sparepart lainnya</h1>
<a href='<?php echo menu("tambah-sparepart&no=ya")?>' class='btn btn-danger'><i class='fa fa-plus'></i> Aksesoris</a>
<a href='<?php echo menu("sparepart") ?>' class='btn'>Sparepart</a>

<div class='pull-right'>
	<form method=get>
		<input type=hidden name='mn' value='sparepart-no'/> 
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
		<th>Keterangan</th>
		<th>Kurang</th>
		<th>Tambah</th>
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
	$q=mysql_query("select * from sparepart where berbayar='tidak' $qtambah order by id_sparepart desc") or die(alert_error("Error : ".mysql_error()));
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
			<td><?php echo $sp['keterangan_sparepart'] ?></td>
			<td>
				<a href='<?php echo menu("penggunaan-sparepart&id_sparepart=$sp[id_sparepart]&url=".url_ref()) ?>'  title="Input penggunaan <?php echo $sp['nama_sparepart'] ?>"><center><i class='fa fa-minus fa-sm'></i></center></a>
			</td>
			<td>
				<a href='<?php echo menu("tambah-stock-sparepart&id_sparepart=$sp[id_sparepart]&url=".url_ref()) ?>' class='' title="Tambah Stock <?php echo $sp['nama_sparepart'] ?>"><center><i class='fa fa-plus fa-sm'></i></center></a>
			</td>
			<td>
				<a href="<?php echo menu("hapus-sparepart&id_sparepart=$sp[id_sparepart]&url=".url_ref()) ?>" onclick='return confirm("Hapus Item ini?")'><i class='fa fa-trash'></i></a> | 
				<a href="<?php echo menu("edit-sparepart&id_sparepart=$sp[id_sparepart]&url=".url_ref()) ?>" ><i class='fa fa-edit'></i></a> | 
			</td>
		</tr>
		<?php
		$no++;
	}
	?>
	</tbody>
</table>