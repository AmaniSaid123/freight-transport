
<?php

require __DIR__ . '/../../../config/debug.php';
require_once __DIR__ . '/../../../php/function.php';
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../../config/constants.php';
}
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['my_userId'])) {
    $userId = $_SESSION['my_userId']; // int
    $username = $_SESSION['my_username']; // string

    // Log la déconnexion
    /*add_notification(
        $bdd,
        "t_user",    // ref_element
        $userId,     // id_element (int)
        "Déconnexion MyPASS", // before
        "Déconnexion MyPASS", // after
        $username,   // ref_user
        "Déconnexion MyPASS"  // description
    );*/
}

// Supprimer la session
session_unset();
session_destroy();

// Redirection vers la page login

header('Location: ' . BASE_URL . 'index.php?page=login');
exit;

