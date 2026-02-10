<?php
class Parcel {
    private $bdd;
    private $shipmentStatusColumn = null;
    private $shipmentHistoryStatusColumn = null;
    
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
        $statusSelect = $this->getStatusSelectExpression();
        $sql = "SELECT s.*, {$statusSelect}
                FROM shipment s 
                LEFT JOIN shipment_status ss ON ss.shipment_id = s.id
                WHERE s.customer_record_id = ?
                ORDER BY s.created_at DESC";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$customer_record_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une expédition par son ID
     */
    public function getShipmentById($id) {
        $statusSelect = $this->getStatusSelectExpression();
        $sql = "SELECT s.*, {$statusSelect}, cr.full_name, cr.email, cr.phone 
                FROM shipment s 
                LEFT JOIN shipment_status ss ON ss.shipment_id = s.id
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

            $historyStatusColumn = $this->resolveShipmentHistoryStatusColumn();
            if (!$historyStatusColumn) {
                throw new Exception("La colonne de statut est absente de la table shipment_status_history");
            }
            // Ajouter à l'historique
            $sql_history = "INSERT INTO shipment_status_history (shipment_id, {$historyStatusColumn}, notes, created_by) VALUES (?, ?, ?, ?)";
            $stmt_history = $this->bdd->prepare($sql_history);
            $historyValue = $this->mapStatusForColumn($status, $historyStatusColumn);
            $stmt_history->execute([$shipment_id, $historyValue, $notes, $user_id]);

            // Mettre à jour l'état courant dans une table dédiée
            $sql_state = "
                INSERT INTO shipment_status (shipment_id, status_code, notes, updated_at, updated_by)
                VALUES (:shipment_id, :status_code, :notes, NOW(), :user_id)
                ON DUPLICATE KEY UPDATE status_code = VALUES(status_code), notes = VALUES(notes), updated_at = NOW(), updated_by = VALUES(updated_by)";
            $stmt_state = $this->bdd->prepare($sql_state);
            $stmt_state->execute([
                'shipment_id' => $shipment_id,
                'status_code' => $status,
                'notes' => $notes,
                'user_id' => $user_id
            ]);

            // Mettre à jour éventuellement la table shipment si la colonne existe
            $this->updateShipmentTableStatus($shipment_id, $status);

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
        $historyStatusColumn = $this->resolveShipmentHistoryStatusColumn();
        $statusExpr = $historyStatusColumn ? "ssh.`{$historyStatusColumn}`" : "NULL";
        if (!$historyStatusColumn) {
            // Au moins exposer un alias status_code pour l'appelant même si la colonne est absente
            $statusSelect = ", NULL AS status_code";
        } elseif ($historyStatusColumn === 'status_code') {
            $statusSelect = "";
        } else {
            $statusSelect = ", {$statusExpr} AS status_code";
        }

        $sql = "SELECT ssh.*{$statusSelect}, u.username as created_by_name, ps.name_fr, ps.name_en, ps.badge_class
                FROM shipment_status_history ssh 
                LEFT JOIN user u ON ssh.created_by = u.id ";
        if ($historyStatusColumn) {
            $sql .= "LEFT JOIN parcel_status ps ON ps.code = {$statusExpr} ";
        } else {
            $sql .= "LEFT JOIN parcel_status ps ON 1 = 0 ";
        }
        $sql .= "WHERE ssh.shipment_id = ? 
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
     * Supprime toutes les expéditions et historiques liés à un dossier client
     */
    public function deleteShipmentsByCustomerRecord($customer_record_id) {
        // Supprimer l'historique des statuts
        $sqlHistory = "DELETE FROM shipment_status_history WHERE shipment_id IN (
            SELECT id FROM shipment WHERE customer_record_id = ?
        )";
        $stmtHistory = $this->bdd->prepare($sqlHistory);
        $stmtHistory->execute([$customer_record_id]);

        // Supprimer les expéditions
        $sqlShipments = "DELETE FROM shipment WHERE customer_record_id = ?";
        $stmtShipments = $this->bdd->prepare($sqlShipments);
        return $stmtShipments->execute([$customer_record_id]);
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
        $statusExpr = $this->getStatusExprForAggregation();
        $sql = "SELECT 
                COUNT(DISTINCT cr.id) as total_customers,
                COUNT(s.id) as total_shipments,
                SUM(CASE WHEN {$statusExpr} IN ('pending', 'en_attente') THEN 1 ELSE 0 END) as pending_shipments,
                SUM(CASE WHEN {$statusExpr} IN ('in_progress', 'en_cours') THEN 1 ELSE 0 END) as in_progress_shipments,
                SUM(CASE WHEN {$statusExpr} IN ('delivered', 'livre') THEN 1 ELSE 0 END) as delivered_shipments,
                SUM(CASE WHEN {$statusExpr} IN ('cancelled', 'annule') THEN 1 ELSE 0 END) as cancelled_shipments
                FROM customer_records cr 
                LEFT JOIN shipment s ON cr.id = s.customer_record_id
                LEFT JOIN shipment_status ss ON ss.shipment_id = s.id
                WHERE cr.deletion_status = 0";
        
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Statuts disponibles (table parcel_status)
     */
    public function getStatusDefinitions()
    {
        $sql = "SELECT code, name_en, name_fr, badge_class FROM parcel_status ORDER BY code ASC";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $definitions = [];
        foreach ($rows as $row) {
            $definitions[$row['code']] = [
                'label_en' => $row['name_en'],
                'label_fr' => $row['name_fr'],
                'badge' => $row['badge_class'] ?: 'secondary'
            ];
        }
        return $definitions;
    }

    /**
     * Template email pour un statut
     */
    public function getEmailTemplateByStatus($status_code)
    {
        $sql = "SELECT status_code, titre_email_fr, titre_email_en, objet_fr, objet_en, contenu_fr, contenu_en 
                FROM mailing 
                WHERE status_code = ? 
                ORDER BY updated_at DESC, created_at DESC 
                LIMIT 1";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$status_code]);
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

    /**
     * Retourne l'expression SQL pour sélectionner le statut courant avec alias status_code
     */
    private function getStatusSelectExpression()
    {
        $column = $this->resolveShipmentStatusColumn();
        $expr = $column ? "COALESCE(s.{$column}, ss.status_code)" : "ss.status_code";
        return $expr . " AS status_code";
    }

    /**
     * Retourne l'expression du statut pour les agrégations
     */
    private function getStatusExprForAggregation()
    {
        $column = $this->resolveShipmentStatusColumn();
        return $column ? "COALESCE(ss.status_code, s.{$column})" : "ss.status_code";
    }

    /**
     * Met à jour la colonne de statut dans la table shipment si elle existe
     */
    private function updateShipmentTableStatus($shipment_id, $status_code)
    {
        $column = $this->resolveShipmentStatusColumn();
        if (!$column) {
            return;
        }

        // Ignore legacy numeric columns that cannot hold text status codes
        if (!$this->statusColumnAcceptsString('shipment', $column)) {
            return;
        }

        $updateParts = ["{$column} = :status_code"];
        if ($this->columnExists('shipment', 'updated_at')) {
            $updateParts[] = "updated_at = NOW()";
        }
        $sql = "UPDATE shipment SET " . implode(', ', $updateParts) . " WHERE id = :shipment_id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'status_code' => $this->mapStatusForColumn($status_code, $column),
            'shipment_id' => $shipment_id
        ]);
    }

