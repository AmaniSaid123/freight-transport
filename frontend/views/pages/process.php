<div class="container-fluid feature py-5 process" id="process">
    <div class="container py-5">
        <div class="section-title mb-5" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0"><?= t('text_process') ?></h4>
            </div>
            <h1 class="display-7 mb-4"><?= t('process_hero_title') ?></h1>
        </div>

        <div class="process-steps">
            <div class="step">
                <div class="step-number">1</div>
                <h2><?= t('process_step1_title') ?></h2>
                <ul class="mb-4">
                    <li><?= t('process_step1_bullet1') ?></li>
                    <li><?= t('process_step1_bullet2') ?></li>
                </ul>

                <div class="step-actions">

                    <button type="submit" class="btn btn-primary text-white py-3 px-5" data-bs-toggle="popover"
                        data-bs-title="<?= t('button_info') ?>" data-bs-content="<?= t('text_info') ?>">
                        <?= t('process_step1_button') ?></button>
                </div>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <h2><?= t('process_step2_title') ?></h2>
                <ul class="mb-4">
                    <li><?= t('process_step2_bullet1') ?></li>
                    <li>
                        <?= t('process_step2_bullet2') ?>
                        <ul class="mt-2">
                            <li><?= t('process_step2_bullet2_option1') ?></li>
                            <li><?= t('process_step2_bullet2_option2') ?></li>
                        </ul>
                    </li>
                    <li><?= t('process_step2_bullet3') ?></li>
                    <li><?= t('process_step2_bullet4') ?></li>
                </ul>

                <div class="contact-methods mb-3">
                    <div class="contact-method">
                        <i class="fab fa-whatsapp"></i>
                        <span><?= t('process_contact_whatsapp') ?></span>
                    </div>
                    <div class="contact-method">
                        <i class="far fa-envelope"></i>
                        <span><a href="mailto:admin@trustedcargo.co.za">admin@trustedcargo.co.za</a></span>
                    </div>
                </div>

                <div class="step-actions">
                    <a href="/contact" class="btn"><?= t('process_step2_button') ?></a>
                </div>
            </div>

            <div class="step">
                <div class="step-number">3</div>
                <h2><?= t('process_arrival_title') ?></h2>
                <ul class="mb-0">
                    <li><?= t('process_arrival_eval') ?></li>
                    <li>
                        <?= t('process_arrival_comm') ?>
                        <ul class="mt-2">
                            <li><?= t('process_arrival_tracking') ?></li>
                            <li><?= t('process_arrival_price') ?></li>
                            <li><?= t('process_arrival_payment_link') ?></li>
                        </ul>
                    </li>
                    <li><strong><?= t('process_arrival_payment_required') ?></strong></li>
                    <li><strong><?= t('process_arrival_storage_fee') ?></strong></li>
                </ul>
            </div>
        </div>

    </div>

</div>
