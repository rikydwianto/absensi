<?php include_once"../config/setting.php"; ?>
<?php include_once"../config/koneksi.php"; ?>
<?php include_once"../fungsi/config.php"; ?>
<style>
#qty{
	width:80px;
}
</style>
<?php
if(isset($_POST['nik']))
{
	$skr=date("H:i:s");
	$nik=post("nik");
	$nik=mysql_query("select * from karyawan join jabatan on jabatan.id_jabatan=karyawan.id_jabatan join departemen on departemen.id_departemen=jabatan.id_departemen where nik='$nik'") or die(alert_error("Error : ".mysql_error()));
	$nik=mysql_fetch_array($nik);
	if(!empty($nik['id_karyawan'])){
			$status='ya';
	}
	else
	{
		echo alert_error("<h4><b>Operasi dihentikan, NIK Tidak ditemukan!</b></h4>");
	}
}
//ACTION UNTUK TAMBAH AMBILAN
if(@$status=='ya'){
	?>
		<table class='table'>
			<thead>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td><?php echo $nik['nama_lengkap'] ?></td>
				</tr>
				<tr>
					<td>Departemen</td>
					<td>:</td>
					<td><?php echo $nik['nama_departemen'] ?></td>
				</tr>
				<tr>
					<td>Jabatan</td>
					<td>:</td>
					<td><?php echo $nik['nama_jabatan'] ?></td>
				</tr>
			</thead>
		</table>
		<div class='row'>
		<?php
		$tgl=date("Y-m-d");
		$ket=post("ket");
		$q=mysql_query("insert into ambilan(id_karyawan,tanggal_ambilan,keterangan_ambilan,status_ambilan,date_created) values('$nik[id_karyawan]','$tgl','$ket','belum selesai',now())");
		if($q){
			$idinput=mysql_insert_id();
		}
		else{
			echo alert_error("Gagal, Koneksi/database error : ". mysql_error());
		}
		$gambar = str_replace(" ","+",post("gambar"));
		define('UPLOAD_DIR', '../data/foto-ambilan/');
		if(!file_exists(UPLOAD_DIR.date("Y-m-d")))
		{
			mkdir(UPLOAD_DIR. date("Y-m-d"));
		}
		$folder=UPLOAD_DIR. date("Y-m-d/");
		$img = $gambar;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$data = base64_decode($img);
		
		$name_file=$nik['nik'].' - '.$nik['nama_lengkap'].' - '.$idinput.'.jpg';
		$name_file=preg_replace('/[^A-Za-z0-9 _ .-]/', '', $name_file);
		$file = $folder . $name_file;
		@$success = file_put_contents($file, $data);
		//print $success ? $file : 'Unable to save the file.';
		mysql_query("update ambilan set photo_ambilan='$name_file' where id_ambilan_sp='$idinput'");
		?>
		<form method=post onsubmit="return true" id='formambilan'>
			<!--<table class='table-hover'> -->
				<?php
				$no=1;
				$qsparepart=mysql_query("select * from sparepart where berbayar='ya' order by nama_sparepart asc") or die(mysql_error());
				while($sparepart=mysql_fetch_array($qsparepart))
				{
					$qty=$sparepart['stock_sparepart'];
					if($qty<1)
					{
						$c="style='color:red'";
						$disabled='readonly';
						$stok="Stok abis";
					}
					else{
						$c='';
						$disabled='';
						$stok='';
					}
					?>
					<div class="col-md-3 " >
					<tr >
						<td>
							<label <?php echo $c; ?>>
								 <?php echo strtoupper($sparepart['nama_sparepart']) ?> [ <?php echo ($sparepart['stock_sparepart']) ?> ]
							</label>
						</td>
						<td>
							&nbsp;
						</td>
						<th>
							<input type=hidden value='<?php echo $idinput ?>' name='idinput' id='idinput' />
							<input type='hidden' name='id_spare[]' id='id_spare' id='cek_<?php echo $sparepart['id_sparepart']?>' value='<?php echo $sparepart['id_sparepart'] ?>' />
							<input type=number id='qty' name='qty[]' class='form-control' id='input_<?php echo $sparepart['id_sparepart']?>' <?php echo $disabled ?>/>
							<input type=hidden name='harga[]' class='form-control' id='input_' value='<?php echo $sparepart['harga_sparepart']?>' />					
						</th>
						</tr>
						<?php echo $stok; ?>
					</div>
					<?php
					$no++;
				}
				?>
				<div class='col-md-12'>
				<tr>
					<td colspan=3>
						<center><input id='ambil'onclick='ambilan()' onsubmit='ambilan()' type=submit value='Selesai' name='lanjut' class='btn btn-lg btn-danger'/> </center>
					</td>
				</tr>
				</div>
			<!-- </table> -->
		</form>
		<?php
}
?>
	</div>
