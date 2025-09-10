<div class="container-fluid feature py-5 process-container" id="process">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0"><?= t('text_process') ?></h4>
            </div>
            <h1 class="display-7 mb-4"><?= t('process_hero_title') ?></h1>
        </div>

        <div class="process-steps">
            <div class="step">
                <div class="step-number">1</div>
                <h2><?= t('process_step1_title') ?></h2>
                <p><?= t('process_step1_paragraph') ?></p>

                <div class="step-details">
                    <p><?= t('process_step1_detail') ?></p>
                    <p><strong><?= t('process_step1_note') ?></strong></p>
                </div>

                <div class="step-actions">
                    <a href="" class="btn" disabled data-bs-toggle="popover" data-bs-title="<?= t('button_info') ?>"
                        data-bs-content="<?= t('text_info') ?>"><?= t('process_step1_button') ?></a>
                </div>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <h2><?= t('process_step2_title') ?></h2>
                <p><?= t('process_step2_paragraph') ?></p>

                <div class="contact-methods">
                    <div class="contact-method">
                        <i class="fab fa-whatsapp"></i>
                        <span><?= t('process_contact_whatsapp') ?></span>
                    </div>
                    <div class="contact-method">
                        <i class="far fa-envelope"></i>
                        <span><a href="mailto:admin@trustedcargo.co.za">admin@trustedcargo.co.za</a></span>
                    </div>
                </div>

                <div class="note">
                    <p><strong><?= t('process_note_label') ?></strong> <?= t('process_note_text') ?></p>
                </div>

                <div class="step-actions">
                    <a href="/contact.php" class="btn"><?= t('process_step2_button') ?></a>
                </div>
            </div>
        </div>

        <div class="note" style="margin-top: 30px;">
            <p><strong><?= t('process_important_label') ?></strong> <?= t('process_important_text') ?></p>
            <p><?= t('process_important_note') ?></p>
        </div>

    </div>

</div>