    /**
     * Vérifie la présence d'une colonne de statut sur la table shipment
     */
    private function resolveShipmentStatusColumn()
    {
        if ($this->shipmentStatusColumn !== null) {
            return $this->shipmentStatusColumn ?: null;
        }

        foreach (['status_code', 'status_id', 'status'] as $column) {
            if ($this->columnExists('shipment', $column)) {
                $this->shipmentStatusColumn = $column;
                return $column;
            }
        }

        $this->shipmentStatusColumn = '';
        return null;
    }

    /**
     * Résout la colonne de statut sur la table shipment_status_history
     */
    private function resolveShipmentHistoryStatusColumn()
    {
        if ($this->shipmentHistoryStatusColumn !== null) {
            return $this->shipmentHistoryStatusColumn ?: null;
        }

        foreach (['status_code', 'status_id', 'status', 'statut'] as $column) {
            if ($this->columnExists('shipment_status_history', $column) && $this->statusColumnAcceptsString('shipment_status_history', $column)) {
                $this->shipmentHistoryStatusColumn = $column;
                return $column;
            }
        }

        $this->shipmentHistoryStatusColumn = '';
        return null;
    }

    /**
     * Vérifie si la colonne peut accueillir une valeur texte (char/varchar/text/enum/set)
     */
    private function statusColumnAcceptsString($table, $column)
    {
        $sql = "SELECT DATA_TYPE 
                FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE TABLE_SCHEMA = DATABASE() 
                  AND TABLE_NAME = :table 
                  AND COLUMN_NAME = :column 
                LIMIT 1";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['table' => $table, 'column' => $column]);
        $type = strtolower((string)$stmt->fetchColumn());

        if (!$type) {
            return false;
        }

        $textualTypes = ['char', 'varchar', 'text', 'tinytext', 'mediumtext', 'longtext', 'enum', 'set'];
        return in_array($type, $textualTypes, true);
    }

    /**
     * Convertit le statut en valeur compatible avec une colonne héritée (ex: enum FR)
     */
    private function mapStatusForColumn($status_code, $column)
    {
        if ($column === 'status_code') {
            return $status_code;
        }

        $map = [
            'pending' => 'en_attente',
            'in_progress' => 'en_cours',
            'delivered' => 'livre',
            'cancelled' => 'annule',
        ];

        return $map[$status_code] ?? $status_code;
    }

    /**
     * Vérifie l'existence d'une colonne dans la base courante
     */
    private function columnExists($table, $column)
    {
        $sql = "SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE TABLE_SCHEMA = DATABASE() 
                  AND TABLE_NAME = :table 
                  AND COLUMN_NAME = :column 
                LIMIT 1";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['table' => $table, 'column' => $column]);
        return (bool)$stmt->fetchColumn();
    }
}
?>
