<?php
class MailingController {
    private $model;
    private $current_user_id;
    
    public function __construct($database, $user_id) {
        $this->model = new Mailing($database);
        $this->current_user_id = $user_id;
    }

    /**
     * Gère l'ajout d'un email
     */
    public function handleAddMail($data) {
        $errors = [];
        
        // Validation des champs requis
        $requiredFields = ['titre_email_fr', 'titre_email_en', 'objet_fr', 'objet_en', 'contenu_fr'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "Ce champ est obligatoire";
            }
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'message' => 'Veuillez corriger les erreurs du formulaire',
                'errors' => $errors
            ];
        }

        try {
            // Préparation des données
            $mailData = [
                'titre_email_fr' => $data['titre_email_fr'] ?? null,
                'titre_email_en' => $data['titre_email_en'] ?? null,
                'objet_fr' => $data['objet_fr'] ?? null,
                'objet_en' => $data['objet_en'] ?? null,
                'contenu_fr' => $data['contenu_fr'],
                'contenu_en' => $data['contenu_en'] ?? null,
                'destinataires' => $data['destinataires'] ?? null,
                'type_destinataires' => $data['type_destinataires'] ?? 'tous',
                'status_code' => $data['statut'] ?? 'brouillon',
                'date_programmation' => !empty($data['date_programmation']) ? $data['date_programmation'] : null,
                'pieces_jointes' => $data['pieces_jointes'] ?? null,
                'created_by' => $this->current_user_id
            ];

            $result = $this->model->createMail($mailData);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Email créé avec succès'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erreur lors de la création de l\'email: ' . $this->model->getLastError()
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
     * Gère la modification d'un email
     */
    public function handleUpdateMail($data, $mail_id) {
        $errors = [];
        
        // Validation des champs requis
        $requiredFields = ['titre_email_fr', 'titre_email_en', 'objet_fr', 'objet_en', 'contenu_fr'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "Ce champ est obligatoire";
            }
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'message' => 'Veuillez corriger les erreurs du formulaire',
                'errors' => $errors
            ];
        }

        try {
            // Préparation des données
            $mailData = [
                'titre_email_fr' => $data['titre_email_fr'] ?? null,
                'titre_email_en' => $data['titre_email_en'] ?? null,
                'objet_fr' => $data['objet_fr'] ?? null,
                'objet_en' => $data['objet_en'] ?? null,
                'contenu_fr' => $data['contenu_fr'],
                'contenu_en' => $data['contenu_en'] ?? null,
                'destinataires' => $data['destinataires'] ?? null,
                'type_destinataires' => $data['type_destinataires'] ?? 'tous',
                'status_code' => $data['statut'] ?? 'brouillon',
                'date_programmation' => !empty($data['date_programmation']) ? $data['date_programmation'] : null,
                'pieces_jointes' => $data['pieces_jointes'] ?? null
            ];

            $result = $this->model->updateMail($mailData, $mail_id);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Email modifié avec succès'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erreur lors de la modification de l\'email: ' . $this->model->getLastError()
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
     * Gère la suppression d'un email
     */
    public function handleDeleteMail($mail_id) {
        try {
            $result = $this->model->deleteMail($mail_id);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Email supprimé avec succès'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erreur lors de la suppression de l\'email'
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
     * Récupère tous les emails
     */
    public function getAllMails() {
        return $this->model->getAllMails();
    }

    /**
     * Récupère un email par son ID
     */
    public function getMailById($id) {
        return $this->model->getMailById($id);
    }

    /**
     * Récupère les statistiques
     */
    public function getStats() {
        return $this->model->getStats();
    }

 

    public function getStatusOptions()
    {
        $defs = [];
        $rows = $this->model->getStatusDefinitions();
        if (is_array($rows)) {
            foreach ($rows as $row) {
                if (!isset($row['code'])) {
                    continue;
                }
                $defs[$row['code']] = [
                    'label_en' => $row['name_en'] ?? $row['code'],
                    'label_fr' => $row['name_fr'] ?? $row['code'],
                    'badge' => $row['badge_class'] ?? 'secondary'
                ];
            }
        }
        return $defs;
    }

    /**
     * Formate la date pour l'affichage
     */
    public function formatDate($date) {
        if (empty($date) || $date === '0000-00-00 00:00:00') {
            return '<span class="text-muted">Non définie</span>';
        }
        return date('d/m/Y H:i', strtotime($date));
    }

    /**
     * Retourne le badge pour le statut
     */
    public function getStatusBadge($statut) {
        // Pull from parcel_status if available
        if (method_exists($this->model, 'getStatusDefinitions')) {
            $rows = $this->model->getStatusDefinitions();
            foreach ($rows as $row) {
                if ($row['code'] === $statut) {
                    $class = $row['badge_class'] ?: 'secondary';
                    $label = $row['name_fr'] ?? $row['name_en'] ?? $statut;
                    return '<span class="badge badge-' . htmlspecialchars($class) . '">' . htmlspecialchars($label) . '</span>';
                }
            }
        }
        // Minimal fallback
        return '<span class="badge badge-secondary">' . htmlspecialchars($statut) . '</span>';
    }
}
?>