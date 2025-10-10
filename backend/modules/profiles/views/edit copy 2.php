<?php
//****************** PAGE SETUP ******************
$idpage = 5;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../config/debug.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Profile.php';
require_once __DIR__ . '/../controllers/ProfileController.php';

//====================== PAGE INFO ======================//
$get_active_menu = "profile";
$page_titre = "Ajouter Profil";
$page_small_detail = "Ajout";
$page_location = "Ajouter un profil";
$set_pluggin_datatable = "yes";
//====================== LOGIC ==========================//

$model = new Profile($bdd);
$controller = new ProfileController($model, $_SESSION['my_username']);

$profileId = $_GET['find'] ?? $_SESSION['my_m_profile'] ?? null;
if (!$profileId) {
    header("Location: list.php?error=Profil introuvable");
    exit;
}

$data_profile = $model->getProfileById($profileId);
if (!$data_profile) {
    header("Location: list.php?error=Profil introuvable");
    exit;
}

$message = '';
$alertClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_profile'])) {
        $result = $controller->editProfile($profileId, $_POST);
    } elseif (isset($_POST['submit_rights'])) {
        $result = $controller->handleAccessRights($profileId, $_POST);
    }
    $message = $result['message'];
    $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';
}

$profileRights = $model->getProfileContents($profileId);


?>


<body class="hold-transition skin-purple sidebar-collapse sidebar-mini <?= isset($is_fixed) ? 'fixed' : '' ?>"
    onbeforeprint="ShowLoading()" onbeforeunload="ShowLoading()">


    <?php include_once __DIR__ . '/../../../layouts/header.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <?php include_once __DIR__ . '/../../../layouts/titre_location.php'; ?>
        </section>

        <section class="content">
            <?php include_once __DIR__ . '/../../../views/pages/print_message.php'; ?>


            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Mode édition</h3>

                </div>

                <?php if (!empty($message)): ?>
                <div class="alert <?= $alertClass; ?> text-center" role="alert">
                    <?= htmlspecialchars($message); ?>
                </div>
                <?php endif; ?>

                <form class="form-horizontal" action="" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nom du profil</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control"
                                    value="<?= htmlspecialchars($data_profile['name']) ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <textarea name="description" class="form-control" rows="3"
                                    required><?= htmlspecialchars($data_profile['description']) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-default">Annuler</button>
                        <button type="submit" class="btn btn-info pull-right" name="submit_profile">Valider</button>
                    </div>
                </form>


                <form method="post">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Les Droit d'Accès</h3>
                                </div>
                                <div class="box-body">
                                    <table id="example2" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>Menu</th>
                                                <th>Fonctionnalité</th>
                                                <th>Accordée?</th>

                                                <th><input type="checkbox" onclick="toggle(this);" /></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $index = 0;
                                            foreach ($profileRights as $right):
                                                if ($right['accorder'] === 'Non') {
                                                    $index++;
                                                }
                                                ?>
                                            <tr>
                                                <td><?= htmlspecialchars($right['ref_menu']) ?></td>
                                                <td><?= htmlspecialchars($right['sous_menu']) ?></td>
                                                <td><?= htmlspecialchars($right['accorder']) ?></td>
                                                <td>
                                                    <?php if ($right['accorder'] === 'Non'): ?>
                                                    <input type="hidden" name="value<?= $index ?>"
                                                        value="<?= $right['id_content'] ?>">
                                                    <input type="checkbox" name="chk<?= $index ?>" value="on">
                                                    <?php else: ?>
                                                    <a
                                                        href="?find=<?= $profileId ?>&del=<?= $right['idpc'] ?>&menu=<?= urlencode($right['sous_menu']) ?>">
                                                        <i class="fa fa-cut"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Menu</th>
                                                <th>Fonctionnalité</th>
                                                <th>Accordée?</th>
                                                <th>Cochez pour accorder</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <input type="hidden" name="total" value="<?= $index ?>">
                                    <div class="box-footer">
                                        <button type="submit" name="submit_rights"
                                            class="btn btn-success pull-right">Mettre à jour les droits</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>




            </div>
        </section>
    </div>

    <footer class="main-footer">
        <?php include_once __DIR__ . '/../../../layouts/footer.php'; ?>
    </footer>

    <?php
    include_once __DIR__ . '/../../../layouts/tableau_controle.php';
    include_once __DIR__ . '/../../../assets/js/script.php';
    ?>

    <script>
    function toggle(source) {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(cb => {
            if (cb !== source) cb.checked = source.checked;
        });
    }
    </script>

</body>

</html>