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
$page_titre = "Modifier le Dossier";
$page_small_detail = "Modifier les informations du client";
$page_location = "Parcel > Modifier le dossier";

//====================== LOGIC ==========================//

$controller = new ParcelController($bdd, $_SESSION['my_userId']);
$message = '';
$alertClass = 'alert-info';
$errors = [];

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

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'full_name' => $_POST['full_name'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'address' => $_POST['address']
    ];

    // Validation
    $validationErrors = [];
    if (empty($data['full_name'])) {
        $validationErrors['full_name'] = "Le nom complet est obligatoire";
    }
    if (empty($data['email'])) {
        $validationErrors['email'] = "L'email est obligatoire";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $validationErrors['email'] = "Format d'email invalide";
    } elseif ($controller->emailExists($data['email'], $customer_id)) {
        $validationErrors['email'] = "Cet email est déjà utilisé par un autre client";
    }
    if (empty($data['address'])) {
        $validationErrors['address'] = "L'adresse est obligatoire";
    }

    if (empty($validationErrors)) {
        $result = $controller->updateCustomerRecord($data, $customer_id);

        if ($result) {
            $message = 'Dossier client mis à jour avec succès';
            $alertClass = 'alert-success';

            // Recharger les données
            $customer = $controller->getCustomerRecordById($customer_id);
        } else {
            // $message = 'Erreur lors de la mise à jour: ' . $controller->model->getLastError();
            $alertClass = 'alert-danger';
        }
    } else {
        $message = 'Veuillez corriger les erreurs du formulaire';
        $alertClass = 'alert-danger';
        $errors = $validationErrors;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once __DIR__ . '/../../../layouts/head.php'; ?>

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
                    <h1 class="h3 mb-2 text-gray-800">Modifier le Dossier</h1>

                    <!-- Message Alert -->
                    <?php if (!empty($message)): ?>
                        <div class="alert <?= $alertClass; ?> text-center" role="alert">
                            <?= htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Formulaire -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Modifier les Informations du Client</h6>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_id">Référence Dossier</label>
                                            <input type="text" class="form-control" id="customer_id"
                                                value="<?= htmlspecialchars($customer['customer_id']) ?>" readonly>
                                            <small class="form-text text-muted">La référence dossier ne peut pas être
                                                modifiée</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="created_at">Date de création</label>
                                            <input type="text" class="form-control" id="created_at"
                                                value="<?= $customer['created_at'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="full_name">Nom Complet *</label>
                                            <input type="text"
                                                class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>"
                                                id="full_name" name="full_name"
                                                value="<?= htmlspecialchars($customer['full_name']) ?>" required>
                                            <?php if (isset($errors['full_name'])): ?>
                                                <div class="invalid-feedback"><?= $errors['full_name'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email *</label>
                                            <input type="email"
                                                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                                id="email" name="email"
                                                value="<?= htmlspecialchars($customer['email']) ?>" required>
                                            <?php if (isset($errors['email'])): ?>
                                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Téléphone</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                value="<?= htmlspecialchars($customer['phone']) ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Adresse *</label>
                                    <textarea class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
                                        id="address" name="address" rows="4"
                                        required><?= htmlspecialchars($customer['address']) ?></textarea>
                                    <?php if (isset($errors['address'])): ?>
                                        <div class="invalid-feedback"><?= $errors['address'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Enregistrer les modifications
                                    </button>
                                    <a href="detail.php?id=<?= $customer_id ?>" class="btn btn-secondary">
                                        <i class="fa fa-times"></i> Annuler
                                    </a>
                                </div>
                            </form>
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