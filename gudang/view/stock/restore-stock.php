<?php 
$id=get("id");
$q=mysql_query("update stock_aksesoris set hapus='tidak' where id_stock='$id'");
if($q){
	echo alert("Berhasil kembalikan ke Stock on Hand/Gudang data lebih");
}
else
{
	echo alert_error("Error : ".mysql_error());
}
direct(kembali());
?>