<div class="container-fluid about bg-light py-5" id="price">
  <div class="container py-5">
    <div class="row g-5 align-items-center">
      <div class="col-lg-5" data-wow-delay="0.2s">
        <div class="about-img pb-5 ps-5">
          <img src="<?= BASE_URL ?>assets/img/prix.png" class="img-fluid rounded w-100" style="object-fit: cover;"
            alt="Image">

        </div>
      </div>
      <div class="col-lg-7">
        <div class="section-title text-start mb-5">
          <h4 class="sub-title pe-3 mb-0"><?= t('prices') ?></h4>


          <p class="mb-4"><?= t('prices_intro_p1') ?></p>
          <p class="mb-4"><?= t('prices_intro_p2') ?></p>


          <table class="table">
            <thead>
              <tr>
                <th><?= t('prices_table_destination') ?></th>
                <th><?= t('prices_table_type') ?></th>
                <th><?= t('prices_table_price') ?></th>
                <th><?= t('prices_table_leadtime') ?></th>
                <th><?= t('prices_table_notes') ?></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td rowspan="2"><?= t('prices_row_jhb_destination') ?></td>
                <td><?= t('prices_row_jhb_air_type') ?></td>
                <td><?= t('prices_row_jhb_air_price') ?></td>
                <td><?= t('prices_row_jhb_air_leadtime') ?></td>
                <td><?= t('prices_row_jhb_air_notes') ?></td>
              </tr>
              <tr>
                <td><?= t('prices_row_jhb_sea_type') ?></td>
                <td><?= t('prices_row_jhb_sea_price') ?></td>
                <td><?= t('prices_row_jhb_sea_leadtime') ?></td>
                <td><?= t('prices_row_jhb_sea_notes') ?></td>
              </tr>
              <tr>
                <td rowspan="2"><?= t('prices_row_kins_destination') ?></td>
                <td><?= t('prices_row_kins_air_type') ?></td>
                <td><?= t('prices_row_kins_air_price') ?></td>
                <td><?= t('prices_row_kins_air_leadtime') ?></td>
                <td><?= t('prices_row_kins_air_notes') ?></td>
              </tr>
              <tr>
                <td><?= t('prices_row_kins_sea_type') ?></td>
                <td><?= t('prices_row_kins_sea_price') ?></td>
                <td><?= t('prices_row_kins_sea_leadtime') ?></td>
                <td><?= t('prices_row_kins_sea_notes') ?></td>
              </tr>
            </tbody>
          </table>





        </div>
      </div>
    </div>
  </div>
</div>