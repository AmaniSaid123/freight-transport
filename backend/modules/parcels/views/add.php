<?php
//****************** PAGE SETUP ******************
$idpage = 27;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../config/debug.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Parcel.php';
require_once __DIR__ . '/../controllers/ParcelController.php';

//====================== PAGE INFO ======================//
$get_active_menu = "parcel";
$page_titre = "Nouveau Colis";
$page_small_detail = "Créer un nouveau dossier client avec expéditions";
$page_location = "Parcel > Nouveau colis";

//====================== LOGIC ==========================//

$controller = new ParcelController($bdd, $_SESSION['my_userId']);
$message = '';
$alertClass = 'alert-info';
$errors = [];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->handleCreateParcel($_POST);
    
    if ($result['success']) {
        $message = $result['message'];
        $alertClass = 'alert-success';
        
        // Redirection vers le détail si nécessaire
        // header('Location: detail.php?customer_id=' . $result['customer_id']);
        // exit;
    } else {
        $message = $result['message'];
        $alertClass = 'alert-danger';
        $errors = $result['errors'] ?? [];
    }
}

$destinations = $controller->getAvailableDestinations();
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once __DIR__ . '/../../../layouts/head.php'; ?>
<style>
    .expedition-item {
        border: 1px solid #e3e6f0;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 15px;
        background: #f8f9fc;
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
                    <h1 class="h3 mb-2 text-gray-800">Nouveau Colis</h1>

                    <!-- Message Alert -->
                    <?php if (!empty($message)): ?>
                        <div class="alert <?= $alertClass; ?> text-center" role="alert">
                            <?= htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Formulaire -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informations du Client</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" id="parcelForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="full_name">Nom Complet *</label>
                                            <input type="text" class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>" 
                                                   id="full_name" name="full_name" 
                                                   value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>
                                            <?php if (isset($errors['full_name'])): ?>
                                                <div class="invalid-feedback"><?= $errors['full_name'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email *</label>
                                            <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                                   id="email" name="email" 
                                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
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
                                                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Adresse *</label>
                                            <textarea class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>" 
                                                      id="address" name="address" rows="2" required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                                            <?php if (isset($errors['address'])): ?>
                                                <div class="invalid-feedback"><?= $errors['address'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section Expéditions -->
                                <div class="mt-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Expéditions</h6>
                                        <button type="button" class="btn btn-success btn-sm" id="addExpedition">
                                            <i class="fa fa-plus"></i> Ajouter une expédition
                                        </button>
                                    </div>

                                    <div id="expeditionsContainer">
                                        <!-- Première expédition -->
                                        <div class="expedition-item">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Origine *</label>
                                                        <select class="form-control" name="origin[]" required>
                                                            <option value="">Sélectionnez une origine</option>
                                                            <?php foreach ($destinations as $destination): ?>
                                                                <option value="<?= $destination ?>" 
                                                                    <?= (isset($_POST['origin'][0]) && $_POST['origin'][0] === $destination) ? 'selected' : '' ?>>
                                                                    <?= $destination ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Destination *</label>
                                                        <select class="form-control" name="destination[]" required>
                                                            <option value="">Sélectionnez une destination</option>
                                                            <?php foreach ($destinations as $destination): ?>
                                                                <option value="<?= $destination ?>" 
                                                                    <?= (isset($_POST['destination'][0]) && $_POST['destination'][0] === $destination) ? 'selected' : '' ?>>
                                                                    <?= $destination ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" name="description[]" rows="2" 
                                                                  placeholder="Description du colis..."><?= htmlspecialchars($_POST['description'][0] ?? '') ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Commentaire</label>
                                                        <textarea class="form-control" name="commentaire[]" rows="2" 
                                                                  placeholder="Commentaire..."><?= htmlspecialchars($_POST['commentaire'][0] ?? '') ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Expéditions supplémentaires existantes -->
                                        <?php if (isset($_POST['origin']) && count($_POST['origin']) > 1): ?>
                                            <?php for ($i = 1; $i < count($_POST['origin']); $i++): ?>
                                                <?php if (!empty($_POST['origin'][$i]) && !empty($_POST['destination'][$i])): ?>
                                                    <div class="expedition-item">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Origine *</label>
                                                                <select class="form-control" name="origin[]" required>
                                                                    <option value="">Sélectionnez une origine</option>
                                                                    <?php foreach ($destinations as $destination): ?>
                                                                        <option value="<?= $destination ?>" 
                                                                            <?= (isset($_POST['origin'][$i]) && $_POST['origin'][$i] === $destination) ? 'selected' : '' ?>>
                                                                            <?= $destination ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Destination *</label>
                                                                    <select class="form-control" name="destination[]" required>
                                                                        <option value="">Sélectionnez une destination</option>
                                                                        <?php foreach ($destinations as $destination): ?>
                                                                            <option value="<?= $destination ?>" 
                                                                                <?= (isset($_POST['destination'][$i]) && $_POST['destination'][$i] === $destination) ? 'selected' : '' ?>>
                                                                                <?= $destination ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Description</label>
                                                                    <textarea class="form-control" name="description[]" rows="2"><?= htmlspecialchars($_POST['description'][$i] ?? '') ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Commentaire</label>
                                                                    <textarea class="form-control" name="commentaire[]" rows="2"><?= htmlspecialchars($_POST['commentaire'][$i] ?? '') ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-danger btn-sm remove-expedition">
                                                            <i class="fa fa-trash"></i> Supprimer
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (isset($errors['expeditions'])): ?>
                                        <div class="alert alert-danger"><?= $errors['expeditions'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Créer le dossier
                                    </button>
                                    <a href="list.php" class="btn btn-secondary">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let expeditionCount = <?= isset($_POST['origin']) ? count($_POST['origin']) : 1 ?>;
            
            // Ajouter une expédition
            document.getElementById('addExpedition').addEventListener('click', function() {
                const container = document.getElementById('expeditionsContainer');
                const newExpedition = document.createElement('div');
                newExpedition.className = 'expedition-item';
                newExpedition.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Origine *</label>
                                <select class="form-control" name="origin[]" required>
                                    <option value="">Sélectionnez une origine</option>
                                    <?php foreach ($destinations as $destination): ?>
                                        <option value="<?= $destination ?>"><?= $destination ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Destination *</label>
                                <select class="form-control" name="destination[]" required>
                                    <option value="">Sélectionnez une destination</option>
                                    <?php foreach ($destinations as $destination): ?>
                                        <option value="<?= $destination ?>"><?= $destination ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description[]" rows="2" placeholder="Description du colis..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Commentaire</label>
                                <textarea class="form-control" name="commentaire[]" rows="2" placeholder="Commentaire..."></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-expedition">
                        <i class="fa fa-trash"></i> Supprimer
                    </button>
                `;
                container.appendChild(newExpedition);
                expeditionCount++;
                
                // Ajouter l'événement de suppression
                newExpedition.querySelector('.remove-expedition').addEventListener('click', function() {
                    if (expeditionCount > 1) {
                        newExpedition.remove();
                        expeditionCount--;
                    } else {
                        alert('Au moins une expédition est requise.');
                    }
                });
            });
            
            // Événements de suppression pour les expéditions existantes
            document.querySelectorAll('.remove-expedition').forEach(button => {
                button.addEventListener('click', function() {
                    if (expeditionCount > 1) {
                        this.closest('.expedition-item').remove();
                        expeditionCount--;
                    } else {
                        alert('Au moins une expédition est requise.');
                    }
                });
            });
        });
    </script>

</body>
</html>
