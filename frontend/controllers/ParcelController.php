<?php
require_once __DIR__ . '/../../php/function.php';
require_once __DIR__ . '/../../config/debug.php';

class ParcelController
{
    private $bdd;
    private $statusDefinitions;

    public function __construct()
    {
        global $bdd;
        $this->bdd = $bdd;
        $this->statusDefinitions = null;
    }

    /**
     * Handle parcel creation (new or existing customer)
     *
     * @param array $data Form data ($_POST)
     * @return array Result with success, message, and optional errors
     */
    public function handleCreateParcel(array $data): array
    {
        try {
            $name = clean_text($data['full_name'] ?? '');
            $phone_country = clean_text($data['phone_country'] ?? '');
            $phone_local = clean_text($data['phone_local'] ?? '');
            $email = clean_text($data['email'] ?? '');
            $address = clean_text($data['address'] ?? '');

            $phone = trim(($phone_country ? $phone_country . ' ' : '') . $phone_local);

            // Validation
            if (!$name || !$email || !$address || !$phone || !$phone_country || !$phone_local) {
                return [
                    'success' => false,
                    'message' => 'Veuillez remplir tous les champs obligatoires.'
                ];
            }

            if (empty($data['origin']) || !is_array($data['origin'])) {
                return [
                    'success' => false,
                    'message' => 'Veuillez ajouter au moins une expédition.'
                ];
            }
            if (empty($data['destination']) || empty($data['description'])) {
                return [
                    'success' => false,
                    'message' => 'Veuillez remplir les champs d\'expédition obligatoires.'
                ];
            }

            // Vérifier si le client existe déjà
            $stmt = $this->bdd->prepare("SELECT id, customer_id FROM customer_records WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->bdd->beginTransaction();

            if ($existing) {
                // ✅ Client existant → on attache de nouvelles expéditions
                $dossier_id = $existing['id'];
                $customer_id = $existing['customer_id'];
            } else {
                // 🚀 Nouveau client
                $customer_id = $this->generateRefDossier();
                $creation_date = date('Y-m-d H:i:s');
                $stmt = $this->bdd->prepare("
                    INSERT INTO customer_records (full_name, phone, email, address, customer_id, created_at)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$name, $phone, $email, $address, $customer_id, $creation_date]);
                $dossier_id = $this->bdd->lastInsertId();
            }

            // 🧾 Ajouter les expéditions
            $origins = $data['origin'];
            $destinations = $data['destination'];
            $descriptions = $data['description'];
            $comments = $data['commentaire'];

            $totalItems = count($origins);
            // Assure des longueurs cohérentes
            if ($totalItems !== count($destinations) || $totalItems !== count($descriptions)) {
                $this->bdd->rollBack();
                return [
                    'success' => false,
                    'message' => 'Veuillez compléter toutes les informations d\'expédition.'
                ];
            }

            for ($i = 0; $i < count($origins); $i++) {
                $origin = clean_text($origins[$i] ?? '');
                $destination = clean_text($destinations[$i] ?? '');
                $description = clean_text($descriptions[$i] ?? '');
                $comment = clean_text($comments[$i] ?? '');

                if (!$origin || !$destination || !$description) {
                    $this->bdd->rollBack();
                    return [
                        'success' => false,
                        'message' => 'Chaque expédition doit avoir une origine, une destination et une description. Le commentaire est facultatif.'
                    ];
                }

                $tracking_ref = $this->generateExpeditionRef($dossier_id, $customer_id);
                $created_at = date('Y-m-d H:i:s');

                $stmt = $this->bdd->prepare("
                    INSERT INTO shipment (customer_record_id, tracking_reference, origin, destination, description, comment, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$dossier_id, $tracking_ref, $origin, $destination, $description, $comment, $created_at]);
            }

            $this->bdd->commit();

            return [
                'success' => true,
                'message' => $existing
                    ? 'Nouvelles expéditions ajoutées au dossier existant.'
                    : 'Dossier client créé avec succès.',
                'customer_id' => $customer_id
            ];

        } catch (Exception $e) {
            $this->bdd->rollBack();
            error_log("Erreur création colis : " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors du traitement.',
                'errors' => [$e->getMessage()]
            ];
        }
    }

    private function generateRefDossier(): string
    {
        do {
            $uniqueId = substr(str_shuffle("0123456789"), 0, 4);
            $customer_id = 'TCC' . $uniqueId;
            $stmt = $this->bdd->prepare("SELECT id FROM customer_records WHERE customer_id = ?");
            $stmt->execute([$customer_id]);
        } while ($stmt->rowCount() > 0);
        return $customer_id;
    }

    private function generateExpeditionRef($dossier_id, $customer_id): string
    {
        $stmt = $this->bdd->prepare("SELECT COUNT(*) as total FROM shipment WHERE tracking_reference LIKE ?");
        $stmt->execute([$customer_id . '%']);
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['total'] + 1;
        return $customer_id . str_pad($count, 3, '0', STR_PAD_LEFT);
    }


public function getParcelWithExpeditions($parcelId)
{


    // Récupérer les infos du colis
    $stmt = $this->bdd->prepare("SELECT * FROM customer_records WHERE id = :id");
    $stmt->execute(['id' => $parcelId]);
    $parcel = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$parcel) {
        return null;
    }

