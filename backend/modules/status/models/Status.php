<?php

class Status
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function getAll()
    {
        $sql = "SELECT code, name_en, name_fr, badge_class, created_at FROM parcel_status ORDER BY code";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCode($code)
    {
        $sql = "SELECT code, name_en, name_fr, badge_class, created_at FROM parcel_status WHERE code = ? LIMIT 1";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO parcel_status (code, name_en, name_fr, badge_class) VALUES (:code, :name_en, :name_fr, :badge_class)";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($code, array $data)
    {
        $fields = [];
        $params = ['code' => $code];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[$key] = $value;
        }
        if (empty($fields)) {
            return false;
        }
        $sql = "UPDATE parcel_status SET " . implode(', ', $fields) . " WHERE code = :code";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($code)
    {
        $sql = "DELETE FROM parcel_status WHERE code = ?";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute([$code]);
    }
}
