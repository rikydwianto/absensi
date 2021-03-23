<?php include"../config/setting.php"?>
<?php include"../config/koneksi.php"?>
<?php include"../fungsi/config.php"?>

<?php
$id= post('id_order');
$qty= post('qty_terima');
$qty_order= post('qty_order');
$qty_lebih= post('total');
$qty_sudah_terima= post('qty_sudah_terima');
$tgl= ubah_tanggal(post('tgl_datang'));
$ket= post('keterangan');
$status= post('status');
$q=mysql_query("select * from order_aksesoris 
	join buyer on order_aksesoris.id_buyer=buyer.id_buyer 
	join suplier on order_aksesoris.id_suplier=suplier.id_suplier where id_order='$id'");
$r=mysql_fetch_array($q);
$cari_barang=mysql_query("select id_stock from stock_aksesoris where id_order='$r[id_order]'");

if($status=='kurang')
{
	$barang="barang kurang";
	$qty_akhir=$qty;
}
else if($status=='lebih')
{
	$barang='sukses';
	$qty_akhir=$qty_order-$qty_sudah_terima;
		
		mysql_query("insert into stock_aksesoris(nama_style,deskripsi,size,warna,qty,keterangan,satuan,tanggal_input,id_karyawan,date_created,date_modified,lebihan,id_order) values('$r[nama_style]','$r[deskripsi]','$r[size]','$r[warna]','$qty_lebih','$r[keterangan]','$r[satuan]',curdate(),'$_SESSION[ID]',now(),now(),'ya','$id')");	
}
else if($status=='sesuai')
{
	$qty_akhir=$qty;
	$barang='sukses';
}

mysql_query("update order_aksesoris set status_order='$barang' where id_order='$id'");	

if(!mysql_num_rows($cari_barang))
{
	mysql_query("insert into stock_aksesoris(nama_style,deskripsi,size,warna,qty,keterangan,satuan,tanggal_input,id_karyawan,date_created,date_modified,lebihan,id_order) values('$r[nama_style]','$r[deskripsi]','$r[size]','$r[warna]','$qty_akhir','$r[keterangan]','$r[satuan]',curdate(),'$_SESSION[ID]',now(),now(),'tidak','$id')");	
}
else{
	$rBar=mysql_fetch_array($cari_barang);
	mysql_query("update stock_aksesoris set qty= qty + $qty_akhir , date_modified=NOW() where id_stock='$rBar[id_stock]'");
}
mysql_query("insert into kedatangan_barang(id_order,qty_datang,keterangan_datang,tanggal_datang,status_datang,id_karyawan,date_created)
	values('$id','$qty','$ket','$tgl','$status','$_SESSION[ID]',now())
");
if(mysql_error())
	echo alert_error(mysql_error());
?>
