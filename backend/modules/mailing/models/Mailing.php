<?php
class Mailing {
    private $bdd;
    
    public function __construct($database) {
        $this->bdd = $database;
    }

    /**
     * Récupère tous les emails
     */
    public function getAllMails() {
        $sql = "SELECT m.*, u.username as created_by_name 
                FROM mailing m 
                LEFT JOIN user u ON m.created_by = u.id 
                ORDER BY m.created_at DESC";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un email par son ID
     */
    public function getMailById($id) {
        $sql = "SELECT m.*, u.username as created_by_name 
                FROM mailing m 
                LEFT JOIN user u ON m.created_by = u.id 
                WHERE m.id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouvel email
     */
    public function createMail($data) {
        $sql = "INSERT INTO mailing (titre_email_fr, titre_email_en, objet_fr, objet_en, contenu_fr, contenu_en, destinataires, type_destinataires, status_code, date_programmation, pieces_jointes, created_by) 
                VALUES (:titre_email_fr, :titre_email_en, :objet_fr, :objet_en, :contenu_fr, :contenu_en, :destinataires, :type_destinataires, :status_code, :date_programmation, :pieces_jointes, :created_by)";
        
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Met à jour un email
     */
    public function updateMail($data, $id) {
        $fields = [];
        $params = ['id' => $id];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[$key] = $value;
        }
        
        $sql = "UPDATE mailing SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Supprime un email
     */
    public function deleteMail($id) {
        $sql = "DELETE FROM mailing WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Récupère les statistiques (basé sur status_code)
     */
    public function getStats() {
        $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status_code = 'envoye' THEN 1 ELSE 0 END) as envoyes,
                SUM(CASE WHEN status_code = 'brouillon' THEN 1 ELSE 0 END) as brouillons,
                SUM(CASE WHEN status_code = 'programme' THEN 1 ELSE 0 END) as programmes,
                SUM(CASE WHEN status_code = 'erreur' THEN 1 ELSE 0 END) as erreurs
                FROM mailing";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Définitions des statuts depuis parcel_status
     */
    public function getStatusDefinitions()
    {
        $sql = "SELECT code, name_en, name_fr, badge_class FROM parcel_status ORDER BY code";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère la dernière erreur
     */
    public function getLastError() {
        return $this->bdd->errorInfo()[2] ?? 'Erreur inconnue';
    }
}
?>