<?php
//******************IDPAGE*****************
$idpage = 9;
//Session check****************************
include_once("php/session_check.php");
include_once("php/function.php");
//********************locally Additionnal Function*************

//****************location******************
$get_active_menu = "journal_user";
$page_titre = "Ajouter Plus Détails Journal";
$page_small_detail = "Ajout des détails";
$page_location = "Ajouter Plus Détails Journal";
$user_id = $_SESSION['my_userId'];
if (isset($_POST['submit'])) {

  $more_details = addslashes($_POST['more_details']);
  $date = date("Y/m/d");
  $feedback_more = add_more_journal($user_id, $more_details, $date);
  if ($feedback_more == 1) {
    $success = "yes";
    $success_message = "Ajout des notes avec succès";
    header("Location:home.php?success=ajout_journal");
    exit();
  } else {
    $error = "yes";
    $error_message = "Erreur lors de l'ajout ";
  }
}
if (isset($_POST['annuler'])) {
  $more_details = Null;
  $date = date("Y/m/d");
  $feedback_more = add_more_journal($user_id, $more_details, $date);
  if ($feedback_more == 1) {
    header("Location:home.php?success=ajout_journal");
    exit();
  } else {
    $error = "yes";
    $error_message = "Erreur lors de l'ajout ";
  }
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
<style>

</style>
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
    <!-- Your Page Content Here -->
    <!-- Horizontal Form -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Ajouter Plus de détails (Facultatif)</h3>
      </div><!-- /.box-header -->
      <form class="form-horizontal" action="ajouter_journal_details.php" method="post">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-4 ">Notes</label>

            <div class="col-sm-8">
              <textarea class="textarea" name="more_details" id="zone" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
              <script type='text/javascript'>
                document.forms['Myform'].elements['message'].onkeyup = function() {
                  document.forms['Myform'].elements['nbcaractere'].value = document.forms['Myform'].elements['message'].value.length;
                }
              </script>
            </div>

          </div>
        </div>
        <div class="box-footer">
          <button type="reset" class="btn btn-default">Annuler</button>
          <button type="submit" class="btn btn-info pull-right" name="submit">Soumettre</button>
          </br>
          </br>
          <button type="submit" class="btn btn-info pull-right" name="annuler">Rien À Ajouter</button>
        </div>
      </form>
    </div>
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