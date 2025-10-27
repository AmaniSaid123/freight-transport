<?php
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../php/function.php';
require_once __DIR__ . '/../services/EmailService.php';

session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header(header: 'HTTP/1.1 401 Unauthorized');
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

$mail_id = isset($_POST['mail_id']) ? (int)$_POST['mail_id'] : 0;

if ($mail_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID d\'email invalide']);
    exit;
}

try {
    $emailService = new EmailService($bdd);
    $result = $emailService->sendEmail($mail_id);
    
    header('Content-Type: application/json');
    echo json_encode($result);
    
} catch (Exception $e) {
    error_log("Erreur envoi email: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur système: ' . $e->getMessage()]);
}
?>