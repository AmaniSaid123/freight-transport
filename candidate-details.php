<?php
session_start();
if (isset($_SESSION['my_doc_online'])) {
    session_unset();
    session_destroy();
}


// Inclusion des fonctions et paramètres

include_once("php/function.php");
include("param.php");

global $bdd;


$nid_client = $email = $pin_secret = "";
$errors = [];

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['btn_valider'])) {

    // Validation et nettoyage des entrées utilisateur
    $nid_client = !empty($_POST['nid_client']) ? trim($_POST['nid_client']) : "";
    $email = !empty($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) : "";
    $pin_secret = !empty($_POST['pin_secret']) ? trim($_POST['pin_secret']) : "";

    if (empty($nid_client)) {
        $errors['nid_client'] = "NID est obligatoire.";
    }
    if (empty($email)) {
        $errors['email'] = "Email est obligatoire.";
    }
    if (empty($pin_secret)) {
        $errors['pin_secret'] = "PIN SECRET est obligatoire.";
    }

    // Si aucune erreur, traitement de l'authentification
    if (empty($errors)) {
        try {
            $stmt = $bdd->prepare("SELECT idt_dossier FROM t_dossier
                                   WHERE (nid_pp = :nid OR ndel = :nid OR email = :email)
                                   AND pin_secret = :pin
                                   AND (statut_dossier IS NULL OR statut_dossier NOT IN ('Clos_reussi','Clos_echec','Clos_Abandon','Paiement_incomplet'))
                                   LIMIT 1");
            $stmt->execute([
                'nid' => $nid_client,
                'email' => $email,
                'pin' => $pin_secret
            ]);
            $dossier = $stmt->fetch();

            if ($dossier) {
                $_SESSION['my_doc_online'] = $dossier['idt_dossier'];
                $_SESSION['username_online'] = "online_user";
                $_SESSION['sessionstarttime_online'] = date('H:i:s d/m/Y');

                add_notification("t_dossier", $nid_client ?: $email, "Connexion", "Connexion réussie", $nid_client ?: $email, "Connexion à MyPASS Online");

                header("Location: candidate-update.php?msg=Vous êtes connecté à votre compte&success=ok");
                exit;

            } else {
                $errors['auth'] = "Nom d'utilisateur ou PIN incorrect.";
            }
        } catch (Exception $e) {
            $errors['auth'] = "Une erreur est survenue : " . $e->getMessage();
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">


<?php
include_once("candidate/layouts/head.php");
?>

<body class="service-details-page">

<?php
include_once("candidate/layouts/header.php");
?>


<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h2 class="heading-title">Consultez Votre Dossier en Toute Confiance</h2>

                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="candidate.php">Accueil</a></li>
                    <li class="current">Consulter dossier MyPass</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Service Details Section -->
    <section id="service-details" class="service-details section payment">

        <div class="container">

            <div class="row gy-4">
                <div class="row justify-content-center">
                    <div class="col-lg-8 py-5 py-xl-5 py-xxl-7 col-payment section-title">
                        <h2>Accéder au dossier <br></h2>
                        <div class="pt-5 p-4">
                            <?php if (!empty($errors['auth']) || !empty($errors['stripe'])): ?>
                                <div class="alert alert-danger">
                                    <?= htmlspecialchars($errors['auth'] ?? $errors['stripe']) ?>
                                </div>
                            <?php endif; ?>

                            <form class="row g-4 mt-3 payment-form" method="POST">
                                <div class="form-group row mb-3 align-items-center">
                                    <label for="nid_client" class="col-12 col-sm-6 col-form-label">NID <span class="text-danger">*</span></label>
                                    <div class="col-12 col-sm-6">
                                        <input type="text" id="nid_client" name="nid_client" class="form-control" value="<?= htmlspecialchars($nid_client) ?>">
                                        <small class="text-danger"><?= $errors['nid_client'] ?? '' ?></small>
                                    </div>
                                </div>

                                <div class="form-group row mb-3 align-items-center">
                                    <label for="email" class="col-12 col-sm-6 col-form-label">Email <span class="text-danger">*</span></label>
                                    <div class="col-12 col-sm-6">
                                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
                                        <small class="text-danger"><?= $errors['email'] ?? '' ?></small>
                                    </div>
                                </div>

                                <div class="form-group row mb-3 align-items-center">
                                    <label for="pin_secret" class="col-12 col-sm-6 col-form-label">PIN Secret <span class="text-danger">*</span></label>
                                    <div class="col-12 col-sm-6">
                                        <input type="password" id="pin_secret" name="pin_secret" class="form-control">
                                        <small class="text-danger"><?= $errors['pin_secret'] ?? '' ?></small>
                                    </div>
                                </div>

                                <div class="col-sm-6 d-grid mt-4">
                                    <button  name="btn_valider" type="submit">Accéder au dossier</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </section><!-- /Service Details Section -->

</main>

<?php
include_once("candidate/layouts/footer.php");
?>

</body>

</html>
