<?php
//****************** PAGE SETUP ******************
$idpage = 29;

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
$emailContacts = array_filter(array_unique([$customer['email'] ?? '']));

// Traitement du changement de statut
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {

    $shipment_id = $_POST['shipment_id'];
    $status = $_POST['status'];
    $notes = $_POST['notes'] ?? '';
    $notifications = [
        'notify_email' => isset($_POST['notify_email']),
        'email_contact' => $_POST['email_contact'] ?? ($customer['email'] ?? ''),
        'email_language' => $_POST['email_language'] ?? null
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

// Ajout d'un commentaire interne
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_internal_comment'])) {
    $shipment_id = $_POST['comment_shipment_id'] ?? null;
    $internal_comment = $_POST['internal_comment'] ?? '';

    $result = $controller->handleAddInternalComment($shipment_id, $internal_comment);

    if ($result['success']) {
        $message = $result['message'];
        $alertClass = 'alert-success';
        $shipments = $controller->getShipmentsByCustomerId($customer_id);
    } else {
        $message = $result['message'];
        $alertClass = 'alert-danger';
    }
}

$statuses = $controller->getAvailableStatuses();
$primaryShipment = $shipments[0] ?? null;
$primaryComment = '-';
if ($shipments) {
    foreach ($shipments as $ship) {
        if (!empty($ship['comment'])) {
            $primaryComment = $ship['comment'];
            break;
        }
    }
}
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

    .detail-header-card .info-label {
        font-size: 0.75rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #858796;
        margin-bottom: 4px;
    }

    .detail-header-card .info-value {
        font-weight: 600;
    }

    .detail-header-card .info-block {
        min-width: 180px;
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




                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2 stat-card stat-customers">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Add Internal Comment</div>
                                            <button type="button"
                                                class="btn btn-light text-primary mr-2 mb-2 add-comment-btn"
                                                data-toggle="modal" data-target="#commentModal"
                                                data-shipment-id="<?= $primaryShipment['id'] ?? '' ?>"
                                                data-tracking="<?= htmlspecialchars($primaryShipment['tracking_reference'] ?? '') ?>"
                                                <?php if (!$primaryShipment)
                                                    echo 'disabled'; ?>>
                                                <i class="fa fa-comment"></i>
                                            </button>
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
                                                Edit File Status</div>
                                            <button type="button"
                                                 class="btn btn-light text-primary mr-2 mb-2 edit-status-btn"
                                                data-toggle="modal" data-target="#statusModal"
                                                data-shipment-id="<?= $primaryShipment['id'] ?? '' ?>"
                                                data-current-status="<?= htmlspecialchars($primaryShipment['status_code'] ?? '') ?>"
                                                data-email="<?= htmlspecialchars($customer['email'] ?? '') ?>"
                                                data-tracking="<?= htmlspecialchars($primaryShipment['tracking_reference'] ?? '') ?>"
                                                <?php if (!$primaryShipment)
                                                    echo 'disabled'; ?>>
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>




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
                                            <td><?= $controller->getCustomerStatusBadge($customer['deletion_status']) ?>
                                            </td>
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
                                                <?= $controller->getShipmentStatusBadge($shipment['status_code'] ?? '') ?>

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
                                                                    <?= $controller->getShipmentStatusBadge($event['status_code']) ?>
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
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
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
                        <div class="form-group">
                            <label for="modal_shipment_id">Sélectionner un colis</label>
                            <select class="form-control" name="shipment_id" id="modal_shipment_id" required>
                                <?php if ($shipments && count($shipments) > 0): ?>
                                    <?php foreach ($shipments as $shipment): ?>
                                        <option value="<?= $shipment['id']; ?>"
                                            data-tracking="<?= htmlspecialchars($shipment['tracking_reference']); ?>">
                                            <?= htmlspecialchars($shipment['tracking_reference']); ?>
                                            <?= $shipment['destination'] ? ' - ' . htmlspecialchars($shipment['destination']) : '' ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">Aucun colis disponible</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="modal_status">File Status</label>
                            <select class="form-control" name="status" id="modal_status" required>
                                <option value="">Sélectionner un statut</option>
                                <?php foreach ($statuses as $key => $label): ?>
                                    <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="modal_notes">Notes internes</label>
                            <input type="text" class="form-control" name="notes" id="modal_notes"
                                placeholder="Notes (optionnel)">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Notify Client</label>
                          
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="notify_email"
                                    name="notify_email">
                                <label class="form-check-label" for="notify_email">
                                    Email (e.g., <?= htmlspecialchars($customer['email']) ?>)
                                </label>
                            </div>
                            <small class="form-text text-muted">Un email dédié est envoyé automatiquement en fonction du
                                statut choisi.</small>
                        </div>
               
                        <div class="form-group">
                            <label for="modal_email_contact">Email Contact</label>
                            <select class="form-control" name="email_contact" id="modal_email_contact" disabled>
                                <?php if (count($emailContacts) === 0): ?>
                                    <option value="">Aucun email disponible</option>
                                <?php else: ?>
                                    <?php foreach ($emailContacts as $email): ?>
                                        <option value="<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email_language">Langue de l'email</label>
                            <select class="form-control" name="email_language" id="email_language" disabled>
                                <option value="fr">Français</option>
                                <option value="en">English</option>
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

    <!-- Modal de commentaire interne -->
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="commentModalLabel">Add Internal Comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="add_internal_comment" value="1">
                        <div class="form-group">
                            <label for="comment_shipment_id">Sélectionner une expédition</label>
                            <select class="form-control" id="comment_shipment_id" name="comment_shipment_id" required>
                                <?php if ($shipments && count($shipments) > 0): ?>
                                    <?php foreach ($shipments as $shipment): ?>
                                        <option value="<?= $shipment['id'] ?>">
                                            <?= htmlspecialchars($shipment['tracking_reference']) ?> -
                                            <?= htmlspecialchars($shipment['destination']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">Aucune expédition disponible</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="internal_comment">Internal Note</label>
                            <textarea class="form-control" id="internal_comment" name="internal_comment" rows="3"
                                placeholder="Ajouter une note interne" required></textarea>
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include_once __DIR__ . '/../../../layouts/logout.php'; ?>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
    <script>
        $(function () {
            $('.edit-status-btn').on('click', function () {
                var button = $(this);
                var shipmentId = button.data('shipment-id');
                var status = button.data('current-status');
                var email = button.data('email');
                var tracking = button.data('tracking');

                $('#modal_shipment_id').val(shipmentId);
                if (tracking) {
                    $('#statusModalLabel').text('Edit File Status - ' + tracking);
                } else {
                    updateStatusModalLabel();
                }
                $('#modal_status').val(status);
                $('#modal_notes').val('');

                if (email) {
                    if ($('#modal_email_contact option[value="' + email + '"]').length === 0) {
                        $('#modal_email_contact').append('<option value="' + email + '">' + email + '</option>');
                    }
                    $('#modal_email_contact').val(email);
                }

                $('#notify_email').prop('checked', false);
                $('#email_language').val('fr');
                toggleEmailFields();
            });

            $('#notify_email').on('change', function () {
                toggleEmailFields();
            });

            $('.add-comment-btn').on('click', function () {
                var button = $(this);
                var shipmentId = button.data('shipment-id');
                var tracking = button.data('tracking');

                $('#internal_comment').val('');
                $('#commentModalLabel').text(tracking ? 'Add Internal Comment - ' + tracking : 'Add Internal Comment');

                if (shipmentId) {
                    $('#comment_shipment_id').val(String(shipmentId));
                } else {
                    $('#comment_shipment_id').prop('selectedIndex', 0);
                }
            });

            function toggleEmailFields() {
                var enabled = $('#notify_email').is(':checked');
                $('#modal_email_contact').prop('disabled', !enabled);
                $('#email_language').prop('disabled', !enabled);
            }

            $('#modal_shipment_id').on('change', function () {
                updateStatusModalLabel();
            });

            function updateStatusModalLabel() {
                var selected = $('#modal_shipment_id option:selected');
                var trackingVal = selected.data('tracking');
                if (trackingVal) {
                    $('#statusModalLabel').text('Edit File Status - ' + trackingVal);
                } else {
                    $('#statusModalLabel').text('Edit File Status');
                }
            }

            // Initialise le titre si un colis est déjà sélectionné
            updateStatusModalLabel();
        });
    </script>

</body>

</html>
