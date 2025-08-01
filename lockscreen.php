<?php
	//******************IDPAGE*****************
	$idpage=1;
	

	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//****************location******************

if(isset($_GET['lock']) && !isset($_POST['lock'])){
$_SESSION['my_m_lock']="yes";		
	
	}
if(isset($_POST['lock'])){
	
	include("php/param.php");
$resultat= $bdd ->query("select count(*) as valide from t_user t  where username='".$_SESSION['my_username']."' and password='".clean_in_text($_POST['password'])."' and status='a' group by username");
//echo "select count(*) as valide from t_user t  where username='".$_SESSION['username']."' and password='".$_POST['password']."' and status='a' group by username";
$donnee=$resultat->fetch();
	
	if ($donnee['valide']==1)
{
	
	if($_SESSION['my_idprofile']==2){
		
		header("Location:home.php?success=ok&msg=Recuperation session reussi");	
		
		}else{
			
		header("Location:home.php?success=ok&msg=Recuperation session reussi");	
			}
	
}else{
	
		header("Location:lockscreen.php?try=ok");
	}
	
	
	}	
	
	
	
	?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MyPASS | Lockscreen</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->

    <!-- Font Awesome -->
      <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
 <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition lockscreen">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
      <div class="lockscreen-logo">
        <a href="#"><b>MyPASS Portal</b></a>
      </div>
      <!-- User name -->
      <div class="lockscreen-name"><?php  echo $_SESSION['my_firstname']." ".$_SESSION['my_lastname']; ?></div>

      <!-- START LOCK SCREEN ITEM -->
      <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
          <img src="<?php  echo $_SESSION['my_user_picture']; ?>" alt="User Image">
        </div>
        <!-- /.lockscreen-image -->

        <!-- lockscreen credentials (contains the form) -->
        <form class="lockscreen-credentials"  action="lockscreen.php" method="post" name="lock">
          <div class="input-group">
            <input type="password" class="form-control" placeholder="password" name="password">
            <div class="input-group-btn">
              <button class="btn" name="lock"><i class="fa fa-arrow-right text-muted"></i></button>
            </div>
          </div>
        </form><!-- /.lockscreen credentials -->
	<?php
	if(isset($_GET['try']) and $_GET['try']=='ok'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Mot de Passe incorrect");';
			echo "</SCRIPT>";
			
			}
	
	if(isset($_GET['error']) and $_GET['error']=='login'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Veuillez vous reconnecter d\'abord");';
			echo "</SCRIPT>";
			
			}
			
	if(isset($_GET['error']) and $_GET['error']=='inactivity'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Votre compte est verrouillé pour non utilisation au dela de 60 minutes");';
			echo "</SCRIPT>";
			
			}
if(isset($_GET['error']) and $_GET['error']=='autorisation'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Votre profile n\' a pas le droit d\'acceder a cette page, Reconnectez-vous!");';
			echo "</SCRIPT>";
			
			}			
	
	
	?>	
	
      </div><!-- /.lockscreen-item -->
      <div class="help-block text-center">
        Entrez votre mot de passe pour accéder à votre session
      </div>
      <div class="text-center">
        <a href="deconnect.php">Ou Reconnectez-vous comme un autre utilisateur </a>
      </div>
      <div class="lockscreen-footer text-center">
        Copyright &copy; 2018 <b><a href="#" class="text-black">E-Solution</a></b><br>
        All rights reserved
      </div>
    </div><!-- /.center -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
