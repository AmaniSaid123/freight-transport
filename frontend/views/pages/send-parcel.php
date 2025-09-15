<!DOCTYPE html>
<html lang="en">


<?php
session_start();

include_once(__DIR__ . "/../../../php/function.php");

global $bdd;
// Fonction pour récupérer la langue principale du navigateur


if (isset($_POST['send-parcel'])) {

    // prepare message container for UI
    $form_message = '';
    $form_type = '';

    // Fonction pour générer une référence dossier unique
    function generateRefDossier($bdd)
    {
        $uniqueId = substr(str_shuffle("0123456789"), 0, 4);
        $ref_dossier = 'TCC' . $uniqueId;

        // Vérifier si déjà utilisé
        $stmt = $bdd->prepare("SELECT id FROM dossier WHERE ref_dossier = ?");
        $stmt->execute([$ref_dossier]);

        while ($stmt->rowCount() > 0) {
            $uniqueId = substr(str_shuffle("0123456789"), 0, 4);
            $ref_dossier = 'TCC' . $uniqueId;
            $stmt->execute([$ref_dossier]);
        }

        return $ref_dossier;
    }

    // Fonction pour générer une référence expédition unique
    function generateExpeditionRef($bdd, $dossier_id, $ref_dossier)
    {
        // Count existing expeditions for this dossier_id to make a sequence number
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM expedition WHERE dossier_id = ?");
        $stmt->execute([$dossier_id]);
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['total'] + 1;

        $expNumber = str_pad($count, 3, '0', STR_PAD_LEFT);
        return $ref_dossier . $expNumber;
    }

    // 👉 Traitement formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Dossier
        $name = clean_in_text($_POST['full_name']);
        $phone_country = clean_in_text($_POST['phone_country'] ?? '');
        $phone_local = clean_in_text($_POST['phone_local'] ?? '');
        // Combine country code and local number into one phone string
        $phone = trim(($phone_country ? $phone_country . ' ' : '') . $phone_local);
        $email = clean_in_text($_POST['email']);
        $address = clean_in_text($_POST['address']);

        // Basic validation
        if (!($name && $email && $address && $phone)) {
            $form_message = t('please_fill_all_fields') ?? 'Veuillez remplir tous les champs du dossier !';
            $form_type = 'error';
        } elseif (empty($_POST['origin']) || !is_array($_POST['origin'])) {
            $form_message = t('please_add_at_least_one_expedition') ?? 'Veuillez ajouter au moins une expédition.';
            $form_type = 'error';
        } else {
            // Check if email already exists to attach expeditions to existing dossier
            $stmt = $bdd->prepare("SELECT id, ref_dossier FROM dossier WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                // Existing customer: attach expeditions to existing dossier
                $existing = $stmt->fetch(PDO::FETCH_ASSOC);
                $dossier_id = $existing['id'];
                $ref_dossier = $existing['ref_dossier'];

                try {
                    $bdd->beginTransaction();

                    $origines = $_POST['origin'];
                    $destinations = $_POST['destination'];
                    $descriptions = $_POST['description'];
                    $comments = $_POST['commentaire'];

                    for ($i = 0; $i < count($origines); $i++) {
                        $origine = htmlspecialchars($origines[$i]);
                        $destination = htmlspecialchars($destinations[$i]);
                        $description = htmlspecialchars($descriptions[$i]);
                        $commentaire = htmlspecialchars($comments[$i]);

                        $ref_expedition = generateExpeditionRef($bdd, $dossier_id, $ref_dossier);
                        $creation_date = date('Y-m-d H:i:s');
                        $stmt = $bdd->prepare("INSERT INTO expedition (dossier_id, reference, origin, destination, description, comment, creation_date) 
                                               VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$dossier_id, $ref_expedition, $origine, $destination, $description, $commentaire, $creation_date]);
                    }

                    $bdd->commit();
                    // Notify user that new expeditions were persisted and clear expedition inputs
                    $form_message = t('expeditions_attached_success') ?? 'Nouvelles expéditions enregistrées avec succès.';
                    $form_type = 'success';
                    // Clear only expedition-related POST data so dossier info persists
                    unset($_POST['origin'], $_POST['destination'], $_POST['description'], $_POST['commentaire']);
                } catch (Exception $e) {
                    $bdd->rollBack();
                    $form_message = t('unexpected_error') ?? 'Une erreur est survenue lors de la création.';
                    $form_type = 'error';
                }

            } else {
                try {
                    // Start transaction
                    $bdd->beginTransaction();

                    // Générer la référence dossier
                    $ref_dossier = generateRefDossier($bdd);

                    // Insérer dossier
                    $creationdate = date('Y-m-d H:i:s');
                    $stmt = $bdd->prepare("INSERT INTO dossier (full_name, phone, email, address, ref_dossier, creationdate) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $phone, $email, $address, $ref_dossier, $creationdate]);
                    $dossier_id = $bdd->lastInsertId();

                    // Insert expeditions
                    $origines = $_POST['origin'];
                    $destinations = $_POST['destination'];
                    $descriptions = $_POST['description'];
                    $comments = $_POST['commentaire'];

                    for ($i = 0; $i < count($origines); $i++) {
                        $origine = htmlspecialchars($origines[$i]);
                        $destination = htmlspecialchars($destinations[$i]);
                        $description = htmlspecialchars($descriptions[$i]);
                        $commentaire = htmlspecialchars($comments[$i]);

                        // Générer ref expédition
                        $ref_expedition = generateExpeditionRef($bdd, $dossier_id, $ref_dossier);

                        // Insérer expédition
                        $creation_date = date('Y-m-d H:i:s');
                        $stmt = $bdd->prepare("INSERT INTO expedition (dossier_id, reference, origin, destination, description, comment, creation_date) 
                                               VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$dossier_id, $ref_expedition, $origine, $destination, $description, $commentaire, $creation_date]);
                    }

                    $bdd->commit();

                    $form_message = t('dossier_created_success') ?? "Dossier et expéditions créés avec succès ! Réf. Dossier : $ref_dossier";
                    $form_type = 'success';

                    // Clear POST so form fields reset (only on success)
                    $_POST = [];

                } catch (Exception $e) {
                    $bdd->rollBack();
                    $form_message = t('unexpected_error') ?? 'Une erreur est survenue lors de la création.';
                    $form_type = 'error';
                }
            }
        }
    }
}







