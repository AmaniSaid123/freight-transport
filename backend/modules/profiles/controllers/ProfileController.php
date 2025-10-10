<?php

require_once __DIR__ . '/../models/Profile.php';

class ProfileController
{
    private Profile $model;
    private string $username;

    public function __construct(Profile $model, string $username)
    {
        $this->model = $model;
        $this->username = $username;
    }

    /** Handle profile creation */
    public function handleAddProfile(array $postData): array
    {
        $response = ['success' => false, 'message' => ''];

        $name = trim($postData['name'] ?? '');
        $description = trim($postData['description'] ?? '');

        if ($name === '') {
            $response['message'] = "Le champ 'Nom' est obligatoire.";
            return $response;
        }

        $id = $this->model->addProfile($name, $description, $this->username);

        /* add_notification(
             "t_profile",
             0,
             "NA",
             "Nom : $name / Description : $description",
             $this->username,
             "Création Profil"
         );*/

        $response['success'] = true;
        $response['message'] = "Profil '$name' créé avec succès.";
        $response['id'] = $id;

        return $response;
    }
    /**
     * Handle close profile action
     *
     * @return array|null
     */
    public function handleCloseProfile()
    {
        if (!empty($_GET['close']) && $_GET['close'] === "ok") {
            $_SESSION['my_m_profile'] = "NA";
            return [
                'success' => 'yes',
                'message' => 'Profile fermé avec succès'
            ];
        }
        return null;
    }

    /**
     * Handle delete profile action
     *
     * @param int $profileId
     * @return array
     */
    public function handleDeleteProfile($profileId)
    {
        // Vérifier si le profil existe
        if (!$this->model->profileExists($profileId)) {
            return [
                'error' => 'yes',
                'message' => "Le profile demandé n'existe pas."
            ];
        }

        $utilisateur_affecte = $this->model->getTotalUsersByProfile($profileId);

        if ($utilisateur_affecte === 0) {
            $profileData = $this->model->getProfileData($profileId);
            $deleted = $this->model->deleteProfile($profileId);

            if ($deleted && $profileData) {
                $this->logDeletion($profileData);
                return [
                    'success' => 'yes',
                    'message' => "Le Profile {$profileData['name']} supprimé avec succès ! (0 utilisateur affecté)"
                ];
            } else {
                return [
                    'error' => 'yes',
                    'message' => "Erreur lors de la suppression du profile."
                ];
            }
        }

        return [
            'error' => 'yes',
            'message' => "Impossible de supprimer ce profile car il est encore attribué à {$utilisateur_affecte} utilisateur(s)."
        ];
    }

    /**
     * Log profile deletion
     *
     * @param array $profileData
     */
    private function logDeletion($profileData)
    {
        /*add_notification(
            "profil",
            0,
            "NA",
            "Nom : {$profileData['name']} Description : {$profileData['description']}",
            $_SESSION['my_username'],
            "Suppression Profile : {$profileData['name']} avec 0 utilisateurs"
        );*/
    }


    public function editProfile(int $id, array $postData): array
    {
        $name = trim($postData['name'] ?? '');
        $description = trim($postData['description'] ?? '');
        if ($name === '') {
            return ['success' => false, 'message' => 'Le nom du profil est obligatoire.'];
        }

        $success = $this->model->updateProfile($id, $name, $description);
        if ($success) {
           // add_notification("profil", 0, "Mise à jour", "Profile : $name", $this->username, "Modification du profil");
            return ['success' => true, 'message' => 'Profil mis à jour avec succès.'];
        }
        return ['success' => false, 'message' => 'Erreur lors de la mise à jour du profil.'];
    }

    public function handleContentUpdate(int $profileId, array $postData): void
    {
        $total = $postData['total'] ?? 0;
        for ($i = 1; $i <= $total; $i++) {
            if (!empty($postData["chk$i"]) && !empty($postData["value$i"])) {
                $this->model->addProfileContent($profileId, (int) $postData["value$i"]);
            }
        }
    }

    public function handleAccessRights(int $profileId, array $postData): array
    {
        $total = $postData['total'] ?? 0;
        $added = 0;

        for ($i = 1; $i <= $total; $i++) {
            if (!empty($postData["chk$i"]) && !empty($postData["value$i"])) {
                $this->model->addProfileContent($profileId, (int)$postData["value$i"]);
                $added++;
            }
        }

        return [
            'success' => true,
            'message' => $added > 0
                ? "$added droit(s) d’accès ont été ajoutés avec succès."
                : "Aucun droit d’accès sélectionné."
        ];
    }
    /**
     * Get all profiles
     *
     * @return PDOStatement
     */
    public function getAllProfiles()
    {
        return $this->model->getAllProfiles();
    }

    /**
     * Get total number of users
     *
     * @return int
     */
    public function getTotalUsers()
    {
        return $this->model->getTotalUsers();
    }

    /**
     * Get profile statistics
     *
     * @return array
     */
    public function getProfileStats()
    {
        return $this->model->getProfileStats();
    }
}
?>