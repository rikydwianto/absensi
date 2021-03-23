<table class='table'>
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Buyer</th>
			<th>Instansi/Lembaga</th>
			<th>Telepon</th>
			<th>Alamat</th>
			<th>Keterangan</th>
			<th>#</th>
		</tr>
	</thead>
	<tbody>
<?php
$no=1;
$q=mysql_query("select * from buyer order by id_buyer desc");
while($Rsup=mysql_fetch_array($q))
{
	?>
<tr>
	<td><?php echo $no ?></td>
	<td><?php echo $Rsup['nama_buyer'] ?></td>
	<td><?php echo $Rsup['instansi_buyer'] ?></td>
	<td><?php echo $Rsup['telepon_buyer'] ?></td>
	<td><?php echo $Rsup['alamat_buyer'] ?></td>
	<td><?php echo $Rsup['keterangan_buyer'] ?></td>
	<td>
		<a href='<?php echo menu("buyer&act=edit&id_buyer=$Rsup[id_buyer]&url=".url_ref()) ?>'> Edit</a> | 
		<a href='<?php echo menu("buyer&act=style&id_buyer=$Rsup[id_buyer]&url=".url_ref()) ?>'> Style</a> | 
		<a href='<?php echo menu("buyer&act=hapus&id_buyer=$Rsup[id_buyer]&url=".url_ref()) ?>' onclick='return confirm("Yakin akan menghapusnya?")'>Hapus</a>
	</td>
</tr>
	<?php
	$no++;
} ?>
	</tbody>
</table>