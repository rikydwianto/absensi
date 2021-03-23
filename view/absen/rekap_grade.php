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
@$bulan=($_GET['bulan'] == "" ) ? date("m") : $_GET['bulan'];
$b = $bulan;
@$tahun=($_GET['tahun'] == "" ) ? date("Y") : $_GET['tahun'];
@$id_jabatan=aman($_GET['jab']);
$bulan=sprintf('%02s', $bulan);
?>
<section class="content-header">
  <h1>
    Grade
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Rekap Grade Karyawan</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Rekap Grade/Nilai/Skill Karyawan</h3>
		</div>
		<div class="box-body">
			<div >
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
				<a href='#' id='klikprint' class='btn btn-danger btn-flat'><i class='fa fa-print'></i> print</a>
			</div>
			<br/>
			<div>
				<div class='pull-right'>
					<form method=get>
						<input type=hidden value='rekap-grade' name='mn'/>
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
						 <select name='bulan'>
						<?php
						$bln=bulan();
						$hitung= count($bln);
						for($i=1;$i<=$hitung;$i++)
						{
							if($i==date('m') || $_POST['bulan']==$i)
								$sel="selected";
							else
								$sel="";
							echo"<option $sel value='$i'>$bln[$i]</option>";
						}
						?>
						</select>
						<select name='tahun'>
							<?php 
							$th=date("Y");
							for($a=$th;$a>2010;$a--)
							{
								echo "<option value='$a'>$a</option>";
							}
							?>
						</select>
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
				$cek_bulan =  bulan();
				?>
				Nama Departemen : <?php echo @$dep->nama_departemen ?><br/>
				Jabatan			: <?php echo @$jab->nama_jabatan ?> <br/>
				Priode	 		: <?php echo $cek_bulan[$b].' '.$tahun; ?><br/>
				<div class='table-responsive '>
				<form action="tambah_grade.php" method="post">
				<input type=hidden name='url' value='<?php echo url_ref() ?>'>
				<input type=hidden name='bulan' value='<?php echo $bulan ?>'>
				<input type=hidden name='tahun' value='<?php echo $tahun ?>'>
					<table border=1 class=' table- table-hover' style='width:100%'>
						<thead>
							<tr>
								<th colspan='7' bgcolor="#ffe6e6">
									<center>
										Rekap Grade <?php echo $bulan.' - '.$cek_bulan[$b].' '.$tahun; ?><br/>
										
									</center>
								</th>
							</tr>
							<tr >
								<th rowspan=1><center>No.</center></th>
								<th rowspan=1 ><center>Nama </center></th>
								<th rowspan=1><center>NIK </center></th>
								<th rowspan=1><center>Jabatan</center></th>
								<th rowspan=1><center>Nilai</center></th>
								<th rowspan=1><center>Revisi <br/> Grade</center></th>
								<th rowspan=1><center>Keterangan</center></th>
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
						and karyawan.id_jabatan=jabatan.id_jabatan  and departemen.id_departemen='$id_jabatan' $qtam order by karyawan.id_jabatan,karyawan.tgl_masuk ";
						#
						$query=mysql_query($query);
						$jm=0;
						$no=1;
						while($Kar=mysql_fetch_array($query))
						{
							$cek_absen = mysql_query("select count(id_karyawan) as absen from absen where id_karyawan='$Kar[id_karyawan]'
							and tanggal_absen like '$tahun-$bulan-%'
							and (keterangan_hadir='out' or keterangan_hadir='off' or keterangan_hadir='spd' )
							");
							$cek_absen = mysql_fetch_array($cek_absen);
							$cek_absen = $cek_absen['absen'];
							
							$hitung = mysql_query("select count(id_karyawan) as absen from absen where id_karyawan='$Kar[id_karyawan]'
							and tanggal_absen like '$tahun-$bulan-%'
							");
							
							$cek_grade = mysql_query("select * from grade where id_karyawan='$Kar[id_karyawan]' and bulan='$bulan' and tahun='$tahun'");
							if(!mysql_num_rows($cek_grade)){
								$grade = null;
								$revisi = null;
							}
							else{
								$cek_grade = mysql_fetch_array($cek_grade);
								$grade = $cek_grade['grade'];
								$revisi = $cek_grade['revisi_grade'];
							}
							$hitung = mysql_fetch_array($hitung);
							$hitung = $hitung['absen'];
							if($cek_absen<1 && $hitung>0){	
							?>
							<tr>
								<td>
									<input type=hidden name='id_karyawan[]' value='<?php echo $Kar['id_karyawan'] ?>' />
								<?php echo $no ?></td>
								<td style='text-align:left'><?php echo $Kar['nama_lengkap'] ?></td>
								<td><?php echo $Kar['nik'] ?></td>
								<td><?php echo $Kar['nama_jabatan'] ?></td>
								<td><input type=text name='grade[]' value='<?php echo $grade ?>' CLASS='form-control' size=3 /></td>
								<td><!--<input type=text name='revisi[]' value='<?php echo $revisi ?>' />--></td>
								<td></td>
							</tr>
							<?php
							$no++;
							}
						}
						?>
						</tbody>
							<tr>
								<th colspan=6></th>
								<th colspan=1><input type='submit' name='aksi_grade' class='btn btn-danger' value='Simpan'></th>
							</tr>
					</table>
					</form>
					<p>
						// Jika Dikosongkan berarti tidak diberi Grade/Nilai/Skill
					</p>
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