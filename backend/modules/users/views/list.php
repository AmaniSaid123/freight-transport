<?php
//****************** CONFIGURATION PAGE ******************
$idpage = 8;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../controllers/UserController.php';

// Configuration de la page
$get_active_menu = "user";
$page_titre = "Liste des Utilisateurs";
$page_small_detail = "du système";
$page_location = "Gestion des Utilisateurs > Liste des Utilisateurs";

//****************** INITIALISATION ******************
$userActions = new UserController($bdd);
$message = null;

//****************** GESTION DES ACTIONS ******************
try {
    // Action : Fermer la session utilisateur
    $closeResult = $userActions->handleCloseSession();
    if ($closeResult) {
        $message = $closeResult;
    }

    // Action : Supprimer un utilisateur
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
        $userId = isset($_POST['delete_user_id']) ? (int) $_POST['delete_user_id'] : 0;

        // Validation supplémentaire
        if ($userId > 0) {
            $message = $userActions->handleDeleteUser($userId);

            // Redirection après suppression réussie pour éviter la resoumission
            if (isset($message['success']) && $message['success'] === 'yes') {
                header('Location: ' . $_SERVER['PHP_SELF'] . '?success=1&message=' . urlencode($message['message']));
                exit;
            }
        } else {
            $message = [
                'error' => 'yes',
                'message' => 'ID d\'utilisateur invalide: ' . $userId
            ];
        }
    }

} catch (Exception $e) {
    $message = [
        'error' => 'yes',
        'message' => 'Une erreur est survenue: ' . $e->getMessage()
    ];
}

