<?php
//******************IDPAGE*****************
$idpage = 67;
//Session check****************************
include_once("php/session_check.php");
include_once("php/function.php");

//****************location******************
$set_pluggin_datatable = "yes";
$set_pluggin_selection_wise = "yes";
$set_plugin_daterange = "yes";
$get_active_menu = "sms";
$page_titre = "Emails dynamiques";
$page_small_detail = "MyPASS";
$page_location = "Accueil > Emails dynamiques";

$returnDataEmailPayment = getMessageEmailData("EMAIL_PAYMENT_WAIT");
$returnDataEmailValid = getMessageEmailData("EMAIL_VALID");
$returnDataEmailInvalid = getMessageEmailData("EMAIL_INVALID");

$cible = "mail_payment.php";

if (isset($_POST['add_message_payment_wait'])) {
  $txt_mail = clean_in_text($_POST['txt_mail']);
  $code = clean_in_text($_POST['code']);
  $write_ = addEmailPayment($txt_mail, $code);
  if ($write_ == 1) {
    $returnDataEmailPayment = getMessageEmailData("EMAIL_PAYMENT_WAIT");
    $success = 'yes';
    $success_message = "Le contenu d'email à été écrit avec succes.";
  } else {
    $error = "yes";
    $error_message = "Une erreur s'est produit lors de l'ecriture du contenu.";
  }
}


if (isset($_POST['update_message_payment_wait'])) {
  $txt_mail = clean_in_text($_POST['txt_mail']);
  $code = clean_in_text($_POST['code']);
  $feedback = updateEmailPayment($txt_mail, $code);
  $returnDataEmailPayment = getMessageEmailData("EMAIL_PAYMENT_WAIT");
  if ($feedback == 1) {
    $success = "yes";
    $success_message = "Messages de souhait ont été changés avec succès.";
  } else {
    $error = "yes";
    $error_message = "Une erreur s'est produit lors de la mise a jour du message de souhait";
  }
}


if (isset($_POST['add_message_valid'])) {
  $txtMailValid = clean_in_text($_POST['txtMailValid']);
  $codeMessgValid = clean_in_text($_POST['codeMessgValid']);
  $write = addEmailPayment($txtMailValid, $codeMessgValid);
  if ($write == 1) {
    $returnDataEmailValid = getMessageEmailData("EMAIL_VALID");
    $success = 'yes';
    $success_message = "Le contenu d'email à été écrit avec succes.";
  } else {
    $error = "yes";
    $error_message = "Une erreur s'est produit lors de l'ecriture du contenu.";
  }
}


if (isset($_POST['update_message_valid'])) {
  $txtMailValid = clean_in_text($_POST['txtMailValid']);
  $codeMessgValid = clean_in_text($_POST['codeMessgValid']);
  $feedback = updateEmailPayment($txtMailValid, $codeMessgValid);
  $returnDataEmailValid = getMessageEmailData("EMAIL_VALID");
  if ($feedback == 1) {
    $success = "yes";
    $success_message = "Messages de souhait ont été changés avec succès.";
  } else {
    $error = "yes";
    $error_message = "Une erreur s'est produit lors de la mise a jour du message de souhait";
  }
}


if (isset($_POST['add_message_invalid'])) {
  $txtMailInvalid = clean_in_text($_POST['txtMailInvalid']);
  $codeMessgInValid = clean_in_text($_POST['codeMessgInValid']);
  $write__ = addEmailPayment($txtMailInvalid, $codeMessgInValid);
  if ($write__ == 1) {
    $returnDataEmailInvalid = getMessageEmailData("EMAIL_INVALID");
    $success = 'yes';
    $success_message = "Le contenu d'email à été écrit avec succes.";
  } else {
    $error = "yes";
    $error_message = "Une erreur s'est produit lors de l'ecriture du contenu.";
  }
}


