<?php 
include_once"fungsi/absen-absen.php";
include_once"fungsi/karyawan.php";
include_once"fungsi/departemen.php";
include_once"fungsi/jabatan.php";
$batasD=50;
if(isset($_GET['batas']))
{
	$batas = aman($_GET['batas']);
}
else
{
	$batas=$batasD;
}

if(isset($_GET['page']))
{
	$page=aman($_GET['page']);
	$posisi=($page-1)*$batas;
}
else
{
	$page=1;
	$posisi=0;
}


$no=($batas * $page) - $batas + 1;
$breadcrumd=$_GET['mn'];
@$dept = aman($_GET['dept']);
@$jabt = aman($_GET['jabt']);
@$order = aman($_GET['orderby']);
$nama_dept = mysql_query("select * from departemen where id_departemen='$dept'");
$nama_dept = mysql_fetch_array($nama_dept);

$nama_jabt = mysql_query("select * from jabatan where id_jabatan='$jabt'");
$nama_jabt = mysql_fetch_array($nama_jabt);

if(!empty($dept)){
	if(empty($jabt)){
		$query_and = " where  departemen.id_departemen='$dept'";
	}
	else{
		$query_and = "  where jabatan.id_jabatan='$jabt'";
	}
	
	
	if($dept=='semua'){
		$query_and="";
		echo "";
	}
}
else $query_and='';

if(isset($_GET['orderby']))
{
	$orderby = $order;
	if($orderby=='asc'){
		@$asc='selected';
	}
	else @$desc='selected';
}
else{
	$orderby = 'asc';
	@$asc='selected';
}
	
	
if(isset($_GET['berdasarkan'])){
	$dasar = aman($_GET['berdasarkan']);
	switch($dasar){
		
		case'nama':
			$berdasarkan = " karyawan.nama_lengkap ";
			$orNama = 'selected';
		break;
		
		case'jk':
			$berdasarkan = " karyawan.jenis_kelamin ";
			$orJK = 'selected';
		break;
		
		case'departemen':
			$berdasarkan = " departemen.nama_departemen,jabatan.nama_jabatan ";
			$orDept = 'selected';
		break;
		
		case'jabatan':
			$berdasarkan = " jabatan.nama_jabatan ";
			$orJabt = 'selected';
		break;
		
		case'masuk':
			$orMasuk = 'selected';
			$berdasarkan = " karyawan.tgl_masuk ";
		break;
		case'keluar':
			$orKeluar = 'selected';
			$berdasarkan = " karyawan.tgl_keluar ";
		break;
		
		case'status':
			$orStatus = 'selected';
			$berdasarkan = " karyawan.status_karyawan ";
		break;
		
		default:
			$orNama = 'selected';
			$berdasarkan = " karyawan.nama_lengkap ";
		break;
		
	}
}
else{
	$orNama = 'selected';
	$berdasarkan = " karyawan.nama_lengkap ";
}


