<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container">
        <a class="navbar-brand" href="../customer_home.php">
            <img class="d-inline-block" src="../front/assets/images/logo passeport.png" width="100" alt="logo" />
        </a>
        <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto pt-2 pt-lg-0 font-base">
                <li class="nav-item px-2">
                    <a class="nav-link fw-medium active" aria-current="page" href="#destinations">
                        <span class="nav-link-icon text-800 me-1 fas fa-home"></span>
                        <span class="nav-link-text">Accueil</span>
                    </a>
                </li>

                <li class="nav-item px-2">
                    <a class="nav-link" href="#hotels">
                        <span class="nav-link-icon text-800 me-1 fas fa-concierge-bell"></span>
                        <span class="nav-link-text">Nos services</span>
                    </a>
                </li>

                <li class="nav-item px-2">
                    <a class="nav-link" href="#hotels">
                        <span class="nav-link-icon text-800 me-1 fas fa-cogs"></span>
                        <span class="nav-link-text">Notre process</span>
                    </a>
                </li>

                <li class="nav-item px-2">
                    <a class="nav-link" href="#flights">
                        <span class="nav-link-icon text-800 me-1 fas fa-info-circle"></span>
                        <span class="nav-link-text">À propos</span>
                    </a>
                </li>

                <li class="nav-item px-2">
                    <a class="nav-link" href="#activities">
                        <span class="nav-link-icon text-800 me-1 fas fa-envelope"></span>
                        <span class="nav-link-text">Contact</span>
                    </a>
                </li>
            </ul>
            <form>

                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Espace Condidat
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="../customer_add_folder.php">Créer Votre Dossier</a></li>
                        <li><a class="dropdown-item" href="../customer_authentification.php">Accéder à votre dossier</a></li>
                        <li><a class="dropdown-item" href="../customer_show_payment.php">Effectuer un paiement</a></li>
                    </ul>
                </div>
            </form>
            <!-- Vérification si l'utilisateur est connecté -->
            <?php if (isset($_SESSION['my_doc_online'])) : ?>
                <a href="customer_logout.php" class="btn btn-danger ms-3">Déconnecter</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
