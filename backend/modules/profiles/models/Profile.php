<?php

class Profile
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    /**
     * Get all profiles with user counts
     *
     * @return PDOStatement
     */
    public function getAllProfiles()
    {
        $sql = "SELECT 
            p.name AS profile, 
            p.id AS idprofile, 
            COUNT(u.username) AS total_user,
            p.created_at, 
            p.description 
        FROM profile p
        LEFT JOIN user u ON p.id = u.id_profile
        WHERE p.viewable = 1 
        GROUP BY p.id, p.name, p.created_at, p.description
        ORDER BY p.name";

        return $this->bdd->query($sql);
    }

    /**
     * Delete a profile by ID
     *
     * @param int $profileId
     * @return bool
     */
    public function deleteProfile($profileId)
    {
        $stmt = $this->bdd->prepare("DELETE FROM profile WHERE id = ?");
        return $stmt->execute([$profileId]);
    }

    /**
     * Get profile data by ID
     *
     * @param int $profileId
     * @return array|null
     */
    public function getProfileData($profileId)
    {
        $stmt = $this->bdd->prepare("SELECT name, description FROM profile WHERE id = ?");
        $stmt->execute([$profileId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get total number of users by profile
     *
     * @param int $profileId
     * @return int
     */
    public function getTotalUsersByProfile($profileId)
    {
        $stmt = $this->bdd->prepare("SELECT COUNT(*) as total FROM user WHERE id_profile = ?");
        $stmt->execute([$profileId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }

    /**
     * Get total number of users in the system
     *
     * @param PDO $bdd
     * @return int
     */
    public function getTotalUsers()
    {
        $stmt = $this->bdd->query("SELECT COUNT(*) AS total FROM user");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $data['total'];
    }

    /**
     * Check if profile exists and is viewable
     *
     * @param int $profileId
     * @return bool
     */
    public function profileExists($profileId)
    {
        $stmt = $this->bdd->prepare("SELECT COUNT(*) as total FROM profile WHERE id = ? AND viewable = 1");
        $stmt->execute([$profileId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'] > 0;
    }

    /**
     * Get profile statistics for dashboard
     *
     * @return array
     */
    public function getProfileStats()
    {
        $sql = "SELECT 
            COUNT(*) as total_profiles,
            SUM(CASE WHEN u.id IS NOT NULL THEN 1 ELSE 0 END) as profiles_with_users,
            MAX(p.created_at) as latest_profile_date
        FROM profile  p
        LEFT JOIN user u ON p.id = u.id_profile
        WHERE p.viewable = 1";

        $stmt = $this->bdd->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function addProfile(string $name, string $description, string $username): int
    {
        $sql = "INSERT INTO profile (name, description, created_at, last_update)
                VALUES (:name, :description, NOW(), NOW())";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
        ]);
        return $this->bdd->lastInsertId();
    }
    public function getProfileById(int $id): ?array
    {
        $stmt = $this->bdd->prepare("SELECT * FROM profile WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }

    public function updateProfile(int $id, string $name, string $description): bool
    {
        $stmt = $this->bdd->prepare("
            UPDATE profile 
            SET name = ?, description = ?, last_update = NOW() 
            WHERE id = ?
        ");
        return $stmt->execute([$name, $description, $id]);
    }

    public function getProfileContents($id)
    {
        $sql = "SELECT 
        c.name AS sous_menu,
        c.id, 
        c.ref_menu,
        pc.id AS idpc,
        pc.id_content,  
        'Oui' AS accorder
            FROM content c 
            JOIN profile_content pc 
                ON c.id = pc.id_content
            WHERE pc.id_profile = :id1

            UNION ALL

            SELECT 
                c.name AS sous_menu, 
                c.id, 
                c.ref_menu, 
                NULL AS idpc,
                c.id AS id_content,
                'Non' AS accorder
            FROM content c
            WHERE c.display = '1'
            AND c.id NOT IN (
                SELECT id_content FROM profile_content WHERE id_profile = :id2
            )
            ORDER BY ref_menu DESC";

        $stmt = $this->bdd->prepare($sql);
        $stmt->bindValue(':id1', $id, PDO::PARAM_INT);
        $stmt->bindValue(':id2', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteProfileContent(int $contentId, int $profileId): bool
    {
        $stmt = $this->bdd->prepare("DELETE FROM profile_content WHERE idpc = ? AND id_profile = ?");
        return $stmt->execute([$contentId, $profileId]);
    }

    public function addProfileContent(int $profileId, int $contentId): bool
    {
        $stmt = $this->bdd->prepare("
            INSERT INTO profile_content (id_profile, id_content)
            VALUES (?, ?)
        ");
        return $stmt->execute([$profileId, $contentId]);
    }
}