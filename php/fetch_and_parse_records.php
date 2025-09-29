<?php
// Inclure la connexion PDO une seule fois


/**
 * Vérifie l'accès d'un profil à un contenu
 */
function get_access(PDO $bdd, int $ref, int $userprofile): int
{
    $stmt = $bdd->prepare(
        "SELECT COUNT(*) AS valide
         FROM profil_content pc
         JOIN content c ON c.id = pc.id_content
         WHERE c.status = 'a' AND pc.id_content = :ref AND pc.id_profil = :profile"
    );
    $stmt->execute([
        ':ref' => $ref,
        ':profile' => $userprofile
    ]);

    $donnee = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int)$donnee['valide'];
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