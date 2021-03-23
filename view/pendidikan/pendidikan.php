<?php 
include_once"fungsi/pendidikan.php";
include_once"fungsi/karyawan.php";
@$id=aman($_GET['id']);
$pendidikan=tampil_pendidikan($id);
?>
<section class="content-header">
  <h1>
    <br/>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=keluarga') ?>">Keluarga</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">penndidikan</h3>
		</div>
		<div class="box-body">
			<div >
			<?php 
			if(isset($_GET['url']))
				$url=urldecode($_GET['url']);
			else
				$url=url('index.php?mn=karyawan');
			?>
				<a href='<?php echo $url ?>'   class='btn btn-success'><i class='fa fa-angle-double-left'></i> Kembali </a>
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
			</div>
			<br/>
			<div>
				<!-- ISI WEB -->
				<div class='table-responsive'>
					<table class="table table-hover table-striped table-responsive" style='width:100%'>
						<thead>
							<tr>
								<th>Pendidikan</th>
								<th>Alamat</th>
								<th >Tahun Masuk</th>
								<th>Tahun Keluar</th>
								<th>Keterangan</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php 
						if(mysql_error())
							echo alert(mysql_error());
						while($pen=mysql_fetch_object($pendidikan))
						{
							?>
						<tr>
							<td><?php echo $pen->nama_pendidikan ?></td>
							<td><?php echo $pen->alamat_pendidikan ?></td>
							<td><?php echo ($pen->thn_masuk) ?></td>
							<td><?php echo ($pen->thn_lulus) ?></td>
							<td><?php echo $pen->keterangan ?></td>
							<td>
								<a href='<?php echo url("index.php?mn=pendidikan&act=edit&id_pend=$pen->id_riwayat_pendidikan&id=$id&url=".url_ref()) ?>' class=''><i class='fa fa-edit'></i> </a>
								<a href='<?php echo url("index.php?mn=pendidikan&act=hapus&id_pend=$pen->id_riwayat_pendidikan&id=$id&url=".url_ref()) ?>'><i class='fa fa-times'></i> </a>

							</td>
							
						</tr>
							
							<?php											
						}
						?>
							
						</tbody>
					</table>
				</div>
				<?php 
				if(isset($_GET['act']))
				{
					switch($_GET['act'])
					{
						default:
							include"view/error/404biasa.php";
						break;
						
						case"tambah":
							include"view/pendidikan/tambah.php";
						break;
						case"edit":
							include"view/pendidikan/edit.php";
						break;
						case"hapus":
							include"view/pendidikan/hapus.php";
						break;
					}
				}
				else
					include"view/pendidikan/tampil.php";
				
				?>
			</div>
		</div>
    </div>

</section>