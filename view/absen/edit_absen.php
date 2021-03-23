
<?php 
error_reporting(0);
$id=aman($_GET['id_absen']);
if(isset($_POST['edit_absen'])){
	$lembur=aman($_POST['lembur']);
	$ket_hadir=aman($_POST['ket_hadir']);
	$keterangan=aman($_POST['keterangan']);
	$shift=aman($_POST['shift']);
	$jam_masuk=($_POST['jam_masuk']);
	$jam_keluar=($_POST['jam_keluar']);
	$menit_lembur=($_POST['menit']);
	if($jam_keluar==''){
		mysql_query("update absen set jam_keluar=NULL where id_absen='$id'");
	}
	else{
		mysql_query("update absen set jam_keluar='$jam_keluar' where id_absen='$id'");
	}
	echo $jam;
	$tgl=ubah_tanggal($_POST['tgl']);
	$q=mysql_query("
	update absen set lembur='$lembur',keterangan_hadir='$ket_hadir',keterangan='$keterangan', shift='$shift',menit_lembur='$menit_lembur',
	date_modified=now(), jam_masuk='$jam_masuk', tanggal_absen='$tgl', date_created='2016-11-01 06:39:33', date_modified='2016-11-01 18:33:55'
	where id_absen='$id';
	");

	if($q)
	{
		echo alert("Berhasil diedit");
	}
	else
	{
		echo alert_error("Error : ". mysql_error());
	}
}
$absen=edit_absen($id);
$karyawan=detail_karyawan($absen->id_karyawan);
?>
<a href='<?php echo (isset($_GET['url']) == '') ? url('index.php?mn=absen') : $_GET['url'] ?>' class='btn btn-flat btn-danger'><i class='fa fa-angle-double-left'></i> Kembali</a>
<form method=post>
	<table class='table'>
		<tr>
			<td>
			Nama[Nik]
			</td>
			<td>
				<?php echo $karyawan->nama_lengkap ?>[<?php echo $karyawan->nik ?>]
			</td>
		</tr>
		<tr>
			<td>
			Tanggal
			</td>
			<td>
				<input type=text name='tgl' id='tgl1' value='<?php echo date("d/m/Y",strtotime($absen->tanggal_absen ))?>' />
			</td>
		</tr>
		<tr>
			<td>
			Jam Masuk - Jam Keluar
			</td>
			<td>
				<input type=text name='jam_masuk' value='<?php echo $absen->jam_masuk ?>' /> - 
				<input type=text name='jam_keluar' value='<?php echo $absen->jam_keluar ?>' />
				<?php echo ($absen->telat=='ya') ? "<b class='label label-danger'>Telat</b>" : "" ?>
			</td>
		</tr>
		<tr>
			<td>
				Lembur
			</td>
			<td>
				<?php 
				if($absen->lembur=='ya'){
					$ya="checked";	
				}
				else if($absen->lembur=='tidak'){
					$tidak="checked";
				}
// $tidak="checked";
				?>
				<label><input <?php echo @$ya ?> type=radio name='lembur' value='ya'/> Ya</label> &nbsp;
				<label><input <?php echo @$tidak ?> type=radio name='lembur' value='tidak'/> Tidak</label>
			</td>
		</tr>
		<tr>
			<td>Shift</td>
			<td><input type='number' maxlength=3 name='shift' value='<?php echo $absen->shift ?>'/></td>
		</tr>
		<tr>
			<td>Lembur(Menit)</td>
			<?php 
				
			@$jam = (($absen->jam_keluar));
			@$menit=round(cari_menit(date('15:00:00'),$jam));
			if($menit>0)
				$aaa = round(@$menit);
			else $aaa = 0;
			?>
			<td><input type='number' maxlength=3 name='menit' value='<?php echo $absen->menit_lembur ?>'/></td>
		</tr>
		<tr>
			<td>
				Keterangan
			</td>
			<td>
				<select name='ket_hadir' class='form-control'>
					<option value=''>Hadir</option>
					<?php 
					$ket_hadir=$absen->keterangan_hadir;
					// $ket_hadir='';
					if($ket_hadir=='izin')
						$izin='selected';
					else if($ket_hadir=='alfa')
						$alfa='selected';
					else if($ket_hadir=='sakit')
						$sakit='selected';
					else if($ket_hadir=='skd')
						$skd='selected';
					else if($ket_hadir=='pulang')
						$pulang='selected';
					else if($ket_hadir=='pulang_libur')
						$pulang_libur='selected';
					else if($ket_hadir=='libur')
						$libur='selected';
					else if($ket_hadir=='spd')
						$spd='selected';
					else if($ket_hadir=='out')
						$out='selected';
					else if($ket_hadir=='off')
						$off='selected';
					else if($ket_hadir=='lembur')
						$lem='selected';
					else if($ket_hadir=='masuk_setengah_hari')
						$set='selected';
					?>
					<option <?php echo @$izin ?> value='izin'>Izin</option>
					<option <?php echo @$alfa ?> value='alfa'>Alfa</option>
					<option <?php echo @$skd ?> value='skd'>SKD</option>
					<option <?php echo @$pulang ?> value='pulang'>Izin / Setengah Hari</option>
					<option <?php echo @$pulang_libur ?> value='pulang_libur'>Libur / Setengah Hari</option>
					<option <?php echo @$set ?> value='masuk_setengah_hari'>Masuk / Setengah Hari</option>
					<option <?php echo @$libur ?> value='libur'>Libur</option>
					<option <?php echo @$spd ?> value='spd'>SPD</option>
					<option <?php echo @$out ?> value='out'>OUT</option>
					<option <?php echo @$off ?> value='off'>DIBERHENTIKAN</option>
					<option <?php echo @$lem ?> value='lembur'>LEMBUR SATPAM</option>
				</select>
				<textarea name='keterangan' class='form-control'><?php echo $absen->keterangan?></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<button input type=submit name='edit_absen' class='btn btn-flat bg-navy'><i class='fa fa-save'></i> Simpan</button>
			</td>
		</tr>
	</table>
</form>
