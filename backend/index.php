<?php

require_once __DIR__ . '/../config/constants.php';

// Get the requested page and module (example: ?module=profiles&page=list)
$module = $_GET['module'] ?? null;
$page   = $_GET['page'] ?? 'login';

// Build the correct path depending on whether a module is specified
if ($module) {
    $viewPath = __DIR__ . "/modules/{$module}/views/" . basename($page) . ".php";
} else {
    $viewPath = __DIR__ . "/views/pages/" . basename($page) . ".php";
}

// Load the view if it exists
if (file_exists($viewPath)) {
    include $viewPath;
} else {
    http_response_code(404);
    echo "404 - Page not found: <strong>" . htmlspecialchars($viewPath) . "</strong>";
}