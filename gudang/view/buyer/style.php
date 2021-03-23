<?php 
$id=get("id_buyer");
$q=mysql_query("select * from buyer where id_buyer='$id'");
$r=mysql_fetch_array($q);
?>
<h1>Style</h1>
<div class='clearfix'></div>
<div class='col-sm-4'>
	<table class='table' >
		<tr>
			<td>Nama Buyer</td>
			<td><?php echo $r['nama_buyer'] ?></td>
		</tr>
		<tr>
			<td>Instansi</td>
			<td><?php echo $r['instansi_buyer'] ?></td>
		</tr>
		<tr>
			<td>Telepon</td>
			<td><?php echo $r['telepon_buyer'] ?></td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td><?php echo $r['alamat_buyer'] ?></td>
		</tr>
	</table>
</div>
<div class='clearfix'></div>
<table class='table'>
	<thead>
		<tr>
			<th>No</th>
			<th>Kode Style</th>
			<th>Nama Style</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$no=1;
	$q=mysql_query("select * from style where id_buyer='$id'");
	while($r=mysql_fetch_array($q))
	{
		?>
		<tr>
			<td><?php echo $no ?></td>
			<td><?php echo $r['kode_style'] ?></td>
			<td><?php echo $r['nama_style'] ?></td>
			<td><?php echo $r['keterangan_style'] ?></td>
		</tr>
		<?php
	}
	?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan=4>
				<a href='<?php echo menu("buyer&act=tambah-style&id_buyer=$id&url=".url_ref()) ?>'>Tambah</a>
			</th>
		</tr>
	</tfoot>
</table>