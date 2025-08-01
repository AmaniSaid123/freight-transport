<header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="d-none d-md-flex align-items-center">
                Pour vos questions
                <div class="phone-mail">
                    <i class="bi bi-phone me-1"></i>+243 82 7000 776
                </div>
                <div class="phone-mail">
                    <i class="bi bi-envelope me-1"></i>admin@passportsarl.voyage
                </div>
            </div>

        </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

        <div class="container position-relative d-flex align-items-center justify-content-end">
            <a href="candidate.php" class="logo d-flex align-items-center me-auto">
                <img src="candidate/assets/img/logo.png" alt="">

            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="candidate.php#home" class="active">Accueil</a></li>
                    <li><a href="candidate.php#about">À propos</a></li>
                    <li><a href="candidate.php#services">Nos services</a></li>
                    <li><a href="candidate.php#testimonials">Testimonials</a></li>

                    <li class="dropdown"><a href="#"><span>Mon dossier</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="candidate-details.php">Consulter dossier MyPass</a></li>
                            <li><a href="candidate-register.php">Créer dossier MyPass </a></li>
                            <li><a href="candidate-payment.php">Effectuer votre paiement</a></li>
                        </ul>
                    </li>
                    <li><a href="candidate.php#contact">Contact</a></li>
                    <?php if (isset($_SESSION['my_doc_online'])) : ?>
                    <li class="dropdown">
                        <a href="#"><span>Mon Profil</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li><a href="historique-dossier.php">Historique Dossier</a></li>
                            <li><a href="imprission-dossier.php">Page Imprimable </a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['my_doc_online'])) : ?>
                        <li><a href="candidate_logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                    <?php endif; ?>

                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>


        </div>

    </div>

</header>
