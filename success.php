<?php

global $bdd;
// Inclusion des fonctions et paramètres
include_once("php/function.php");
include("param.php");
require 'vendor/autoload.php'; // Charge Stripe
require 'env.php';


load_env();
\Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

$sessionId = $_GET['session_id'] ?? null;
$customerData = [];

if ($sessionId) {
    try {
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        // Vérifiez si un client est associé à la session
        if (!empty($session->customer)) {
            $customer = \Stripe\Customer::retrieve($session->customer);

            $customerData = [
                'Nom complet' => $customer->name ?? 'Non disponible',
                'Email' => $customer->email ?? 'Non disponible',
                'Téléphone' => $customer->phone ?? 'Non disponible',
                'Montant payé (€)' => number_format($session->amount_total / 100, 2),
                'Devise' => strtoupper($session->currency),
                'Date de paiement' => date('d/m/Y H:i:s', $session->created),
            ];
        } else {
            // Si pas de customer, utilisez uniquement les infos de session
            $customerData = [
                'Montant payé (€)' => number_format($session->amount_total / 100, 2),
                'Devise' => strtoupper($session->currency),
                'Date de paiement' => date('d/m/Y H:i:s', $session->created),
                'Email (via paiement)' => $session->customer_details->email ?? 'Non disponible',
            ];
        }
    } catch (\Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php
include_once("candidate/layouts/head.php");
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>

    .success-icon {
        font-size: 60px;
        color: #28a745;
    }
</style>
<body>
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
                        <h2 class="heading-title">Le paiement a été effectuée avec succès</h2>

                    </div>
                </div>
            </div>
        </div>

    </div><!-- End Page Title -->

    <!-- Service Details Section -->
    <section id="service-details" class="service-details section payment">

        <div class="container">

            <div class="row gy-4">
                <div class="row justify-content-center">
                    <div class="col-lg-8 py-5 py-xl-5 py-xxl-7 col-payment section-title">
                        <h2>Détails du paiement <br></h2>
                        <div class="pt-5 p-4">


                            <i class="fas fa-check-circle success-icon"></i>
                            <h1>Merci !</h1>
                            <p>Votre paiement a été effectué avec succès.</p>


                            <?php if (!empty($customerData)): ?>
                                <table class="table table-bordered mt-3">
                                    <tbody>
                                    <?php foreach ($customerData as $label => $value): ?>
                                        <tr>
                                            <th><?= htmlspecialchars($label) ?></th>
                                            <td><?= htmlspecialchars($value) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>Aucune donnée client disponible.</p>
                            <?php endif; ?>
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
