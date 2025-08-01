<?php
// webhook.php
\Stripe\Stripe::setApiKey('sk_test_51RCK9BQwCmfrEigZzly9bW9rGX8ur7qwkuckBRrGZvJTgcPuc3exvWKKErx8I5eT2OqbsHuNg4i6eNIxVKUbomF000HlQ6TJQk');

$endpoint_secret = 'whsec_XXXXXXX'; // À configurer sur Stripe Dashboard

$payload = @file_get_contents("php://input");
$sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];

$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch(Exception $e) {
    http_response_code(400);
    exit();
}

if ($event->type == 'checkout.session.completed') {
    $session = $event->data->object;
    // Ici, tu peux enregistrer le paiement dans ta base de données
}

http_response_code(200);
