<?php 
include_once"fungsi/absen-absen.php";
include_once"fungsi/karyawan.php";
include_once"fungsi/departemen.php";
include_once"fungsi/jabatan.php";
$breadcrumd=$_GET['mn'];
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
		  <h3 class="box-title">Rekap Total </h3>
		</div>
		<div class="box-body">
			<div >
			<?php 
			if(isset($_GET['bulan']) || isset($_GET['tahun']))
			{
				$link="?bulan=$_GET[bulan]&tahun=$_GET[tahun]";
			}
			else
			{
				$link="?bulan=".date("m")."&tahun=".date("Y");
			}
			?>
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
				<a href='<?php echo url('laporan/absen_rekap_total.php'.$link) ?>' class='btn btn-danger btn-flat'><i class='fa fa-excel-o'></i> Export </a>
			</div>
			<br/>
			<div>
				<?php 
				if(isset($_GET['cr']))
				{
					$t=aman($_GET['tahun']);
					$b=aman($_GET['bulan']);
					$id_jabatan=aman($_GET['jab']);
				}
				else{
					$b=date("m");
					$t=date("Y");
					$id_jabatan=null;
				}
				$b=sprintf('%02s', $b);
				?>
				<div class='pull-right'>
				<form method=get>
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
					<input type=hidden value='rekap' name='mn'/>
					<select name='bulan'>
						<?php
						$bln=bulan();
						$hitung= count($bln);
						for($i=1;$i<=$hitung;$i++)
						{
							if($i==date('m') || @$_GET['bulan']==$i)
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
							if(@$_GET['tahun']==$a)
								$ts="selected";
							else
								$ts="";
							echo "<option $ts value='$a'>$a</option>";
						}
						?>
					</select>
					<input type=submit value='Cari' name='cr'/>
					</form>

				</div>
				<br/>
				<br/>
				<?php 
