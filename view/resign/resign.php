<?php 
include_once"fungsi/resign.php";
include_once"fungsi/karyawan.php";
@$id=aman($_GET['id']);
$detail=detail_karyawan($id);
?>
<section class="content-header">
  <h1>
    Karyawan
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=karyawan') ?>">Karyawan</a></li>
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
				<table style='font-size:20px'>
					<tr>
						<td>NIK </td>
						<td>: </td>
						<td><?php echo $detail->nik ?></td>
					</tr>
					<tr>
						<td>Nama </td>
						<td>: </td>
						<td><?php echo $detail->nama_lengkap ?></td>
					</tr>
					<tr>
						<td>TTL</td>
						<td>: </td>
						<td><?php echo ($detail->tpt_lahir) ?> <?php echo tanggal($detail->tgl_lahir) ?></td>
					</tr>
					<tr>
						<td>Tanggal Masuk</td>
						<td>: </td>
						<td><?php echo tanggal($detail->tgl_masuk) ?></td>
					</tr>
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
							include"view/resign/tambah.php";
						break;
						case"edit":
							include"view/resign/edit.php";
						break;
						case"hapus":
							include"view/resign/hapus.php";
						break;
					}
				}
				//else
					//include"view/resign/tampil.php";
				
				?>
			</div>
		</div>
    </div>

</section>