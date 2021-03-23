<?php include"fungsi/karyawan.php"; 
error_reporting(0);
?>
<section class="content-header">
  <h1>
    Log History
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=log') ?>">Log History</a></li>

  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Log History</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
		<div class='table-responsive'>
			<table id='example1' class='table'>
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Act Name</th>
						<th>Waktu</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$no=1;
				$q=mysql_query("select * from record order by date_created desc");
				while($r=mysql_fetch_object($q))
				{
					$detail=detail_karyawan($r->id_karyawan);
					$act=detail_karyawan($r->id_karyawan_input);
					?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $detail->nama_lengkap ?></td>
						<td><?php echo $act->nama_lengkap ?></td>
						<td><?php echo waktu($r->waktu.$r->tanggal)?></td>
						<td><?php echo $r->keterangan ?></td>
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