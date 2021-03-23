<div class="row">
	<div class="col-md-12">
		<h1 class="page-head-line"><?php echo $title ?></h1>
		<h1 class="page-subhead-line">Aplikasi inventaris gudang Aksesoris</h1>

	</div>
</div>
<!-- /. ROW  -->
<?php 
$hitung_pending=mysql_query("select count(status_order) total from order_aksesoris where status_order='pending'") or die(alert_error(mysql_error()));
$hitung_pending=mysql_fetch_array($hitung_pending);
$hitung_pending=$hitung_pending['total'];

$hitung_lebih=mysql_query("select count(id_stock) total from stock_aksesoris where lebihan='ya' and hapus='tidak'") or die(alert_error(mysql_error()));
$hitung_lebih=mysql_fetch_array($hitung_lebih);
$hitung_lebih=$hitung_lebih['total'];

$hitung_loading=mysql_query("select * from hitung_loading where tanggal_loading_aksesoris=curdate()");
$hitung_loading=mysql_fetch_array($hitung_loading);
$hitung_loading=$hitung_loading['selesai'] + $hitung_loading['belum_selesai'] + $hitung_loading['batal'] ;
?>
<div class="row">
	<div class="col-md-12">
	   <div class="row">
			<div class="col-md-4">
				<div class="main-box mb-red">
					<a href="<?php echo menu('data-loading-tanggal&tgl='.date("Y-m-d").'&url='.url_ref()) ?>">
						<i class="fa fa-bar-chart-o fa-5x"></i>
						<h5><?php echo $hitung_loading?> Loading</h5>
						<small>Hari ini</small>
					</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="main-box mb-pink">
					<a href="<?php echo menu('list-order') ?>">
						<i class="fa fa-shopping-cart fa-5x"></i>
						<h5><?php echo $hitung_pending?> Pending</h5>
						<br/>
					</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="main-box mb-dull">
					<a href="<?php echo menu('stock-lebih') ?>">
						<i class="fa fa-plus-square fa-5x"></i>
						<h5><?php echo $hitung_lebih ?> Barang Lebih</h5>
						<br/>
					</a>
				</div>
			</div>

		</div>
	</div>
</div>