//				error_reporting(0);
				$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $b, $t);
				$jumlah_hari1 = cal_days_in_month(CAL_GREGORIAN, $b, $t);
				$jab=cari_jabatan($id_jab_dep);
				$dep=cari_dep($id_jabatan);
				$hitung_libur_nasional=hitung_libur_nasional($b,$t);
				?>
				Nama Departemen : <?php echo @$dep->nama_departemen ?><br/>
				Jabatan			: <?php echo @$jab->nama_jabatan ?>
				
				<div class='table-responsive '>
					<table border=1 class=' table- table-hover' style='width:100%'>
						<thead>
							<tr>
								<th colspan='14'>
									<center>
										Rekap Total <?php echo cek_bulan($b).' '.$t?> 
									</center>
								</th>
							</tr>
							<tr >
								<th rowspan=2><center>No.</center></th>
								<th rowspan=2><center>Nama </center></th>
								<th rowspan=2><center>Jabatan</center></th>
								<th >Total Hari</th>
								<th >Libur</th>
								<th colspan=3><center>Absensi</center></th>
								<th rowspan=2><center>Telat</center></th>
								<th rowspan=2><center>Lembur(Jam)</center></th>
								<th rowspan=2><center>Lembur(Hari)</center></th>
								<th colspan=3><center>Total</center></th>
							</tr>
							<tr >
								<th >Hari/bln</th>
								<th >Nasional</th>
								<th><center>S</center></th>
								<th><center>I</center></th>
								<th><center>A</center></th>
								<th>Masuk</th>
								<th>Tidak Masuk</th>
								<th>Libur</th>
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
						$query="select id_karyawan,nik,nama_lengkap,nama_jabatan,datediff(curdate(),tgl_masuk) as lama_kerja,tgl_masuk,kode_departemen from karyawan,jabatan,departemen where departemen.id_departemen=jabatan.id_departemen 
						and karyawan.id_jabatan=jabatan.id_jabatan and karyawan.status_karyawan!=5 and departemen.id_departemen='$id_jabatan' and datediff(curdate(),tgl_masuk) <=28 $qtam  order by karyawan.tgl_masuk ";
						$query=mysql_query($query);
						$jm=0;
						$no=1;
						while($Kar=mysql_fetch_array($query))
						{
							$lama_kerja=$Kar['lama_kerja'] ;
							$idkaryawan=$Kar['id_karyawan'];
							$tgl_masuk=explode("-",$Kar['tgl_masuk']);
							$tgl_masuk=$tgl_masuk[2];
							if($tgl_masuk[1]==$b && $tgl_masuk[0]==$t){
								// $tgl_masuk=$tgl_masuk[2];
								$jumlah_hari=$lama_kerja;
							}
							else{
								// $tgl_masuk=1;
								$jumlah_hari=$jumlah_hari;
							}
							if($Kar['kode_departemen']!='09'){
							
								$lembur_hari=mysql_query("SELECT count(id_karyawan) as total_lembur_hari FROM absen 
								WHERE tanggal_absen IN (SELECT tanggal_lembur FROM lembur_hari WHERE tanggal_lembur like '$t-$b-%')
								and id_karyawan=$idkaryawan 
								#and keterangan_hadir in ('')
								") or die(alert_error("Error : ".mysql_error()));
								$lembur_hari=mysql_fetch_array($lembur_hari);
								$lembur_hari=$lembur_hari['total_lembur_hari'];
							}
							else{
								$lembur_hari=0;
							}
							
							
							echo $lama_kerja;
							if($lama_kerja>=$jumlah_hari1)
							{
								// $lama_per_bulan=$jumlah_hari;
								$lama_libur=$hitung_libur_nasional;	
							}
							else{
								// $lama_per_bulan=$lama_kerja;
								$jumlah_libur=0;
								for($i=$tgl_masuk;$i<=$jumlah_hari1;$i++){
									$detail_libur=mysql_query("select count(id_libur_nasional) as total from libur_nasional where tanggal_libur_nasional='$t-$b-$i'") or die(mysql_error());
									$detail_libur=mysql_fetch_array($detail_libur);
									$detail_libur = $detail_libur['total'];
									if($detail_libur==1){
										$jumlah_libur=$jumlah_libur+1;
									}
								}
								$lama_libur=($jumlah_libur);
							}
							$hitung_libur_nasional = $lama_libur;
							//pulang
							// $jumlah_hari=$lama_per_bulan;
							$pulang=hitung_ket_karyawan($idkaryawan,'pulang',$b,$t);
							$libur=hitung_ket_karyawan($idkaryawan,'libur',$b,$t);
							
							?>
							<tr >
								<td ><?php echo $no; ?></td>
								<td ><?php echo $Kar['nama_lengkap'] ?>[<?php echo $Kar['nik']?>]</td>
								<td ><?php echo $Kar['nama_jabatan']?> </td>
								<td ><?php echo $jumlah_hari ?></td>
								<td ><?php echo $hitung_libur_nasional ?></td>
								<td ><center><?php echo $sakit=hitung_ket_karyawan($idkaryawan,'skd',$b,$t) ?></center></td>
								<td ><center><?php echo $izin=hitung_ket_karyawan($idkaryawan,'izin',$b,$t) ?></center></td>
								<td ><center><?php echo $alfa=hitung_ket_karyawan($idkaryawan,'alfa',$b,$t)?></center></td>
								<td ><center><?php echo $telat = hitung_telat_karyawan($idkaryawan,$b,$t) ?></center></td>
								<td><?php echo total_lembur($idkaryawan,$b,$t) ?></td>
								<td><?php echo $lembur_hari = $lembur_hari ?> Hari</td>
								<td><?php echo $total_kerja = hitung_jml_karyawan($idkaryawan,$b,$t) - $izin - ($alfa * 2) - $lembur_hari + ($pulang / 2) - $libur ?></td>
								<td><?php echo $tm =  ($alfa * 2) + $izin ?></td>
								<?php 
								//LIBUR OFF
								$total_kerja1 = hitung_jml_karyawan($idkaryawan,$b,$t) - $izin - ($alfa * 2)  - ($pulang / 2)  ;
								if($lama_kerja>=$jumlah_hari1){
									$libur = $jumlah_hari - ($total_kerja1 + $tm + $hitung_libur_nasional) + $lembur_hari + $libur ;
									// $jumlah=0;
									// for($a=1;$a<=$jumlah_hari1;$a++){
										// $cek_=mysql_query("select count(id_karyawan) as total from absen where tanggal_absen='$t-$b-$a' and id_karyawan='$idkaryawan'");
										// $cek_=mysql_fetch_array($cek_);
										// $cek = $cek_['total'];
										// if($cek==0)
										// {
											// $jumlah += 1;
										// }
									// }
									 // $libur= $jumlah_hari - $total_kerja1 - $jumlah ;
								}
								else
								{
									$jumlah=0;
									for($a=$tgl_masuk;$a<=$jumlah_hari1;$a++){
										$cek_=mysql_query("select count(id_karyawan) as total from absen where tanggal_absen='$t-$b-$a' and id_karyawan='$idkaryawan'");
										$cek_=mysql_fetch_array($cek_);
										$cek = $cek_['total'];
										if($cek==0)
										{
											$jumlah += 1;
										}
									}
									 $libur= $jumlah - $hitung_libur_nasional + ($pulang / 2) + $lembur_hari + $libur ;
								}
								?>
								<td><?php echo $libur; ?> Hari</td>
							</tr>
						<?php 
						$no++;
						}
						?>
						</tbody>
						<tfoot>
							<tr >
								<th >No.</th>
								<th >Nama </th>
								<th >Jabatan</th>
								<th >Total Hari/bln</th>
								<th >Libur Nasional</th>
								<th><center>S</center></th>
								<th><center>I</center></th>
								<th><center>A</center></th>
								<th>Telat</th>
								<th>Lembur(Jam)</th>
								<th>Lembur(Hari)</th>
								<th>Masuk</th>
								<th>Tidak Masuk</th>
								<th>Libur</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
    </div>

</section>