<?php
class Parcel {
    private $bdd;
    
    public function __construct($database) {
        $this->bdd = $database;
    }

    /**
     * Récupère tous les dossiers clients non supprimés avec leurs expéditions
     */
    public function getAllParcels($filters = []) {
        $sql = "SELECT cr.*, 
                COUNT(s.id) as shipment_count,
                MAX(s.created_at) as last_shipment_date
                FROM customer_records cr 
                LEFT JOIN shipment s ON cr.id = s.customer_record_id 
                WHERE cr.deletion_status = 0";
        
        $params = [];
        
        // Filtres
        if (!empty($filters['search'])) {
            $sql .= " AND (cr.full_name LIKE ? OR cr.email LIKE ? OR cr.customer_id LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " GROUP BY cr.id ORDER BY cr.created_at DESC";
        
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un dossier client par son ID (non supprimé)
     */
    public function getCustomerRecordById($id) {
        $sql = "SELECT * FROM customer_records WHERE id = ? AND deletion_status = 0";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un dossier client par customer_id (non supprimé)
     */
    public function getCustomerRecordByCustomerId($customer_id) {
        $sql = "SELECT * FROM customer_records WHERE customer_id = ? AND deletion_status = 0";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$customer_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un dossier client par email (non supprimé)
     */
    public function getCustomerRecordByEmail($email) {
        $sql = "SELECT * FROM customer_records WHERE email = ? AND deletion_status = 0";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les expéditions d'un dossier client
     */
    public function getShipmentsByCustomerId($customer_record_id) {
        $sql = "SELECT * FROM shipment WHERE customer_record_id = ? ORDER BY created_at DESC";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$customer_record_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une expédition par son ID
     */
    public function getShipmentById($id) {
        $sql = "SELECT s.*, cr.full_name, cr.email, cr.phone 
                FROM shipment s 
                JOIN customer_records cr ON s.customer_record_id = cr.id 
                WHERE s.id = ? AND cr.deletion_status = 0";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouveau dossier client
     */
    public function createCustomerRecord($data) {
        $sql = "INSERT INTO customer_records (customer_id, full_name, phone, email, address) 
                VALUES (:customer_id, :full_name, :phone, :email, :address)";
        
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Crée une nouvelle expédition
     */
    public function createShipment($data) {
        $sql = "INSERT INTO shipment (customer_record_id, tracking_reference, origin, destination, description, comment) 
                VALUES (:customer_record_id, :tracking_reference, :origin, :destination, :description, :comment)";
        
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Met à jour un dossier client
     */
    public function updateCustomerRecord($data, $id) {
        $fields = [];
        $params = ['id' => $id];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[$key] = $value;
        }
        
        $sql = "UPDATE customer_records SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Met à jour une expédition
     */
    public function updateShipment($data, $id) {
        $fields = [];
        $params = ['id' => $id];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[$key] = $value;
        }
        
        $sql = "UPDATE shipment SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Met à jour le statut d'une expédition
     */
    public function updateShipmentStatus($shipment_id, $status, $notes = null, $user_id = null) {
        try {
            $this->bdd->beginTransaction();

            // Mettre à jour le statut de l'expédition
            $sql = "UPDATE shipment SET status = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $this->bdd->prepare($sql);
            $stmt->execute([$status, $shipment_id]);

            // Ajouter à l'historique
            $sql_history = "INSERT INTO shipment_status_history (shipment_id, status, notes, created_by) VALUES (?, ?, ?, ?)";
            $stmt_history = $this->bdd->prepare($sql_history);
            $stmt_history->execute([$shipment_id, $status, $notes, $user_id]);

            $this->bdd->commit();
            return true;
        } catch (Exception $e) {
            $this->bdd->rollBack();
            throw $e;
        }
    }

    /**
     * Récupère l'historique des statuts d'une expédition
     */
    public function getShipmentStatusHistory($shipment_id) {
        $sql = "SELECT ssh.*, u.username as created_by_name 
                FROM shipment_status_history ssh 
                LEFT JOIN user u ON ssh.created_by = u.id 
                WHERE ssh.shipment_id = ? 
                ORDER BY ssh.created_at DESC";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$shipment_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime logiquement un dossier client
     */
    public function deleteCustomerRecord($id, $user_id = null) {
        $sql = "UPDATE customer_records SET deletion_status = 1, deleted_at = NOW(), deleted_by_user = ? WHERE id = ?";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute([$user_id, $id]);
    }

    /**
     * Supprime une expédition
     */
    public function deleteShipment($id) {
        $sql = "DELETE FROM shipment WHERE id = ?";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Vérifie si un email existe déjà (non supprimé)
     */
    public function emailExists($email, $exclude_id = null) {
        $sql = "SELECT COUNT(*) FROM customer_records WHERE email = ? AND deletion_status = 0";
        $params = [$email];
        
        if ($exclude_id !== null) {
            $sql .= " AND id != ?";
            $params[] = $exclude_id;
        }
        
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Génère une référence dossier unique
     */
    public function generateRefDossier() {
        $uniqueId = substr(str_shuffle("0123456789"), 0, 4);
        $customer_id = 'TCC' . $uniqueId;

        // Vérifier si déjà utilisé
        $stmt = $this->bdd->prepare("SELECT id FROM customer_records WHERE customer_id = ?");
        $stmt->execute([$customer_id]);

        while ($stmt->rowCount() > 0) {
            $uniqueId = substr(str_shuffle("0123456789"), 0, 4);
            $customer_id = 'TCC' . $uniqueId;
            $stmt->execute([$customer_id]);
        }

        return $customer_id;
    }

    /**
     * Génère une référence expédition unique
     */
    public function generateExpeditionRef($dossier_id, $customer_id) {
        // Compter les expéditions existantes pour ce dossier_id
        $stmt = $this->bdd->prepare("SELECT COUNT(*) as total FROM shipment WHERE customer_record_id = ?");
        $stmt->execute([$dossier_id]);
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['total'] + 1;

        $expNumber = str_pad($count, 3, '0', STR_PAD_LEFT);
        return $customer_id . $expNumber;
    }

    /**
     * Récupère les statistiques (non supprimés)
     */
    public function getStats() {
        $sql = "SELECT 
                COUNT(DISTINCT cr.id) as total_customers,
                COUNT(s.id) as total_shipments,
                SUM(CASE WHEN s.status = 'en_attente' THEN 1 ELSE 0 END) as pending_shipments,
                SUM(CASE WHEN s.status = 'en_cours' THEN 1 ELSE 0 END) as in_progress_shipments,
                SUM(CASE WHEN s.status = 'livre' THEN 1 ELSE 0 END) as delivered_shipments,
                SUM(CASE WHEN s.status = 'annule' THEN 1 ELSE 0 END) as cancelled_shipments
                FROM customer_records cr 
                LEFT JOIN shipment s ON cr.id = s.customer_record_id
                WHERE cr.deletion_status = 0";
        
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère le dernier ID inséré
     */
    public function getLastInsertId() {
        return $this->bdd->lastInsertId();
    }

    /**
     * Démarre une transaction
     */
    public function beginTransaction() {
        return $this->bdd->beginTransaction();
    }

    /**
     * Valide une transaction
     */
    public function commit() {
        return $this->bdd->commit();
    }

    /**
     * Annule une transaction
     */
    public function rollBack() {
        return $this->bdd->rollBack();
    }

    /**
     * Récupère la dernière erreur
     */
    public function getLastError() {
        return $this->bdd->errorInfo()[2] ?? 'Erreur inconnue';
    }
}
?>