<?php
require_once __DIR__ . '/../../../../services/EmailService.php';

class ContactController {
    private $model;
    private $current_user_id;
    private $emailService;
    
    public function __construct($database, $user_id, EmailService $emailService = null) {
        $this->model = new Contact($database);
        $this->current_user_id = $user_id;
        $this->emailService = $emailService ?: new EmailService($database);
    }

    /**
     * Récupère tous les contacts avec filtres
     */
    public function getAllContacts($filters = []) {
        return $this->model->getAllContacts($filters);
    }

    /**
     * Récupère un contact par son ID
     */
    public function getContactById($id) {
        return $this->model->getContactById($id);
    }

    /**
     * Met à jour le statut d'un contact
     */
    public function updateContactStatus($contact_id, $statut) {
        try {
            $result = $this->model->updateStatus($contact_id, $statut, $this->current_user_id);
            
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Statut mis à jour avec succès'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour du statut'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Ajoute une réponse à un contact
     */
    public function addResponse($contact_id, $reponse, $email_subject = null) {
        try {
            $contact = $this->model->getContactById($contact_id);
            if (!$contact) {
                return [
                    'success' => false,
                    'message' => 'Contact non trouvé'
                ];
            }

            $payload = $this->resolveEmailPayload($contact, $reponse, $email_subject);

            // Valider la réponse
            if (empty(trim($payload['body_text']))) {
                return [
                    'success' => false,
                    'message' => 'La réponse ne peut pas être vide'
                ];
            }

            $result = $this->model->addResponse($contact_id, $payload['body_text'], $this->current_user_id);
            
            if ($result) {
                // Envoyer l'email de réponse
                $emailResult = $this->sendResponseEmail($contact_id, $reponse, $email_subject);

                if (!$emailResult['success']) {
                    return [
                        'success' => false,
                        'message' => 'Réponse enregistrée, mais l\'email n\'a pas été envoyé : ' . ($emailResult['message'] ?? 'Erreur inconnue')
                    ];
                }

                return [
                    'success' => true,
                    'message' => 'Réponse envoyée avec succès'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erreur lors de l\'enregistrement de la réponse'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Ajoute une note interne
     */
    public function addInternalNote($contact_id, $note) {
        try {
            if (empty(trim($note))) {
                return [
                    'success' => false,
                    'message' => 'La note ne peut pas être vide'
                ];
            }

            $note_with_user = date('d/m/Y H:i') . " - " . $_SESSION['my_username'] . ": " . $note;
            $result = $this->model->addInternalNote($contact_id, $note_with_user, $this->current_user_id);
            
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Note ajoutée avec succès'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erreur lors de l\'ajout de la note'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Envoie un email de réponse
     */
    private function sendResponseEmail($contact_id, $reponse, $email_subject = null) {
        try {
            $contact = $this->model->getContactById($contact_id);
            if (!$contact) {
                return ['success' => false, 'message' => 'Contact non trouvé'];
            }

            $payload = $this->resolveEmailPayload($contact, $reponse, $email_subject);

            $to = trim((string) ($contact['email'] ?? ''));
            if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => 'Email du contact invalide'];
            }

            $subject = $this->sanitizeEmailHeader($payload['subject']);
            $subject = $this->encodeEmailSubject($subject);
            $message = $this->buildResponseEmail($contact, $payload);
            $headers = $this->buildEmailHeaders();

            $sendResult = $this->emailService->sendHtmlEmail($to, $subject, $message, $headers);
            return $sendResult['success'] ? ['success' => true, 'message' => 'Email envoyé'] : $sendResult;
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }
    }

    /**
     * Construit le contenu de l'email de réponse
     */
    private function buildResponseEmail($contact, $payload) {
        $title = $payload['title'];
        $bodyHtml = $payload['body_html'];
        $language = $payload['language'];
        $dateLabel = date('d/m/Y à H:i', strtotime($contact['date_creation']));
        $year = date('Y');

        if ($language === 'en') {
            $greeting = "Hello " . htmlspecialchars($contact['nom']) . ",";
            $intro = "Thank you for contacting us. Here is our reply:";
            $originalTitle = "Your original message:";
            $closing = "Best regards,<br>The support team";
            $footer = "This email is a response to your message on " . $dateLabel . ".";
        } else {
            $greeting = "Bonjour " . htmlspecialchars($contact['nom']) . ",";
            $intro = "Nous vous remercions de nous avoir contactés. Voici notre réponse :";
            $originalTitle = "Votre message original :";
            $closing = "Cordialement,<br>L'équipe du support";
            $footer = "Cet email est une réponse à votre message du " . $dateLabel . ".";
        }

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
                .original-message { background: #e9ecef; padding: 15px; margin: 15px 0; border-left: 4px solid #6c757d; }
                .response { background: #d4edda; padding: 15px; margin: 15px 0; border-left: 4px solid #28a745; }
                .footer { text-align: center; padding: 20px; font-size: 12px; color: #6c757d; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>" . htmlspecialchars($title) . "</h1>
                </div>
                <div class='content'>
                    <p>" . $greeting . "</p>
                    
                    <p>" . $intro . "</p>
                    
                    <div class='response'>
                        " . $bodyHtml . "
                    </div>
                    
                    <div class='original-message'>
                        <strong>" . $originalTitle . "</strong><br>
                        " . nl2br(htmlspecialchars($contact['message'])) . "
                    </div>
                    
                    <p>" . $closing . "</p>
                </div>
                <div class='footer'>
                    <p>" . $footer . "</p>
                    <p>&copy; " . $year . " Votre Société. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>";

        return $template;
    }

    private function resolveEmailPayload($contact, $payload, $email_subject = null)
    {
        $language = 'fr';
        $title = '';
        $subject = '';
        $contentHtml = '';

        if (is_array($payload)) {
            $language = trim((string)($payload['language'] ?? 'fr'));
            if (!in_array($language, ['fr', 'en'], true)) {
                $language = 'fr';
            }

            $titleFr = trim((string)($payload['title_fr'] ?? ''));
            $titleEn = trim((string)($payload['title_en'] ?? ''));
            $subjectFr = trim((string)($payload['subject_fr'] ?? ''));
            $subjectEn = trim((string)($payload['subject_en'] ?? ''));

            $contentFr = (string)($payload['content_fr'] ?? '');
            $contentEn = (string)($payload['content_en'] ?? '');

            $contentHtml = $language === 'en' ? $contentEn : $contentFr;

            $title = $language === 'en' ? $titleEn : $titleFr;
            if ($title === '') {
                $title = $language === 'en' ? 'Reply to your message' : 'Réponse à votre message';
            }

            $subject = $language === 'en' ? $subjectEn : $subjectFr;
        } else {
            $contentHtml = (string)$payload;
        }

        $subject = trim((string)($subject ?: $email_subject));
        if ($subject === '') {
            $subject = 'Re: ' . ($contact['sujet'] ?? '');
        }

        $contentHtml = trim($contentHtml);
        $bodyText = trim(strip_tags($contentHtml));

        return [
            'language' => $language,
            'title' => $title ?: 'Réponse à votre message',
            'subject' => $subject,
            'body_html' => $contentHtml !== '' ? $contentHtml : nl2br(htmlspecialchars($bodyText)),
            'body_text' => $bodyText
        ];
    }

    /**
     * Construit les headers de l'email
     */
    private function buildEmailHeaders() {
        $from = $this->resolveFromAddress();
        $replyTo = $this->resolveReplyToAddress($from);

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: " . $from . "\r\n";
        $headers .= "Reply-To: " . $replyTo . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        return $headers;
    }

    private function resolveFromAddress()
    {
        $candidates = [
            getenv('MAIL_FROM') ?: null,
            defined('MAIL_FROM_ADDRESS') ? MAIL_FROM_ADDRESS : null,
            defined('CONTACT_EMAIL') ? CONTACT_EMAIL : null,
            getenv('CONTACT_EMAIL') ?: null
        ];

        foreach ($candidates as $candidate) {
            if ($candidate && filter_var($candidate, FILTER_VALIDATE_EMAIL)) {
                return $candidate;
            }
        }

        $host = $this->resolveHostDomain();
        if ($host === null) {
            return 'no-reply@localhost';
        }

        return 'no-reply@' . $host;
    }

    private function resolveReplyToAddress($fallback)
    {
        $candidate = getenv('MAIL_REPLY_TO') ?: null;
        if (!$candidate && defined('MAIL_REPLY_TO')) {
            $candidate = MAIL_REPLY_TO;
        }

        if ($candidate && filter_var($candidate, FILTER_VALIDATE_EMAIL)) {
            return $candidate;
        }

        return $fallback ?: 'no-reply@localhost';
    }

    private function resolveHostDomain()
    {
        $host = $_SERVER['SERVER_NAME'] ?? ($_SERVER['HTTP_HOST'] ?? '');
        $host = strtolower(trim($host));
        $host = preg_replace('/:\d+$/', '', $host);
        $host = preg_replace('/^www\./', '', $host);

        if ($host === '' || $host === 'localhost' || $host === '127.0.0.1') {
            return null;
        }

        return $host;
    }

    private function sanitizeEmailHeader($value)
    {
        $value = trim((string) $value);
        return preg_replace("/\r|\n/", ' ', $value);
    }

    private function encodeEmailSubject($subject)
    {
        if (function_exists('mb_encode_mimeheader')) {
            return mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n");
        }

        return $subject;
    }

    /**
     * Récupère les statistiques
     */
    public function getStats() {
        return $this->model->getStats();
    }

    /**
     * Récupère les catégories
     */
    public function getCategories() {
        return $this->model->getCategories();
    }

    /**
     * Formate la date pour l'affichage
     */
    public function formatDate($date) {
        if (empty($date) || $date === '0000-00-00 00:00:00') {
            return '<span class="text-muted">-</span>';
        }
        
        $dateTime = new DateTime($date);
        $now = new DateTime();
        $interval = $now->diff($dateTime);
        
        if ($interval->days == 0) {
            return 'Aujourd\'hui ' . $dateTime->format('H:i');
        } elseif ($interval->days == 1) {
            return 'Hier ' . $dateTime->format('H:i');
        } elseif ($interval->days < 7) {
            return 'Il y a ' . $interval->days . ' jour(s)';
        } else {
            return $dateTime->format('d/m/Y H:i');
        }
    }

    /**
     * Retourne le badge pour le statut
     */
    public function getStatusBadge($statut) {
        $badges = [
            'nouveau' => 'danger',
            'lu' => 'info',
            'en_cours' => 'warning',
            'repondu' => 'success',
            'ferme' => 'secondary'
        ];
        
        $labels = [
            'nouveau' => 'Nouveau',
            'lu' => 'Lu',
            'en_cours' => 'En cours',
            'repondu' => 'Répondu',
            'ferme' => 'Fermé'
        ];
        
        $class = $badges[$statut] ?? 'secondary';
        $label = $labels[$statut] ?? $statut;
        
        return '<span class="badge badge-' . $class . '">' . $label . '</span>';
    }

    /**
     * Retourne le badge pour la priorité
     */
    public function getPriorityBadge($priorite) {
        $badges = [
            'basse' => 'secondary',
            'normale' => 'info',
            'haute' => 'warning',
            'urgente' => 'danger'
        ];
        
        $labels = [
            'basse' => 'Basse',
            'normale' => 'Normale',
            'haute' => 'Haute',
            'urgente' => 'Urgente'
        ];
        
        $class = $badges[$priorite] ?? 'secondary';
        $label = $labels[$priorite] ?? $priorite;
        
        return '<span class="badge badge-' . $class . '">' . $label . '</span>';
    }

    /**
     * Raccourcit le texte
     */
    public function shortenText($text, $length = 100) {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }
}
?>
