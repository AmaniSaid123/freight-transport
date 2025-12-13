<!DOCTYPE html>
<html lang="en">

<?php
session_start();
require_once __DIR__ . '/../../includes/translation.php';
?>

<?php include(__DIR__ . '/../layouts/head.php'); ?>
<style>

</style>

<body>

    <?php include(__DIR__ . '/../layouts/topbar.php'); ?>

    <?php include(__DIR__ . '/../layouts/menu.php'); ?>

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h3 class="display-7 mb-4 wow fadeInDown" data-wow-delay="0.1s"><?= t('routes_china_page_title') ?></h3>
            <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="homepage.php"><?= t('home') ?></a></li>
                <li class="breadcrumb-item"><a href="#"><?= t('pages') ?></a></li>
                <li class="breadcrumb-item active text-black"><?= t('routes_china_page_title') ?></li>
            </ol>
        </div>
    </div>
    <!-- Header End -->

    <div class="container-fluid feature py-5 process" id="routes-china">
        <div class="container py-5">
            <div class="section-title mb-5" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0"><?= t('routes_china_page_title') ?></h4>
                </div>
            </div>

            <div class="city-list">
                <div class="city-tag"><i class="fa fa-map-marker-alt"></i> <?= t('prices_row_jhb_destination') ?></div>
                <div class="city-tag"><i class="fa fa-map-marker-alt"></i> <?= t('prices_row_kins_destination') ?></div>
                <div class="city-tag"><i class="fa fa-map-marker-alt"></i> <?= t('prices_row_lumb_destination') ?></div>
                <div class="city-tag"><i class="fa fa-map-marker-alt"></i> <?= t('prices_row_kwz_destination') ?></div>
            </div>

            <p class="process-intro text-center mb-4"><?= t('process_china_intro') ?></p>

            <div class="process-container">
                <div class="process-card">
                    <div class="process-step">1</div>
                    <div class="process-icon"><i class="fa fa-shopping-cart"></i></div>
                    <h3><?= t('process_china_step1_title') ?></h3>
                    <p><?= t('process_china_step1_desc') ?></p>
                </div>
                <div class="process-card">
                    <div class="process-step">2</div>
                    <div class="process-icon"><i class="fa fa-warehouse"></i></div>
                    <h3><?= t('process_china_step2_title') ?></h3>
                    <p><?= t('process_china_step2_desc') ?></p>
                </div>
                <div class="process-card">
                    <div class="process-step">3</div>
                    <div class="process-icon"><i class="fa fa-plane-departure"></i></div>
                    <h3><?= t('process_china_step3_title') ?></h3>
                    <p><?= t('process_china_step3_desc') ?></p>
                    <div class="transport-options">
                        <div class="transport-card">
                            <div class="transport-icon"><i class="fa fa-plane"></i></div>
                            <h4><?= t('service1_title') ?></h4>
                            <p><?= t('process_transport_air_desc') ?></p>
                        </div>
                        <div class="transport-card">
                            <div class="transport-icon"><i class="fa fa-ship"></i></div>
                            <h4><?= t('service2_title') ?></h4>
                            <p><?= t('process_transport_sea_desc') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include(__DIR__ . '/../layouts/footer.php'); ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>


    <?php include(__DIR__ . '/../layouts/js.php'); ?>

</body>

</html>
