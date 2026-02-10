<?php
//****************** PAGE SETUP ******************
$idpage = 20;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Contact.php';
require_once __DIR__ . '/../controllers/ContactController.php';

//====================== PAGE INFO ======================//
$get_active_menu = "contact";
$page_titre = "Détail du message";
$page_small_detail = "Consulter le message";
$page_location = "Contact > Détail";

//====================== LOGIC ==========================//
$controller = new ContactController($bdd, $_SESSION['my_userId']);
$message = '';
$alertClass = 'alert-info';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: list.php');
    exit;
}

$contact_id = (int) $_GET['id'];
$contact = $controller->getContactById($contact_id);

if (!$contact) {
    header('Location: list.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'])) {
        $statut = $_POST['statut'] ?? '';
        $result = $controller->updateContactStatus($contact_id, $statut);
        $message = $result['message'];
        $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';
    }

    if (isset($_POST['add_note'])) {
        $note = $_POST['note_interne'] ?? '';
        $result = $controller->addInternalNote($contact_id, $note);
        $message = $result['message'];
        $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';
    }

    $contact = $controller->getContactById($contact_id);
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Détail du message</h1>
                        <a href="list.php" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
                        </a>
                    </div>

                    <!-- Message Alert -->
                    <?php if (!empty($message)): ?>
                        <div class="alert <?= $alertClass; ?> text-center" role="alert">
                            <?= htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Message reçu</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1"><strong>Contact:</strong> <?= htmlspecialchars($contact['nom']) ?></p>
                                    <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($contact['email']) ?></p>
                                    <?php if (!empty($contact['telephone'])): ?>
                                        <p class="mb-1"><strong>Téléphone:</strong> <?= htmlspecialchars($contact['telephone']) ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($contact['categorie'])): ?>
                                        <p class="mb-1"><strong>Catégorie:</strong> <?= htmlspecialchars($contact['categorie']) ?></p>
                                    <?php endif; ?>
                                    <p class="mb-1"><strong>Date:</strong> <?= $controller->formatDate($contact['date_creation']) ?></p>
                                    <p class="mb-3"><strong>Statut:</strong> <?= $controller->getStatusBadge($contact['statut']) ?></p>

                                    <div class="mb-3">
                                        <h6 class="text-uppercase text-muted">Sujet</h6>
                                        <div class="p-3 bg-light rounded"><?= htmlspecialchars($contact['sujet']) ?></div>
                                    </div>

                                    <div>
                                        <h6 class="text-uppercase text-muted">Message</h6>
                                        <div class="p-3 bg-light rounded"><?= nl2br(htmlspecialchars($contact['message'])) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Statut</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" class="mb-3">
                                        <input type="hidden" name="update_status" value="1">
                                        <div class="form-group">
                                            <label for="statut">Mettre à jour le statut</label>
                                            <select class="form-control" id="statut" name="statut" required>
                                                <option value="nouveau" <?= $contact['statut'] === 'nouveau' ? 'selected' : '' ?>>Nouveau</option>
                                                <option value="lu" <?= $contact['statut'] === 'lu' ? 'selected' : '' ?>>Lu</option>
                                                <option value="en_cours" <?= $contact['statut'] === 'en_cours' ? 'selected' : '' ?>>En cours</option>
                                                <option value="repondu" <?= $contact['statut'] === 'repondu' ? 'selected' : '' ?>>Répondu</option>
                                                <option value="ferme" <?= $contact['statut'] === 'ferme' ? 'selected' : '' ?>>Fermé</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-outline-primary btn-sm">Mettre à jour</button>
                                    </form>

                                    <div class="border-top pt-3">
                                        <h6 class="text-uppercase text-muted">Priorité</h6>
                                        <div><?= $controller->getPriorityBadge($contact['priorite'] ?? '') ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Notes internes</h6>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($contact['notes_interne'])): ?>
                                        <div class="mb-3 p-3 bg-light rounded" style="white-space: pre-line;">
                                            <?= htmlspecialchars($contact['notes_interne']) ?>
                                        </div>
                                    <?php endif; ?>

                                    <form method="post">
                                        <input type="hidden" name="add_note" value="1">
                                        <div class="form-group">
                                            <label for="note_interne">Ajouter une note</label>
                                            <textarea class="form-control" id="note_interne" name="note_interne" rows="4" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-outline-secondary btn-sm">Ajouter</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="reply.php?id=<?= $contact['id'] ?>" class="btn btn-primary btn-sm">Répondre</a>

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
