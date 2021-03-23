<?php 
include_once"fungsi/absen-absen.php";
include_once"fungsi/karyawan.php";
include_once"fungsi/departemen.php";
include_once"fungsi/jabatan.php";
$breadcrumd=$_GET['mn'];
$kemarin = date("d/m/Y",strtotime('-1 day'));
$kemarin = urlencode($kemarin);
$tgl=$_GET['tgl'];
$id=$_GET['id'];
$karyawan=detail_karyawan($id);
?>
<section class="content-header">
  <h1>
    Absen Karyawan
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Absen Karyawan</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Absen Karyawan </h3>
		</div>
		<div class="box-body">
			<div >
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary btn-flat'><i class='fa fa-refresh'></i> Reload </a>
			</div>
			<br/>
			<div>
				<div class='col-md-5'>
					<table class='table'>
						<tr>
							<td>NIK</td>
							<td><?php echo $karyawan->nik ?></td>
						</tr>
						<tr>
							<td>Nama</td>
							<td><?php echo $karyawan->nama_lengkap ?></td>
						</tr>
						<tr>
							<td>Tanggal</td>
							<td><?php echo tanggal($tgl) ?></td>
						</tr>
					</table>
				</div>
				<div class='clearfix'></div>

			<!-- ISI WEB -->
			<?php
			$qq="select * from absen where tanggal_absen='$tgl' and id_karyawan='$id' ";
			$qq=mysql_query($qq);
			echo mysql_error();
			$no=1;
			if(mysql_num_rows($qq)){
				echo "<table class='table'>";
				while($absen = mysql_fetch_array($qq)){
					?>
					<tr>
						<td><?php echo $no ?>. </td>
						<td><?php echo $absen['jam_masuk'] ?></td>
						<td><?php echo $absen['jam_keluar'] ?></td>
						<td><?php echo $absen['keterangan_hadir'] ?></td>
						<td><?php echo $absen['keterangan'] ?></td>
						<td>
							<a href='<?php echo url('index.php?mn=absen&act=edit&id_absen='.$absen['id_absen'].'&url='.url_ref()) ?>' class='btn btn-info'><i class='fa fa-edit'></i> EDIT</a>
							<a href='<?php echo url('index.php?mn=absen&act=hapus_absen&id_absen='.$absen['id_absen'].'&url='.url_ref()) ?>' class='btn btn-danger'><i class='fa fa-remove'></i> HAPUS</a>
						</td>
					</tr>
					<?php
					$no++;
				}
				echo "</table>";
			}
			else
			{
				?>
				<h2>Belum Ada Absen pada tanggal <?php echo tanggal($tgl)?>, Berikan keterangan : </h2>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=&id=$id&tanggal=$tgl&url=".url_ref()) ?>' class='btn bg-blue btn-flat '>MASUK</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=skd&id=$id&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-success btn-flat '>SAKIT</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=izin&id=$id&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-info btn-flat '>IZIN</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=alfa&id=$id&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-danger btn-flat '>ALFA</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=libur&id=$id&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-danger btn-flat '>LIBUR</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=pulang&id=$id&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-info btn-flat '>Setengah Hari(IZIN)</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=pulang_libur&id=$id&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-info btn-flat '>Setengah Hari(Libur)</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=spd&id=$id&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-danger btn-flat '>SPD</a>
				<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=out&id=$id&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-danger btn-flat '>OUT</a>

				<?php
			}
			?>
			<div class='clearfix'></div>
			NOTE : Menghapus absen berarti menjadikan tidak absen/libur
			</div>
		</div>
    </div>

</section>