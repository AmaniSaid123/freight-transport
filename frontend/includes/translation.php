<?php

function getBrowserLanguage(): string
{
    if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) return 'fr';
    $lang = substr(explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])[0], 0, 2);
    return in_array($lang, ['fr','en']) ? $lang : 'fr';
}

$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? getBrowserLanguage();
$_SESSION['lang'] = $lang;

$langFile = __DIR__ . '/../lang/' . $lang . '.php';
$translations = file_exists($langFile) ? include $langFile : include __DIR__ . '/../lang/fr.php';

function t(string $key): string {
    global $translations;
    return $translations[$key] ?? $key;
}
