<form method=post>
	<table class='table'>
		<tr>
			<td>
			Tanggal
			</td>
			<td>
				<div class="input-group">
				  <div class="input-group-addon">
					<i class="fa fa-calendar"></i>
				  </div>
				 <input type=text class='form-control' value='<?php echo date("d/m/Y") ?>' required name='tgl' id='tgl1' data-inputmask="'alias': 'dd-mm-yyyy hh:mm:00'" data-mask>
				</div><!-- /.input group -->
			</td>
		</tr>
		<tr>
			<td>
			Jam mulai(JJ:MM:DD)
			</td>
			<td>
				<input type=text class='' required value='17:00:00' name='mulai' data-inputmask="'alias': 'hh:mm:ss'" data-mask>
				<!-- <input type=text class='' required value='19:00:00' name='selesai' data-inputmask="'alias': 'hh:mm:ss'" data-mask> -->
			</td>
		</tr>
		<tr>
			<td>
				Keterangan
			</td>
			<td>
				<textarea name='ket' placeholder='Keterangan lemburan ... ' class='form-control'></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><button input type=submit name='tmb-lembur' class='btn btn-flat bg-navy'><i class='fa fa-plus'></i> Aktifkan Lemburan</button></td>
		</tr>
	</table>
</form>
<?php
if(isset($_POST['tmb-lembur']))
{
	$tgl=aman($_POST['tgl']);
	$ket=aman($_POST['ket']);
	$mulai=aman($_POST['mulai']);
	$selesai=null;//aman($_POST['selesai']);
	$pecah=explode(" ",$tgl);
	$tanggal=explode('/',$pecah[0]);
	$gb=$tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];	
	
	$cek=lembur_hari($gb);
	
	
	
	if(mysql_num_rows($cek) < 1 )
	{
		$q=input_lembur($gb,$mulai,$selesai,$ket);
		if($q)
		{
			echo alert("Lembur pada ". tanggal($gb) ." Jam : $mulai Sudah diaktifkan");
		}
		else
		{
			echo alert_error("Error : ". mysql_error());
		}
	}
	else{
		$cek=mysql_fetch_object($cek);
		echo alert_error("Lemburan pada ". tanggal($gb) .' Sudah diinput pada '. waktu(date($cek->date_created)));
	}
}
?>