if(isset($_GET['query']) && !empty($_GET['query'])){
	$cari = aman($_GET['query']);
	if(!empty($dept)){
		if(empty($jabt)){
			$and = " and ";
		}
		else{
			$and = "  and ";
		}
		
		
		if($dept=='semua'){
			$and="where ";
		}
	}
	else
		$and='where';
	
	$qCari = $and." 
	(karyawan.nama_lengkap like '%$cari%' or
	karyawan.nik = '$cari' or
	karyawan.nik like '%$cari%' or
	karyawan.alamat_rumah like '%$cari%' or
	karyawan.tlp_1 like '%$cari%' or
	karyawan.tlp_2 like '%$cari%' or
	karyawan.catatan like '%$cari%' or
	
	karyawan.tgl_lahir='$cari' or
	karyawan.tgl_masuk='$cari' or
	karyawan.tgl_keluar='$cari'
	)
	";
}
else $qCari=" ";
$query="SELECT * FROM karyawan 
INNER JOIN jabatan ON jabatan.`id_jabatan`=karyawan.`id_jabatan` INNER JOIN departemen ON departemen.`id_departemen` = jabatan.`id_departemen` 
$query_and $qCari order by $berdasarkan $orderby limit $posisi,$batas";
$queryPaging="SELECT * FROM karyawan 
INNER JOIN jabatan ON jabatan.`id_jabatan`=karyawan.`id_jabatan` INNER JOIN departemen ON departemen.`id_departemen` = jabatan.`id_departemen` 
$query_and $qCari order by $berdasarkan $orderby ";
$queryPaging = mysql_query($queryPaging);
$query = mysql_query($query) or die("Error : ". mysql_error());
function jk_simple($param){
	if($param==0) return "L";
	else if($param==1) return "P";
	else return "";
}
?>
<section class="content-header">
  <h1>
    Semua Karyawan
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Karyawan </a></li>
    <li class="active">Semua Karyawan</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Karyawan </h3>
		</div>
		<div class="box-body">
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
				<a href='<?php echo url('index.php?mn=karyawan&act=tambah') ?>'   class='btn btn-info'><i class='fa fa-plus'></i> Tambah Karyawan </a>
				<a href='<?php echo url('index.php?mn=karyawan_semua') ?>'   class='btn btn-danger'><i class='fa fa-times'></i> Tampilkan Semua </a>
			</div>
			<br/>
				<div class='pull-right'>
				<form method=get>
					<input type=text name='query' class='form-control' value="<?php echo @$_GET['query']; ?>" placeholder="Nama, NIK, Alamat, No Hp, Keterangan, Tanggal(YYYY-MM-DD) ...." />
					<select name='dept' id='dept' class='sel1ect2'>
						<option value=''>Departemen </option>
						<option value='semua'>Tampilkan Semua </option>
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
					<select name='berdasarkan'>
						<option <?php echo @$orNama ?> value='nama'>Berdasarkan Nama</option>
						<option <?php echo @$orJK ?> value='jk'>Berdasarkan Jenis Kelamin</option>
						<option <?php echo @$orDept ?> value='departemen'>Berdasarkan Departemen</option>
						<option <?php echo @$orJabt ?> value='jabatan'>Berdasarkan Jabatan</option>
						<option <?php echo @$orMasuk ?> value='masuk'>Berdasarkan Tanggal Masuk</option>
						<option <?php echo @$orKeluar ?> value='keluar'>Berdasarkan Tanggal keluar</option>
						<option <?php echo @$orStatus ?> value='status'>Berdasarkan Status Karyawan</option>
					</select>
					<select name='orderby'>
						<option <?php echo @$asc ?> value='asc'>Dari A ke Z</option>
						<option <?php echo @$desc ?> value='desc'>Dari Z ke A</option>
					</select>
					<input type=hidden value='karyawan_semua' name='mn'/>
					batas : <input type=text value='<?php echo $batas ?>' size='5' name='batas' placeholder='Batas data yang ditampilkan' data-original-title="Batas Halaman, Default batas halaman adalah <?php echo $batasD ?>" data-toggle="tooltip" data-placement="top"/>
					<input type=submit value='Filter' name='cr'/>
					</form>

				</div>
				<br/>
				<table class='table'>
					<tr>
						<td>
						Karyawan Tetap : <?php echo $t = total_karyawan('3') ?><br/>
						Karyawan Kontrak : <?php echo $k = total_karyawan('2') ?><br/>
						Karyawan Training : <?php echo $T = total_karyawan('1') ?><br/>
						<b>Karyawan Aktif : <?php echo $t + $T + $k ?></b><br/>
						Karyawan Keluar : <?php echo total_karyawan('5') + total_karyawan('4') ?>
						
						</td>
						<td>
							
							Total Laki Laki : <?php echo total_jk('0'); ?> <br/>
							Total Perempuan : <?php echo total_jk('1'); ?> <br/>
							Total Tanpa Jenis Kelamin : <?php echo mysql_num_rows($queryPaging) - (total_jk('0') + total_jk('1')); ?> <br/>
							Total Tanpa Status : <?php echo tanpa_status()?> <br/>
							<b>Total Semua Karyawan : <?php echo mysql_num_rows($queryPaging); ?> </b>
							
						</td>
					</tr>
				</table>
				
				<div class='' >
					<table border=1 class=' ' style='font-size:11px;width:100%'>
					<thead>
					<tr>
						<th >No</th>
						<th >NIK</th>
						<th >Nama</th>
						<th >Dept</th>
						<th >Jabatan Terakhir</th>
						<th >JK</th>
						<th >Masuk</th>
						<th >Keluar</th>
						<th >Status Karyawan</th>
						<th >Alamat</th>
						<th >Email</th>
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
						<tr valign=top >
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
							<td><?php echo $rowTampil['nama_departemen'] ?></td>
							<td><?php echo $rowTampil['nama_jabatan'] ?></td>
							<td ><center data-original-title="<?php echo jk($rowTampil['jenis_kelamin'])?>" data-toggle="tooltip" data-placement="top" ><?php echo jk_simple($rowTampil['jenis_kelamin'])?></center></td>
							<td><?php echo $rowTampil['tgl_masuk'] ?></td>
							<td><?php echo $rowTampil['tgl_keluar'] ?></td>
							<td><?php echo status_karyawan($rowTampil['status_karyawan'])?></td>
							<td><p style='font-size:9.5px'><?php echo ($rowTampil['alamat_rumah'])?></p></td>
							<td><p style='font-size:9.5px'><?php echo ($rowTampil['email'])?></p></td>
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
										
					<ul class="pagination">
					<?php
					@$uri = "index.php?query=$cari&dept=$dept&jabt=$jabt&berdasarkan=$dasar&orderby=$order&mn=karyawan_semua&cr=Filter&batas=$batas";
				   $q2=mysql_num_rows($queryPaging);
				   echo mysql_error();
					$jml=ceil($q2/$batas);
					$jumPage=$jml;
					if ($page > 1){
					echo  "<li><a href='".url($uri)."'><i class='fa fa-angle-double-left'></i> First</a></li>";
					echo  "<li><a href='".url('index.php?mn=karyawan&page='.($page-1))."'><i class='fa fa-angle-left'></i> Prev</a></li>";
					}
					//menampilkan urutan paging
					for($i = 1; $i <= $jumPage; $i++){
						if($i==$page) echo " <li class='active'> <a href='".url($uri."&page=".$i)."' >".$i."</a> </li>";
						else echo " <li> <a href='".url($uri."&page=".$i)."'>".$i."</a> </li>";
					}
					//menampilkan link Next >>
					if ($page < $jumPage){
					echo "<li><a href='".url($uri."&page=".($page + 1))."'>Next <i class='fa fa-angle-right'></i></a></li>";
					echo "<li><a href='".url($uri."&page=".$jml)."'>End <i class='fa fa-angle-double-right'></i></a></li>";
					}

					?>
					</ul>
					<br/>
					<br/>

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