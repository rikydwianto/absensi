<?php 
if(isset($_GET['page']))
{
	$page=$_GET['page'];
	$posisi=($page-1)*$batas;
}
else
{
	$page=1;
	$posisi=0;
}
?>
<style>
.tooltip-inner {
    white-space:pre;
    max-width: none;
}

</style>
<table class='table table-responsive table-hover' id="">
	<thead>
		<tr>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	@$cari=aman($_GET['q']);
	if(isset($_GET['q']))
	{
		$text=$cari;
		$hitung=hitung_cari_karyawan($text);
	}
	else{
		$hitung=hitung_karyawan();
		$text=null;
	}
	$q=tampil_karyawan($text,$posisi,$batas);
	if(mysql_error())
		echo alert_error(mysql_error());
	if(mysql_num_rows($q)>0)
	{
	while($r=mysql_fetch_object($q))
	{
		?>
		<tr data-toggle="tooltip" data-placement="top"   data-html="true"
		data-original-title="<p align=left><?php echo strtoupper($r->nama_lengkap) ?> (<?php echo $r->nik ?>) 
		<br/>No. KTP : <?php echo $r->no_ktp ?>
		<br/>Nama Lengkap :  <?php echo $r->nama_lengkap ?>
		<br/>NO. HP :  <?php echo ($r->tlp_1)?><br/>
		<br/>NO. HP 2 :  <?php echo ($r->tlp_2)?><br/>
		<br/>ALAMAT :  <?php echo ($r->alamat_rumah)?>
		<br/>Departemen : <?php echo @$dep->nama_departemen ?>
		<br/>Jabatan :  <?php echo @$jab->nama_jabatan ?>
		"
		
		
		>
		<td>
		<div class="row invoice-info" id='<?php echo $r->id_karyawan ?>'>
			<div class="col-sm-2 invoice-col">
				<address>
					
					<a href="<?php echo url("index.php?mn=detail_karyawan&id=".$r->id_karyawan."&nik=".$r->nik.'&url='.url_ref())?>" target="">
					<img data-original-title="<?php echo $r->nama_lengkap ?>" data-toggle="tooltip" data-placement="right" title="" style="width:130px; display: block;" src="<?php echo url(cek_photo($r->id_karyawan)) ?>" alt="<?php echo $r->nama_lengkap ?>">
					</a>
					<br/>
					<a href="<?php echo url("index.php?mn=karyawan&act=edit&id=".$r->id_karyawan."&url=".url_ref()) ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>
					 
					<a href="javascript:;<?php //echo url("index.php?mn=karyawan&act=hapus&id=".$r->id_karyawan."&url=".url_ref()) ?>" onclick="klik_modal('<?php echo $r->id_karyawan ?>')" class="btn btn-danger btn-xs" data-toggle="modal" data-target=""><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>
				</address>
			</div>
				<!-- /.col -->
			<div class="col-sm-3 invoice-col">
			<?php 
			$umur=umur($r->tgl_lahir);
			?>

				<address>
					<strong>No. KTP : </strong><?php echo $r->no_ktp ?>
					<br/><strong>Nama Lengkap : </strong> <?php echo $r->nama_lengkap ?>
					<br/><strong>TTL : </strong><?php echo $r->tpt_lahir ?>, <?php echo tanggal($r->tgl_lahir)?>
					<br/><strong>Jenis Kelamin : </strong><?php echo jk($r->jenis_kelamin)?>
					<br/><strong>Status Nikah : </strong><?php echo status($r->status_nikah)?>
					<br/><strong>Jumlah Anak : </strong> <?php echo ($r->jml_anak)?>
					<br/><strong>Agama : </strong> <?php echo ($r->agama)?>
					<br/><strong>Umur : </strong> <?php echo $umur['years'] ?> Tahun
					<br/><strong>Nama Ayah : </strong><?php echo ($r->nama_ayah)?> 
					<br/><strong>Nama Ibu : </strong><?php echo ($r->nama_ibu)?> 
				</address>
			</div>
				<!-- /.col -->
			<div class="col-sm-3 invoice-col">
				<address>
				<?php 
					if($r->tgl_keluar==null)
						$tgl=date("Y-m-d");
					else
						$tgl=$r->tgl_keluar;
					$lama=lama_kerja($r->tgl_masuk,$tgl);
					$jab=cari_jabatan($r->id_jabatan);
					@$dep=cari_dep($jab->id_departemen);
					?>
					<strong>NIK : </strong><a href="<?php echo url("index.php?mn=detail_karyawan&id=".$r->id_karyawan."&nik=".$r->nik.'&url='.url_ref())?>" target="" data-original-title="Lihat Detail <?php echo $r->nama_lengkap ?>" data-toggle="tooltip" data-placement="right" ><?php echo $r->nik ?></a>
					<br/><strong>Tanggal Masuk : </strong><br/><?php echo tanggal($r->tgl_masuk) ?>
					<br/><strong>Tanggal Keluar : </strong><br/> <?php echo ($r->tgl_keluar==null) ? "-" : tanggal($r->tgl_keluar) ?>
					<br/><strong>Masa Kerja : </strong>
					<br/>
					<?php echo ($lama['years']==0) ? "" : $lama['years']." Tahun," ?> <?php echo ($lama['months']==0) ? "" : $lama['months']." Bulan," ?> <?php echo $lama['days'] ?> hari
					<br/><strong>Departemen : </strong>
					<?php echo @$dep->nama_departemen ?>
					<br/><strong>Jabatan : </strong> <?php echo @$jab->nama_jabatan ?>
					<br/><strong>Status Karyawan : </strong><?php echo status_karyawan($r->status_karyawan)?>
					
				</address>
			</div>
				<!-- /.col -->
			<div class="col-sm-3 invoice-col">
				<address>
					<strong>Alamat Rumah : </strong><?php echo $r->alamat_rumah?>
					<br/><strong>Alamat Tinggal : </strong><?php echo $r->alamat_tinggal?>
					<br/><strong>No.Tlp  : </strong>
					<br/> - <?php echo $r->tlp_1?>
					<br/> - <?php echo $r->tlp_2?>
					<br/><strong>Email : </strong><?php echo $r->email?>
					<br/>
					<a href='<?php echo url('index.php?mn=karyawan&act=edit_jabatan&id='.$r->id_karyawan.'&url='.url_ref())?>' class='btn btn-success btn-xs btn-flat'><i class='fa fa-edit'></i> Jabatan</a>
					<a href='<?php echo url('index.php?mn=resign&act=tambah&id='.$r->id_karyawan.'&url='.url_ref())?>' class='btn btn-info btn-xs btn-flat'><i class='fa fa-edit'></i> Resign?</a> <br/><br/>
					<a href='<?php echo url('index.php?mn=berkas&id='.$r->id_karyawan.'&url='.url_ref().'#'.$r->id_karyawan )?>' class='btn btn-danger btn-flat'><i class='fa fa-folder-o'></i> Berkas</a>
					<a href='<?php echo url('index.php?mn=report-per-karyawan&id='.$r->id_karyawan.'&url='.url_ref().'#'.$r->id_karyawan )?>' class='btn btn-success btn-flat'><i class='fa fa-clock-o'></i> Rekap Absen</a>
				</address>
			</div>
				<!-- /.col -->
				
		</div>
		</td>
		</tr>
			<?php
		}
	}
	else
		include"view/error/search.php";
	?>
	</tbody>
