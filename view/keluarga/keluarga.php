<?php 
include_once"fungsi/keluarga.php";
include_once"fungsi/karyawan.php";
@$id=aman($_GET['id']);
$keluarga=tampil_keluarga($id);
?>
<section class="content-header">
  <h1>
    keluarga
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=keluarga') ?>">keluarga</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">keluarga</h3>
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
				<table class="table table-hover table-striped table-responsive" style='width:100%'>
					<thead>
						<tr>
							<th>Nama Lengkap</th>
							<th>Tanggal Lahir</th>
							<th >Status</th>
							<th>Pekerjaan</th>
							<th>Catatan</th>
							<th>#</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					if(mysql_error())
						echo alert(mysql_error());
					while($kel=mysql_fetch_object($keluarga))
					{
						?>
					<tr>
						<td><?php echo $kel->nama_lengkap ?></td>
						<td><?php echo tanggal($kel->tgl_lahir) ?></td>
						<td><?php echo $kel->status ?></td>
						<td><?php echo $kel->pekerjaan ?></td>
						<td><?php echo $kel->catatan ?></td>
						<td>
							<a href='<?php echo url("index.php?mn=keluarga&act=edit&id_kel=$kel->id_keluarga&id=$id&url=".url_ref()) ?>'><i class='fa fa-edit'></i> </a>
							<a href='<?php echo url("index.php?mn=keluarga&act=hapus&id_kel=$kel->id_keluarga&id=$id&url=".url_ref()) ?>'><i class='fa fa-times'></i> </a>
						</td>
						
					</tr>
						
						<?php											
					}
					?>
						
					</tbody>
				</table>
				<?php 
				if(isset($_GET['act']))
				{
					switch($_GET['act'])
					{
						default:
							include"view/error/404biasa.php";
						break;
						
						case"tambah":
							include"view/keluarga/tambah.php";
						break;
						case"edit":
							include"view/keluarga/edit.php";
						break;
						case"hapus":
							include"view/keluarga/hapus.php";
						break;
					}
				}
				else
					include"view/keluarga/tampil.php";
				
				?>
			</div>
		</div>
    </div>

</section>