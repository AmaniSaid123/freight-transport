<?php
class EmailService {
    private $bdd;
    
    public function __construct($database) {
        $this->bdd = $database;
    }

    /**
     * Envoi simple d'un email HTML (pour les usages transactionnels)
     */
    public function sendHtmlEmail($to, $subject, $message, $headers = null)
    {
        try {
            $headersToUse = $headers ?: $this->buildHeaders();
        if ($this->isLocalEnvironment()) {
            // envoi SMTP vers MailDev
            $mailDevResult = $this->sendViaMailDev($to, $subject, $message, $headersToUse);
            if ($mailDevResult['success']) {
                return $mailDevResult;
            }
            // fallback vers mail() si MailDev indisponible
            $sentFallback = mail($to, $subject, $message, $headersToUse);
            if ($sentFallback) {
                return ['success' => true, 'message' => 'Email envoyé (fallback)'];
            }

            $lastError = error_get_last();
            $detail = $lastError['message'] ?? '';
            $fallbackMessage = $mailDevResult['message'] ?? 'Envoi email impossible';
            if ($detail) {
                $fallbackMessage .= ' | mail(): ' . $detail;
            }

            return ['success' => false, 'message' => $fallbackMessage];
        }
            $sent = mail($to, $subject, $message, $headersToUse);
            if (!$sent) {
                $lastError = error_get_last();
                $detail = $lastError['message'] ?? '';
                return [
                    'success' => false,
                    'message' => 'Envoi email impossible' . ($detail ? ' : ' . $detail : '')
                ];
            }

            return ['success' => true, 'message' => 'Email envoyé'];
        } catch (Exception $e) {
            error_log("Erreur envoi à $to: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur système: ' . $e->getMessage()];
        }
    }

    /**
     * Detecte si l'environnement est local
     */
    private function isLocalEnvironment()
    {
        $serverName = strtolower($_SERVER['SERVER_NAME'] ?? '');
        $httpHost = strtolower($_SERVER['HTTP_HOST'] ?? '');
        $host = $serverName ?: $httpHost;
        $env = strtolower(getenv('APP_ENV') ?: (getenv('ENV') ?: ''));

        if (in_array($env, ['local', 'dev', 'development', 'test'], true)) {
            return true;
        }

        if (getenv('MAILDEV_HOST') || getenv('MAILDEV_PORT')) {
            return true;
        }

        if ($host === 'localhost' || $host === '127.0.0.1') {
            return true;
        }

        foreach (['.local', '.test'] as $suffix) {
            if ($host !== '' && substr($host, -strlen($suffix)) === $suffix) {
                return true;
            }
        }

        return php_sapi_name() === 'cli-server';
    }

    /**
     * Envoi SMTP vers MailDev (local)
     */
    private function sendViaMailDev($to, $subject, $message, $headers)
    {
        $host = getenv('MAILDEV_HOST') ?: '127.0.0.1';
        $port = (int) (getenv('MAILDEV_PORT') ?: 1025);
        $timeout = 5;

        $socket = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if (!$socket) {
            return ['success' => false, 'message' => "MailDev indisponible ($errstr:$errno)"];
        }

        stream_set_timeout($socket, $timeout);
        if (!$this->smtpExpectOk($socket)) {
            fclose($socket);
            return ['success' => false, 'message' => 'MailDev: handshake invalide'];
        }

        $this->smtpWrite($socket, 'HELO localhost');
        if (!$this->smtpExpectOk($socket)) {
            fclose($socket);
            return ['success' => false, 'message' => 'MailDev: HELO refuse'];
        }

        $from = $this->extractHeaderEmail($headers, 'From') ?: 'no-reply@localhost';
        $this->smtpWrite($socket, "MAIL FROM:<$from>");
        if (!$this->smtpExpectOk($socket)) {
            fclose($socket);
            return ['success' => false, 'message' => 'MailDev: MAIL FROM refuse'];
        }

        $recipients = $this->normalizeRecipients($to);
        if (empty($recipients)) {
            fclose($socket);
            return ['success' => false, 'message' => 'MailDev: aucun destinataire valide'];
        }

        foreach ($recipients as $recipient) {
            $this->smtpWrite($socket, "RCPT TO:<$recipient>");
            if (!$this->smtpExpectOk($socket)) {
                fclose($socket);
                return ['success' => false, 'message' => "MailDev: RCPT TO refuse ($recipient)"];
            }
        }

        $this->smtpWrite($socket, 'DATA');
        if (!$this->smtpExpectOk($socket)) {
            fclose($socket);
            return ['success' => false, 'message' => 'MailDev: DATA refuse'];
        }

        $rawMessage = $this->buildRawEmailData($to, $subject, $message, $headers);
        $rawMessage = str_replace("\n.", "\n..", $rawMessage);
        fwrite($socket, $rawMessage . "\r\n.\r\n");
        if (!$this->smtpExpectOk($socket)) {
            fclose($socket);
            return ['success' => false, 'message' => 'MailDev: message refuse'];
        }

        $this->smtpWrite($socket, 'QUIT');
        fclose($socket);

        return ['success' => true, 'message' => 'Email envoye (MailDev)'];
    }

    private function buildRawEmailData($to, $subject, $message, $headers)
    {
        $headerLines = $headers ? preg_split("/\r\n|\n|\r/", trim($headers)) : [];
        $hasTo = false;
        $hasSubject = false;

        foreach ($headerLines as $line) {
            if (stripos($line, 'To:') === 0) {
                $hasTo = true;
            } elseif (stripos($line, 'Subject:') === 0) {
                $hasSubject = true;
            }
        }

        if (!$hasTo) {
            array_unshift($headerLines, 'To: ' . $to);
        }
        if (!$hasSubject) {
            array_unshift($headerLines, 'Subject: ' . $subject);
        }

        $body = str_replace(["\r\n", "\r"], "\n", $message);
        $body = str_replace("\n", "\r\n", $body);

        return implode("\r\n", $headerLines) . "\r\n\r\n" . $body;
    }

    private function normalizeRecipients($to)
    {
        $list = is_array($to) ? $to : preg_split('/,/', (string) $to);
        $emails = [];

        foreach ($list as $item) {
            $email = $this->extractEmail($item);
            if ($email) {
                $emails[] = $email;
            }
        }

        return array_values(array_unique($emails));
    }

    private function extractHeaderEmail($headers, $headerName)
    {
        $value = $this->getHeaderValue($headers, $headerName);
        return $value ? $this->extractEmail($value) : null;
    }

    private function getHeaderValue($headers, $headerName)
    {
        if (!$headers) {
            return null;
        }

        $lines = preg_split("/\r\n|\n|\r/", $headers);
        $prefix = strtolower($headerName) . ':';

        foreach ($lines as $line) {
            if (stripos($line, $prefix) === 0) {
                return trim(substr($line, strlen($prefix)));
            }
        }

        return null;
    }

    private function extractEmail($value)
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        if (preg_match('/<([^>]+)>/', $value, $match)) {
            $value = $match[1];
        }

        return filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : null;
    }

    private function smtpWrite($socket, $command)
    {
        fwrite($socket, $command . "\r\n");
    }

    private function smtpExpectOk($socket)
    {
        $response = $this->smtpRead($socket);
        if ($response === '') {
            return false;
        }

        $code = (int) substr($response, 0, 3);
        return $code >= 200 && $code < 400;
    }

    private function smtpRead($socket)
    {
        $response = '';
        while (!feof($socket)) {
            $line = fgets($socket, 515);
            if ($line === false) {
                break;
            }
            $response .= $line;
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }

        return $response;
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
