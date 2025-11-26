<?php
//****************** PAGE SETUP ******************
$idpage = 14;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../config/debug.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Parcel.php';
require_once __DIR__ . '/../controllers/ParcelController.php';

//====================== PAGE INFO ======================//
$get_active_menu = "parcel";
$page_titre = "Gestion des Colis";
$page_small_detail = "Dossiers clients et expéditions";
$page_location = "Parcel > Liste des colis";

//====================== LOGIC ==========================//

$controller = new ParcelController($bdd, $_SESSION['my_userId']);
$message = '';
$alertClass = 'alert-info';

// Filtres
$filters = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $filters['search'] = $_GET['search'];
}

// Récupération des données
$parcels = $controller->getAllParcels($filters);
$stats = $controller->getStats();
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once __DIR__ . '/../../../layouts/head.php'; ?>

<link href="<?= BASE_URL ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<style>
    .stat-card {
        border-left: 4px solid;
    }

    .stat-customers {
        border-left-color: #4e73df;
    }

    .stat-shipments {
        border-left-color: #1cc88a;
    }

    .stat-pending {
        border-left-color: #f6c23e;
    }

    .stat-delivered {
        border-left-color: #36b9cc;
    }

    .customer-card {
        transition: all 0.3s ease;
        border-left: 4px solid #4e73df;
    }

    .customer-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .shipment-item {
        border-left: 3px solid #e74a3b;
        padding-left: 10px;
        margin-bottom: 10px;
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
                    <h1 class="h3 mb-2 text-gray-800">Gestion des Colis</h1>

                    <!-- Message Alert -->
                    <?php if (!empty($message)): ?>
                        <div class="alert <?= $alertClass; ?> text-center" role="alert">
                            <?= htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Statistics Cards -->
                    <?php if (!empty($stats)): ?>
                        <div class="row mb-4">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2 stat-card stat-customers">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Clients</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['total_customers'] ?? 0 ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2 stat-card stat-shipments">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Expéditions</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['total_shipments'] ?? 0 ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-box fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2 stat-card stat-pending">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    En attente</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['pending_shipments'] ?? 0 ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2 stat-card stat-delivered">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Livrés</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $stats['delivered_shipments'] ?? 0 ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>


                    <!-- Liste des dossiers -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des Colis</h6>
                            <a href="add.php" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Nouveau Colis
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom du client</th>
                                            <th>Référence</th>
                                            <th>Email</th>
                                            <th>Téléphone</th>
                                            <th>Adresse</th>
                                            <th>Expéditions</th>
                                            <th>Statut</th>
                                            <th>Créé le</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($parcels && count($parcels) > 0): ?>
                                            <?php foreach ($parcels as $index => $parcel):
                                                $shipments = $controller->getShipmentsByCustomerId($parcel['id']);
                                                ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><strong><?= htmlspecialchars($parcel['full_name']) ?></strong></td>
                                                    <td><?= htmlspecialchars($parcel['customer_id']) ?></td>
                                                    <td><?= htmlspecialchars($parcel['email']) ?></td>
                                                    <td><?= htmlspecialchars($parcel['phone']) ?></td>
                                                    <td><?= htmlspecialchars($controller->shortenText($parcel['address'], 60)) ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($shipments && count($shipments) > 0): ?>
                                                            <ul class="list-unstyled mb-0">
                                                                <?php foreach (array_slice($shipments, 0, 2) as $shipment): ?>
                                                                    <li>
                                                                        <strong><?= htmlspecialchars($shipment['tracking_reference']) ?></strong><br>
                                                                        <small class="text-muted">
                                                                            <?= htmlspecialchars($shipment['origin']) ?> →
                                                                            <?= htmlspecialchars($shipment['destination']) ?>
                                                                        </small><br>
                                                                        <?= $controller->getShipmentStatusBadge($shipment['status']) ?>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                                <?php if (count($shipments) > 2): ?>
                                                                    <li class="text-muted small">+<?= count($shipments) - 2 ?> autres
                                                                    </li>
                                                                <?php endif; ?>
                                                            </ul>
                                                        <?php else: ?>
                                                            <span class="text-muted small">Aucune</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $controller->getCustomerStatusBadge($parcel['deletion_status']) ?>
                                                    </td>
                                                    <td><?= $parcel['created_at'] ?></td>
                                                    <td>
                                                        <a href="detail.php?id=<?= $parcel['id'] ?>" class="btn btn-info btn-sm"
                                                            title="Voir détails">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="10" class="text-center py-4">
                                                    <i class="fa fa-box fa-2x text-muted mb-2"></i><br>
                                                    <span class="text-muted">Aucun dossier trouvé</span><br>
                                                    <a href="add.php" class="btn btn-primary btn-sm mt-2">
                                                        <i class="fa fa-plus"></i> Créer votre premier colis
                                                    </a>
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

    <!-- Page level custom scripts -->
    <script src="<?= BASE_URL ?>assets/js/demo/datatables-demo.js"></script>
</body>

</html>