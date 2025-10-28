<?php
//****************** PAGE SETUP ******************
$idpage = 14;
require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Mailing.php';
require_once __DIR__ . '/../controllers/MailingController.php';

//====================== PAGE INFO ======================//
$get_active_menu = "mailing";
$page_titre = "Gestion des Emails";
$page_small_detail = "Campagnes d'emailing";
$page_location = "Mailing > Liste des emails";

//====================== LOGIC ==========================//

$controller = new MailingController($bdd, $_SESSION['my_userId']);
$message = '';
$alertClass = 'alert-info';

// Gestion des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_mail_id'])) {
    $mail_id = (int) $_POST['delete_mail_id'];
    $result = $controller->handleDeleteMail($mail_id);
    $message = $result['message'];
    $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';

    if ($result['success']) {
        header('Location: list.php?success=1&message=' . urlencode($message));
        exit;
    }
}

// Récupération des données
$mails = $controller->getAllMails();
$stats = $controller->getStats();
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once __DIR__ . '/../../../layouts/head.php'; ?>
<style>
    .stat-card {
        border-left: 4px solid;
    }

    .stat-total {
        border-left-color: #4e73df;
    }

    .stat-envoye {
        border-left-color: #1cc88a;
    }

    .stat-brouillon {
        border-left-color: #f6c23e;
    }

    .stat-programme {
        border-left-color: #36b9cc;
    }

    .stat-erreur {
        border-left-color: #e74a3b;
    }

    .email-preview {
        max-height: 100px;
        overflow: hidden;
        position: relative;
    }

    .email-preview::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 20px;
        background: linear-gradient(transparent, #f8f9fc);
    }
