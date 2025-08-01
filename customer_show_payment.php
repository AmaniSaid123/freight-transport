<?php
session_start();
if (isset($_SESSION['my_doc_online'])) {
    session_unset();
    session_destroy();
}
global $bdd;
// Inclusion des fonctions et paramètres
include_once("php/function.php");
include("param.php");
require 'vendor/autoload.php'; // Charge Stripe
require 'env.php';

load_env();
\Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

$errors = [];

$nid_client = clean_in_text($_POST['nid_client'] ?? '');
$email = clean_in_text($_POST['email'] ?? '');
$identite = clean_in_text($_POST['identite'] ?? '');
$commentaire = clean_in_text($_POST['commentaire'] ?? '');
$montant = clean_in_double($_POST['montant'] ?? 0);
$ref_operation = $_POST['ref_operation'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_add_paiement'])) {
    // Validations
    if (empty($email)) {
        $errors['email'] = "L'adresse email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse email n'est pas valide.";
    }

    if ($montant <= 0) {
        $errors['montant'] = "Le montant doit être supérieur à 0.";
    }

    if (empty($nid_client) && empty($identite)) {
        $errors['identite'] = "Le nom complet est requis si vous n'avez pas de dossier.";
    }

    // Vérification du NID si fourni
    $ref_dossier = null;
    $full_name = $identite;

    if (!empty($nid_client)) {
        $data_dossier = get_dossier_data_by_ndel($nid_client);
        if (!$data_dossier) {
            $errors['nid_client'] = "Aucun dossier trouvé pour le NID fourni.";
        } else {
            $ref_dossier = $data_dossier['idt_dossier'];
            $full_name = $data_dossier['identite'];
        }
    }


    if ($ref_operation === '') {
        $errors['ref_operation'] = "Veuillez sélectionner une opération.";
    } elseif ($ref_operation === 'autre') {
        $autre_operation = clean_in_text($_POST['autre_operation'] ?? '');
        if (empty($autre_operation)) {
            $errors['autre_operation'] = "Veuillez préciser l'opération.";
        }
    }


    // Si pas d'erreurs, procéder au paiement
    if (empty($errors)) {
        try{
            if($ref_operation === 'autre') {
                $data_operation = trim($autre_operation);
                $add_paiement = add_online_payment(
                    $ref_dossier,
                    null,
                    $data_operation,
                    $montant,
                    $full_name,
                    null,
                    $commentaire,
                    $email
                );
                $subject = $data_operation;
            } else {

                $data_operation = get_operation_data($ref_operation);
                $add_paiement = add_online_payment(
                    $ref_dossier,
                    $ref_operation,
                    null,
                    $montant,
                    $full_name,
                    null,
                    $commentaire,
                    $email
                );
                $subject = $data_operation['label'];
            }
            $libelle = $full_name . ($nid_client ? " : " . $nid_client : '');
            $YOUR_DOMAIN = 'http://localhost:8000/';

            if ($add_paiement) {
                if (!empty($email)) {
                    $text_message = $commentaire;
                    $to_destination = $email;
                    $sujet = $subject;
                    include("sendmail_info_client.php");
                }

                try {
                    $session = \Stripe\Checkout\Session::create([
                        'payment_method_types' => ['card'],
                        'line_items' => [[
                            'price_data' => [
                                'currency' => 'eur',
                                'product_data' => [
                                    'name' => $subject ?? 'Paiement MyPass',
                                ],
                                'unit_amount' => intval($montant * 100),
                            ],
                            'quantity' => 1,
                        ]],
                        'mode' => 'payment',
                        'success_url' => $YOUR_DOMAIN . '/success.php',
                        'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
                    ]);

                    header('Location: ' . $session->url);
                    exit;
                } catch (Exception $e) {
                    $errors['stripe'] = "Erreur Stripe : " . $e->getMessage();
                }
            } else {
                $errors['auth'] = "Une erreur est survenue lors de l'enregistrement du paiement.";
            }
        } catch (Exception $e) {
            error_log("Payment processing error: " . $e->getMessage());
            $errors['processing'] = "An error occurred: " . $e->getMessage();
        }

    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once("customer/layouts/head.php"); ?>
</head>
<body>
<main class="main" id="top">
    <?php include_once("customer/layouts/header.php"); ?>

    <section class="mt-7 py-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 py-5 py-xl-5 py-xxl-7">
                    <div class="pt-5 p-4 border rounded shadow-sm bg-light">
                        <h1 class="text-primary fw-bold text-center">Effectuer Votre Paiement</h1>

                        <?php if (!empty($errors['auth']) || !empty($errors['stripe'])): ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($errors['auth'] ?? $errors['stripe']) ?>
                            </div>
                        <?php endif; ?>

                        <form class="row g-4 mt-3" method="POST">
                            <!-- Question avec checkbox -->
                            <div class="form-group row mb-3 align-items-center">
                                <label for="hasDossier" class="col-12 col-sm-6 col-form-label">Vous avez déjà un dossier MyPass ?</label>
                                <div class="col-12 col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="dossierCheck" <?= !empty($nid_client) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="dossierCheck">Oui</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Champ conditionnel NID -->
                            <div class="form-group row mb-3 align-items-center" id="nidContainer" style="<?= empty($nid_client) ? 'visibility: hidden; opacity: 0; height: 0;' : 'visibility: visible; opacity: 1; height: auto;' ?> transition: opacity 0.3s ease;">
                                <label for="inputNid" class="col-12 col-sm-6 col-form-label">NID</label>
                                <div class="col-12 col-sm-6">
                                    <input type="text" id="nid_client" name="nid_client" class="form-control" value="<?= htmlspecialchars($nid_client) ?>">
                                    <?php if (!empty($errors['nid_client'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($errors['nid_client']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Champ Email -->
                            <div class="form-group row mb-3 align-items-center">
                                <label for="email" class="col-12 col-sm-6 col-form-label">Email <span class="text-danger">*</span></label>
                                <div class="col-12 col-sm-6">
                                    <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
                                    <?php if (!empty($errors['email'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($errors['email']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Champ Identité -->
                            <div class="form-group row mb-3 align-items-center">
                                <label for="identite" class="col-12 col-sm-6 col-form-label">Noms au complet<span class="text-danger">*</span></label>
                                <div class="col-12 col-sm-6">
                                    <input type="text" id="identite" name="identite" class="form-control" value="<?= htmlspecialchars($identite) ?>">
                                    <?php if (!empty($errors['identite'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($errors['identite']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Champ Montant -->
                            <div class="form-group row mb-3 align-items-center">
                                <label for="montant" class="col-12 col-sm-6 col-form-label">Montant <span class="text-danger">*</span></label>
                                <div class="col-12 col-sm-6">
                                    <input type="number" id="montant" name="montant" class="form-control"" value="<?= htmlspecialchars($montant) ?>">
                                    <small class="text-danger"><?= $errors['montant'] ?? '' ?></small>
                                </div>
                            </div>


                            <div class="form-group row mb-3 align-items-center">
                                <label for="operation" class="col-12 col-sm-6 col-form-label">Sélectionnez une opération <span class="text-danger">*</span></label>
                                <div class="col-12 col-sm-6">
                                    <select id="operation" name="ref_operation" class="form-control">
                                        <option value="">-- Sélectionnez --</option>
                                        <?php echo get_operation_customer($_POST['ref_operation'] ?? ''); ?>
                                        <option value="autre" <?= ($_POST['ref_operation'] ?? '') === 'autre' ? 'selected' : '' ?>>Autre</option>
                                    </select>
                                    <small class="text-danger"><?= $errors['ref_operation'] ?? '' ?></small>
                                </div>
                            </div>

                            <div id="autreOperationContainer" class="form-group row mb-3 align-items-center" style="<?= ($_POST['ref_operation'] ?? '') === 'autre' ? 'display: flex;' : 'display: none;' ?>">
                                <label for="autre_operation" class="col-12 col-sm-6 col-form-label">Précisez l’opération</label>
                                <div class="col-12 col-sm-6">
                                    <input type="text" id="autre_operation" name="autre_operation" class="form-control"
                                           value="<?= htmlspecialchars($_POST['autre_operation'] ?? '') ?>">
                                    <small class="text-danger"><?= $errors['autre_operation'] ?? '' ?></small>
                                </div>
                            </div>
                            <!-- Champ Commentaire -->
                            <div class="form-group row mb-3 align-items-center">
                                <label for="commentaire" class="col-12 col-sm-6 col-form-label">Commentaire</label>
                                <div class="col-12 col-sm-6">
                                    <textarea id="commentaire" name="commentaire" class="form-control" rows="4"><?= htmlspecialchars($commentaire) ?></textarea>
                                </div>
                            </div>

                            <!-- Bouton de soumission -->
                            <div class="col-sm-3 d-grid mt-4">
                                <button class="btn btn-secondary" name="submit_add_paiement" type="submit">Suivant</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include_once("customer/layouts/footer.php"); ?>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dossierCheck = document.getElementById("dossierCheck");
        const nidContainer = document.getElementById("nidContainer");

        dossierCheck.addEventListener("change", function() {
            if (this.checked) {
                nidContainer.style.visibility = "visible";
                nidContainer.style.opacity = "1";
                nidContainer.style.height = "auto";
            } else {
                nidContainer.style.visibility = "hidden";
                nidContainer.style.opacity = "0";
                nidContainer.style.height = "0";
            }
        });
    });

    document.getElementById('operation').addEventListener('change', function () {
        const autreContainer = document.getElementById('autreOperationContainer');
        if (this.value === 'autre') {
            autreContainer.style.display = 'flex';
        } else {
            autreContainer.style.display = 'none';
        }
    });
</script>

<?php include_once("customer/layouts/script.php"); ?>
</body>
</html>