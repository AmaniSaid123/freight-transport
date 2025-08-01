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

                header("Location: modification-dossier.php?msg=Vous êtes connecté à votre compte&success=ok");
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
<html lang="fr">


<?php include_once "customer/layouts/head.php"; ?>

<body>
<main class="main" id="top">

    <head>
        <?php include_once "customer/layouts/header.php"; ?>
    </head>
    <section class="mt-7 py-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 py-5 py-xl-5 py-xxl-7">
                    <div class="pt-5 p-4 border rounded shadow-sm bg-light">
                        <h1 class="text-primary fw-bold text-center">Accéder au dossier</h1>

                        <?php if (!empty($errors['auth'])): ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($errors['auth']) ?>
                            </div>
                        <?php endif; ?>

                        <form class="row g-4 mt-3" method="POST">

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
                                <button type="submit" name="btn_valider" class="btn btn-secondary">Accéder au dossier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <section class="mt-7 py-0">
    </section>


    <?php
    include_once("customer/layouts/footer.php");
    ?>

</main>

<?php
include_once("customer/layouts/script.php");
?>
</body>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</html>
