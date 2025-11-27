
<!DOCTYPE html>
<html lang="en">


<?php
session_start();

//include_once(__DIR__ . "/../../../php/function.php");

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
            <h3 class="display-7 mb-4 wow fadeInDown" data-wow-delay="0.1s"><?= t('payment_title') ?></h3>
            <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="homepage.php"><?= t('home') ?></a></li>
                <li class="breadcrumb-item"><a href="#"><?= t('pages') ?></a></li>
                <li class="breadcrumb-item active text-black"><?= t('payment_title') ?></li>
            </ol>
        </div>
    </div>
    <!-- Header End -->


<div class="container-fluid feature py-5" id="payment">
    <div class="container py-5">
        <div class="section-title mb-5" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0"> <?= t('payment_title') ?></h4>
            </div>
        </div>


        <div class="payment-section">
            <div class="payment-info">
                <h3 class="section-title">
                    <i class="fas fa-credit-card"></i>
                    <?= t('payment_text') ?>
                </h3>
                <p class="info-text">
                    <?= t('payment_info_text') ?>
                </p>

                <div class="payment-features">
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <div><?= t('payment_feature1') ?></div>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <div><?= t('payment_feature2') ?></div>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <div><?= t('payment_feature3') ?></div>
                    </div>
                </div>

                <div class="currency-note">
                    <?= t('payment_currency_note') ?>
                </div>
            </div>

            <div class="payment-form">
                <h3 class="section-title">
                    <i class="fas fa-lock"></i>
                    <?= t('payment_text_process') ?>
                </h3>

                <a href="https://pay.yoco.com/trusted-cargo-co" class="btn">
                    <?= t('payment_pay_button') ?>
                    <i class="fas fa-arrow-right"></i>
                </a>


                <p class="secure-payment">
                    <i class="fas fa-shield-alt"></i>
                 <?= t('payment_secure_text') ?>
                </p>

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