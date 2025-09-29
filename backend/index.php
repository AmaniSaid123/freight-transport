<?php

//require_once __DIR__ . '/../config/debug.php';  
require_once __DIR__ . '/../config/constants.php';  
$page = $_GET['page'] ?? 'login';
$viewPath = __DIR__ . '/views/pages/' . basename($page) . '.php';

if (file_exists($viewPath)) {
    include $viewPath;
} else {
    http_response_code(404);
    echo "404 - Page not found";
}
