<?php
$idpage = 22;
require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../config/debug.php';
require_once __DIR__ . '/../../../../php/function.php';
require_once __DIR__ . '/../models/Status.php';
require_once __DIR__ . '/../controllers/StatusController.php';

$get_active_menu = 'status';

$controller = new StatusController($bdd);
$message = '';
$alertClass = 'alert-info';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_code'])) {
    $result = $controller->handleDeleteStatus($_POST['delete_code']);
    $message = $result['message'] ?? '';
    $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';
}

$statuses = $controller->getAllStatuses();
?>

<!DOCTYPE html>
<html lang="fr">

<?php include_once __DIR__ . '/../../../layouts/head.php'; ?>

<body id="page-top">
    <div id="wrapper">
        <?php include_once __DIR__ . '/../../../layouts/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include_once __DIR__ . '/../../../layouts/topbar.php'; ?>
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="h3 mb-0 text-gray-800">Statuts des expéditions</h1>
                        <?php if (get_access($bdd, 23, $_SESSION['my_idprofile']) == 1): ?>
                        <a href="add.php" class="btn btn-primary btn-sm">Ajouter un statut</a>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($message)) : ?>
                    <div class="alert <?= $alertClass; ?>" role="alert"><?= htmlspecialchars($message); ?></div>
                    <?php endif; ?>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des statuts</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Nom (EN)</th>
                                            <th>Nom (FR)</th>
                                            <th>Badge</th>
                                            <th>Créé le</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($statuses as $status) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($status['code']); ?></td>
                                            <td><?= htmlspecialchars($status['name_en']); ?></td>
                                            <td><?= htmlspecialchars($status['name_fr']); ?></td>
                                            <td><span
                                                    class="badge badge-<?= htmlspecialchars($status['badge_class'] ?: 'secondary'); ?>"><?= htmlspecialchars($status['badge_class']); ?></span>
                                            </td>
                                            <td><?= htmlspecialchars($status['created_at']); ?></td>
                                            <td class="d-flex gap-2">
                                                <?php if (get_access($bdd, 24, $_SESSION['my_idprofile']) == 1): ?>

                                                <a href="edit.php?code=<?= urlencode($status['code']); ?>"
                                                    class="btn btn-sm btn-info mr-2">Editer</a>
                                                <?php endif; ?>
                                                <?php if (get_access($bdd, 25, $_SESSION['my_idprofile']) == 1): ?>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    data-toggle="modal"
                                                    data-target="#deleteStatusModal"
                                                    data-code="<?= htmlspecialchars($status['code'], ENT_QUOTES); ?>"
                                                    data-name="<?= htmlspecialchars($status['name_fr'], ENT_QUOTES); ?>">
                                                    Supprimer
                                                </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Status Modal -->
            <div class="modal fade" id="deleteStatusModal" tabindex="-1" role="dialog" aria-labelledby="deleteStatusModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteStatusModalLabel">Supprimer un statut</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Voulez-vous vraiment supprimer le statut
                            <strong id="deleteStatusCode"></strong>
                            <span id="deleteStatusName"></span> ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="delete_code" id="deleteStatusInput" value="">
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include_once __DIR__ . '/../../../layouts/footer.php'; ?>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>

    <script>
        $('#deleteStatusModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var code = button.data('code') || '';
            var name = button.data('name') || '';

            var modal = $(this);
            modal.find('#deleteStatusInput').val(code);
            modal.find('#deleteStatusCode').text(code);
            modal.find('#deleteStatusName').text(name ? ' (' + name + ')' : '');
        });
    </script>
</body>

</html>
