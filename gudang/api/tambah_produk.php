<?php include_once"../config/setting.php"; ?>
<?php include_once"../config/koneksi.php"; ?>
<?php include_once"../fungsi/config.php"; ?>
<?php
$id_ambil = $_SESSION['id_input'];
$id_bahan = $_SESSION['id_input_bahan'];
@$id_sparepart = post("id_sparepart");
if(isset($_POST['tambah_produk'])){
	$cek = mysql_query("select * from sparepart where id_sparepart='$id_sparepart'");
	$sp = mysql_fetch_array($cek);
	$harga = $sp['harga_sparepart'];
	$qty = post("qty");
	$input=mysql_query("insert into detail_ambilan_sp(id_ambilan_sp,id_sparepart,qty_ambilan,harga_ambilan) values($id_ambil,'$id_sparepart','$qty','$harga')");
}
else if(isset($_POST['reset_item'])){
	$id = post("id_sparepart");
	mysql_query("delete from detail_ambilan_sp where id_ambilan_sp='$id'");
	mysql_query("delete from detail_loading_aksesoris where id_loading_aksesoris='$id_bahan'");
}
else if(isset($_POST['sukses'])){
	mysql_query("update loading_aksesoris set status_loading='selesai', date_modified=now() where id_loading_aksesoris='$id_bahan'");
	$qbahan = mysql_query("select * from loading_aksesoris join detail_loading_aksesoris on loading_aksesoris.id_loading_aksesoris=detail_loading_aksesoris.id_loading_aksesoris
	join stock_aksesoris on stock_aksesoris.id_stock=detail_loading_aksesoris.id_stock where loading_aksesoris.id_loading_aksesoris='$id_bahan'");

	if(mysql_num_rows($qbahan)){
		while($rbahan = mysql_fetch_array($qbahan)){
			mysql_query("update stock_aksesoris set qty=qty-$rbahan[qty_loading], date_modified=now() where id_stock='$rbahan[id_stock]'");
			$insert = "insert into penggunaan_bahan(id_bahan,tanggal_penggunaan_bahan,qty_penggunaan_bahan,keterangan_penggunaan_bahan,date_created,status_penggunaan)
		values('$rbahan[id_stock]',curdate(),'$rbahan[qty_loading]','Loading bahan ',now(),'kredit')
		";
		mysql_query($insert);
		}
	}
	else
	{
		mysql_query("delete from loading_aksesoris where id_loading_aksesoris='$id_bahan'");
	}
	$q = mysql_query("select * from detail_ambilan_sp where id_ambilan_sp='$id_ambil'");
	if(mysql_num_rows($q)){
		mysql_query("update ambilan set status_ambilan='sukses' where id_ambilan_sp='$id_ambil'");
		while($r = mysql_fetch_array($q)){
			mysql_query("insert into penggunaan_sparepart(id_sparepart,tanggal_penggunaan_sp,qty_penggunaan_sp,date_created,keterangan_penggunaan_sp)
				values('$r[id_sparepart]',curdate(),'$r[qty_ambilan]',now(),'Ambilan sp')
				");
			mysql_query("update sparepart set stock_sparepart=stock_sparepart - $r[qty_ambilan] where id_sparepart='$r[id_sparepart]'");

			//echo $r['id_sparepart'];
		}
	}
	else
	{
		mysql_query("delete from ambilan where id_ambilan_sp='$id_ambil'");
	}
	unset($_SESSION['id_input']);
	unset($_SESSION['id_input_user']);
	unset($_SESSION['id_input_bahan']);
}
else if(isset($_POST['delete_sparepart'])){
	mysql_query("delete from detail_ambilan_sp where id_sparepart ='$id_sparepart'");
}
else if(isset($_POST['delete_bahan'])){
	$id_stock = post("id_stock");
	mysql_query("delete from detail_loading_aksesoris where id_stock ='$id_stock'");
}
else if(isset($_POST['tambah_bahan'])){
	$id = $_SESSION['id_input_bahan'];
	$id_stock = post("id_bahan");
	$qty = post("qty");
	mysql_query("insert into detail_loading_aksesoris(id_loading_aksesoris,id_stock,qty_loading,date_created) values('$id','$id_stock','$qty',now())
");

}
else if(isset($_POST['batal_transaksi'])){
	mysql_query("delete from loading_aksesoris  where id_loading_aksesoris='$id_bahan'");
	mysql_query("update ambilan set status_ambilan='batal' where id_ambilan_sp='$id_ambil'");
}
else if(isset($_POST['retur'])){
	mysql_query("update loading_aksesoris set status_loading='retur', date_modified=now() where id_loading_aksesoris='$id_bahan'");
	$qbahan = mysql_query("select * from loading_aksesoris join detail_loading_aksesoris on loading_aksesoris.id_loading_aksesoris=detail_loading_aksesoris.id_loading_aksesoris
	join stock_aksesoris on stock_aksesoris.id_stock=detail_loading_aksesoris.id_stock where loading_aksesoris.id_loading_aksesoris='$id_bahan'");

	if(mysql_num_rows($qbahan)){
		while($rbahan = mysql_fetch_array($qbahan)){
			mysql_query("update stock_aksesoris set qty=qty-$rbahan[qty_loading], date_modified=now() where id_stock='$rbahan[id_stock]'");

		}
	}
	else
	{
		mysql_query("delete from loading_aksesoris where id_loading_aksesoris='$id_bahan'");
	}
	$q = mysql_query("select * from detail_ambilan_sp where id_ambilan_sp='$id_ambil'");
	if(mysql_num_rows($q)){
		mysql_query("update ambilan set status_ambilan='retur' where id_ambilan_sp='$id_ambil'");
		while($r = mysql_fetch_array($q)){
			mysql_query("insert into penggunaan_sparepart(id_sparepart,tanggal_penggunaan_sp,qty_penggunaan_sp,date_created,keterangan_penggunaan_sp)
				values('$r[id_sparepart]',curdate(),'$r[qty_ambilan]',now(),'retur barang')
				");
			mysql_query("update sparepart set stock_sparepart=stock_sparepart - $r[qty_ambilan] where id_sparepart='$r[id_sparepart]'");

			//echo $r['id_sparepart'];
		}
	}
	else
	{
		mysql_query("delete from ambilan where id_ambilan_sp='$id_ambil'");
	}
	unset($_SESSION['id_input']);
	unset($_SESSION['id_input_user']);
	unset($_SESSION['id_input_bahan']);
}
?>