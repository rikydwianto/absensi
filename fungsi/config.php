<?php
//Tracking
function track(){
	$agent = $_SERVER['HTTP_USER_AGENT'];	//tipe browser
	$URI = $_SERVER['REQUEST_URI']; // MELIHAT SCRIPT DI EKSEKUSI DARI MANA GET(URL)
	$IP = $_SERVER['REMOTE_ADDR']; //MELIHAT IP 
	$REF = url_sekarang();//IMELIHAT SCRIPT DI REFER DARI MANA
	$ASLI =//$_SERVER['HTTP_X_FORWARDED_FOR'];//MELIHAT RPOXY PENGUNJUNG
	$VIA =//$_SERVER['HTTP_VIA'];//MELIHAT KONEKSI PENGUNJUNG
	$DTIME = DATE('r');//TANGGAL
$ENTRY_LINE = "WAKTU: " .$DTIME."| IP: ".$IP."| BROWSER: ".$agent."| URL: ".$URI."| REFERRER: ".$REF."| PROXY: ".$ASLI."| KONEKSI: ".$VIA."
	";
	$FP  =fopen("data_log.txt","a");
	fputs($FP,$ENTRY_LINE);
	fclose($FP);

}
track();
function url($l=null)
{
	$url= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
	$url.= "://".$_SERVER['HTTP_HOST'];
	$url.= preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])).'/';

	if($l==null)
		$tambah='';
	else
		$tambah=$l;
	
	return $url.$tambah;
}
function waktu($tgl)
{
	$tgl=date($tgl);
	$hari=array('Minggu','Senin','Selasa','Rabu','Kamis',"Jum'at",'Sabtu');
	$bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$tanggal=date('Y-m-d', strtotime($tgl));
	$angka=date('w',strtotime($tgl));
	$bln=(int)date('m',strtotime($tgl));
	$day=date('d',strtotime($tgl));
	$thn=date('Y',strtotime($tgl));
	$semua=$hari[$angka].', '.$day.' '.$bulan[$bln].' '.$thn;
	return date("H:i",strtotime($tgl)).' '.$semua;
	//$wak=strtotime($time);
	//return date("H:i d-m-Y",$wak);
}

function tanggal($tgl)
{
	$tgl=date($tgl);
	$hari=array('Minggu','Senin','Selasa','Rabu','Kamis',"Jum'at",'Sabtu');
	$bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$tanggal=date('Y-m-d', strtotime($tgl));
	$angka=date('w',strtotime($tgl));
	$bln=(int)date('m',strtotime($tgl));
	$day=date('d',strtotime($tgl));
	$thn=date('Y',strtotime($tgl));
	$semua=$hari[$angka].', '.$day.' '.$bulan[$bln].' '.$thn;
	return $semua;
}

function cek_hari($tgl)
{
	$tgl=date($tgl);
	$hari=array('Minggu','Senin','Selasa','Rabu','Kamis',"Jum'at",'Sabtu');
	$bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$tanggal=date('Y-m-d', strtotime($tgl));
	$angka=date('w',strtotime($tgl));
	$bln=(int)date('m',strtotime($tgl));
	$day=date('d',strtotime($tgl));
	$thn=date('Y',strtotime($tgl));
	$semua=$hari[$angka];
	return $semua;
}

function cek_bulan($bln)
{
	$bln=(int)$bln;
	$bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$semua=$bulan[$bln];
	return $semua;
}

function aman($text){
	return mysql_real_escape_string(htmlspecialchars($text));
	
}
function url_ref(){
	return urlencode(url_sekarang());
}
function folder_photo($text)
{
	return"data/foto/$text";
}
function direct($url){
	?>
	<script>
		window.location.href='<?php echo $url ?>';
	</script>
	<?php
}
function url_sekarang()
{
	$url= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
	$url.= "://".$_SERVER['HTTP_HOST'];
	$url.=$_SERVER['REQUEST_URI'];
	return ($url);
}
function cek_login()
{

	if(!isset($_SESSION['id_user']))
	{
		direct(url('login.php?url='.url_ref()));
	}
}

function alert($text)
{
	return "
	<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
			$text
	</div>
	";
}
function alert2($text)
{
	return "
	<script>
		alert('$text');
	</script>
	";
}
function alert_error($text)
{
	return "
	<div class='alert alert-danger alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
			$text
	</div>
	";
}

function jk($id)
{
	if($id==0)
		return "Laki - laki";
	else if($id==1)
		return "Perempuan";
	else
		return "tidak terdefinisi";
}
function status($id){
	switch($id){
		case"0":
			return "Belum Nikah";
		break;
		case"1":
			return "Nikah";
		break;
		case"2":
			return "Janda";
		break;
		case"3":
			return "Duda";
		break;
		default:
			return "Tidak didefinisikan.";
		break;
	}
}



