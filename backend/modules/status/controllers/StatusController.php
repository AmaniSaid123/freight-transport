<?php

class StatusController
{
    private $model;

    public function __construct($bdd)
    {
        $this->model = new Status($bdd);
    }

    public function list()
    {
        return $this->model->getAll();
    }

    public function get($code)
    {
        return $this->model->getByCode($code);
    }

    public function getAllStatuses()
    {
        return $this->list();
    }

    public function create(array $data)
    {
        $errors = $this->validate($data, true);
        if ($errors) {
            return ['success' => false, 'errors' => $errors, 'message' => 'Merci de corriger les champs'];
        }
        try {
            $ok = $this->model->create([
                'code' => trim($data['code']),
                'name_en' => trim($data['name_en']),
                'name_fr' => trim($data['name_fr']),
                'badge_class' => trim($data['badge_class'] ?? 'secondary'),
            ]);
            return ['success' => $ok, 'message' => $ok ? 'Statut créé' : 'Création impossible'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function update($code, array $data)
    {
        $errors = $this->validate($data, false);
        if ($errors) {
            return ['success' => false, 'errors' => $errors, 'message' => 'Merci de corriger les champs'];
        }
        try {
            $payload = [
                'name_en' => trim($data['name_en']),
                'name_fr' => trim($data['name_fr']),
                'badge_class' => trim($data['badge_class'] ?? 'secondary'),
            ];
            $ok = $this->model->update($code, $payload);
            return ['success' => $ok, 'message' => $ok ? 'Statut mis à jour' : 'Mise à jour impossible'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete($code)
    {
        if (empty($code)) {
            return ['success' => false, 'message' => 'Code requis'];
        }
        try {
            $ok = $this->model->delete($code);
            return ['success' => $ok, 'message' => $ok ? 'Statut supprimé' : 'Suppression impossible (références existantes?)'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function validate(array $data, $checkCode = false)
    {
        $errors = [];
        if ($checkCode && empty(trim($data['code'] ?? ''))) {
            $errors['code'] = 'Code requis';
        }
        if (empty(trim($data['name_en'] ?? ''))) {
            $errors['name_en'] = 'Nom (EN) requis';
        }
        if (empty(trim($data['name_fr'] ?? ''))) {
            $errors['name_fr'] = 'Nom (FR) requis';
        }
        return $errors;
    }
}

?>
