<?php 
include_once"fungsi/absen-absen.php";
include_once"fungsi/karyawan.php";
include_once"fungsi/departemen.php";
include_once"fungsi/jabatan.php";
$breadcrumd=$_GET['mn'];
$kemarin = date("d/m/Y",strtotime('-1 day'));
$kemarin = urlencode($kemarin);
?>
<section class="content-header">
  <h1>
    Absen
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Absen</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Absen </h3>
		</div>
		<div class="box-body">
			<div >
			<?php 
			if(isset($_GET['tgl']))
			{
				@$tgl_="?tgl=".ubah_tanggal($_GET['tgl']);
			}
			else
				$tgl_="?tgl=".(date("Y-m-d"));
			?>
				<a href='<?php echo url('index.php?mn=absen&tgl='.$kemarin."&cr=Cari") ?>' class='btn btn-info btn-flat'><i class='fa fa-calendar-o'></i> Kemarin </a>
				<a href='<?php echo url('index.php?mn=absen') ?>' class='btn btn-info btn-flat'><i class='fa fa-calendar-o'></i> Hari ini </a>
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary btn-flat'><i class='fa fa-refresh'></i> Reload </a>
				<a href='<?php echo url('laporan/absen_hari.php'.$tgl_)?>' class='btn btn-danger btn-flat'><i class='fa fa-file-excel-o'></i> Export </a>
			</div>
			<br/>
			<div>
				<!-- ISI WEB -->
				<?php 
				if(isset($_GET['act']))
				{
					switch($_GET['act'])
					{
						default:
							include"view/error/404biasa.php";
						break;
						
						case"setting":
							include"view/absen/lembur-setting.php";
						break;
						case"edit":
							include"view/absen/edit_absen.php";
						break;
						case"hapus_absen":
							@$id=$_GET['id_absen'];
							mysql_query("delete from absen where id_absen='$id'");
							echo alert("Telah dihapus ");	
							direct(($_GET['url']));
						break;
					}
				}
				else
					include"view/absen/data-absen.php";
				
				?>
			</div>
		</div>
    </div>

</section>