<?php 
include_once"config/setting.php";
include_once"fungsi/config.php";
include_once"fungsi/lihat.php";
// proses
$awal = microtime(true);

?>
<!DOCTYPE html>
<html oncontextmenu="return false">
<head>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Mesin Absen -  <?php echo $title?></title>
	<link rel="icon"  href="<?php echo url() ?>assets/img/logo.png"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo url('assets') ?>/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo url('assets/dist') ?>/css/AdminLTE.absen.css">
	<script type="text/javascript" src="<?php echo url('assets/plugins') ?>/webcam/webcam.js"></script>
	<script>
	var laman="<?php echo url() ?>";
			// 1 detik = 1000 
	window.setTimeout("waktu()",1); 
	window.setTimeout("rekam()",3000); 
		
	function waktu() { 
		var tanggal = new Date(); 
		setTimeout("waktu()",1); 
		var menit=tanggal.getMinutes();
		var menit_tampil;
		if(menit<10)
			menit_tampil="0" + menit;
		else
			menit_tampil=menit; 
		
		var jam=tanggal.getHours();
		var jam_tampil;
		if(jam<10)
			jam_tampil="0"+jam;
		else
			jam_tampil=jam;
		var detik=tanggal.getSeconds();
		var detik_tampil;
		if(detik<10)
			detik_tampil="0"+detik;
		else
			detik_tampil=detik;
		
		
		document.getElementById("lbl_jam").innerHTML =jam_tampil+":"+menit_tampil+":"+detik_tampil; 
		
		document.getElementById('nik').focus();
		
		}
		
		function tanggal(){
			setTimeout("tanggal()",1); 
			var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
			var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
			var date = new Date();
			var day = date.getDate();
			var month = date.getMonth();
			var thisDay = date.getDay(),
				thisDay = myDays[thisDay];
			var yy = date.getYear();
			var year = (yy < 1000) ? yy + 1900 : yy;
			document.getElementById("tanggal").innerHTML = thisDay + ', ' + day + ' ' + months[month] + ' ' + year;
		}
		tanggal();
		function take()
		{
			var apa=null;
			Webcam.snap(function(data_uri){
				var raw_image_data = data_uri;		
				apa=raw_image_data;
			});
			return apa;
		}
		function kosong()
		{
			document.getElementById("nik").value='';
		}
		
		function cek_status(id) {
			var gambar= take();
			var xhttp = new XMLHttpRequest();
			xhttp.open("GET", laman + "api/status_masuk.php?nik="+ id, true);
			xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
			  document.getElementById("status_masuk").innerHTML = xhttp.responseText;
			}
			else{
				
			}
			};
			
			xhttp.send();
			return false;
		}
		
		function absen(id) {
			id= document.getElementById("nik").value;
			if(id=='11111111')
			{
				window.reload()
			}
			var gambar= take();
			var xhttp = new XMLHttpRequest();
			xhttp.open("POST", laman + "api/absen.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("nik="+ id + "&gambar="+ gambar);
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
				  document.getElementById("absen").innerHTML = xhttp.responseText;
				}
				else{
					
				}
			};
			
			// xhttp.send();
			cek_status(id);
			kosong();
			return false;
		}	
		function rekam() {
			setTimeout("rekam()",3000); 
			var gambar= take();
			var xhttp = new XMLHttpRequest();
			xhttp.open("POST", laman + "api/rekam_camera.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("gambar="+ gambar);
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
				 /* alert('a'); */
				}
				else{
					
				}
			};
			
			// xhttp.send();
			return false;
		}
		rekam();
		</script>
</head>

<body class="" oncontextmenu="return false">
	<div class="container">
		<div class="row">
			<div class="login-logo">
				<div class=" ">
					<h3><?php echo $title?></h3>
				</div>
				<h3 class='line-header'><span id='tanggal'></span> <span id='lbl_jam'></span></h3>
			</div>
			<div class='col-md-12 hold-transition' style='margin-top:0' id='status_masuk' align=center></div>
			<div class="col-md-12 hold-transition login-page" >
				<div class='col-md-4'>
					<center><span class='' id="my_camera" ></span></center>
					<script language="JavaScript">
					Webcam.set({
						width: 320,
						height: 280,
						image_format: 'jpeg',
						jpeg_quality: 100
					});
					Webcam.attach( '#my_camera' );
					</script>

				</div>
				
				<div class='col-md-8'>
					<div class="login-box" >              
						<div class="">
						
							<form role="form" method='post' onsubmit='return absen(this)'>
								<fieldset>
								
									<div class="form-group">
										<input name="gambar" id="base64" type="hidden"  >
										<input class="form-control" onkeypress="return enter(event)" style='text-align:center' id='nik' placeholder="Nomor Induk Karyawan/NIK" name="nik" type="text"  autofocus>
									</div>
								</fieldset>
							</form>
							<span id='absen'></span>
						</div>
					</div>
				</div>
			</div>
			<div class='helper-block'>
				<br/>
				<center>
					<strong>
					<h3><?php echo $nm_aplikasi?></h3>
					</strong>
					<?php 
					$akhir = microtime(true);
					$lama = $akhir - $awal;
					$detik= "Time: ".round($lama,3)." microsecond";

					?>
					<?php echo $detik ?>
				</center>
			</div>	
		</div>
	</div>
	<script>
	function enter(event) {
			var charCode = event.which || event.keyCode;

			if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
			else return true;			
	}
	</script>
</body>
</html>

