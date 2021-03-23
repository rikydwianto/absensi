<?php 
error_reporting(0);
include_once"fungsi/departemen.php";
include_once"fungsi/jabatan.php";
include_once"fungsi/karyawan.php";
include_once"fungsi/keluarga.php";
include_once"fungsi/pendidikan.php";
include_once"fungsi/pengalaman.php";
$breadcrumd="karyawan";
?>
<?php 
if(!isset($_GET['nik']) || !isset($_GET['nik']))
{
  echo alert_error("Maaf Tidak tersedia!");
	direct(urldecode($_GET['url']));

}
$karyawan=detail_karyawan(aman($_GET['id']));
if(mysql_error()){
	echo alert("Error : ". mysql_error());
}
$karyawan=$karyawan;


if($karyawan->tgl_keluar==null)
	$tgl=date("Y-m-d");
else
	$tgl=$karyawan->tgl_keluar;
$lama=lama_kerja($karyawan->tgl_masuk,$tgl);
$jab=cari_jabatan($karyawan->id_jabatan);
$dep=cari_dep($jab->id_departemen);
$keluarga=tampil_keluarga($karyawan->id_karyawan);
$pendidikan=tampil_pendidikan($karyawan->id_karyawan);
$pengalaman=tampil_pengalaman($karyawan->id_karyawan);
?>
<section class="content-header">
  <h1>
    Detail Karyawan
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.($breadcrumd)) ?>">Karyawan</a></li>
    <li><a href="<?php echo url('index.php?mn='.($breadcrumd)) ?>">Detail Karyawan</a></li>
    <li class="active"><?php echo $karyawan->nama_lengkap ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div>
	<?php 
	if(isset($_GET['url']))
		$url=urldecode($_GET['url']);
	else
		$url=url('index.php?mn=karyawan');
	?>
		<a href='<?php echo $url ?>' class='btn btn-danger'><i class='fa fa-angle-double-left'></i> Kembali</a>
		<a href='<?php echo url("index.php?mn=karyawan&act=edit&id=".$karyawan->id_karyawan."&url=".url_ref()) ?>' class='btn btn-info'><i class='fa fa-edit'></i> Edit Karyawan</a>
		<a href='<?php echo url('index.php?mn=karyawan&act=edit_jabatan&id='.$karyawan->id_karyawan)?>' class='btn btn-success'><i class='fa fa-edit'></i> Edit Jabatan & Departemen</a>
		<a href='' class='btn bg-navy'><i class='fa fa-repeat'></i> Reload</a>
	</div>
  <!-- Default box -->
	<div class="box">
		<div class="box-header with-border">

		</div>
		<div class="box-body">
			<div class="x_panel">
				<div class="x_content">

					<div class="col-md-4 col-sm-4 col-xs-12 profile_left">

						<div class="profile_img">

						   <div class="avatar-view" title="<?php echo $karyawan->nama_lengkap?>(<?php echo $karyawan->nama_panggilan?>)" align="center">
									<img src="<?php echo url(cek_photo($karyawan->id_karyawan)) ?>" class="\" alt="<?php echo $karyawan->nama_lengkap?>" style="width:150px">
							</div>

						</div>
						<h3><?php echo $karyawan->nama_lengkap?></h3>
						<h4><?php echo $karyawan->nama_panggilan?></h4>
						<ul class="list-unstyled user_data">
							<li><i class="fa fa-building user-profile-icon"></i> <b>NIK : </b><?php echo $karyawan->nik?></li>
							<li><i class="fa fa-building user-profile-icon"></i> <b>Departemen : </b><?php echo $dep->nama_departemen?></li>
							<li><i class="fa fa-user-md user-profile-icon"></i> <b>Jabatan : </b><?php echo $jab->nama_jabatan?></li>
							<li><i class="fa fa-venus-mars user-profile-icon"></i> <b>Jenis Kelamin : </b><?php echo jk($karyawan->jenis_kelamin)?></li>
							<li><i class="fa fa-calendar-o user-profile-icon"></i> <b>TTL : </b><?php echo $karyawan->tpt_lahir?> <?php echo tanggal($karyawan->tgl_lahir) ?></li>
							<li><i class="fa fa-building user-profile-icon"></i> <b>Agama : </b><?php echo $karyawan->agama?></li>
							<li><i class="fa fa-globe user-profile-icon"></i> <b>Warganegara : </b><?php echo $karyawan->warganegara?></li>
							<li><i class="fa fa-female user-profile-icon"></i> <b>Status Nikah : </b><?php echo status($karyawan->status_nikah)?></li>
							<li><i class="fa fa-child user-profile-icon"></i> <b>Jumlah Anak : </b><?php echo $karyawan->jml_anak?></li>
							<li><i class="fa fa-user user-profile-icon"></i> <b>Nama Ayah : </b><?php echo $karyawan->nama_ayah?></li>
							<li><i class="fa fa-user user-profile-icon"></i> <b>Nama Ibu : </b><?php echo $karyawan->nama_ibu?></li>
							<li><i class="fa fa-map-marker user-profile-icon"></i> <b>Alamat Rumah : </b><?php echo $karyawan->alamat_rumah?></li>
							<li><i class="fa fa-map-marker user-profile-icon"></i> <b>Alamat Tinggal : </b><?php echo $karyawan->alamat_tinggal?></li>
							<li><i class="fa fa-phone user-profile-icon"></i> <b>No. Telepon : </b>
								<ol>
									<li><?php echo $karyawan->tlp_1?></li>
									<li><?php echo $karyawan->tlp_2?></li>
								</ol>
							<br>
							
							</li><li><i class="fa fa-envelope user-profile-icon"></i> <b>Email : </b><?php echo $karyawan->email?></li>
							
							<li><i class="fa fa-calendar-check-o user-profile-icon"></i> <b>Tangal Masuk : </b><?php echo tanggal($karyawan->tgl_masuk)?></li>
							<li><i class="fa fa- user-profile-icon"></i> <b>Status Karyawan : </b><?php echo status($karyawan->status_nikah)?></li>
							<li><i class="fa fa-calendar-o user-profile-icon"></i> <b>Lama Kerja : </b><?php echo ($lama['years']==0) ? "" : $lama['years']." Tahun," ?> <?php echo ($lama['months']==0) ? "" : $lama['months']." Bulan," ?> <?php echo $lama['days'] ?> hari</li>
							
						</ul>

						
						<br>

					</div>
					<div class="col-md-8 col-sm-8 col-xs-12">

						<!-- start of user-activity-graph -->
						
						<!-- end of user-activity-graph -->

						<div class="" role="tabpanel" data-example-id="togglable-tabs">
							<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
								<li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><i class='fa fa-sticky-note'></i> Catatan</a>
								</li>
								<li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class='fa fa-users'></i> Keluarga</a>
								</li>
								<li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class='fa fa-mortar-board'></i> Pendidikan</a>
								</li>
								<li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class='fa fa-motorcycle'></i> Riwayat kerja</a>
								</li>
								
								<li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><i class='fa fa-history'></i> Riwayat Jabatan</a>
								</li>
							</ul>
							<div id="myTabContent" class="tab-content">
								<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
									<p> <br/>
										<?php echo $karyawan->catatan ?>
									</p>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
								<div class='table-responsive'>
									<!-- start user projects -->
									<table class="table-hover table-striped table-responsive" style='width:100%'>
										<thead>
											<tr>
												<th>Nama Lengkap</th>
												<th>Tanggal Lahir</th>
												<th >Status</th>
												<th>Pekerjaan</th>
												<th>Catatan</th>
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
											
										</tr>
											
											<?php											
										}
										?>
											
										</tbody>
										<tfoot>
											<tr>
												<td colspan=4>
													<a href='<?php echo url("index.php?mn=keluarga&act=tambah&id=$karyawan->id_karyawan&url=".url_ref()) ?>' class='btn btn-danger'><i class='fa fa-plus'></i> Tambah / Edit </a>
												</td>
											</tr>
										</tfoot>
									</table>
									<!-- end user projects -->
								</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
									<div class='table-responsive'>
										<table class="table-hover table-striped table-responsive" style='width:100%'>
										<thead>
											<tr>
												<th>Pendidikan</th>
												<th>Alamat</th>
												<th >Tahun Masuk</th>
												<th>Tahun Keluar</th>
												<th>Keterangan</th>
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
											
										</tr>
											
											<?php											
										}
										?>
											
										</tbody>
										<tfoot>
											<tr>
												<td colspan=4>
													<a href='<?php echo url("index.php?mn=pendidikan&act=tambah&id=$karyawan->id_karyawan&url=".url_ref()) ?>' class='btn btn-danger'><i class='fa fa-plus'></i> Tambah </a>
												</td>
											</tr>
										</tfoot>
									</table>
									</div>
								</div>
								
								<div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
									<div class='table-responsive'>
										<table class="table-hover table-striped table-responsive" style='width:100%'>
											<thead>
												<tr>
													<th>Perusahaan</th>
													<th>Sebagai</th>
													<th>Alamat</th>
													<th >Masuk</th>
													<th>Keluar</th>
													<th>Deskripsi Kerja</th>
													<th>Alasan keluar</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											if(mysql_error())
												echo alert(mysql_error());
											while($peng=mysql_fetch_object($pengalaman))
											{
												?>
											<tr>
												<td><?php echo $peng->nama_perusahaan ?></td>
												<td>
													<?php echo $peng->departemen ?> - 
													<?php echo $peng->jabatan ?>
													
												</td>
												<td><?php echo ($peng->alamat_perusahaan) ?></td>
												<td><?php echo tanggal($peng->tgl_masuk) ?></td>
												<td><?php echo tanggal($peng->tgl_keluar) ?></td>
												<td><?php echo $peng->deskripsi_pekerjaan ?></td>
												<td><?php echo $peng->alasan_keluar ?></td>
												
											</tr>
												
												<?php											
											}
											?>
												
											</tbody>
											<tfoot>
												<tr>
													<td colspan=4>
														<a href='<?php echo url("index.php?mn=pangalaman&act=tambah&id=$karyawan->id_karyawan&url=".url_ref()) ?>' class='btn btn-danger'><i class='fa fa-plus'></i> Tambah </a>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
								
								<div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
									<div class='table-responsive'>
									Jabatan sekarang : <?php echo $jab->nama_jabatan ?><br/>
									Departemen sekarang : <?php echo $dep->nama_departemen ?><br/>
										<table class="table-hover table-striped table-responsive" style='width:100%'>
											<tr>
												<th>Jabatan Asal</th>
												<th>Dept. Asal</th>
												<th>Tgl Pindah jabatan</th>
												<th>Catatan</th>
											</tr>
											<?php 
											$asal=mysql_query("select * from riwayat_jabatan where id_karyawan='$karyawan->id_karyawan' order by id_riwayat_jabatan desc");
											while($asal_jab=mysql_fetch_object($asal)){
												?>
											<tr>
												<td><?php echo $asal_jab->jabatan_asal ?></td>
												<td><?php echo $asal_jab->departemen_asal ?></td>
												<td><?php echo $asal_jab->tanggal_pindah_jabatan ?></td>
												<td><?php echo $asal_jab->keterangan ?></td>
											</tr>
												<?php
											}
											?>
										</table>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		
    </div>

</section>