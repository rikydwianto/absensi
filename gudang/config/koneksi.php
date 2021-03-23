<?php
$conn = mysql_connect( $host, $user, $pass) or die('Error : Could not connect to mysql server.<br>' . mysql_error());
mysql_select_db($dabname, $conn) or die('Error : Could not select database.');

?>