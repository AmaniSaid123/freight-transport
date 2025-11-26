<?php

require_once __DIR__ . '/../ParcelController.php';

$controller = new ParcelController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    $result = $controller->handleCreateParcel($_POST);

    // Si succès, inclure l'ID du colis
    if ($result['success'] && isset($result['parcel_id'])) {
        $result['redirect_url'] = BASE_URL . "views/pages/detail.php?parcel_id=" . $result['parcel_id'];
    }

    echo json_encode($result);
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);