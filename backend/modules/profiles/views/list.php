<?php
//****************** PAGE SETUP ******************
$idpage = 2;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../config/debug.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Profile.php';
require_once __DIR__ . '/../controllers/ProfileController.php';

// Configuration de la page
$get_active_menu = "profile";
$page_titre = "Profiles";
$page_small_detail = "des Utilisateurs";
$page_location = "Gestion des Profiles > Profiles des Utilisateurs";


$profileModel = new Profile($bdd);

//****************** INITIALISATION ******************
$profileActions = new ProfileController($profileModel, $_SESSION['my_username']);
$message = null;

//****************** GESTION DES ACTIONS ******************
try {
    // Action : Fermer le profil
    $closeResult = $profileActions->handleCloseProfile();
    if ($closeResult) {
        $message = $closeResult;
    }

    // Action : Supprimer un profil
    if (!empty($_GET['del'])) {
        $profileId = (int) $_GET['del'];

        // Validation supplémentaire
        if ($profileId > 0) {
            $message = $profileActions->handleDeleteProfile($profileId);

            // Redirection après suppression réussie pour éviter la resoumission
            if (isset($message['success']) && $message['success'] === 'yes') {
                header('Location: ' . $_SERVER['PHP_SELF'] . '?success=1&message=' . urlencode($message['message']));
                exit;
            }
        } else {
            $message = [
                'error' => 'yes',
                'message' => 'ID de profile invalide'
            ];
        }
    }

    // Gestion des messages de redirection
    if (isset($_GET['success']) && $_GET['success'] == 1 && isset($_GET['message'])) {
        $message = [
            'success' => 'yes',
            'message' => urldecode($_GET['message'])
        ];
    }
} catch (Exception $e) {
    $message = [
        'error' => 'yes',
        'message' => 'Une erreur est survenue: ' . $e->getMessage()
    ];
}

//****************** RÉCUPÉRATION DES DONNÉES ******************
try {
    $profiles = $profileActions->getAllProfiles();

    $total_agent = $profileActions->getTotalUsers();

    // Récupérer les statistiques pour les indicateurs
    $stats = $profileActions->getProfileStats();
} catch (Exception $e) {
    $profiles = [];
    $total_agent = 0;
    $stats = [];

    if (!isset($message)) {
        $message = [
            'error' => 'yes',
            'message' => 'Erreur lors du chargement des données: ' . $e->getMessage()
        ];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<?php include_once __DIR__ . '/../../../layouts/head.php'; ?>

<link href="<?= BASE_URL ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                    <h1 class="h3 mb-2 text-gray-800">Profiles</h1>

                    <!-- Statistics Cards -->
                    <?php if (!empty($stats)): ?>
                        <div class="row mb-4">
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Profils Totaux</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['total_profiles'] ?? 0 ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Utilisateurs Totaux</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_agent ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Profils Actifs</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['profiles_with_users'] ?? 0 ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Profiles List</h6>
                            <?php if (get_access($bdd, 4, $_SESSION['my_idprofile']) == 1): ?>
                                <a href="<?= BASE_URL ?>modules/profiles/views/add.php" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus"></i> Nouveau Profile
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">Profile</th>
                                            <th width="10%"><i class="fa fa-link"></i> Utilisation</th>
                                            <th width="35%">Description</th>
                                            <th width="15%">Crée le</th>
                                            <th width="15%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($profiles && $profiles->rowCount() > 0): ?>
                                            <?php foreach ($profiles as $index => $data):
                                                $percent = $total_agent > 0 ? round(($data['total_user'] / $total_agent * 100)) : 0;
                                                $badgeClass = $percent > 50 ? 'bg-green' : ($percent > 25 ? 'bg-blue' : 'bg-light-blue');
                                                ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td>
                                                        <strong><?= htmlspecialchars($data['profile']) ?></strong>
                                                        <?php if ($data['total_user'] > 0): ?>
                                                            <br><small class="text-muted"><?= $data['total_user'] ?>
                                                                utilisateur(s)</small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge <?= $badgeClass ?>">
                                                            <?= $percent ?>%
                                                        </span>
                                                    </td>
                                                    <td><?= htmlspecialchars($data['description'] ?? 'Non renseignée') ?></td>
                                                    <td>
                                                        <?php if (!empty($data['created_at'])): ?>
                                                            <?= date('d/m/Y', strtotime($data['created_at'])) ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="action-buttons">
                                                        
                                                        <?php if (get_access($bdd, 5, $_SESSION['my_idprofile']) == 1): ?>
                                                            <a href="<?= BASE_URL ?>modules/profiles/views/edit.php?find=<?= $data['idprofile'] ?>"
                                                                class="btn btn-default btn-xs" title="Modifier le profile">
                                                                <i class="fa fa-pencil-alt"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if (get_access($bdd, 5, $_SESSION['my_idprofile']) == 1): ?>
                                                            <a href="<?= BASE_URL ?>modules/profiles/views/list.php?del=<?= $data['idprofile'] ?>"
                                                                class="btn btn-default btn-xs"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer le profile \'<?= addslashes($data['profile']) ?>\' ? Cette action est irréversible.')"
                                                                title="Supprimer le profile">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="no-data">
                                                    <i class="fa fa-info-circle"></i> Aucun profile trouvé
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

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

    <!-- Logout Modal-->


    <?php include_once __DIR__ . '/../../../layouts/logout.php'; ?>
    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>

    <script src="<?= BASE_URL ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= BASE_URL ?>assets/js/demo/datatables-demo.js"></script>

    <script>
        // Script pour améliorer l'UX
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-dissimulation des messages après 5 secondes
            setTimeout(function () {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function (alert) {
                    const fade = new bootstrap.Alert(alert);
                    fade.close();
                });
            }, 5000);

            // Confirmation améliorée pour la suppression
            const deleteButtons = document.querySelectorAll('a[onclick*="confirm"]');
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function (e) {
                    if (!confirm(this.getAttribute('data-confirm-message') || this.getAttribute(
                        'onclick').match(/'([^']+)'/)[1])) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>

</html>