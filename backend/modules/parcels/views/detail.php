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
$page_titre = "Détail du Dossier";
$page_small_detail = "Informations détaillées du client et ses expéditions";
$page_location = "Parcel > Détail du dossier";

//====================== LOGIC ==========================//

$controller = new ParcelController($bdd, $_SESSION['my_userId']);
$message = '';
$alertClass = 'alert-info';

// Vérifier l'ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: list.php');
    exit;
}

$customer_id = $_GET['id'];
$customer = $controller->getCustomerRecordById($customer_id);

if (!$customer) {
    header('Location: list.php');
    exit;
}

// Récupérer les expéditions
$shipments = $controller->getShipmentsByCustomerId($customer_id);
$phoneContacts = array_filter(array_unique([$customer['phone'] ?? '']));
$emailContacts = array_filter(array_unique([$customer['email'] ?? '']));

// Traitement du changement de statut
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $shipment_id = $_POST['shipment_id'];
    $status = $_POST['status'];
    $notes = $_POST['notes'] ?? '';
    $notifications = [
        'notify_email' => isset($_POST['notify_email']),
        'notify_sms' => isset($_POST['notify_sms']),
        'phone_contact' => $_POST['phone_contact'] ?? ($customer['phone'] ?? ''),
        'email_contact' => $_POST['email_contact'] ?? ($customer['email'] ?? '')
    ];
    
    $result = $controller->handleUpdateShipmentStatus($shipment_id, $status, $notes, $notifications);
    
    if ($result['success']) {
        $message = $result['message'];
        $alertClass = 'alert-success';
        
        // Recharger les données
        $shipments = $controller->getShipmentsByCustomerId($customer_id);
    } else {
        $message = $result['message'];
        $alertClass = 'alert-danger';
    }
}

// Traitement de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_customer'])) {
    $result = $controller->handleDeleteCustomerRecord($customer_id);
    
    if ($result['success']) {
        $_SESSION['message'] = $result['message'];
        $_SESSION['alert_class'] = 'alert-success';
        header('Location: list.php');
        exit;
    } else {
        $message = $result['message'];
        $alertClass = 'alert-danger';
    }
}

