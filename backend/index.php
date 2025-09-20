<?php
//require __DIR__ . '/../config/debug.php';

// Détruire la session si existante
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>MyPASS Portal</title>
    <link rel="stylesheet" href="../backend/assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .error {
            color: red;
            margin: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="logo">
            <h1>TrustedCargo</h1>
            <p>Solutions logistiques pour fret aérien et maritime</p>
        </div>

        <form method="post" action="../authentification.php">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Nom d'utilisateur" name="login" required>
            </div>

            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Mot de passe" name="pwd" required>
            </div>


            <button type="submit" class="btn" name="valider">Se connecter</button>

            <div class="security-note">
                <i class="fas fa-shield-alt"></i> Système sécurisé de gestion logistique
            </div>


        </form>
    </div>


    <?php
    // Gestion des messages d'erreur
    $errorMessages = [
        'auth_failed' => "Mot de Passe ou nom d'utilisateur incorrect",
        'login' => "Veuillez vous reconnecter d'abord",
        'inactivity' => "Votre Session a pris fin pour non utilisation au dela de 3 heures",
        'autorisation' => "Votre profile n'a pas le droit d'accéder à cette page",
        'acces_caisse' => "Désolé vous devez avoir un accès caisse pour accéder à cette page"
    ];

    if (isset($_GET['error']) && isset($errorMessages[$_GET['error']])) {
        echo '<div class="error">' . $errorMessages[$_GET['error']] . '</div>';
    }
    ?>

</body>

</html>