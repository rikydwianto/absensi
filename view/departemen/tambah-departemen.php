<?php include"fungsi/departemen.php"; ?>
<section class="content-header">
  <h1>
    Departemen
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=departemen') ?>">Departemen</a></li>
    <li class="active">Tambah</li>
  </ol>
</section>


<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Tambah Departemen</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
		<?php
		if(isset($_POST['tambah-dep']))
		{

		$kode=aman($_POST['kd_dep']);
		if(cari_depkode($kode)>0)
		{
			echo alert_error("duplikat kode departemen, Harap ganti kode departemen!");
		}
		else{
			$nama=aman($_POST['namadep']);
			$des=aman($_POST['des']);
			$input_departemen=tambah_departemen($kode,$nama,$des);
			if($input_departemen)
			{
				echo alert("Departemen Berhasi ditambahkan");
			}
			else
			{
				echo alert_error("Departemen, Gagal ditambahkan! Error : ".mysql_error());
			}
			
		}

		}
		?>
		<form method=post>
			<table class='table'>
				<tr>
					<td>Kode Departemen</td>
					<td><input class='form-control' required type=text name='kd_dep'/></td>
				</tr>
				<tr>
					<td>Nama Departemen</td>
					<td><input class='form-control' required type=text name='namadep'/></td>
				</tr>
				<tr>
					<td>Deskripsi</td>
					<td><textarea class='form-control' name='des'></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type=submit class='btn btn-info' value='Simpan' name='tambah-dep'/>
						<input type=reset class='btn btn-danger' value='Reset' />
					
					</td>
				</tr>
			</table>
		</form>
    </div>
	</div>
</section>

