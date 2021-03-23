<?php @$tgllama=($_POST['tgl'] == "" ) ? date("d/m/Y - d/m/Y") : $_POST['tgl']; ?> <hr/>
<h3></h3>
<form method=post>
	<table>
		<tr>
			<td>NIK</td>
			<td><input type=text name='nik' /></td>
		</tr>
		<tr>
			<td>Tanggal</td>
			<td><input type=text name='tgl' id='reservation' value='<?php echo $tgllama ?>'/></td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td>
				<select name='hadir'>
					<option value='izin'>Izin</option>
					<option value='skd'>Sakit/SKD</option>
					<option value='alfa'>Alfa</option>
					<option value='pulang'>Setengah Hari(Izin/sakit)</option>
					<option value='pulang_libur'>Setengah Hari(Libur)</option>
					<option value='SPD'>SPD</option>
					<option value='libur'>Libur</option>
				</select> <br/>
				<textarea name='keterangan'></textarea>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type=submit name='tmb' value='Simpan' class='btn btn-success' />
				<!--<input type=submit name='print' value='Simpan dan Print' class='btn btn-info' />-->
			</td>
		</tr>
	</table>
</form>
<?php
include"fungsi/karyawan.php";
if(isset($_POST['tmb']))
{
	$nik=aman($_POST['nik']);
	$nik=cek_nik($nik);
	if(empty($nik))
	{
		echo alert_error("NIK Tidak ditemukan!");
	}
	else
	{
		@$tgllama=($_POST['tgl'] == "" ) ? date("d/m/Y - d/m/Y") : $_POST['tgl'];
		@$tgl=($_POST['tgl'] == "" ) ? date("d/m/Y - d/m/Y") : $_POST['tgl'];
		@$tgl=(explode("-",$tgl));
		$tglawal = (ubah_tanggal(trim($tgl[0])));
		$tglakhir = (ubah_tanggal(trim($tgl[1])));
		$total_range=date_diff(date_create($tglawal),date_create($tglakhir));
		$total_range=$total_range->format("%d") + 1;
		$jumlah_hari=$total_range;
		$b=$tglawal;
		$t=$tglakhir;
		@$hari=explode('-',$b);
		@$hari=$hari[2];
		$ket=empty($_POST['hadir']) ? "" : aman($_POST['hadir']);
		$keterangan=aman($_POST['keterangan']);
		$idkaryawan=$nik->id_karyawan;
		function banding_tgl($awal,$akhir){
			$q=mysql_query("SELECT DATEDIFF('$awal','$akhir') as date_difference");
			$r=mysql_fetch_array($q);
			return abs($r['date_difference']) + 1;
			
		}
		
		$jumlah_hari =  banding_tgl($tglawal,$tglakhir);
		for($i=0;$i<$jumlah_hari;$i++)
		{
			$date=date("Y-m-d",strtotime("+$i day", strtotime($tglawal)));
			$tgl=$date;
			$cek_absen=mysql_query("select * from absen where tanggal_absen='$tgl' and id_karyawan='$idkaryawan'");
				if(mysql_num_rows($cek_absen))
				{
					$Rcek=mysql_fetch_array($cek_absen);
					if(empty($Rcek['jam_keluar'])){
						$query=mysql_query("update absen set keterangan_hadir='$ket', keterangan='$keterangan', jam_keluar='00:00:00' where id_absen='$Rcek[id_absen]'");					
					}
					else
						$query=mysql_query("update absen set keterangan_hadir='$ket',keterangan='$keterangan' where id_absen='$Rcek[id_absen]'");					
				}
				else{
					$query=mysql_query("insert into absen (id_karyawan,tanggal_absen,keterangan_hadir,date_created,jam_masuk,jam_keluar,keterangan) 
					values('$idkaryawan','$tgl','$ket',now(),'00:00:00','00:00:00','$keterangan')");
				}
		}
		if($query)
			echo alert("Berhasil disimpan");
		else 
			echo alert_error("Error : ". mysql_error());
		
	}
	
}
?>