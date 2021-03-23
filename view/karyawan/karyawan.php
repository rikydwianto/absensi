<?php 
include_once"fungsi/departemen.php";
include_once"fungsi/jabatan.php";
include_once"fungsi/karyawan.php";
$breadcrumd=$_GET['mn'];
?>
<section class="content-header">
  <h1>
    Karyawan
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Karyawan</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Karyawan</h3>
		</div>
		<div class="box-body">
			<div >
				<a href='<?php echo url('index.php?mn='.$breadcrumd) ?>'   class='btn btn-success'><i class='fa fa-eye'></i> Tampilkan </a>
				<a href='<?php echo url('index.php?mn='.$breadcrumd.'&act=tambah') ?>'   class='btn btn-info'><i class='fa fa-plus'></i> Tambah </a>
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
				<a href='<?php echo url('index.php?mn=tambah-departemen') ?>' class='btn btn-danger disabled'><i class='fa fa-file-pdf-o'></i> Export PDF </a>
				<a href='<?php echo url('laporan/karyawan.php') ?>' class='btn btn-danger '><i class='fa fa-file-excel-o'></i> Export Excel </a>
			</div>
			<br/>
			<div>
			<form action="<?php echo url('index.php?mn=karyawan') ?>" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="hidden" name="mn" value='karyawan' >
              <input type="text" name="q" class="form-control" value='<?php echo aman(@$_GET['q']) ?>' placeholder="Nik/Nama Lengkap/Nama Panggilan Karayawan ...">
              <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
				<!-- ISI WEB -->
				<?php 
				if(isset($_GET['act']))
				{
					switch($_GET['act'])
					{
						default:
							include"view/error/404biasa.php";
						break;
						
						case"tambah":
							include"view/karyawan/tambah.php";
						break;
						case"edit":
							include"view/karyawan/edit.php";
						break;
						case"hapus":
							include"view/karyawan/hapus.php";
						break;
						case"edit_jabatan":
							include"view/karyawan/edit_jabatan.php";
						break;
					}
				}
				else
					include"view/karyawan/tampil.php";
				
				?>
			</div>
		</div>
    </div>

</section>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Peringatan!</h4>
      </div>
      <div class="modal-body">
        Apakah anda yakin akan menghapus Karyawan :  <b id='nama_karyawan'>Nama Karyawan</b> ????
		<input type=hidden id='id_kar' />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="button" id='klik_hapus' class="btn btn-primary btn-flat">Hapus</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Informasi</h4>
      </div>
      <div class="modal-body">
        <center>
			<i class='fa fa-check fa-4x'></i><br/>
			<h2>Berhasil Dihapus</h2>
			<h4 id='error'></h4>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" id='klik_oke' class="btn btn-default" data-dismiss="modal">Oke</button>
      </div>
    </div>
  </div>
</div>