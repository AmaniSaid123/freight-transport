<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<?php
include_once("candidate/layouts/head.php");
?>

<body class="index-page">

<?php
include_once("candidate/layouts/header.php");
?>


  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <div class="carousel-item active">
          <img src="candidate/assets/img/hero-carousel/hero-carousel-1.webp" alt="">
        </div><!-- End Carousel Item -->

        <div class="carousel-item">
          <img src="candidate/assets/img/hero-carousel/hero-carousel-2.jpg" alt="">
        </div><!-- End Carousel Item -->

        <div class="carousel-item">
          <img src="candidate/assets/img/hero-carousel/hero-carousel-3.jpg" alt="">
        </div><!-- End Carousel Item -->

        <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>

        <ol class="carousel-indicators"></ol>

      </div>

    </section><!-- /Hero Section -->

    <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item position-relative">
              <div class="icon">  <i class="fas fa-handshake"></i></div>
              <h4><a href="" class="stretched-link">Accompagnement</a></h4>
              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative">
              <div class="icon"><i class="fas fa-home"></i></div>
              <h4><a href="" class="stretched-link">Logement</a></h4>
              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
              <div class="icon"><i class="fas fa-globe-africa"></i></div>
              <h4><a href="" class="stretched-link">Visa</a></h4>
              <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative">
              <div class="icon"><i class="fas fa-folder-open"></i></div>
              <h4><a href="" class="stretched-link">Documents</a></h4>
              <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
            </div>
          </div><!-- End Service Item -->

        </div>

      </div>

    </section><!-- /Featured Services Section -->

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section accent-background">

      <div class="container">
        <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
          <div class="col-xl-10">
            <div class="text-center">
              <h3>Vous rêvez de poursuivre vos études à l'étranger.</h3>
              <a class="cta-btn" href="candidate-register.php">Créer dossier MyPass</a>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Call To Action Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title">
        <h2>À propos<br></h2>
        <p>C'est une réalité établie depuis longtemps.</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">
          <div class="col-lg-6 position-relative align-self-start">
            <img src="candidate/assets/img/about.webp" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 content">
            <p class="fst-italic">
              MyPass est née d’un constat simple : de plus en plus d’élèves du secondaire, de bacheliers et d’étudiants aspirent à poursuivre leurs études à l’étranger, mais se heurtent à des démarches complexes, souvent décourageantes. C’est pour répondre à cette demande croissante que notre agence a vu le jour, avec une mission claire : simplifier l’accès à une éducation internationale de qualité.
            </p>
            <p class="fst-italic">
              Étudier à l’étranger est une décision majeure, qui ouvre des portes sur le plan académique, professionnel et personnel. Que vous soyez motivé par l’enrichissement culturel ou par l’ambition de renforcer votre parcours, MyPass vous accompagne à chaque étape de votre projet : du choix de la destination au dépôt de votre dossier, en passant par l’obtention du visa, la sélection de l’université, le financement et même la recherche de logement.

            </p>
            <p class="fst-italic">
              Un séjour d’études à l’étranger ne s’improvise pas. C’est pourquoi notre équipe d’experts met à votre disposition son expérience, son réseau international, et son engagement pour garantir une organisation optimale de votre rentrée universitaire.
              Vous vous demandez :
            </p>
            <ul>
              <li><i class="bi bi-check2-all"></i> <span>Comment partir ?</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Comment obtenir un visa ?</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Où et quoi étudier ?</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Comment financer vos études ?</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Quelle université choisir ?</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Où se loger ?</span></li>
            </ul>
            <p>
              MyPass a les réponses. Ensemble, donnons vie à vos ambitions à l’international.
            </p>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
              <i class="fas fa-map-marked-alt flex-shrink-0"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="3" data-purecounter-duration="1" class="purecounter"></span>
                <p>Destinations</p>
              </div>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
              <i class="fas fa-award flex-shrink-0"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="10" data-purecounter-duration="1" class="purecounter"></span>
                <p>Années D'éxperience</p>
              </div>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
              <i class="fas fa-passport flex-shrink-0"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="300" data-purecounter-duration="1" class="purecounter"></span>
                <p>Visa acceptés</p>
              </div>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
              <i class="fas fa-handshake flex-shrink-0"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="10" data-purecounter-duration="1" class="purecounter"></span>
                <p>Partenaires</p>
              </div>
            </div>
          </div><!-- End Stats Item -->

        </div>

      </div>

    </section><!-- /Stats Section -->



    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title">
        <h2>Services</h2>
        <p>Chez MyPass, nous savons que préparer des études à l’étranger peut s’avérer complexe et parfois décourageant. C’est pourquoi nous vous proposons un accompagnement personnalisé et complet, depuis la préparation de votre projet jusqu’à votre installation dans le pays d’accueil.

          Que vous envisagiez de poursuivre vos études à l’étranger après le bac ou que vous recherchiez des opportunités d'études même sans le bac, nous mettons à votre disposition toutes les informations et les démarches nécessaires : demande de visa étudiant, recherche de logement, choix de la destination, sélection de l’université, et bien plus encore.

          Nos services sont conçus pour vous guider pas à pas vers la réussite académique, que votre destination soit le Canada, l’Afrique du Sud, ou toute autre destination prisée par les étudiants internationaux.
        </p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6">
            <div class="service-item  position-relative">
              <div class="icon">
                <i class="fas fa-file-alt"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Demande d'admission</h3>
              </a>
              <p>MyPass constitue le moyen le plus efficace et le plus rapide pour assurer le traitement de votre demande d'admission.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-passport"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Demande de visa</h3>
              </a>
              <p>Nos consultants des admissions travaillent en coopération très étroite avec les agents chargés des visas de nos destinations. Ils se tiennent informés des nouvelles lois concernant les visas et savent exactement quels documents sont nécessaires pour aider les étudiants.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-plane-departure"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Reservation billet d'avion</h3>
              </a>
              <p>Réservez vos billets d'avion à petit prix vers plus de 100 destinations.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-hands-helping"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Assistance et Suivi</h3>
              </a>
              <p>Assistance particuliers et professionnels· Suivi de votre dossier. Consulter l'état d'avancement de tous vos dossiers en temps réel.</p>
              <a href="#" class="stretched-link"></a>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-file-signature"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Traductions et légalisations</h3>
              </a>
              <p>Nos consultants des admissions travaillent en coopération très étroite avec les agents chargés des visas de nos destinations. Ils se tiennent informés des nouvelles lois concernant les visas et savent exactement quels documents sont nécessaires à traduire et légaliser.</p>
              <a href="#" class="stretched-link"></a>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-hotel"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Reservation Logement</h3>
              </a>
              <p>Grâce à nos partenariats, nous vous proposons les solutions d’hébergement les plus adaptées à votre situation: résidences universitaires, colocations, etc.</p>
              <a href="#" class="stretched-link"></a>
            </div>
          </div><!-- End Service Item -->

        </div>

      </div>

    </section><!-- /Services Section -->




    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

      <!-- Section Title -->
      <div class="container section-title">
        <h2>Témoignage</h2>
        <p>Expériences partagées</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="swiper init-swiper" data-speed="600" data-delay="5000" data-breakpoints="{ &quot;320&quot;: { &quot;slidesPerView&quot;: 1, &quot;spaceBetween&quot;: 40 }, &quot;1200&quot;: { &quot;slidesPerView&quot;: 3, &quot;spaceBetween&quot;: 40 } }">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 40
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 20
                }
              }
            }
          </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item" "="">
            <p>
              <i class=" bi bi-quote quote-icon-left"></i>
                <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>
                <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="candidate/assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                <h3>Saul Goodman</h3>
                <h4>Ceo &amp; Founder</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="candidate/assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                <h3>Sara Wilsson</h3>
                <h4>Designer</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="candidate/assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                <h3>Jena Karlis</h3>
                <h4>Store Owner</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="candidate/assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                <h3>Matt Brandon</h3>
                <h4>Freelancer</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="candidate/assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                <h3>John Larson</h3>
                <h4>Entrepreneur</h4>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->





    <!-- Faq Section -->
    <section id="faq" class="faq section light-background">

      <!-- Section Title -->
      <div class="container section-title">
        <h2>Notre Process</h2>
        <p>Planifier vos études à l’étranger avec MyPass</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-10">

            <div class="faq-container">

              <div class="faq-item">
                <h3>Non consectetur a erat nam at lectus urna duis?</h3>
                <div class="faq-content">
                  <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Feugiat scelerisque varius morbi enim nunc faucibus?</h3>
                <div class="faq-content">
                  <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Dolor sit amet consectetur adipiscing elit pellentesque?</h3>
                <div class="faq-content">
                  <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?</h3>
                <div class="faq-content">
                  <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Tempus quam pellentesque nec nam aliquam sem et tortor?</h3>
                <div class="faq-content">
                  <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Perspiciatis quod quo quos nulla quo illum ullam?</h3>
                <div class="faq-content">
                  <p>Enim ea facilis quaerat voluptas quidem et dolorem. Quis et consequatur non sed in suscipit sequi. Distinctio ipsam dolore et.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>

          </div><!-- End Faq Column-->

        </div>

      </div>

    </section><!-- /Faq Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
        <?php
        include_once("candidate-contacts.php");
        ?>



    </section><!-- /Contact Section -->

  </main>

<?php
include_once("candidate/layouts/footer.php");
?>


</body>

</html>