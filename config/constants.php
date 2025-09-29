<?php
// Détection de l'environnement local
$isLocal = ($_SERVER['SERVER_NAME'] === 'localhost' || php_sapi_name() === 'cli-server');

// Récupère le dossier courant du script
$scriptName = $_SERVER['SCRIPT_NAME']; // ex: /backend/index.php ou /index.php
$firstFolder = explode('/', trim($scriptName, '/'))[0] ?? '';

// Définition de BASE_URL
if (!defined('BASE_URL')) {
    if ($firstFolder === 'backend') {
        define('BASE_URL', $isLocal ? '/backend/' : '/backend/');
    } else {
        define('BASE_URL', $isLocal ? '/' : '/');
    }
}


