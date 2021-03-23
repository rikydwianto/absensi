<?php 
$mn=get('mn');
if(empty($mn))
{
	$home='class="active-menu"';
}
else
{
	if($mn=='po')
		$po='class="active-menu"';
	else if($mn=='list-order')
		$list_order='class="active-menu"';
	else if($mn=='stock')
		$stock='class="active-menu"';
	else if($mn=='stock-lebih')
		$stock_lebih='class="active-menu"';
	else if($mn=='loading')
		$loading='class="active-menu"';
	else if($mn=='data-loading' || $mn=='data-loading-tanggal' || $mn=='detail_loading')
		$data_loading='class="active-menu"';
	else if($mn=='suplier')
		$suplier='class="active-menu"';
	else if($mn=='stock_sampah')
		$sampah='class="active-menu"';
	else if($mn=='laporan-sparepart')
		$laporan_sparepart='class="active-menu"';
	else if($mn=='laporan-penggunaan-sparepart')
		$laporan_penggunaan='class="active-menu"';
	else if($mn=='sparepart' || $mn=='pengambilan_sparepart' || $mn=='sparepart-no')
		$sparepart='class="active-menu"';
	else if($mn=='buyer' )
		$buyer='class="active-menu"';
	else if($mn=='style' )
		$buyer='class="active-menu"';
	else if($mn=='satuan' )
		$satuan='class="active-menu"';
	else if($mn=='data-sparepart' )
		$data_sparepart='class="active-menu"';
	
	if($mn=='suplier' || $mn=='satuan' || $mn=='buyer' || $mn=='style' || $mn=='suplier'){
		$top_menu='class="active-menu-top"';
		$collapse='collapse in';
	}
	else if($mn=='laporan-sparepart' || $mn=='laporan-penggunaan-sparepart' || $mn=='data-sparepart'){
		$top_menu1='class="active-menu-top"';
		$collapse1='collapse in';
	}
}

?>
<!-- /. NAV TOP  -->
<?php 
include_once("fungsi/karyawan.php");
$ID=$_SESSION['ID'];
$karyawan=cek_karyawan($ID);

