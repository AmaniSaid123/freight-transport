<?php
class User
{
    private $bdd;

    public function __construct($database)
    {
        $this->bdd = $database;
    }

    /**
     * Récupère tous les utilisateurs avec leurs profils
     *
     * @return array
     */
    public function getAllUsers()
    {
        $sql = "SELECT 
            p.name as profile, 
            p.id as idprofile,
            u.lastlogon, 
            u.firstname, 
            u.lastname, 
            u.id as iduser, 
            u.username,
            u.email,
            u.created_at,
            u.status 
        FROM user u
        JOIN profile p ON u.id_profile = p.id
        WHERE p.viewable = 1 
        ORDER BY u.firstname, u.lastname";

        $stmt = $this->bdd->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les statistiques des utilisateurs
     *
     * @return array
     */
    public function getUserStats()
    {
        $sql = "SELECT 
            COUNT(*) as total_users,
            COUNT(CASE WHEN status = '1' THEN 1 END) as active_users,
            COUNT(CASE WHEN lastlogon >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 END) as recent_users,
            MAX(created_at) as latest_user
        FROM user";

        $stmt = $this->bdd->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie si un utilisateur existe
     *
     * @param int $userId
     * @return bool
     */
    public function userExists($userId)
    {
        $stmt = $this->bdd->prepare("SELECT COUNT(*) as total FROM user WHERE id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'] > 0;
    }

    /**
     * Récupère le nombre d'utilisateurs par profil
     *
     * @return array
     */
    public function getUsersByProfile()
    {
        $sql = "SELECT 
            p.name as profile_name,
            COUNT(u.id) as user_count
        FROM profile p
        LEFT JOIN user u ON  u.id_profile =  p.id 
        WHERE p.viewable = 1
        GROUP BY p.id, p.name
        ORDER BY user_count DESC";

        $stmt = $this->bdd->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($data)
    {
        $sql = "INSERT INTO user (username, password, created_at, lastlogon, id_profile, status, email, firstname, lastname, url_picture) 
            VALUES (:username, :password, :created_at, NULL, :id_profile, :status, :email, :firstname, :lastname, :url_picture)";

        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Vérifie si un nom d'utilisateur existe déjà
     */


    public function usernameExists($username, $exclude_user_id = null)
    {
        $sql = "SELECT COUNT(*) FROM user WHERE username = ?";
        $params = [$username];

        if ($exclude_user_id) {
            $sql .= " AND id != ?";
            $params[] = $exclude_user_id;
        }

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function emailExists($email, $exclude_user_id = null)
    {
        $sql = "SELECT COUNT(*) FROM user WHERE email = ?";
        $params = [$email];

        if ($exclude_user_id) {
            $sql .= " AND id != ?";
            $params[] = $exclude_user_id;
        }

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
    /**
     * Récupère un utilisateur par son ID
     */
    public function getUserById($id)
    {
        $sql = "SELECT u.*, p.name as profile_name 
            FROM user u 
            LEFT JOIN profile p ON u.id_profile = p.id 
            WHERE u.id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Met à jour un utilisateur
     */
    public function updateUser($data, $user_id)
    {
        try {
            $fields = [];
            $params = ['id' => $user_id];

            foreach ($data as $key => $value) {
                $fields[] = "$key = :$key";
                $params[$key] = $value;
            }

            $sql = "UPDATE user SET " . implode(', ', $fields) . " WHERE id = :id";
            $stmt = $this->bdd->prepare($sql);
            return $stmt->execute($params);

        } catch (PDOException $e) {
            error_log("Erreur mise à jour utilisateur: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Met à jour le mot de passe
     */
    public function updatePassword($password, $user_id)
    {
        $sql = "UPDATE user SET password = :password WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute([
            'password' => $password,
            'id' => $user_id
        ]);
    }
    /**
     * Supprime un utilisateur
     */
    public function deleteUser($user_id)
    {
        try {
            $sql = "DELETE FROM user WHERE id = :id";
            $stmt = $this->bdd->prepare($sql);
            return $stmt->execute(['id' => $user_id]);
        } catch (PDOException $e) {
            error_log("Erreur suppression utilisateur: " . $e->getMessage());
            return false;
        }
    }

}