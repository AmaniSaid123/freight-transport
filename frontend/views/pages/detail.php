<?php
session_start();
require_once __DIR__ . '/../../includes/translation.php';
include_once(__DIR__ . "/../../../php/function.php");
require __DIR__ . '/../../../config/debug.php';
require_once __DIR__ . '/../../controllers/ParcelController.php';

global $bdd;
$controller = new ParcelController();

// Récupération du colis
$parcelId = $_GET['parcel_id'] ?? null;

if (!$parcelId) {
    $error = "Aucun colis spécifié.";
} else {
    $parcel = $controller->getParcelWithExpeditions($parcelId);
    if (!$parcel) {
        $error = "Aucun colis trouvé avec l’ID " . htmlspecialchars($parcelId);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<?php include(__DIR__ . '/../layouts/head.php'); ?>

<body>

<?php include(__DIR__ . '/../layouts/topbar.php'); ?>
<?php include(__DIR__ . '/../layouts/menu.php'); ?>

<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width:900px;">
        <h3 class="display-7 mb-4 wow fadeInDown" data-wow-delay="0.1s">
            <?= t('parcel_details') ?>
        </h3>
        <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="homepage.php"><?= t('home') ?></a></li>
            <li class="breadcrumb-item"><a href="#"><?= t('pages') ?></a></li>
            <li class="breadcrumb-item active text-black"><?= t('parcel_details') ?></li>
        </ol>
    </div>
</div>

<div class="container-fluid appointment py-5">
    <div class="container py-5">
        <div class="appointment-form rounded p-5">

            <h1 class="display-6 mb-4"><?= t('parcel_details') ?></h1>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php else: ?>
                <!-- Informations principales du colis -->
                <div class="card shadow-sm border-primary mb-4">
                    <div class="card-body">
                        <h5 class="card-title">📦 <?= htmlspecialchars($parcel['tracking_number'] ?? '—') ?></h5>
                        <p><strong><?= t('full_name') ?> :</strong> <?= htmlspecialchars($parcel['full_name']) ?></p>
                        <p><strong><?= t('email') ?> :</strong> <?= htmlspecialchars($parcel['email']) ?></p>
                        <p><strong><?= t('phone') ?> :</strong> <?= htmlspecialchars($parcel['phone']) ?></p>
                        <p><strong><?= t('address') ?> :</strong> <?= htmlspecialchars($parcel['address']) ?></p>
                        <p><strong><?= t('date_created') ?> :</strong> <?= htmlspecialchars($parcel['created_at']) ?></p>
                    </div>
                </div>

                <!-- Liste des expéditions -->
                <h3 class="mb-3"><?= t('expeditions') ?></h3>

                <?php if (!empty($parcel['expeditions'])): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th><?= t('origin') ?></th>
                                    <th><?= t('destination') ?></th>
                                    <th><?= t('description') ?></th>
                                    <th><?= t('commentaire') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($parcel['expeditions'] as $i => $exp): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= htmlspecialchars($exp['origin']) ?></td>
                                        <td><?= htmlspecialchars($exp['destination']) ?></td>
                                        <td><?= htmlspecialchars($exp['description']) ?></td>
                                        <td><?= htmlspecialchars($exp['comment']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted"><?= t('no_expedition_found') ?></p>
                <?php endif; ?>

                <div class="text-end mt-4">
                    <a href="<?= BASE_URL ?>views/pages/send-parcel.php" class="btn btn-primary">
                        ← <?= t('back_to_send') ?>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include(__DIR__ . '/../layouts/footer.php'); ?>
<a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>
<?php include(__DIR__ . '/../layouts/js.php'); ?>

</body>
</html>
