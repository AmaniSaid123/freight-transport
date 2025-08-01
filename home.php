<?php
//******************IDPAGE*****************
$idpage = 1;
//Session check****************************
include_once("php/session_check.php");
include_once("php/function.php");

//****************location******************
$get_active_menu = "";
$page_titre = "MyPASS";
$page_small_detail = "Version 1.0";
$page_location = "Accueil";
// Add show banner 
$resultat = $bdd->query("select solde_usd from t_livre_compte where account_no = 57 and ref_agence=" . $_SESSION['my_agence'] . " ");
$dataSolde = $resultat->fetch();
if (isset($dataSolde) && $dataSolde['solde_usd']) {
  $solde_final = $dataSolde['solde_usd'];
}
$resultat2 = $bdd->query("select price from t_banners where compte = 57 and agence=" . $_SESSION['my_agence'] . " ");
$dataPrice = $resultat2->fetch();
if (isset($dataPrice) && $dataPrice['price']) {
  $price = $dataPrice['price'];
}





$user = get_user_data_by_username($_SESSION['my_username']);

if (isset($_GET['close']) && $_GET['close'] == "ok") {


  $_SESSION['mi_m_profile'] = "NA";
  $_SESSION['my_m_user'] = "NA";
  $_SESSION['my_m_membre'] = "NA";


  $_SESSION['my_m_lock'] = "NA";
  $success = "yes";
  $success_message = "Tous les sous dossiers actifs ont été fermés";
}

if (isset($_POST['submit_change_agence'])) {

  $feed_agence = get_agence_data($_POST['agence']);

  if ($feed_agence['is_exist'] == 1) {

    $_SESSION['my_agence'] = $feed_agence['id_agence'];
    $success = "yes";
    $success_message = "Votre agence de connexion est changé avec succes";
  }
}
if (isset($_POST['submit_taux'])) {

  set_off_taux();
  $feedback = add_taux(clean_in_integer($_POST['taux']));
  if ($feedback == 1) {
    add_notification("t_taux", 0, "Nouveau Taux : " . $_POST['taux'], "Nouveau Taux : " . $_POST['taux'], $_SESSION['my_username'], "Edition taux du Jour");
    $success = "yes";
    $success_message = "Taux du jour defini avec succes";
  }
}
if (isset($_GET['refresh'])) {
  $data_taux = get_taux();
  $_SESSION['my_taux'] = $data_taux['valeur'];
  $_SESSION['my_id_taux'] = $data_taux['id_taux'];
}




?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<?php
include_once("php/header.php");

?>
<?php  ?>
<!-- Sidebar Menu -->
<?php
include_once("php/main_menu.php");

?>

<!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <?php
    include_once("php/titre_location.php");

    ?>
  </section>

  <!-- Main content -->
  <section class="content">
    <?php include_once("php/print_message.php"); ?>
    <?php if (get_access(63, $_SESSION['my_idprofile']) == 1) { ?>
      <?php
      if ((isset($solde_final) && isset($price)) && ((int)$solde_final >= (int)$price)) {
      ?>
        <div class="alert alert-warning alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4> <i class="icon fas fa-exclamation"></i>
            Attention ! Le solde actuel de la caisse dépasse le montant recommandé. Veuillez faire les OP prévus, ensuite le dépôt à la banque le plus tôt possible.
          </h4>
        </div>
      <?php
      }
      ?>

    <?php } ?>

    <!-- Your Page Content Here -->
    <div id="light" class="white_content">
      <a onClick="hide_pop()" class="btn-danger"><i class="fa  fa-close">Fermer Ici</i></a>
      <?php
      //*******************************Modification Cote Systematique ****************************
      if (isset($_POST['change_taux']) && get_access(39, $_SESSION['my_idprofile']) == 1) {

      ?>

        <form class="form-horizontal" action="home.php" method="post">
          <p align="center">
          <h4>Definir le du jour, Ancien Taux : <?php echo $_SESSION['my_taux']; ?></h4>
          </p>
          <div class="box-body">

            <div class="form-group">
              <label class="col-sm-4 control-label">Taux du Jour</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" value="<?php echo $_SESSION['my_taux']; ?>" name="taux">
              </div>
            </div>




          </div><!-- /.box-body -->
          <div class="box-footer">
            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
            <button type="submit" class="btn btn-info pull-right" name="submit_taux">Valider</button>
          </div><!-- /.box-footer -->
        </form>



      <?php
      } else {

        if (isset($_GET['set_taux']) && $_GET['set_taux'] == "yes" && 0) {

          echo '<p align="center"><h4>Desole vous n avez pas le droit de definir le taux du Jour</h4></p>';
        }
      }
      ?>
    </div>
    <div id="fade" class="black_overlay"></div>

    <?php if ($user['task_list'] != '') {

    ?>

      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Mes Taches</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
          <div class="col-sm-10">
            <?php echo $user['task_list'];   ?>
          </div>


      </div>
      <!-- /.row -->
</div><!-- /.box-body -->

</form>
</div>
<?php  }

?>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
  <?php
  include_once("php/footer.php");

  ?>
</footer>

<!-- Control Sidebar -->

<?php
include_once("php/tableau_controle.php");

?>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->

</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<?php
include_once("php/importation_js.php");

?>
</body>

</html>