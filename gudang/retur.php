<?php include_once"config/setting.php"; ?>
<?php include_once"config/koneksi.php"; ?>
<?php include_once"fungsi/config.php";
// proses
$awal = microtime(true);
?>
<?php cek_login(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php include"view/template/link-head.php" ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $title?></title>
	<link rel="icon"  href="<?php echo url() ?>assets/img/logo.png"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<script type="text/javascript" src="<?php echo url('assets/plugins') ?>/webcam/webcam.js"></script>
	<script type="text/javascript" src="<?php echo url('assets/js') ?>/jquery.js"></script>
	<script>
	
	
	var laman="<?php echo url() ?>";
			// 1 detik = 1000 
	window.setTimeout("waktu()",1); 
		
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
		
		//document.getElementById('nik').focus();
		
		}
		
		function tanggal(){
			setTimeout("tanggal()",1); 
			var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
			var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu'];
			var date = new Date();
			var day = date.getDate();
			var month = date.getMonth();
			var thisDay = date.getDay(),
				thisDay = myDays[thisDay];
			var yy = date.getYear();
			var year = (yy < 1000) ? yy + 1900 : yy;
			$("#tanggal").html(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
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
		
		window.setTimeout("tanggal()",1); 
	</script>
	<style>
	#my_camera{
		display: none;
	}
	</style>
</head>

<body class="" oncontextmenu="return false">
	<div class="container">
		<div class="row">
			<div class="login-logo">
				<center>
					<div class=" ">
						<h3>RETUR BARANG - <?php echo $title?> </h3>
					</div>
					<h3 class='line-header'><span id='tanggal'></span> <span id='lbl_jam'></span></h3>
				</center>
			</div>
			<!--<div class='col-md-12 ' style='margin-top:0' id='status_masuk' align=center>
				<a href='' class='btn btn-success btn-active'>Reload</a>
			</div> -->
			<div class='clearfix'></div>
			<input class="form-control" style='text-align:center' id='nik' placeholder="NOMOR INDUK KARYAWAN / NIK" name="nik" type="text"  autofocus>
			<div class="col-md-12 " >
				<form role="form" id='form' method='post' onsubmit='return false'>
					<fieldset>
						<input name="gambar" id="base64" type="hidden"  >
						<input class="form-control" style='text-align:center' id='barang' placeholder="Silahkan Cari Nama/Barang Barang yang dibutuhkan" name="barang" type="text"  autofocus>
					</fieldset>
				</form>
				<form id='form_barang'>
					<span id='barang_area'></span>
				</form>
			</div>
			
			<div class='col-md-4'>
					<center><span class='' id="my_camera" ></span></center>
					<script language="JavaScript">
					Webcam.set({
						width: 960,
						height: 720,
						image_format: 'jpeg',
						jpeg_quality: 500
					});
					Webcam.attach( '#my_camera' );
					</script>

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
	
   $("#nik").keydown(function(e) {
    	var nik  = $(this).val();
    	var gambar= take();
	        var code = (e.keyCode ? e.keyCode : e.which);
	        if(code==13)// Enter key hit
	        {
				alert('asaa');
	           barcode=barcode+String.fromCharCode(code);
		        $.ajax({
		 			url:laman + 'api/cari_nik.php',
		 			data:'nik='+nik+ '&gambar='+gambar,
		 			type:'post',
		 			beforeSend:function(h){
		 				$("#barang_area").html("Sedang memeriksa NIK Karyawan, tunggu sebentar ...");
		 			},
		 			success:function(html){
		 				if(html=='tidak'){
			 				$("#barang_area").html("<h1>NIK "+ nik +" TIDAK DITEMUKAN, PROSES TIDAK DAPAT DILANJUTKAN!</h1>");
		 				}
		 				else{
			 				$("#barang_area").html("Silahkan cari barang yang dibutuhkan");
		 					id = html;
		 					tampil();
		        			$("#nik").hide(100);
		        			$("#form").show(600);
		        			$("#barang").focus();
		 					
		 				}
		 				

		 			}
		 		});
	 			$("#nik").val('');
		    }
	 			barcode='';
	    });
    });

	$(window).keydown(function(){
		$("#nik").focus();
		//$("#barang").focus();
	});
	 $(window).bind('beforeunload', function(){
		  return 'Are you sure you want to leave?';
		});
	</script>
</body>
</html>