$statuses = $controller->getAvailableStatuses();
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once __DIR__ . '/../../../layouts/head.php'; ?>
<style>
    .shipment-card {
        border-left: 4px solid #4e73df;
        margin-bottom: 15px;
    }
    .status-history {
        max-height: 200px;
        overflow-y: auto;
    }
    .timeline-item {
        border-left: 2px solid #4e73df;
        padding-left: 15px;
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
                    <h1 class="h3 mb-2 text-gray-800">Détail du Dossier</h1>

                    <!-- Message Alert -->
                    <?php if (!empty($message)): ?>
                        <div class="alert <?= $alertClass; ?> text-center" role="alert">
                            <?= htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Informations Client -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Informations Client</h6>
                            <div>
                                <a href="list.php" class="btn btn-secondary btn-sm">
                                    <i class="fa fa-arrow-left"></i> Retour
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fa fa-trash"></i> Supprimer
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Référence:</th>
                                            <td><?= htmlspecialchars($customer['customer_id']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nom Complet:</th>
                                            <td><?= htmlspecialchars($customer['full_name']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td><?= htmlspecialchars($customer['email']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Téléphone:</th>
                                            <td><?= htmlspecialchars($customer['phone'] ?: '-') ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Date création:</th>
                                            <td><?= ($customer['created_at']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Statut:</th>
                                            <td><?= $controller->getCustomerStatusBadge($customer['deletion_status']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nombre d'expéditions:</th>
                                            <td><?= count($shipments) ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <strong>Adresse:</strong>
                                    <div class="mt-2 p-3 bg-light rounded">
                                        <?= nl2br(htmlspecialchars($customer['address'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Liste des Expéditions -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Expéditions (<?= count($shipments) ?>)</h6>
                        </div>
                        <div class="card-body">
                            <?php if ($shipments && count($shipments) > 0): ?>
                                <?php foreach ($shipments as $shipment): 
                                    $history = $controller->getShipmentStatusHistory($shipment['id']);
                                ?>
                                    <div class="card shipment-card mb-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h6 class="m-0 font-weight-bold">
                                                <?= htmlspecialchars($shipment['tracking_reference']) ?>
                                            </h6>
                                            <div class="d-flex align-items-center">
                                                <?= $controller->getShipmentStatusBadge($shipment['status']) ?>
                                                <button class="btn btn-outline-primary btn-sm ml-2 edit-status-btn"
                                                        data-toggle="modal"
                                                        data-target="#statusModal"
                                                        data-shipment-id="<?= $shipment['id'] ?>"
                                                        data-current-status="<?= $shipment['status'] ?>"
                                                        data-email="<?= htmlspecialchars($customer['email']) ?>"
                                                        data-phone="<?= htmlspecialchars($customer['phone']) ?>"
                                                        data-tracking="<?= htmlspecialchars($shipment['tracking_reference']) ?>">
                                                    <i class="fa fa-edit"></i> Modifier
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <th width="40%">Origine:</th>
                                                            <td><?= htmlspecialchars($shipment['origin']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Destination:</th>
                                                            <td><?= htmlspecialchars($shipment['destination']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Date création:</th>
                                                            <td><?= $shipment['created_at'] ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <th width="40%">Dernière mise à jour:</th>
                                                            <td><?= $shipment['updated_at'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Description:</th>
                                                            <td><?= htmlspecialchars($shipment['description'] ?: '-') ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Commentaire:</th>
                                                            <td><?= htmlspecialchars($shipment['comment'] ?: '-') ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Historique des statuts -->
                                            <div class="mt-3">
                                                <h6 class="font-weight-bold">Historique des statuts:</h6>
                                                <div class="status-history">
                                                    <?php if ($history && count($history) > 0): ?>
                                                        <?php foreach ($history as $event): ?>
                                                            <div class="timeline-item">
                                                                <div class="small text-muted">
                                                                    <?= $event['created_at'] ?>
                                                                    <?php if ($event['created_by_name']): ?>
                                                                        - par <?= htmlspecialchars($event['created_by_name']) ?>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div>
                                                                    <?= $controller->getShipmentStatusBadge($event['status']) ?>
                                                                    <?php if ($event['notes']): ?>
                                                                        : <?= htmlspecialchars($event['notes']) ?>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div class="text-muted">Aucun historique disponible</div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="fa fa-box fa-3x text-muted mb-3"></i><br>
                                    <span class="text-muted">Aucune expédition trouvée</span>
                                </div>
                            <?php endif; ?>
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

    <!-- Modal de statut -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Edit File Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="update_status" value="1">
                        <input type="hidden" name="shipment_id" id="modal_shipment_id">
                        <div class="form-group">
                            <label for="modal_status">File Status</label>
                            <select class="form-control" name="status" id="modal_status" required>
                                <option value="">Sélectionner un statut</option>
                                <?php foreach ($statuses as $key => $label): ?>
                                    <option value="<?= $key ?>"><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="modal_notes">Notes internes</label>
                            <input type="text" class="form-control" name="notes" id="modal_notes" placeholder="Notes (optionnel)">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Notify Client</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="notify_sms" name="notify_sms">
                                <label class="form-check-label" for="notify_sms">
                                    SMS (e.g., 3334353636)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="notify_email" name="notify_email" checked>
                                <label class="form-check-label" for="notify_email">
                                    Email (e.g., <?= htmlspecialchars($customer['email']) ?>)
                                </label>
                            </div>
                            <small class="form-text text-muted">Un email dédié est envoyé automatiquement en fonction du statut choisi.</small>
                        </div>
                        <div class="form-group">
                            <label for="modal_phone_contact">Phone Contact</label>
                            <select class="form-control" name="phone_contact" id="modal_phone_contact">
                                <?php if (count($phoneContacts) === 0): ?>
                                    <option value="">Aucun numéro disponible</option>
                                <?php else: ?>
                                    <?php foreach ($phoneContacts as $phone): ?>
                                        <option value="<?= htmlspecialchars($phone) ?>"><?= htmlspecialchars($phone) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="modal_email_contact">Email Contact</label>
                            <select class="form-control" name="email_contact" id="modal_email_contact">
                                <?php if (count($emailContacts) === 0): ?>
                                    <option value="">Aucun email disponible</option>
                                <?php else: ?>
                                    <?php foreach ($emailContacts as $email): ?>
                                        <option value="<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer le dossier client <strong><?= htmlspecialchars($customer['full_name']) ?></strong> ?
                    <br><br>
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i> 
                        Cette action supprimera également toutes les expéditions associées à ce client.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="delete_customer" value="1">
                        <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include_once __DIR__ . '/../../../layouts/logout.php'; ?>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
    <script>
        $(function() {
            $('.edit-status-btn').on('click', function () {
                var button = $(this);
                var shipmentId = button.data('shipment-id');
                var status = button.data('current-status');
                var email = button.data('email');
                var phone = button.data('phone');
                var tracking = button.data('tracking');

                $('#modal_shipment_id').val(shipmentId);
                $('#statusModalLabel').text('Edit File Status - ' + tracking);
                $('#modal_status').val(status);
                $('#modal_notes').val('');

                if (email) {
                    if ($('#modal_email_contact option[value="' + email + '"]').length === 0) {
                        $('#modal_email_contact').append('<option value="' + email + '">' + email + '</option>');
                    }
                    $('#modal_email_contact').val(email);
                }

                if (phone) {
                    if ($('#modal_phone_contact option[value="' + phone + '"]').length === 0) {
                        $('#modal_phone_contact').append('<option value="' + phone + '">' + phone + '</option>');
                    }
                    $('#modal_phone_contact').val(phone);
                }

                $('#notify_email').prop('checked', true);
                $('#notify_sms').prop('checked', !!phone);
            });
        });
    </script>

</body>
</html>
