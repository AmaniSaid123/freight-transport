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

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h3 class="display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Conditions Générales </h1>
                <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.html"><?= t('home') ?></a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active text-black">Conditions Générales </li>
                </ol>
        </div>
    </div>
    <!-- Header End -->


    <div class="terms-container">


        <div class="terms-content">
            <section class="terms-section">
                <h2>Art. 1:</h2>
                <p>L'expéditeur est SEUL responsable de la liste d'inventaire établie, de sa déclaration en Effets
                    Personnels ou Commerciaux.
                    n cas de refus des services douaniers ou gouvernementaux de la ville de destination finale, le
                    client paiera les surtaxations avant
                    la livraison au destinataire. Le contrôle du poids à l'arrivée est le SEUL contrôle pris en compte.
                    Le destinataire ne pourra en aucun cas
                    faire référence à la liste établie par l'expéditeur et non contresignée par Trusted Cargo company de
                    la ville de destination finale.
                    L'expéditeur certifie que le contenu des colis n'est ni dangereux pour le transport, ni prohibé par
                    les autorités.</p>
            </section>

            <section class="terms-section">
                <h2>2. Utilisation du site</h2>
                <p>Ce site est destiné à fournir des informations générales sur nos produits et services. Vous êtes
                    autorisé à utiliser ce site à des fins légales et conformément à ces conditions.</p>

                <h3>Interdictions :</h3>
                <ul>
                    <li>Utiliser le site de manière à nuire, désactiver, surcharger ou endommager le site</li>
                    <li>Tenter d'accéder à des zones non autorisées du site</li>
                    <li>Utiliser des robots, spiders ou tout autre moyen automatisé pour accéder au site</li>
                    <li>Reproduire, dupliquer, copier ou vendre tout élément du site</li>
                </ul>
            </section>

            <section class="terms-section">
                <h2>3. Propriété intellectuelle</h2>
                <p>Tout le contenu présent sur ce site, y compris mais sans s'y limiter, les textes, graphiques, logos,
                    icônes, images, clips audio, téléchargements numériques, compilation de données et logiciels, est la
                    propriété de notre société ou de ses fournisseurs de contenu et est protégé par les lois sur le
                    droit d'auteur.</p>
            </section>

            <section class="terms-section">
                <h2>4. Limitations de responsabilité</h2>
                <p>Nous ne serons pas responsables des dommages (y compris, sans limitation, les dommages pour perte de
                    données ou de profit, ou en raison d'une interruption d'activité) résultant de l'utilisation ou de
                    l'impossibilité d'utiliser les matériaux de ce site, même si nous avons été notifié oralement ou par
                    écrit de la possibilité de tels dommages.</p>
            </section>

            <section class="terms-section">
                <h2>5. Modifications des conditions</h2>
                <p>Nous nous réservons le droit, à notre seule discrétion, de modifier ou remplacer ces conditions à
                    tout moment. Il est de votre responsabilité de vérifier périodiquement ces conditions pour les
                    changements.</p>
            </section>

            <section class="terms-section">
                <h2>6. Loi applicable</h2>
                <p>Ces conditions sont régies et interprétées conformément aux lois de [Pays] et vous vous soumettez
                    irrévocablement à la juridiction exclusive des tribunaux de cet État ou lieu.</p>
            </section>
        </div>

        <footer class="terms-footer">
            <p>Si vous avez des questions concernant ces conditions, veuillez nous contacter à contact@exemple.com</p>
        </footer>
    </div>




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