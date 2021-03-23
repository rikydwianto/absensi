<table class='table'>
	<thead>
		<tr>
			<th>No</th>
			<th>Satuan</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no=1;
		$q=mysql_query("select * from satuan order by id_satuan desc");
		while($Rsup=mysql_fetch_array($q))
		{
			?>
		<tr>
			<td><?php echo $no ?></td>
			<td><?php echo $Rsup['satuan'] ?></td>
			<td><?php echo $Rsup['keterangan_satuan'] ?></td>
			<td>
				<a href='<?php echo menu("satuan&act=edit&id_satuan=$Rsup[id_satuan]&url=".url_ref()) ?>'>Edit</a>
				<a href='<?php echo menu("satuan&act=hapus&id_satuan=$Rsup[id_satuan]&url=".url_ref()) ?>' onclick='return confirm("Yakin akan menghapusnya?")'>Hapus</a>
			</td>
		</tr>
			<?php
			$no++;
		}
		?>
	</tbody>
</table>