<?php
//****************** PAGE SETUP ******************
$idpage = 21;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Contact.php';
require_once __DIR__ . '/../controllers/ContactController.php';

//====================== PAGE INFO ======================//
$get_active_menu = "contact";
$page_titre = "Répondre au message";
$page_small_detail = "Composer une réponse";
$page_location = "Contact > Répondre";

//====================== LOGIC ==========================//
$controller = new ContactController($bdd, $_SESSION['my_userId']);
$message = '';
$alertClass = 'alert-info';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: list.php');
    exit;
}

$contact_id = (int) $_GET['id'];
$contact = $controller->getContactById($contact_id);

if (!$contact) {
    header('Location: list.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_response'])) {
        $emailData = [
            'language' => $_POST['lang_send'] ?? 'fr',
            'title_fr' => $_POST['title_fr'] ?? '',
            'title_en' => $_POST['title_en'] ?? '',
            'subject_fr' => $_POST['subject_fr'] ?? '',
            'subject_en' => $_POST['subject_en'] ?? '',
            'content_fr' => $_POST['content_fr'] ?? '',
            'content_en' => $_POST['content_en'] ?? ''
        ];
        $result = $controller->addResponse($contact_id, $emailData);
        $message = $result['message'];
        $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';
    }

    $contact = $controller->getContactById($contact_id);
}

