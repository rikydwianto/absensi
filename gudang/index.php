<?php include_once"config/setting.php"; ?>
<?php include_once"config/koneksi.php"; ?>
<?php include_once"fungsi/config.php"; ?>
<?php cek_login(); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include"view/template/link-head.php" ?>
</head>
<body>
    <div id="wrapper">
        <?php include"view/template/header.php" ?>
        <?php include"view/template/side-bar.php" ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <?php 
				if(!isset($_GET['mn']))
				{
					include"view/template/awal.php";
				}
				else
				{
					$mn=get('mn');
					if($mn=='po')
						include"view/po/form.php";
					else if($mn=='list-order')
						include"view/po/list-order.php";
					else if($mn=='stock')
						include"view/stock/stock_gudang.php";
					else if($mn=='stock-lebih')
						include"view/stock/stock_lebih.php";
					else if($mn=='plus-stock')
						include"view/stock/plus_stock.php";
					else if($mn=='loading')
						include"view/loading/loading.php";
					else if($mn=='cart')
						include"view/loading/cart.php";
					else if($mn=='tambah-stock')
						include"view/stock/tambah_stock.php";
					else if($mn=='edit-stock')
						include"view/stock/edit_stock.php";
					else if($mn=='data-loading')
						include"view/loading/data-loading.php";
					else if($mn=='hapus-stock')
						include"view/stock/hapus-stock.php";
					else if($mn=='data-loading-tanggal')
						include"view/loading/data-loading-tanggal.php";
					else if($mn=='detail_loading')
						include"view/loading/detail_loading.php";
					else if($mn=='suplier')
						include"view/suplier/suplier.php";
					else if($mn=='kotak-sampah')
						include"view/stock/stock_sampah.php";
					else if($mn=='laporan-sparepart')
						include"view/sparepart/sparepart.php";
					else if($mn=='sparepart')
						include"view/sparepart/tampilsparepart.php";
					else if($mn=='data-sparepart')
						include"view/sparepart/data-ambilan.php";
					else if($mn=='pengambilan_sparepart')
						include"view/sparepart/pengambilan_sparepart.php";
					else if($mn=='sparepart-no')
						include"view/sparepart/sparepartfree.php";
					else if($mn=='penggunaan-sparepart')
						include"view/sparepart/penggunaan-sparepart.php";
					else if($mn=='laporan-penggunaan-sparepart')
						include"view/sparepart/laporan-penggunaan-sparepart.php";
					else if($mn=='laporan-penggunaan-sparepart-hari')
						include"view/sparepart/laporan-penggunaan-sparepart-hari.php";
					else if($mn=='laporan-penggunaan-sparepart-tahun')
						include"view/sparepart/laporan-penggunaan-sparepart-tahun.php";
					else if($mn=='laporan-penggunaan-sparepart-semua')
						include"view/sparepart/laporan-penggunaan-sparepart-semua.php";
					else if($mn=='tambah-sparepart')
						include"view/sparepart/tambah-sparepart.php";
					else if($mn=='hapus-sparepart')
						include"view/sparepart/hapus-sparepart.php";
					else if($mn=='edit-sparepart')
						include"view/sparepart/edit-sparepart.php";
					else if($mn=='tambah-stock-sparepart')
						include"view/sparepart/tambah-stock-sparepart.php";
					else if($mn=='restore')
						include"view/stock/restore-stock.php";
					else if($mn=='tambah-suplier')
						include"view/suplier/tambah-suplier.php";
					else if($mn=='edit-suplier')
						include"view/suplier/edit-suplier.php";
					else if($mn=='hapus-suplier')
						include"view/suplier/hapus-suplier.php";
					else if($mn=='buyer')
						include"view/buyer/buyer.php";
					else if($mn=='retur-suplier')
						include"view/stock/retur-suplier.php";
					else if($mn=='edit-order')
						include"view/po/edit-order.php";
					else if($mn=='satuan')
						include"view/satuan/satuan.php";
					else if($mn=='hapus-ambilan')
						include"view/sparepart/hapus-ambilan.php";
					else if($mn=='laporan')
						include"view/laporan_bahan/laporan.php";
					else
						echo "Error";
				}
				?>

            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <?php include"view/template/footer.php"; ?>


</body>
</html>
