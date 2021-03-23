<?php
$no=1;
$q=mysql_query("select * from suplier order by id_suplier desc");
while($Rsup=mysql_fetch_array($q))
{
	?>
<tr>
	<td><?php echo $no ?></td>
	<td><?php echo $Rsup['nama_suplier'] ?></td>
	<td><?php echo $Rsup['telepon_suplier'] ?></td>
	<td><?php echo $Rsup['alamat_suplier'] ?></td>
	<td><?php echo $Rsup['keterangan_suplier'] ?></td>
	<td>
		<a href='<?php echo menu("edit-suplier&id_suplier=$Rsup[id_suplier]&url=".url_ref()) ?>'>Edit</a>
		<a href='<?php echo menu("hapus-suplier&id_suplier=$Rsup[id_suplier]&url=".url_ref()) ?>' onclick='return confirm("Yakin akan menghapusnya?")'>Hapus</a>
	</td>
</tr>
	<?php
	$no++;
}