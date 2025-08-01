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
$page_titre = "Détails Journal";
$page_small_detail = "MyPASS";
$page_location = "Gestion des Journaux > Détails Journal";

$active_export = "no";
//****************location******************
$daterange = "";

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
  $page_no = $_GET['page_no'];
} else {
  $page_no = 1;
}

$total_records_per_page = 30;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$result_count = ("SELECT COUNT(*) As total_records FROM t_journal_users");
$sql_result1 = $bdd->query($result_count);

$total_records = $sql_result1->fetch();

$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1; // total page minus 1

if (isset($_GET['dateDebut']) && isset($_GET['dateFin'])) {
  $date_debut = $_GET['dateDebut'];
  $date_fin = $_GET['dateFin'];
  $param_query = " and t_journal_users.date between '" . $date_debut . "' and '" . $date_fin . "' ";
}
$user_id = $_SESSION['my_userId'];
if (isset($_GET['date'])) {
  $date = $_GET['date'];
  $param_query = $param_query . " and date='" . $date . "' ";
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
    <div class="box">
      <?php
      $sql_select1 =  "SELECT t_journal_users.id  as idJournal,
             t_profile.name AS profile , t_user.firstname , t_user.lastname , 
             t_user.lastlogon, t_user.iduser, t_user.username  
             FROM t_journal_users INNER JOIN t_profile ON t_journal_users.profile_id = t_profile.idprofile
            INNER JOIN t_user ON t_journal_users.user_id = t_user.iduser " . $param_query . " and t_journal_users.user_id = $user_id";
      //  echo($sql_select1);
      $sql_result1 = $bdd->query($sql_select1);
      $data1 = $sql_result1->fetch()
      ?>
      <ul class="timeline">
        <li>
          <!-- begin timeline-time -->
          <div class="timeline-body">
            <div class="timeline-header">
              <span class="userimage"><img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt=""></span>
              <span class="username"><a href="javascript:;"></a> <?php echo $data1['username']; ?> <small></small></span>
              <span class="pull-right text-muted">Dernière connexion :<?php echo $data1['lastlogon']; ?></span>

            </div>
            <div class="timeline-content">
              <p>
                <span class="text-style-cutsomer">Profile : </span> <?php echo $data1['profile']; ?>
              </p>
              <p>
                <span class="text-style-cutsomer">Nom : </span> <?php echo $data1['lastname']; ?>
              </p>
              <p>
                <span class="text-style-cutsomer">Prénom : </span> <?php echo $data1['firstname']; ?>
              </p>

            </div>

          </div>
          <!-- end timeline-body -->
        </li>

      </ul>


      <?php
      ?>
      <?php
      $sql_select1 =  "SELECT t_journal_users.date, arriving_time, exit_time,more_details,t_journal_users.id  as idJournal,
             t_journal_users.description as descriptionJournal, comment , reaction, date_comment , comment_by ,
             t_user.firstname , t_user.lastname , 
             t_user.lastlogon, t_user.iduser FROM t_journal_users 
              INNER JOIN t_user ON t_journal_users.user_id = t_user.iduser
               " . $param_query . " and t_journal_users.user_id = $user_id
               LIMIT $offset, $total_records_per_page ";
      //echo ($sql_select1);
      $sql_result1 = $bdd->query($sql_select1);
      $index = 0;
      while ($data1 = $sql_result1->fetch()) {
        $index++;
      ?>

        <ul class="timeline">
          <li>
            <!-- begin timeline-time -->
            <div class="timeline-time">
              <span class="date"> <?php echo $data1['date']; ?></span>
              <span class="date"> <?php echo dateToFrench($data1['date'], "l"); ?></span>

            </div>
            <!-- end timeline-time -->
            <!-- begin timeline-icon -->
            <div class="timeline-icon">
              <a href="javascript:;">&nbsp;</a>
            </div>
            <!-- end timeline-icon -->
            <!-- begin timeline-body -->

            <div class="timeline-body">
              <div class="timeline-header">
                <span class="text-style-cutsomer"> Heure Entrée : </span>
                <span> <?php echo $data1['arriving_time']; ?></span>
                <span class="pull-right">
                  <span class="text-style-cutsomer"> Heure Sortie : </span>
                  <?php echo $data1['exit_time']; ?>
                </span>
              </div>
              <div class="timeline-content">
                <p>
                  <span class="text-style-cutsomer"> Description : </span>
                  <?php echo $data1['descriptionJournal']; ?>
                </p>
              </div>

              <div class="timeline-footer">
                <p>
                  <span class="text-style-cutsomer"> Plus Détails : </span> <?php echo $data1['more_details']; ?>
                </p>
              </div>
              <?php if($data1['comment']) { ?>
              <div class="timeline-comment-box" style="background: #f6f6f6;">
                <div class="timeline-likes">
                  <p>
                    <span class="text-style-cutsomer"> Commentaires :
                  </p>
                  <div class="stats-right">
                    <span class="stats-text">Commenter par : <?php echo $data1['comment_by']; ?></span>
                    <span class="stats-text">Le : <?php echo $data1['date_comment']; ?></span>
                  </div>
                  <div class="stats">
                    <?php
                    if ($data1['reaction'] == 1) {
                    ?>
                      <span class="fa-stack fa-fw stats-icon">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-thumbs-up fa-stack-1x fa-inverse t-plus-1"></i>
                      </span>

                      <span class="stats-total">1 Like</span>

                    <?php } ?>

                    <?php
                    if ($data1['reaction'] == -1) {
                    ?>
                      <span class="fa-stack fa-fw stats-icon">
                        <i class="fa fa-circle fa-stack-2x text-danger"></i>
                        <i class="fa fa-thumbs-down fa-stack-1x fa-inverse t-plus-1"></i>
                      </span>

                      <span class="stats-total">1 Dislike</span>
                    <?php } ?>

                    <?php
                    if ($data1['reaction'] == 0) {
                    ?>

                      <span class="fa-stack fa-fw stats-icon">
                        <i class="fa fa-circle fa-stack-2x text-warning"></i>
                        <i class="fa fa-ban fa-stack-1x fa-inverse t-plus-1"></i>
                      </span>

                    <?php } ?>


                  </div>
                  <br>
                  <p><?php echo $data1['comment']; ?> </p>
                </div>
              </div>
              <?php
              }
              ?>

            </div>
            <!-- end timeline-body -->
          </li>

        </ul>


      <?php
      }

      ?>
      <?php
      if ($date_debut && $date_fin) {
      ?>
        <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
          <strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
        </div>


        <ul class="pagination">
          <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } 
          ?>

          <li <?php if ($page_no <= 1) {
                echo "class='disabled'";
              } ?>>
            <a <?php if ($page_no > 1) {
                  echo "href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=$previous_page'";
                } ?>>Previous</a>
          </li>

          <?php
          if ($total_no_of_pages <= 10) {
            for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
              if ($counter == $page_no) {
                echo "<li class='active'><a>$counter</a></li>";
              } else {
                echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=$counter'>$counter</a></li>";
              }
            }
          } elseif ($total_no_of_pages > 10) {

            if ($page_no <= 4) {
              for ($counter = 1; $counter < 8; $counter++) {
                if ($counter == $page_no) {
                  echo "<li class='active'><a>$counter</a></li>";
                } else {
                  echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=$counter'>$counter</a></li>";
                }
              }
              echo "<li><a>...</a></li>";
              echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=$second_last'>$second_last</a></li>";
              echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
            } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
              echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=1'>1</a></li>";
              echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=2'>2</a></li>";
              echo "<li><a>...</a></li>";
              for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                if ($counter == $page_no) {
                  echo "<li class='active'><a>$counter</a></li>";
                } else {
                  echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=$counter'>$counter</a></li>";
                }
              }
              echo "<li><a>...</a></li>";
              echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=$second_last'>$second_last</a></li>";
              echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
            } else {
              echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=1'>1</a></li>";
              echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=2'>2</a></li>";
              echo "<li><a>...</a></li>";

              for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                if ($counter == $page_no) {
                  echo "<li class='active'><a>$counter</a></li>";
                } else {
                  echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=$counter'>$counter</a></li>";
                }
              }
            }
          }
          ?>

          <li <?php if ($page_no >= $total_no_of_pages) {
                echo "class='disabled'";
              } ?>>
            <a <?php if ($page_no < $total_no_of_pages) {
                  echo "href=details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=$next_page'";
                } ?>>Next</a>
          </li>
          <?php if ($page_no < $total_no_of_pages) {
            echo "<li><a href='details_my_journal.php?find=$id&&dateDebut=$date_debut&&dateFin=$date_fin&&page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
          } ?>
        </ul>


        <br /><br />
      <?php
      }
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

<?php
include_once("php/importation_js.php");
//include_once("php/export_to_csv_js.php");

?>

</body>

</html>