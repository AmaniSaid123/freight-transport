<?php
//****************** PAGE SETUP ******************
$idpage = 18;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Mailing.php';
require_once __DIR__ . '/../controllers/MailingController.php';

//====================== PAGE INFO ======================//
$get_active_menu = "mailing";
$page_titre = "Détails de l'Email";
$page_small_detail = "Consultation";
$page_location = "Mailing > Détails email";

//====================== LOGIC ==========================//

$controller = new MailingController($bdd, $_SESSION['my_userId']);
$message = '';
$alertClass = 'alert-info';

// Récupérer l'ID de l'email depuis l'URL
$mail_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($mail_id === 0) {
    header('Location: list.php');
    exit;
}

// Récupérer les détails de l'email
$mail = $controller->getMailById($mail_id);

if (!$mail) {
    header('Location: list.php?error=mail_not_found');
    exit;
}

// Formater les dates
$created_at = $controller->formatDate($mail['created_at']);
$date_programmation = $controller->formatDate($mail['date_programmation']);
$date_envoi = $controller->formatDate($mail['date_envoi']);
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once __DIR__ . '/../../../layouts/head.php'; ?>
<style>
    .email-content {
        background: #f8f9fa;
        border: 1px solid #e3e6f0;
        border-radius: 5px;
        padding: 20px;
        margin-top: 10px;
    }
    .info-card {
        border-left: 4px solid #4e73df;
    }
    .recipients-list {
        max-height: 150px;
        overflow-y: auto;
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
                            <h1 class="h3 mb-0 text-gray-800">Détails de l'email</h1>
                            <div>
                                <a href="edit.php?id=<?= $mail_id ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Modifier
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

                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Email Content Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Contenu de l'email</h6>
                                    <span><?= $controller->getStatusBadge($mail['status_code'] ?? '') ?></span>
                                </div>
                                <div class="card-body">
                                    <h4 class="text-gray-800"><?= htmlspecialchars($mail['titre_email_fr'] ?? $mail['titre_email'] ?? '') ?></h4>
                                    <p class="text-muted">Objet: <strong><?= htmlspecialchars($mail['objet_fr'] ?? $mail['objet'] ?? '') ?></strong></p>
                                    
                                    <div class="email-content">
                                        <h5>Version Française:</h5>
                                        <div class="content-fr">
                                            <?= nl2br(htmlspecialchars($mail['contenu_fr'])) ?>
                                        </div>
                                        
                                        <?php if (!empty($mail['contenu_en'])): ?>
                                            <hr>
                                            <h5>Version Anglaise:</h5>
                                            <div class="content-en">
                                                <?= nl2br(htmlspecialchars($mail['contenu_en'])) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <!-- Informations Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Informations</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Type de destinataires:</strong><br>
                                        <?php
                                        $types = [
                                            'tous' => 'Tous les utilisateurs',
                                            'specifiques' => 'Destinataires spécifiques',
                                            'groupe' => 'Groupe spécifique'
                                        ];
                                        echo $types[$mail['type_destinataires']] ?? $mail['type_destinataires'];
                                        ?>
                                    </div>

                                    <?php if (!empty($mail['destinataires'])): ?>
                                        <div class="mb-3">
                                            <strong>Destinataires:</strong>
                                            <div class="recipients-list mt-2 p-2 bg-light rounded">
                                                <?php
                                                $emails = explode(',', $mail['destinataires']);
                                                foreach ($emails as $email):
                                                    $email = trim($email);
                                                    if (!empty($email)):
                                                ?>
                                                        <span class="badge badge-primary mb-1"><?= htmlspecialchars($email) ?></span><br>
                                                <?php
                                                    endif;
                                                endforeach;
                                                ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="mb-3">
                                        <strong>Créé par:</strong><br>
                                        <?= htmlspecialchars($mail['created_by_name'] ?? 'Système') ?>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Date de création:</strong><br>
                                        <?= $created_at ?>
                                    </div>

                                    <?php if (!empty($date_programmation) && $date_programmation !== 'Non définie'): ?>
                                        <div class="mb-3">
                                            <strong>Date de programmation:</strong><br>
                                            <?= $date_programmation ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($date_envoi) && $date_envoi !== 'Non définie'): ?>
                                        <div class="mb-3">
                                            <strong>Date d'envoi:</strong><br>
                                            <?= $date_envoi ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Actions Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="edit.php?id=<?= $mail_id ?>" 
                                           class="btn btn-primary btn-block">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        
                                        <?php $mailStatus = $mail['status_code'] ?? ''; ?>
                                        <?php if ($mailStatus === 'brouillon' || $mailStatus === 'programme'): ?>
                                            <button type="button" class="btn btn-success btn-block">
                                                <i class="fas fa-paper-plane"></i> Envoyer maintenant
                                            </button>
                                        <?php endif; ?>
                                        
                                        <a href="list.php" class="btn btn-secondary btn-block">
                                            <i class="fas fa-list"></i> Retour à la liste
                                        </a>
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
