<!DOCTYPE html>
<html lang="en">

<?php
session_start();
//include_once(__DIR__ . '/../../php/function.php');
// bonne fichier
//include_once __DIR__ . "/../../../php/function.php";

?>


<?php include(__DIR__ . '/../layouts/head.php'); ?>

<body>

    <?php include(__DIR__ . '/../layouts/topbar.php'); ?>

    <?php include(__DIR__ . '/../layouts/menu.php'); ?>



    <!-- About Start -->
    <?php include(__DIR__ . '/about.php'); ?>


    <!-- About End -->

    <?php include(__DIR__ . '/service.php'); ?>

    <!-- tracking Start -->
    <div class="container-fluid tracking py-5" id="tracking">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0"> <?= t('tracking_title') ?></h4>
                </div>
                <h1 class="display-7 mb-4"> <?= t('tracking_text') ?></h1>
                <p class="mb-0">
                    <?= t('tracking_description') ?>
                </p>
            </div>

            <!-- Formulaire de suivi -->
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <form action="tracking-result.php" method="get" class="d-flex">
                        <input type="text" name="tracking_number" class="form-control form-control-lg me-2"
                            placeholder="<?= t('tracking_placeholder') ?>" required>
                        <button type="submit" class="btn btn-primary rounded-pill text-white py-3 px-5"
                            data-bs-toggle="popover" data-bs-title="<?= t('button_info') ?>"
                            data-bs-content="<?= t('text_info') ?>">
                            <?= t('tracking_button') ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- tracking End -->

    <?php include(__DIR__ . '/values.php'); ?>
    <?php include(__DIR__ . '/process.php'); ?>
    <?php include(__DIR__ . '/price.php'); ?>

    <?php include(__DIR__ . '/../layouts/footer.php'); ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>

    <?php include(__DIR__ . '/../layouts/js.php'); ?>



</body>

</html>