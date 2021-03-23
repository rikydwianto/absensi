<?php include"fungsi/departemen.php"; ?>
<?php 
$id=aman($_GET['iddep']);
$r=cari_dep($id);
?>

	
<section class="content-header">
  <h1>
    Departemen
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=departemen') ?>">Departemen</a></li>
    <li class="active">Edit</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Edit Departemen</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
	<?php
	if(isset($_POST['edit-dep']))
	{
		$id=aman($_POST['id_departemen']);
		$kode=aman($_POST['kode_departemen']);
		$nama=aman($_POST['nama_departemen']);
		$deskripsi_departemen=aman($_POST['deskripsi_departemen']);
		$kode=aman($_POST['kode_departemen']);
		if($r->kode_departemen!=$kode)
		{
			if(cari_depkode($kode)>0)
			{
				echo alert_error("duplikat kode departemen, Harap ganti kode departemen!");
			}
			else
			{
				$edit_departemen=edit_dep($id,$kode,$nama,$deskripsi_departemen);
			}
		}
		else{
			$edit_departemen=edit_dep($id,$kode,$nama,$deskripsi_departemen);
		}
		
		if(@$edit_departemen)
			{
				echo alert("Departemen Berhasi Diedit");
			}
			else
			{
				echo alert_error("Departemen, Gagal diedit! Error : ".mysql_error());
			}

	}
	?>
		
		<form method=post>
			<table class='table'>
				<tr>
					<td>Kode Departemen</td>
					<td>
						<input class='form-control' value='<?php echo $r->kode_departemen ?>' type=text name='kode_departemen'/>
						<input class='form-control' value='<?php echo $r->id_departemen ?>' type=hidden name='id_departemen'/>
					</td>
				</tr>
				<tr>
					<td>Nama Departemen</td>
					<td><input class='form-control' value='<?php echo $r->nama_departemen ?>' type=text name='nama_departemen'/></td>
				</tr>
				<tr>
					<td>Deskripsi</td>
					<td><textarea class='form-control' name='deskripsi_departemen'><?php echo $r->deskripsi_departemen?></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type=submit class='btn btn-info' value='Simpan' name='edit-dep'/>
						<input type=reset class='btn btn-danger' value='Reset' />
					
					</td>
				</tr>
			</table>
		</form>
    </div>
	</div>
</section>