<?php 
include_once"fungsi/resign.php";
include_once"fungsi/karyawan.php";
@$id=aman($_GET['id']);
$detail=detail_karyawan($id);
?>
<section class="content-header">
  <h1>
    <br/>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=karyawan') ?>">Daftar Resign</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Data Resign</h3>
		</div>
		<div class="box-body">
			<div >
			<?php 
				$url=url('index.php?mn=karyawan');
			?>
				<a href='<?php echo $url ?>' class='btn btn-success'><i class='fa fa-plus'></i> Tambah </a>
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
			</div>
			<br/>
			<div>
				<!-- ISI WEB -->
				<div class='table-responsive'>
					<table class='table table-hovered table-border'>
						<thead>
							<tr>
								<th>No</th>
								<th>NIK</th>
								<th>Nama</th>
								<th>Resign</th>
								<th>Ket</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$no=1;
						$q=mysql_query("select karyawan.nama_lengkap,karyawan.nik,karyawan.id_karyawan, resign.* 
						from karyawan, resign where karyawan.id_karyawan=resign.id_karyawan and status_karyawan=5 order by id_resign desc") or die(alert_error(mysql_error()));
						while($resign=mysql_fetch_object($q))
						{
							?>
							<tr>
								<td><?php echo $no ?></td>
								<td><?php echo $resign->nik?></td>
								<td><?php echo $resign->nama_lengkap?></td>
								<td><?php echo tanggal($resign->tanggal_resign)?></td>
								<td><?php echo $resign->keterangan?></td>
								<td>
									<a class='btn btn-flat btn-info' id='loading' onclick="Fdetail('<?php echo $resign->id_resign ?>')">Detail</a>
								</td>
							</tr>
							<?php
							$no++;
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
    </div>

</section>
<!-- Modal -->
<div class="modal fade" id="Dmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail Resign </h4>
      </div>
      <div class="modal-body">
		<div id='detail_modal'></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-flat" data-dismiss="modal">OKE</button>
      </div>
    </div>
  </div>
</div>