<section class="content-header">
  <h1>
    <?php echo $title ?>
    <small><?php echo $nm_aplikasi ?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Hamalan Awal</li>
  </ol>
</section>

<!-- Main content 
<section class="content">

  
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Halaman Awal</h3>
    </div>
    <div class="box-body">
      <img src='<?php echo url('assets/img/page-header.jpg') ?>' class='img img-responsive img-thumbnail'/>
		<div class="alert alert- alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4 class="page-header">Selamat datang</h4>
				Pada <?php echo $nm_aplikasi ?><br/>
		</div>
		

  </div>
</div>

</section>

-->
<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Log absen terbaru</h3>
      <small>Menampilkan 100 absen terbaru</small>
    </div>
    <div class="box-body">
    <table class='table' id='example2'>
	<thead>
      <tr>
        <th>NIK</th>
        <th>Nama</th>
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Jam Keluar</th>
        <th>Lembur</th>
        <th>Keterngan</th>
        <th></th>
      </tr>
	</thead>
	<tbody>
		<?php 
      $q = mysql_query("select * from absen join karyawan on karyawan.id_karyawan=absen.id_karyawan order by absen.date_modified,absen.date_created desc limit 0,100");
      echo mysql_error();
      while($absen  = mysql_fetch_array($q)){
       ?>
      <tr>
        <td><?php echo $absen['nik'] ?></td>
        <td><?php echo $absen['nama_lengkap'] ?></td>
        <td><?php echo $absen['tanggal_absen'] ?></td>
        <td><?php echo $absen['jam_masuk'] ?></td>
        <td><?php echo $absen['jam_keluar'] ?></td>
        <td><?php echo $absen['menit_lembur'] ?></td>
        <td><?php echo $absen['keterangan_hadir'] ?></td>
        <td>
			<a href='<?php echo url('index.php?mn=absen&act=edit&id_absen='.$absen['id_absen'].'&url='.url_ref()) ?>' class='btn btn-xs'><i class='fa fa-edit'></i> E</a>
		</td>
      </tr>
       <?php 
      }
       ?>
	</tbody>
    </table>
  </div>
</div>

</section>