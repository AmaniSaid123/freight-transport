<?php
class ParcelController
{
    private $model;
    private $current_user_id;

    public function __construct($database, $user_id)
    {
        $this->model = new Parcel($database);
        $this->current_user_id = $user_id;
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
            $smsInfo = null;

            if ($result) {
                if (!empty($notifications['notify_email'])) {
                    $emailRecipient = $notifications['email_contact'] ?? $shipment['email'];
                    $emailInfo = $this->sendStatusEmail($status, $shipment, $emailRecipient);
                }

                if (!empty($notifications['notify_sms'])) {
                    $phoneRecipient = $notifications['phone_contact'] ?? $shipment['phone'];
                    $smsInfo = $this->sendStatusSms($status, $shipment, $phoneRecipient);
                }

                $message = 'Statut mis à jour avec succès';
                if ($emailInfo && !$emailInfo['success']) {
                    $message .= ' (email: ' . $emailInfo['message'] . ')';
                } elseif ($emailInfo && $emailInfo['success']) {
                    $message .= ' (email envoyé)';
                }
                if ($smsInfo && !$smsInfo['success']) {
                    $message .= ' (sms: ' . $smsInfo['message'] . ')';
                } elseif ($smsInfo && $smsInfo['success']) {
                    $message .= ' (sms envoyé)';
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
     * Gère la suppression d'un dossier client
     */
    public function handleDeleteCustomerRecord($id)
    {
        try {
            $result = $this->model->deleteCustomerRecord($id, $this->current_user_id);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Dossier client supprimé avec succès'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erreur lors de la suppression du dossier'
                ];
            }
        } catch (Exception $e) {
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
        $label = $definitions[$status]['label'] ?? $status;

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
        return [
            'en_attente' => ['label' => 'En attente', 'badge' => 'warning'],
            'en_cours' => ['label' => 'En cours', 'badge' => 'info'],
            'livre' => ['label' => 'Livré', 'badge' => 'success'],
            'annule' => ['label' => 'Annulé', 'badge' => 'danger']
        ];
    }

    /**
     * Construit et envoie l'email selon le statut choisi
     */
    private function sendStatusEmail($status, $shipment, $recipient)
    {
        if (empty($recipient) || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Email client invalide'];
        }

        $templates = $this->getStatusEmailTemplates();
        $definitions = $this->getStatusDefinitions();
        $label = $definitions[$status]['label'] ?? $status;

        $subject = '[' . $label . '] Mise à jour de votre expédition ' . ($shipment['tracking_reference'] ?? '');

        $template = $templates[$status] ?? $templates['default'];
        $body = sprintf(
            $template,
            htmlspecialchars($shipment['full_name'] ?? 'Client'),
            htmlspecialchars($shipment['tracking_reference'] ?? ''),
            $label
        );

        $headers = $this->buildEmailHeaders();
        $sent = mail($recipient, $subject, $body, $headers);

        if ($sent) {
            return ['success' => true, 'message' => 'Email envoyé'];
        }

        return ['success' => false, 'message' => 'Envoi email impossible'];
    }

    /**
     * Envoie un SMS de statut si activé
     */
    private function sendStatusSms($status, $shipment, $recipient)
    {
        if (empty($recipient)) {
            return ['success' => false, 'message' => 'Numéro client manquant'];
        }

        $definitions = $this->getStatusDefinitions();
        $label = $definitions[$status]['label'] ?? $status;
        $tracking = $shipment['tracking_reference'] ?? '';
        $message = "Mise a jour: votre colis {$tracking} est {$label}. Merci de votre confiance.";

        if (function_exists('send_sms')) {
            // Sender et type restent génériques pour éviter de casser l'existant
            send_sms($recipient, $message, 'TCC', 'parcel_status');
            return ['success' => true, 'message' => 'SMS en file d\'envoi'];
        }

        return ['success' => false, 'message' => 'Service SMS indisponible'];
    }

    /**
     * Templates HTML pour les emails de statut
     */
    private function getStatusEmailTemplates()
    {
        return [
            'en_attente' => "
                <html><body style='font-family: Arial, sans-serif; color:#333;'>
                    <h2 style='color:#4e73df;'>Suivi de votre expédition</h2>
                    <p>Bonjour %s,</p>
                    <p>Nous avons bien enregistré votre demande. Votre colis <strong>%s</strong> est actuellement <strong>%s</strong>.</p>
                    <p>Nous vous tiendrons informé dès qu'une nouvelle étape sera franchie.</p>
                    <p>Cordialement,<br>L'équipe support</p>
                </body></html>",
            'en_cours' => "
                <html><body style='font-family: Arial, sans-serif; color:#333;'>
                    <h2 style='color:#17a2b8;'>Votre colis est en cours</h2>
                    <p>Bonjour %s,</p>
                    <p>Bonne nouvelle ! Votre colis <strong>%s</strong> est <strong>%s</strong>.</p>
                    <p>Vous recevrez un nouveau message lorsque la livraison sera finalisée.</p>
                    <p>Merci pour votre confiance.</p>
                </body></html>",
            'livre' => "
                <html><body style='font-family: Arial, sans-serif; color:#333;'>
                    <h2 style='color:#1cc88a;'>Votre colis est livré</h2>
                    <p>Bonjour %s,</p>
                    <p>Nous confirmons la livraison du colis <strong>%s</strong>. Statut actuel : <strong>%s</strong>.</p>
                    <p>Si quelque chose ne correspond pas à vos attentes, contactez-nous.</p>
                    <p>Cordialement,<br>L'équipe support</p>
                </body></html>",
            'annule' => "
                <html><body style='font-family: Arial, sans-serif; color:#333;'>
                    <h2 style='color:#e74a3b;'>Mise à jour de votre dossier</h2>
                    <p>Bonjour %s,</p>
                    <p>Votre expédition <strong>%s</strong> est maintenant <strong>%s</strong>.</p>
                    <p>Pour plus d'informations ou pour reprogrammer un envoi, merci de nous contacter.</p>
                    <p>Cordialement,<br>L'équipe support</p>
                </body></html>",
            'default' => "
                <html><body style='font-family: Arial, sans-serif; color:#333;'>
                    <p>Bonjour %s,</p>
                    <p>Votre expédition <strong>%s</strong> a été mise à jour : <strong>%s</strong>.</p>
                </body></html>"
        ];
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
}
?>
