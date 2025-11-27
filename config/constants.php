<?php
// Détection de l'environnement local
$isLocal = ($_SERVER['SERVER_NAME'] === 'localhost' || php_sapi_name() === 'cli-server');

// Récupère le dossier courant du script
$scriptName = $_SERVER['SCRIPT_NAME']; // ex: /backend/index.php ou /frontend/send-parcel.php
$firstFolder = explode('/', trim($scriptName, '/'))[0] ?? '';

// Définition de BASE_URL si non définie
if (!defined('BASE_URL')) {
    switch ($firstFolder) {
        case 'backend':
            define('BASE_URL', $isLocal ? '/backend/' : '/backend/'); // tu peux adapter le prod ici
            break;
        case 'frontend':
            //define('BASE_URL', $isLocal ? '/' : '/'); // prod
            define('BASE_URL', $isLocal ? '/frontend/' : '/frontend/'); // local ici si différent
            break;
        default:
            define('BASE_URL', $isLocal ? '/' : '/'); // racine si autre dossier
    }
}