if (isset($_POST['update_message_invalid'])) {
  $txtMailInvalid = clean_in_text($_POST['txtMailInvalid']);
  $codeMessgInValid = clean_in_text($_POST['codeMessgInValid']);
  $feedback = updateEmailPayment($txtMailInvalid, $codeMessgInValid);
  $returnDataEmailInvalid = getMessageEmailData("EMAIL_INVALID");
  if ($feedback == 1) {
    $success = "yes";
    $success_message = "Messages de souhait ont été changés avec succès.";
  } else {
    $error = "yes";
    $error_message = "Une erreur s'est produit lors de la mise a jour du message de souhait";
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once("php/header.php");

?>
<?php ?>
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
    <div id="light" class="white_content">
      <a onClick="hide_pop()" class="btn-danger"><i class="fa fa-close" aria-hidden="true" />Fermer Ici</i></a>
      <?php include_once("vue_white_popup_zone.php"); ?>
    </div>
    <!-- Your Page Content Here -->
    <form class="form-horizontal" action="<?= $cible ?>" method="post">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Mes Paramètres des emails</h3>
            </div>


            <div class="box-body no-padding">
              <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title" style="color: cornflowerblue;font-size: 20px;">
                  Attente de Validation du Paiement <i class="fa fa-setting" aria-hidden="true" /></i>
                  </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" aria-hidden="true" /></i></button>
                  </div>
                </div>

                <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Email </label>
                    <div class="col-sm-10">
                      <input type="text" name="code" class="form-control" value="EMAIL_PAYMENT_WAIT" readonly="readonly" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Texte Email</label>
                    <div class="col-sm-10">
                      <textarea class="textarea" name="txt_mail" id="zone" placeholder="Ecrivez un message de Souhait pour le maul ici" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                      <?php echo $returnDataEmailPayment['txt_mail']; ?>
                    </textarea><br>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="box-footer">
                        <?php if ($returnDataEmailPayment) { ?>
                          <button type="submit" class="btn btn-info pull-right" name="update_message_payment_wait"><i class="fa fa-save" aria-hidden="true" /></i>
                            Modifier MSG
                          </button>
                        <?php } else { ?>
                          <button type="submit" class="btn btn-success pull-right" name="add_message_payment_wait"><i class="fa fa-save" aria-hidden="true" /></i>
                            Ajouter MSG
                          </button>
                        <?php } ?>
                      </div>
                    </div><!-- /.col -->
                  </div><!-- /.col -->
                </div>
              </div>
            </div>



            <div class="box-body no-padding">
              <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title" style="color: cornflowerblue;font-size: 20px;">
                    Paiement Validé<i class="fa fa-setting" aria-hidden="true" /></i>
                  </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" aria-hidden="true" /></i></button>
                  </div>
                </div>

                <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Email </label>
                    <div class="col-sm-10">
                      <input type="text" name="codeMessgValid" class="form-control" value="EMAIL_VALID" readonly="readonly" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Texte Email</label>
                    <div class="col-sm-10">
                      <textarea class="textarea" name="txtMailValid" id="zone1" placeholder="Ecrivez un message de Souhait pour le maul ici" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                      <?php echo $returnDataEmailValid['txt_mail']; ?></textarea><br>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="box-footer">
                        <?php if ($returnDataEmailValid) { ?>
                          <button type="submit" class="btn btn-info pull-right" name="update_message_valid"><i class="fa fa-save" aria-hidden="true" /></i>
                            Modifier MSG
                          </button>
                        <?php } else { ?>
                          <button type="submit" class="btn btn-success pull-right" name="add_message_valid"><i class="fa fa-save" aria-hidden="true" /></i>
                            Ajouter MSG
                          </button>
                        <?php } ?>
                      </div>
                    </div><!-- /.col -->
                  </div><!-- /.col -->
                </div>
              </div>
            </div>

            <div class="box-body no-padding">
              <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title" style="color: cornflowerblue;font-size: 20px;">
                  Paiement Invalidé <i class="fa fa-setting" aria-hidden="true" /></i>
                  </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" aria-hidden="true" /></i></button>
                  </div>
                </div>

                <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Email </label>
                    <div class="col-sm-10">
                      <input type="text" name="codeMessgInValid" class="form-control" value="EMAIL_INVALID" readonly="readonly" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Texte Email</label>
                    <div class="col-sm-10">
                      <textarea class="textarea" name="txtMailInvalid" id="zone2" placeholder="Ecrivez un message de Souhait pour le maul ici" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                      <?php echo $returnDataEmailInvalid['txt_mail']; ?></textarea><br>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="box-footer">
                        <?php if ($returnDataEmailInvalid) { ?>
                          <button type="submit" class="btn btn-info pull-right" name="update_message_invalid"><i class="fa fa-save" aria-hidden="true" /></i>
                            Modifier MSG
                          </button>
                        <?php } else { ?>
                          <button type="submit" class="btn btn-success pull-right" name="add_message_invalid"><i class="fa fa-save" aria-hidden="true" /></i>
                            Ajouter MSG
                          </button>
                        <?php } ?>
                      </div>
                    </div><!-- /.col -->
                  </div><!-- /.col -->
                </div>
              </div>
            </div>





          </div>
        </div>
      </div>
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


</div><!-- ./wrapper -->
<?php
include_once("php/importation_js.php");

?>
</body>

</html>