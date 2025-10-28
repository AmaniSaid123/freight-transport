<?php
// Inclure la connexion PDO une seule fois


/**
 * Vérifie l'accès d'un profil à un contenu
 */
function get_access(PDO $bdd, int $ref, int $userprofile): int
{
    $stmt = $bdd->prepare(
        "SELECT COUNT(*) AS valide
         FROM profile_content pc
         JOIN content c ON c.id = pc.id_content
         WHERE c.status = 'active' AND pc.id_content = :ref AND pc.id_profile = :profile"
    );

    $stmt->execute([
        ':ref' => $ref,
        ':profile' => $userprofile
    ]);

    $donnee = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int) $donnee['valide'];
}

/**
 * Récupère les données d'un utilisateur par username
 */
function get_user_data_by_username(PDO $bdd, string $username): array
{
    $stmt = $bdd->prepare(
        "SELECT *, 1 AS is_exist
         FROM user
         WHERE username = :username
         LIMIT 1"
    );
    $stmt->execute([':username' => $username]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data ?: [];
}


function update_user_lastlogon(PDO $bdd, string $username): int
{
    $stmt = $bdd->prepare(
        "UPDATE user SET lastlogon = NOW() WHERE username = :username"
    );
    $stmt->execute([':username' => $username]);

    return $stmt->rowCount();
}



// Fonctions pour le dashboard adaptées à TrustedCargo

/**
 * Récupère le nombre total d'expéditions
 */
function get_total_shipments($bdd)
{
    $sql = "SELECT COUNT(*) as total FROM shipment";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}

/**
 * Récupère le nombre d'expéditions du mois en cours
 */
function get_monthly_shipments($bdd)
{
    $current_month = date('Y-m');
    $sql = "SELECT COUNT(*) as count FROM shipment 
            WHERE DATE_FORMAT(created_at, '%Y-%m') = :current_month";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':current_month', $current_month);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] ?? 0;
}

/**
 * Récupère le nombre total de clients
 */
function get_total_customers($bdd)
{
    $sql = "SELECT COUNT(*) as total FROM customer_records WHERE deletion_status = 0";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}

/**
 * Récupère le nombre d'expéditions par destination
 */
function get_shipments_by_destination($bdd)
{
    $sql = "SELECT 
                destination,
                COUNT(*) as count
            FROM shipment 
            GROUP BY destination
            ORDER BY count DESC";

    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les données pour le graphique des expéditions mensuelles
 */
function get_monthly_shipments_chart($bdd)
{
    $sql = "SELECT 
                MONTH(created_at) as month,
                YEAR(created_at) as year,
                COUNT(*) as shipments_count
            FROM shipment 
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY year, month
            LIMIT 12";

    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les expéditions récentes avec les informations clients
 */
function get_recent_shipments($bdd, $limit = 5)
{
    $sql = "SELECT 
                s.*,
                cr.full_name as customer_name,
                cr.phone as customer_phone
            FROM shipment s 
            LEFT JOIN customer_records cr ON s.customer_record_id = cr.id 
            WHERE cr.deletion_status = 0
            ORDER BY s.created_at DESC 
            LIMIT :limit";

    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les statistiques par destination
 */
function get_destination_stats($bdd)
{
    $sql = "SELECT 
                destination,
                COUNT(*) as total_shipments,
                MIN(created_at) as first_shipment,
                MAX(created_at) as last_shipment
            FROM shipment 
            GROUP BY destination
            ORDER BY total_shipments DESC";

    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère le top des clients avec le plus d'expéditions
 */
function get_top_customers($bdd, $limit = 5)
{
    $sql = "SELECT 
                cr.full_name,
                cr.phone,
                cr.email,
                COUNT(s.id) as total_shipments
            FROM customer_records cr
            LEFT JOIN shipment s ON cr.id = s.customer_record_id
            WHERE cr.deletion_status = 0
            GROUP BY cr.id, cr.full_name, cr.phone, cr.email
            ORDER BY total_shipments DESC
            LIMIT :limit";

    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
