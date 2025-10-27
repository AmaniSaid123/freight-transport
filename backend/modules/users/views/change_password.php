<?php
//****************** PAGE SETUP ******************
$idpage = 10;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../controllers/UserController.php';

//====================== PAGE INFO ======================//
$get_active_menu = "user";
$page_titre = "Changer le mot de passe";
$page_small_detail = "Sécurité";
$page_location = "Changer mot de passe";

//====================== LOGIC ==========================//

$controller = new UserController($bdd);
$message = '';
$alertClass = 'alert-info';
$errors = [];

// Récupérer l'ID de l'utilisateur depuis l'URL
$user_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($user_id === 0) {
    header('Location: list.php');
    exit;
}

// Récupérer les informations de l'utilisateur
$user = $controller->getUserById($user_id);

if (!$user) {
    header('Location: list.php?error=user_not_found');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $result = $controller->handleChangePassword($_POST, $user_id);
    $message = $result['message'];
    $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';
    $errors = $result['errors'] ?? [];

    if ($result['success']) {
        // Redirection après succès
        header('Location: detail.php?id=' . $user_id . '&success=password_changed');
        exit;
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
                        <h1 class="h3 mb-0 text-gray-800">Changer le mot de passe</h1>
                        <a href="detail.php?id=<?= $user_id ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour aux détails
                        </a>
                    </div>

                    <!-- Message Alert -->
                    <?php if (!empty($message)): ?>
                        <div class="alert <?= $alertClass; ?> text-center" role="alert">
                            <?= htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Modification du mot de passe pour
                                <?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?>
                            </h6>
                        </div>
                        <div class="card-body">
                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $user_id ?>"
                                method="post" id="changePasswordForm">

                                <!-- Nouveau mot de passe -->
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        Nouveau mot de passe
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password"
                                            class="form-control <?= (!empty($errors['new_password']) ? 'is-invalid' : '') ?>"
                                            name="new_password" placeholder="Entrez le nouveau mot de passe" required
                                            data-validation-rules='{"minLength": 6}'
                                            data-required-message="Le nouveau mot de passe est obligatoire"
                                            data-minlength-message="Le mot de passe doit contenir au moins 6 caractères">
                                        <?php if (!empty($errors['new_password'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['new_password']) ?>
                                            </div>
                                        <?php else: ?>
                                            <small class="form-text text-muted">Le mot de passe doit contenir au moins 6
                                                caractères</small>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Confirmation du mot de passe -->
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">
                                        Confirmer le mot de passe
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password"
                                            class="form-control <?= (!empty($errors['confirm_password']) ? 'is-invalid' : '') ?>"
                                            name="confirm_password" placeholder="Confirmez le nouveau mot de passe"
                                            required
                                            data-required-message="La confirmation du mot de passe est obligatoire">
                                        <?php if (!empty($errors['confirm_password'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['confirm_password']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <div class="required-fields-note mb-3">
                                            <small class="text-muted">
                                                <span class="text-danger">*</span> Champs obligatoires
                                            </small>
                                        </div>
                                        <button type="submit" class="btn btn-warning" name="submit">
                                            <i class="fas fa-key"></i> Changer le mot de passe
                                        </button>
                                        <button type="reset" class="btn btn-secondary">
                                            <i class="fas fa-undo"></i> Réinitialiser
                                        </button>
                                        <a href="detail.php?id=<?= $user_id ?>" class="btn btn-light">
                                            <i class="fas fa-times"></i> Annuler
                                        </a>
                                    </div>
                                </div>
                            </form>
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

    <script>
        // Validation côté client pour la confirmation du mot de passe
        document.getElementById('changePasswordForm').addEventListener('submit', function (e) {
            const newPassword = document.querySelector('input[name="new_password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas');
            }
        });
    </script>

</body>

</html>