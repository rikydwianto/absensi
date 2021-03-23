<?php include_once"config/setting.php"; ?>
<?php include_once"config/koneksi.php"; ?>
<?php include_once"fungsi/config.php";
// proses
$awal = microtime(true);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php include"view/template/link-head.php" ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> Sparepart -  <?php echo $title?></title>
	<link rel="icon"  href="<?php echo url() ?>assets/img/logo.png"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<script type="text/javascript" src="<?php echo url('assets/plugins') ?>/webcam/webcam.js"></script>
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
		
		document.getElementById('nik').focus();
		
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
			document.getElementById("tanggal").innerHTML = thisDay + ', ' + day + ' ' + months[month] + ' ' + year;
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
			if(id=='11111111')
			{
				window.reload()
			}
			var gambar= take();
			var xhttp = new XMLHttpRequest();
			xhttp.open("POST", laman + "api/ambilan.php", true);
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
			kosong();
			return false;
		}	
		window.setTimeout("tanggal()",1); 
	</script>
	<style>
	#my_camera{
		display: none;
	}
	</style>
</head>

<body class="" oncaontextmenu="return false">
	<div class="container">
		<div class="row">
			<div class="login-logo">
				<center>
					<div class=" ">
						<h3>BAHAN - <?php echo $title?></h3>
					</div>
					<h3 class='line-header'><span id='tanggal'></span> <span id='lbl_jam'></span></h3>
				</center>
			</div>
			<div class='col-md-12 ' style='margin-top:0' id='status_masuk' align=center>
				<a href='<?php echo url('ambilan.php') ?>' class='btn btn-success btn-active'>Sparepart</a>
				<a href='<?php echo url('bahan.php') ?>' class='btn btn-danger'>Bahan</a> 
				<a href='<?php echo url('aksesoris.php') ?>' class='btn btn-primary'>Aksesoris</a> 
			</div>
			<div class='clearfix'></div>
			<div class="col-md-12 " >
				<form role="form" method='post' onsubmit='return absen(this)'>
					<fieldset>
						<input name="gambar" id="base64" type="hidden"  >
						<input class="form-control" onkeypress="return enter(event)" style='text-align:center' id='nik' placeholder="Nomor Induk Karyawan/NIK" name="nik" type="text"  autofocus>
					</fieldset>
				</form>
				<span id='absen'></span>
			</div>
			<?php 
			if(isset($_POST['lanjut']))
			{
				$id=($_POST['id_spare']);
				$id_ambil=post("idinput");
				$qty1=($_POST['qty']);
				$harga=($_POST['harga']);
				for($i=0;$i<count($id);$i++){
					if($qty1[$i] > 0)
					{
						mysql_query("update sparepart set stock_sparepart=stock_sparepart - $qty1[$i] where id_sparepart='$id[$i]'");
						$input=mysql_query("insert into detail_ambilan_sp(id_ambilan_sp,id_sparepart,qty_ambilan,harga_ambilan)
						values($id_ambil,'$id[$i]','$qty1[$i]','$harga[$i]')
						");
					}
				}
				if($input){
					mysql_query("update ambilan set status_ambilan='sukses' where id_ambilan_sp='$id_ambil'");
					// direct(menu("pengambilan_sparepart"));
					
				}
				else{
					echo alert_error("error :  ".mysql_error());
				}
			}
			?>
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
	</script>
</body>
</html>

