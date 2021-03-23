<?php include_once"config/setting.php"; ?>
<?php include_once"config/koneksi.php"; ?>
<?php include_once"fungsi/config.php"; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $nm_aplikasi ?> - <?php echo $title ?></title>

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body style="background-color: #E2E2E2;">
    <div class="container">
        <div class="row text-center " style="padding-top:100px;">
            <div class="col-md-12">
                <h2>PT. LYDIA SOLA GRACIA</h2>
                <h2>WAREHOUSE ACCESSORIS</h2>
            </div>
        </div>
         <div class="row ">
               
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
					<div class="panel-body">
						<form role="form" method=post>
							<hr />
							<h5>Login</h5>
							   <br />
							 <div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
									<input type="text" name='username' class="form-control" placeholder="Your Username " autofocus/>
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
									<input type="password" name='password' class="form-control"  placeholder="Your Password" />
								</div>
								<button class='btn btn-primary' name='login'>Masuk <i class='fa fa-sign-in'></i></button>
							<hr />
						</form>
						<?php 
						if(isset($_POST['login'])){
							$username=post("username");
							$password=post("password");
							$cek=mysql_query("select * from user where username='$username'") or die(alert_error("Error : ". mysql_error()));
							if(mysql_num_rows($cek))
							{
								$user=mysql_fetch_array($cek);
								if($user['password_user']==$password){
									if ($user['lvl_user']=='gudang' || $user['lvl_user']=='super user') {
										mysql_query("update user set last_login=now() where id_user='$user[id_user]'");
										echo alert("Login Berhasil!");
										if(isset($_GET['url']))
											direct(kembali());
										else
										{
											direct(url());
										}
										$_SESSION['ID']=$user['id_karyawan'];
									}
									else{
										echo alert_error("maaf anda tidak diberi akses untuk mengakses aplikasi SIMPEG ini, anda hanya bisa login diaplikasi $user[lvl_user]");
									}
									
								}
								else{
									echo alert_error("User : <b>$username</b> ditemukan, Password Salah!");
								}
							}
							else
							{
								echo alert_error("Username Tidak ditemukan!");
							}
						}
						?>
					</div>     
				</div>
        </div>
    </div>

</body>
</html>