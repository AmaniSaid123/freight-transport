<?php
//****************** PAGE SETUP ******************
$idpage = 9;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../../profiles/controllers/ProfileController.php';
require_once __DIR__ . '/../../profiles/models/Profile.php';

//====================== PAGE INFO ======================//
$get_active_menu = "user";
$page_titre = "Nouvel Utilisateur";
$page_small_detail = "Création";
$page_location = "Ajouter un utilisateur";

//====================== LOGIC ==========================//


$userModel = new User($bdd);
$userActions = new UserController($bdd);

$profileModel = new Profile($bdd);
$profileActions = new ProfileController($profileModel, $_SESSION['my_username']);

$message = '';
$alertClass = 'alert-info';
$formData = [];
$errors = [];

// Récupérer la liste des profils pour le select
$profiles = $profileActions->getAllProfiles();
$user_id = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $result = $userActions->handleAddUser($_POST, $user_id);
    $message = $result['message'];
    $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';
    $errors = $result['errors'] ?? [];

    if (!$result['success']) {
        $formData = $_POST;
    } else {
        // Rediriger ou vider le formulaire en cas de succès
        $formData = [];
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
                        <h1 class="h3 mb-0 text-gray-800">Ajouter un nouvel utilisateur</h1>
                        <a href="<?= BASE_URL ?>modules/users/views/list.php"
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
                            <h6 class="m-0 font-weight-bold text-primary">Informations de l'utilisateur</h6>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal needs-validation"
                                action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="userForm"
                                novalidate enctype="multipart/form-data">

                                <!-- Username -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Nom d'utilisateur
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control <?= (!empty($errors['username']) ? 'is-invalid' : '') ?>"
                                            name="username" placeholder="Entrez le nom d'utilisateur"
                                            value="<?= htmlspecialchars($formData['username'] ?? '') ?>" required
                                            data-validation-rules='{"minLength": 3}'
                                            data-required-message="Le nom d'utilisateur est obligatoire"
                                            data-minlength-message="Le nom d'utilisateur doit contenir au moins 3 caractères">
                                        <?php if (!empty($errors['username'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['username']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="email"
                                            class="form-control <?= (!empty($errors['email']) ? 'is-invalid' : '') ?>"
                                            name="email" placeholder="Entrez l'adresse email"
                                            value="<?= htmlspecialchars($formData['email'] ?? '') ?>" required
                                            data-required-message="L'email est obligatoire">
                                        <?php if (!empty($errors['email'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['email']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Mot de passe
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="password"
                                            class="form-control <?= (!empty($errors['password']) ? 'is-invalid' : '') ?>"
                                            name="password" placeholder="Entrez le mot de passe" required
                                            data-validation-rules='{"minLength": 6}'
                                            data-required-message="Le mot de passe est obligatoire"
                                            data-minlength-message="Le mot de passe doit contenir au moins 6 caractères">
                                        <?php if (!empty($errors['password'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['password']) ?>
                                            </div>
                                        <?php else: ?>
                                            <small class="form-text text-muted">Le mot de passe doit contenir au moins 6
                                                caractères</small>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Confirmer le mot de passe
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="password"
                                            class="form-control <?= (!empty($errors['confirm_password']) ? 'is-invalid' : '') ?>"
                                            name="confirm_password" placeholder="Confirmez le mot de passe" required
                                            data-required-message="La confirmation du mot de passe est obligatoire">
                                        <?php if (!empty($errors['confirm_password'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['confirm_password']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Firstname -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Prénom
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control <?= (!empty($errors['firstname']) ? 'is-invalid' : '') ?>"
                                            name="firstname" placeholder="Entrez le prénom"
                                            value="<?= htmlspecialchars($formData['firstname'] ?? '') ?>" required
                                            data-required-message="Le prénom est obligatoire">
                                        <?php if (!empty($errors['firstname'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['firstname']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Lastname -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Nom
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control <?= (!empty($errors['lastname']) ? 'is-invalid' : '') ?>"
                                            name="lastname" placeholder="Entrez le nom"
                                            value="<?= htmlspecialchars($formData['lastname'] ?? '') ?>" required
                                            data-required-message="Le nom est obligatoire">
                                        <?php if (!empty($errors['lastname'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['lastname']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Profile -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Profil
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <select
                                            class="form-control <?= (!empty($errors['id_profile']) ? 'is-invalid' : '') ?>"
                                            name="id_profile" required
                                            data-required-message="Le profil est obligatoire">
                                            <option value="">Sélectionnez un profil</option>
                                            <?php foreach ($profiles as $profile): ?>
                                                <option value="<?= $profile['idprofile'] ?>"
                                                    <?= isset($formData['id_profile']) && $formData['id_profile'] == $profile['idprofile'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($profile['profile']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if (!empty($errors['id_profile'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['id_profile']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Statut
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <select
                                            class="form-control <?= (!empty($errors['status']) ? 'is-invalid' : '') ?>"
                                            name="status" required data-required-message="Le statut est obligatoire">
                                            <option value="">Sélectionnez un statut</option>
                                            <option value="1" <?= isset($formData['status']) && $formData['status'] == '1' ? 'selected' : '' ?>>Actif</option>
                                            <option value="0" <?= isset($formData['status']) && $formData['status'] == '0' ? 'selected' : '' ?>>Inactif</option>
                                        </select>
                                        <?php if (!empty($errors['status'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['status']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Profile Picture -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Photo de profil
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="file"
                                            class="form-control-file <?= (!empty($errors['url_picture']) ? 'is-invalid' : '') ?>"
                                            name="url_picture" accept="image/*">
                                        <?php if (!empty($errors['url_picture'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['url_picture']) ?>
                                            </div>
                                        <?php else: ?>
                                            <small class="form-text text-muted">Formats acceptés: JPG, PNG, GIF. Taille max:
                                                2MB</small>
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
                                            <i class="fas fa-save"></i> Créer l'utilisateur
                                        </button>
                                        <button type="reset" class="btn btn-secondary">
                                            <i class="fas fa-undo"></i> Réinitialiser
                                        </button>
                                        <a href="<?= BASE_URL ?>modules/users/views/list.php" class="btn btn-light">
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