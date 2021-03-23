<?php 
include"../config/setting.php";
include"../config/koneksi.php";
include"../fungsi/config.php";
include"../fungsi/lihat.php";
include"../fungsi/karyawan.php";
include"../fungsi/absen-absen.php";
include"../fungsi/jabatan.php";
include"../fungsi/departemen.php";
require_once('../library/excel/PHPExcel.php');
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("PT Lydia Sola Gracia")
->setLastModifiedBy("PT Lydia Sola Gracia")
->setTitle("Laporan PT Lydia Sola Gracia")
->setSubject("Laporan Karyawan")
->setDescription("Data karyawan ")
->setKeywords("karyawan")
->setCategory("Laporan");

$tgl=$_GET['tgl'];
header('Content-Type: applicatio n/vnd.ms-excel' );
header('Content-Disposition: attachment;filename="Data Absen '.$tgl.'.xls"' );
header('Cache-Control: max-age=0');
function nama_karyawan($id)
{
	$q=mysql_query("select nama_lengkap from karyawan where id_karyawan='$id'");
	$r=mysql_fetch_array($q);
	return $r['nama_lengkap'];
}
?>
<style>
table {
    table-layout: fixed;
	 border-collapse: collapse;
} 
	table tr td{
		vertical-align: text-top;
		padding:0;
	}
</style>


Tanggal : <?php echo tanggal($tgl)?> <br/>


Jumlah Karyawan : <?php echo $semua= hitung_karyawan()?><br/>


Masuk : <?php echo $hit_absen = hitung_absen($tgl) ?><br/>


Keluar : <?php echo hitung_keluar($tgl) ?><br/>

<span class="info-box-text">Alfa : <?php echo hitung_alfa($tgl) ?></span>
<span class="info-box-text">Izin : <?php echo hitung_izin($tgl) ?></span>
<span class="info-box-text">Sakit : <?php echo hitung_sakit($tgl) ?></span>
<span class="info-box-text">Telat : <?php echo hitung_telat($tgl) ?></span>
<span class="info-box-text">Tidak Absen : <?php echo tidak_absen($tgl) ?></span>

<table border=1  >
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Departemen</th>
			<th>Jabatan</th>
			<th>Shift</th>
			<th>Kehadiran</th>
			<th>Telat</th>
			<th>Masuk</th>
			<th>Keluar</th>
			<th>Lembur</th>
			<th>Menit</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no=1;
		$q=tampil_absen('','',$tgl);
		while($r=mysql_fetch_object($q))
		{	
			$jab=cari_jabatan($r->id_jabatan);
			$dep=cari_dep($jab->id_departemen);


		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td>
				<?php echo $r->nama_lengkap ?>
			</td>
			<td><?php echo $dep->nama_departemen ?></td>
			<td><?php echo $jab->nama_jabatan ?></td>
			<td>
				<?php 
				if($r->shift==null )
				{
					if($r->keterangan_hadir==null)
						echo 1;
				}
				else
					echo $r->shift;
				?>
			</td>
			<td>
				<?php echo $r->keterangan ?>
			</td>
			<td>
				<?php echo ($r->telat=='ya') ? "<b class='label label-danger'>Telat</b>" : "" ?>
			</td>
			<td>
				<?php echo $r->jam_masuk; ?>
			</td>
			<td>
				<?php echo $r->jam_keluar; ?>
			</td>
			<td><?php echo $r->lembur; ?></td>
			<td><?php echo $r->menit_lembur; ?></td>
			<td>
				<?php echo $r->keterangan_hadir ?>
			</td>
		</tr>
			<?php
			$no++;
		}
		?>
	</tbody>
</table>
<?php

exit;

?>
