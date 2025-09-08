<!-- Navbar & Hero Start -->
<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
        <a href="index.html" class="navbar-brand p-0">

            <img src="<?= BASE_URL ?>assets/img/logo.svg" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="#home" class="nav-item nav-link active"><?= t('home') ?></a>
                <a href="#about" class="nav-item nav-link"><?= t('about') ?></a>
                <a href="#services" class="nav-item nav-link"><?= t('services') ?></a>
                <a href="#tracking" class="nav-item nav-link"><?= t('tracking') ?></a>
                <a href="#values" class="nav-item nav-link"><?= t('values') ?></a>
                <a href="#process" class="nav-item nav-link"><?= t('proceed') ?></a>
                <a href="#price" class="nav-item nav-link"><?= t('prices') ?></a>
                <a href="contact.php" class="nav-item nav-link"><?= t('contact') ?></a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><?= t('language') ?></a>
                    <div class="dropdown-menu m-0">

                        <a href="?lang=fr" class="dropdown-item"><?= t('french') ?></a>
                        <a href="?lang=en" class="dropdown-item"><?= t('english') ?></a>
                    </div>
                </div>
            </div>
            <a href="send-parcel.php"
                class="btn btn-primary rounded-pill text-white py-2 px-4 flex-wrap flex-sm-shrink-0">
                <?= t('send_parcel') ?>
            </a>
        </div>

    </nav>

    <?php
    // Récupère le chemin du script courant
    $currentRoute = $_SERVER['SCRIPT_NAME'];

    // Vérifie si on est sur homepage.php
    if (basename($currentRoute) === 'index.php'): ?>
        <div class="header-carousel owl-carousel">
            <!-- Carousel Start -->

            <div class="header-carousel-item">
                <img src="<?= BASE_URL ?>assets/img/carousel-1.jpg" class="img-fluid w-100" alt="Image">
                <div class="carousel-caption">
                    <div class="carousel-caption-content p-3">
                        <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">
                            <?= t('carousel-1') ?>
                        </h5>
                        <h1 class="display-1 text-white mb-4"><?= t('carousel-text-1') ?></h1>
                        <p class="mb-5 fs-5"><?= t('carousel-description-1') ?>
                        </p>
                        <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="send-parcel.php">
                            <?= t('send_parcel') ?></a>
                    </div>
                </div>
            </div>
            <div class="header-carousel-item">
                <img src="<?= BASE_URL ?>assets/img/carousel-2.jpg" class="img-fluid w-100" alt="Image">
                <div class="carousel-caption">
                    <div class="carousel-caption-content p-3">
                        <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">
                            <?= t('carousel-2') ?>
                        </h5>
                        <h1 class="display-1 text-white mb-4"><?= t('carousel-text-2') ?></h1>
                        <p class="mb-5 fs-5 animated slideInDown"><?= t('carousel-description-2') ?>
                        </p>
                        <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#"><?= t('send_parcel') ?></a>
                    </div>
                </div>
            </div>

            <!-- Carousel End -->
        </div>
    <?php endif; ?>

</div>
<!-- Navbar & Hero End -->