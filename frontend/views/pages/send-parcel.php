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

$form_message = null;
$form_type = null;

if (isset($_POST['send-parcel'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = $controller->handleCreateParcel($_POST);
        $form_message = $result['message'] ?? '';
        $form_type = (!empty($result['success']) ? 'success' : 'error');
        if (!empty($result['success'])) {
            // Clear fields on success
            $_POST = [];
        }
    } else {
        http_response_code(405);
        $form_message = 'Méthode non autorisée';
        $form_type = 'error';
    }
}

?>


<?php include(__DIR__ . '/../layouts/head.php'); ?>

<body>



    <?php include(__DIR__ . '/../layouts/topbar.php'); ?>
    <?php include(__DIR__ . '/../layouts/menu.php'); ?>

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h3 class="display-7 mb-4 wow fadeInDown" data-wow-delay="0.1s"><?= t('send_parcel') ?></h3>
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

                        <h1 class="display-5 mb-3"><?= t('send_parcel') ?></h1>
                        <p class="text-muted lead fw-normal mb-4 send-parcel-subtitle">
                            <?= t('send_parcel_subtitle') ?>
                        </p>

                        <?php if (!empty($form_message)): ?>
                            <div class="mb-3">
                                <?php if ($form_type === 'success'): ?>
                                    <div class="alert alert-success" role="alert"><?= $form_message ?></div>
                                <?php else: ?>
                                    <div class="alert alert-danger" role="alert"><?= $form_message ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>


                        <form id="sendParcelForm" method="post" action="<?= BASE_URL ?>views/pages/send-parcel.php" novalidate>

                            <div class="send-parcel-shell">
                                <div class="form-intro bg-light rounded-4 p-4 mb-4 d-flex flex-wrap align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="pill pill-primary"><?= t('send_parcel') ?></div>
                                        <div class="text-muted small">
                                            <span class="me-3"><i class="fa fa-check-circle text-success me-1"></i><?= t('full_name') ?></span>
                                            <span class="me-3"><i class="fa fa-check-circle text-success me-1"></i><?= t('origin') ?>/<?= t('destination') ?></span>
                                            <span><i class="fa fa-check-circle text-success me-1"></i><?= t('description') ?></span>
                                        </div>
                                    </div>
                                    <div class="chip-badge">
                                        <i class="fa fa-bolt me-2"></i><?= t('express_shipping') ?>
                                    </div>
                                </div>

                                <div class="row g-4 align-items-stretch">
                                    <div class="col-lg-6">
                                        <div class="section-card shadow-sm h-100">
                                            <div class="section-card__header">
                                                <div class="pill pill-soft">1</div>
                                                <div>
                                                    <h2 class="h5 mb-1"><?= t('send_parcel_step1_title') ?></h2>
                                                    <p class="text-muted small mb-0"><?= t('send_parcel_step1_desc') ?></p>
                                                </div>
                                            </div>
                                            <div class="client-toggle d-flex align-items-center gap-2 mb-3">
                                                <div class="form-check form-switch mb-0">
                                                    <input class="form-check-input" type="checkbox" id="clientToggle" name="client_mode">
                                                    <label class="form-check-label" for="clientToggle"><?= t('client_toggle_label') ?></label>
                                                </div>
                       
                                            </div>
                                            <div class="row gy-3">
                                                <div class="col-12 client-hide">
                                                    <label for="full_name" class="form-label small text-muted"><?= t('full_name') ?> <span class="required-dot">*</span></label>
                                                    <div class="input-group modern-input">
                                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                        <input name="full_name" id="full_name" type="text"
                                                            class="form-control"
                                                            placeholder="<?= t('full_name') ?>" required aria-required="true"
                                                            value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>"
                                                            data-required="full_name">
                                                    </div>
                                                    <div class="field-error" data-error-for="full_name"></div>
                                                </div>

                                                <div class="col-12 client-hide">
                                                    <label class="form-label small text-muted"><?= t('phone') ?> <span class="required-dot">*</span></label>
                                                    <div class="input-group modern-input flex-wrap">
                                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                        <select name="phone_country" id="phone_country"
                                                            class="form-select phone-country-select"
                                                            required data-required="phone_country">
                                                            <option value="+1" <?= (($_POST['phone_country'] ?? '') === '+1') ? 'selected' : '' ?>>🇺🇸 +1</option>
                                                            <option value="+33" <?= (($_POST['phone_country'] ?? '') === '+33') ? 'selected' : '' ?>>🇫🇷 +33</option>
                                                            <option value="+41" <?= (($_POST['phone_country'] ?? '') === '+41') ? 'selected' : '' ?>>🇨🇭 +41</option>
                                                            <option value="+243" <?= (($_POST['phone_country'] ?? '') === '+243') ? 'selected' : '' ?>>🇨🇩 +243</option>
                                                            <option value="+27" <?= (($_POST['phone_country'] ?? '') === '+27') ? 'selected' : '' ?>>🇿🇦 +27</option>
                                                        </select>
                                                        <input name="phone_local" id="phone_local" type="tel" pattern="[0-9() \-]{4,20}"
                                                            class="form-control"
                                                            placeholder="<?= t('phone') ?>" required aria-required="true"
                                                            value="<?= htmlspecialchars($_POST['phone_local'] ?? '') ?>"
                                                            data-required="phone_local">
                                                    </div>
                                                    <div class="field-error" data-error-for="phone"></div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="email" class="form-label small text-muted"><?= t('email') ?> <span class="required-dot">*</span></label>
                                                    <div class="input-group modern-input">
                                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                                        <input name="email" id="email" type="email"
                                                            class="form-control"
                                                            placeholder="<?= t('email') ?>" required aria-required="true"
                                                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                                            data-required="email">
                                                    </div>
                                                    <div class="field-error" data-error-for="email"></div>
                                                </div>

                                                <div class="col-12 client-hide">
                                                    <label for="address" class="form-label small text-muted"><?= t('address') ?> <span class="required-dot">*</span></label>
                                                    <div class="input-group modern-input">
                                                        <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                                        <input name="address" id="address" type="text"
                                                            class="form-control"
                                                            placeholder="<?= t('address') ?>" required aria-required="true"
                                                            value="<?= htmlspecialchars($_POST['address'] ?? '') ?>"
                                                            data-required="address">
                                                    </div>
                                                    <div class="field-error" data-error-for="address"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="section-card shadow-sm section-card--accent h-100">
                                            <div class="section-card__header justify-content-between align-items-start flex-wrap">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="pill pill-soft">2</div>
                                                    <div>
                                                        <h2 class="h5 mb-1"><?= t('send_parcel_step2_title') ?></h2>
                                                        <p class="text-muted small mb-0"><?= t('send_parcel_step2_desc') ?></p>
                                                    </div>
                                                </div>
                                                <div class="chip-badge chip-badge--ghost">
                                                    <i class="fa fa-layer-group me-2"></i><?= t('add_expedition') ?>
                                                </div>
                                            </div>

                                            <div id="expeditions" class="expedition-stack">
                                                <!-- Bloc d'expédition -->
                                                <div class="row gy-3 gx-3 expedition-item expedition-card">
                                                    <div class="expedition-card__meta">
                                                        <div class="chip-badge"><?= t('expedition_label') ?> #1</div>
                                                        <button type="button" class="btn btn-link text-danger btn-sm remove-expedition" aria-label="<?= t('remove_expedition') ?>">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <label class="form-label small text-muted"><?= t('origin') ?> <span class="required-dot">*</span></label>
                                                        <select class="form-select" name="origin[]"
                                                            required data-required="origin">
                                                            <option value="" disabled selected><?= t('select_origin') ?? t('origin') ?>
                                                            </option>
                                                            <option value="Chine">Chine</option>
                                                            <option value="Johannesburg">Johannesburg</option>
                                                            <option value="Kinshasa">Kinshasa</option>
                                                            <option value="Lubumbashi">Lubumbashi</option>
                                                            <option value="Kolwezi">Kolwezi</option>
                                                        </select>
                                                        <div class="field-error" data-error-for="origin"></div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <label class="form-label small text-muted"><?= t('destination') ?> <span class="required-dot">*</span></label>
                                                        <select class="form-select"
                                                            name="destination[]" required data-required="destination">
                                                            <option value="" disabled selected>
                                                                <?= t('select_destination') ?? t('destination') ?>
                                                            </option>
                                                            <option value="Chine">Chine</option>
                                                            <option value="Johannesburg">Johannesburg</option>
                                                            <option value="Kinshasa">Kinshasa</option>
                                                            <option value="Lubumbashi">Lubumbashi</option>
                                                            <option value="Kolwezi">Kolwezi</option>
                                                        </select>
                                                        <div class="field-error" data-error-for="destination"></div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <label class="form-label small text-muted"><?= t('description') ?> <span class="required-dot">*</span></label>
                                                        <textarea class="form-control"
                                                            placeholder="<?= t('description') ?>" name="description[]" rows="2"
                                                            required data-required="description"></textarea>
                                                        <div class="field-error" data-error-for="description"></div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <label class="form-label small text-muted"><?= t('commentaire') ?></label>
                                                        <textarea class="form-control"
                                                            placeholder="<?= t('commentaire') ?>" name="commentaire[]"
                                                            rows="2"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="soft-divider my-4"></div>
                                            <!-- Bouton ajouter -->
                                            <div class="form-actions d-flex justify-content-between align-items-center flex-wrap gap-3">
                                                <div class="d-flex gap-2">
                                                    <button type="button" id="add" class="btn btn-outline-primary rounded-pill px-4">
                                                        <i class="fa fa-plus me-2"></i><?= t('add_expedition') ?>
                                                    </button>
                                                    <button type="reset" id="resetForm" class="btn btn-reset">
                                                        <i class="fa fa-undo me-2"></i><?= t('reset') ?>
                                                    </button>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-send"
                                                        name="send-parcel"><i class="fa fa-box me-2"></i><?= t('send') ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                const expeditionNumber = $(".expedition-item").length + 1;
                let newExpedition = `
                <div class="row gy-3 gx-3 expedition-item expedition-card">
                    <div class="expedition-card__meta">
                        <div class="chip-badge"><?= t('expedition_label') ?> #${expeditionNumber}</div>
                        <button type="button" class="btn btn-link text-danger btn-sm remove-expedition" aria-label="<?= t('remove_expedition') ?>">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted"><?= t('origin') ?> <span class="required-dot">*</span></label>
                        <select class="form-select" name="origin[]" required data-required="origin">
                            <option value="" disabled selected><?= t('select_origin') ?? t('origin') ?></option>
                            <option value="Chine">Chine</option>
                            <option value="Johannesburg">Johannesburg</option>
                            <option value="Kinshasa">Kinshasa</option>
                            <option value="Lubumbashi">Lubumbashi</option>
                            <option value="Kolwezi">Kolwezi</option>
                        </select>
                        <div class="field-error" data-error-for="origin"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted"><?= t('destination') ?> <span class="required-dot">*</span></label>
                        <select class="form-select" name="destination[]" required data-required="destination">
                            <option value="" disabled selected><?= t('select_destination') ?? t('destination') ?></option>
                            <option value="Chine">Chine</option>
                            <option value="Johannesburg">Johannesburg</option>
                            <option value="Kinshasa">Kinshasa</option>
                            <option value="Lubumbashi">Lubumbashi</option>
                            <option value="Kolwezi">Kolwezi</option>
                        </select>
                        <div class="field-error" data-error-for="destination"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted"><?= t('description') ?> <span class="required-dot">*</span></label>
                        <textarea class="form-control" placeholder="<?= t('description') ?>" name="description[]" rows="2" required data-required="description"></textarea>
                        <div class="field-error" data-error-for="description"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted"><?= t('commentaire') ?></label>
                        <textarea class="form-control" placeholder="<?= t('commentaire') ?>" name="commentaire[]" rows="2"></textarea>
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
            const form = document.getElementById('sendParcelForm');
            const clientToggle = document.getElementById('clientToggle');
            const emailField = document.getElementById('email');
            const contactFields = form.querySelectorAll('.client-hide input, .client-hide select');
            const messages = {
                full_name: "<?= t('required_full_name') ?>",
                phone: "<?= t('required_phone') ?>",
                email: "<?= t('required_email') ?>",
                address: "<?= t('required_address') ?>",
                origin: "<?= t('required_origin') ?>",
                destination: "<?= t('required_destination') ?>",
                description: "<?= t('required_description') ?>"
            };

            const clearErrors = (context) => {
                context.querySelectorAll('.field-error').forEach(el => el.textContent = '');
            };

            const setError = (field, message) => {
                const errEl = field.closest('.col-md-6, .col-xl-6, .col-12')?.querySelector('.field-error[data-error-for]');
                if (errEl) errEl.textContent = message;
            };

            const toggleClientMode = () => {
                const isClient = clientToggle.checked;
                form.classList.toggle('client-mode', isClient);
                contactFields.forEach(el => {
                    el.disabled = isClient;
                });
                emailField.disabled = false;
                emailField.readOnly = false;
            };

            toggleClientMode();
            clientToggle.addEventListener('change', toggleClientMode);

            form.addEventListener('submit', function (e) {
                clearErrors(form);
                let hasError = false;

                const requiredFields = [
                    { selector: '[data-required=\"full_name\"]', message: messages.full_name },
                    { selector: '[data-required=\"phone_country\"]', message: messages.phone },
                    { selector: '[data-required=\"phone_local\"]', message: messages.phone },
                    { selector: '[data-required=\"email\"]', message: messages.email },
                    { selector: '[data-required=\"address\"]', message: messages.address }
                ];

                requiredFields.forEach(({ selector, message }) => {
                    const field = form.querySelector(selector);
                    if (field && !field.disabled && !field.value.trim()) {
                        setError(field, message);
                        hasError = true;
                    }
                });

                // Expeditions validation
                const expeditions = form.querySelectorAll('.expedition-item');
                expeditions.forEach(exp => {
                    const origin = exp.querySelector('[data-required=\"origin\"]');
                    const destination = exp.querySelector('[data-required=\"destination\"]');
                    const description = exp.querySelector('[data-required=\"description\"]');

                    if (origin && !origin.value) {
                        setError(origin, messages.origin);
                        hasError = true;
                    }
                    if (destination && !destination.value) {
                        setError(destination, messages.destination);
                        hasError = true;
                    }
                    if (description && !description.value.trim()) {
                        setError(description, messages.description);
                        hasError = true;
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    // Ensure email is submitted even if disabled
                    emailField.disabled = false;
                    emailField.readOnly = false;
                }
            });
        });
    </script>


</body>

</html>
