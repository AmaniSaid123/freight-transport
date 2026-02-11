<?php
require_once __DIR__ . '/../../../../services/EmailService.php';

class ParcelController
{
    private $model;
    private $current_user_id;
    private $emailService;

    public function __construct($database, $user_id, ?EmailService $emailService = null)
    {
        $this->model = new Parcel($database);
        $this->current_user_id = $user_id;
        $this->emailService = $emailService ?: new EmailService($database);
    }


    public function emailExists($email, $exclude_id = null)
    {
        return $this->model->emailExists($email, $exclude_id);
    }
    public function updateCustomerRecord($id, $data)
    {
        return $this->model->updateCustomerRecord($id, $data, $this->current_user_id);
    }   
    /**
     * Gère la création d'un nouveau colis (dossier + expéditions)
     */
    public function handleCreateParcel($data)
    {
        $errors = [];

        // Validation des champs requis
        $requiredFields = ['full_name', 'email', 'address'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "Ce champ est obligatoire";
            }
        }

        // Validation email
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Format d'email invalide";
        }

        // Vérifier s'il y a au moins une expédition
        if (empty($data['origin']) || !is_array($data['origin'])) {
            $errors['expeditions'] = "Veuillez ajouter au moins une expédition";
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'message' => 'Veuillez corriger les erreurs du formulaire',
                'errors' => $errors
            ];
        }

        try {
            // Vérifier si l'email existe déjà
            if ($this->model->emailExists($data['email'])) {
                // Client existant : attacher les nouvelles expéditions
                $existing_customer = $this->model->getCustomerRecordByEmail($data['email']);
                $dossier_id = $existing_customer['id'];
                $customer_id = $existing_customer['customer_id'];

                $this->model->beginTransaction();

                // Ajouter les nouvelles expéditions
                $origines = $data['origin'];
                $destinations = $data['destination'];
                $descriptions = $data['description'];
                $comments = $data['commentaire'];

                for ($i = 0; $i < count($origines); $i++) {
                    if (!empty($origines[$i]) && !empty($destinations[$i])) {
                        $ref_expedition = $this->model->generateExpeditionRef($dossier_id, $customer_id);

                        $shipmentData = [
                            'customer_record_id' => $dossier_id,
                            'tracking_reference' => $ref_expedition,
                            'origin' => htmlspecialchars($origines[$i]),
                            'destination' => htmlspecialchars($destinations[$i]),
                            'description' => htmlspecialchars($descriptions[$i] ?? ''),
                            'comment' => htmlspecialchars($comments[$i] ?? '')
                        ];

                        $this->model->createShipment($shipmentData);
                    }
                }

                $this->model->commit();

                return [
                    'success' => true,
                    'message' => 'Nouvelles expéditions ajoutées au dossier existant avec succès',
                    'customer_id' => $customer_id
                ];

            } else {
                // Nouveau client
                $this->model->beginTransaction();

                // Générer la référence dossier
                $customer_id = $this->model->generateRefDossier();

                // Créer le dossier client
                $customerData = [
                    'customer_id' => $customer_id,
                    'full_name' => $data['full_name'],
                    'phone' => $data['phone'] ?? '',
                    'email' => $data['email'],
                    'address' => $data['address']
                ];

                $this->model->createCustomerRecord($customerData);
                $dossier_id = $this->model->getLastInsertId();

                // Créer les expéditions
                $origines = $data['origin'];
                $destinations = $data['destination'];
                $descriptions = $data['description'];
                $comments = $data['commentaire'];

                for ($i = 0; $i < count($origines); $i++) {
                    if (!empty($origines[$i]) && !empty($destinations[$i])) {
                        $ref_expedition = $this->model->generateExpeditionRef($dossier_id, $customer_id);

                        $shipmentData = [
                            'customer_record_id' => $dossier_id,
                            'tracking_reference' => $ref_expedition,
                            'origin' => htmlspecialchars($origines[$i]),
                            'destination' => htmlspecialchars($destinations[$i]),
                            'description' => htmlspecialchars($descriptions[$i] ?? ''),
                            'comment' => htmlspecialchars($comments[$i] ?? '')
                        ];

                        $this->model->createShipment($shipmentData);
                    }
                }

                $this->model->commit();

                return [
                    'success' => true,
                    'message' => 'Dossier et expéditions créés avec succès',
                    'customer_id' => $customer_id
                ];
            }

        } catch (Exception $e) {
            $this->model->rollBack();
            error_log("Erreur création parcel: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Gère la mise à jour du statut d'une expédition
     */
    public function handleUpdateShipmentStatus($shipment_id, $status, $notes = null, $notifications = [])
    {
        try {
            $notes = trim((string)$notes);
            $availableStatuses = $this->getStatusDefinitions();
            if (!isset($availableStatuses[$status])) {
                return [
                    'success' => false,
                    'message' => 'Statut inconnu'
                ];
            }

            $shipment = $this->model->getShipmentById($shipment_id);
           
    
            if (!$shipment) {
                return [
                    'success' => false,
                    'message' => 'Expédition introuvable'
                ];
            }

            $result = $this->model->updateShipmentStatus($shipment_id, $status, $notes, $this->current_user_id);
        
            $emailInfo = null;
         
            if ($result) {
       

                if (!empty($notifications['notify_email'])) {
                    $emailRecipient = $notifications['email_contact'] ?? $shipment['email'];
                    $language = $notifications['email_language'] ?? null;     
                    $emailInfo = $this->sendStatusEmail($status, $shipment, $emailRecipient, $language, $notes);
         
                }


                $message = 'Statut mis à jour avec succèss';
                if ($emailInfo && !$emailInfo['success']) {
                    $message .= ' (email: ' . $emailInfo['message'] . ')';
                } elseif ($emailInfo && $emailInfo['success']) {
                    $message .= ' (email envoyé)';
                }

                return [
                    'success' => true,
                    'message' => $message
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
     * Enregistre un commentaire interne sur une expédition
     */
    public function handleAddInternalComment($shipment_id, $comment)
    {
        if (empty($shipment_id)) {
            return [
                'success' => false,
                'message' => 'Expédition introuvable'
            ];
        }

        $shipment = $this->model->getShipmentById($shipment_id);
        if (!$shipment) {
            return [
                'success' => false,
                'message' => 'Expédition introuvable'
            ];
        }

        $cleanComment = trim($comment ?? '');
        if ($cleanComment === '') {
            return [
                'success' => false,
                'message' => 'Le commentaire ne peut pas être vide'
            ];
        }

        try {
            $this->model->updateShipment(['comment' => $cleanComment], $shipment_id);

            return [
                'success' => true,
                'message' => 'Commentaire interne enregistré'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement du commentaire: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Gère la suppression d'un dossier client
     */
    public function handleDeleteCustomerRecord($id)
    {
        try {
            $this->model->beginTransaction();

            // Supprimer toutes les expéditions liées
            $this->model->deleteShipmentsByCustomerRecord($id);

            // Supprimer logiquement le dossier
            $result = $this->model->deleteCustomerRecord($id, $this->current_user_id);

            if ($result) {
                $this->model->commit();
                return [
                    'success' => true,
                    'message' => 'Dossier client et expéditions supprimés avec succès'
                ];
            } else {
                $this->model->rollBack();
                return [
                    'success' => false,
                    'message' => 'Erreur lors de la suppression du dossier'
                ];
            }
        } catch (Exception $e) {
            $this->model->rollBack();
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }

    // Les autres méthodes restent inchangées...
    public function getAllParcels($filters = [])
    {
        return $this->model->getAllParcels($filters);
    }

    public function getCustomerRecordById($id)
    {
        return $this->model->getCustomerRecordById($id);
    }

    public function getShipmentsByCustomerId($customer_record_id)
    {
        return $this->model->getShipmentsByCustomerId($customer_record_id);
    }

    public function getShipmentById($id)
    {
        return $this->model->getShipmentById($id);
    }

    public function getShipmentStatusHistory($shipment_id)
    {
        return $this->model->getShipmentStatusHistory($shipment_id);
    }

    public function getStats()
    {
        return $this->model->getStats();
    }

  

    public function getShipmentStatusBadge($status)
    {
        $definitions = $this->getStatusDefinitions();
        $badgeClass = $definitions[$status]['badge'] ?? 'secondary';
        $label = $definitions[$status]['label_fr'] ?? $definitions[$status]['label_en'] ?? $status;

        return '<span class="badge badge-' . $badgeClass . '">' . $label . '</span>';
    }

    public function getCustomerStatusBadge($deletion_status)
    {
        if ($deletion_status == 1) {
            return '<span class="badge badge-secondary">Supprimé</span>';
        } else {
            return '<span class="badge badge-success">Actif</span>';
        }
    }

    public function shortenText($text, $length = 100)
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }

    /**
     * Récupère les destinations disponibles
     */
    public function getAvailableDestinations()
    {
        return [
            'Chine',
            'Johannesburg',
            'Kinshasa',
            'Lubumbashi',
            'Kolwezi'
        ];
    }

    /**
     * Récupère les statuts disponibles
     */
    public function getAvailableStatuses()
    {
        $definitions = $this->getStatusDefinitions();
        $labels = [];

        foreach ($definitions as $key => $definition) {
            $labels[$key] = $definition['label'];
        }

        return $labels;
    }

    /**
     * Définitions des statuts (badge + label)
     */
    private function getStatusDefinitions()
    {
        $rows = $this->model->getStatusDefinitions();
        $definitions = [];
        foreach ($rows as $code => $row) {
            $definitions[$code] = [
                'label' => $row['label_fr'] ?? $row['label_en'] ?? $code,
                'label_fr' => $row['label_fr'] ?? $code,
                'label_en' => $row['label_en'] ?? $code,
                'badge' => $row['badge'] ?? 'secondary'
            ];
        }
        return $definitions;
    }

    /**
     * Construit et envoie l'email selon le statut choisi
     */
    private function sendStatusEmail($status, $shipment, $recipient, $language = null, $notes = '')
    {
      
        if (empty($recipient) || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Email client invalide'];
        }

        $language = $this->resolveEmailLanguage($language);
        $definitions = $this->getStatusDefinitions();
        $label = $definitions[$status]["label_{$language}"] ?? $definitions[$status]['label_fr'] ?? $definitions[$status]['label_en'] ?? $status;

        $templateRow = $this->model->getEmailTemplateByStatus($status) ?: [];

        $subjectTpl = $this->pickLocalizedValue($templateRow, 'objet', $language);
        $bodyTpl = $this->pickLocalizedValue($templateRow, 'contenu', $language);
   

        // Fallback sur l'autre langue si vide
        if (empty($subjectTpl)) {
            $subjectTpl = $this->pickLocalizedValue($templateRow, 'objet', $language === 'fr' ? 'en' : 'fr');
        }
        if (empty($bodyTpl)) {
            $bodyTpl = $this->pickLocalizedValue($templateRow, 'contenu', $language === 'fr' ? 'en' : 'fr');
        }

        $placeholders = $this->buildEmailPlaceholders($shipment, $status, $label, $notes);
        $subject = $this->applyEmailPlaceholders(
            $subjectTpl ?: "[{$label}] Mise à jour de votre expédition {{tracking_number}}",
            $placeholders
        );

        $body = $this->applyEmailPlaceholders(
            $bodyTpl ?: "<p>Bonjour {{customer_name}},</p><p>Votre expédition <strong>{{tracking_number}}</strong> a été mise à jour : <strong>{{status_label}}</strong>.</p><p>{{notes_html}}</p>",
            $placeholders
        );

        $headers = $this->buildEmailHeaders();
    
        return $this->emailService->sendHtmlEmail($recipient, $subject, $body, $headers);
    }


    /**
     * Headers HTML pour les emails
     */
    private function buildEmailHeaders()
    {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: support@tcc.local\r\n";
        $headers .= "Reply-To: no-reply@tcc.local\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        return $headers;
    }

    /**
     * Détermine la langue pour l'email
     */
    private function resolveEmailLanguage($language = null)
    {
        $language = strtolower($language ?? ($_SESSION['lang'] ?? 'fr'));
        return in_array($language, ['fr', 'en'], true) ? $language : 'fr';
    }

    /**
     * Récupère une valeur localisée (fr/en) depuis le template
     */
    private function pickLocalizedValue(array $row, $prefix, $language)
    {
        $key = "{$prefix}_{$language}";
        return $row[$key] ?? null;
    }

    /**
     * Prépare les remplacements de variables pour les emails
     */
    private function buildEmailPlaceholders($shipment, $status, $label, $notes)
    {
        $cleanNotes = trim($notes ?? '');
        return [
            '{{customer_name}}' => htmlspecialchars($shipment['full_name'] ?? 'Client', ENT_QUOTES, 'UTF-8'),
            '{{tracking_number}}' => htmlspecialchars($shipment['tracking_reference'] ?? '', ENT_QUOTES, 'UTF-8'),
            '{{status_label}}' => htmlspecialchars($label, ENT_QUOTES, 'UTF-8'),
            '{{status_code}}' => htmlspecialchars($status, ENT_QUOTES, 'UTF-8'),
            '{{destination}}' => htmlspecialchars($shipment['destination'] ?? '', ENT_QUOTES, 'UTF-8'),
            '{{origin}}' => htmlspecialchars($shipment['origin'] ?? '', ENT_QUOTES, 'UTF-8'),
            '{{notes}}' => htmlspecialchars($cleanNotes, ENT_QUOTES, 'UTF-8'),
            '{{notes_html}}' => nl2br(htmlspecialchars($cleanNotes, ENT_QUOTES, 'UTF-8'))
        ];
    }

    /**
     * Applique les placeholders sur une chaine
     */
    private function applyEmailPlaceholders($template, array $replacements)
    {
        return strtr($template, $replacements);
    }
}
?>
