<?php 
function waktu_edit($table)
{
	$q=mysql_query("update $table set date_modified=now()");
}
?>