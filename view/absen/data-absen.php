<?php 
if(isset($_GET['cr']))
{
	$tgl=$_GET['tgl'];
	$ex=explode("/",$tgl);
	$tgl=$ex[2].'-'.$ex[1].'-'.$ex[0];
}
else
	$tgl=date("Y-m-d");

if(isset($_POST['filter']))
{
	$id_jabatan=aman($_POST['jab']);
	@$id_dep=aman($_POST['dep']);
}
else{
	$id_jabatan=null;
	$id_dep=null;
}

?>
<style>
.modal {
}
.vertical-alignment-helper {
    display:table;
    height: 100%;
    width: 100%;
}
.vertical-align-center {
    /* To center vertically */
    display: table-cell;
    vertical-align: middle;
}
.modal-content {
    /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
    width:inherit;
    height:inherit;
    /* To center horizontally */
    margin: 0 auto;
}
</style>
<h2>Data Absen <?php echo tanggal($tgl) ?></h2>
<div class='pull-right'>
<form method=post>
	<select name='jab' id='dept' class='sel1ect2'>
		<option value=''>Tampilkan Semua </option>
		<?php 
		$Qdep=tampil_departemen();
		while($rDep=mysql_fetch_object($Qdep))
		{
			if($rDep->id_departemen==$id_jabatan)
				echo "<option selected value='$rDep->id_departemen'>$rDep->nama_departemen</option>";
			else
				echo "<option value='$rDep->id_departemen'>$rDep->nama_departemen</option>";
			
		}
		?>
	</select>
	<select id='jabatan' name='dep'>
		<option value=''>-- Jabatan --</option>
		<?php 
		$Qjab=jabatan_departemen(@$id_jabatan);
		while($rJab=mysql_fetch_object($Qjab)){
			if($rJab->id_jabatan==@$_POST['dep'])
				echo "<option selected value='$rJab->id_jabatan'>$rJab->nama_jabatan</option>";
			else
				echo "<option value='$rJab->id_jabatan'>$rJab->nama_jabatan</option>";
		}
		?>
	</select>
	<input type=submit value='Filter' name='filter'/>

</form>
</div>

<div class=''>
	<form method=get>
	Pilih  : 
	<input type=hidden name='mn' value='absen' id=''/>
	<input type=text name='tgl' value='<?php echo date("d/m/Y",strtotime(@$tgl)) ?>' id='tgl1' data-inputmask="'alias': 'dd/mm/yyyy'" data-mask />
	<input type=submit value='Cari' class='' name='cr'/>

	</form>
</div>
<br/>

<?php include"view/absen/hitung-absen.php"; ?>
<div class='table-responsive'>
<form method=post>
<?php 
if(isset($_POST['lembur']))
{
	if(hitung_cek_lembur())
	{
		@$id=$_POST['id_absen'];
		for($i=0;$i<count($id);$i++)
		{
			beri_lembur($id[$i]);
		}
		echo alert("Lembur telah diterapkan");
	}
	else
	{
		echo alert_error("Anda harus mengatur lemburan terlebih dahulu, Presensi -> Data Lembur -> <i class='fa fa-plus'></i> Lembur");
	}
	
}
if(isset($_POST['batal_lembur']))
{
	@$id=$_POST['id_absen'];
	for($i=0;$i<count($id);$i++)
	{
		mysql_query("update absen set lembur='tidak' where id_absen='$id[$i]'");
	}
	echo alert("Lembur telah dibatalkan");	
}
if(isset($_POST['hapus_absen']))
{
	@$id=$_POST['id_absen'];
	for($i=0;$i<count($id);$i++)
	{
		mysql_query("delete from absen where id_absen='$id[$i]'");
	}
	echo alert("Telah dihapus ");	
}
if(isset($_POST['pulang']))
{
	@$id=$_POST['id_absen'];
	for($i=0;$i<count($id);$i++)
	{
		mysql_query("update absen set jam_keluar='00:00:00' where id_absen='$id[$i]'");
	}
	direct(urldecode(url_ref()));
}
?>
<div>
	<input type=submit name='batal_lembur' value='Batal Lembur' class='btn btn-flat btn-danger pull-right'>
	<input type=submit name='hapus_absen' value='Hapus Absen' class='btn btn-flat btn-danger pull-right'>
	<input type=submit name='lembur' value='Apply Lembur' class='btn btn-flat btn-info pull-right'>
	<input type=submit name='pulang' value='Pulangkan' class='btn btn-flat btn-success pull-right'>
