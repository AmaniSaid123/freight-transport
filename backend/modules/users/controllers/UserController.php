<?php
class UserController
{
    private $queries;
    private $model;

    public function __construct($database)
    {
        // Fix: Use the correct class name
        $this->queries = new User($database);
        $this->model = new User($database);
    }

    /**
     * Gère la fermeture de session utilisateur
     *
     * @return array|null
     */
    public function handleCloseSession()
    {
        if (isset($_GET['close']) && $_GET['close'] === "ok") {
            $_SESSION['mi_m_user'] = "NA";
            return [
                'success' => 'yes',
                'message' => 'Session utilisateur fermée avec succès'
            ];
        }
        return null;
    }

    /**
     * Formate la date de dernière connexion
     *
     * @param string $lastlogon
     * @return string
     */
    public function formatLastLogon($lastlogon)
    {
        if (empty($lastlogon) || $lastlogon === '0000-00-00 00:00:00') {
            return '<span class="text-muted">Jamais</span>';
        }

        $date = new DateTime($lastlogon);
        $now = new DateTime();
        $interval = $now->diff($date);

        if ($interval->days == 0) {
            return 'Aujourd\'hui ' . $date->format('H:i');
        } elseif ($interval->days == 1) {
            return 'Hier ' . $date->format('H:i');
        } elseif ($interval->days < 7) {
            return 'Il y a ' . $interval->days . ' jour(s)';
        } else {
            return $date->format('d/m/Y H:i');
        }
    }

    /**
     * Récupère tous les utilisateurs
     *
     * @return array
     */
    public function getAllUsers()
    {
        return $this->queries->getAllUsers();
    }


    /**
     * Récupère les statistiques utilisateurs
     *
     * @return array
     */
    public function getUserStats()
    {
        return $this->queries->getUserStats();
    }

    /**
     * Récupère la répartition par profil
     *
     * @return array // ← Fixed return type
     */
    public function getUsersByProfile()
    {
        return $this->queries->getUsersByProfile(); // This should return array
    }

    /**
     * Vérifie le statut de l'utilisateur
     *
     * @param array $user
     * @return string
     */
    public function getUserStatus($user)
    {
        if (empty($user['lastlogon']) || $user['lastlogon'] === '0000-00-00 00:00:00') {
            return 'new';
        }

        $lastLogon = new DateTime($user['lastlogon']);
        $now = new DateTime();
        $interval = $now->diff($lastLogon);

        if ($interval->days <= 7) {
            return 'active';
        } elseif ($interval->days <= 30) {
            return 'inactive';
        } else {
            return 'very-inactive';
        }
    }


