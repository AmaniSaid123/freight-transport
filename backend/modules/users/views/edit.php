<?php
//****************** PAGE SETUP ******************
$idpage = 5;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../../profiles/controllers/ProfileController.php';
require_once __DIR__ . '/../../profiles/models/Profile.php';
//====================== PAGE INFO ======================//
$get_active_menu = "user";
$page_titre = "Modifier Utilisateur";
$page_small_detail = "Édition";
$page_location = "Modifier utilisateur";

//====================== LOGIC ==========================//

$controller = new UserController($bdd);

$profileModel = new Profile($bdd);
$profileActions = new ProfileController($profileModel, $_SESSION['my_username']);

$message = '';
$alertClass = 'alert-info';
$errors = [];
$formData = [];

// Récupérer l'ID de l'utilisateur depuis l'URL
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

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

// Récupérer la liste des profils
$profiles = $profileActions->getAllProfiles();

// Initialiser les données du formulaire avec les données de l'utilisateur
$formData = $user;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $result = $controller->handleUpdateUser($_POST, $user_id);
    $message = $result['message'];
    $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';
    $errors = $result['errors'] ?? [];

    if ($result['success']) {
        // Redirection après succès
        header('Location: detail.php?id=' . $user_id . '&success=user_updated');
        exit;
    } else {
        $formData = array_merge($formData, $_POST);
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
                        <h1 class="h3 mb-0 text-gray-800">Modifier l'utilisateur</h1>
                        <div>
                            <a href="change_password.php?id=<?= $user_id ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-key"></i> Changer mot de passe
                            </a>
                            <a href="detail.php?id=<?= $user_id ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Retour aux détails
                            </a>
                        </div>
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
                                action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $user_id ?>" 
                                method="post" 
                                id="updateUserForm"
                                novalidate 
                                enctype="multipart/form-data">
                                
                                <!-- Username -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Nom d'utilisateur
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control <?= (!empty($errors['username']) ? 'is-invalid' : '') ?>"
                                            name="username" 
                                            placeholder="Entrez le nom d'utilisateur"
                                            value="<?= htmlspecialchars($formData['username'] ?? '') ?>" 
                                            required
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
                                            name="email" 
                                            placeholder="Entrez l'adresse email"
                                            value="<?= htmlspecialchars($formData['email'] ?? '') ?>" 
                                            required
                                            data-required-message="L'email est obligatoire">
                                        <?php if (!empty($errors['email'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['email']) ?>
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
                                            name="firstname" 
                                            placeholder="Entrez le prénom"
                                            value="<?= htmlspecialchars($formData['firstname'] ?? '') ?>" 
                                            required
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
                                            name="lastname" 
                                            placeholder="Entrez le nom"
                                            value="<?= htmlspecialchars($formData['lastname'] ?? '') ?>" 
                                            required
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
                                        <select class="form-control <?= (!empty($errors['id_profile']) ? 'is-invalid' : '') ?>"
                                                name="id_profile" required
                                                data-required-message="Le profil est obligatoire">
                                            <option value="">Sélectionnez un profil</option>
                                            <?php foreach ($profiles as $profile): ?>
                                                <option value="<?= $profile['idprofile'] ?>" 
                                                    <?= ($formData['id_profile'] ?? '') == $profile['idprofile'] ? 'selected' : '' ?>>
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
                                        <select class="form-control <?= (!empty($errors['status']) ? 'is-invalid' : '') ?>"
                                                name="status" required
                                                data-required-message="Le statut est obligatoire">
                                            <option value="">Sélectionnez un statut</option>
                                            <option value="1" <?= ($formData['status'] ?? '') == '1' ? 'selected' : '' ?>>Actif</option>
                                            <option value="0" <?= ($formData['status'] ?? '') == '0' ? 'selected' : '' ?>>Inactif</option>
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
                                        <!-- Afficher l'image actuelle -->
                                        <?php 
                                        // Construire le chemin correct de l'image
                                        $currentPicture = '';
                                        if (!empty($formData['url_picture'])) {
                                            // Si le chemin contient déjà "uploads/users/", utiliser tel quel
                                            if (strpos($formData['url_picture'], 'uploads/users/') !== false) {
                                                $currentPicture = BASE_URL . $formData['url_picture'];
                                            } else {
                                                // Sinon, construire le chemin complet
                                                $currentPicture = BASE_URL . 'uploads/users/' . $formData['url_picture'];
                                            }
                                            
                                            // Vérifier si l'image existe vraiment
                                            $imagePath = __DIR__ . '/../../../../backend/uploads/users/' . basename($formData['url_picture']);
                                            if (!file_exists($imagePath)) {
                                                $currentPicture = BASE_URL . 'assets/img/undraw_profile.svg';
                                            }
                                        }
                                        ?>
                                        
                                        <?php if (!empty($formData['url_picture']) && $currentPicture !== BASE_URL . 'assets/img/undraw_profile.svg'): ?>
                                            <div class="mb-3">
                                                <img src="<?= $currentPicture ?>" 
                                                    alt="Photo actuelle" 
                                                    class="img-thumbnail"
                                                    style="max-width: 150px; max-height: 150px; object-fit: cover;"
                                                    onerror="this.src='<?= BASE_URL ?>assets/img/undraw_profile.svg'">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="remove_picture" value="1" id="removePicture">
                                                    <label class="form-check-label" for="removePicture">
                                                        Supprimer la photo actuelle
                                                    </label>
                                                </div>
                                            </div>
                                        <?php elseif (empty($formData['url_picture'])): ?>
                                            <div class="mb-3 text-muted">
                                                <i class="fas fa-user fa-3x mb-2"></i>
                                                <p>Aucune photo de profil</p>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <input type="file"
                                            class="form-control-file <?= (!empty($errors['url_picture']) ? 'is-invalid' : '') ?>"
                                            name="url_picture"
                                            accept="image/*">
                                        <?php if (!empty($errors['url_picture'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['url_picture']) ?>
                                            </div>
                                        <?php else: ?>
                                            <small class="form-text text-muted">Formats acceptés: JPG, PNG, GIF. Taille max: 2MB</small>
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
                                            <i class="fas fa-save"></i> Mettre à jour
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

</body>

</html>