</style>

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
                    <h1 class="h3 mb-2 text-gray-800">Gestion des Emails</h1>

                    <!-- Message Alert -->
                    <?php if (isset($_GET['message'])): ?>
                        <div class="alert alert-success text-center" role="alert">
                            <?= htmlspecialchars(urldecode($_GET['message'])) ?>
                        </div>
                    <?php elseif (!empty($message)): ?>
                        <div class="alert <?= $alertClass; ?> text-center" role="alert">
                            <?= htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Statistics Cards -->
                    <?php if (!empty($stats)): ?>
                        <div class="row mb-4">
                            <div class="col-xl-2 col-md-4 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2 stat-card stat-total">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Total</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['total'] ?? 0 ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-2 col-md-4 mb-4">
                                <div class="card border-left-success shadow h-100 py-2 stat-card stat-envoye">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Envoyés</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['envoyes'] ?? 0 ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-paper-plane fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-2 col-md-4 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2 stat-card stat-brouillon">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Brouillons</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['brouillons'] ?? 0 ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-edit fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-2 col-md-4 mb-4">
                                <div class="card border-left-info shadow h-100 py-2 stat-card stat-programme">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Programmé</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['programmes'] ?? 0 ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-2 col-md-4 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2 stat-card stat-erreur">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                    Erreurs</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['erreurs'] ?? 0 ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <?php if (get_access($bdd, 15, $_SESSION['my_idprofile']) == 1): ?>
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Liste des Emails</h6>
                                <a href="add.php" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus"></i> Nouvel Email
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="15%">Titre</th>
                                            <th width="15%">Objet</th>
                                            <th width="20%">Contenu (FR)</th>
                                            <th width="10%">Statut</th>
                                            <th width="10%">Programmation</th>
                                            <th width="10%">Crée le</th>
                                            <th width="15%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($mails && count($mails) > 0): ?>
                                            <?php foreach ($mails as $index => $mail): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td>
                                                        <strong><?= htmlspecialchars($mail['titre_email']) ?></strong>
                                                    </td>
                                                    <td><?= htmlspecialchars($mail['objet']) ?></td>
                                                    <td>
                                                        <div class="email-preview">
                                                            <?= nl2br(htmlspecialchars(substr($mail['contenu_fr'], 0, 200))) ?>
                                                            <?= strlen($mail['contenu_fr']) > 200 ? '...' : '' ?>
                                                        </div>
                                                    </td>
                                                    <td><?= $controller->getStatusBadge($mail['statut']) ?></td>
                                                    <td><?= $controller->formatDate($mail['date_programmation']) ?></td>
                                                    <td><?= $controller->formatDate($mail['created_at']) ?></td>
                                                    <td class="text-center">
                                                        <div class="action-buttons d-flex justify-content-center">
                                                            <!-- Voir détails -->
                                                            <?php if (get_access($bdd, 18, $_SESSION['my_idprofile']) == 1): ?>
                                                                <a href="detail.php?id=<?= $mail['id'] ?>"
                                                                    class="btn btn-info btn-xs" title="Voir détails">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <!-- Modifier -->
                                                            <?php if (get_access($bdd, 16, $_SESSION['my_idprofile']) == 1): ?>

                                                                <a href="edit.php?id=<?= $mail['id'] ?>"
                                                                    class="btn btn-primary btn-xs" title="Modifier">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <!-- Supprimer -->
                                                            <?php if (get_access($bdd, 17, $_SESSION['my_idprofile']) == 1): ?>
                                                                <button type="button" class="btn btn-danger btn-xs delete-mail-btn"
                                                                    title="Supprimer" data-mail-id="<?= $mail['id'] ?>"
                                                                    data-mail-title="<?= htmlspecialchars($mail['titre_email']) ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>

                                            <tr>
                                                <?php if (get_access($bdd, 15, $_SESSION['my_idprofile']) == 1): ?>
                                                    <td colspan="8" class="text-center py-4">
                                                        <i class="fa fa-envelope fa-3x text-muted mb-3"></i><br>
                                                        <span class="text-muted">Aucun email trouvé</span><br>
                                                        <a href="add.php" class="btn btn-primary btn-sm mt-2">
                                                            <i class="fa fa-plus"></i> Créer votre premier email
                                                        </a>
                                                    </td>
                                                <?php endif; ?>
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

    <!-- Delete Mail Modal -->
    <div class="modal fade" id="deleteMailModal" tabindex="-1" role="dialog" aria-labelledby="deleteMailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteMailModalLabel">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Confirmation de suppression
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <strong>Attention :</strong> Cette action est irréversible.
                    </div>
                    <p>Êtes-vous sûr de vouloir supprimer l'email :</p>
                    <p class="font-weight-bold" id="deleteMailTitle"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                    <form id="deleteMailForm" method="post" style="display: inline;">
                        <input type="hidden" name="delete_mail_id" id="deleteMailId">
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Gestion du modal de suppression
            const deleteModal = document.getElementById('deleteMailModal');
            const deleteMailForm = document.getElementById('deleteMailForm');
            const deleteMailIdElement = document.getElementById('deleteMailId');
            const deleteMailTitle = document.getElementById('deleteMailTitle');

            // Événement pour les boutons de suppression
            document.querySelectorAll('.delete-mail-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const mailId = this.getAttribute('data-mail-id');
                    const mailTitle = this.getAttribute('data-mail-title');

                    // Mettre à jour le contenu du modal
                    deleteMailIdElement.value = mailId;
                    deleteMailTitle.textContent = '"' + mailTitle + '"';

                    // Ouvrir le modal
                    $(deleteModal).modal('show');
                });
            });

            // Validation du formulaire de suppression
            deleteMailForm.addEventListener('submit', function (e) {
                const mailId = deleteMailIdElement.value;
                if (!mailId || mailId <= 0) {
                    e.preventDefault();
                    alert('Erreur: ID d\'email invalide');
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

            // Initialisation DataTable
            $('#dataTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                },
                "pageLength": 25,
                "order": [[0, 'desc']]
            });
        });
    </script>
</body>

</html>