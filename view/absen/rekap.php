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
    <li><a href="<?php echo url('index.php?mn='.$breadcrumd) ?>">Rekap</a></li>
    <li class="active"><?php echo (@$_GET['act']) ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	
  <!-- Default box -->
  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Rekap </h3>
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
			if(isset($_GET['jab']))
				$Tjab="&jab=".($_GET['jab']);
			else
				$Tjab="";
			?>
				<a href='<?php echo url_sekarang() ?>' class='btn btn-primary'><i class='fa fa-refresh'></i> Reload </a>
				<!--
				-->
				<a href='javascript:void()' id='refresh_rekap' class='btn btn-danger btn-flat'><i class='fa fa-refresh'></i> Refresh  </a> 
				<a href='<?php echo url('laporan/absen_total.php'.$link.$Tjab) ?>' class='btn btn-danger btn-flat'><i class='fa fa-refresh'></i> Export Excel </a>
			</div>
			<br/>
			<div id='reload_rekap'>
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
					<select name='jab' id='dept' class='sel1ect2'>
						<option value=''>Departemen </option>
						<option value='semua'>Tampilkan Semua</option>
						<?php 
						$Qdep=tampil_departemen();
						while($rDep=mysql_fetch_object($Qdep))
						{
							if($id_jabatan==$rDep->id_departemen)
								echo "<option selected value='$rDep->id_departemen'>$rDep->nama_departemen</option>";
							else
								echo "<option value='$rDep->id_departemen'>$rDep->nama_departemen</option>";
								
							
						}
						?>
					</select>
					<select id='jabatan' name='id_jabatan'>
					<option value=''>Jabatan</option>
					<?php 
					@$id_jab=$_GET['id_jabatan'];
					$Qjab=jabatan_departemen($id_jabatan);
					while($rJab=mysql_fetch_object($Qjab)){
						if(@$id_jab==$rJab->id_jabatan)
							$select="selected";
						else
							$select="";
						echo "<option $select value='$rJab->id_jabatan'>$rJab->nama_jabatan</option>";
					}
					?>
					</select>
					<input type=hidden value='rekap_absen' name='mn'/>
					<select name='bulan'>
						<?php
						$bln=bulan();
						$hitung= count($bln);
						for($i=1;$i<=$hitung;$i++)
						{
							if($i==date('m'))
								$sel="selected";
							else if($_GET['bulan']==$i)
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
							if($_GET['tahun']==$a)
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
				//error_reporting(0);
				$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $b, $t);
				$dep=cari_dep($id_jabatan);
				?>
				Nama Departemen : <?php echo ($id_jabatan=='semua') ? "Semua Departemen" : $dep->nama_departemen ?><br/>
				<div class='table-responsive' >
					<table border=1 class=' table- table-hover' style='width:100%'>
					<thead>
					<tr>
						<th colspan='<?php echo $jumlah_hari + 2 + 6  ?>' >
							<center><?php echo cek_bulan($b) ?> <?php echo $t?></center>
						</th>
					</tr>
					<tr>
						<th >No</th>
						<th >Nama</th>
						<?php 
						for($i=1;$i<=$jumlah_hari;$i++){
							$m= date("l",strtotime(date("$t-$b-$i")));
							$libur=hitung_libur_nasional_detail($i,$b,$t);
							// if()
							if($libur || $m=='Sunday')
								$minggu="style='background:#ff9999'";
							else
								$minggu='';
							echo"<th $minggu width='25'><a href='".url("index.php?mn=absen&tgl=$i/$b/$t&cr=Cari")."' target=_blank><center>$i</center></a></th>";
						}
						?>
						
						<th width='25' ><center>A</center></th>
						<th width='25'><center>S</center></th>
						<th width='25'><center>I</center></th>
						<!--<th width='25'><center>TM</center></th>-->
						<th width='25'><center>P</center></th>
						<th width='25'><center>Jml</center></th>
					</thead>
					<tbody>
					<?php 
					$no=1;
					if(empty($id_jab)){
						$jabatan="";
						$and ='';
					}
					else{
						$jabatan="and jabatan.id_jabatan='$id_jab'";
						$and = "  ";
					}

					if($id_jabatan=='semua')
						$qqq = "where (karyawan.status_karyawan !='5' ) order by karyawan.id_jabatan, karyawan.tgl_masuk asc";
					else
						$qqq = "where departemen.id_departemen='$id_jabatan' $jabatan and (karyawan.status_karyawan !='5'  ) order by karyawan.id_jabatan, karyawan.tgl_masuk asc";

					$query="SELECT id_karyawan,nik,nama_lengkap FROM karyawan 
					INNER JOIN jabatan ON jabatan.`id_jabatan`=karyawan.`id_jabatan` INNER JOIN departemen ON departemen.`id_departemen` = jabatan.`id_departemen` $qqq";
					// $query="call cari_karyawan('$id_jabatan','$id_jab')";
					$query=mysql_query($query);
					$jm=0;
					while($Kar=mysql_fetch_assoc($query))
					{
						$idkaryawan=$Kar['id_karyawan'];
						?>
					<tr>
						<td>
						<?php echo $no ?>
						</td>
						<td>
						<?php echo $Kar['nama_lengkap']?> [<?php echo $Kar['nik'] ?>]
						</td>
						<?php 
						for($i=1;$i<=$jumlah_hari;$i++){
							$ket = absen_tgl($Kar['id_karyawan'],$i,$b,$t);
							$m= date("l",strtotime(date("$t-$b-$i")));
							$libur=hitung_libur_nasional_detail($i,$b,$t);
							if($libur || $m=='Sunday')
								$minggu="style='background:#ff9999'";
							else
								$minggu='';
							if(is_int($ket)){
								if($ket=='-1'){
									$minggu='style="background:#f30000"';
									$ket="<b style='color:white'>$ket</b>";
								}
								else
									$ket=$ket;//'class="bg-red"';
							}
							else{
								if($ket=='S'){
									$ket="<b style='color:green'>$ket</b>";
								}
								else if($ket=='I'){
									$minggu='style="background:#48a4ff"';
									$ket="<b style='color:white'>$ket</b>";
								}
								else if($ket=='skd'){
									$minggu='style="background: #00a65a !important "';
									$ket="<b style='color:white'>1</b>";
								}
								else if($ket=='spd'){
									$minggu='style="background: #000 !important "';
									$ket="<b style='color:white'>spd</b>";
								}
								else if($ket=='out'){
									$minggu='style="background: #000 !important "';
									$ket="<b style='color:white'>out</b>";
								}
								else if($ket=='off'){
									$minggu='style="background: #000 !important "';
									$ket="<b style='color:white'>off</b>";
								}
							}
							 $href=url("index.php?mn=absen_karyawan&tgl=$t-$b-$i&id=$idkaryawan");
							echo "<td $minggu style='width:7px'><center><a href='$href' target=_blank style='color:black'>".$ket.'</a></center></td>';
						}
						$pulang = hitung_ket_karyawan($Kar['id_karyawan'],'pulang',$b,$t);
						$total_kerja = hitung_jml_karyawan($Kar['id_karyawan'],$b,$t);
						?>
						<td class='bg-red'><center><?php echo $alfa=hitung_ket_karyawan($Kar['id_karyawan'],'alfa',$b,$t)?></center></td>
						<td class='bg-green'><center><?php echo $sakit=hitung_ket_karyawan($Kar['id_karyawan'],'skd',$b,$t) ?></center></td>
						<td class='bg-blue'><center><?php echo $izin=hitung_ket_karyawan($Kar['id_karyawan'],'izin',$b,$t) ?></center></td>
						<!--<td class='bg-yellow'><center><?php echo $jumlah_hari - $total_kerja - ($alfa * 2) - ($pulang / 2) - $izin?></center></td>-->
						<td class='bg-yellow'><center><?php echo $pulang ?></center></td>
						<td class='bg-black'><center><?php echo $total_kerja - $izin - ($pulang/2) - ($alfa * 2) - hitung_ket_karyawan($Kar['id_karyawan'],'libur',$b,$t) ?></center></td>
					</tr>
						<?php
					$no++;
					}
					?>
					</tbody>
					</table>
				
				</div>
			</div>
		</div>
    </div>

</section>