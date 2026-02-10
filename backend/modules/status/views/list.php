<?php
$idpage = 22;
require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../config/debug.php';
require_once __DIR__ . '/../../../../php/function.php';
require_once __DIR__ . '/../models/Status.php';
require_once __DIR__ . '/../controllers/StatusController.php';

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

                                                <form method="post" onsubmit="return confirm('Supprimer ce statut ?');"
                                                    class="d-inline">
                                                    <input type="hidden" name="delete_code"
                                                        value="<?= htmlspecialchars($status['code']); ?>">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger">Supprimer</button>
                                                </form>
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
            <?php include_once __DIR__ . '/../../../layouts/footer.php'; ?>
        </div>
    </div>
</body>

</html>