?>



<style>
    /* Progress bar */
    .progress-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        position: relative;
    }

    .progress-container::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        height: 4px;
        width: 100%;
        background: #e9ecef;
        z-index: -1;
    }

    .progress-step {
        width: 35px;
        height: 35px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        color: #000;
    }

    .progress-step.active {
        background: #4b8ef1;
        color: #fff;
    }

    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }
</style>
<?php include("../layouts/head.php"); ?>

<body>



    <?php include("../layouts/topbar.php"); ?>

    <?php include("../layouts/menu.php"); ?>

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h3 class="display-7 mb-4 wow fadeInDown" data-wow-delay="0.1s"><?= t('send_parcel') ?></h1>
                <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="homepage.php"><?= t('home') ?></a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active text-black"><?= t('send_parcel') ?></li>
                </ol>
        </div>
    </div>
    <!-- Header End -->


    <div class="container-fluid appointment py-5" id="appointment">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">

                        <h1 class="display-5 mb-4"><?= t('send_parcel') ?></h1>

                        <?php if (!empty($form_message)): ?>
                            <div class="mb-3">
                                <?php if ($form_type === 'success'): ?>
                                    <div class="alert alert-success" role="alert"><?= $form_message ?></div>
                                <?php else: ?>
                                    <div class="alert alert-danger" role="alert"><?= $form_message ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <form action="send-parcel.php" method="post" novalidate>

                            <div class="row gy-3 gx-4">
                                <div class="col-md-6">
                                    <label for="full_name"
                                        class="form-label visually-hidden"><?= t('full_name') ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-primary"><i
                                                class="fa fa-user"></i></span>
                                        <input name="full_name" id="full_name" type="text"
                                            class="form-control py-3 border-primary bg-transparent"
                                            placeholder="<?= t('full_name') ?>" required aria-required="true"
                                            value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label visually-hidden"><?= t('phone') ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-primary"><i
                                                class="fa fa-phone"></i></span>
                                        <select name="phone_country" id="phone_country"
                                            class="form-select py-3 border-primary bg-transparent w-auto me-2 phone-country-select"
                                            style="max-width:110px;" required>
                                            <option value="+1" <?= (($_POST['phone_country'] ?? '') === '+1') ? 'selected' : '' ?>>🇺🇸 +1</option>
                                            <option value="+33" <?= (($_POST['phone_country'] ?? '') === '+33') ? 'selected' : '' ?>>🇫🇷 +33</option>
                                            <option value="+41" <?= (($_POST['phone_country'] ?? '') === '+41') ? 'selected' : '' ?>>🇨🇭 +41</option>
                                            <option value="+243" <?= (($_POST['phone_country'] ?? '') === '+243') ? 'selected' : '' ?>>🇨🇩 +243</option>
                                            <option value="+27" <?= (($_POST['phone_country'] ?? '') === '+27') ? 'selected' : '' ?>>🇿🇦 +27</option>
                                            <!-- add more countries as needed -->
                                        </select>
                                        <input name="phone_local" id="phone_local" type="tel" pattern="[0-9() \-]{4,20}"
                                            class="form-control py-3 border-primary bg-transparent"
                                            placeholder="<?= t('phone') ?>" required aria-required="true"
                                            value="<?= htmlspecialchars($_POST['phone_local'] ?? '') ?>">
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label visually-hidden"><?= t('email') ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-primary"><i
                                                class="fa fa-envelope"></i></span>
                                        <input name="email" id="email" type="email"
                                            class="form-control py-3 border-primary bg-transparent"
                                            placeholder="<?= t('email') ?>" required aria-required="true"
                                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="address" class="form-label visually-hidden"><?= t('address') ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-primary"><i
                                                class="fa fa-map-marker"></i></span>
                                        <input name="address" id="address" type="text"
                                            class="form-control py-3 border-primary bg-transparent"
                                            placeholder="<?= t('address') ?>" required aria-required="true"
                                            value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
                                    </div>
                                </div>

                            </div>
                            <div id="expeditions">
                                <!-- Bloc d'expédition -->
                                <div class="row gy-3 gx-4 expedition-item border rounded p-3 mb-3">
                                    <div class="col-xl-6">
                                        <label class="form-label visually-hidden"><?= t('origin') ?></label>
                                        <select class="form-select py-3 border-primary bg-transparent" name="origin[]"
                                            required>
                                            <option value="" disabled selected><?= t('select_origin') ?? t('origin') ?>
                                            </option>
                                            <option value="Chine">Chine</option>
                                        </select>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="form-label visually-hidden"><?= t('destination') ?></label>
                                        <select class="form-select py-3 border-primary bg-transparent"
                                            name="destination[]" required>
                                            <option value="" disabled selected>
                                                <?= t('select_destination') ?? t('destination') ?></option>
                                            <option value="Johannesburg">Johannesburg</option>
                                            <option value="Kinshasa">Kinshasa</option>
                                            <option value="Lubumbashi">Lubumbashi</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-6">
                                        <label class="form-label visually-hidden"><?= t('description') ?></label>
                                        <textarea class="form-control py-3 border-primary bg-transparent text-dark"
                                            placeholder="<?= t('description') ?>" name="description[]" rows="2"
                                            required></textarea>
                                    </div>
                                    <div class="col-xl-6">
                                        <label class="form-label visually-hidden"><?= t('commentaire') ?></label>
                                        <textarea class="form-control py-3 border-primary bg-transparent text-dark"
                                            placeholder="<?= t('commentaire') ?>" name="commentaire[]"
                                            rows="2"></textarea>
                                    </div>

                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-expedition"
                                            aria-label="<?= t('remove_expedition') ?>">✖</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Bouton ajouter -->
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <button type="button" id="add" class="btn btn-success">➕
                                        <?= t('add_expedition') ?></button>
                                    <button type="reset" id="resetForm" class="btn btn-secondary ms-2">↺
                                        <?= t('reset') ?></button>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary btn-lg text-white px-4"
                                        name="send-parcel">📦 <?= t('send') ?></button>
                                </div>
                            </div>





                    </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>






    <?php
    include_once("../layouts/footer.php");
    ?>


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>


    <?php include(__DIR__ . '/../layouts/js.php'); ?>

    <script>
        $(document).ready(function () {
            // Ajouter une expédition
            $("#add").click(function () {
                let newExpedition = `
                <div class="row gy-3 gx-4 expedition-item border rounded p-3 mb-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label visually-hidden"><?= t('origin') ?></label>
                        <select class="form-select py-3 border-primary bg-transparent" name="origin[]" required>
                            <option value="" disabled selected><?= t('select_origin') ?? t('origin') ?></option>
                            <option value="Chine">Chine</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label visually-hidden"><?= t('destination') ?></label>
                        <select class="form-select py-3 border-primary bg-transparent" name="destination[]" required>
                            <option value="" disabled selected><?= t('select_destination') ?? t('destination') ?></option>
                            <option value="Johannesburg">Johannesburg</option>
                            <option value="Kinshasa">Kinshasa</option>
                            <option value="Lubumbashi">Lubumbashi</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label visually-hidden"><?= t('description') ?></label>
                        <textarea class="form-control py-3 border-primary bg-transparent text-dark" placeholder="<?= t('description') ?>" name="description[]" rows="2" required></textarea>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label visually-hidden"><?= t('commentaire') ?></label>
                        <textarea class="form-control py-3 border-primary bg-transparent text-dark" placeholder="<?= t('commentaire') ?>" name="commentaire[]" rows="2"></textarea>
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-expedition" aria-label="<?= t('remove_expedition') ?>">✖</button>
                    </div>
                </div>`;
                $("#expeditions").append(newExpedition);
            });

            // Supprimer une expédition
            $(document).on("click", ".remove-expedition", function () {
                $(this).closest(".expedition-item").remove();
            });
        });
    </script>

</body>

</html>