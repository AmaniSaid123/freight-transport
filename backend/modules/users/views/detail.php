<?php
//****************** PAGE SETUP ******************
$idpage = 11;

require_once __DIR__ . '/../../../views/pages/session_check.php';

require_once __DIR__ . '/../../../../php/function.php';
require_once __DIR__ . '/../../../../config/constants.php';
// Charger les classes
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../controllers/UserController.php';

//====================== PAGE INFO ======================//
$get_active_menu = "user";
$page_titre = "Détails Utilisateur";
$page_small_detail = "Fiche détaillée";
$page_location = "Détails utilisateur";

//====================== LOGIC ==========================//

$controller = new UserController($bdd);
$message = '';
$alertClass = 'alert-info';


// Récupérer l'ID de l'utilisateur depuis l'URL
$user_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($user_id === 0) {
    header('Location: list.php');
    exit;
}

$user = $controller->getUserById($user_id);

function getUserProfilePicture($user)
{

    if (empty($user['url_picture'])) {
        return BASE_URL . 'assets/img/undraw_profile.svg';
    }

    // Si le chemin contient déjà "uploads/users/", utiliser BASE_URL + le chemin
    if (strpos($user['url_picture'], 'uploads/users/') !== false) {
        return BASE_URL . $user['url_picture'];
    }

    // Si c'est seulement un nom de fichier, ajouter le chemin
    return BASE_URL . 'uploads/users/' . $user['url_picture'];
}

// Récupérer les détails de l'utilisateur

$profilePicture = getUserProfilePicture($user);

// Formater les dates
$created_at = $user['created_at'] ? date('d/m/Y H:i', strtotime($user['created_at'])) : 'N/A';
$lastlogon = $controller->formatLastLogon($user['lastlogon']);
$status_label = $user['status'] == 1 ? 'Actif' : 'Inactif';
$status_class = $user['status'] == 1 ? 'success' : 'secondary';
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
                        <h1 class="h3 mb-0 text-gray-800">Détails de l'utilisateur</h1>
                        <div>
                            <a href="edit.php?id=<?= $user_id ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="change_password.php?id=<?= $user_id ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-key"></i> Changer mot de passe
                            </a>
                            <a href="list.php" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                        </div>
                    </div>

                    <!-- Message Alert -->
                    <?php if (!empty($message)): ?>
                        <div class="alert <?= $alertClass; ?> text-center" role="alert">
                            <?= htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <!-- User Details Card -->
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Profile Picture Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Photo de profil</h6>
                                </div>
                                <div class="card-body text-center">
                                    <?php if (!empty($user['url_picture'])): ?>
                                        <img src="<?= $profilePicture ?>" class="img-fluid rounded-circle mb-3"
                                            alt="Photo de profil" style="width: 200px; height: 200px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3"
                                            style="width: 200px; height: 200px;">
                                            <i class="fas fa-user text-white" style="font-size: 80px;"></i>
                                        </div>
                                    <?php endif; ?>

                                    <h4 class="text-gray-800">
                                        <?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?>
                                    </h4>
                                    <p class="text-muted">@<?= htmlspecialchars($user['username']) ?></p>

                                    <span class="badge badge-<?= $status_class ?>">
                                        <?= $status_label ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <!-- Informations Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Informations personnelles</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Nom d'utilisateur:</strong>
                                            <p class="text-gray-800"><?= htmlspecialchars($user['username']) ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Email:</strong>
                                            <p class="text-gray-800"><?= htmlspecialchars($user['email']) ?></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Prénom:</strong>
                                            <p class="text-gray-800"><?= htmlspecialchars($user['firstname']) ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Nom:</strong>
                                            <p class="text-gray-800"><?= htmlspecialchars($user['lastname']) ?></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Profil:</strong>
                                            <p class="text-gray-800">
                                                <?= htmlspecialchars($user['profile_name'] ?? 'N/A') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Statut:</strong>
                                            <p>
                                                <span class="badge badge-<?= $status_class ?>">
                                                    <?= $status_label ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Activité</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Date de création:</strong>
                                            <p class="text-gray-800"><?= $created_at ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Dernière connexion:</strong>
                                            <p class="text-gray-800"><?= $lastlogon ?></p>
                                        </div>
                                    </div>
                                </div>
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

</body>

</html>