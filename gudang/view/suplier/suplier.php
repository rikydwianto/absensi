<h1 class='page-head-line'>Suplier</h1>
<a href='<?php echo menu('tambah-suplier') ?>' class='btn btn-danger'><i class='fa fa-plus'></i> Tambah</a>
<a href='' class='btn btn-info'><i class='fa fa-refresh'></i> Reload</a>
<table class='table'>
	<thead>
		<tr>
			<th>No</th>
			<th>Suplier</th>
			<th>Telepon</th>
			<th>Alamat</th>
			<th>Keterangan</th>
			<th>#</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if(isset($_GET['act']))
		{
			$menu=aman($_GET['act']);
			if($menu=='tambah')
				include"view/suplier/tambah.php";
			else if($menu=='hapus')
				include"view/suplier/hapus.php";
			else if($menu=='edit')
				include"view/suplier/edit.php";
		}
		else
			include"view/suplier/tampil.php";
		?>
	</tbody>
</table>