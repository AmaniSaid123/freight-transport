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
            <h3 class="display-7 mb-4 wow fadeInDown" data-wow-delay="0.1s"><?= t('routes_sa_page_title') ?></h3>
            <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="homepage.php"><?= t('home') ?></a></li>
                <li class="breadcrumb-item"><a href="#"><?= t('pages') ?></a></li>
                <li class="breadcrumb-item active text-black"><?= t('routes_sa_page_title') ?></li>
            </ol>
        </div>
    </div>
    <!-- Header End -->

    <div class="container-fluid feature py-5 process" id="routes-sa">
        <div class="container py-5">
            <div class="section-title mb-5" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0"><?= t('routes_sa_page_title') ?></h4>
                </div>
            </div>

            <p class="process-intro text-center mb-4"><?= t('process_sa_intro') ?></p>

            <div class="process-container">
                <div class="process-card">
                    <div class="process-step">1</div>
                    <div class="process-icon"><i class="fa fa-box-open"></i></div>
                    <h3><?= t('process_sa_step1_title') ?></h3>
                    <p><?= t('process_sa_step1_desc') ?></p>
                    <ul class="nested-list">
                        <li><strong><?= t('process_sa_step1_purchase_title') ?></strong>
                            <?= t('process_sa_step1_purchase_desc') ?></li>
                        <li><strong><?= t('process_sa_step1_personal_title') ?></strong>
                            <ul class="nested-list">
                                <li><strong><?= t('process_sa_step1_direct_title') ?></strong>
                                    <?= t('process_sa_step1_direct_desc') ?></li>
                                <li><strong><?= t('process_sa_step1_courier_title') ?></strong>
                                    <?= t('process_sa_step1_courier_desc') ?></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="process-card">
                    <div class="process-step">2</div>
                    <div class="process-icon"><i class="fa fa-bell"></i></div>
                    <h3><?= t('process_sa_step2_title') ?></h3>
                    <p><?= t('process_sa_step2_desc') ?></p>
                    <div class="warning-note">
                        <p><i class="fa fa-exclamation-triangle"></i><?= t('process_sa_info_list') ?></p>
                    </div>
                </div>
            </div>

            <div class="process-container mt-4">
                <div class="process-card">
                    <div class="process-step">3</div>
                    <div class="process-icon"><i class="fa fa-warehouse"></i></div>
                    <h3><?= t('process_sa_step3_title') ?></h3>
                    <p><?= t('process_sa_step3_desc') ?></p>
                </div>
                <div class="process-card">
                    <div class="process-step">4</div>
                    <div class="process-icon"><i class="fa fa-calculator"></i></div>
                    <h3><?= t('process_sa_step4_title') ?></h3>
                    <p><?= t('process_sa_step4_desc') ?></p>
                </div>
                <div class="process-card">
                    <div class="process-step">5</div>
                    <div class="process-icon"><i class="fa fa-credit-card"></i></div>
                    <h3><?= t('process_sa_step5_title') ?></h3>
                    <p><?= t('process_sa_step5_desc') ?></p>
                    <div class="payment-options">
                        <div class="payment-option">
                            <div class="payment-icon"><i class="fa fa-laptop"></i></div>
                            <h4><?= t('process_payment_online') ?></h4>
                            <p><?= t('process_payment_online_desc') ?></p>
                        </div>
                        <div class="payment-option">
                            <div class="payment-icon"><i class="fa fa-money-bill-wave"></i></div>
                            <h4><?= t('process_payment_cash') ?></h4>
                            <p><?= t('process_payment_cash_desc') ?></p>
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
