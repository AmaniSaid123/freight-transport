<div class="container-fluid pricing-section py-5" id="price">
  <div class="container">
    <!-- En-tête -->
    <div class="row justify-content-center mb-4">
      <div class="col-lg-10 text-center">
        <h3 class="section-title mb-3"><?= t('prices_title') ?></h3>
        <p class="mb-0 small"><?= t('prices_intro_full') ?></p>


      </div>
    </div>

    <!-- Tableau des prix -->
    <div class="row">
      <div class="col-12">
        <div class="pricing-table-container compact">
          <div class="table-responsive">
            <table class="pricing-table compact-table">
              <thead>
                <tr>
                  <th class="destination-col"><?= t('prices_table_destination') ?></th>
                  <th class="type-col"><?= t('prices_table_type') ?></th>
                  <th class="price-col"><?= t('prices_table_price') ?></th>
                  <th class="delivery-col"><?= t('prices_table_leadtime') ?></th>
                  <th class="notes-col"><?= t('prices_table_notes') ?></th>

                </tr>
              </thead>
              <tbody>
                <!-- Johannesburg -->
                <tr class="table-row">
                  <td class="destination-cell">
                    <div class="destination-info">
                      <span class="city-name"><?= t('prices_row_jhb_destination') ?></span>
                    </div>
                  </td>
                  <td class="type-cell">
                    <span class="service-type sea small">
                      <i class="fas fa-ship"></i>
                      <?= t('prices_row_jhb_sea_type') ?>
                    </span>
                  </td>
                  <td class="price-cell">
                    <span class="price-value"><?= t('prices_row_jhb_sea_price') ?></span>
                    <div class="price-detail-inline">
                      <?= t('prices_detail_note') ?>
                      <a href="<?= BASE_URL ?>assets/pdf/SA TRUSTED CARGO COMPANY SEA FREIGHT PRICE LIST.pdf"
                        class="pdf-download-btn small" target="_blank" rel="noopener">
                        <i class="fas fa-file-pdf"></i>
                      </a>
                    </div>
                  </td>
                  <td class="delivery-cell">
                    <div class="delivery-info small">
                      <i class="fas fa-clock"></i>
                      <span><?= t('prices_row_jhb_sea_leadtime') ?></span>
                    </div>
                  </td>
                  <td class="notes-cell small">
                    <div class="notes-content">
                      <?= t('prices_row_jhb_sea_notes') ?>
                      <div class="included-features">
                        <span class="feature-badge small">
                          <i class="fas fa-check"></i>
                          <?= t('prices_customs_included') ?>
                        </span>
                      </div>
                    </div>
                  </td>

                </tr>

                <!-- Kinshasa -->
                <tr class="table-row">
                  <td rowspan="2" class="destination-cell">
                    <div class="destination-info">
                      <span class="city-name"><?= t('prices_row_kins_destination') ?></span>
                    </div>
                  </td>
                  <td class="type-cell">
                    <span class="service-type air small">
                      <i class="fas fa-plane"></i>
                      <?= t('prices_row_kins_air_type') ?>
                    </span>
                  </td>
                  <td class="price-cell">
                    <span class="price-value"><?= t('prices_row_kins_air_price') ?></span>
                  </td>
                  <td class="delivery-cell">
                    <div class="delivery-info small">
                      <i class="fas fa-clock"></i>
                      <span><?= t('prices_row_kins_air_leadtime') ?></span>
                    </div>
                  </td>
                  <td class="notes-cell small">
                    <?= t('prices_row_kins_air_notes') ?>
                  </td>

                </tr>
                <tr class="table-row">
                  <td class="type-cell">
                    <span class="service-type sea small">
                      <i class="fas fa-ship"></i>
                      <?= t('prices_row_kins_sea_type') ?>
                    </span>
                  </td>
                  <td class="price-cell">
                    <span class="price-value"><?= t('prices_row_kins_sea_price') ?></span>
                  </td>
                  <td class="delivery-cell">
                    <div class="delivery-info small">
                      <i class="fas fa-clock"></i>
                      <span><?= t('prices_row_kins_sea_leadtime') ?></span>
                    </div>
                  </td>
                  <td class="notes-cell small">
                    <div class="notes-content">
                      <?= t('prices_row_kins_sea_notes') ?>
                      <div class="included-features">
                        <span class="feature-badge small">
                          <i class="fas fa-check"></i>
                          <?= t('prices_customs_included') ?>
                        </span>
                      </div>
                    </div>
                  </td>

                </tr>

                <!-- Lubumbashi -->
                <tr class="table-row">
                  <td rowspan="3" class="destination-cell">
                    <div class="destination-info">
                      <span class="city-name"><?= t('prices_row_lumb_destination') ?></span>
                    </div>
                  </td>
                  <td class="type-cell">
                    <span class="service-type air small">
                      <i class="fas fa-plane"></i>
                      <?= t('prices_row_lumb_air_type') ?>
                    </span>
                  </td>
                  <td class="price-cell">
                    <span class="price-value"><?= t('prices_row_lumb_air_price') ?></span>
                  </td>
                  <td class="delivery-cell">
                    <div class="delivery-info small">
                      <i class="fas fa-clock"></i>
                      <span><?= t('prices_row_lumb_air_leadtime') ?></span>
                    </div>
                  </td>
                  <td class="notes-cell small">
                    <?= t('prices_row_lumb_air_notes') ?>
                  </td>

                </tr>
                <tr class="table-row">
                  <td class="type-cell">
                    <span class="service-type sea small">
                      <i class="fas fa-ship"></i>
                      <?= t('prices_row_lumb_sea_type') ?>
                    </span>
                  </td>
                  <td class="price-cell">
                    <span class="price-value"><?= t('prices_row_lumb_sea_price') ?></span>
                  </td>
                  <td class="delivery-cell">
                    <div class="delivery-info small">
                      <i class="fas fa-clock"></i>
                      <span><?= t('prices_row_lumb_sea_leadtime') ?></span>
                    </div>
                  </td>
                  <td class="notes-cell small">
                    <div class="notes-content">
                      <?= t('prices_row_lumb_sea_notes') ?>
                      <div class="included-features">
                        <span class="feature-badge small">
                          <i class="fas fa-check"></i>
                          <?= t('prices_customs_included') ?>
                        </span>
                      </div>
                    </div>
                  </td>

                </tr>
                <tr class="table-row">
                  <td class="type-cell">
                    <span class="service-type sea small">
                      <i class="fas fa-truck"></i>
                      <?= t('prices_row_lumb_road_type') ?>
                    </span>
                  </td>
                  <td class="price-cell">
                    <span class="price-value"><?= t('prices_row_lumb_road_price') ?></span>
                  </td>
                  <td class="delivery-cell">
                    <div class="delivery-info small">
                      <i class="fas fa-clock"></i>
                      <span><?= t('prices_row_lumb_road_leadtime') ?></span>
                    </div>
                  </td>
                  <td class="notes-cell small">
                    <div class="notes-content">
                      <?= t('prices_row_lumb_road_notes') ?>
                      <div class="included-features">
                        <span class="feature-badge small">
                          <i class="fas fa-check"></i>
                          <?= t('prices_customs_included') ?>
                        </span>
                      </div>
                    </div>
                  </td>

                </tr>

                <!-- Kolwezi -->
                <tr class="table-row">
                  <td class="destination-cell">
                    <div class="destination-info">
                      <span class="city-name"><?= t('prices_row_kwz_destination') ?></span>
                    </div>
                  </td>
                  <td class="type-cell">
                    <span class="service-type sea small">
                      <i class="fas fa-ship"></i>
                      <?= t('prices_row_kwz_sea_type') ?>
                    </span>
                  </td>
                  <td class="price-cell">
                    <span class="price-value"><?= t('prices_row_kwz_sea_price') ?></span>
                  </td>
                  <td class="delivery-cell">
                    <div class="delivery-info small">
                      <i class="fas fa-clock"></i>
                      <span><?= t('prices_row_kwz_sea_leadtime') ?></span>
                    </div>
                  </td>
                  <td class="notes-cell small">
                    <div class="notes-content">
                      <?= t('prices_row_kwz_sea_notes') ?>
                      <div class="included-features">
                        <span class="feature-badge small">
                          <i class="fas fa-check"></i>
                          <?= t('prices_customs_included') ?>
                        </span>
                      </div>
                    </div>
                  </td>

                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