    /**
     * Gère l'ajout d'un utilisateur
     *
     * @param array $data
     * @return array
     */
    public function handleAddUser($data, $user_id)
    {
        $errors = [];

        // Validation des champs requis
        $requiredFields = ['username', 'email', 'firstname', 'lastname', 'id_profile', 'status'];
        foreach ($requiredFields as $field) {
            if (empty(trim($data[$field] ?? ''))) {
                $errors[$field] = "Ce champ est obligatoire";
            }
        }

        // Validation email
        if (!empty($data['email'])) {
            $email = trim($data['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Format d'email invalide";
            } elseif ($this->model->emailExists($email, $user_id)) {
                $errors['email'] = "Cet email est déjà utilisé par un autre utilisateur";
            }
        }

        // Vérification username
        if (!empty($data['username'])) {
            $username = trim($data['username']);
            if ($this->model->usernameExists($username, $user_id)) {
                $errors['username'] = "Ce nom d'utilisateur est déjà utilisé par un autre utilisateur";
            }
        }

        // Validation longueur des champs
        if (!empty($data['username']) && strlen($data['username']) > 50) {
            $errors['username'] = "Le nom d'utilisateur ne peut pas dépasser 50 caractères";
        }

        if (!empty($data['email']) && strlen($data['email']) > 100) {
            $errors['email'] = "L'email ne peut pas dépasser 100 caractères";
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'message' => 'Veuillez corriger les erreurs du formulaire',
                'errors' => $errors
            ];
        }
        try {
            // Gestion de l'upload de l'image
            $url_picture = null;
            if (!empty($_FILES['url_picture']['name']) && $_FILES['url_picture']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->uploadImage($_FILES['url_picture']);
                if ($uploadResult['success']) {
                    $url_picture = $uploadResult['file_path'];
                } else {
                    $errors['url_picture'] = $uploadResult['error'];
                    return [
                        'success' => false,
                        'message' => 'Erreur lors de l\'upload de l\'image',
                        'errors' => $errors
                    ];
                }
            }

            // Hash du mot de passe avec vérification
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            if ($hashedPassword === false) {
                throw new Exception('Erreur lors du hashage du mot de passe');
            }

            // Vérifier la longueur du hash
            if (strlen($hashedPassword) > 255) {
                throw new Exception('Le hash du mot de passe est trop long pour la base de données');
            }

            // Préparation des données pour l'insertion
            $userData = [
                'username' => substr($data['username'], 0, 50), // Limiter à 50 caractères
                'email' => substr($data['email'], 0, 100), // Limiter à 100 caractères
                'password' => $hashedPassword,
                'firstname' => substr($data['firstname'], 0, 50), // Limiter à 50 caractères
                'lastname' => substr($data['lastname'], 0, 50), // Limiter à 50 caractères
                'id_profile' => (int) $data['id_profile'],
                'status' => (int) $data['status'],
                'url_picture' => $url_picture,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->model->createUser($userData);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Utilisateur créé avec succès'
                ];
            } else {
                // Récupérer l'erreur PDO pour plus d'informations
                $errorInfo = $this->model->getLastError();
                return [
                    'success' => false,
                    'message' => 'Erreur lors de la création de l\'utilisateur: ' . $errorInfo
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
     * Upload une image
     *
     * @param array $file
     * @return array
     */
    private function uploadImage($file)
    {
        $targetDir = __DIR__ . '/../../../../backend/uploads/users/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        $fileName = basename($file['name']);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $fileSize = $file['size'];

        // Vérification du type de fichier
        if (!in_array($fileType, $allowedTypes)) {
            return ['success' => false, 'error' => 'Type de fichier non autorisé'];
        }

        // Vérification de la taille
        if ($fileSize > $maxSize) {
            return ['success' => false, 'error' => 'Fichier trop volumineux (max 2MB)'];
        }

        // Génération d'un nom unique
        $newFileName = uniqid() . '.' . $fileType;
        $targetFile = $targetDir . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Retourner seulement le nom du fichier
            return ['success' => true, 'file_path' => $newFileName];
        } else {
            return ['success' => false, 'error' => 'Erreur lors de l\'upload'];
        }
    }

    /**
     * Récupère un utilisateur par son ID
     */
    public function getUserById($id)
    {
        return $this->model->getUserById($id);
    }

    /**
     * Gère la modification d'un utilisateur
     */
    public function handleUpdateUser($data, $user_id)
    {
        $errors = [];

        // Validation des champs requis
        $requiredFields = ['username', 'email', 'firstname', 'lastname', 'id_profile', 'status'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "Ce champ est obligatoire";
            }
        }

        // Validation email
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Format d'email invalide";
        }

        // Vérification si l'username existe déjà (exclure l'utilisateur actuel)
        if (!empty($data['username']) && $this->model->usernameExists($data['username'], $user_id)) {
            $errors['username'] = "Ce nom d'utilisateur existe déjà";
        }

        // Vérification si l'email existe déjà (exclure l'utilisateur actuel)
        if (!empty($data['email']) && $this->model->emailExists($data['email'], $user_id)) {
            $errors['email'] = "Cet email existe déjà";
        }

        // =============================================
        // 3. VALIDATION SUPPLEMENTAIRE DES DOUBLONS
        // =============================================
        $current_user = $this->getUserById($user_id);
        if ($current_user) {
            $hasChanges = false;

            // Vérifier chaque champ pour détecter les modifications
            if ($data['email'] !== $current_user['email'])
                $hasChanges = true;
            if ($data['username'] !== $current_user['username'])
                $hasChanges = true;
            if ($data['firstname'] !== $current_user['firstname'])
                $hasChanges = true;
            if ($data['lastname'] !== $current_user['lastname'])
                $hasChanges = true;
            if ((int) $data['id_profile'] !== (int) $current_user['id_profile'])
                $hasChanges = true;
            if ((int) $data['status'] !== (int) $current_user['status'])
                $hasChanges = true;

            // Vérifier si une nouvelle image est uploadée ou si on supprime l'image
            $hasImageChanges = (!empty($_FILES['url_picture']['name']) ||
                (isset($data['remove_picture']) && $data['remove_picture'] == '1'));

            // Si aucune modification n'est détectée
            if (!$hasChanges && !$hasImageChanges) {
                return [
                    'success' => true,
                    'message' => 'Aucune modification détectée - mise à jour non nécessaire',
                    'no_changes' => true
                ];
            }
        }
        // =============================================

        if (!empty($errors)) {
            return [
                'success' => false,
                'message' => 'Veuillez corriger les erreurs du formulaire',
                'errors' => $errors
            ];
        }


        try {
            // Gestion de l'upload de l'image
            $url_picture = null;
            $remove_picture = isset($data['remove_picture']) && $data['remove_picture'] == '1';

            if ($remove_picture) {
                // Supprimer l'image actuelle
                $current_user = $this->getUserById($user_id);
                if (!empty($current_user['url_picture'])) {
                    $this->deleteImage($current_user['url_picture']);
                }
                $url_picture = null;
            } elseif (!empty($_FILES['url_picture']['name'])) {
                $uploadResult = $this->uploadImage($_FILES['url_picture']);
                if ($uploadResult['success']) {
                    // Supprimer l'ancienne image si elle existe
                    $current_user = $this->getUserById($user_id);
                    if (!empty($current_user['url_picture'])) {
                        $this->deleteImage($current_user['url_picture']);
                    }
                    $url_picture = $uploadResult['file_path'];
                } else {
                    $errors['url_picture'] = $uploadResult['error'];
                    return [
                        'success' => false,
                        'message' => 'Erreur lors de l\'upload de l\'image',
                        'errors' => $errors
                    ];
                }
            }

            // Préparation des données pour la mise à jour
            $userData = [
                'username' => substr($data['username'], 0, 50),
                'email' => substr($data['email'], 0, 100),
                'firstname' => substr($data['firstname'], 0, 50),
                'lastname' => substr($data['lastname'], 0, 50),
                'id_profile' => (int) $data['id_profile'],
                'status' => (int) $data['status']
            ];

            // Ajouter l'URL de l'image seulement si elle a changé
            if ($url_picture !== null) {
                $userData['url_picture'] = $url_picture;
            } elseif ($remove_picture) {
                $userData['url_picture'] = null;
            }

            $result = $this->model->updateUser($userData, $user_id);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Utilisateur mis à jour avec succès'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour de l\'utilisateur'
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
     * Gère le changement de mot de passe
     */
    public function handleChangePassword($data, $user_id)
    {
        $errors = [];

        // Validation des champs requis
        $requiredFields = ['new_password', 'confirm_password'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "Ce champ est obligatoire";
            }
        }

        // Validation confirmation mot de passe
        if (!empty($data['new_password']) && $data['new_password'] !== $data['confirm_password']) {
            $errors['confirm_password'] = "Les mots de passe ne correspondent pas";
        }

        // Validation longueur mot de passe
        if (!empty($data['new_password']) && strlen($data['new_password']) < 6) {
            $errors['new_password'] = "Le mot de passe doit contenir au moins 6 caractères";
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'message' => 'Veuillez corriger les erreurs du formulaire',
                'errors' => $errors
            ];
        }

        try {
            // Hash du nouveau mot de passe
            $hashedPassword = password_hash($data['new_password'], PASSWORD_DEFAULT);
            if ($hashedPassword === false) {
                throw new Exception('Erreur lors du hashage du mot de passe');
            }

            $result = $this->model->updatePassword($hashedPassword, $user_id);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Mot de passe changé avec succès'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erreur lors du changement de mot de passe'
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
     * Gère la suppression d'un utilisateur
     */
    public function handleDeleteUser($user_id)
    {
        try {
            // Empêcher l'utilisateur de se supprimer lui-même
            $current_user_id = $_SESSION['user_id'] ?? 0;
            if ($user_id == $current_user_id) {
                return [
                    'error' => 'yes',
                    'message' => 'Vous ne pouvez pas supprimer votre propre compte'
                ];
            }

            // Récupérer les informations de l'utilisateur avant suppression
            $user = $this->getUserById($user_id);
            if (!$user) {
                return [
                    'error' => 'yes',
                    'message' => 'Utilisateur non trouvé'
                ];
            }

            // Supprimer l'image de profil si elle existe
            if (!empty($user['url_picture'])) {
                $this->deleteImage($user['url_picture']);
            }

            // Supprimer l'utilisateur
            $result = $this->model->deleteUser($user_id);

            if ($result) {
                return [
                    'success' => 'yes',
                    'message' => 'Utilisateur supprimé avec succès'
                ];
            } else {
                return [
                    'error' => 'yes',
                    'message' => 'Erreur lors de la suppression de l\'utilisateur'
                ];
            }

        } catch (Exception $e) {
            return [
                'error' => 'yes',
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Supprime une image
     */
    private function deleteImage($file_path)
    {
        $full_path = __DIR__ . '/../../../../' . $file_path;
        if (file_exists($full_path) && is_file($full_path)) {
            unlink($full_path);
        }
    }


}
?>