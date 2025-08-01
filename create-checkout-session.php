<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51RCK9BQwCmfrEigZzly9bW9rGX8ur7qwkuckBRrGZvJTgcPuc3exvWKKErx8I5eT2OqbsHuNg4i6eNIxVKUbomF000HlQ6TJQk'); // Remplace par ta clé secrète Stripe

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:8000/'; // ou ton domaine réel

$checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'Nom du produit',
            ],
            'unit_amount' => 2000, // 20.00€ (en centimes)
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . '/success.html',
    'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);

echo json_encode(['id' => $checkout_session->id]);
