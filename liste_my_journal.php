<?php
//******************IDPAGE*****************
$idpage = 9;
//Session check****************************
include_once("php/session_check.php");
include_once("php/function.php");
//********************locally Additionnal Function*************

//*********************Get Profile Data*****
$set_pluggin_datatable = "yes";
$set_pluggin_selection_wise = "yes";
$set_plugin_daterange = "yes";

//***********************Find Profile****************
//*************************Selection des informations du profile************************

$get_active_menu = "journal_user";
$page_titre = "Mon Journal";
$page_small_detail = "MyPASS";
$page_location = "Gestion des Journaux > Mon Journal";

$active_export = "no";
//****************location******************

$profile_name = $_SESSION['my_profile'];
$my_firstname = $_SESSION['my_firstname'];
$my_lastname = $_SESSION['my_lastname'];
$my_lastname = $_SESSION['my_lastname'];
$my_username = $_SESSION['my_username'];

$daterange = "";
$date_debut = "";
$date_fin = "";

if (isset($_GET['user_id'])) {

  $user_id = clean_in_integer($_GET['user_id']);
  $param_query = $param_query . " where user_id='" . $user_id . "' ";
}
if (isset($_POST["submit"])) {
  $daterange = $_POST['daterange'];
  $user_id = $_SESSION['my_userId'];

  if (isset($_POST['daterange']) && $_POST['daterange'] != "") {
    $tempo = explode("-", $_POST['daterange']);
    $daterange = $_POST['daterange'];
    $date_debut = trim($tempo[0]);
    $date_fin = trim($tempo[1]);
    $param_query = " where user_id='" . $user_id . "' and t_journal_users.date between '" . $date_debut . "' and '" . $date_fin . "' ";
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
<link rel="stylesheet" href="css/styleCustomer.css">
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
    <!-- Your Page Content Here -->
    <!-- Horizontal Form -->
    <form class="form-horizontal" action="liste_my_journal.php" method="post">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Criteres` de recherche</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus" aria-hidden="true"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Profile</label>
            <div class="col-sm-4">
              <input type="text" class="form-control pull-right" value="<?php echo $profile_name; ?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nom</label>
            <div class="col-sm-4">
              <input type="text" class="form-control pull-right" value="<?php echo $my_firstname; ?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Prénom</label>
            <div class="col-sm-4">
              <input type="text" class="form-control pull-right" value="<?php echo $my_lastname; ?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Période ciblée</label>
            <div class="col-sm-4">
              <input type="text" class="form-control pull-right" id="date4" name="daterange"
                value="<?php echo $daterange; ?>" placeholder="Specifiez une date">
            </div>
          </div>
        </div>

        <div class="box-footer">
          <i class="fa fa-warning" aria-hidden="true"> Ce rapport a une limitation d'affichage de 2000 lignes </i>
          <button type="submit" class="btn btn-info pull-right" name="submit">Trouver</button>
        </div><!-- /.box-footer -->

      </div><!-- /.box -->

    </form>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Mode Liste</h3>
      </div><!-- /.box-header -->
      <div class="box-body" style="overflow-y: scroll;">

        <table aria-describedby="tableOfMyJournal" id="example2" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Date</th>
              <th>Nom d'Utilisateur</th>
              <th>Heure Entrée</th>
              <th>Heure Sortie</th>
              <th>H/J</th>
              <th>On/Off</th>
              <th>Status</th>
              <th>Commentaire</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            //$sql_select1 = "SELECT * FROM t_journal_users " . $param_query . "";
            
            $sql_select1 = "SELECT t_journal_users.date, id ,arriving_time, exit_time,t_journal_users.id as idJournal,
             t_journal_users.description as descriptionJournal, comment ,reaction, holiday_day, more_details,
             TIMEDIFF(exit_time, arriving_time) as totalH,t_profile.name AS profile, t_profile.idprofile,
             t_user.firstname,t_user.lastname ,t_user.lastlogon, t_user.iduser, t_user.username
              FROM t_journal_users INNER JOIN t_profile ON t_journal_users.profile_id = t_profile.idprofile
              INNER JOIN t_user ON t_journal_users.user_id = t_user.iduser " . $param_query . " ORDER BY date";
            $sql_result1 = $bdd->query($sql_select1);
            $index = 0;
            while ($data1 = $sql_result1->fetch()) {
              $index++;
            ?>

            <tr>
              <td>
                <?php echo $index; ?>
              </td>
              <td>
                <?php echo $data1['date']; ?>
              </td>
              <td>
                <?php echo $my_username; ?>
              </td>
              
              <td>
                <?php
              if (isset($data1['arriving_time'])) {
                  ?>
                <?php echo $data1['arriving_time']; ?>
                <?php
              } else {
                  ?>
                {{ -- }}
                <?php
              }
                  ?>
              </td>

              <td>
                <?php
              if (isset($data1['exit_time'])) {
                  ?>
                <?php echo $data1['exit_time']; ?>
                <?php
              } else {
                  ?>
                {{ -- }}
                <?php
              }
                  ?>
              </td>

              <td>
                  <?php
                  if (isset($data1['totalH'])) {
                  ?>
                    <?php echo $data1['totalH']; ?>
                  <?php
                  } else {
                  ?>
                    {{ -- }}
                  <?php
                  }
                  ?>
                </td>

                <td>
                  <?php
                  if ($data1['holiday_day']) {
                  ?>
                    <i class='fa fa-calendar-minus-o blue-color' aria-hidden="true"></i>


                  <?php
                  } else {
                  ?>
                    <i class='fa fa-calendar-plus-o green-color' aria-hidden="true"></i>

                  <?php
                  }
                  ?>
                </td>

              <td>
                <?php
              if (((!$data1['descriptionJournal']) && (!$data1['arriving_time']) && (!$data1['exit_time']))
                || (!$data1['descriptionJournal'])
              ) {
                ?>
                <i class='fa fa-exclamation-triangle red-color' aria-hidden="true"></i>
                <?php
              } else {
                ?>
                <i class='fa fa-check-circle-o green-color' aria-hidden="true"></i>

                <?php
              }
                ?>
              </td>
              <td>
              <?php
                  if ($data1['reaction'] == 1) {
                  ?>
                    <i class="fa fa-thumbs-up fa-lg text-primary" aria-hidden="true"></i>
                  <?php } ?>
                  <?php
                  if ($data1['reaction'] == -1) {
                  ?>
                    <i class="fa fa-thumbs-down fa-lg text-danger" aria-hidden="true"></i>
                  <?php } ?>

                  <?php
                  if ($data1['reaction'] == 0) {
                  ?>
                    <i class="fa fa fa-ban fa-lg text-warning" aria-hidden="true"></i>
                  <?php } ?>
                  
                  <?php
                  if ($data1['comment']) {
                  ?>
                    <i class="fa fa-comments text-primary" aria-hidden="true" style="padding:12px;"></i>
                  <?php
                  } else {
                  ?>
                    <i class="fa fa fa-ban fa-lg text-warning" aria-hidden="true" style="padding:12px;"></i>
                  <?php
                  }
                  ?>
              </td>

              <td>
              <?php

              if (($data1['holiday_day']) && (!$data1['more_details'])) {
                ?>
                <i class='fa fa-exclamation-triangle red-color' aria-hidden="true"></i>
                <?php
              } else {
                ?>
                <?php
                if ($date_debut && $date_fin) {
                ?>
                <a
                  href="details_my_journal.php?find=<?php echo $data1['id']; ?>&&dateDebut=<?php echo $date_debut; ?>&&dateFin=<?php echo $date_fin; ?>">
                  <i class="fa fa-eye" aria-hidden="true"></i></a>
                <?php
                } else {
                ?>
                <a href="details_my_journal.php?find=<?php echo $data1['id']; ?>&&date=<?php echo $data1['date']; ?>">
                  <i class="fa fa-eye" aria-hidden="true"></i> </a>

                <?php
                }
                ?>
                <?php
              }
                ?>
              </td>

            </tr>
            <?php

            }

            ?>

          </tbody>

        </table>
      </div><!-- /.box-body -->
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
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->

</div><!-- ./wrapper -->

<?php
include_once("php/importation_js.php");

?>
</body>

</html>