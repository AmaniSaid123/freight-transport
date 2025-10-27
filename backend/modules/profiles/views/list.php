<?php
//****************** PAGE SETUP ******************
$idpage = 2;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Profile.php';
require_once __DIR__ . '/../controllers/ProfileController.php';

// Configuration de la page
$get_active_menu = "profile";
$page_titre = "Profiles";
$page_small_detail = "des Utilisateurs";
$page_location = "Gestion des Profiles > Profiles des Utilisateurs";

//****************** INITIALISATION ******************
$profileModel = new Profile($bdd);
$profileActions = new ProfileController($profileModel, $_SESSION['my_username']);
$message = null;

//****************** GESTION DES ACTIONS ******************
try {
    // Action : Fermer le profil
    $closeResult = $profileActions->handleCloseProfile();
    if ($closeResult) {
        $message = $closeResult;
    }

    // Action : Supprimer un profil (via POST pour plus de sécurité)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_profile'])) {
        $profileId = isset($_POST['profile_id']) ? (int) $_POST['profile_id'] : 0;

        // DEBUG: Afficher les données POST pour le débogage
        error_log("Suppression profil - ID reçu: " . $profileId);
        error_log("Données POST: " . print_r($_POST, true));

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
                'message' => 'ID de profile invalide: ' . $profileId
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

    // Gestion des erreurs de redirection
    if (isset($_GET['error']) && isset($_GET['message'])) {
        $message = [
            'error' => 'yes',
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

                    <!-- Message Alert -->
                    <?php if (!empty($message)): ?>
                        <div class="alert <?= isset($message['success']) && $message['success'] === 'yes' ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show"
                            role="alert">
                            <?= htmlspecialchars($message['message']) ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

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
                            <h6 class="m-0 font-weight-bold text-primary">Liste des Profiles</h6>
                            <?php if (get_access($bdd, 3, $_SESSION['my_idprofile']) == 1): ?>
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
                                                $badgeClass = $percent > 50 ? 'bg-success' : ($percent > 25 ? 'bg-primary' : 'bg-info');
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

                                                        <?php if (get_access($bdd, 4, $_SESSION['my_idprofile']) == 1): ?>
                                                            <a href="<?= BASE_URL ?>modules/profiles/views/edit.php?find=<?= $data['idprofile'] ?>"
                                                                class="btn btn-primary btn-sm" title="Modifier le profile">
                                                                <i class="fa fa-pencil-alt"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if (get_access($bdd, 5, $_SESSION['my_idprofile']) == 1): ?>
                                                            <button type="button" class="btn btn-danger btn-sm delete-profile-btn"
                                                                data-profile-id="<?= $data['idprofile'] ?>"
                                                                data-profile-name="<?= htmlspecialchars($data['profile']) ?>"
                                                                data-user-count="<?= $data['total_user'] ?>"
                                                                title="Supprimer le profile">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        <?php endif; ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <i class="fa fa-info-circle fa-2x text-muted mb-2"></i><br>
                                                    <span class="text-muted">Aucun profile trouvé</span>
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

    <!-- Delete Profile Modal -->
    <div class="modal fade" id="deleteProfileModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProfileModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Attention :</strong> Cette action est irréversible.
                    </div>
                    <p>Êtes-vous sûr de vouloir supprimer le profil :</p>
                    <div class="text-center">
                        <h5 id="profileName" class="text-danger mb-3"></h5>
                        <div id="userCountWarning" class="alert alert-danger d-none">
                            <i class="fas fa-users mr-2"></i>
                            <strong>Attention :</strong> Ce profil est utilisé par <span id="userCount">0</span>
                            utilisateur(s).
                            La suppression n'est pas recommandée.
                        </div>
                    </div>
                    <p class="text-muted small">Toutes les données associées à ce profil seront perdues définitivement.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                    <form id="deleteProfileForm" method="post" style="display: inline;">
                        <input type="hidden" name="profile_id" id="deleteProfileId">
                        <input type="hidden" name="delete_profile" value="1">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-2"></i>Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <?php include_once __DIR__ . '/../../../layouts/logout.php'; ?>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>

    <script src="<?= BASE_URL ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= BASE_URL ?>assets/js/demo/datatables-demo.js"></script>

    <script>
        // Script pour la gestion du modal de suppression
        document.addEventListener('DOMContentLoaded', function () {
            // Gestion du modal de suppression
            const deleteModal = document.getElementById('deleteProfileModal');
            const deleteProfileForm = document.getElementById('deleteProfileForm');
            const profileNameElement = document.getElementById('profileName');
            const deleteProfileIdElement = document.getElementById('deleteProfileId');
            const userCountWarning = document.getElementById('userCountWarning');
            const userCountElement = document.getElementById('userCount');

            // Événement pour les boutons de suppression
            document.querySelectorAll('.delete-profile-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const profileId = this.getAttribute('data-profile-id');
                    const profileName = this.getAttribute('data-profile-name');
                    const userCount = parseInt(this.getAttribute('data-user-count'));

                    console.log('Profile ID:', profileId); // Debug

                    // Mettre à jour le contenu du modal
                    profileNameElement.textContent = '"' + profileName + '"';
                    deleteProfileIdElement.value = profileId;

                    // Afficher l'avertissement si le profil est utilisé
                    if (userCount > 0) {
                        userCountElement.textContent = userCount;
                        userCountWarning.classList.remove('d-none');
                    } else {
                        userCountWarning.classList.add('d-none');
                    }

                    // Ouvrir le modal
                    $(deleteModal).modal('show');
                });
            });

            // Validation du formulaire de suppression
            deleteProfileForm.addEventListener('submit', function (e) {
                const profileId = deleteProfileIdElement.value;
                if (!profileId || profileId <= 0) {
                    e.preventDefault();
                    alert('Erreur: ID de profil invalide');
                    return false;
                }
                return true;
            });

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