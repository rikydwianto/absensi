<?php include"../config/setting.php"?>
<?php include"../config/koneksi.php"?>
<?php include"../fungsi/config.php"?>
<?php 
$id=post('id_transaksi');
$id_stock=post('id_stock');
mysql_query("insert into detail_loading_aksesoris(id_loading_aksesoris,id_stock,qty_loading,date_created)
values('$id','$id_stock',1,now())
");
?>