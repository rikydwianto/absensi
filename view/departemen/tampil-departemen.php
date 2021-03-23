<?php 
include_once"fungsi/departemen.php";
?>
<section class="content-header">
  <h1>
    Departemen
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=departemen') ?>">Departemen</a></li>
    <li class="active">Tampil</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Departemen</h3>
    </div>
    <div class="box-body">
    	<div >
		<a href='<?php echo url('index.php?mn=tambah-departemen') ?>'   class='btn btn-info'><i class='fa fa-plus'></i> Tambah </a>
		<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
		<a href='<?php echo url('index.php?mn=tambah-departemen') ?>' class='btn btn-danger disabled'><i class='fa fa-file-pdf-o'></i> Export PDF </a>
		<a href='<?php echo url('laporan/departemen.php') ?>' class='btn btn-danger'><i class='fa fa-file-pdf-o'></i> Export Excel </a>
	</div>
	<br/>
	<div>
		<div class='table-responsive'>
		<table class='table table-responsive' id="example1">
			<thead>
				<tr>
					<th>ID.</th>
					<th>Kode Departemen</th>
					<th>Nama Departemen</th>
					<th>Deskripsi</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$q=tampil_departemen();
			while($r=mysql_fetch_object($q))
			{
				?>
				<tr>
					<td><?php echo $r->id_departemen ?></td>
					<td><?php echo $r->kode_departemen ?></td>
					<td><?php echo $r->nama_departemen ?></td>
					<td><?php echo $r->deskripsi_departemen ?></td>
					<td>
						<a href='<?php echo url('index.php?mn=edit-departemen&iddep='.$r->id_departemen.'&url='.url_ref())?>'><i class='fa fa-edit'></i></a>
						<a href='<?php echo url('index.php?mn=hapus-departemen&iddep='.$r->id_departemen.'&url='.(url_ref())) ?>'><i class='fa fa-times'></i></a>
					</td>
				</tr>
				<?php
			}
			?>
			</tbody>
			<tfoot>
				<tr>
					<th>ID.</th>
					<th>Kode Departemen</th>
					<th>Nama Departemen</th>
					<th>Deskripsi</th>
					<th>#</th>
				</tr>
			</tfoot>
		</table>
		</div>
    </div>

</section>