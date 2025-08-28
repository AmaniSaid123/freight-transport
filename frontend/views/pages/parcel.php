<?php
/** frontend/views/pages/send-parcel.php */
session_start();
include_once(__DIR__ . "/../../../php/function.php"); // fournit $bdd (PDO)

// ---------- i18n minimal (reprend ta logique) ----------
function getBrowserLanguage(): string {
    if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) return 'fr';
    $lang = substr(explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])[0] ?? 'fr', 0, 2);
    return in_array($lang, ['fr','en'], true) ? $lang : 'fr';
}
if (isset($_GET['lang']))      $_SESSION['lang'] = $_GET['lang'];
elseif (!isset($_SESSION['lang'])) $_SESSION['lang'] = getBrowserLanguage();
$lang     = $_SESSION['lang'];
$langFile = __DIR__ . "/../../lang/{$lang}.php";
$translations = file_exists($langFile) ? include $langFile : [];
function t(string $key): string {
    global $translations;
    return $translations[$key] ?? $key;
}

// ---------- helpers sûrs ----------
function safe_post(string $key): string {
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : '';
}
function generateRefDossier(PDO $pdo): string {
    do {
        $unique = substr(str_shuffle("0123456789"), 0, 4); // 4 chiffres
        $ref    = 'TCC' . $unique;
        $st = $pdo->prepare("SELECT 1 FROM dossier WHERE ref_dossier = ?");
        $st->execute([$ref]);
    } while ($st->fetchColumn());
    return $ref;
}
/** Retourne le nombre déjà présent pour ce dossier (on incrémentera ensuite en mémoire) */
function getExistingExpCount(PDO $pdo, string $reference): int {
    $st = $pdo->prepare("SELECT COUNT(*) FROM expedition WHERE reference = ?");
    $st->execute([$reference]);
    return (int)$st->fetchColumn();
}

