<?php
class EmailService {
    private $bdd;
    
    public function __construct($database) {
        $this->bdd = $database;
    }

    /**
     * Envoie un email
     */
    public function sendEmail($mailId) {
        try {
            // Récupérer l'email
            $sql = "SELECT * FROM mailing WHERE id = ? AND statut IN ('brouillon', 'programme')";
            $stmt = $this->bdd->prepare($sql);
            $stmt->execute([$mailId]);
            $mail = $stmt->fetch();

            if (!$mail) {
                return ['success' => false, 'message' => 'Email non trouvé ou déjà envoyé'];
            }

            // Récupérer les destinataires
            $recipients = $this->getRecipients($mail);
            if (empty($recipients)) {
                return ['success' => false, 'message' => 'Aucun destinataire trouvé'];
            }

            // Préparer l'email
            $subject = $mail['objet'];
            $message = $this->buildEmailTemplate($mail);
            $headers = $this->buildHeaders();

            // Envoyer l'email
            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            foreach ($recipients as $recipient) {
                if ($this->sendSingleEmail($recipient, $subject, $message, $headers)) {
                    $successCount++;
                } else {
                    $errorCount++;
                    $errors[] = $recipient;
                }
            }

            // Mettre à jour le statut
            $this->updateMailStatus($mailId, $successCount, $errorCount);

            return [
                'success' => true,
                'message' => "Email envoyé à $successCount destinataire(s). Erreurs: $errorCount",
                'success_count' => $successCount,
                'error_count' => $errorCount,
                'errors' => $errors
            ];

        } catch (Exception $e) {
            error_log("Erreur envoi email: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur système: ' . $e->getMessage()];
        }
    }

    /**
     * Récupère la liste des destinataires
     */
    private function getRecipients($mail) {
        switch ($mail['type_destinataires']) {
            case 'tous':
                return $this->getAllUsersEmails();
            case 'specifiques':
                return $this->getSpecificRecipients($mail['destinataires']);
            case 'groupe':
                return $this->getGroupRecipients($mail['destinataires']);
            default:
                return [];
        }
    }

    /**
     * Récupère tous les emails des utilisateurs
     */
    private function getAllUsersEmails() {
        $sql = "SELECT email FROM user WHERE status = 1 AND email IS NOT NULL";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return array_filter($users);
    }

    /**
     * Récupère les destinataires spécifiques
     */
    private function getSpecificRecipients($destinataires) {
        if (empty($destinataires)) return [];
        
        $emails = explode(',', $destinataires);
        return array_map('trim', $emails);
    }

    /**
     * Récupère les destinataires d'un groupe
     */
    private function getGroupRecipients($groupe) {
        // Implémentez la logique pour les groupes
        // Par exemple, récupérer les utilisateurs d'un profil spécifique
        return [];
    }

    /**
     * Construit le template de l'email
     */
    private function buildEmailTemplate($mail) {
        $content = $mail['contenu_fr']; // Utiliser la version française par défaut
        
        $template = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #4e73df; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f8f9fa; }
                .footer { text-align: center; padding: 20px; font-size: 12px; color: #6c757d; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>" . htmlspecialchars($mail['titre_email']) . "</h1>
                </div>
                <div class='content'>
                    " . nl2br($content) . "
                </div>
                <div class='footer'>
                    <p>Cet email a été envoyé via notre plateforme.</p>
                    <p>&copy; " . date('Y') . " Votre Société. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>";

        return $template;
    }

    /**
     * Construit les headers de l'email
     */
    private function buildHeaders() {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@votresociete.com" . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        return $headers;
    }

    /**
     * Envoie un email individuel
     */
    private function sendSingleEmail($to, $subject, $message, $headers) {
        try {
            return mail($to, $subject, $message, $headers);
        } catch (Exception $e) {
            error_log("Erreur envoi à $to: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Met à jour le statut de l'email
     */
    private function updateMailStatus($mailId, $successCount, $errorCount) {
        $statut = $errorCount > 0 ? 'erreur' : 'envoye';
        
        $sql = "UPDATE mailing SET 
                statut = ?,
                date_envoi = NOW(),
                pieces_jointes = CONCAT(IFNULL(pieces_jointes, ''), ' | Envoyé à $successCount, Erreurs: $errorCount')
                WHERE id = ?";
        
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$statut, $mailId]);
    }
}
?>