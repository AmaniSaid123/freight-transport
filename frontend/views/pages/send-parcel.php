<!DOCTYPE html>
<html lang="en">


<?php
session_start();
require_once __DIR__ . '/../../includes/translation.php';
include_once(__DIR__ . "/../../../php/function.php");
//require __DIR__ . '/../../../config/debug.php';


require_once __DIR__ . '/../../controllers/ParcelController.php';


global $bdd;
$controller = new ParcelController();


if (isset($_POST['send-parcel'])) {


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json; charset=utf-8');
        $result = $controller->handleCreateParcel($_POST);
        echo json_encode($result);
        exit;
    }

    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}

?>


<?php include(__DIR__ . '/../layouts/head.php'); ?>

<body>



    <?php include(__DIR__ . '/../layouts/topbar.php'); ?>
    <?php include(__DIR__ . '/../layouts/menu.php'); ?>

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


                        <form method="post" action="<?= BASE_URL ?>views/pages/send-parcel.php" novalidate>

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
                                            <option value="Johannesburg">Johannesburg</option>
                                            <option value="Kinshasa">Kinshasa</option>
                                            <option value="Lubumbashi">Lubumbashi</option>
                                            <option value="Kolwezi">Kolwezi</option>
                                        </select> </select>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="form-label visually-hidden"><?= t('destination') ?></label>
                                        <select class="form-select py-3 border-primary bg-transparent"
                                            name="destination[]" required>
                                            <option value="" disabled selected>
                                                <?= t('select_destination') ?? t('destination') ?>
                                            </option>
                                            <option value="Chine">Chine</option>
                                            <option value="Johannesburg">Johannesburg</option>
                                            <option value="Kinshasa">Kinshasa</option>
                                            <option value="Lubumbashi">Lubumbashi</option>
                                            <option value="Kolwezi">Kolwezi</option>
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
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>







    <?php include(__DIR__ . '/../layouts/footer.php'); ?>

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
                            <option value="Kolwezi">Kolwezi</option>
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

    <script>
        $(document).ready(function () {
            $("#parcelForm").on("submit", function (e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.post("<?= BASE_URL ?>controllers/api/create_parcel_action.php", formData, function (response) {
                    $(".alert-container").html("");

                    if (response.success) {
                        $(".alert-container").html(
                            `<div class="alert alert-success">${response.message}</div>`
                        );
                        setTimeout(() => {
                            window.location.href = "<?= BASE_URL ?>views/pages/detail.php?parcel_id=" + response.parcel_id;
                        }, 1000);
                        $("#parcelForm")[0].reset();
                    } else {
                        $(".alert-container").html(
                            `<div class="alert alert-danger">${response.message}</div>`
                        );
                    }
                }, "json").fail(function () {
                    $(".alert-container").html(
                        `<div class="alert alert-danger">Erreur de communication avec le serveur.</div>`
                    );
                });
            });
        });
    </script>


</body>

</html>