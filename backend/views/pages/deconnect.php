<?php
if (!defined('BASE_URL')) {
        require_once __DIR__ . '/../../../config/constants.php';
}
session_start();

// Vérifier si la déconnexion est demandée via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    
    // Détruire toutes les variables de session
    $_SESSION = array();

    // Détruire le cookie de session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Détruire la session
    session_destroy();

    // Redirection vers la page de connexion
    header('Location: ' . BASE_URL . 'index.php?page=login');
    exit;
} else {
    // Si accès direct sans formulaire, rediriger vers l'accueil
    header('Location: ' . BASE_URL . 'index.php');
    exit;
}
?>