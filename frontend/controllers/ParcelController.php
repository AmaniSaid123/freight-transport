<?php
require_once __DIR__ . '/../../php/function.php';
require_once __DIR__ . '/../../config/debug.php';

class ParcelController
{
    private $bdd;

    public function __construct()
    {
        global $bdd;
        $this->bdd = $bdd;
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
            if (!$name || !$email || !$address || !$phone) {
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

            for ($i = 0; $i < count($origins); $i++) {
                $origin = htmlspecialchars($origins[$i]);
                $destination = htmlspecialchars($destinations[$i]);
                $description = htmlspecialchars($descriptions[$i]);
                $comment = htmlspecialchars($comments[$i]);

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

}