    // Récupérer les expéditions liées
    $stmtExp =  $this->bdd->prepare("SELECT * FROM shipment WHERE customer_record_id = :id");
    $stmtExp->execute(['id' => $parcelId]);
    $parcel['expeditions'] = $stmtExp->fetchAll(PDO::FETCH_ASSOC);

    return $parcel;
}

    public function getTrackingDataByReference(string $trackingReference): ?array
    {
        $trackingReference = trim($trackingReference);
        if ($trackingReference === '') {
            return null;
        }

        $stmt = $this->bdd->prepare("
            SELECT s.*, ss.status_code AS current_status,
                   cr.id AS customer_record_id,
                   cr.customer_id,
                   cr.full_name,
                   cr.email,
                   cr.phone,
                   cr.address,
                   cr.created_at AS customer_created_at
            FROM shipment s
            JOIN customer_records cr ON cr.id = s.customer_record_id
            LEFT JOIN shipment_status ss ON ss.shipment_id = s.id
            WHERE s.tracking_reference = ?
              AND cr.deletion_status = 0
            LIMIT 1
        ");
        $stmt->execute([$trackingReference]);
        $shipment = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$shipment) {
            $stmtCustomer = $this->bdd->prepare("
                SELECT cr.*
                FROM customer_records cr
                WHERE cr.customer_id = ?
                  AND cr.deletion_status = 0
                LIMIT 1
            ");
            $stmtCustomer->execute([$trackingReference]);
            $customerRecord = $stmtCustomer->fetch(PDO::FETCH_ASSOC);

            if (!$customerRecord) {
                return null;
            }

            $customer = [
                'id' => $customerRecord['id'],
                'customer_id' => $customerRecord['customer_id'] ?? null,
                'full_name' => $customerRecord['full_name'] ?? '',
                'email' => $customerRecord['email'] ?? '',
                'phone' => $customerRecord['phone'] ?? '',
                'address' => $customerRecord['address'] ?? '',
                'created_at' => $customerRecord['created_at'] ?? null
            ];

            $shipments = $this->getShipmentsByCustomerId($customer['id']);

            return [
                'customer' => $customer,
                'shipments' => $shipments,
                'searched_tracking' => $trackingReference
            ];
        }

        $customer = [
            'id' => $shipment['customer_record_id'],
            'customer_id' => $shipment['customer_id'] ?? null,
            'full_name' => $shipment['full_name'] ?? '',
            'email' => $shipment['email'] ?? '',
            'phone' => $shipment['phone'] ?? '',
            'address' => $shipment['address'] ?? '',
            'created_at' => $shipment['customer_created_at'] ?? null
        ];

        $shipments = $this->getShipmentsByCustomerId($customer['id']);

        return [
            'customer' => $customer,
            'shipments' => $shipments,
            'searched_tracking' => $trackingReference
        ];
    }

    public function getShipmentsByCustomerId($customerRecordId): array
    {
        $stmt = $this->bdd->prepare("
            SELECT s.*, ss.status_code
            FROM shipment s
            LEFT JOIN shipment_status ss ON ss.shipment_id = s.id
            WHERE s.customer_record_id = ?
            ORDER BY s.created_at DESC
        ");
        $stmt->execute([$customerRecordId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getShipmentStatusHistory($shipmentId): array
    {
        $stmt = $this->bdd->prepare("
            SELECT ssh.*, u.username AS created_by_name, ps.name_fr, ps.name_en, ps.badge_class
            FROM shipment_status_history ssh
            LEFT JOIN user u ON ssh.created_by = u.id
            LEFT JOIN parcel_status ps ON ps.code = ssh.status_code
            WHERE ssh.shipment_id = ?
            ORDER BY ssh.created_at DESC
        ");
        $stmt->execute([$shipmentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatusDefinitions(): array
    {
        if ($this->statusDefinitions !== null) {
            return $this->statusDefinitions;
        }

        $stmt = $this->bdd->prepare("SELECT code, name_en, name_fr, badge_class FROM parcel_status ORDER BY code ASC");
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

        $this->statusDefinitions = $definitions;
        return $definitions;
    }

    public function getShipmentStatusBadge(?string $statusCode): string
    {
        if (!$statusCode) {
            return '<span class="badge bg-secondary">—</span>';
        }

        $definitions = $this->getStatusDefinitions();
        $definition = $definitions[$statusCode] ?? null;
        $lang = $_SESSION['lang'] ?? 'fr';
        $label = $definition
            ? ($lang === 'en' ? $definition['label_en'] : $definition['label_fr'])
            : $statusCode;
        $badgeClass = $definition['badge'] ?? 'secondary';
        $textClass = in_array($badgeClass, ['warning', 'info', 'light'], true) ? ' text-dark' : '';

        return '<span class="badge bg-' . $badgeClass . $textClass . '">' . htmlspecialchars($label) . '</span>';
    }

}
