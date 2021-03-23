<div class='table-responsive'>
		<table class='table table-responsive' id="exaample1">
			<thead>
				<tr>
					<th>ID.</th>
					<th>Kode Jabatan</th>
					<th>Jabatan</th>
					<th>Deskripsi</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$Qdep=tampil_departemen();
			while($dep=mysql_fetch_object($Qdep))
			{
				?>
				<tr>
					<th colspan=5><?php echo $dep->nama_departemen ?></th>
				</tr>
				<?php 
				$q=jabatan_departemen($dep->id_departemen);
				while($r=mysql_fetch_object($q))
				{
					$dep=cari_dep($r->id_departemen);
					?>
					
					<tr>
						<td><?php echo $r->id_jabatan ?></td>
						<td><?php echo $r->kode_jabatan ?></td>
						<td><?php echo $r->nama_jabatan?></td>
						<td><?php echo ($r->deskripsi_jabatan) ?></td>
						<td>
							<a href='<?php echo url('index.php?mn=jabatan&act=edit&id='.$r->id_jabatan.'&url='.url_ref())?>'><i class='fa fa-edit'></i></a>
							<a href='<?php echo url('index.php?mn=jabatan&act=hapus&id='.$r->id_jabatan.'&url='.(url_ref())) ?>'><i class='fa fa-times'></i></a>
						</td>
					</tr>
					<?php
				}
				?>
				<?php
			}
			?>
			</tbody>
			<tfoot>
				<tr>
					<th>ID.</th>
					<th>Kode Jabatan</th>
					<th>Jabatan</th>
					<th>Deskripsi</th>
					<th>#</th>
				</tr>
			</tfoot>
		</table>
		</div>