</div>
<table class='table table-hover' style='width:100%' id='example1'>
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Ket</th>
			<th>Jam Masuk</th>
			<th>Jam Pulang</th>
			<th>Lama Kerja</th>
			<th>Lembur</th>
			<th>Menit</th>
			<th><label><input type=checkbox id='selectall' /><a>Semua</a> </label></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no=1;
		$q=tampil_absen($id_dep,$id_jabatan,$tgl);
		while($r=mysql_fetch_object($q))
		{	
			$jab=cari_jabatan($r->id_jabatan);
			$dep=cari_dep($jab->id_departemen);

			$cari_dup = mysql_query("select count(id_absen) as duplikat from absen where id_karyawan='$r->id_karyawan' and tanggal_absen='$tgl'");
			$cari_dup = mysql_fetch_array($cari_dup);
			$cari_dup = $cari_dup['duplikat'];
			if($cari_dup>1)
				$merah = "danger";
			else $merah='';
		?>
		<tr class='<?php echo $merah ?>'>
			<td><?php echo $no; ?></td>
			<td>
				<a href='<?php echo url('index.php?mn=report-per-karyawan&id='.$r->id_karyawan.'&url='.url_ref().'#'.$r->id_karyawan )?>' target=_blank>
					<?php echo $r->nama_lengkap ?> [<?php echo $dep->nama_departemen ?>-<?php echo $jab->nama_jabatan ?>]
				</a>
			</td>
			<td>
				<?php echo $r->keterangan_hadir ?> - <?php echo $r->keterangan ?>
			</td>
			<td>
				<?php echo $r->jam_masuk; ?> 
				<?php echo ($r->telat=='ya') ? "<b class='label label-danger'>Telat</b>" : "" ?>
			</td>
			<td>
				<?php echo $r->jam_keluar; ?>
				
			</td>
			<td>
				<?php 
				
				@$jam = (($r->jam_keluar));
				@$menit=round(cari_menit(date('07:00:00'),$jam));
				if($menit>0)
					echo round(@$menit/60,1).' jam';
				?>
			</td>
			<td><?php echo $r->lembur; ?></td>
			<td><?php echo $r->menit_lembur; ?></td>
			<td>
			<?php
			if($r->jam_keluar!='' || $r->keterangan_hadir!='')
			{
			?>
			<!--	<label>
					<input type=checkbox  class='case' name='id_absen[]' value='<?php echo $r->id_absen ?>'  />
					Pilih
				</label>  -->
			<?php 
			}
			else
			{
			?>
				<label>
					<input type=checkbox  class='case' name='id_absen[]' value='<?php echo $r->id_absen ?>'  />
					Pilih
				</label>
			<?php 
			}?>
			</td>
			<td>
				<a href='javascript:void(0);' onclick="detail_absen('<?php echo $r->id_absen ?>')" class='btn btn-info'>Detail</a>
				<a href='<?php echo url('index.php?mn=absen&act=edit&id_absen='.$r->id_absen.'&url='.url_ref()) ?>' class='btn btn-xs'><i class='fa fa-edit'></i> E</a>
				<a href='<?php echo url('index.php?mn=absen&act=hapus_absen&id_absen='.$r->id_absen.'&url='.url_ref()) ?>' class='btn btn-xs'><i class='fa fa-remove'></i> H</a>
			</td>
		</tr>
			<?php
			$no++;
		}
		?>
	</tbody>
</table>
</form>

<?php 
if(isset($_POST['filter']))
{
	?>
	<form method=post>
		<div class='table-responsive' id=''>
			
			<table style='width:100%' class='table-hover'>
				<thead>
				<tr>
					<td colspan=5>
						
					</td>
				</tr>
				<tr>
					<th>No.</th>
					<th>ID.</th>
					<th>NIK</th>
					<th>Nama</th>
					<th>Departemen</th>
					<th>Jabatan</th>
					<th>#</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$no=1;
				if(!empty($id_dep)){
					$query="and karyawan.id_jabatan='$id_dep'";
				}else $query=null;
				$q=tidak_hadir($id_jabatan,$tgl,$query);
				while($r=mysql_fetch_object($q)){
					?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $r->id_karyawan ?></td>
					<td><?php echo $r->nik ?></td>
					<td><?php echo $r->nama_lengkap ?></td>
					<td><?php echo @$r->nama_departemen ?></td>
					<td><?php echo @$r->nama_jabatan ?></td>
					<td>
						<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' class='btn bg-blue btn-flat btn-xs'>D</a>
						<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=skd&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-success btn-flat btn-xs'>SKD</a>
						<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=izin&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-info btn-flat btn-xs'>I</a>
						<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=alfa&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-danger btn-flat btn-xs'>A</a>
						<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=libur&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-danger btn-flat btn-xs'>LIBUR</a>
						<a href='<?php echo url("index.php?mn=data-tidak-hadir&ket=out&id=$r->id_karyawan&tanggal=$tgl&url=".url_ref()) ?>' class='btn btn-danger btn-flat btn-xs'>OUT</a>
				</td>
				</tr>
					<?php
				$no++;
				}
				?>
				</tbody>
			</table>
		</div>
		</form>
	<?php
}
?>
</div>
<script>
function detail_absen(id)
{
	$.ajax({
		url:laman+'api/gambar_absen.php?id='+id,
		success:function(html)
		{
			$("#gambar_base_absen").html(html);
			$("#gambar_absen").modal();
			
		}
	});
}


</script>

<div class="modal fade bs-example-modal-sm" id='gambar_absen' tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <i id='gambar_base_absen'></i>
    </div>
  </div>
</div>
