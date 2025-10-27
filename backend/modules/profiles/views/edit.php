<?php
//****************** PAGE SETUP ******************
$idpage = 4;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Profile.php';
require_once __DIR__ . '/../controllers/ProfileController.php';

//====================== PAGE INFO ======================//
$get_active_menu = "profile";
$page_titre = "Modifier le Profil";
$page_small_detail = "Édition";
$page_location = "Modifier un profil";
//====================== LOGIC ==========================//

$model = new Profile($bdd);
$controller = new ProfileController($model, $_SESSION['my_username']);
$message = '';
$alertClass = 'alert-info';
$formData = [];

// Get profile ID from URL

$profileId = isset($_GET['find']) ? intval($_GET['find']) : 0;
if (!$profileId) {
    header("Location: list.php?error=Profil introuvable");
    exit;
}

$data_profile = $model->getProfileById($profileId);
if (!$data_profile) {
    header("Location: list.php?error=Profil introuvable");
    exit;
}

// Load profile rights
$profileRights = $model->getProfileContents($profileId);


if (isset($_GET['del'])) {
    $rightId = (int) $_GET['del'];
    $menuName = $_GET['menu'] ?? '';

    if ($rightId > 0) {
        $result = $controller->handleDeleteRight($rightId);

        if ($result['success']) {
            header("Location: edit.php?find=" . $profileId . "&success=1&message=" . urlencode($result['message']));
            exit;
        } else {
            $message = $result['message'];
            $alertClass = 'alert-danger';
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_profile'])) {
        $result = $controller->editProfile($profileId, $_POST);
        $message = $result['message'];
        $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';

        if ($result['success']) {
            // Reload profile data after successful update
            $data_profile = $model->getProfileById($profileId);
        } else {
            $formData = $_POST;
        }
    } elseif (isset($_POST['submit_rights'])) {
        $result = $controller->handleAccessRights($profileId, $_POST);
        $message = $result['message'];
        $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';

        // Reload rights after update
        $profileRights = $model->getProfileContents($profileId);
    }
}

// Gestion des messages de succès depuis la redirection
if (isset($_GET['success']) && $_GET['success'] == 1 && isset($_GET['message'])) {
    $message = urldecode($_GET['message']);
    $alertClass = 'alert-success';
}

// Count non-granted rights for the hidden input
$index = 0;
foreach ($profileRights as $right) {
    if ($right['accorder'] === 'Non') {
        $index++;
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<?php include_once __DIR__ . '/../../../layouts/head.php'; ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include_once __DIR__ . '/../../../layouts/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include_once __DIR__ . '/../../../layouts/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Modifier le profil</h1>
                        <a href="<?= BASE_URL ?>modules/profiles/views/list.php"
                            class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
                        </a>
                    </div>

                    <!-- Message Alert -->
                    <?php if (!empty($message)): ?>
                        <div class="alert <?= $alertClass; ?> text-center" role="alert">
                            <?= htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Profile Information Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Informations du profil</h6>
                            <span class="badge badge-info">ID: <?= $profileId ?></span>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal needs-validation" action="" method="post" id="profileForm"
                                novalidate>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Nom du profil
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name"
                                            value="<?= htmlspecialchars($data_profile['name']) ?>" required
                                            data-validation-rules='{"minLength": 2}'
                                            data-required-message="Le nom du profil est obligatoire"
                                            data-minlength-message="Le nom doit contenir au moins 2 caractères">
                                        <small class="form-text text-muted">Le nom doit être unique et
                                            descriptif</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" rows="3" name="description" required
                                            data-validation-rules='{"minLength": 10}'
                                            data-required-message="La description est obligatoire"
                                            data-minlength-message="La description doit contenir au moins 10 caractères"><?= htmlspecialchars($data_profile['description']) ?></textarea>
                                        <small class="form-text text-muted">Décrivez le rôle et les permissions de ce
                                            profil</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <div class="required-fields-note mb-3">
                                            <small class="text-muted">
                                                <span class="text-danger">*</span> Champs obligatoires
                                            </small>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="submit_profile">
                                            <i class="fas fa-save"></i> Mettre à jour le profil
                                        </button>
                                        <button type="reset" class="btn btn-secondary">
                                            <i class="fas fa-undo"></i> Réinitialiser
                                        </button>
                                        <a href="<?= BASE_URL ?>modules/profiles/views/list.php" class="btn btn-light">
                                            <i class="fas fa-times"></i> Annuler
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Access Rights Card -->
                    <?php if (get_access($bdd, 6, $_SESSION['my_idprofile']) == 1): ?>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Gestion des droits d'accès</h6>
                            </div>
                            <div class="card-body">
                                <form method="post" id="rightsForm">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="accessRightsTable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Menu</th>
                                                    <th>Fonctionnalité</th>
                                                    <th>Statut</th>
                                                    <th>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="selectAll"
                                                                onclick="toggleAll(this);">
                                                            <label class="form-check-label small" for="selectAll">
                                                                Tout sélectionner
                                                            </label>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $counter = 0;
                                                foreach ($profileRights as $right):
                                                    $isGranted = $right['accorder'] === 'Oui';
                                                    $counter++;
                                                    ?>
                                                    <tr>
                                                        <td class="align-middle">
                                                            <strong><?= htmlspecialchars($right['ref_menu']) ?></strong>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?= htmlspecialchars($right['sous_menu']) ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <span
                                                                class="badge badge-<?= $isGranted ? 'success' : 'secondary' ?>">
                                                                <?= htmlspecialchars($right['accorder']) ?>
                                                            </span>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <?php if (!$isGranted): ?>
                                                                <input type="hidden" name="value<?= $counter ?>"
                                                                    value="<?= $right['id_content'] ?>">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="chk<?= $counter ?>" value="on">
                                                                </div>
                                                            <?php else: ?>
                                                                <?php if (get_access($bdd, 7, $_SESSION['my_idprofile']) == 1): ?>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-danger delete-right-btn"
                                                                        data-right-id="<?= $right['idpc'] ?>"
                                                                        data-menu-name="<?= htmlspecialchars($right['sous_menu']) ?>"
                                                                        data-profile-id="<?= $profileId ?>" title="Retirer l'accès">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="small text-muted">
                                                        Total des droits: <?= count($profileRights) ?> |
                                                        Accordés:
                                                        <?= array_sum(array_map(fn($r) => $r['accorder'] === 'Oui' ? 1 : 0, $profileRights)) ?>
                                                        |
                                                        En attente:
                                                        <?= array_sum(array_map(fn($r) => $r['accorder'] === 'Non' ? 1 : 0, $profileRights)) ?>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <input type="hidden" name="total" value="<?= $counter ?>">
                                    <div class="form-group mt-4">
                                        <button type="submit" name="submit_rights" class="btn btn-success">
                                            <i class="fas fa-check-circle"></i> Mettre à jour les droits
                                        </button>
                                        <small class="form-text text-muted">
                                            Seules les cases cochées (droits non accordés) seront ajoutées
                                        </small>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once __DIR__ . '/../../../layouts/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Delete Right Modal -->
    <div class="modal fade" id="deleteRightModal" tabindex="-1" role="dialog" aria-labelledby="deleteRightModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRightModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Attention :</strong> Cette action est irréversible.
                    </div>
                    <p>Êtes-vous sûr de vouloir retirer l'accès à :</p>
                    <div class="text-center">
                        <h5 id="rightMenuName" class="text-danger mb-3"></h5>
                    </div>
                    <p class="text-muted small">L'utilisateur perdra l'accès à cette fonctionnalité.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                    <a href="#" id="confirmDeleteRight" class="btn btn-danger">
                        <i class="fas fa-trash mr-2"></i>Retirer l'accès
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Logout Modal-->
    <?php include_once __DIR__ . '/../../../layouts/logout.php'; ?>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>


    <script>
        function toggle(source) {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(cb => {
                if (cb !== source) cb.checked = source.checked;
            });
        }
    </script>
    <script>
        // Gestion de la suppression des droits d'accès
        document.addEventListener('DOMContentLoaded', function () {
            const deleteRightModal = document.getElementById('deleteRightModal');
            const rightMenuNameElement = document.getElementById('rightMenuName');
            const confirmDeleteRightLink = document.getElementById('confirmDeleteRight');

            // Événement pour les boutons de suppression des droits
            document.querySelectorAll('.delete-right-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const rightId = this.getAttribute('data-right-id');
                    const menuName = this.getAttribute('data-menu-name');
                    const profileId = this.getAttribute('data-profile-id');

                    // Mettre à jour le contenu du modal
                    rightMenuNameElement.textContent = '"' + menuName + '"';

                    // Mettre à jour le lien de confirmation
                    const deleteUrl = `edit.php?find=${profileId}&del=${rightId}&menu=${encodeURIComponent(menuName)}`;
                    confirmDeleteRightLink.href = deleteUrl;

                    // Ouvrir le modal
                    $(deleteRightModal).modal('show');
                });
            });

            // Fonction pour tout sélectionner
            function toggleAll(source) {
                const checkboxes = document.querySelectorAll('input[name^="chk"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = source.checked;
                });
            }

            // Auto-dissimulation des messages après 5 secondes
            setTimeout(function () {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function (alert) {
                    if (alert.classList.contains('alert-dismissible')) {
                        const closeButton = alert.querySelector('.close');
                        if (closeButton) {
                            closeButton.click();
                        }
                    }
                });
            }, 5000);
        });
    </script>
</body>

</html>