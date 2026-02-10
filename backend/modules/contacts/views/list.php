<?php
//****************** PAGE SETUP ******************
$idpage = 19;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Contact.php';
require_once __DIR__ . '/../controllers/ContactController.php';

//====================== PAGE INFO ======================//
$get_active_menu = "contact";
$page_titre = "Gestion des Contacts";
$page_small_detail = "Messages reçus";
$page_location = "Contact > Liste des messages";

//====================== LOGIC ==========================//

$controller = new ContactController($bdd, $_SESSION['my_userId']);
$message = '';
$alertClass = 'alert-info';

// Filtres
$filters = [];
if (isset($_GET['statut']) && !empty($_GET['statut'])) {
    $filters['statut'] = $_GET['statut'];
}
if (isset($_GET['priorite']) && !empty($_GET['priorite'])) {
    $filters['priorite'] = $_GET['priorite'];
}
if (isset($_GET['categorie']) && !empty($_GET['categorie'])) {
    $filters['categorie'] = $_GET['categorie'];
}
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $filters['search'] = $_GET['search'];
}

// Actions rapides
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'])) {
        $contact_id = (int)$_POST['contact_id'];
        $statut = $_POST['statut'];
        $result = $controller->updateContactStatus($contact_id, $statut);
        $message = $result['message'];
        $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';
    }
}

// Récupération des données
$contacts = $controller->getAllContacts($filters);
$stats = $controller->getStats();
$categories = $controller->getCategories();
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

.stat-nouveau {
    border-left-color: #e74a3b;
}

.stat-lu {
    border-left-color: #36b9cc;
}

.stat-en-cours {
    border-left-color: #f6c23e;
}

.stat-repondu {
    border-left-color: #1cc88a;
}

.stat-ferme {
    border-left-color: #858796;
}

.contact-preview {
    max-height: 80px;
    overflow: hidden;
    position: relative;
}

.contact-preview::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 20px;
    background: linear-gradient(transparent, #f8f9fc);
}

.urgent-contact {
    background-color: #f8d7da !important;
    border-left: 4px solid #e74a3b;
}

