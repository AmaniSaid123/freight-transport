<?php
//******************IDPAGE*****************
$idpage = 1;

//Session check****************************

require_once __DIR__ . '/session_check.php';

require_once __DIR__ . '/../../../php/function.php';

//****************location******************
$get_active_menu = "";
$page_titre = "TrustedCargo";
$page_small_detail = "Version 1.0";
$page_location = "Accueil";


// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
  header("Location: " . BASE_URL . "index.php?page=login");
  exit;
}

$user = get_user_data_by_username($bdd, $_SESSION['my_username']);

if (isset($_GET['close']) && $_GET['close'] == "ok") {


  $_SESSION['mi_m_profile'] = "NA";
  $_SESSION['my_m_user'] = "NA";
  $_SESSION['my_m_membre'] = "NA";


  $_SESSION['my_m_lock'] = "NA";
  $success = "yes";
  $success_message = "Tous les sous dossiers actifs ont été fermés";
}

?>

<!DOCTYPE html>

<html>

<body onbeforeprint="ShowLoading()" onbeforeunload="ShowLoading()"
    class="hold-transition skin-purple sidebar-collapse sidebar-mini     <?php echo (isset($is_fixed)) ? "fixed" : ""; ?>">

    <?php include_once __DIR__ . '/../../layouts/header.php'; ?>


    <div class="content-wrapper">

        <section class="content-header">
            <?php include_once __DIR__ . '/../../layouts/titre_location.php'; ?>
        </section>


        <section class="content">

            <?php include_once __DIR__ . '/print_message.php'; ?>
            <?php if ($user['task_list'] != '') {

        ?>

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Mes Taches</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
                    <div class="col-sm-10">
                        <?php echo $user['task_list']; ?>
                    </div>
                </form>
            </div>




            <?php }

      ?>
        </section>
    </div>


    <footer class="main-footer">
        <?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
    </footer>

    <?php include_once __DIR__ . '/../../layouts/tableau_controle.php'; ?>

    <?php include_once __DIR__ . '/../../assets/js/script.php';?>
</body>

</html>