//****************** RÉCUPÉRATION DES DONNÉES ******************
try {
    $users = $userActions->getAllUsers();
    $stats = $userActions->getUserStats();
    $usersByProfile = $userActions->getUsersByProfile();

} catch (Exception $e) {
    $users = [];
    $stats = [];
    $usersByProfile = [];

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
                    <h1 class="h3 mb-2 text-gray-800">Utilisateurs</h1>

                    <!-- Message Alert -->
                    <?php if (isset($_GET['message'])): ?>
                        <div class="alert alert-success text-center" role="alert">
                            <?= htmlspecialchars(urldecode($_GET['message'])) ?>
                        </div>
                    <?php elseif (!empty($message)): ?>
                        <div class="alert <?= isset($message['error']) ? 'alert-danger' : 'alert-success'; ?> text-center"
                            role="alert">
                            <?= htmlspecialchars($message['message']) ?>
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
                                                    Utilisateurs Totaux</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['total_users'] ?? 0 ?>
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
                                                    Utilisateurs Actifs</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['active_users'] ?? 0 ?>
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
                                                    Connectés (30j)</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['recent_users'] ?? 0 ?>
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
                            <h6 class="m-0 font-weight-bold text-primary">Liste Utilisateurs</h6>
                            <?php if (get_access($bdd, 9, $_SESSION['my_idprofile']) == 1): ?>
                                <a href="<?= BASE_URL ?>modules/users/views/add.php" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus"></i> Nouveau Utilisateur
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="15%">Login</th>
                                            <th width="15%">Nom</th>
                                            <th width="15%">Prénom</th>
                                            <th width="15%">Profile</th>
                                            <th width="15%">Dernière Connexion</th>
                                            <th width="15%">Crée par</th>
                                            <th width="5%">Statut</th>
                                            <th width="10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($users && count($users) > 0): ?>
                                            <?php foreach ($users as $index => $user):
                                                $status = $userActions->getUserStatus($user);
                                                $statusClass = "status-{$status}";
                                                $statusText = [
                                                    'active' => 'Actif',
                                                    'inactive' => 'Inactif',
                                                    'very-inactive' => 'Très inactif',
                                                    'new' => 'Nouveau'
                                                ][$status];
                                                ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td>
                                                        <strong><?= htmlspecialchars($user['username']) ?></strong>
                                                        <?php if (!empty($user['email'])): ?>
                                                            <br><small
                                                                class="text-muted"><?= htmlspecialchars($user['email']) ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($user['lastname']) ?></td>
                                                    <td><?= htmlspecialchars($user['firstname']) ?></td>
                                                    <td>
                                                        <span
                                                            class="badge bg-info"><?= htmlspecialchars($user['profile']) ?></span>
                                                    </td>
                                                    <td>
                                                        <?= $userActions->formatLastLogon($user['lastlogon']) ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($user['created_by_name'])): ?>
                                                            <?= htmlspecialchars($user['created_by_name']) ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">Système</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="user-status <?= $statusClass ?>"
                                                            title="<?= $statusText ?>"></span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="action-buttons d-flex justify-content-center">
                                                            <!-- Voir détails -->
                                                            <?php if (get_access($bdd, 12, $_SESSION['my_idprofile']) == 1): ?>
                                                                <a href="<?= BASE_URL ?>modules/users/views/detail.php?id=<?= $user['iduser'] ?>"
                                                                    class="btn btn-info btn-xs" title="Voir détails">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <!-- Modifier -->
                                                            <?php if (get_access($bdd, 10, $_SESSION['my_idprofile']) == 1): ?>
                                                                <a href="<?= BASE_URL ?>modules/users/views/edit.php?id=<?= $user['iduser'] ?>"
                                                                    class="btn btn-primary btn-xs" title="Modifier">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <?php if (get_access($bdd, 13, userprofile: $_SESSION['my_idprofile']) == 1): ?>
                                                                <!-- Changer mot de passe -->
                                                                <a href="<?= BASE_URL ?>modules/users/views/change_password.php?id=<?= $user['iduser'] ?>"
                                                                    class="btn btn-warning btn-xs" title="Changer mot de passe">
                                                                    <i class="fa fa-key"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <!-- Supprimer - UN SEUL BOUTON -->
                                                            <?php if (get_access($bdd, 11, $_SESSION['my_idprofile']) == 1): ?>
                                                                <button type="button" class="btn btn-danger btn-xs delete-user-btn"
                                                                    title="Supprimer" data-user-id="<?= $user['iduser'] ?>"
                                                                    data-user-name="<?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?>"
                                                                    data-user-username="<?= htmlspecialchars($user['username']) ?>"
                                                                    data-user-email="<?= htmlspecialchars($user['email'] ?? '') ?>"
                                                                    data-user-avatar="<?= !empty($user['url_picture']) ? BASE_URL . $user['url_picture'] : BASE_URL . 'assets/img/undraw_profile.svg' ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="9" class="text-center py-4">
                                                    <i class="fa fa-users fa-3x text-muted mb-3"></i><br>
                                                    <span class="text-muted">Aucun utilisateur trouvé</span>
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

    <!-- Delete User Modal -->
    <div class="modal fade delete-modal" id="deleteUserModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteUserModalLabel">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Confirmation de suppression
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <strong>Attention :</strong> Cette action est irréversible. Toutes les données associées à cet
                        utilisateur seront perdues.
                    </div>
                    <div class="user-info">
                        <img id="deleteUserAvatar" src="" alt="Avatar" class="user-avatar">
                        <div class="user-details">
                            <h6 id="deleteUserName"></h6>
                            <p id="deleteUserUsername"></p>
                            <p id="deleteUserEmail" class="text-muted"></p>
                        </div>
                    </div>
                    <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                    <form id="deleteUserForm" method="post" style="display: inline;">
                        <input type="hidden" name="delete_user_id" id="deleteUserId">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-2"></i>Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>

    <script src="<?= BASE_URL ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= BASE_URL ?>assets/js/demo/datatables-demo.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Gestion du modal de suppression
            const deleteModal = document.getElementById('deleteUserModal');
            const deleteUserForm = document.getElementById('deleteUserForm');
            const deleteUserIdElement = document.getElementById('deleteUserId');
            const deleteUserAvatar = document.getElementById('deleteUserAvatar');
            const deleteUserName = document.getElementById('deleteUserName');
            const deleteUserUsername = document.getElementById('deleteUserUsername');
            const deleteUserEmail = document.getElementById('deleteUserEmail');

            // Événement pour les boutons de suppression
            document.querySelectorAll('.delete-user-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const userId = this.getAttribute('data-user-id');
                    const userName = this.getAttribute('data-user-name');
                    const userUsername = this.getAttribute('data-user-username');
                    const userEmail = this.getAttribute('data-user-email');
                    const userAvatar = this.getAttribute('data-user-avatar');

                    // Mettre à jour le contenu du modal
                    deleteUserIdElement.value = userId;
                    deleteUserAvatar.src = userAvatar;
                    deleteUserName.textContent = userName;
                    deleteUserUsername.textContent = userUsername;
                    deleteUserEmail.textContent = userEmail;

                    // Ouvrir le modal
                    $(deleteModal).modal('show');
                });
            });

            // Validation du formulaire de suppression
            deleteUserForm.addEventListener('submit', function (e) {
                const userId = deleteUserIdElement.value;
                if (!userId || userId <= 0) {
                    e.preventDefault();
                    alert('Erreur: ID d\'utilisateur invalide');
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