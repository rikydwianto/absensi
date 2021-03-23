<?php
include"config/setting.php";
include"config/koneksi.php";
include"fungsi/config.php";
?>
<!DOCTYPE html>
<html>

<head>
  <?php include_once"view/template/link-head.php"; ?>

</head>

<body class="hold-transition login-page">

    <div class="container">
       
        <div class="row">
			
            <div class="col-md-4 col-md-offset-4">
                <div class="login-box">              
                    <div class="login-logo">
						<div class=" ">
							<br/>
						  <img src="<?php echo url() ?>assets/img/logo.png" alt=""/>
							<br/>
							<h3><?php echo $title?></h3>
						</div>
                    </div>
					
                    <div class="login-box-body">
					
						<br/>
					<?php 
					if(isset($_POST['btn_login']))
					{
						$un = aman($_POST['txt_un']);
						$pswd = aman($_POST['txt_pswd']);
						if(!empty($un)||!empty($pswd))
						{
							$query = mysql_query("select * from user where username='".$un."' and password_user='".$pswd."'");
							$data=mysql_fetch_array($query);
							$rc=mysql_num_rows($query);
							if($rc==1)
							{
								if ($data['lvl_user']=='simpeg' || $data['lvl_user']=='super user') {
									$_SESSION['id_user']			=$data['id_user'];
									$_SESSION['id_karyawan']		=$data['id_karyawan'];
									$_SESSION['username']			=$data['username'];
									$QS_K = mysql_query("select * from karyawan where id_karyawan=".$data['id_karyawan']);
									$QD_K = mysql_fetch_array($QS_K);
									$DD_K_foto = $QD_K['file_foto'];
									$Q_u = mysql_query("update user set last_login=now() where id_user='".$data['id_user']."'") or die (mysql_error());
									echo alert("Welcome!<br>Sekarang anda bisa memasuki sistem.");
									if(isset($_GET['url']))
										$url=urldecode($_GET['url']);
									else
										$url="index.php";
									header("Refresh: 3; URL=$url");
								}
								else
								{
									echo alert_error("maaf anda tidak diberi akses untuk mengakses aplikasi SIMPEG ini, anda hanya bisa login diaplikasi $data[lvl_user]");
								}
							}
							else
							{
								echo alert_error("Username atau password salah!<br /> Silahkan Coba Lagi!");
								
							}
							
						}
						ELSE
						{
							echo alert_error("Username & password belum diisi!");
						}
					}
					?>
                        <form role="form" method='post'>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="txt_un" type="text" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="txt_pswd" required type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
								<button type='submit' name='btn_login' class='btn btn-info form-control'>
									<i class='fa fa-sign-in'></i> Login
								</button>
                            </fieldset>
                        </form>
						<div class='helper-block'>
							<br/>
							<center >
								<strong>
								<?php echo $nm_aplikasi?>
								</strong>
							</center>
						</div>
						
                    </div>
					

                </div>
            </div>
        </div>
    </div>

     <!-- Core Scripts - Include with every page -->
	 <?php include_once"view/template/footer.php"; ?>
</body>

</html>