// ---------- traitement du formulaire ----------
$errors = [];
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send-parcel'])) {
    // Dossier (client)
    $full_name = safe_post('full_name');
    $phone     = safe_post('phone');
    $email     = safe_post('email');
    $address   = safe_post('address');

    // Validations minimales
    if ($full_name === '' || $phone === '' || $email === '' || $address === '') {
        $errors[] = "Veuillez remplir tous les champs du dossier.";
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse e-mail invalide.";
    }

    // Expéditions (peuvent être multiples)
    $origins      = $_POST['origin']       ?? [];
    $destinations = $_POST['destination']  ?? [];
    $descs        = $_POST['description']  ?? [];
    $comments     = $_POST['commentaire']  ?? [];

    // On garde uniquement les lignes non vides (au moins origine + destination)
    $rows = [];
    $max = max(count($origins), count($destinations), count($descs), count($comments));
    for ($i = 0; $i < $max; $i++) {
        $o = trim((string)($origins[$i]      ?? ''));
        $d = trim((string)($destinations[$i] ?? ''));
        $de= trim((string)($descs[$i]        ?? ''));
        $co= trim((string)($comments[$i]     ?? ''));
        if ($o !== '' && $d !== '') {
            $rows[] = ['origin'=>$o, 'destination'=>$d, 'description'=>$de, 'comment'=>$co];
        }
    }
    if (empty($rows)) {
        $errors[] = "Ajoutez au moins une expédition (origine & destination).";
    }

    if (empty($errors)) {
        try {
            $bdd->beginTransaction();

            // 1) Créer le dossier
            $ref_dossier = generateRefDossier($bdd);

            $st = $bdd->prepare("
                INSERT INTO dossier (ref_dossier, full_name, phone, email, address, creationdate)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            $st->execute([$ref_dossier, $full_name, $phone, $email, $address]);
            $dossier_id = (int)$bdd->lastInsertId();

            // 2) Créer les expéditions
            $already = getExistingExpCount($bdd, $ref_dossier); // normalement 0 lors de la création
            $expStmt = $bdd->prepare("
                INSERT INTO expedition
                (dossier_id, reference, origin, destination, description, `comment`)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $i = 0;
            foreach ($rows as $r) {
                $i++;
                $seq = $already + $i; // 1, 2, 3, ...
                $ref_expedition = $ref_dossier . str_pad($seq, 3, '0', STR_PAD_LEFT);
                $expStmt->execute([
                    $dossier_id,
                    $ref_expedition,
                    $r['origin'],
                    $r['destination'],
                    $r['description'],
                    $r['comment'],
                ]);
            }

            $bdd->commit();
            $successMsg = "Dossier et expédition(s) créés avec succès. Réf. dossier : <b>{$ref_dossier}</b>";
            // Option : vider $_POST pour ne pas réafficher les valeurs après succès
            $_POST = [];
        } catch (Throwable $e) {
            if ($bdd->inTransaction()) $bdd->rollBack();
            $errors[] = "Erreur lors de l’enregistrement : " . htmlspecialchars($e->getMessage(), ENT_QUOTES);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include("../layouts/head.php"); ?>
    <style>
        .appointment-form .form-control,
        .appointment-form .form-select { min-height: 54px; }
        .expedition-item { background: rgba(255,255,255,.03); }
    </style>
</head>
<body>
<?php include("../layouts/topbar.php"); ?>
<?php include("../layouts/menu.php"); ?>

<div class="container-fluid bg-breadcrumb">
  <div class="container text-center py-5" style="max-width:900px;">
    <h1 class="text-white display-4 mb-3"><?= t('send_parcel') ?? 'Send a Parcel' ?></h1>
  </div>
</div>

<div class="container-fluid appointment py-5" id="appointment">
  <div class="container py-5">
    <div class="row g-5">
      <div class="col-lg-12">
        <div class="appointment-form rounded p-5">

          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                  <li><?= htmlspecialchars($err, ENT_QUOTES) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php elseif ($successMsg): ?>
            <div class="alert alert-success"><?= $successMsg ?></div>
          <?php endif; ?>

          <form action="" method="post" novalidate>
            <div class="row gy-3 gx-4">
              <div class="col-xl-6">
                <input type="text" name="full_name" required
                       class="form-control py-3 border-primary bg-transparent"
                       placeholder="<?= t('full_name') ?>"
                       value="<?= htmlspecialchars($_POST['full_name'] ?? '', ENT_QUOTES) ?>">
              </div>
              <div class="col-xl-6">
                <input type="tel" name="phone" required
                       class="form-control py-3 border-primary bg-transparent"
                       placeholder="<?= t('phone') ?>"
                       value="<?= htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES) ?>">
              </div>
              <div class="col-xl-6">
                <input type="email" name="email" required
                       class="form-control py-3 border-primary bg-transparent"
                       placeholder="<?= t('email') ?>"
                       value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>">
              </div>
              <div class="col-xl-6">
                <input type="text" name="address" required
                       class="form-control py-3 border-primary bg-transparent"
                       placeholder="<?= t('address') ?>"
                       value="<?= htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES) ?>">
              </div>
            </div>

            <div id="expeditions" class="mt-4">
              <!-- 1er bloc d’expédition -->
              <div class="row gy-3 gx-4 expedition-item border rounded p-3 mb-3">
                <div class="col-xl-6">
                  <select class="form-select py-3 border-primary bg-transparent" name="origin[]" required>
                    <option value="" disabled selected><?= t('origin') ?></option>
                    <option value="Chine">Chine</option>
                  </select>
                </div>
                <div class="col-xl-6">
                  <select class="form-select py-3 border-primary bg-transparent" name="destination[]" required>
                    <option value="" disabled selected><?= t('destination') ?></option>
                    <option value="Johannesburg">Johannesburg</option>
                    <option value="Kinshasa">Kinshasa</option>
                    <option value="Lubumbashi">Lubumbashi</option>
                  </select>
                </div>
                <div class="col-xl-6">
                  <textarea class="form-control py-3 border-primary bg-transparent"
                            name="description[]" placeholder="<?= t('description') ?>"></textarea>
                </div>
                <div class="col-xl-6">
                  <textarea class="form-control py-3 border-primary bg-transparent"
                            name="commentaire[]" placeholder="<?= t('commentaire') ?>"></textarea>
                </div>
                <div class="col-12 text-end">
                  <button type="button" class="btn btn-danger btn-sm remove-expedition">❌ Supprimer</button>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <button type="button" id="add" class="btn btn-primary">➕ Ajouter une expédition</button>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary text-white w-100 py-3 px-5" name="send-parcel">
                📦 Envoyer
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include("../layouts/footer.php"); ?>

<a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
$(function(){
  $("#add").on("click", function(){
    const tpl = `
    <div class="row gy-3 gx-4 expedition-item border rounded p-3 mb-3">
      <div class="col-xl-6">
        <select class="form-select py-3 border-primary bg-transparent" name="origin[]" required>
          <option value="" disabled selected><?= t('origin') ?></option>
          <option value="Chine">Chine</option>
        </select>
      </div>
      <div class="col-xl-6">
        <select class="form-select py-3 border-primary bg-transparent" name="destination[]" required>
          <option value="" disabled selected><?= t('destination') ?></option>
          <option value="Johannesburg">Johannesburg</option>
          <option value="Kinshasa">Kinshasa</option>
          <option value="Lubumbashi">Lubumbashi</option>
        </select>
      </div>
      <div class="col-xl-6">
        <textarea class="form-control py-3 border-primary bg-transparent" name="description[]"
                  placeholder="<?= t('description') ?>"></textarea>
      </div>
      <div class="col-xl-6">
        <textarea class="form-control py-3 border-primary bg-transparent" name="commentaire[]"
                  placeholder="<?= t('commentaire') ?>"></textarea>
      </div>
      <div class="col-12 text-end">
        <button type="button" class="btn btn-danger btn-sm remove-expedition">❌ Supprimer</button>
      </div>
    </div>`;
    $("#expeditions").append(tpl);
  });

  $(document).on("click", ".remove-expedition", function(){
    $(this).closest(".expedition-item").remove();
  });
});
</script>
</body>
</html>
