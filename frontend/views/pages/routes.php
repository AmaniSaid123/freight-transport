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
            <h3 class="display-7 mb-4 wow fadeInDown" data-wow-delay="0.1s"><?= t('communication_tracking') ?></h3>
            <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="homepage.php"><?= t('home') ?></a></li>
                <li class="breadcrumb-item"><a href="#"><?= t('pages') ?></a></li>
                <li class="breadcrumb-item active text-black"><?= t('communication_tracking') ?></li>
            </ol>
        </div>
    </div>
    <!-- Header End -->
    <div class="container-fluid feature py-5 process" id="process">
        <div class="container py-5">
            <div class="section-title mb-5" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0"><?= t('communication_tracking') ?></h4>
                </div>
               
            </div>

            <div class="process-nav">

                <button class="process-tab active" data-target="process-sa"><i class="fa fa-truck"></i>
                    <?= t('process_tab_sa') ?></button>
                <button class="process-tab" data-target="process-china"><i class="fa fa-globe"></i>
                    <?= t('process_tab_china') ?></button>
            </div>

            <div id="process-sa" class="process-section active">

                <p class="process-intro text-center mb-3"><?= t('process_sa_intro') ?></p>
                <div id="sa-block-1" class="process-container process-subsection active">
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
                <div id="sa-block-2" class="process-container process-subsection">

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

            <div id="process-china" class="process-section">
                <div class="city-list">
                    <div class="city-tag"><i class="fa fa-map-marker-alt"></i> <?= t('prices_row_jhb_destination') ?>
                    </div>
                    <div class="city-tag"><i class="fa fa-map-marker-alt"></i> <?= t('prices_row_kins_destination') ?>
                    </div>
                    <div class="city-tag"><i class="fa fa-map-marker-alt"></i> <?= t('prices_row_lumb_destination') ?>
                    </div>
                    <div class="city-tag"><i class="fa fa-map-marker-alt"></i> <?= t('prices_row_kwz_destination') ?>
                    </div>
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

    </div>
    <?php include(__DIR__ . '/../layouts/footer.php'); ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>


    <?php include(__DIR__ . '/../layouts/js.php'); ?>

</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.process-tab');
        const sections = document.querySelectorAll('.process-section');
        const subtabs = document.querySelectorAll('.process-subtab');
        const subsections = document.querySelectorAll('.process-subsection');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(btn => btn.classList.remove('active'));
                sections.forEach(section => section.classList.remove('active'));

                tab.classList.add('active');
                const target = tab.getAttribute('data-target');
                const activeSection = document.getElementById(target);
                if (activeSection) {
                    activeSection.classList.add('active');
                }
            });
        });

        subtabs.forEach(subtab => {
            subtab.addEventListener('click', () => {
                const group = subtab.closest('.process-section');
                if (!group) return;

                group.querySelectorAll('.process-subtab').forEach(btn => btn.classList.remove('active'));
                group.querySelectorAll('.process-subsection').forEach(sec => sec.classList.remove('active'));

                subtab.classList.add('active');
                const target = subtab.getAttribute('data-target');
                const activeSub = group.querySelector(`#${target}`);
                if (activeSub) activeSub.classList.add('active');
            });
        });
    });
</script>