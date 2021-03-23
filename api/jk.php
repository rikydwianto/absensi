<?php 
$hitung=mysql_query("SELECT SUM(IF(jenis_kelamin=0,1,0)) AS laki,SUM(IF(jenis_kelamin=1,1,0)) AS cewe,SUM(IF(jenis_kelamin=NULL,1,0)) AS lain, COUNT(jenis_kelamin) AS total FROM karyawan");
$hitung=mysql_fetch_array($hitung);
?>
