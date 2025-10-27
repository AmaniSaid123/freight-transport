<?php
//****************** PAGE SETUP ******************
$idpage = 12;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Mailing.php';
require_once __DIR__ . '/../controllers/MailingController.php';

//====================== PAGE INFO ======================//
$get_active_menu = "mailing";
$page_titre = "Nouvel Email";
$page_small_detail = "Création";
$page_location = "Mailing > Nouvel email";

//====================== LOGIC ==========================//

$controller = new MailingController($bdd, $_SESSION['my_userId']);
$message = '';
$alertClass = 'alert-info';
$formData = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $result = $controller->handleAddMail($_POST);
    $message = $result['message'];
    $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';
    $errors = $result['errors'] ?? [];

    if (!$result['success']) {
        $formData = $_POST;
    } else {
        header('Location: list.php?success=1&message=' . urlencode($result['message']));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once __DIR__ . '/../../../layouts/head.php'; ?>
<style>
    .editor-toolbar {
        background: #f8f9fa;
        padding: 10px;
        border: 1px solid #e3e6f0;
        border-bottom: none;
    }
    .email-editor {
        min-height: 300px;
        border: 1px solid #e3e6f0;
        padding: 15px;
    }
    .recipient-tag {
        display: inline-block;
        background: #e9ecef;
        padding: 2px 8px;
        margin: 2px;
        border-radius: 15px;
        font-size: 0.85em;
    }
</style>

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
                        <h1 class="h3 mb-0 text-gray-800">Créer un nouvel email</h1>
                        <a href="list.php" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
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
                            <h6 class="m-0 font-weight-bold text-primary">Informations de l'email</h6>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal needs-validation"
                                action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
                                method="post" 
                                id="mailForm"
                                novalidate>
                                
                                <!-- Titre Email -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Titre de l'email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control <?= (!empty($errors['titre_email']) ? 'is-invalid' : '') ?>"
                                            name="titre_email" 
                                            placeholder="Donnez un titre à cet email"
                                            value="<?= htmlspecialchars($formData['titre_email'] ?? '') ?>" 
                                            required
                                            data-required-message="Le titre de l'email est obligatoire">
                                        <?php if (!empty($errors['titre_email'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['titre_email']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Objet -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Objet
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control <?= (!empty($errors['objet']) ? 'is-invalid' : '') ?>"
                                            name="objet" 
                                            placeholder="Objet de l'email"
                                            value="<?= htmlspecialchars($formData['objet'] ?? '') ?>" 
                                            required
                                            data-required-message="L'objet de l'email est obligatoire">
                                        <?php if (!empty($errors['objet'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['objet']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Type Destinataires -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Type de destinataires
                                    </label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="type_destinataires" id="typeDestinataires">
                                            <option value="tous" <?= ($formData['type_destinataires'] ?? '') == 'tous' ? 'selected' : '' ?>>Tous les utilisateurs</option>
                                            <option value="specifiques" <?= ($formData['type_destinataires'] ?? '') == 'specifiques' ? 'selected' : '' ?>>Destinataires spécifiques</option>
                                            <option value="groupe" <?= ($formData['type_destinataires'] ?? '') == 'groupe' ? 'selected' : '' ?>>Groupe spécifique</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Destinataires spécifiques -->
                                <div class="form-group row" id="destinatairesGroup" style="display: none;">
                                    <label class="col-sm-2 col-form-label">
                                        Destinataires
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" 
                                                  name="destinataires" 
                                                  placeholder="Entrez les adresses email séparées par des virgules"
                                                  rows="3"><?= htmlspecialchars($formData['destinataires'] ?? '') ?></textarea>
                                        <small class="form-text text-muted">Séparez les adresses par des virgules</small>
                                    </div>
                                </div>

                                <!-- Contenu FR -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Contenu (Français)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <div class="editor-toolbar">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('bold')"><i class="fas fa-bold"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('italic')"><i class="fas fa-italic"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('underline')"><i class="fas fa-underline"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertLink()"><i class="fas fa-link"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertImage()"><i class="fas fa-image"></i></button>
                                        </div>
                                        <textarea class="form-control <?= (!empty($errors['contenu_fr']) ? 'is-invalid' : '') ?>"
                                                  name="contenu_fr" 
                                                  id="contenu_fr"
                                                  rows="15"
                                                  placeholder="Rédigez le contenu de votre email en français..."
                                                  required
                                                  data-required-message="Le contenu en français est obligatoire"><?= htmlspecialchars($formData['contenu_fr'] ?? '') ?></textarea>
                                        <?php if (!empty($errors['contenu_fr'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <?= htmlspecialchars($errors['contenu_fr']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Contenu EN -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Contenu (Anglais)
                                    </label>
                                    <div class="col-sm-10">
                                        <div class="editor-toolbar">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatTextEn('bold')"><i class="fas fa-bold"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatTextEn('italic')"><i class="fas fa-italic"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatTextEn('underline')"><i class="fas fa-underline"></i></button>
                                        </div>
                                        <textarea class="form-control"
                                                  name="contenu_en" 
                                                  id="contenu_en"
                                                  rows="10"
                                                  placeholder="Rédigez le contenu de votre email en anglais (optionnel)..."><?= htmlspecialchars($formData['contenu_en'] ?? '') ?></textarea>
                                    </div>
                                </div>

                                <!-- Statut -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Statut
                                    </label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="statut">
                                            <option value="brouillon" <?= ($formData['statut'] ?? '') == 'brouillon' ? 'selected' : '' ?>>Brouillon</option>
                                            <option value="programme" <?= ($formData['statut'] ?? '') == 'programme' ? 'selected' : '' ?>>Programmé</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Date de programmation -->
                                <div class="form-group row" id="dateProgrammationGroup">
                                    <label class="col-sm-2 col-form-label">
                                        Date de programmation
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="datetime-local" 
                                               class="form-control" 
                                               name="date_programmation"
                                               value="<?= htmlspecialchars($formData['date_programmation'] ?? '') ?>">
                                        <small class="form-text text-muted">Laissez vide pour envoyer immédiatement</small>
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
                                            <i class="fas fa-save"></i> Enregistrer l'email
                                        </button>
                                        <button type="reset" class="btn btn-secondary">
                                            <i class="fas fa-undo"></i> Réinitialiser
                                        </button>
                                        <a href="list.php" class="btn btn-light">
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
        // Gestion de l'affichage conditionnel des champs
        document.addEventListener('DOMContentLoaded', function() {
            const typeDestinataires = document.getElementById('typeDestinataires');
            const destinatairesGroup = document.getElementById('destinatairesGroup');
            const statutSelect = document.querySelector('select[name="statut"]');
            const dateProgrammationGroup = document.getElementById('dateProgrammationGroup');

            function toggleFields() {
                // Destinataires spécifiques
                if (typeDestinataires.value === 'specifiques') {
                    destinatairesGroup.style.display = 'flex';
                } else {
                    destinatairesGroup.style.display = 'none';
                }

                // Date de programmation
                if (statutSelect.value === 'programme') {
                    dateProgrammationGroup.style.display = 'flex';
                } else {
                    dateProgrammationGroup.style.display = 'none';
                }
            }

            typeDestinataires.addEventListener('change', toggleFields);
            statutSelect.addEventListener('change', toggleFields);
            
            // Initialisation
            toggleFields();
        });

        // Fonctions d'édition basique
        function formatText(command) {
            document.getElementById('contenu_fr').focus();
            document.execCommand(command, false, null);
        }

        function formatTextEn(command) {
            document.getElementById('contenu_en').focus();
            document.execCommand(command, false, null);
        }

        function insertLink() {
            const url = prompt('Entrez l\'URL:');
            if (url) {
                document.getElementById('contenu_fr').focus();
                document.execCommand('createLink', false, url);
            }
        }

        function insertImage() {
            const url = prompt('Entrez l\'URL de l\'image:');
            if (url) {
                document.getElementById('contenu_fr').focus();
                document.execCommand('insertImage', false, url);
            }
        }

        // Validation du formulaire
        document.getElementById('mailForm').addEventListener('submit', function(e) {
            const contenuFr = document.getElementById('contenu_fr').value.trim();
            if (!contenuFr) {
                e.preventDefault();
                alert('Le contenu en français est obligatoire');
                document.getElementById('contenu_fr').focus();
                return false;
            }
            return true;
        });
    </script>

</body>
</html>