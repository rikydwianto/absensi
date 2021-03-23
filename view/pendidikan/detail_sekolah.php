<?php //i ?>
<section class="content-header">
  <h1>
    Pendidikan
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=daftar_pendidikan') ?>">Pendidikan</a></li>
    <li class="active">Tampil</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Pendidikan</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
		
		<div class='table-responsive'>
			<table class='table'>
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Karyawan</th>
						<th>Tahun</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no=1;
					@$q=aman($_GET['sekolah']);
					$q=urldecode($q);
					$q=mysql_query("SELECT karyawan.id_karyawan,karyawan.nik,karyawan.nama_lengkap,riwayat_pendidikan.*
					FROM karyawan,riwayat_pendidikan WHERE
					karyawan.id_karyawan=riwayat_pendidikan.`id_karyawan` AND riwayat_pendidikan.nama_pendidikan LIKE '%$q%'") or die(alert_error(mysql_error()));
					while($rPen=mysql_fetch_object($q)){
						?>
						<tr>
							<td><?php echo $no ?></td>
							<td>
								<a href='<?php echo url('index.php?mn=detail_karyawan&id='.$rPen->id_karyawan."&nik=".$rPen->nik."&url=".url_ref())?>'>
								<?php echo $rPen->nama_lengkap ?>
								</a>
							</td>
							<td>
								<?php echo $rPen->thn_masuk ?>-<?php echo $rPen->thn_lulus ?>
							</td>
							<td>
								<?php echo $rPen->keterangan ?>
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
</section>