<div class="container-fluid about bg-light py-5" id="about">
    <div class="container py-5">
        <div class="row g-5 align-items-start">
            <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="about-img pb-5 ps-5">
                    <img src="<?= BASE_URL ?>assets/img/about.jpg" class="img-fluid rounded w-100" style="object-fit: cover;"
                        alt="Image">
                    <div class="about-img-inner">
                        <img src="<?= BASE_URL ?>assets/img/about.png" class="img-fluid rounded-circle w-100 h-100" alt="Image">
                    </div>
                </div>
            </div>
            <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                <div class="section-title text-start mb-5">
                    <h4 class="sub-title pe-3 mb-0"> <?= t('about_title') ?></h4>
                    <h5 class="fw-bold mt-3 mb-3"><?= t('who_are_you') ?> ?</h5>
                    <p class="mb-4"><?= t('who_are_we_desc_1') ?></p>
                    <h5 class="fw-bold mb-2"><?= t('who_are_we_desc_2') ?></h5>
                    <p class="mb-4"><?= t('who_are_we_desc_3') ?></p>
                    <ul class="ps-4 mb-0">
                        <li class="mb-3">
                            <strong><?= t('who_are_we_route_sa_title') ?></strong>
                            <ul class="ps-3 mt-2">
                                <li><?= t('who_are_we_route_sa_origin') ?></li>
                                <li>
                                    <strong><?= t('who_are_we_route_sa_dest_title') ?></strong>
                                    <ul class="ps-3 mt-2 mb-0">
                                        <li><?= t('who_are_we_route_sa_dest_1') ?></li>
                                        <li><?= t('who_are_we_route_sa_dest_2') ?></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <strong><?= t('who_are_we_route_china_title') ?></strong>
                            <ul class="ps-3 mt-2">
                                <li><?= t('who_are_we_route_china_origin') ?></li>
                                <li>
                                    <strong><?= t('who_are_we_route_china_dest_title') ?></strong>
                                    <ul class="ps-3 mt-2 mb-0">
                                        <li><?= t('who_are_we_route_china_dest_1') ?></li>
                                        <li><?= t('who_are_we_route_china_dest_2') ?></li>
                                        <li><?= t('who_are_we_route_china_dest_3') ?></li>
                                        <li><?= t('who_are_we_route_china_dest_4') ?></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