</table>
<center>
<ul class="pagination">
<?php

   $q2=($hitung);
   echo mysql_error();
	$jml=ceil($q2/$batas);
	$jumPage=$jml;
   if(!isset($_GET['q']))
   {
		if ($page > 1){
		echo  "<li><a href='".url('index.php?mn=karyawan&page='.($page-1))."'><< Prev</a></li>";
		}
		//menampilkan urutan paging
		for($i = 1; $i <= $jumPage; $i++){
		//mengurutkan agar yang tampil i+3 dan i-3
				 if ((($i >= $page - 3) && ($i <= $page + 3)) || ($i == 1) || ($i == $jumPage))
				 {
					if($i==$jumPage && $page <= $jumPage-5) echo "<li><a>...</a></li>";
					if ($i == $page) echo " <li class='active'><a >".$i."</a></li> ";
					else echo " <li> <a href='".url('index.php?mn=karyawan&page='.($i))."'>".$i."</a> </li>";
					if($i==1 && $page >= 6) echo "<li><a>...</a></li>";
				 }
		}
		//menampilkan link Next >>
		if ($page < $jumPage){
		echo "<li><a href='".url('index.php?mn=karyawan&page='.($page + 1))."'>Next >></a></li>";
		}
   }
   else{
	   if ($page > 1){
		echo  "<li><a href='".url('index.php?mn=karyawan&page='.($page-1))."&q=$cari'><< Prev</a></li>";
		}
		//menampilkan urutan paging
		for($i = 1; $i <= $jumPage; $i++){
		//mengurutkan agar yang tampil i+3 dan i-3
				 if ((($i >= $page - 3) && ($i <= $page + 3)) || ($i == 1) || ($i == $jumPage))
				 {
					if($i==$jumPage && $page <= $jumPage-5) echo "<li><a>...</a></li>";
					if ($i == $page) echo " <li class='active'><a>".$i."</a></li> ";
					else echo "<li><a href='".url('index.php?mn=karyawan&page='.($i))."&q=$cari'>".$i."</a></li> ";
					if($i==1 && $page >= 6) echo "<li><a>...</a></li>";
				 }
		}
		//menampilkan link Next >>
		if ($page < $jumPage){
		echo "<li><a href='".url('index.php?mn=karyawan&page='.($page + 1))."&q=$cari'>Next >></a></li>";
		}
   }


?>
</ul>
</center>