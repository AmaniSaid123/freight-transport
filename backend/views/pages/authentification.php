<?php
//******************************************************
//************ Authentification Sécurisée **************
//******************************************************
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../../config/constants.php';
}
// Démarrer la session au tout début
session_start();

require_once __DIR__ . '/../../../php/function.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valider'])) {

    // Validation des champs
    if (empty($_POST['login']) || empty($_POST['pwd'])) {
        $_SESSION['error'] = "Veuillez remplir tous les champs";
        header("Location: login.php?error=empty_fields");
        exit;
    }

    // Nettoyage des données
    $username = htmlspecialchars(trim($_POST['login']));
    $password = $_POST['pwd'];

    // REQUÊTE SÉCURISÉE
    $sql = "SELECT u.*, 
            p.name as profile,
            p.id as idprofile, 
            u.id as iduser
            FROM user u 
            JOIN profile p ON u.id_profile = p.id
            WHERE u.username = ? AND u.status = '1'
            LIMIT 1";

    try {
        $req = $bdd->prepare($sql);
        $req->execute([$username]);
        $user = $req->fetch();

        // VÉRIFICATION AVEC MOT DE PASSE HACHÉ (SÉCURISÉ)
        if ($user && password_verify($password, $user['password'])) {
            
            // Vérifier si le mot de passe doit être re-haché (algorithme obsolète)
            if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                // Mettre à jour le hash dans la base de données
                $updateSql = "UPDATE user SET password = ? WHERE id = ?";
                $updateReq = $bdd->prepare($updateSql);
                $updateReq->execute([$newHash, $user['iduser']]);
            }

            // Initialisation de la session
            $_SESSION['auth'] = true;
            $_SESSION['my_username'] = strtolower($username);
            $_SESSION['my_time'] = date('H:i:s d/m/Y');
            $_SESSION['my_firstname'] = $user['firstname'];
            $_SESSION['my_userId'] = $user['iduser'];
            $_SESSION['my_lastname'] = $user['lastname'];
            $_SESSION['my_user_picture'] = $user['url_picture'];
            $_SESSION['my_profile'] = $user['profile'];
            $_SESSION['my_idprofile'] = $user['idprofile'];
            $_SESSION['is_agent'] = ($user['idprofile'] == 2 ? '1' : '0');

            // Zones par défaut
            $_SESSION['my_zone1'] = 0;
            $_SESSION['my_zone2'] = 0;
            $_SESSION['my_zone3'] = 0;

            // Permissions par défaut
            $_SESSION['my_m_profile'] = "NA";
            $_SESSION['my_m_procedure'] = "NA";
            $_SESSION['my_m_user'] = "NA";
            $_SESSION['my_m_dossier'] = "NA";
            $_SESSION['my_m_dossier_ligne'] = "NA";
            $_SESSION['my_m_lock'] = "NA";

            // Mise à jour dernière connexion
            if (update_user_lastlogon($bdd, $username) > 0) {
                $success_message = "Connexion réussie";
                header("Location: " . BASE_URL . "index.php?page=dashboard&success=ok&msg=$success_message");
                exit;
            } else {
                $_SESSION['error'] = "Erreur de mise à jour du journal";
                $error_message = "Erreur de mise à jour du journal";
                header("Location: " . BASE_URL . "index.php?page=login&error=update_failed&msg=$error_message");
                exit;
            }

        } else {
            // Échec authentification
            $_SESSION['error'] = "Identifiants incorrects";
            $error_message = "Identifiants incorrects";
            header("Location: " . BASE_URL . "index.php?page=login&error=auth_failed&msg=$error_message");
            exit;
        }

    } catch (Exception $e) {
        // Erreur base de données
        error_log("Erreur authentification dans " . __FILE__ . " ligne " . __LINE__ . " : " . $e->getMessage());
        $_SESSION['error'] = "Erreur système temporaire";
        $error_message = "Erreur système temporaire";
        header("Location: " . BASE_URL . "index.php?page=login&error=system_error&msg=$error_message");
        exit;
    }
}

// Accès direct sans formulaire
header('Location: ' . BASE_URL . 'index.php?page=login');
exit;
?>