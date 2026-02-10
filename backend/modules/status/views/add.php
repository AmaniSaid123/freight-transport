<?php
$idpage = 23;
require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../config/debug.php';
require_once __DIR__ . '/../../../../php/function.php';
require_once __DIR__ . '/../models/Status.php';
require_once __DIR__ . '/../controllers/StatusController.php';

$controller = new StatusController($bdd);
$message = '';
$alertClass = 'alert-info';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->create($_POST);
    if ($result['success']) {
        $message = $result['message'];
        $alertClass = 'alert-success';
        $_POST = [];
    } else {
        $message = $result['message'] ?? 'Erreur';
        $alertClass = 'alert-danger';
        $errors = $result['errors'] ?? [];
    }
}

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
                    <h1 class="h3 mb-2 text-gray-800">Nouveau statut</h1>

                    <?php if (!empty($message)) : ?>
                        <div class="alert <?= $alertClass; ?>" role="alert"><?= htmlspecialchars($message); ?></div>
                    <?php endif; ?>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Créer un statut</h6>
                            <a href="list.php" class="btn btn-sm btn-secondary">Retour</a>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="code">Code *</label>
                                    <input type="text" class="form-control <?= isset($errors['code']) ? 'is-invalid' : '' ?>" id="code" name="code" value="<?= htmlspecialchars($_POST['code'] ?? '') ?>" required>
                                    <?php if (isset($errors['code'])) : ?><div class="invalid-feedback"><?= $errors['code']; ?></div><?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="name_en">Nom (EN) *</label>
                                    <input type="text" class="form-control <?= isset($errors['name_en']) ? 'is-invalid' : '' ?>" id="name_en" name="name_en" value="<?= htmlspecialchars($_POST['name_en'] ?? '') ?>" required>
                                    <?php if (isset($errors['name_en'])) : ?><div class="invalid-feedback"><?= $errors['name_en']; ?></div><?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="name_fr">Nom (FR) *</label>
                                    <input type="text" class="form-control <?= isset($errors['name_fr']) ? 'is-invalid' : '' ?>" id="name_fr" name="name_fr" value="<?= htmlspecialchars($_POST['name_fr'] ?? '') ?>" required>
                                    <?php if (isset($errors['name_fr'])) : ?><div class="invalid-feedback"><?= $errors['name_fr']; ?></div><?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="badge_class">Badge (classe Bootstrap)</label>
                                    <input type="text" class="form-control" id="badge_class" name="badge_class" placeholder="success, warning, info..." value="<?= htmlspecialchars($_POST['badge_class'] ?? '') ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once __DIR__ . '/../../../layouts/footer.php'; ?>
        </div>
    </div>

</body>

</html>
