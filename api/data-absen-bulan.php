<?php 
				//error_reporting(0);
				$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $b, $t);
				$dep=cari_dep($id_jabatan);
				?>
				Nama Departemen : <?php echo $dep->nama_departemen ?><br/>
				<div class='table-responsive '>
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
							if($m=='Sunday')
								$minggu="style='background:#ff9999'";
							else
								$minggu='';
							echo"<th $minggu width='25'><center>$i</center></th>";
						}
						?>
						
						<th width='25' ><center>A</center></th>
						<th width='25'><center>S</center></th>
						<th width='25'><center>I</center></th>
						<th width='25'><center>TM</center></th>
						<th width='25'><center>P</center></th>
						<th width='25'><center>Jml</center></th>
					</thead>
					<tbody>
					<?php 
					$no=1;
					$query="SELECT id_karyawan,nik,nama_lengkap FROM karyawan 
					INNER JOIN jabatan ON jabatan.`id_jabatan`=karyawan.`id_jabatan` INNER JOIN departemen ON departemen.`id_departemen` = jabatan.`id_departemen` 
					where departemen.id_departemen='$id_jabatan' and karyawan.status_karyawan !='5' order by karyawan.nama_lengkap asc limit 30,60";
					$query=mysql_query($query) or die(alert_error("Error : ". mysql_error()));
					$jm=0;
					while($Kar=mysql_fetch_object($query))
					{
						?>
					<tr>
						<td>
						<?php echo $no ?>
						</td>
						<td>
						<?php echo $Kar->nama_lengkap ?> [<?php echo $Kar->nik ?>]
						</td>
						<?php 
						for($i=1;$i<=$jumlah_hari;$i++){

							$ket = absen_tgl($Kar->id_karyawan,$i,$b,$t);
							$m= date("l",strtotime(date("$t-$b-$i")));
							if($m=='Sunday')
								$minggu="style='background:#ff9999'";
							else
								$minggu='';
							if(is_int($ket)){
								if($ket=='-1'){
									$ket="<b style='color:red'>$ket</b>";
								}
								else
									$ket=$ket;//'class="bg-red"';
							}
							else
								if($ket=='S'){
									$ket="<b style='color:green'>$ket</b>";
								}
								else if($ket=='I'){
									$ket="<b style='color:blue'>$ket</b>";
									
								}
							echo "<td $minggu style='width:7px'><center>".$ket.'</center></td>';
							$total_kerja = hitung_jml_karyawan($Kar->id_karyawan,$b,$t);
						}
						?>
						<td class='bg-red'><center><?php echo $alfa=hitung_ket_karyawan($Kar->id_karyawan,'alfa',$b,$t)?></center></td>
						<td class='bg-green'><center><?php echo $sakit=hitung_ket_karyawan($Kar->id_karyawan,'sakit',$b,$t) ?></center></td>
						<td class='bg-blue'><center><?php echo $izin=hitung_ket_karyawan($Kar->id_karyawan,'izin',$b,$t) ?></center></td>
						<td class='bg-yellow'><center><?php echo $jumlah_hari - $total_kerja + ($alfa * 2) + $sakit + $izin + $pulang?></center></td>
						<td class='bg-yellow'><center><?php echo hitung_ket_karyawan($Kar->id_karyawan,'pulang',$b,$t) ?></center></td>
						<td class='bg-black'><center><?php echo $total_kerja - ($alfa * 2)- $izin - $pulang?></center></td>
					</tr>
						<?php
					$no++;
					}
					?>
					</tbody>
					</table>