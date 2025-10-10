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
$page_titre = "Nouveau Profil";
$page_small_detail = "Création";
$page_location = "Ajouter un profil";

//====================== LOGIC ==========================//

$model = new Profile($bdd);
$controller = new ProfileController($model, $_SESSION['my_username']);
$message = '';
$alertClass = 'alert-info';
$formData = []; // Store form data to repopulate on error

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $result = $controller->handleAddProfile($_POST);
    $message = $result['message'];
    $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';

    // Store form data only if there was an error (to repopulate form)
    if (!$result['success']) {
        $formData = $_POST;
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
                        <h1 class="h3 mb-0 text-gray-800">Ajouter un nouveau profil</h1>
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

                    <!-- Form Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informations du profil</h6>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal needs-validation"
                                action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="profileForm"
                                novalidate>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Nom du profil
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control <?= (!empty($errors['name']) ? 'is-invalid' : '') ?>"
                                            name="name" placeholder="Identifiez le profil"
                                            value="<?= htmlspecialchars($formData['name'] ?? '') ?>" required
                                            data-validation-rules='{"minLength": 2}'
                                            data-required-message="Le nom du profil est obligatoire"
                                            data-minlength-message="Le nom doit contenir au moins 2 caractères">

                                        <?php if (!empty($errors['name'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['name']) ?>
                                            </div>
                                        <?php else: ?>
                                            <small class="form-text text-muted">Le nom doit être unique et
                                                descriptif</small>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea
                                            class="form-control <?= (!empty($errors['description']) ? 'is-invalid' : '') ?>"
                                            rows="3" name="description" placeholder="Décrivez-le ici ..." required
                                            data-validation-rules='{"minLength": 10}'
                                            data-required-message="La description est obligatoire"
                                            data-minlength-message="La description doit contenir au moins 10 caractères"><?= htmlspecialchars($formData['description'] ?? '') ?></textarea>
                                        <?php if (!empty($errors['description'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['description']) ?>
                                            </div>
                                        <?php else: ?>
                                            <small class="form-text text-muted">Décrivez le rôle et les permissions de ce
                                                profil</small>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <div class="required-fields-note mb-3">
                                            <small class="text-muted">
                                                <span class="text-danger">*</span> Champs obligatoires
                                            </small>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="submit">
                                            <i class="fas fa-save"></i> Créer le profil
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