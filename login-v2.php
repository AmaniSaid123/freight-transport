<?php
session_start();
if (isset($_SESSION['my_doc_online'])) {
  session_unset();
  session_destroy();
}

/****** Begin authenticafication_online */

include_once("php/function.php");

if ((isset($_POST['btn_valider']) && isset($_POST['nid_client']) && isset($_POST['nid_client'])
    && isset($_POST['email']) && isset($_POST['email'])
    && $_POST['nid_client'] != "" && $_POST['pin_secret'] != "") ||
  (isset($_GET['pin_secret']) && isset($_GET['email']) && isset($_GET['nid_client']))
) {
  include("param.php");

  $use_username = (isset($_POST['nid_client'])) ? addslashes(htmlspecialchars($_POST['nid_client'])) : addslashes(htmlspecialchars($_GET['nid_client']));
  $use_mdp = (isset($_POST['pin_secret'])) ? addslashes(htmlspecialchars($_POST['pin_secret'])) : addslashes(htmlspecialchars($_GET['pin_secret']));
  $email = (isset($_POST['email'])) ? addslashes(htmlspecialchars($_POST['email'])) : addslashes(htmlspecialchars($_GET['email']));


  //Ex&eacute;cution de la requete**************************************************
  //echo "select count(*) as valide,t.* from t_dossier  where nid_pp='".$use_username."' and pin_secret='".$use_mdp."'";

  $resultat = $bdd->query("select count(*) as valide,t.* from t_dossier t  where (nid_pp='" . $use_username . "' or ndel='" . $use_username . "') and pin_secret='" . $use_mdp . "' and email='" . $email . "' and statut_dossier not in ('Clos_reussi','Clos_echec','Clos_Abandon','	
  Paiement_incomplet') group by idt_dossier");
  $donnee = $resultat->fetch();
  if ($donnee['valide'] == 1) {
    session_start(); // On d&eacute;marre la session AVANT toute chose


    $_SESSION['my_doc_online'] = $donnee['idt_dossier'];
    $_SESSION['username_online'] = "online_user";
    $_SESSION['sessionstarttime_online'] = strtolower(date('H:i:s d/m/Y'));


    if (1) {
      add_notification("t_dossier", $use_username, "Connexion ", "Connexion ", $use_username, "Connexion a MyPASS Online");
      $message = (isset($_GET['msg'])) ? $_GET['msg'] : "Vous êtes connecté à votre compte";
      if (isset($_POST['pin_secret'])) {
        header("Location:view_doc_editable_v2.php?msg=" . $message . "&success=ok");
      } else {
        header("Location:view_doc_editable_v2.php?msg=" . $message . ", Vous etes connécté a votre compte maintenant. Merci de téléverser vos fichier en cliquant sur le bouton ci-bas" . "&success=ok");
      }
    } else {
    }

    // echo 'sa marche';
  } else {
    header("Location:login-v2.php?try=ok&tri=2&idr=2");
  }
}
  //****** End authenticafication_online */

	$page_location="ACCES AU DOSSIER";
 $get_active_menu="dossier_online";
	
$success="yes";
$success_message="Bienvenu à vous, connectez vous pour voir l'evolution de votre dossier";
$error="no";
$warning="no";
$success="no";
$information="no";

$error_message="Error on the page Errorcode=xx001Defaults";
$warning_message="This is a warning";
$success_message="Your request succeed";
$information_message="Welcome in MyPASS";	
  $errorAuth = "";
  if (isset($_GET['try']) && $_GET['try'] == 'ok') {
    $errorAuth = "Mot de Passe ou nom d'utilisateur incorrect";
  }
?>

<!DOCTYPE html>
<html lang="en">

<?php
include_once("php/layouts/head-v2.php");
?>

<?php
// define variables and set to empty values
$nidCLientError = $emailError = $pinSecretError = "";
$nidCLient = $email = $pinSecret = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["nid_client"])) {
    $nidCLientError = "NID Client est obligatoire";
  } else {
    $nidCLient = test_input($_POST["nid_client"]);
  }
  if (empty($_POST["email"])) {
    $emailError = "Email est obligatoire";
  } else {
    $email = test_input($_POST["email"]);
  }

  if (empty($_POST["pin_secret"])) {
    $pinSecretError = "PIN SECRET est obligatoire";
  } else {
    $pinSecret = test_input($_POST["pin_secret"]);
  }
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="index.html" class="logo">
              <img src="front/assets/images/logo passeport.png" alt="Chain App Dev" style="width: 160px;">
            </a>
       
          

          </nav>
        </div>
      </div>
    </div>
  </header>

  <!-- ***** Header Area End ***** -->


  <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                <div class="row">
                  <div class="col-lg-12">
                    <h3>A nos chers clients, nous vous informons que notre site est en maintenance</h3>
                    <p>
                      Vous pouvez connecter pour consulter vos dossiers.
                    </p>
                  </div>
                  <div class="col-lg-12">
                    <div class="white-button first-button scroll-to-section">
                      <a href="dossier_online_v2_new.php"><i
                          class="fa fa-sign-in-alt"></i> Créer Votre Dossier</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <?php include_once("php/print_message.php"); ?>
            <div class="col-lg-6">
              <div class="right-image wow fadeInRight  main-banner-perso" data-wow-duration="1s" data-wow-delay="0.5s">
                <div class="screen">
                  <div class="screen__content">
                    <form class="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                      <h3>Connexion au Dossier
                      </h3>

                      <span class="error" style="line-height: 3em;"> <?php echo $errorAuth; ?></span> 
                 
                      <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input type="text" class="login__input" placeholder="NID" name="nid_client">
                        <span class="error">* </span>
                        <br>
                        <span class="error" align="right"> <?php echo $nidCLientError; ?></span>
                      </div>

                      <div class="login__field">
                        <i class="login__icon fas fa-envelope"></i>
                        <input type="text" class="login__input" placeholder="Email" name="email">
                        <span class="error">* </span>
                        <br>
                        <span class="error" align=right"> <?php echo $emailError; ?></span>
                      </div>
                      <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input type="password" class="login__input" placeholder="PIN SECRET" name="pin_secret">
                        <span class="error">* </span>
                        <br>
                        <span class="error" align=right"> <?php echo $pinSecretError; ?></span>
                      </div>
                      <button class="button login__submit" type="submit" name="btn_valider">
                        <span class="button__text">Accéder au dossier</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                      </button>
                    </form>

                  </div>
                  <div class="screen__background">
                    <span class="screen__background__shape screen__background__shape4"></span>
                    <span class="screen__background__shape screen__background__shape3"></span>
                    <span class="screen__background__shape screen__background__shape2"></span>
                    <span class="screen__background__shape screen__background__shape1"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php
  include_once("php/layouts/footer-v2.php");
  ?>

  <?php
  include_once("php/layouts/script-v2.php");
  ?>
</body>

</html>