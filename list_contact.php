<?php
$idpage = 68;
//Session check****************************
include_once("php/session_check.php");
include_once("php/function.php");
//********************locally Additionnal Function*************
global $bdd;
// Initialize variables
$set_pluggin_datatable = "yes";
$set_pluggin_selection_wise = "yes";
$set_plugin_daterange = "yes";
$get_active_menu = "contact";
$page_titre = "Contacts";
$page_small_detail = "MyPASS";
$page_location = "Gestion des contacts";
$active_export = "no";
$daterange = $param_query = "";
$date_debut = $date_fin = "";
$ndel = "";
$errors = [];

// delete contact
if (isset($_GET["del"]) && get_access(66, $_SESSION['my_idprofile']) == 1) {
  $id = clean_in_integer($_GET["del"]);
    try {
        $feedback_deletion = $bdd->exec("delete from t_contacts where id=" . $id);
        if ($feedback_deletion == 1) {
            $success = "yes";
            $success_message = "Le Contact a été supprimé avec succès";
        } else {
            $error = "yes";
            $error_message = "Erreur de la suppression du Contact";
        }
  } catch (PDOException $e) {
        error_log($e->getMessage());
        $error = "yes";
        $error_message = "Erreur lors de la suppression";
    }

}

// Handle search form submission
if (isset($_POST["submit"])) {
    $ndel = clean_in_text($_POST['ndel']);
    $daterange = $_POST['daterange'];
    $conditions = [];
    if ($ndel != "") {
        $data_dossier = get_dossier_data_by_ndel($ndel);
        if (!$data_dossier) {
            $errors['ndel'] = "Aucun dossier trouvé pour le NID fourni.";
        } else {
            $ref_dossier = $data_dossier['idt_dossier'];
            $conditions[] = "t.ref_dossier = '" . addslashes($ref_dossier) . "'";
        }
    }

    if (isset($_POST['daterange']) && $_POST['daterange'] != "") {
        $tempo = explode("-", $_POST['daterange']);
        $daterange = $_POST['daterange'];
        $date_debut = trim($tempo[0]). ' 00:00:00';
        $date_fin = trim($tempo[1]) . ' 23:59:59';
        $conditions[] = "t.created_at BETWEEN '" . addslashes($date_debut) . "' AND '" . addslashes($date_fin) . "'";
    }
    if (!empty($conditions)) {
        $param_query = " WHERE " . implode(" AND ", $conditions);
    } else {
        $param_query = ""; // aucun filtre
    }
}

// Prepare and execute contacts query
try {
    $sql = "SELECT t.*, d.ndel
            FROM t_contacts t
            LEFT JOIN t_dossier d ON t.ref_dossier = d.idt_dossier" . $param_query .
        " ORDER BY created_at";

    $stmt = $bdd->prepare($sql);
    if ($param_query) {
        $stmt->bindParam(':date_debut', $date_debut);
        $stmt->bindParam(':date_fin', $date_fin);
    }
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log($e->getMessage());
    $error = "yes";
    $error_message = "Erreur lors de la récupération des contacts";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>MyPASS - <?= $page_titre ?></title>
</head>

<?php include_once("php/header.php"); ?>
<link rel="stylesheet" href="css/styleCustomer.css">

<body>

<?php include_once("php/main_menu.php"); ?>



<!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <?php include_once("php/titre_location.php"); ?>
  </section>

  <!-- Main content -->
  <section class="content">
    <?php include_once("php/print_message.php"); ?>

    <form class="form-horizontal" action="list_contact.php" method="post">
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
                  <label class="col-sm-2 control-label">NID</label>
                  <div class="col-sm-4">
                      <input type="text" class="form-control" name="ndel" placeholder="Votre NID" value="<?php echo $ndel; ?>">
                      <?php if (!empty($errors['ndel'])): ?>
                          <small class="text-danger"><?= htmlspecialchars($errors['ndel']) ?></small>
                      <?php endif; ?>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 control-label">Période ciblée</label>
                  <div class="col-sm-4">
                      <input type="text" class="form-control pull-right"
                             id="date4" name="daterange"
                             value="<?= htmlspecialchars($daterange) ?>"
                             placeholder="Specifiez une date">
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

        <table aria-describedby="tableJournal" id="example2" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Date</th>
              <th>Nid</th>
              <th>Nom</th>
              <th>Email</th>
              <th>Sujet</th>
              <th>Commentaire</th>
              <th>Actions</th>
            </tr>
          </thead>
            <tbody>
            <?php foreach ($contacts as $index => $contact): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($contact['created_at']) ?></td>
                    <td><?= $contact['ndel'] ? htmlspecialchars($contact['ndel']) : '{{ -- }}' ?></td>
                    <td><?= htmlspecialchars($contact['name']) ?></td>
                    <td><?= htmlspecialchars($contact['email']) ?></td>
                    <td><?= htmlspecialchars($contact['subject']) ?></td>
                    <td><?= htmlspecialchars($contact['message']) ?></td>
                    <td>
                        <?php if (get_access(66, $_SESSION['my_idprofile']) == 1): ?>
                            <a href="list_contact.php?del=<?= $contact['id'] ?>"
                               onclick="return confirm('Cette action va supprimer ce commentaire definitivement, Veuillez confirmer?')"
                               style="padding:12px;">
                                <i class="fa fa-cut" aria-hidden="true"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>


        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->




  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
  <?php include_once("php/footer.php"); ?>
</footer>
<?php include_once("php/tableau_controle.php"); ?>

</div>

<?php include_once("php/importation_js.php"); ?>
</body>

</html>
