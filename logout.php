<?php
include"config/setting.php";
include"config/koneksi.php";
include"fungsi/config.php";
session_destroy();
unset($_SESSION);
direct("login.php");
?>