function cek($text)
{
	if(empty($cek))
		return " - ";
	else
		return $text;
}



function umur($tgl1, $tgl2=null){
	$tgl2=date("Y-m-d");
	$tgl1 = (is_string($tgl1) ? strtotime($tgl1) : $tgl1);
	$tgl2 = (is_string($tgl2) ? strtotime($tgl2) : $tgl2);
	$diff_secs = abs($tgl1 - $tgl2);
	$base_year = min(date("y", $tgl1), date("y", $tgl2));
	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	return array( "years" => date("y", $diff) - $base_year,
	"months_total" => (date("y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
	"months" => date("n", $diff) - 1,
	"days_total" => floor($diff_secs / (3600 * 24)),
	"days" => date("j", $diff) - 1,
	"hours_total" => floor($diff_secs / 3600),
	"hours" => date("g", $diff),
	"minutes_total" => floor($diff_secs / 60),
	"minutes" => (int) date("i", $diff),
	"seconds_total" => $diff_secs,
	"seconds" => (int) date("s", $diff));
}



function lama_kerja($tgl1, $tgl2){
	$tgl1 = (is_string($tgl1) ? strtotime($tgl1) : $tgl1);
	$tgl2 = (is_string($tgl2) ? strtotime($tgl2) : $tgl2);
	$diff_secs = abs($tgl1 - $tgl2);
	$base_year = min(date("y", $tgl1), date("y", $tgl2));
	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	return array( "years" => date("y", $diff) - $base_year,
	"months_total" => (date("y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
	"months" => date("n", $diff) - 1,
	"days_total" => floor($diff_secs / (3600 * 24)),
	"days" => date("j", $diff) - 1,
	"hours_total" => floor($diff_secs / 3600),
	"hours" => date("g", $diff),
	"minutes_total" => floor($diff_secs / 60),
	"minutes" => (int) date("i", $diff),
	"seconds_total" => $diff_secs,
	"seconds" => (int) date("s", $diff));
}
function status_karyawan($id)
{
	$status=null;
	if($id=='1')
		$status='Training';
	else if($id=='2')
		$status="Kontrak";
	else if($id=='3')
		$status="Tetap";
	else if($id=='4')
		$status="Off";
	else if($id=='5')
		$status="Resign";
	else
		$status="Undefinied";
	return $status;
}


function cari_menit($awal,$akhir)
{
	
	list($h,$m,$s) = explode(":","$awal");
	$dtAwal = mktime($h,$m,$s,"1","1","1");
	list($h,$m,$s) = explode(":","$akhir");
	$dtAkhir = mktime($h,$m,$s,"1","1","1");
	$dtSelisih = $dtAkhir-$dtAwal;

	return ($dtSelisih/60);
}

function ubah_tanggal($tgl){
	$tgl=date($tgl);
	$pecah=explode("/",$tgl);
	$tanggal=$pecah[2].'-'.$pecah[1].'-'.$pecah[0];
	return $tanggal;
}


function Upload($uploadName,$nik){
    $direktori          = "data/foto/";
    $direktoriThumb     = "data/foto/thumb/";
    $file               = $direktori.$nik.'.jpg';
   
    //simpan gambar ukuran sebenernya
    $realImagesName     = $uploadName['tmp_name'];
    //move_uploaded_file($realImagesName, $file);
   
    //identitas file gambar
    $realImages             = imagecreatefromjpeg($file);
    $width                  = imageSX($realImages);
    $height                 = imageSY($realImages);
   
    //simpan ukuran thumbs
    $thumbWidth     = $width / 2.5;
    $thumbHeight    = $height / 2.5;
   
    //mengubah ukuran gambar
    $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
    imagecopyresampled($thumbImage, $realImages, 0,0,0,0, $thumbWidth, $thumbHeight, $width, $height);
   
    //simpan gambar thumbnail
    imagejpeg($thumbImage,$direktoriThumb.$nik.'.jpg');
   
    //hapus objek gambar dalam memori
    imagedestroy($realImages);
    imagedestroy($thumbImage);
    }
	
	

function duatanggal($tgl1, $tgl2){
	 date_default_timezone_set("Asia/Jakarta");
	$tgl1 = strtotime($tgl1);
	$tgl2 = strtotime($tgl2);
	$diff_secs = abs($tgl1 - $tgl2);
	$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "	" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
}

function rupiah($uang){
 $jadi = "Rp. " . number_format($uang,2,',','.');
	return $jadi;

}