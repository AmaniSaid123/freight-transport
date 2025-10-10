<?php
//****************** PAGE SETUP ******************
$idpage = 2;

require_once __DIR__ . '/../../../views/pages/session_check.php';
require_once __DIR__ . '/../../../../config/debug.php';
require_once __DIR__ . '/../../../../php/function.php';

// Charger les classes
require_once __DIR__ . '/../models/Profile.php';
require_once __DIR__ . '/../controllers/ProfileController.php';

// Configuration de la page
$get_active_menu = "profile";
$page_titre = "Profiles";
$page_small_detail = "des Utilisateurs";
$page_location = "Gestion des Profiles > Profiles des Utilisateurs";


$profileModel = new Profile($bdd);

//****************** INITIALISATION ******************
$profileActions = new ProfileController($profileModel, $_SESSION['my_username']);
$message = null;

//****************** GESTION DES ACTIONS ******************
try {
    // Action : Fermer le profil
    $closeResult = $profileActions->handleCloseProfile();
    if ($closeResult) {
        $message = $closeResult;
    }

    // Action : Supprimer un profil
    if (!empty($_GET['del'])) {
        $profileId = (int) $_GET['del'];

        // Validation supplémentaire
        if ($profileId > 0) {
            $message = $profileActions->handleDeleteProfile($profileId);

            // Redirection après suppression réussie pour éviter la resoumission
            if (isset($message['success']) && $message['success'] === 'yes') {
                header('Location: ' . $_SERVER['PHP_SELF'] . '?success=1&message=' . urlencode($message['message']));
                exit;
            }
        } else {
            $message = [
                'error' => 'yes',
                'message' => 'ID de profile invalide'
            ];
        }
    }

    // Gestion des messages de redirection
    if (isset($_GET['success']) && $_GET['success'] == 1 && isset($_GET['message'])) {
        $message = [
            'success' => 'yes',
            'message' => urldecode($_GET['message'])
        ];
    }
} catch (Exception $e) {
    $message = [
        'error' => 'yes',
        'message' => 'Une erreur est survenue: ' . $e->getMessage()
    ];
}

//****************** RÉCUPÉRATION DES DONNÉES ******************
try {
    $profiles = $profileActions->getAllProfiles();

    $total_agent = $profileActions->getTotalUsers();

    // Récupérer les statistiques pour les indicateurs
    $stats = $profileActions->getProfileStats();
} catch (Exception $e) {
    $profiles = [];
    $total_agent = 0;
    $stats = [];

    if (!isset($message)) {
        $message = [
            'error' => 'yes',
            'message' => 'Erreur lors du chargement des données: ' . $e->getMessage()
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_titre ?> - <?= $page_small_detail ?></title>
    <style>
    .stats-container {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .stat-card {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        flex: 1;
        min-width: 200px;
        text-align: center;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
    }

    .action-buttons a {
        padding: 5px 8px;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .action-buttons a:hover {
        background-color: #f8f9fa;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        color: #6c757d;
        font-style: italic;
    }
    </style>
</head>

<body class="hold-transition skin-purple sidebar-collapse sidebar-mini <?= isset($is_fixed) ? 'fixed' : '' ?>"
    onbeforeprint="ShowLoading()" onbeforeunload="ShowLoading()">


    <?php include_once __DIR__ . '/../../../layouts/header.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <?php include_once __DIR__ . '/../../../layouts/titre_location.php'; ?>
        </section>

        <section class="content">
            <?php include_once __DIR__ . '/../../../views/pages/print_message.php'; ?>

            <!-- Indicateurs de statistiques -->
            <?php if (!empty($stats)): ?>
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-number"><?= $stats['total_profiles'] ?? 0 ?></div>
                    <div class="stat-label">Profils Totaux</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $total_agent ?></div>
                    <div class="stat-label">Utilisateurs Totaux</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $stats['profiles_with_users'] ?? 0 ?></div>
                    <div class="stat-label">Profils Actifs</div>
                </div>
            </div>
            <?php endif; ?>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Liste des Profiles</h3>
                    <div class="box-tools">
                        <?php if (get_access($bdd, 4, $_SESSION['my_idprofile']) == 1): ?>
                        <a href="<?= BASE_URL ?>modules/profiles/views/add.php" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Nouveau Profile
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Profile</th>
                                    <th width="10%"><i class="fa fa-link"></i> Utilisation</th>
                                    <th width="35%">Description</th>
                                    <th width="15%">Crée le</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($profiles && $profiles->rowCount() > 0): ?>
                                <?php foreach ($profiles as $index => $data):
                                        $percent = $total_agent > 0 ? round(($data['total_user'] / $total_agent * 100)) : 0;
                                        $badgeClass = $percent > 50 ? 'bg-green' : ($percent > 25 ? 'bg-blue' : 'bg-light-blue');
                                        ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($data['profile']) ?></strong>
                                        <?php if ($data['total_user'] > 0): ?>
                                        <br><small class="text-muted"><?= $data['total_user'] ?> utilisateur(s)</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= $badgeClass ?>">
                                            <?= $percent ?>%
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($data['description'] ?? 'Non renseignée') ?></td>
                                    <td>
                                        <?php if (!empty($data['created_at'])): ?>
                                        <?= date('d/m/Y', strtotime($data['created_at'])) ?>
                                        <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="action-buttons">
                                        <?php if (get_access($bdd, 3, $_SESSION['my_idprofile']) == 1): ?>
                                        <a href="<?= BASE_URL ?>modules/profiles/views/edit.php?find=<?= $data['idprofile'] ?>"
                                            class="btn btn-default btn-xs" title="Modifier le profile">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <?php endif; ?>

                                        <?php if (get_access($bdd, 5, $_SESSION['my_idprofile']) == 1): ?>
                                        <a href="<?= BASE_URL ?>modules/profiles/views/list.php?del=<?= $data['idprofile'] ?>"
                                            class="btn btn-danger btn-xs"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer le profile \'<?= addslashes($data['profile']) ?>\' ? Cette action est irréversible.')"
                                            title="Supprimer le profile">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="6" class="no-data">
                                        <i class="fa fa-info-circle"></i> Aucun profile trouvé
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($profiles && $profiles->rowCount() > 0): ?>
                <div class="box-footer clearfix">
                    <div class="pull-right text-muted">
                        <small>
                            Affichage de <?= $profiles->rowCount() ?> profile(s) sur
                            <?= $stats['total_profiles'] ?? $profiles->rowCount() ?> au total
                        </small>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <?php include_once __DIR__ . '/../../../layouts/footer.php'; ?>
    </footer>

    <?php
    include_once __DIR__ . '/../../../layouts/tableau_controle.php';
    include_once __DIR__ . '/../../../assets/js/script.php';
    ?>

    <script>
    // Script pour améliorer l'UX
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dissimulation des messages après 5 secondes
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const fade = new bootstrap.Alert(alert);
                fade.close();
            });
        }, 5000);

        // Confirmation améliorée pour la suppression
        const deleteButtons = document.querySelectorAll('a[onclick*="confirm"]');
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                if (!confirm(this.getAttribute('data-confirm-message') || this.getAttribute(
                        'onclick').match(/'([^']+)'/)[1])) {
                    e.preventDefault();
                }
            });
        });
    });
    </script>
</body>

</html>