<?php
// frontend/index.php

// Récupère la page demandée dans l'URL (ex: ?page=homepage)
$page = $_GET['page'] ?? 'homepage';

// Définit le chemin des vues
$viewPath = __DIR__ . '/views/pages/' . $page . '.php';

echo($viewPath);

// Vérifie si la vue existe
if (file_exists($viewPath)) {
    include $viewPath;
} else {
    http_response_code(404);
    echo "404 - Page not found";
}
