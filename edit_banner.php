<?php
//******************IDPAGE*****************
$idpage = 4;
//Session check****************************
include_once("php/session_check.php");
include_once("php/function.php");
//********************locally Additionnal Function*************

//*********************Get Profile Data*****
$set_pluggin_datatable = "yes";
$agence = '';
$price = '';
$compte = '';
$backup = "";
$edit = "";
$data_banner = "";
$is_submittion = 0;
//***********************Find Profile****************
//*************************Selection des informations du profile************************


$get_active_menu = "DG";
$page_titre = "Editer Banner";
$page_small_detail = "Ajouter Banner";
//$page_small_detail = $data_banner['label'];
$page_location = "Editer Banner";

if (isset($_GET['find']) || isset($_POST['find'])) {

  $edit = (isset($_GET['find'])) ? clean_in_integer($_GET['find']) : clean_in_integer($_POST['find']);
  $data_banner = get_banner_data($edit);
}
if (isset($_POST['submit']) && $_POST['price'] != "" && $_POST['compte'] != "" && $_POST['agence'] != "") {

  $compte = ($_POST['compte']);
  $agence = ($_POST['agence']);
  $price = addslashes($_POST['price']);

  $feedback = update_banner($compte, $agence, $price, $edit);
  if ($feedback == 1) {
    header("Location:add_banner.php?success=ok&msg=".$success_message.", Modification sur le banner enregistrée avec succès");			

  } else {
    $error = "yes";
    $error_message = "Une erreur a survenu lors de la modification du banner";
  }
}

//****************location******************

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
    <!-- Your Page Content Here -->
    <!-- Horizontal Form -->
    <form class="form-horizontal" method="post" action="<?php echo $_SERVER["PHP_SELF"] . '?' . http_build_query($_GET); ?>">

      <div class="box box-info" style="overflow-y: scroll;">
        <div class="box-header with-border">
          <h3 class="box-title">Mode Edition</h3>
        </div><!-- /.box-header -->
        <!-- form start -->

        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Compte</label>
            <div class="col-sm-10">
              <select name="compte" class="custom-select2 form-control">
                <?php echo getcombo_compte($data_banner['compte']); ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Agence</label>
            <div class="col-sm-10">

              <select name="agence" class="custom-select2 form-control">
                <?php echo getcombo_agence($data_banner['agence']); ?>
              </select>

            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Solde</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" value="<?php echo $data_banner['price']; ?>" name="price" placeholder="ajouter le solde">
            </div>
          </div>


        </div><!-- /.box-body -->
        <div class="box-footer">
          <button type="reset" class="btn btn-default">Annuler</button>
          <button type="submit" class="btn btn-info pull-right" name="submit">Valider</button>
        </div><!-- /.box-footer -->

      </div><!-- /.box -->

    </form>

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

<?php
include_once("php/importation_js.php");

?>
</body>

</html>