?>
<nav class="navbar-default navbar-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="main-menu">
			<li>
				<div class="user-img-div">
					<img src="<?php echo url(cek_photo($ID)) ?>" class="img-thumbnail" />

					<div class="inner-text">
						<?php echo $karyawan['nama_lengkap'] ?>
					<br />
						<!-- <small>Last Login : 2 Weeks Ago </small> -->
					</div>
				</div>
			</li>
			<li>
			<!-- class='active-menu' -->
				<a <?php echo @$home ?> href="<?php echo url() ?>"><i class="fa fa-dashboard "></i>Home</a>
			</li>

			<li>
			<!-- class='active-menu' -->
				<a  href="<?php echo url() ?>pos.php" target='_blank'><i class="fa fa-times"></i>POS</a>
			</li>
			<li>
			<!-- class='active-menu' -->
				<a  href="<?php echo url() ?>cari_nik.php" target='_blank'><i class="fa fa-times"></i>Cari NIK</a>
			</li>
			<li>
				<a <?php echo @$loading ?> href="<?php echo menu("loading") ?>"><i class="fa fa-shopping-cart "></i> Loading</a>
			</li>
			<li>
				<a <?php echo @$data_loading ?> href="<?php echo menu("data-loading") ?>"><i class="fa fa-list-alt "></i> Data Loading</a>
			</li>
			<li>
				<a <?php echo @$po ?> href="<?php echo menu("po") ?>"><i class="fa fa-money "></i> Purchase Order</a>
			</li>
			<li>
				<a <?php echo @$list_order ?> href="<?php echo menu("list-order") ?>"><i class="fa fa-tasks "></i> List Order</a>
			</li>
			<li>
				<a <?php echo @$stock ?> href="<?php echo menu("stock") ?>"><i class="fa fa-database "></i> Stock on Hand</a>
			</li>
			<li>
				<a <?php echo @$sparepart ?> href="<?php echo menu("sparepart") ?>"><i class="fa fa-gears "></i> Data sparepart</a>
			</li>
			<li>
				<a  href="#" <?php echo @$top_menu1 ?>><i class="fa fa-file-word-o "></i> Laporan</a>
				<ul class="nav nav-second-level <?php echo @$collapse1 ?>">
					<li>
						<a <?php echo @$laporan_penggunaan ?> href="#<?php //echo menu("laporan-penggunaan-sparepart") ?>" ><i class="fa fa-file-word-o "></i> Laporan Sparepart</a>
						<ul class="nav nav-third-level <?php echo @$collapse1 ?>">
							<li>
								<a <?php echo @$data_sparepart ?> href="<?php echo menu("data-sparepart") ?>" ><i class="fa fa-file-word-o "></i> Data Ambilan</a>
							</li>
							<li>
								<a <?php echo @$laporan_sparepart ?> href="<?php echo menu("laporan-sparepart") ?>" ><i class="fa fa-file-word-o "></i> Sparepart Ambilan</a>
							</li>
							<li>
								<a <?php echo @$laporan_penggunaan_hari ?> href="<?php echo menu("laporan-penggunaan-sparepart-hari") ?>" ><i class="fa fa-file-word-o "></i> Penggunaan /Hari</a>
							</li>
							<li>
								<a <?php echo @$laporan_penggunaan ?> href="<?php echo menu("laporan-penggunaan-sparepart") ?>" ><i class="fa fa-file-word-o "></i> Penggunaan /Bulan</a>
							</li>
							<li>
								<a <?php echo @$laporan_penggunaan_tahun ?> href="<?php echo menu("laporan-penggunaan-sparepart-tahun") ?>" ><i class="fa fa-file-word-o "></i> Penggunaan /Tahun</a>
							</li>
							<li>
								<a <?php echo @$laporan_penggunaan_semua ?> href="<?php echo menu("laporan-penggunaan-sparepart-semua") ?>" ><i class="fa fa-file-word-o "></i> Penggunaan Sepanjang Waktu</a>
							</li>
						</ul>
					</li>
				</ul>
				
				<!--<ul class="nav nav-second-level <?php echo @$collapse2 ?>">
					<li>
						<a <?php echo @$laporan_penggunaan ?> href="#<?php //echo menu("laporan-penggunaan-sparepart") ?>" ><i class="fa fa-file-word-o "></i> Laporan Bahan</a>
						<ul class="nav nav-third-level <?php echo @$collapse1 ?>">
							<li>
								<a <?php echo @$data_sparepart ?> href="<?php echo menu("data-sparepart") ?>" ><i class="fa fa-file-word-o "></i> Data Ambilan</a>
							</li>
							<li>
								<a <?php echo @$laporan_sparepart ?> href="<?php echo menu("laporan-sparepart") ?>" ><i class="fa fa-file-word-o "></i> Sparepart Ambilan</a>
							</li>
							<li>
								<a <?php echo @$laporan_penggunaan_hari ?> href="<?php echo menu("laporan-penggunaan-sparepart-hari") ?>" ><i class="fa fa-file-word-o "></i> Penggunaan /Hari</a>
							</li>
							<li>
								<a <?php echo @$laporan_penggunaan ?> href="<?php echo menu("laporan-penggunaan-sparepart") ?>" ><i class="fa fa-file-word-o "></i> Penggunaan /Bulan</a>
							</li>
							<li>
								<a <?php echo @$laporan_penggunaan_tahun ?> href="<?php echo menu("laporan-penggunaan-sparepart-tahun") ?>" ><i class="fa fa-file-word-o "></i> Penggunaan /Tahun</a>
							</li>
							<li>
								<a <?php echo @$laporan_penggunaan_semua ?> href="<?php echo menu("laporan-penggunaan-sparepart-semua") ?>" ><i class="fa fa-file-word-o "></i> Penggunaan Sepanjang Waktu</a>
							</li>
						</ul>
					</li>
				</ul> -->
			</li>
			<li>
				<a <?php echo @$stock_lebih ?> href="<?php echo menu("stock-lebih") ?>"><i class="fa fa-database "></i> Data Barang Lebih</a>
			</li>
			<li>
				<a href="#" <?php echo @$top_menu ?> ><i class="fa fa-database "></i> Data Utama <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level <?php echo @$collapse ?>">
					<li>
						<a <?php echo @$suplier ?> href="<?php echo menu('suplier') ?>" ><i class="fa fa-database "></i> Suplier </a>
					</li>
					<li>
						<a <?php echo @$buyer ?> href="<?php echo menu('buyer') ?>" ><i class="fa fa-database "></i> Buyer </a>
					</li>
					<li>
						<a <?php echo @$satuan ?> href="<?php echo menu('satuan') ?>" ><i class="fa fa-database "></i> Satuan </a>
					</li>
				</ul>
			</li>
			<li>
				<a <?php echo @$sampah ?> href="<?php echo menu("kotak-sampah") ?>"><i class="fa fa-trash "></i> Kotak Sampah</a>
			</li>
		</ul>
	</div>

</nav>