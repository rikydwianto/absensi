<?php 
include_once"fungsi/absen-absen.php";
include_once"fungsi/karyawan.php";
include_once"fungsi/departemen.php";
include_once"fungsi/jabatan.php";
$no=1;
$breadcrumd=$_GET['mn'];
@$dept = aman($_GET['dept']);
@$jabt = aman($_GET['jabt']);
$nama_dept = mysql_query("select * from departemen where id_departemen='$dept'");
$nama_dept = mysql_fetch_array($nama_dept);

$nama_jabt = mysql_query("select * from jabatan where id_jabatan='$jabt'");
$nama_jabt = mysql_fetch_array($nama_jabt);

if(empty($jabt)){
	$query_and = " and departemen.id_departemen='$dept'";
}
else{
	$query_and = " and jabatan.id_jabatan='$jabt'";
}

$query="SELECT * FROM karyawan 
INNER JOIN jabatan ON jabatan.`id_jabatan`=karyawan.`id_jabatan` INNER JOIN departemen ON departemen.`id_departemen` = jabatan.`id_departemen` 
where (karyawan.status_karyawan !='5'  ) 
$query_and order by departemen.id_departemen,jabatan.id_jabatan,karyawan.tgl_masuk asc";
$query = mysql_query($query);
?>
<section class="content-header">
  <h1>
    Semua Karyawan
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Karyawan Perline</a></li>
    <li class="active">Aktif</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Rekap </h3>
		</div>
		<div class="box-body">
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
			</div>
			<br/>
				<div class='pull-right'>
				<form method=get>
					<select name='dept' id='dept' class='sel1ect2'>
						<option value=''>Departemen </option>
						<?php 
						$Qdep=tampil_departemen();
						while($rDep=mysql_fetch_object($Qdep))
						{
							if($dept==$rDep->id_departemen)
								echo "<option selected value='$rDep->id_departemen'>$rDep->nama_departemen</option>";
							else
								echo "<option value='$rDep->id_departemen'>$rDep->nama_departemen</option>";
								
							
						}
						?>
					</select>
					<select id='jabatan' name='jabt'>
					<option value=''>Jabatan</option>
					<?php 
					$Qjab=jabatan_departemen($dept);
					while($rJab=mysql_fetch_object($Qjab)){
						if(@$jabt==$rJab->id_jabatan)
							$select="selected";
						else
							$select="";
						echo "<option $select value='$rJab->id_jabatan'>$rJab->nama_jabatan</option>";
					}
					?>
					</select>
					<input type=hidden value='karyawan_aktif' name='mn'/>
					<input type=submit value='Cari' name='cr'/>
					</form>

				</div>
				<br/>
				<br/>
				<?php 
				//error_reporting(0);
				?>
				Nama Departemen : <?php echo $nama_dept['nama_departemen'] ?><br/>
				Nama Jabatan : <?php echo $nama_jabt['nama_jabatan'] ?><br/>
				<div class='' >
					<table border=1 class=' ' style='font-size:11px;width:100%'>
					<thead>
					<tr>
						<th >No</th>
						<th >NIK</th>
						<th >Nama</th>
						<th >Jabatan</th>
						<th >NIK KTP.</th>
						<th >Tmp Lahir</th>
						<th >Tgl Lahir</th>
						<th >Jenis Kelamin</th>
						<th >Tanggal Masuk</th>
						<th >Status Karyawan</th>
						<th >Alamat</th>
						<th >No. Hp</th>
						<th >Keterangan	</th>
						<th >Photo	</th>
					</thead>
					<tbody>
					<?php 
					while($rowTampil=mysql_fetch_array($query)){
					
					if($rowTampil['tgl_keluar']==null)
						$tgl=date("Y-m-d");
					else
						$tgl=$rowTampil['tgl_keluar'];
					$lama=lama_kerja($rowTampil['tgl_masuk'],$tgl);
					/* 
					data-original-title="Klik Nama Untuk Melihat Detail <?php echo $rowTampil['nama_lengkap'] ?>" data-toggle="tooltip" data-placement="top" 
					*/
					?>
						<tr >
							<td><?php echo $no ?></td>
							<td><?php echo $rowTampil['nik'] ?></td>
							<td>	
							
							
								<div class="btn-group" role="group">
									<a href="javascript:void(0)" id="btnGroupDrop1" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<?php echo $rowTampil['nama_lengkap'] ?>
									</a>
									<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
										<li><a class="dropdown-item" href="<?php echo url("index.php?mn=detail_karyawan&id=".$rowTampil['id_karyawan']."&nik=".$rowTampil['nik'].'&url='.url_ref())?>" target="_blank" data-original-title="Profile <?php echo $rowTampil['nama_lengkap'] ?>" data-toggle="tooltip" data-placement="right">Lihat Profil</a></li>
										<li><a class="dropdown-item" href="<?php echo url('index.php?mn=report-per-karyawan&id='.$rowTampil['id_karyawan'].'&url='.url_ref().'#'.$rowTampil['id_karyawan'] )?>" target="_blank" data-original-title="Absen <?php echo $rowTampil['nama_lengkap'] ?>" data-toggle="tooltip" data-placement="right">Lihat Absen</a></li>
										<li><a class="dropdown-item" href="<?php echo url('index.php?mn=berkas&id='.$rowTampil['id_karyawan'].'&url='.url_ref().'#'.$rowTampil['id_karyawan'] )?>" target="_blank" data-original-title="Berkas <?php echo $rowTampil['nama_lengkap'] ?>" data-toggle="tooltip" data-placement="right">Lihat Berkas</a></li>
										
										<li class="divider"></li>
										
										<li><a class="dropdown-item" href="<?php echo url('index.php?mn=karyawan&act=edit_jabatan&id='.$rowTampil['id_karyawan'].'&url='.url_ref())?>" target="_blank" data-original-title="Ganti Jabatan <?php echo $rowTampil['nama_lengkap'] ?>" data-toggle="tooltip" data-placement="right">Edit Jabatan</a></li>
										<li><a class="dropdown-item" href="<?php echo url("index.php?mn=karyawan&act=edit&id=".$rowTampil['id_karyawan']."&url=".url_ref()) ?>" target="_blank" data-original-title="Edit <?php echo $rowTampil['nama_lengkap'] ?>" data-toggle="tooltip" data-placement="right">Edit</a></li>
										<li><a class="dropdown-item" href="<?php echo url('index.php?mn=resign&act=tambah&id='.$rowTampil['id_karyawan'].'&url='.url_ref())?>" target="_blank" data-original-title="Resign/Keluar <?php echo $rowTampil['nama_lengkap'] ?>" data-toggle="tooltip" data-placement="right">Resign/Keluar</a></li>
									</div>
								  </div>
							</td>
							<td><?php echo $rowTampil['nama_jabatan'] ?></td>
							<td><?php echo $rowTampil['no_ktp'] ?></td>
							<td><?php echo $rowTampil['tpt_lahir'] ?></td>
							<td><?php echo tanggal($rowTampil['tgl_lahir'])?></td>
							<td><?php echo jk($rowTampil['jenis_kelamin'])?></td>
							<td><?php echo $rowTampil['tgl_masuk'] ?></td>
							<td><?php echo status_karyawan($rowTampil['status_karyawan'])?></td>
							<td><?php echo ($rowTampil['alamat_rumah'])?></td>
							<td><?php echo ($rowTampil['tlp_1'])?><br/><?php echo ($rowTampil['tlp_2'])?></td>
							<td><?php echo ($rowTampil['catatan'])?></td>
							<td>
								<a href="<?php echo url(cek_photo_besar($rowTampil['id_karyawan'])) ?>" rel="prettyPhoto" title="<?php echo $rowTampil['nama_lengkap'] ?>(<?php echo $rowTampil['nik'] ?>)">Photo</a>
							</td>
						</tr>
					<?php
					$no++;
					}
					?>
					</tbody>
					</table>

					<br/>

					<br/>

					<br/>

					<br/>

					<br/>

					<br/>

					<br/>

					<br/>

					<br/>

			</div>
		</div>
    </div>

</section>