$selectedLang = $_POST['lang_send'] ?? ($contact['lang'] ?? 'fr');
if (!in_array($selectedLang, ['fr', 'en'], true)) {
    $selectedLang = 'fr';
}
$frRequired = $selectedLang === 'fr' ? 'required' : '';
$enRequired = $selectedLang === 'en' ? 'required' : '';
$frDisabled = $selectedLang === 'fr' ? '' : 'disabled';
$enDisabled = $selectedLang === 'en' ? '' : 'disabled';
$frStyle = $selectedLang === 'fr' ? '' : 'style="display:none"';
$enStyle = $selectedLang === 'en' ? '' : 'style="display:none"';
$defaultSubject = 'Re: ' . ($contact['sujet'] ?? '');
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once __DIR__ . '/../../../layouts/head.php'; ?>
<style>
    .email-editor {
        border: 1px solid #d1d3e2;
        border-radius: 6px;
        background: #fff;
    }
    .editor-toolbar {
        display: flex;
        gap: 6px;
        padding: 8px;
        border-bottom: 1px solid #e3e6f0;
        background: #f8f9fc;
    }
    .editor-toolbar button {
        border: 1px solid #d1d3e2;
        background: #fff;
        padding: 4px 8px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
    }
    .editor-body {
        min-height: 180px;
        padding: 10px;
        outline: none;
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
                        <h1 class="h3 mb-0 text-gray-800">Répondre au message</h1>
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

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Message reçu</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1"><strong>Contact:</strong> <?= htmlspecialchars($contact['nom']) ?></p>
                                    <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($contact['email']) ?></p>
                                    <?php if (!empty($contact['telephone'])): ?>
                                        <p class="mb-1"><strong>Téléphone:</strong> <?= htmlspecialchars($contact['telephone']) ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($contact['categorie'])): ?>
                                        <p class="mb-1"><strong>Catégorie:</strong> <?= htmlspecialchars($contact['categorie']) ?></p>
                                    <?php endif; ?>
                                    <p class="mb-1"><strong>Date:</strong> <?= $controller->formatDate($contact['date_creation']) ?></p>
                                    <p class="mb-3"><strong>Statut:</strong> <?= $controller->getStatusBadge($contact['statut']) ?></p>

                                    <div class="mb-3">
                                        <h6 class="text-uppercase text-muted">Sujet</h6>
                                        <div class="p-3 bg-light rounded"><?= htmlspecialchars($contact['sujet']) ?></div>
                                    </div>

                                    <div>
                                        <h6 class="text-uppercase text-muted">Message</h6>
                                        <div class="p-3 bg-light rounded"><?= nl2br(htmlspecialchars($contact['message'])) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card shadow mb-4" id="reponse">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Informations de l'email</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" id="responseForm">
                                        <input type="hidden" name="add_response" value="1">

                                        <div class="form-group">
                                            <label for="lang_send">Langue d'envoi</label>
                                            <select class="form-control" id="lang_send" name="lang_send">
                                                <option value="fr" <?= $selectedLang === 'fr' ? 'selected' : '' ?>>Français</option>
                                                <option value="en" <?= $selectedLang === 'en' ? 'selected' : '' ?>>English</option>
                                            </select>
                                        </div>

                                        <div class="form-group lang-section lang-fr" <?= $frStyle ?>>
                                            <label for="title_fr">Titre (FR) *</label>
                                            <input type="text" class="form-control" id="title_fr" name="title_fr"
                                                value="<?= htmlspecialchars($_POST['title_fr'] ?? 'Réponse à votre message') ?>" data-required="1" <?= $frRequired ?> <?= $frDisabled ?>>
                                        </div>

                                        <div class="form-group lang-section lang-en" <?= $enStyle ?>>
                                            <label for="title_en">Titre (EN)</label>
                                            <input type="text" class="form-control" id="title_en" name="title_en"
                                                value="<?= htmlspecialchars($_POST['title_en'] ?? 'Reply to your message') ?>" data-required="1" <?= $enRequired ?> <?= $enDisabled ?>>
                                        </div>

                                        <div class="form-group lang-section lang-fr" <?= $frStyle ?>>
                                            <label for="subject_fr">Objet (FR) *</label>
                                            <input type="text" class="form-control" id="subject_fr" name="subject_fr"
                                                value="<?= htmlspecialchars($_POST['subject_fr'] ?? $defaultSubject) ?>" data-required="1" <?= $frRequired ?> <?= $frDisabled ?>>
                                        </div>

                                        <div class="form-group lang-section lang-en" <?= $enStyle ?>>
                                            <label for="subject_en">Objet (EN)</label>
                                            <input type="text" class="form-control" id="subject_en" name="subject_en"
                                                value="<?= htmlspecialchars($_POST['subject_en'] ?? $defaultSubject) ?>" data-required="1" <?= $enRequired ?> <?= $enDisabled ?>>
                                        </div>

                                        <div class="form-group">
                                            <label>Type de destinataires</label>
                                            <input type="text" class="form-control" value="Contact actuel" disabled>
                                        </div>

                                        <div class="form-group lang-section lang-fr" <?= $frStyle ?>>
                                            <label for="content_fr">Contenu (Français) *</label>
                                            <div class="email-editor" data-target="content_fr">
                                                <div class="editor-toolbar">
                                                    <button type="button" data-command="bold"><strong>B</strong></button>
                                                    <button type="button" data-command="italic"><em>I</em></button>
                                                    <button type="button" data-command="underline"><u>U</u></button>
                                                </div>
                                                <div class="editor-body" id="editor_content_fr" contenteditable="true"></div>
                                            </div>
                                            <textarea class="d-none" id="content_fr" name="content_fr" data-required="1" <?= $frRequired ?> <?= $frDisabled ?>><?= htmlspecialchars($_POST['content_fr'] ?? ($contact['reponse'] ?? '')) ?></textarea>
                                        </div>

                                        <div class="form-group lang-section lang-en" <?= $enStyle ?>>
                                            <label for="content_en">Contenu (Anglais)</label>
                                            <div class="email-editor" data-target="content_en">
                                                <div class="editor-toolbar">
                                                    <button type="button" data-command="bold"><strong>B</strong></button>
                                                    <button type="button" data-command="italic"><em>I</em></button>
                                                    <button type="button" data-command="underline"><u>U</u></button>
                                                </div>
                                                <div class="editor-body" id="editor_content_en" contenteditable="true"></div>
                                            </div>
                                            <textarea class="d-none" id="content_en" name="content_en" data-required="1" <?= $enRequired ?> <?= $enDisabled ?>><?= htmlspecialchars($_POST['content_en'] ?? '') ?></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Envoyer la réponse</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="detail.php?id=<?= $contact['id'] ?>" class="btn btn-link">&larr; Voir le détail</a>

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
        document.addEventListener('DOMContentLoaded', function () {
            const responseForm = document.getElementById('responseForm');
            if (!responseForm) {
                return;
            }

            const langSelect = document.getElementById('lang_send');
            const toggleLanguage = function (lang) {
                responseForm.querySelectorAll('.lang-section').forEach(function (section) {
                    const isActive = section.classList.contains('lang-' + lang);
                    section.style.display = isActive ? '' : 'none';

                    section.querySelectorAll('[data-required]').forEach(function (input) {
                        if (isActive) {
                            input.removeAttribute('disabled');
                            input.setAttribute('required', 'required');
                        } else {
                            input.removeAttribute('required');
                            input.setAttribute('disabled', 'disabled');
                        }
                    });
                });
            };

            responseForm.querySelectorAll('.email-editor').forEach(function (editor) {
                const targetId = editor.dataset.target;
                const textarea = document.getElementById(targetId);
                const body = editor.querySelector('.editor-body');

                if (textarea && body) {
                    body.innerHTML = textarea.value;
                }

                editor.querySelectorAll('[data-command]').forEach(function (btn) {
                    btn.addEventListener('click', function (event) {
                        event.preventDefault();
                        const command = btn.getAttribute('data-command');
                        body.focus();
                        document.execCommand(command, false, null);
                    });
                });
            });

            if (langSelect) {
                toggleLanguage(langSelect.value || 'fr');
                langSelect.addEventListener('change', function () {
                    toggleLanguage(langSelect.value || 'fr');
                });
            }

            responseForm.addEventListener('submit', function () {
                responseForm.querySelectorAll('.email-editor').forEach(function (editor) {
                    const targetId = editor.dataset.target;
                    const textarea = document.getElementById(targetId);
                    const body = editor.querySelector('.editor-body');

                    if (textarea && body) {
                        textarea.value = body.innerHTML;
                    }
                });
            });
        });
    </script>
</body>
</html>
