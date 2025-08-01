<?php
//******************IDPAGE*****************
$idpage = 9;
//Session check****************************
include_once("php/session_check.php");
include_once("php/function.php");
//********************locally Additionnal Function*************

//****************location******************
$get_active_menu = "journal_user";
$page_titre = "Nouveau Journal";
$page_small_detail = "Création";
$page_location = "Nouveau Journal";
$user_id = $_SESSION['my_userId'];
$profile_id = $_SESSION['my_idprofile'];
$user_name = $_SESSION['my_firstname'] . " " . $_SESSION['my_lastname'];
$error_message = "";
$error = "";

$arriving_time = "";
$exit_time = "";
$description = "";
// Add Journal
if (isset($_POST['submit'])) {
  if ((($_POST["arriving_time"]) == "00:00:00") || (($_POST["exit_time"]) == "00:00:00")) {
    $error = "yes";
    $error_message = "Vous devrez mentionner les vraies heures d'entrée et de sortie en conformité
    avec la pointeuse biometrique.";
  } elseif ((empty($_POST["arriving_time"])) || (empty($_POST["exit_time"])) || (empty($_POST["description"]))) {
    $error = "yes";
    $error_message = "Vous devrez remplir tous les champs obligatoires";
  } else {
    $date = addslashes($_POST['date']);
    $profile_name = $_SESSION['my_profile'];
    $user_id = $_SESSION['my_userId'];
    $arriving_time = addslashes($_POST['arriving_time']);
    $exit_time = addslashes($_POST['exit_time']);
    $description = addslashes($_POST['description']);
    $feedback = add_journal($user_id, $profile_id, $date, $arriving_time, $exit_time, $description);
    if ($feedback == 1) {
      $success = "yes";
      $success_message = "Journal créé avec succès";
      header("Location: ajouter_journal_details.php");
      exit();
    } else {
      $error = "yes";
      $error_message = "Erreur lors de création de journal";
    }
  }
}
if (isset($_POST['submitHoliday'])) {
    $date = addslashes($_POST['date']);
    $profile_name = $_SESSION['my_profile'];
    $user_id = $_SESSION['my_userId'];
    $feedback = add_journal_holiday($user_id, $profile_id, $date);
    if ($feedback == 1) {
      $success = "yes";
      $success_message = "Journal OFF crée avec succès";
      header("Location:home.php?success=add_holiday");
      exit();
    } else {
      $error = "yes";
      $error_message = "Erreur lors de création de jour OFF";
    }
  
}
?>
<!DOCTYPE html>

<html lang="en">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js">
</script>
<!-- Include Moment.js CDN -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js">
</script>

<!-- Include Bootstrap DateTimePicker CDN -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
  rel="stylesheet">

<script
  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
  </script>
<?php
include_once("php/header.php");
?>
<style>
  .style-textarea {
    width: 100%;
    height: 200px;
    font-size: 14px;
    line-height: 18px;
    border: 1px solid #dddddd;
    padding: 10px;
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
</style>
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

    <div class="alert alert-info alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4> <i class="fa fa-exclamation-circle" aria-hidden="true"> Attention ! </i>
      </h4>
      Vous avez jusqu'à 23h45 pour remplir votre rapport d'aujourd'hui.
      A partir de 23h46, cela deviendra impossible de remplir votre rapport pour la journée d'aujourd'hui
      et votre hiérarchie considérera que vous n'avez rien produit aujourd'hui.
    </div>
    <div class="alert alert-info alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4> <i class="fa fa-info-circle" aria-hidden="true"> Attention ! </i>
      </h4>
      Si c'est votre journée OFF, cliquez sur Journée OFF, ensuite cliquez sur le bouton VALIDER ci-dessous pour SOUMETTRE et
      enregistrer votre choix.
    </div>

    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Créer mon journal</h3>
      </div>


      <div class="box-body pull-right">
        <label style="margin-right: 14px;">Journée OFF </label>
        <label class="switch">
          <input type="checkbox" id="Equip">
          <span class="slider round"></span>
        </label>
      </div>

      <br>
      <br>
      <div id="equipText">
        <form class="form-horizontal" action="add_journal.php" method="post">
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-4 ">Nom Utilisateur</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="user_id"
                  value="<?php echo $_SESSION['my_firstname'] . " " . $_SESSION['my_lastname']; ?>" readonly="true">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 ">Nom du Profile</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="profile_id" value="<?php echo $_SESSION['my_profile']; ?>"
                  readonly="true">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 ">Date</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="date" value="<?php echo date("Y/m/d") ?>" readonly="true">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 ">Heure d'arrivée (conforme à la pointeuse biometrique)<font color="#FF0000"> *
                </font></label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="datetime_entree" name="arriving_time">

              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 ">Heure de départ (conforme à la pointeuse biometrique)<font color="#FF0000"> *
                </font></label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="datetime_exit" name="exit_time">


              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 ">Description<font color="#FF0000"> *</font></label>
              <div class="col-sm-8">
                <textarea class="textarea style-textarea" name="description" id="zone"
                  placeholder="Place some text here">
                                 </textarea>
                <script type='text/javascript'>
                  document.forms['Myform'].elements['message'].onkeyup = function () {
                    document.forms['Myform'].elements['nbcaractere'].value = document.forms[
                      'Myform'].elements['message'].value.length;
                  }
                </script>
              </div>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <button type="reset" class="btn btn-default">Annuler</button>
            <button type="submit" class="btn btn-info pull-right" name="submit">Valider</button>
          </div>
        </form>
      </div>
      <div id="equipText2">
        <form class="form-horizontal" action="add_journal.php" method="post">
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-4 ">Nom Utilisateur</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="user_id"
                  value="<?php echo $_SESSION['my_firstname'] . " " . $_SESSION['my_lastname']; ?>" readonly="true">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 ">Nom du Profile</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="profile_id" value="<?php echo $_SESSION['my_profile']; ?>"
                  readonly="true">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 ">Date</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="date" value="<?php echo date("Y/m/d") ?>" readonly="true">
              </div>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <button type="reset" class="btn btn-default">Annuler</button>
            <button type="submit" class="btn btn-info pull-right" name="submitHoliday">Valider</button>
          </div>
        </form>
      </div>

    </div><!-- /.box -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
  <?php
  include_once("php/footer.php");

  ?>
</footer>

<?php
include_once("php/tableau_controle.php");
?>
</div>

<?php
include_once("php/importation_js.php");
?>
<script>
  $(function () {
    $("#equipText2").hide();
    $("#Equip").click(function () {
      if ($(this).is(":checked")) {
        $("#equipText2").show();
        $("#equipText").hide();
      } else {
        $("#equipText2").hide();
        $("#equipText").show();
      }

    });
  });
</script>
</body>

</html>