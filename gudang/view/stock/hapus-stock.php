<?php 
$id=get('id');
$q=mysql_query("update stock_aksesoris set hapus='ya', date_modified=now() where id_stock='$id'");
if($q)
{
	echo alert("Disimpan dikotak sampah");
	direct(kembali());
}
else
{
	echo alert_error("Error : ". mysql_error());
}
?>