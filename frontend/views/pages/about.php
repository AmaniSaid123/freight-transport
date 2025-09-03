<div class="container-fluid about bg-light py-5" id="about">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="about-img pb-5 ps-5">
                    <img src="frontend/assets/img/about.jpg" class="img-fluid rounded w-100" style="object-fit: cover;"
                        alt="Image">
                    <div class="about-img-inner">
                        <img src="frontend/assets/img/about.png" class="img-fluid rounded-circle w-100 h-100" alt="Image">
                    </div>
                </div>
            </div>
            <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                <div class="section-title text-start mb-5">
                    <h4 class="sub-title pe-3 mb-0"> <?= t('about_title') ?></h4>


                    <p class="mb-4">
                        <?= t('who_are_we_desc_1') ?>
                    </p>
                    <p class="mb-4">
                        <?= t('who_are_we_desc_2') ?>
                    </p>
                    <p class="mb-4">
                        <?= t('who_are_we_desc_3') ?>
                    </p>
                    <p class="mb-4">
                        <?= t('who_are_we_desc_4') ?>
                    </p>


                    <div class="mb-4">
                        <p class="text-dark"><i class="fa fa-check me-2"></i> <?= t('about_list_1') ?> </p>
                        <p class="text-dark"><i class="fa fa-check me-2"></i> <?= t('about_list_2') ?></p>
                        <p class="text-dark"><i class="fa fa-check me-2"></i><?= t('about_list_3') ?></p>
                    </div>
                    <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5"><?= t('about_button') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>