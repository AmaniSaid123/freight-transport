<?php
require_once __DIR__ . '/../config/constants.php';  


$page = $_GET['page'] ?? 'homepage';

$viewPath = __DIR__ . '/views/pages/' . basename($page) . '.php';
// Vérifie si la vue existe
if (file_exists($viewPath)) {
    include $viewPath;
} else {
    http_response_code(404);
    echo "404 - Page not found";
}
