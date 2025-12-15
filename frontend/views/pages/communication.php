<div class="container-fluid communication-section py-5" id="communication">
    <div class="container communication-wrapper py-5">
        <div class="communication-title">
            <h2><i class="fas fa-comments me-2"></i><?= t('communication_title') ?></h2>
            <p><?= t('communication_intro') ?></p>
        </div>

        <div class="communication-grid">
            <div class="communication-card">
                <div class="communication-icon"><i class="fas fa-tag"></i></div>
                <h3><?= t('communication_card_price_title') ?></h3>
                <p><?= t('communication_card_price_desc') ?></p>
                <div class="highlight"><?= t('communication_card_price_highlight') ?></div>
            </div>

            <div class="communication-card">
                <div class="communication-icon"><i class="fas fa-map-marked-alt"></i></div>
                <h3><?= t('communication_card_tracking_title') ?></h3>
                <p><?= t('communication_card_tracking_desc') ?></p>
                <div class="highlight"><?= t('communication_card_tracking_highlight') ?></div>
            </div>

            <div class="communication-card">
                <div class="communication-icon"><i class="fas fa-truck-loading"></i></div>
                <h3><?= t('communication_card_delivery_title') ?></h3>
                <p><?= t('communication_card_delivery_desc') ?></p>
                <div class="cities-list">
                    <div class="city-tag"><?= t('prices_row_jhb_destination') ?></div>
                    <div class="city-tag"><?= t('prices_row_kins_destination') ?></div>
                    <div class="city-tag"><?= t('prices_row_lumb_destination') ?></div>
                    <div class="city-tag"><?= t('prices_row_kwz_destination') ?></div>
                </div>
            </div>
        </div>

        <div class="contact-methods">
            <div class="contact-method">
                <div class="contact-icon"><i class="fab fa-whatsapp"></i></div>
                <div class="contact-label"><?= t('communication_contact_whatsapp') ?></div>
            </div>
            <div class="contact-method">
                <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                <div class="contact-label"><?= t('communication_contact_email') ?></div>
            </div>
        </div>

        <div class="timeline-container">
            <h3 class="timeline-title"><?= t('communication_timeline_title') ?></h3>
            <div class="timeline">
                <div class="timeline-step">
                    <div class="step-icon"><i class="fas fa-warehouse"></i></div>
                    <div class="step-label"><?= t('communication_step_reception') ?></div>
                </div>
                <div class="timeline-step">
                    <div class="step-icon"><i class="fas fa-calculator"></i></div>
                    <div class="step-label"><?= t('communication_step_pricing') ?></div>
                </div>
                <div class="timeline-step">
                    <div class="step-icon"><i class="fas fa-shipping-fast"></i></div>
                    <div class="step-label"><?= t('communication_step_shipping') ?></div>
                </div>
                <div class="timeline-step">
                    <div class="step-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="step-label"><?= t('communication_step_tracking') ?></div>
                </div>
                <div class="timeline-step">
                    <div class="step-icon"><i class="fas fa-home"></i></div>
                    <div class="step-label"><?= t('communication_step_delivery') ?></div>
                </div>
            </div>
        </div>

    </div>
</div>
