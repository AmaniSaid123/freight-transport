<?php
// process_contact.php
session_start();
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../php/function.php';
require_once __DIR__ . '/../services/EmailService.php';

// Headers pour JSON
header('Content-Type: application/json');

// Vérifier que c'est une requête POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Validation des données
$errors = [];

// Nettoyer et valider les données
$nom = trim($_POST['nom'] ?? '');
$email = trim($_POST['email'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$categorie = trim($_POST['categorie'] ?? '');
$sujet = trim($_POST['sujet'] ?? '');
$message = trim($_POST['message'] ?? '');
$ip_address = $_POST['ip_address'] ?? $_SERVER['REMOTE_ADDR'];
$user_agent = $_POST['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'];
$lang = $_POST['lang'] ?? 'fr';

// Validation
if (empty($nom)) {
    $errors['nom'] = 'Le nom est obligatoire';
}

if (empty($email)) {
    $errors['email'] = 'L\'email est obligatoire';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'L\'email n\'est pas valide';
}

if (empty($sujet)) {
    $errors['sujet'] = 'Le sujet est obligatoire';
}

if (empty($message)) {
    $errors['message'] = 'Le message est obligatoire';
} elseif (strlen($message) < 10) {
    $errors['message'] = 'Le message doit contenir au moins 10 caractères';
}

// Si erreurs, retourner les erreurs
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Veuillez corriger les erreurs du formulaire',
        'errors' => $errors
    ]);
    exit;
}

try {
    // Connexion à la base de données
    require_once __DIR__ . '/../param.php';
    $emailService = new EmailService($bdd);

    // Vérifier si la colonne lang existe
    $langColumnExists = false;
    try {
        $checkLang = $bdd->prepare("SHOW COLUMNS FROM contact LIKE 'lang'");
        $checkLang->execute();
        $langColumnExists = (bool) $checkLang->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $langColumnExists = false;
    }

    // Insérer dans la base de données
    if ($langColumnExists) {
        $sql = "INSERT INTO contact (nom, email, telephone, categorie, sujet, message, ip_address, user_agent, lang, statut, priorite, date_creation) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'nouveau', 'normale', NOW())";
    } else {
        $sql = "INSERT INTO contact (nom, email, telephone, categorie, sujet, message, ip_address, user_agent, statut, priorite, date_creation) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'nouveau', 'normale', NOW())";
    }

    $stmt = $bdd->prepare($sql);
    if ($langColumnExists) {
        $result = $stmt->execute([$nom, $email, $telephone, $categorie, $sujet, $message, $ip_address, $user_agent, $lang]);
    } else {
        $result = $stmt->execute([$nom, $email, $telephone, $categorie, $sujet, $message, $ip_address, $user_agent]);
    }

    if ($result) {
        // Envoyer un email de notification (optionnel)
        sendNotificationEmail($emailService, $nom, $email, $sujet, $message);

        echo json_encode([
            'success' => true,
            'message' => 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.'
        ]);
    } else {
        throw new Exception('Erreur lors de l\'enregistrement du message');
    }

} catch (Exception $e) {
    error_log("Erreur traitement contact: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer.'
    ]);
}

/**
 * Envoie un email de notification aux administrateurs
 */
function sendNotificationEmail(EmailService $emailService, $nom, $email, $sujet, $message)
{
    try {
        $to = "contact@votresociete.com"; // Email de notification
        $subject = "Nouveau message de contact: " . $sujet;

        $emailContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #4e73df; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f8f9fa; }
                .message { background: #e9ecef; padding: 15px; margin: 15px 0; border-left: 4px solid #6c757d; }
                .footer { text-align: center; padding: 20px; font-size: 12px; color: #6c757d; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Nouveau message de contact</h1>
                </div>
                <div class='content'>
                    <p><strong>De:</strong> $nom ($email)</p>
                    <p><strong>Sujet:</strong> $sujet</p>
                    
                    <div class='message'>
                        <strong>Message:</strong><br>
                        " . nl2br(htmlspecialchars($message)) . "
                    </div>
                    
                    <p><strong>Date:</strong> " . date('d/m/Y à H:i') . "</p>
                    <p><strong>IP:</strong> " . ($_POST['ip_address'] ?? $_SERVER['REMOTE_ADDR']) . "</p>
                </div>
                <div class='footer'>
                    <p>Cet email a été généré automatiquement par le formulaire de contact.</p>
                </div>
            </div>
        </body>
        </html>";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@votresociete.com" . "\r\n";
        $headers .= "Reply-To: $email" . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        $emailService->sendHtmlEmail($to, $subject, $emailContent, $headers);

    } catch (Exception $e) {
        error_log("Erreur envoi notification contact: " . $e->getMessage());
    }
}
?>
