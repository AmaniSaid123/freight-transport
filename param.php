<?php
// param.php — connexion PDO + mysqli (compatibilité legacy)

// config
$dbHost = '127.0.0.1';
$dbName = 'passport';
$dbUser = 'root';
$dbPass = 'root';

// PDO (pour nouveau code)
try {
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $bdd = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (PDOException $e) {
    error_log("PDO connexion failed: " . $e->getMessage());
    die('Erreur de connexion à la base de données (PDO).');
}

// mysqli (pour fonctions existantes qui utilisent mysqli / $bdd_i)
$bdd_i = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (!$bdd_i) {
    error_log("mysqli connexion failed: " . mysqli_connect_error());
    die('Erreur de connexion à la base de données (mysqli).');
}
mysqli_set_charset($bdd_i, 'utf8mb4');
