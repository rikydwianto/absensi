<?php 
include_once"config/setting.php";
include_once"fungsi/config.php";
include_once"fungsi/lihat.php";
// proses
$awal = microtime(true);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CARI NIK -  <?php echo $title?></title>
	<link rel="icon"  href="<?php echo url() ?>assets/img/logo.png"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo url('assets') ?>/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo url('assets/dist') ?>/css/AdminLTE.absen.css">
	<script type="text/javascript" src="<?php echo url('assets/plugins') ?>/webcam/webcam.js"></script>
	<script>
	var laman="<?php echo url() ?>";
			// 1 detik = 1000 
	// window.setTimeout("waktu()",1); 
		
	function waktu() { 
		var tanggal = new Date(); 
		// setTimeout("waktu()",1); 
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
		
		function absen(id) {
			id= document.getElementById("nik").value;
			var gambar= take();
			var xhttp = new XMLHttpRequest();
			xhttp.open("GET", laman + "api/cari.php?nik="+ id + "&gambar="+ gambar , true);
			xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
			  document.getElementById("absen").innerHTML = xhttp.responseText;
			}
			else{
				
			}
			};
			
			xhttp.send();
			kosong();
			return false;
		}	
	</script>
</head>

<body class="hold-transition login-page">

    <div class="container">
       
        <div class="row">
			
            <div class="col-md-8 col-md-offset-2" >
                <div class="login-box" >              
                    <div class="login-logo">
						<div class=" ">
						  <a href='<?php echo url_sekarang() ?>'><img src="<?php echo url() ?>assets/img/logo.png" alt=""/></a>
							<h4><?php echo $title?></h4>
						</div>
						<h4 class='line-header'><?php echo tanggal(date("Y-m-d"))?></h4>
						<h4 class='line-header'><span id='lbl_jam'></span></h4>
                    </div>
					
                    <div class="login-box-body">
					
						<br/>
                        <form role="form" method='post' onsubmit='return absen(this)'>
							<fieldset>
							
								<div class="form-group">
									<input name="gambar" id="base64" type="hidden"  >
									<input class="form-control" onkeypress="return" style='text-align:center' id='nik' placeholder="Nomor Induk Karyawan/NIK" name="nik" type="text"  autofocus>
								</div>
							</fieldset>
						</form>
						<span id='absen'></span>			
                    </div>
					<div class='helper-block'>
						<br/>
						<center>
							<strong>
							<h3><?php echo $nm_aplikasi?></h3>
							</strong>
						</center>
					</div>
                </div>
            </div>
        </div>
    </div>

     <!-- Core Scripts - Include with every page -->
</body>

</html>

