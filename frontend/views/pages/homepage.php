<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include_once(__DIR__ . "/../../../php/function.php");

?>


<?php include("../layouts/head.php"); ?>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <?php include("../layouts/topbar.php"); ?>

    <?php include("../layouts/menu.php"); ?>


    <!-- About Start -->
    <?php include("./about.php"); ?>
    <!-- About End -->

    <?php include("./service.php"); ?>

    <!-- tracking Start -->
    <div class="container-fluid tracking py-5" id="tracking">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0"> <?= t('tracking_title') ?></h4>
                </div>
                <h1 class="display-3 mb-4"> <?= t('tracking_text') ?></h1>
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
                        <button type="submit" class="btn btn-primary rounded-pill text-white py-3 px-5">
                            <?= t('tracking_button') ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- tracking End -->
    <?php include("./values.php"); ?>
    <?php include("./process.php"); ?>
    <?php include("./price.php"); ?>


    <?php
    include_once("../layouts/footer.php");
    ?>


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/lib/wow/wow.min.js"></script>
    <script src="../../assets/lib/easing/easing.min.js"></script>
    <script src="../../assets/lib/waypoints/waypoints.min.js"></script>
    <script src="../../assets/lib/owlcarousel/owl.carousel.min.js"></script>


    <!-- Template Javascript -->
    <script src="../../assets/js/main.js"></script>

</body>

</html>