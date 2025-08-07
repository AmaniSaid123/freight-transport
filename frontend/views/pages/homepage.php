<!DOCTYPE html>
<html lang="en">


<?php
session_start();

// Fonction pour récupérer la langue principale du navigateur
function getBrowserLanguage() {
    if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        return 'fr'; // fallback
    }
    // Exemple: "fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7"
    $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    if (count($langs) > 0) {
        // Prendre la première langue (ex: fr-FR)
        $lang = substr($langs[0], 0, 2);
        // On accepte uniquement 'fr' ou 'en' ici
        if (in_array($lang, ['fr', 'en'])) {
            return $lang;
        }
    }
    return 'fr'; // fallback si autre langue
}

// Si l'utilisateur a choisi via GET, on stocke en session
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
} elseif (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
} else {
    // Sinon on détecte la langue navigateur
    $lang = getBrowserLanguage();
    $_SESSION['lang'] = $lang; // On peut aussi la stocker pour garder cette valeur
}

// Chargement fichier traduction
$langFile = __DIR__ . "/../../lang/{$lang}.php";
if (file_exists($langFile)) {
    $translations = include $langFile;
} else {
    $translations = include __DIR__ . "/../../lang/{$lang}.php";
}
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


    <!-- Services Start -->
    <div class="container-fluid service py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">What We Do    <h1><?php echo $translations['hello']; ?></h1>
    <p><?php echo $translations['contact']; ?></p></h4>
                </div>
                <h1 class="display-3 mb-4">Our Service Given Physio Therapy By Expert.</h1>
                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat deleniti amet at atque
                    sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia voluptas maxime veniam
                    necessitatibus saepe in ab? Repellat!</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="../../assets/img/service-1.jpg" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Message Therapy</h5>
                                <p class="mb-4">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum
                                    accusamus, dolor qui ullam</p>
                                <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="../../assets/img/service-2.jpg" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Physiotherapy</h5>
                                <p class="mb-4">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum
                                    accusamus, dolor qui ullam</p>
                                <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="../../assets/img/service-3.jpg" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Heat & Cold Therapy</h5>
                                <p class="mb-4">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum
                                    accusamus, dolor qui ullam</p>
                                <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="../../assets/img/service-4.jpg" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Chiropatic Therapy</h5>
                                <p class="mb-4">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum
                                    accusamus, dolor qui ullam</p>
                                <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="../../assets/img/service-5.jpg" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Work Injuries</h5>
                                <p class="mb-4">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum
                                    accusamus, dolor qui ullam</p>
                                <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="../../assets/img/service-6.jpg" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Spot Injuries</h5>
                                <p class="mb-4">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum
                                    accusamus, dolor qui ullam</p>
                                <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="../../assets/img/service-7.jpg" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Regular Therapy</h5>
                                <p class="mb-4">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum
                                    accusamus, dolor qui ullam</p>
                                <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="../../assets/img/service-8.jpg" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">Back Pain</h5>
                                <p class="mb-4">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum
                                    accusamus, dolor qui ullam</p>
                                <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#">Services More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->

    <!-- About Start -->
    <div class="container-fluid tracking py-5" id="tracking">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">Suivi de mon colis</h4>
                </div>
                <h1 class="display-3 mb-4">Suivez votre envoi en temps réel</h1>
                <p class="mb-0">
                    Entrez votre numéro de suivi ci-dessous pour connaître l’état et la localisation de votre envoi.
                    Notre système de suivi vous donne des mises à jour précises depuis le départ jusqu’à la livraison.
                </p>
            </div>

            <!-- Formulaire de suivi -->
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <form action="tracking-result.php" method="get" class="d-flex">
                        <input type="text" name="tracking_number" class="form-control form-control-lg me-2"
                            placeholder="Entrez votre numéro de suivi" required>
                        <button type="submit" class="btn btn-primary rounded-pill text-white py-3 px-5">Suivre</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- About End -->

    <!-- About Start -->
    <div class="container-fluid about bg-light py-5" id="about">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-img pb-5 ps-5">
                        <img src="../../assets/img/about.jpg" class="img-fluid rounded w-100" style="object-fit: cover;"
                            alt="Image">
                        <div class="about-img-inner">
                            <img src="../../assets/img/about.png" class="img-fluid rounded-circle w-100 h-100"
                                alt="Image">
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="section-title text-start mb-5">
                        <h4 class="sub-title pe-3 mb-0">À propos de nous</h4>
                        <h1 class="display-3 mb-4">Votre partenaire de confiance pour le transport international</h1>
                        <p class="mb-4">
                            TCC Logistics est spécialisée dans le fret aérien et maritime, reliant la Chine à l’Afrique
                            avec
                            fiabilité et rapidité. Nous gérons l’acheminement complet de vos marchandises, de la
                            réception
                            dans nos entrepôts jusqu’à la livraison finale.
                        </p>
                        <div class="mb-4">
                            <p class="text-dark"><i class="fa fa-check me-2"></i> Expertise en fret
                                aérien et maritime</p>
                            <p class="text-dark"><i class="fa fa-check  me-2"></i> Suivi en temps réel
                                de vos expéditions</p>
                            <p class="text-dark"><i class="fa fa-check  me-2"></i> Services
                                personnalisés selon vos besoins</p>
                        </div>
                        <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">Découvrir nos services</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Feature Start -->
    <div class="container-fluid feature py-5" id="services">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">Nos Services</h4>
                </div>
                <h1 class="display-3 mb-4">Des solutions logistiques fiables et sur mesure</h1>
                <p class="mb-0"> Nous vous offrons un ensemble complet de services pour expédier vos marchandises en
                    toute sécurité et efficacité.
                    Du fret aérien et maritime à l’entreposage, en passant par le suivi en temps réel, nous vous
                    accompagnons à chaque étape.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <!-- Service 1 : Fret Aérien -->
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row-cols-1 feature-item p-4 text-dark">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-plane-departure fa-4x"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Fret Aérien</h5>
                                <p class="mb-0">Transport rapide depuis la Chine vers l’Afrique par avion.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 2 : Fret Maritime -->
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="row-cols-1 feature-item p-4 text-dark">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-ship fa-4x"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Fret Maritime</h5>
                                <p class="mb-0">Expédition économique par bateau pour gros volumes.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 3 : Entreposage -->
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="row-cols-1 feature-item p-4 text-dark">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-warehouse fa-4x"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Entreposage</h5>
                                <p class="mb-0">Stockage sécurisé et consolidation de vos commandes.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 4 : Suivi en Temps Réel -->
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row-cols-1 feature-item p-4 text-dark">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-map-marker-alt fa-4x"></i> <!-- Compatible FA v5 -->
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Suivi en Temps Réel</h5>
                                <p class="mb-0">Information continue du départ à la livraison, via email & WhatsApp.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 5 : Évaluation & Devis -->
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="row-cols-1 feature-item p-4 text-dark">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-file-invoice fa-4x"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Évaluation & Devis</h5>
                                <p class="mb-0">Évaluation rapide et précise des coûts de transport avec devis clair et
                                    détaillé.</p>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Service 6 : Assistance à l’Achat -->
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="row-cols-1 feature-item p-4 text-dark">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-truck fa-4x"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Assistance à l’Achat</h5>
                                <p class="mb-0">Instructions claires pour vos vendeurs afin de livrer correctement.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 7 : Emballage & Préparation -->
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="row-cols-1 feature-item p-4 text-dark">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-box-open fa-4x"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Emballage & Préparation</h5>
                                <p class="mb-0">Emballage sécurisé pour protéger vos marchandises pendant le transport.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 8 : Assurance Transport -->
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-shield-alt fa-4x text-dark"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">Assurance Transport</h5>
                                <p class="mb-0">Couverture contre les pertes ou dommages durant l’acheminement.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton Plus d'infos -->
                <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">Plus de détails</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->


    <!-- Book Appointment Start -->
    <div class="container-fluid appointment py-5" id="appointment">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2">
                    <div class="section-title text-start">
                        <h4 class="sub-title pe-3 mb-0">Solutions To Your Pain</h4>
                        <h1 class="display-4 mb-4">Best Quality Services With Minimal Pain Rate</h1>
                        <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat
                            deleniti amet
                            at atque sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia
                            voluptas
                            maxime veniam necessitatibus saepe in ab? Repellat!</p>
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4">
                                        <h5 class="mb-3"><i class="fa fa-check text-dark me-2"></i> Body
                                            Relaxation
                                        </h5>
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Et
                                            deserunt qui cupiditate veritatis enim ducimus.</p>
                                    </div>
                                    <div class="mb-4">
                                        <h5 class="mb-3"><i class="fa fa-check text-dark me-2"></i> Body
                                            Relaxation
                                        </h5>
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Et
                                            deserunt qui cupiditate veritatis enim ducimus.</p>
                                    </div>
                                    <div class="text-start mb-4">
                                        <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">More
                                            Details</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">

                        <h1 class="display-5 mb-4">Get Appointment</h1>
                        <form>
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-6">
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent text-white"
                                        placeholder="First Name">
                                </div>
                                <div class="col-xl-6">
                                    <input type="email"
                                        class="form-control py-3 border-primary bg-transparent text-white"
                                        placeholder="Email">
                                </div>
                                <div class="col-xl-6">
                                    <input type="phone" class="form-control py-3 border-primary bg-transparent"
                                        placeholder="Phone">
                                </div>
                                <div class="col-xl-6">
                                    <select class="form-select py-3 border-primary bg-transparent"
                                        aria-label="Default select example">
                                        <option selected>Your Gender</option>
                                        <option value="1">Male</option>
                                        <option value="2">FeMale</option>
                                        <option value="3">Others</option>
                                    </select>
                                </div>
                                <div class="col-xl-6">
                                    <input type="date" class="form-control py-3 border-primary bg-transparent">
                                </div>
                                <div class="col-xl-6">
                                    <select class="form-select py-3 border-primary bg-transparent"
                                        aria-label="Default select example">
                                        <option selected>Department</option>
                                        <option value="1">Physiotherapy</option>
                                        <option value="2">Physical Helth</option>
                                        <option value="2">Treatments</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control border-primary bg-transparent text-white" name="text"
                                        id="area-text" cols="30" rows="5" placeholder="Write Comments"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary text-white w-100 py-3 px-5">SUBMIT
                                        NOW</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Video -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen
                            allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Book Appointment End -->




    <!-- Testimonial Start -->
    <div class="container-fluid testimonial py-5 wow zoomInDown" data-wow-delay="0.1s" id="testimonial">
        <div class="container py-5">
            <div class="section-title mb-5">
                <div class="sub-style">
                    <h4 class="sub-title text-white px-3 mb-0">Testimonial</h4>
                </div>
                <h1 class="display-3 mb-4">What Clients are Say</h1>
            </div>
            <div class="testimonial-carousel owl-carousel">
                <div class="testimonial-item">
                    <div class="testimonial-inner p-5">
                        <div class="testimonial-inner-img mb-4">
                            <img src="../../assets/img/testimonial-img.jpg" class="img-fluid rounded-circle" alt="">
                        </div>
                        <p class="text-white fs-7">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                            Asperiores
                            nemo facilis tempora esse explicabo sed! Dignissimos quia ullam pariatur blanditiis
                            sed
                            voluptatum. Totam aut quidem laudantium tempora. Minima, saepe earum!
                        </p>
                        <div class="text-center">
                            <h5 class="mb-2">John Abraham</h5>
                            <p class="mb-2 text-white-50">New York, USA</p>
                            <div class="d-flex justify-content-center">
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item">
                    <div class="testimonial-inner p-5">
                        <div class="testimonial-inner-img mb-4">
                            <img src="../../assets/img/testimonial-img.jpg" class="img-fluid rounded-circle" alt="">
                        </div>
                        <p class="text-white fs-7">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                            Asperiores
                            nemo facilis tempora esse explicabo sed! Dignissimos quia ullam pariatur blanditiis
                            sed
                            voluptatum. Totam aut quidem laudantium tempora. Minima, saepe earum!
                        </p>
                        <div class="text-center">
                            <h5 class="mb-2">John Abraham</h5>
                            <p class="mb-2 text-white-50">New York, USA</p>
                            <div class="d-flex justify-content-center">
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item">
                    <div class="testimonial-inner p-5">
                        <div class="testimonial-inner-img mb-4">
                            <img src="../../assets/img/testimonial-img.jpg" class="img-fluid rounded-circle" alt="">
                        </div>
                        <p class="text-white fs-7">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                            Asperiores
                            nemo facilis tempora esse explicabo sed! Dignissimos quia ullam pariatur blanditiis
                            sed
                            voluptatum. Totam aut quidem laudantium tempora. Minima, saepe earum!
                        </p>
                        <div class="text-center">
                            <h5 class="mb-2">John Abraham</h5>
                            <p class="mb-2 text-white-50">New York, USA</p>
                            <div class="d-flex justify-content-center">
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


    <!-- Blog Start -->
    <div class="container-fluid blog py-5" id="blog">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">Our Blog</h4>
                </div>
                <h1 class="display-3 mb-4">Excellent Facility and High Quality Therapy</h1>
                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat deleniti amet
                    at atque
                    sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia voluptas maxime
                    veniam
                    necessitatibus saepe in ab? Repellat!</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="blog-item rounded">
                        <div class="blog-img">
                            <img src="../../assets/img/blog-1.jpg" class="img-fluid w-100" alt="Image">
                        </div>
                        <div class="blog-centent p-4">
                            <div class="d-flex justify-content-between mb-4">
                                <p class="mb-0 text-muted"><i class="fa fa-calendar-alt text-dark"></i> 01
                                    Jan 2045
                                </p>
                                <a href="#" class="text-muted"><span class="fa fa-comments text-dark"></span>
                                    3
                                    Comments</a>
                            </div>
                            <a href="#" class="h4">Remove back Pain While Working on o physio</a>
                            <p class="my-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium
                                hic
                                consequatur beatae architecto,</p>
                            <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1">Read
                                More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="blog-item rounded">
                        <div class="blog-img">
                            <img src="../../assets/img/blog-2.jpg" class="img-fluid w-100" alt="Image">
                        </div>
                        <div class="blog-centent p-4">
                            <div class="d-flex justify-content-between mb-4">
                                <p class="mb-0 text-muted"><i class="fa fa-calendar-alt text-dark"></i> 01
                                    Jan 2045
                                </p>
                                <a href="#" class="text-muted"><span class="fa fa-comments text-dark"></span>
                                    3
                                    Comments</a>
                            </div>
                            <a href="#" class="h4">Benefits of a weekly physiotherapy session</a>
                            <p class="my-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium
                                hic
                                consequatur beatae architecto,</p>
                            <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1">Read
                                More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="blog-item rounded">
                        <div class="blog-img">
                            <img src="../../assets/img/blog-3.jpg" class="img-fluid w-100" alt="Image">
                        </div>
                        <div class="blog-centent p-4">
                            <div class="d-flex justify-content-between mb-4">
                                <p class="mb-0 text-muted"><i class="fa fa-calendar-alt text-dark"></i> 01
                                    Jan 2045
                                </p>
                                <a href="#" class="text-muted"><span class="fa fa-comments text-dark"></span>
                                    3
                                    Comments</a>
                            </div>
                            <a href="#" class="h4">Regular excercise can slow ageing process</a>
                            <p class="my-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium
                                hic
                                consequatur beatae architecto,</p>
                            <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1">Read
                                More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog End -->



    <!-- Contact Start -->
    <div class="container-fluid contact py-5" id="contact">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style mb-4">
                    <h4 class="sub-title text-white px-3 mb-0">Contact Us</h4>
                </div>
                <p class="mb-0 text-black-50">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat
                    deleniti
                    amet at atque sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia
                    voluptas
                    maxime veniam necessitatibus saepe in ab? Repellat!</p>
            </div>
            <div class="row g-4 align-items-center">
                <div class="col-lg-5 col-xl-5 contact-form wow fadeInLeft" data-wow-delay="0.1s">
                    <h2 class="display-5 text-white mb-2">Get in Touch</h2>
                    <p class="mb-4 text-white">The contact form is currently inactive. Get a functional and
                        working
                        contact form with Ajax & PHP in a few minutes. Just copy and paste the files, add a
                        little code
                        and you're done. <a class="text-dark fw-bold" href="https://htmlcodex.com/contact-form">Download
                            Now</a>.</p>
                    <form>
                        <div class="row g-3">
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-transparent border border-white" id="name"
                                        placeholder="Your Name">
                                    <label for="name">Your Name</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control bg-transparent border border-white"
                                        id="email" placeholder="Your Email">
                                    <label for="email">Your Email</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="phone" class="form-control bg-transparent border border-white"
                                        id="phone" placeholder="Phone">
                                    <label for="phone">Your Phone</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-transparent border border-white"
                                        id="project" placeholder="Project">
                                    <label for="project">Your Project</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-transparent border border-white"
                                        id="subject" placeholder="Subject">
                                    <label for="subject">Subject</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control bg-transparent border border-white"
                                        placeholder="Leave a message here" id="message"
                                        style="height: 160px"></textarea>
                                    <label for="message">Message</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-light text-dark w-100 py-3">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-xl-2 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bg-transparent rounded">
                        <div class="d-flex flex-column align-items-center text-center mb-4">
                            <div class="bg-white d-flex align-items-center justify-content-center mb-3"
                                style="width: 90px; height: 90px; border-radius: 50px;"><i
                                    class="fa fa-map-marker-alt fa-2x text-dark"></i></div>
                            <h4 class="text-dark">Addresses</h4>
                            <p class="mb-0 text-white">123 ranking Street, New York, USA</p>
                        </div>
                        <div class="d-flex flex-column align-items-center text-center mb-4">
                            <div class="bg-white d-flex align-items-center justify-content-center mb-3"
                                style="width: 90px; height: 90px; border-radius: 50px;"><i
                                    class="fa fa-phone-alt fa-2x text-dark"></i></div>
                            <h4 class="text-dark">Mobile</h4>
                            <p class="mb-0 text-white">+012 345 67890</p>
                            <p class="mb-0 text-white">+012 345 67890</p>
                        </div>

                        <div class="d-flex flex-column align-items-center text-center">
                            <div class="bg-white d-flex align-items-center justify-content-center mb-3"
                                style="width: 90px; height: 90px; border-radius: 50px;"><i
                                    class="fa fa-envelope-open fa-2x text-dark"></i></div>
                            <h4 class="text-dark">Email</h4>
                            <p class="mb-0 text-white">info@example.com</p>
                            <p class="mb-0 text-white">info@example.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-5 wow fadeInRight" data-wow-delay="0.3s">
                    <div class="d-flex justify-content-center mb-4">
                        <a class="btn btn-lg-square btn-light rounded-circle mx-2" href=""><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-lg-square btn-light rounded-circle mx-2" href=""><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-lg-square btn-light rounded-circle mx-2" href=""><i
                                class="fab fa-instagram"></i></a>
                        <a class="btn btn-lg-square btn-light rounded-circle mx-2" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="rounded h-100">
                        <iframe class="rounded w-100" style="height: 500px;"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387191.33750346623!2d-73.97968099999999!3d40.6974881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1694259649153!5m2!1sen!2sbd"
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

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