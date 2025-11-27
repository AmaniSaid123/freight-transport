<!DOCTYPE html>
<html lang="en">


<?php
session_start();

//include_once(__DIR__ . "/../../../php/function.php");
require_once __DIR__ . '/../../includes/translation.php';

?>


<?php include(__DIR__ . '/../layouts/head.php'); ?>
<style>
    .is-invalid {
        border-color: #e74a3b !important;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #e74a3b;
    }

    .alert {
        border-radius: 0.35rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .alert-success {
        color: #1cc88a;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #e74a3b;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-info {
        color: #36b9cc;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }

    /* Animation pour le bouton */
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

<body>


    <?php include(__DIR__ . '/../layouts/topbar.php'); ?>

    <?php include(__DIR__ . '/../layouts/menu.php'); ?>

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h3 class="display-7 mb-4 wow fadeInDown" data-wow-delay="0.1s"><?= t('contact_page_title') ?></h3>
            <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="homepage.php"><?= t('home') ?></a></li>
                <li class="breadcrumb-item"><a href="#"><?= t('pages') ?></a></li>
                <li class="breadcrumb-item active text-black"><?= t('contact_page_breadcrumb') ?></li>
            </ol>
        </div>
    </div>
    <!-- Header End -->




    <div class="container-fluid feature py-5" id="contact">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">Contact Us</h4>
                </div>

            </div>
            <div class="row g-4 justify-content-center contact-warehouse">
                <section class="card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h2 class="card-title"><?= t('contact_general_info_title') ?></h2>
                    </div>
                    <p><?= t('contact_general_info_paragraph') ?></p>
                </section>
                <section class="card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <h2 class="card-title"><?= t('contact_instructions_title') ?></h2>
                    </div>
                    <p><?= t('contact_instructions_p1') ?></p>
                    <p><?= t('contact_instructions_p2') ?></p>

                    <div class="image-gallery">
                        <div class="image-card">
                            <div class="image-placeholder">
                                <img src="<?= BASE_URL ?>assets/img/tcc-Joh.jpg" alt="Johannesburg">
                            </div>

                            <div class="image-info">
                                <h3><?= t('contact_city_jhb') ?></h3>
                                <p><?= t('contact_city_jhb_desc') ?></p>
                                <a href="<?= BASE_URL ?>assets/img/tcc-Joh.jpg" class="download-btn" download><i
                                        class="fas fa-download"></i>
                                    <?= t('contact_download_file') ?></a>


                            </div>
                        </div>

                        <div class="image-card">
                            <div class="image-placeholder"> <img src="<?= BASE_URL ?>assets/img/tcc-Kin.jpg"
                                    alt="Kinshasa"></div>
                            <div class="image-info">
                                <h3><?= t('contact_city_kin') ?></h3>
                                <p><?= t('contact_city_kin_desc') ?></p>
                                <a href="<?= BASE_URL ?>assets/img/tcc-Kin.jpg" class="download-btn" download><i
                                        class="fas fa-download"></i>
                                    <?= t('contact_download_file') ?></a>
                            </div>
                        </div>

                        <div class="image-card">
                            <div class="image-placeholder">
                                <img src="<?= BASE_URL ?>assets/img/tcc-Lumb.jpg" alt="Lubumbashi">
                            </div>
                            <div class="image-info">
                                <h3><?= t('contact_city_lub') ?></h3>
                                <p><?= t('contact_city_lub_desc') ?></p>
                                <a href="<?= BASE_URL ?>assets/img/tcc-Lumb.jpg" class="download-btn" download><i
                                        class="fas fa-download"></i>
                                    <?= t('contact_download_file') ?></a>
                            </div>
                        </div>

                        <div class="image-card">
                            <div class="image-placeholder">
                                <img src="<?= BASE_URL ?>assets/img/tcc-Kwz.jpg" alt="Lubumbashi">
                            </div>
                            <div class="image-info">
                                <h3><?= t('contact_city_kwz') ?></h3>
                                <p><?= t('contact_city_kwz_desc') ?></p>
                                <a href="<?= BASE_URL ?>assets/img/tcc-Kwz.jpg" class="download-btn" download><i
                                        class="fas fa-download"></i>
                                    <?= t('contact_download_file') ?></a>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h2 class="card-title"><?= t('contact_pickup_points_title') ?></h2>
                    </div>

                    <div class="contact-grid">
                        <div class="contact-card">
                            <h4><i class="fas fa-city"></i> <?= t('contact_city_jhb_full') ?></h4>
                            <div class="address">
                                <p>Trusted Cargo Company</p>
                                <p>30 Gaunt Road</p>
                                <p>Bryanston Sandton</p>
                                <p>Johannesburg 2191</p>
                            </div>
                            <div class="contact-details">
                                <a href="mailto:<?= t('contact_email') ?>"><i class="fas fa-envelope"></i>
                                    <?= t('contact_email') ?></a>
                                <a href="tel:+27 73 298 5311"><i class="fas fa-phone"></i>
                                    +27 73 298 5311</a>
                            </div>
                        </div>


                        <div class="contact-card">
                            <h4><i class="fas fa-city"></i> <?= t('contact_city_kin_full') ?></h4>
                            <div class="address">
                                <p>Trusted Cargo Company</p>
                                <p>14, Avenue Sergent Moke</p>
                                <p>Commune de Ngaliema Kinshasa</p>
                                <p>Réf. : Rond Point Socimat</p>
                            </div>
                            <div class="contact-details">
                                <a href="mailto:<?= t('contact_email') ?>"><i class="fas fa-envelope"></i>
                                    <?= t('contact_email') ?></a>
                                <a href="tel:+243 987 020 110"><i class="fas fa-phone"></i>
                                    +243 987 020 110</a>
                            </div>
                        </div>

                        <div class="contact-card">
                            <h4><i class="fas fa-city"></i> <?= t('contact_city_lub_full') ?></h4>
                            <div class="address">
                                <p>Trusted Cargo Company</p>
                                <p>108, Avenue Kasaï</p>
                                <p>Commune de Lubumbashi</p>
                                <p>Centre-ville</p>
                                <p>Réf. : Cliniques universitaires</p>
                            </div>
                            <div class="contact-details">
                                <a href="mailto:<?= t('contact_email') ?>"><i class="fas fa-envelope"></i>
                                    <?= t('contact_email') ?></a>
                                <a href="tel:+243 852 934 920<"><i class="fas fa-phone"></i>
                                    +243 852 934 920</a>
                            </div>
                        </div>


                        <div class="contact-card">
                            <h4><i class="fas fa-city"></i> <?= t('contact_city_kwz_full') ?></h4>
                            <div class="address">
                                <p>Trusted Cargo Company</p>
                                <p> NB : <?= t('footer_contact_des_kwz') ?></p>
                            </div>
                            <div class="contact-details">
                                <a href="mailto:<?= t('contact_email') ?>"><i class="fas fa-envelope"></i>
                                    <?= t('contact_email') ?></a>
                                <a href="tel:+27 73 298 5311"><i class="fas fa-phone"></i>
                                    +243 852 934 920</a>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h2 class="card-title"><?= t('contact_hours_title') ?></h2>
                    </div>

                    <ul class="hours-list">
                        <li><span><?= t('contact_hours_weekdays_label') ?></span> <span
                                class="highlight"><?= t('contact_hours_weekdays') ?></span></li>
                        <li><span><?= t('contact_hours_saturday_label') ?></span> <span
                                class="highlight"><?= t('contact_hours_saturday') ?></span></li>
                        <li><span><?= t('contact_hours_holidays_label') ?></span> <span
                                class="highlight"><?= t('contact_hours_holidays') ?></span></li>
                    </ul>

                    <p style="margin-top: 20px; font-style: italic;"><?= t('contact_hours_holiday_note') ?></p>
                </section>
            </div>
        </div>

    </div>


    <!-- Contact Start -->
    <div class="container-fluid contact py-5" id="contact">
        <div class="container py-5">

            <div class="row g-4 align-items-center">
                <div class="col-lg-5 col-xl-5 contact-form">
                    <h2 class="display-5 text-white mb-2"><?= t('contact_form_title') ?></h2>
                    <p class="mb-4 text-white"><?= t('contact_form_description') ?> <a class="text-dark fw-bold"
                            href="#"><?= t('contact_form_download') ?></a>.</p>
                    <form id="contactForm" method="POST" action="<?= BASE_URL ?>/actions/process_contact.php">
                        <div class="row g-3">
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-transparent border border-white" id="nom"
                                        name="nom" placeholder="<?= t('contact_form_name_placeholder') ?>" required>
                                    <label for="nom"><?= t('contact_form_name_label') ?></label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control bg-transparent border border-white"
                                        id="email" name="email" placeholder="<?= t('contact_form_email_placeholder') ?>"
                                        required>
                                    <label for="email"><?= t('contact_form_email_label') ?></label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control bg-transparent border border-white"
                                        id="telephone" name="telephone"
                                        placeholder="<?= t('contact_form_phone_placeholder') ?>">
                                    <label for="telephone"><?= t('contact_form_phone_label') ?></label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-transparent border border-white"
                                        id="categorie" name="categorie"
                                        placeholder="<?= t('contact_form_project_placeholder') ?>">
                                    <label for="categorie"><?= t('contact_form_project_label') ?></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-transparent border border-white"
                                        id="sujet" name="sujet"
                                        placeholder="<?= t('contact_form_subject_placeholder') ?>" required>
                                    <label for="sujet"><?= t('contact_form_subject_label') ?></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control bg-transparent border border-white" id="message"
                                        name="message" placeholder="<?= t('contact_form_message_placeholder') ?>"
                                        style="height: 160px" required></textarea>
                                    <label for="message"><?= t('contact_form_message_label') ?></label>
                                </div>
                            </div>

                            <!-- Champ caché pour les métadonnées -->
                            <input type="hidden" name="ip_address" id="ip_address">
                            <input type="hidden" name="user_agent" id="user_agent">
                            <input type="hidden" name="lang" value="<?= $_SESSION['lang'] ?? 'fr' ?>">

                            <div class="col-12">
                                <button type="submit" class="btn btn-light text-dark py-3" id="submitBtn">
                                    <?= t('contact_form_send_button') ?>
                                </button>
                                <div id="formMessage" class="mt-3" style="display: none;"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-xl-2 ">
                    <div class="bg-transparent rounded">
                        <div class="d-flex flex-column align-items-center text-center mb-4">
                            <div class="bg-white d-flex align-items-center justify-content-center mb-3"
                                style="width: 90px; height: 90px; border-radius: 50px;"><i
                                    class="fa fa-map-marker-alt fa-2x text-dark"></i></div>
                            <h4 class="text-dark"><?= t('contact_block_addresses') ?></h4>
                        </div>
                        <div class="d-flex flex-column align-items-center text-center mb-4">
                            <div class="bg-white d-flex align-items-center justify-content-center mb-3"
                                style="width: 90px; height: 90px; border-radius: 50px;"><i
                                    class="fa fa-phone-alt fa-2x text-dark"></i></div>
                            <h4 class="text-dark"><?= t('contact_block_mobile') ?></h4>
                        </div>

                        <div class="d-flex flex-column align-items-center text-center">
                            <div class="bg-white d-flex align-items-center justify-content-center mb-3"
                                style="width: 90px; height: 90px; border-radius: 50px;"><i
                                    class="fa fa-envelope-open fa-2x text-dark"></i></div>
                            <h4 class="text-dark"><?= t('contact_block_email') ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-5" data-wow-delay="0.3s">
                    <div class="d-flex justify-content-center mb-4">
                        <a class="btn btn-lg-square btn-light rounded-circle mx-2"
                            href="https://www.facebook.com/share/1CVqVzjFVB/"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-lg-square btn-light rounded-circle mx-2" href=""><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-lg-square btn-light rounded-circle mx-2"
                            href="https://www.instagram.com/trustedcargocompany?igsh=MWlvdXo4cjIwZjlkNA=="><i
                                class="fab fa-instagram"></i></a>
                        <a class="btn btn-lg-square btn-light rounded-circle mx-2" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="rounded h-100">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <?php include(__DIR__ . '/../layouts/footer.php'); ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>


    <?php include(__DIR__ . '/../layouts/js.php'); ?>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const contactForm = document.getElementById('contactForm');
            const submitBtn = document.getElementById('submitBtn');
            const formMessage = document.getElementById('formMessage');

            // Remplir les champs cachés
            document.getElementById('ip_address').value = getUserIP();
            document.getElementById('user_agent').value = navigator.userAgent;

            contactForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Désactiver le bouton
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<?= t('contact_form_sending') ?>...';
                formMessage.style.display = 'none';

                // Récupérer les données du formulaire
                const formData = new FormData(contactForm);

                // Envoyer la requête AJAX
                fetch(contactForm.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Succès
                            showMessage(data.message, 'success');
                            contactForm.reset();
                        } else {
                            // Erreur
                            showMessage(data.message, 'danger');

                            // Afficher les erreurs de champ
                            if (data.errors) {
                                displayFieldErrors(data.errors);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMessage('Une erreur est survenue. Veuillez réessayer.', 'danger');
                    })
                    .finally(() => {
                        // Réactiver le bouton
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<?= t('contact_form_send_button') ?>';
                    });
            });

            function showMessage(message, type) {
                formMessage.innerHTML = message;
                formMessage.className = `alert alert-${type} mt-3`;
                formMessage.style.display = 'block';

                // Scroll vers le message
                formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            function displayFieldErrors(errors) {
                // Réinitialiser les erreurs
                document.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                document.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.remove();
                });

                // Afficher les nouvelles erreurs
                for (const field in errors) {
                    const input = document.getElementById(field);
                    if (input) {
                        input.classList.add('is-invalid');

                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = errors[field];

                        input.parentNode.appendChild(errorDiv);
                    }
                }
            }

            // Fonction pour obtenir l'IP de l'utilisateur
            function getUserIP() {
                return new Promise((resolve) => {
                    // Essayer d'obtenir l'IP via un service externe
                    fetch('https://api.ipify.org?format=json')
                        .then(response => response.json())
                        .then(data => resolve(data.ip))
                        .catch(() => {
                            // Fallback vers l'IP du serveur
                            resolve('<?= $_SERVER['REMOTE_ADDR'] ?>');
                        });
                });
            }

            // Initialiser avec l'IP
            getUserIP().then(ip => {
                document.getElementById('ip_address').value = ip;
            });
        });
    </script>

</body>

</html>