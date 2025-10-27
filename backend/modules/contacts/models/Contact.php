<?php
class Contact {
    private $bdd;
    
    public function __construct($database) {
        $this->bdd = $database;
    }

    /**
     * Récupère tous les contacts
     */
    public function getAllContacts($filters = []) {
        $sql = "SELECT c.*, u.username as reponse_par_nom 
                FROM contact c 
                LEFT JOIN user u ON c.reponse_par = u.id 
                WHERE 1=1";
        
        $params = [];
        
        // Filtres
        if (!empty($filters['statut'])) {
            $sql .= " AND c.statut = ?";
            $params[] = $filters['statut'];
        }
        
        if (!empty($filters['priorite'])) {
            $sql .= " AND c.priorite = ?";
            $params[] = $filters['priorite'];
        }
        
        if (!empty($filters['categorie'])) {
            $sql .= " AND c.categorie = ?";
            $params[] = $filters['categorie'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (c.nom LIKE ? OR c.email LIKE ? OR c.sujet LIKE ? OR c.message LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY 
            CASE c.priorite 
                WHEN 'urgente' THEN 1
                WHEN 'haute' THEN 2
                WHEN 'normale' THEN 3
                WHEN 'basse' THEN 4
            END,
            c.date_creation DESC";
        
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un contact par son ID
     */
    public function getContactById($id) {
        $sql = "SELECT c.*, u.username as reponse_par_nom 
                FROM contact c 
                LEFT JOIN user u ON c.reponse_par = u.id 
                WHERE c.id = ?";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour le statut d'un contact
     */
    public function updateStatus($id, $statut, $user_id = null) {
        $sql = "UPDATE contact SET statut = ?, date_modification = NOW()";
        $params = [$statut];
        
        if ($user_id) {
            $sql .= ", reponse_par = ?";
            $params[] = $user_id;
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $id;
        
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Ajoute une réponse à un contact
     */
    public function addResponse($id, $reponse, $user_id) {
        $sql = "UPDATE contact SET 
                reponse = ?,
                reponse_par = ?,
                statut = 'repondu',
                date_reponse = NOW(),
                date_modification = NOW()
                WHERE id = ?";
        
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute([$reponse, $user_id, $id]);
    }

    /**
     * Ajoute une note interne
     */
    public function addInternalNote($id, $note, $user_id) {
        $sql = "UPDATE contact SET 
                notes_interne = CONCAT(IFNULL(notes_interne, ''), '\n', ?),
                date_modification = NOW()
                WHERE id = ?";
        
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute([$note, $id]);
    }

    /**
     * Récupère les statistiques
     */
    public function getStats() {
        $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN statut = 'nouveau' THEN 1 ELSE 0 END) as nouveaux,
                SUM(CASE WHEN statut = 'lu' THEN 1 ELSE 0 END) as lus,
                SUM(CASE WHEN statut = 'en_cours' THEN 1 ELSE 0 END) as en_cours,
                SUM(CASE WHEN statut = 'repondu' THEN 1 ELSE 0 END) as repondus,
                SUM(CASE WHEN statut = 'ferme' THEN 1 ELSE 0 END) as fermes,
                SUM(CASE WHEN priorite = 'urgente' THEN 1 ELSE 0 END) as urgents,
                SUM(CASE WHEN priorite = 'haute' THEN 1 ELSE 0 END) as haut,
                SUM(CASE WHEN priorite = 'normale' THEN 1 ELSE 0 END) as normale,
                SUM(CASE WHEN priorite = 'basse' THEN 1 ELSE 0 END) as basse
                FROM contact";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les catégories existantes
     */
    public function getCategories() {
        $sql = "SELECT DISTINCT categorie FROM contact WHERE categorie IS NOT NULL AND categorie != ''";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Récupère la dernière erreur
     */
    public function getLastError() {
        return $this->bdd->errorInfo()[2] ?? 'Erreur inconnue';
    }
}
?>