.high-priority-contact {
    background-color: #fff3cd !important;
    border-left: 4px solid #f6c23e;
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
                    <h1 class="h3 mb-2 text-gray-800">Messages de contact</h1>

                    <!-- Message Alert -->
                    <?php if (!empty($message)): ?>
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
                            <div class="card border-left-danger shadow h-100 py-2 stat-card stat-nouveau">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Nouveaux</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= $stats['nouveaux'] ?? 0 ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-4 mb-4">
                            <div class="card border-left-info shadow h-100 py-2 stat-card stat-lu">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Lus</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= $stats['lus'] ?? 0 ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-4 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2 stat-card stat-en-cours">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                En cours</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= $stats['en_cours'] ?? 0 ?>
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
                            <div class="card border-left-success shadow h-100 py-2 stat-card stat-repondu">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Répondus</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= $stats['repondus'] ?? 0 ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-4 mb-4">
                            <div class="card border-left-secondary shadow h-100 py-2 stat-card stat-ferme">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                Fermés</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= $stats['fermes'] ?? 0 ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-archive fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Filtres -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Filtres</h6>
                        </div>
                        <div class="card-body">
                            <form method="get" class="form-inline">
                                <div class="form-group mr-3 mb-2">
                                    <label for="statut" class="sr-only">Statut</label>
                                    <select class="form-control" id="statut" name="statut">
                                        <option value="">Tous les statuts</option>
                                        <option value="nouveau"
                                            <?= ($filters['statut'] ?? '') == 'nouveau' ? 'selected' : '' ?>>Nouveau
                                        </option>
                                        <option value="lu" <?= ($filters['statut'] ?? '') == 'lu' ? 'selected' : '' ?>>
                                            Lu</option>
                                        <option value="en_cours"
                                            <?= ($filters['statut'] ?? '') == 'en_cours' ? 'selected' : '' ?>>En cours
                                        </option>
                                        <option value="repondu"
                                            <?= ($filters['statut'] ?? '') == 'repondu' ? 'selected' : '' ?>>Répondu
                                        </option>
                                        <option value="ferme"
                                            <?= ($filters['statut'] ?? '') == 'ferme' ? 'selected' : '' ?>>Fermé
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group mr-3 mb-2">
                                    <label for="priorite" class="sr-only">Priorité</label>
                                    <select class="form-control" id="priorite" name="priorite">
                                        <option value="">Toutes les priorités</option>
                                        <option value="urgente"
                                            <?= ($filters['priorite'] ?? '') == 'urgente' ? 'selected' : '' ?>>Urgente
                                        </option>
                                        <option value="haute"
                                            <?= ($filters['priorite'] ?? '') == 'haute' ? 'selected' : '' ?>>Haute
                                        </option>
                                        <option value="normale"
                                            <?= ($filters['priorite'] ?? '') == 'normale' ? 'selected' : '' ?>>Normale
                                        </option>
                                        <option value="basse"
                                            <?= ($filters['priorite'] ?? '') == 'basse' ? 'selected' : '' ?>>Basse
                                        </option>
                                    </select>
                                </div>

                                <?php if (!empty($categories)): ?>
                                <div class="form-group mr-3 mb-2">
                                    <label for="categorie" class="sr-only">Catégorie</label>
                                    <select class="form-control" id="categorie" name="categorie">
                                        <option value="">Toutes les catégories</option>
                                        <?php foreach ($categories as $categorie): ?>
                                        <option value="<?= htmlspecialchars($categorie) ?>"
                                            <?= ($filters['categorie'] ?? '') == $categorie ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($categorie) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php endif; ?>

                                <div class="form-group mr-3 mb-2">
                                    <label for="search" class="sr-only">Recherche</label>
                                    <input type="text" class="form-control" id="search" name="search"
                                        placeholder="Rechercher..."
                                        value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                                </div>

                                <button type="submit" class="btn btn-primary mb-2">
                                    <i class="fas fa-filter"></i> Filtrer
                                </button>
                                <a href="list.php" class="btn btn-secondary mb-2 ml-2">
                                    <i class="fas fa-times"></i> Effacer
                                </a>
                            </form>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des messages</h6>
                            <span class="badge badge-danger"><?= $stats['nouveaux'] ?? 0 ?> nouveau(x)</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="15%">Contact</th>
                                            <th width="20%">Sujet</th>
                                            <th width="25%">Message</th>
                                            <th width="10%">Statut</th>
                                            <th width="10%">Priorité</th>
                                            <th width="10%">Date</th>
                                            <th width="5%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($contacts && count($contacts) > 0): ?>
                                        <?php foreach ($contacts as $index => $contact): 
                                                $rowClass = '';
                                                if ($contact['priorite'] === 'urgente') {
                                                    $rowClass = 'urgent-contact';
                                                } elseif ($contact['priorite'] === 'haute') {
                                                    $rowClass = 'high-priority-contact';
                                                }
                                            ?>
                                        <tr class="<?= $rowClass ?>">
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <strong><?= htmlspecialchars($contact['nom']) ?></strong><br>
                                                <small
                                                    class="text-muted"><?= htmlspecialchars($contact['email']) ?></small>
                                                <?php if (!empty($contact['telephone'])): ?>
                                                <br><small
                                                    class="text-muted"><?= htmlspecialchars($contact['telephone']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars($contact['sujet']) ?></strong>
                                                <?php if (!empty($contact['categorie'])): ?>
                                                <br><span
                                                    class="badge badge-light"><?= htmlspecialchars($contact['categorie']) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="contact-preview">
                                                    <?= nl2br(htmlspecialchars($controller->shortenText($contact['message'], 150))) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?= $controller->getStatusBadge($contact['statut']) ?>
                                                <?php if ($contact['statut'] === 'nouveau'): ?>
                                                <br>
                                                <form method="post" class="d-inline">
                                                    <input type="hidden" name="contact_id"
                                                        value="<?= $contact['id'] ?>">
                                                    <input type="hidden" name="statut" value="lu">
                                                    <button type="submit" name="update_status"
                                                        class="btn btn-sm btn-outline-primary mt-1">
                                                        <i class="fas fa-eye"></i> Marquer lu
                                                    </button>
                                                </form>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $controller->getPriorityBadge($contact['priorite']) ?></td>
                                            <td><?= $controller->formatDate($contact['date_creation']) ?></td>
                                            <td class="text-center">
                                                <div class="action-buttons d-flex justify-content-center">
                                                    <!-- Voir détails -->
                                                    <?php if (get_access($bdd, 20, $_SESSION['my_idprofile']) == 1): ?>
                                                    <a href="detail.php?id=<?= $contact['id'] ?>"
                                                        class="btn btn-info btn-xs" title="Voir détails">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                    <!-- Répondre -->
                                                    <?php if (get_access($bdd, 21, $_SESSION['my_idprofile']) == 1): ?>

                                                    <a href="reply.php?id=<?= $contact['id'] ?>"
                                                        class="btn btn-primary btn-xs" title="Répondre">
                                                        <i class="fa fa-reply"></i>
                                                    </a> <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="fa fa-envelope fa-3x text-muted mb-3"></i><br>
                                                <span class="text-muted">Aucun message trouvé</span>
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

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>

    <script src="<?= BASE_URL ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation DataTable
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            },
            "pageLength": 25,
            "order": [
                [0, 'desc']
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": [7]
            }]
        });

        // Auto-dissimulation des messages après 5 secondes
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
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