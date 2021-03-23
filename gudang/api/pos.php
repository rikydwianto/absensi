<?php include_once"../config/setting.php"; ?>
<?php include_once"../config/koneksi.php"; ?>
<?php include_once"../fungsi/config.php"; ?>

<?php @$barang =  aman($_POST['barang']);
$idkaryawan =  $_SESSION['id_input_user'];
$id_input =  $_SESSION['id_input'];
$id_bahan =  $_SESSION['id_input_bahan'];
$karyawan=mysql_query("select * from karyawan join jabatan on jabatan.id_jabatan=karyawan.id_jabatan join departemen on departemen.id_departemen=jabatan.id_departemen where id_karyawan='$idkaryawan'") or die(alert_error("Error : ".mysql_error()));
$karyawan=mysql_fetch_array($karyawan);
?>

<table class='table'  border=1>
	<tr >
		<td style="width:55%;">

		<h3>Daftar Barang</h3>
			<?php
			$no=1;
			$qsparepart=mysql_query("select * from sparepart where nama_sparepart like '%$barang%' or kode_sparepart like '%$barang%' order by berbayar,nama_sparepart asc limit 0, 20") or die(mysql_error());
			if(mysql_num_rows($qsparepart)){
				echo "<table class='table-hover' style='width:100%;font-size:12px'>
				<thead>
					<tr>
						<th>NO</th>
						<th>Kode</th>
						<th>Barang</th>
						<th>Stok</th>
						<th>Tambah</th>
					</tr>
				</thead>
				<tbody>";
				while($sparepart=mysql_fetch_array($qsparepart))
				{
					$qty=$sparepart['stock_sparepart'];
					if($qty<1)
					{
						$c="style='color:red'";
						$disabled='disabled';
						$tr='class="danger"';
						$stok="Stok abis";
						$value='';
					}
					else{
						$c='';
						$disabled='';
						$stok='';
						$value=1;
						$tr = "";
					}
					?>
					<tr <?php echo @$tr ?>>
						<td><?php echo $no ?></td>
						<td><?php echo ($sparepart['kode_sparepart']) ?></td>
						<td>
							<span <?php echo $c; ?>>
								 <?php echo ($sparepart['nama_sparepart']) ?>
							</span>
						</td>
						<td>
							<?php echo ($sparepart['stock_sparepart']) ?>
						</td>
						<td class=''>
							<input type=number class='.form-control' name='qty[]' value="<?php echo $value; ?>" style='width:50px'  id='qty_<?php echo $sparepart['id_sparepart']?>' <?php echo $disabled ?> max="<?php echo $qty ?>" />
							<?php 
							if($qty>0)
							{?>
								<a href="javascript:void(0)" onclick="tambah_produk('<?php echo $sparepart['id_sparepart'] ?>')" class='btn btn-xs'><i class='glyphicon glyphicon-plus'></i></a>
								<?php 
							}
							?>
						</td>
					</tr>
					<?php
					$no++;
				}
				echo'
					</tbody>
				</table>';
			}
			else{
				echo "Tidak ditemukan barang yg bernama/kode : $barang";
			}
			?>

			<h3>Daftar Bahan,dll</h3>
			<table class='table-hover' style='width:100%;font-size:12px'>
				<thead>
					<tr>
						<th>NO</th>
						<th>Kode</th>
						<th>style</th>
						<th>Deskripsi</th>
						<th>warna</th>
						<th>qty</th>
						<th>Tambah</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$no=1;
				$qbahan =mysql_query("select * from stock_aksesoris where kode_po like '%$barang%' or
					nama_style like '%$barang%' or 
					deskripsi like '%$barang%' or 
					warna like '%$barang%' or 
					qty	like '%$barang%' or
					keterangan like '%$barang%' limit 0, 10
				 ");
				echo mysql_error();
				while($rbahan = mysql_fetch_array($qbahan)){
					$disabled='';
					$qty_bahan = $rbahan['qty'];
					if($qty_bahan<1){
						$disabled='disabled';
						$tr = 'class="danger"';
						$value='';
					}
					else{
						$disabled='';
						$tr = '';
						$value=1;
					}
					?>
					<tr <?php echo $tr ?> >
						<td><?php echo $no ?></td>
						<td><?php echo $rbahan['kode_po'] ?></td>
						<td><?php echo $rbahan['nama_style'] ?></td>
						<td><?php echo $rbahan['deskripsi'] ?></td>
						<td><?php echo $rbahan['warna'] ?></td>
						<td><?php echo $rbahan['qty'] ?><?php echo $rbahan['satuan'] ?></td>
						<td>
							<input type=text class='.form-control' name='qty_bahan[]' value="<?php echo $value; ?>" style='width:50px'  id='qty_bahan_<?php echo $rbahan['id_stock']?>' <?php echo $disabled ?> max="<?php echo $qty_bahan ?>" />
							<?php echo $rbahan['satuan'] ?>
							<?php 
							if($qty_bahan>0)
							{?>
								<a href="javascript:void(0)" onclick="tambah_produk_bahan('<?php echo $rbahan['id_stock'] ?>')" class='btn btn-xs'><i class='glyphicon glyphicon-plus'></i></a>
								<?php 
							}
							?>
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
				</tbody>
			</table>
		</td>
		<td>
			<h3>Detail <a class='btn' href='javascript:void(0)' onclick="tampil()"><i class='glyphicon glyphicon-refresh'></i></a> </h3>
			<table class='table '>
				<tr>
					<td>Nama </td>
					<td><?php echo $karyawan['nama_lengkap'] ?></td>
				</tr>
				<tr>
					<td>Jabatan</td>
					<td><?php echo $karyawan['nama_departemen'] ?> - <?php echo $karyawan['nama_jabatan'] ?></td>
				</tr>
			</table>

			<table class='table-hover' style="width:100%;font-size:12px">
				<thead>
					<tr>
						<th>NO</th>
						<th>kode</th>
						<th>Barang</th>
						<th>QTY</th>
						<th>HARGA</th>
						<th>TOTAL</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$ambilan=mysql_query("select sparepart.kode_sparepart, sparepart.nama_sparepart,detail_ambilan_sp.*, sum(detail_ambilan_sp.qty_ambilan) as qty_ambilan1  from detail_ambilan_sp join sparepart on detail_ambilan_sp.id_sparepart=sparepart.id_sparepart where detail_ambilan_sp.id_ambilan_sp='$id_input'  group by detail_ambilan_sp.id_sparepart  order by id_detail_ambilan_sp desc");
				echo mysql_error();
				$koma=array();
				$no=1;
				while($Rdetail=mysql_fetch_array($ambilan)){
					$total[]=$Rdetail['harga_ambilan'] * $Rdetail['qty_ambilan1'];
					?>
					<tr>
						<td><?php echo $no ?></td>
						<td><?php echo $Rdetail['kode_sparepart'] ?></td>
						<td><?php echo $Rdetail['nama_sparepart'] ?></td>
						<td><?php echo $Rdetail['qty_ambilan1'] ?></td>
						<td><?php echo rupiah($Rdetail['harga_ambilan']) ?></td>
						<td><?php echo rupiah($Rdetail['harga_ambilan'] * $Rdetail['qty_ambilan1']) ?></td>
						<td>
							<a href='javascript:void(0)'  onclick="delete_sparepart('<?php echo $Rdetail['id_sparepart'] ?>')" class='btn btn-xs ' >
								<i class='glyphicon glyphicon-remove'></i>
							</a>
						 </td>
					</tr>
					<?php
					$no++;
				}
				@$gabung=implode("<br/>",$koma);
				@$sumtotal=array_sum($total);
				?>
				<?php 
				$qtampilbahan = mysql_query("select sum(detail_loading_aksesoris.qty_loading) as qty_loading1,loading_aksesoris.*,stock_aksesoris.* from loading_aksesoris join detail_loading_aksesoris on loading_aksesoris.id_loading_aksesoris=detail_loading_aksesoris.id_loading_aksesoris
	join stock_aksesoris on stock_aksesoris.id_stock=detail_loading_aksesoris.id_stock where loading_aksesoris.id_loading_aksesoris='$id_bahan' group by detail_loading_aksesoris.id_stock");
				while($rtampilbahan = mysql_fetch_array($qtampilbahan)){
					?>
					<tr>
						<td><?php echo $no ?></td>
						<td><abbr title="<?php echo @$rtampilbahan['nama_style'] ?> <?php echo @$rtampilbahan['warna'] ?>" ><?php echo @$rtampilbahan['kode_po'] ?><?php echo @$rtampilbahan['nama_style'] ?></abbr></td>
						<td><?php echo $rtampilbahan['deskripsi'] ?> (<small><?php echo @$rtampilbahan['warna'] ?>)</small></td>
						<td><?php echo $rtampilbahan['qty_loading1'] ?><?php echo $rtampilbahan['satuan'] ?></td>
						<td><?php echo null; ?></td>
						<td><?php echo null ?></td>
						<td>
							<a href='javascript:void(0)'  onclick="delete_bahan('<?php echo $rtampilbahan['id_stock'] ?>')" class='btn btn-xs ' >
								<i class='glyphicon glyphicon-remove'></i>
							</a>
						 </td>
					</tr>
					<?php
					$no++;
				}
				?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="5"></th>
						<th colspan="1"><?php echo rupiah($sumtotal) ?></th>
						<th colspan="1"></th>
					</tr>
					<tr>
					<td colspan=7>
						<center>
							<a href='javascript:void(0)' id='ambil' onclick='sukses_ambilan()' class='btn btn-success' >SELESAI</a> 
							<a href='javascript:void(0)' onclick="reset_ambilan(<?php echo $id_input ?>)" class='btn btn-danger'>RESET ITEM</a> 
							
							<a class='btn btn-info' href='javascript:void(0)' onclick="retur()"><i class='glyphicon glyphicon-reply'></i> RETUR</a>
							<a class='btn btn-danger' href='javascript:void(0)' onclick="batal_transaksi()"><i class='glyphicon glyphicon-remove'></i> BATAL</a>
						</center>
					</td>
				</tr>
				</tfoot>
			</table>
		</td>
	</tr>
</table>