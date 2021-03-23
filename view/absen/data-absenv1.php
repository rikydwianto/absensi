<?php 
if(isset($_GET['cr']))
{
	$tgl=$_GET['tgl'];
	$ex=explode("/",$tgl);
	$tgl=$ex[2].'-'.$ex[1].'-'.$ex[0];
}
else
	$tgl=date("Y-m-d");
?>
<h2>Data Absen <?php echo tanggal($tgl) ?></h2>
<form method=get>
Pilih  : 
<input type=hidden name='mn' value='absen' id=''/>
<input type=text name='tgl' value='<?php echo date("d/m/Y",strtotime(@$tgl)) ?>' id='tgl1' data-inputmask="'alias': 'dd/mm/yyyy'" data-mask />
<input type=submit value='Cari' class='' name='cr'/>
</form>

<br/>
<?php include"view/absen/hitung-absen.php"; ?>
<table class='table-hover' style='width:100%' id=''>
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Jam-Keluar</th>
			<th>Lembur(Menit)</th>
			<th>#</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no=1;
		$q=tampil_absen($tgl);
		while($r=mysql_fetch_object($q))
		{	
			$detail=detail_karyawan($r->id_karyawan);
			$jab=cari_jabatan($detail->id_jabatan);
			$dep=cari_dep($jab->id_departemen);


		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td>
				<a href='<?php echo url('index.php?mn=detail_karyawan&id='.$detail->id_karyawan.'&nik='.$detail->nik) ?>' target=_blank>
					<?php echo $detail->nama_lengkap ?> [<?php echo $dep->nama_departemen ?>]
				</a>
			</td>
			<td>
				<?php echo $r->jam_masuk; ?> - <?php echo $r->jam_keluar; ?>
				<?php echo ($r->telat=='ya') ? "<span class='label label-danger'>Telat</span>" : "" ?>
			</td>
			<td><?php echo $r->lembur; ?>(<?php echo $r->menit_lembur; ?>)</td>
			<td>
				
			</td>
		</tr>
			<?php
			$no++;
		}
		?>
	</tbody>
</table>