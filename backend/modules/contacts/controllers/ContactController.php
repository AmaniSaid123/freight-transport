<?php
class ContactController {
    private $model;
    private $current_user_id;
    
    public function __construct($database, $user_id) {
        $this->model = new Contact($database);
        $this->current_user_id = $user_id;
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
    public function addResponse($contact_id, $reponse) {
        try {
            // Valider la réponse
            if (empty(trim($reponse))) {
                return [
                    'success' => false,
                    'message' => 'La réponse ne peut pas être vide'
                ];
            }

            $result = $this->model->addResponse($contact_id, $reponse, $this->current_user_id);
            
            if ($result) {
                // Envoyer l'email de réponse
                $emailResult = $this->sendResponseEmail($contact_id, $reponse);
                
                return [
                    'success' => true,
                    'message' => 'Réponse envoyée avec succès' . ($emailResult['success'] ? '' : ' (mais erreur d\'envoi email)')
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
    private function sendResponseEmail($contact_id, $reponse) {
        try {
            $contact = $this->model->getContactById($contact_id);
            if (!$contact) {
                return ['success' => false, 'message' => 'Contact non trouvé'];
            }

            $to = $contact['email'];
            $subject = "Re: " . $contact['sujet'];
            $message = $this->buildResponseEmail($contact, $reponse);
            $headers = $this->buildEmailHeaders();

            if (mail($to, $subject, $message, $headers)) {
                return ['success' => true, 'message' => 'Email envoyé'];
            } else {
                return ['success' => false, 'message' => 'Erreur d\'envoi email'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }
    }

    /**
     * Construit le contenu de l'email de réponse
     */
    private function buildResponseEmail($contact, $reponse) {
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
                    <h1>Réponse à votre message</h1>
                </div>
                <div class='content'>
                    <p>Bonjour " . htmlspecialchars($contact['nom']) . ",</p>
                    
                    <p>Nous vous remercions de nous avoir contactés. Voici notre réponse :</p>
                    
                    <div class='response'>
                        " . nl2br(htmlspecialchars($reponse)) . "
                    </div>
                    
                    <div class='original-message'>
                        <strong>Votre message original :</strong><br>
                        " . nl2br(htmlspecialchars($contact['message'])) . "
                    </div>
                    
                    <p>Cordialement,<br>L'équipe du support</p>
                </div>
                <div class='footer'>
                    <p>Cet email est une réponse à votre message du " . date('d/m/Y à H:i', strtotime($contact['date_creation'])) . ".</p>
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
    private function buildEmailHeaders() {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: support@votresociete.com" . "\r\n";
        $headers .= "Reply-To: no-reply@votresociete.com" . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        return $headers;
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