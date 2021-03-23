<script src="<?php echo url('assets/plugins/printarea/') ?>jquery-1.10.2.js" type="text/JavaScript" language="javascript"></script>
<style>
table tr th{
	text-align:center;
}
table tr td {
	text-align:center;
}
.nama{
	text-align:right;
}
</style>
<?php 
include_once"fungsi/absen-absen.php";
include_once"fungsi/karyawan.php";
include_once"fungsi/departemen.php";
include_once"fungsi/jabatan.php";
$breadcrumd=$_GET['mn'];
@$tgllama=($_GET['tgl'] == "" ) ? date("01/m/Y - t/m/Y") : $_GET['tgl'];
@$tgl=($_GET['tgl'] == "" ) ? date("01/m/Y - t/m/Y") : $_GET['tgl'];
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
@$id_jabatan=aman($_GET['jab']);
$bulannnn = date('m',strtotime($tglawal));
$tahunn = date('Y',strtotime($tglawal));
function banding_tgl($awal,$akhir){
	$q=mysql_query("SELECT DATEDIFF('$awal','$akhir') as date_difference");
	$r=mysql_fetch_array($q);
	return abs($r['date_difference']) + 1;
	
}
$jumlah_hari =  banding_tgl($tglawal,$tglakhir);
?>
<section class="content-header">
  <h1>
    Absen 
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Rekap Total Absen</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Rekap Total Tanggal .... sampai .... </h3>
		</div>
		<div class="box-body">
			<div >
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
				<a href='<?php echo url('index.php?mn=rekap_satpam') ?>' class='btn btn-success'><i class='fa fa-refresh'></i> REKAP KHUSUS SECURITY  </a>
				<a href='<?php echo url('laporan/rekap_absen_range.php?filter='.$id_jabatan.'&tgl='.$tgllama) ?>' class='btn btn-danger btn-flat'><i class='fa fa-excel-o'></i> Export Dept ini</a>
				<a href='<?php echo url('laporan/rekap_absen_range.php?tgl='.$tgllama) ?>' class='btn btn-danger btn-flat'><i class='fa fa-excel-o'></i> Export Semua Departemen </a>
				<a href='#' id='klikprint' class='btn btn-danger btn-flat'><i class='fa fa-print'></i> print</a>
			</div>
			<br/>
			<div>
				<div class='pull-right'>
				<form method=get>
					<input type=hidden value='rekap-total-range' name='mn'/>
					<select id='dept' name='jab' class='sel1ect2'>
						<option value=''>Departemen</option>
						<?php 
						$Qdep=tampil_departemen();
						
						while($rDep=mysql_fetch_object($Qdep))
						{
							if($rDep->id_departemen==@$id_jabatan)
								echo "<option value='$rDep->id_departemen' selected>$rDep->nama_departemen</option>";
							else
								echo "<option value='$rDep->id_departemen'>$rDep->nama_departemen</option>";
							
						}
						?>
					</select>
					<select  id='jabatan' name='id_jabatan'>
						<option value=''>-- Jabatan --</option>
						<?PHP
						$id_jab_dep=aman($_GET['id_jabatan']);
						$Qjab=jabatan_departemen(@$id_jabatan);						
						while($rJab=mysql_fetch_object($Qjab)){
						if($id_jab_dep==$rJab->id_jabatan)
							$select="selected";
						else
							$select="";
						echo "<option $select value='$rJab->id_jabatan'>$rJab->nama_jabatan</option>";
						}
						?>
					</select>
					<input type=text name='tgl' id='reservation' value='<?php echo @$tgllama ?>'  />
					<input type=submit value='Cari' name='cr'/>
					</form>

				</div>
				<br/>
				<br/>
				<div class='printarea'>
				<?php 
				error_reporting(0);
				$jab=cari_jabatan($id_jab_dep);
				$dep=cari_dep($id_jabatan);
				$hitung_libur_nasional=hitung_libur_nasional($b,$t);
				?>
				Nama Departemen : <?php echo @$dep->nama_departemen ?><br/>
				Jabatan			: <?php echo @$jab->nama_jabatan ?> <br/>
				Priode	 		: <?php echo tanggal($tglawal) ?> s/d <?php echo tanggal($tglakhir) ?><br/>
				Total Hari 		: <?php echo $jumlah_hari?>
								<div class='table-responsive '>
					<table border=1 class=' table- table-hover' style='width:100%'>
						<thead>
							<tr>
								<th colspan='18' bgcolor="#ffe6e6">
									<center>
										Rekap Total <?php echo tanggal($tglawal)?> s/d <?php echo tanggal($tglakhir)?> 
									</center>
								</th>
							</tr>
							<tr >
								<th rowspan=2><center>No.</center></th>
								<th rowspan=2 ><center>Nama </center></th>
								<th rowspan=2><center>NIK </center></th>
								<th rowspan=2><center>Jabatan</center></th>
								<th >Total Hari</th>
								<th rowspan=1>Libur</th>
								<th rowspan=1>Lembur  </th>
								<th rowspan=1>Lembur</th>
								<th colspan=3><center>Absensi</center></th>
								<th rowspan=1>Libur</th>
								<!--<th rowspan=2><center>Telat</center></th>-->
								<th colspan=2><center>Total</center></th>
								<!--<th rowspan=2><center>Berobat</center></th>-->
								<th rowspan=2><center>GRADE</center></th>
								<th rowspan=2><center>REVISI<br/> GRADE</center></th>
								<th rowspan=2><center>Keterangan</center></th>
							</tr>
							<tr >
								<th >Kerja</th>
								<th >Nasional</th>
								<th >Jam</th>
								<th >Hari</th>
								<th width='27px'><center>S</center></th>
								<th width='27px'><center>I</center></th>
								<th width='27px'><center>A</center></th>
								<th >Off</th>
								<th style='font-size:9px'>Tidak <br/>Masuk</th>
								<th>Masuk</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						if(empty($id_jab_dep))
						{
							$qtam="";
						}
						else
							$qtam=" and karyawan.id_jabatan='$id_jab_dep' ";
						$query="select id_karyawan,nik,nama_lengkap,nama_jabatan,datediff(curdate(),tgl_masuk) as lama_kerja,tgl_masuk,kode_departemen,status_karyawan from karyawan,jabatan,departemen where departemen.id_departemen=jabatan.id_departemen 
						and karyawan.id_jabatan=jabatan.id_jabatan  and departemen.id_departemen='$id_jabatan'  $qtam order by karyawan.tgl_masuk ";
						#and karyawan.status_karyawan!=5
						$query=mysql_query($query);
						$jm=0;
						$no=1;
						while($Kar=mysql_fetch_array($query))
						{
							$idkaryawan = $Kar['id_karyawan'];
							$hitung_absen = mysql_query("select count(id_absen) as absen from absen where (tanggal_absen between '$tglawal' and '$tglakhir') and id_karyawan='$Kar[id_karyawan]'");
							$hitung_absen = mysql_fetch_array($hitung_absen);
							// echo "  nik : $Kar[nama_lengkap]  =  ". $hitung_absen['absen'];
							if($hitung_absen['absen']<1)
							{
								$tampil = "tidak"; 
							}
							else{
								if($Kar['status_karyawan']==5 || $Kar['status_karyawan']==4){
								//echo "tidak akan ditampilkan";
									$tampil ='tidak';
								}
								else
								{
									$tampil = "ya"; 
								}
							}
							
							$cek_out = mysql_query("select id_absen from absen where (tanggal_absen between '$tglawal' and '$tglakhir') and id_karyawan='$Kar[id_karyawan]' and keterangan_hadir='out'");
							if(mysql_num_rows($cek_out)){
								$tampil='tidak';
							}
							

							if($tampil=='ya'){
								$cek_grade = mysql_query("select * from grade where id_karyawan='$idkaryawan' and bulan='$bulannnn' and tahun='$tahunn'");
								if(!mysql_num_rows($cek_grade)){
									$nilai = null;
									$revisi = null;
								}
								else{
									$cek_grade = mysql_fetch_array($cek_grade);
									$nilai = $cek_grade['grade'];
									$revisi = $cek_grade['revisi_grade'];
								}
								//echo "tidak akan ditampilkan";
							//JIKA TGL MASUK KURANG DARI TGL AWAL YG DIPILIH
							if(strtotime($b)<strtotime($Kar['tgl_masuk'])){
								$tgl_baru=$Kar['tgl_masuk'];
								$ulang=date_diff(date_create($tgl_baru),date_create($t));
								$ulang= banding_tgl($tgl_baru,$t) ;//$ulang->format("%d") + 1;
								//$jumlah_hari = banding_tgl($tgl_baru,$t) - banding_tgl($t,$tgl_baru);
								$jumlah_hari = $ulang;
								$ket="Masuk pada tanggal $tgl_baru";
								$sss  = banding_tgl($b,$tgl_baru) - 1;
							}
							else
							{
								$tgl_baru=null;
								$tgl_baru=$b;
								$ket="";
								$jumlah_hari =  banding_tgl($t,$b);
								$ulang=$jumlah_hari;
								$jumlah_hari = $ulang;
							}
							
							//JIKA KARYAWAN SPD / DI OFF / DIBERHENTIKAN
							$cari_spdq=mysql_query("select id_karyawan,tanggal_absen,keterangan_hadir from absen where (tanggal_absen between '$tglawal' and '$tglakhir') and id_karyawan='$Kar[id_karyawan]' and (keterangan_hadir='spd' or keterangan_hadir='off' )");
							@$cari_spd=mysql_fetch_array($cari_spdq);
							if(mysql_num_rows($cari_spdq) || $cari_spd['keterangan_hadir']=='spd' || $cari_spd['keterangan_hadir']=='off')
							{
								
								$tglakhir=$cari_spd['tanggal_absen'];
								$ulang=date_diff(date_create($tgl_baru),date_create($tglakhir));
								$ulang=$ulang->format("%d") + 1;
								$jumlah_hari =  banding_tgl($tglawal,$tglakhir);
							}
							else{
								$tglakhir = null;
								$tglakhir =  $t;
								$jumlah_hari =  banding_tgl($tglawal,$tglakhir);
								$ulang=$jumlah_hari;
							}
							$ulang = $jumlah_hari;
							$jumlah_hari = $jumlah_hari - $sss;
							$lama_kerja=$Kar['lama_kerja'] ;
							$idkaryawan=$Kar['id_karyawan'];
							$tgl_masuk=explode("-",$Kar['tgl_masuk']);
							$tgl_masuk=$tgl_masuk[2];
							// if($tgl_masuk[1]==$b && $tgl_masuk[0]==$t){
								// $tgl_masuk=$tgl_masuk[2];
								// $jumlah_hari=$lama_kerja;
							// }
							// else{
								$tgl_masuk=1;
								// $jumlah_hari=$jumlah_hari;
							// }
							
							
							if($Kar['kode_departemen']!='09'){
							
								$lembur_hari=mysql_query("SELECT count(id_karyawan) as total_lembur_hari FROM absen 
								WHERE tanggal_absen IN (SELECT tanggal_lembur FROM lembur_hari WHERE tanggal_lembur BETWEEN '$tgl_baru' and '$tglakhir')
								and id_karyawan=$idkaryawan and (keterangan_hadir is null or keterangan_hadir='' or keterangan_hadir='pulang' or keterangan_hadir='pulang_libur' )
								") or die(alert_error("Error : ".mysql_error()));
								$lembur_hari=mysql_fetch_array($lembur_hari);
								$lembur_hari=$lembur_hari['total_lembur_hari'];
								$lembur_hari111=$lembur_hari['total_lembur_hari'];
								
								
								$lembur_izin=0;
								$lembur_libur=0;
								$biasa_izin=0;
								$biasa_libur=0;
								$izin_lembur = 0;
								$alfa_lembur=0;
								$set=mysql_query("SELECT tanggal_absen,keterangan_hadir FROM absen 
								WHERE tanggal_absen BETWEEN '$tgl_baru' and '$tglakhir' and id_karyawan=$idkaryawan and (keterangan_hadir ='pulang_libur' or keterangan_hadir ='pulang' or keterangan_hadir ='izin' or keterangan_hadir ='alfa')") or die(alert_error("Error : ".mysql_error()));
								while($set_hari=mysql_fetch_array($set)){
									$cari_set=mysql_query("select * from lembur_hari where tanggal_lembur='$set_hari[tanggal_absen]'");
									if( mysql_num_rows($cari_set)>0){
										if($set_hari['keterangan_hadir']=='pulang'){
											$lembur_izin=$lembur_izin+1;
											// echo 'izin pada lembur';
										}
										else if($set_hari['keterangan_hadir']=='pulang_libur'){
											$lembur_libur=$lembur_libur+1;
											// echo 'libur/ 1/2 pada lembur';
										}
										else if($set_hari['keterangan_hadir']=='izin'){
											$izin_lembur=$izin_lembur+1;
											// echo 'libur/ 1/2 pada lembur';
										}
										else if($set_hari['keterangan_hadir']=='alfa'){
											$alfa_lembur=$alfa_lembur+1;
											// echo 'libur/ 1/2 pada lembur';
										}
									}
									else
									{
										if($set_hari['keterangan_hadir']=='pulang'){
											$biasa_izin=$biasa_izin+1;
											// echo "izin hari biasa";
											
										}
										else if($set_hari['keterangan_hadir']=='pulang_libur')
										{
											$biasa_libur=$biasa_libur+1;
											// echo "libur hari biasa";
											
										}
									}
								}
	
								
							}
							else{
								$lembur_hari=0;
								
							
								$lembur_hari=mysql_query("SELECT count(id_karyawan) as total_lembur_hari FROM absen 
								WHERE tanggal_absen IN (SELECT tanggal_lembur FROM lembur_hari WHERE tanggal_lembur BETWEEN '$tgl_baru' and '$tglakhir')
								and id_karyawan=$idkaryawan and (keterangan_hadir is null or keterangan_hadir='' or keterangan_hadir='pulang' or keterangan_hadir='pulang_libur' )
								") or die(alert_error("Error : ".mysql_error()));
								$lembur_hari=mysql_fetch_array($lembur_hari);
								$lembur_hari=$lembur_hari['total_lembur_hari'];
								$lembur_hari111=$lembur_hari['total_lembur_hari'];
								
								
								$lembur_izin=0;
								$lembur_libur=0;
								$biasa_izin=0;
								$biasa_libur=0;
								$izin_lembur = 0;
								$alfa_lembur=0;
								$set=mysql_query("SELECT tanggal_absen,keterangan_hadir FROM absen 
								WHERE tanggal_absen BETWEEN '$tgl_baru' and '$tglakhir' and id_karyawan=$idkaryawan and (keterangan_hadir ='pulang_libur' or keterangan_hadir ='pulang' or keterangan_hadir ='izin' or keterangan_hadir ='alfa')") or die(alert_error("Error : ".mysql_error()));
								while($set_hari=mysql_fetch_array($set)){
									$cari_set=mysql_query("select * from lembur_hari where tanggal_lembur='$set_hari[tanggal_absen]'");
									if( mysql_num_rows($cari_set)>0){
										if($set_hari['keterangan_hadir']=='pulang'){
											$lembur_izin=$lembur_izin+1;
											// echo 'izin pada lembur';
										}
										else if($set_hari['keterangan_hadir']=='pulang_libur'){
											$lembur_libur=$lembur_libur+1;
											// echo 'libur/ 1/2 pada lembur';
										}
										else if($set_hari['keterangan_hadir']=='izin'){
											$izin_lembur=$izin_lembur+1;
											// echo 'libur/ 1/2 pada lembur';
										}
										else if($set_hari['keterangan_hadir']=='alfa'){
											$alfa_lembur=$alfa_lembur+1;
											// echo 'libur/ 1/2 pada lembur';
										}
									}
									else
									{
										if($set_hari['keterangan_hadir']=='pulang'){
											$biasa_izin=$biasa_izin+1;
											// echo "izin hari biasa";
											
										}
										else if($set_hari['keterangan_hadir']=='pulang_libur')
										{
											$biasa_libur=$biasa_libur+1;
											// echo "libur hari biasa";
											
										}
									}
								}
							}
							
							$libur_nasional=mysql_query("SELECT count(tanggal_libur_nasional) as total_nasional FROM libur_nasional WHERE tanggal_libur_nasional BETWEEN '$tgl_baru' and '$tglakhir' ");
							$libur_nasional=mysql_fetch_array($libur_nasional);
							// echoecho $lama_kerja;
							$hitung_libur_nasional = $libur_nasional['total_nasional'];
							//pulang/SETENGAH HARI
							
								//LIBUR OFF
								// $total_kerja1 = hitung_jml_karyawan($idkaryawan,$tgl_baru,$tglakhir) - $izin - ($alfa * 2)  - ($pulang / 2)  ;
								/*$hitung_jml=array();
								for($i=0;$i<$ulang;$i++)
								{
									$date=date("Y-m-d",strtotime("+$i day", strtotime($tgl_baru)));
									$tgl_tmb=mysql_query("select id_absen from absen where tanggal_absen='$date' and id_karyawan='$idkaryawan'");
									$hit=mysql_num_rows($tgl_tmb);
									if(!$hit){
										$hitung_jml[]=1;
									}
									// else $hitung_jml[]=0;
									
								}
								*/
								$hitung_lbr = array() ; 
								for($i=0;$i<$jumlah_hari;$i++)
								{
									$date=date("Y-m-d",strtotime("+$i day", strtotime($tgl_baru)));
									$tgl_tmb=mysql_query("select id_absen from absen where tanggal_absen='$date' and id_karyawan='$idkaryawan'");
									$hit=mysql_num_rows($tgl_tmb);
									if(!$hit){
										$hlb=mysql_query("select * from libur_nasional where tanggal_libur_nasional='$date'");
										if(!mysql_num_rows($hlb)){
											$hitung_lbr[]=1;
										}
									}
									
									
								}
								$sakit=hitung_ket_karyawan_range($idkaryawan,'skd',$tgl_baru,$tglakhir) ;
								$izin=hitung_ket_karyawan_range($idkaryawan,'izin',$tgl_baru,$tglakhir) + ($biasa_izin/2) + ($lembur_izin / 2) ;
								$alfa=hitung_ket_karyawan_range($idkaryawan,'alfa',$tgl_baru,$tglakhir);
								$off=hitung_ket_karyawan_range($idkaryawan,'libur',$tgl_baru,$tglakhir) ;
								$ppp=hitung_ket_karyawan_range($idkaryawan,'pulang_libur',$tgl_baru,$tglakhir) ;
								$spd=hitung_ket_karyawan_range($idkaryawan,'spd',$tgl_baru,$tglakhir);
								$masuk_setengah_hari=hitung_ket_karyawan_range($idkaryawan,'masuk_setengah_hari',$tgl_baru,$tglakhir) / 2;
								$telat = hitung_telat_karyawan($idkaryawan,$tgl_baru,$tglakhir) ;
								total_lembur_range($idkaryawan,$tgl_baru,$tglakhir) ;
								//$libur=count($hitung_jml) - $hitung_libur_nasional + $lembur_hari + $off + ($biasa_libur / 2) + ($lembur_libur / 2) - $sss;
								$libur=count($hitung_lbr) +  $off ;
								//($lembur_libur / 2) +
								$total_kerja = hitung_jml_karyawan_range($idkaryawan,$tgl_baru,$tglakhir)  - $lembur_hari - $off ;#+ $spd  ;
								//$libur = $libur + $izin_lembur + $alfa_lembur
								$biaya = hitung_biaya_skd($Kar['id_karyawan'],$b,$t);
								?>
							<tr >
								<td ><?php echo $no; ?></td>
								<td style='text-align:left'><?php echo $Kar['nama_lengkap'] ?></td>
								<td style='font-size:9.8px'><?php echo $Kar['nik']?></td>
								<td ><?php echo $Kar['nama_jabatan']?> </td>
								<td ><?php echo $jumlah_hari ?></td>
								<td ><?php echo $hitung_libur_nasional ?></td>
								<td><?php echo total_lembur_range($idkaryawan,$tgl_baru,$tglakhir) ?></td>
								<td><?php echo $lembur_hari = $lembur_hari - ($lembur_izin / 2) - ($lembur_libur / 2) + $masuk_setengah_hari;   ?> </td>
								<td ><center><?php echo hitung_ket_karyawan_range($idkaryawan,'skd',$tgl_baru,$tglakhir) ?></center></td>
								<td ><center><?php echo $izin ?></center></td>
								<td ><center><?php echo hitung_ket_karyawan_range($idkaryawan,'alfa',$tgl_baru,$tglakhir)?></center></td>
								<td><?php echo $libur + ($ppp / 2) ?></td>
								<!--<td ><center><?php echo $telat = hitung_telat_karyawan($idkaryawan,$tgl_baru,$tglakhir) ?></center></td>-->
								
								<td><?php echo $tm =  ($alfa * 2) + $izin  ?></td>
								<td><?php echo $total_kerja - $tm - ($ppp / 2)  ?></td>
								<!--<td><?php echo ($biaya==null)?"" : rupiah($biaya) ?></td>-->
								<td><?php echo ($nilai==0)?"" : $nilai ?></td>
								<td><?php echo ($revisi==0)?"" : $revisi ?></td>
								
								<td style='text-align:left;font-size:10px'>
									<?php 
									if($cari_spd['keterangan_hadir']=='spd')
									{
										$ket =  "Berhenti Tanggal ". $cari_spd['tanggal_absen'];
									}
									else if($cari_spd['keterangan_hadir']=='off'){
										$ket = 'diberhentikan '. $cari_spd['tanggal_absen'];
									}
									echo $ket;
									?>
								</td>
							</tr>
						<?php 
						$no++;
						
						}
						}
						?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
    </div>

</section>

<script>
	
	
    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=3300,width=2100');
        mywindow.document.write('<html><head><title>Rekap Absen</title>');
        mywindow.document.write('<style>');
        mywindow.document.write("*{font-size:11px; border-collapse: collapse; margin: 4px 0px 0px 0px;padding: 0;}");
        mywindow.document.write("table, th, td {border: 1px solid black;}");
        mywindow.document.write("table tr th{text-align:center;}table tr td {text-align:center;}.nama{text-align:right;}");
        mywindow.document.write("@page { size:2100cm 3300cm; margin: 4px 0px 0px 0px }");
        mywindow.document.write('</style>');
        // mywindow.document.write('<link rel="stylesheet" href="<?php echo url('assets/print.css') ?>" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
	$("#klikprint").click(function(){
		Popup($(".printarea").html());
	});
</script>