

<?php
// S'assurer que les constantes sont définies
if (!defined('BASE_URL')) {
        require_once __DIR__ . '/../../../config/constants.php';  

}

// Inclure head.php
include_once __DIR__ . '/head.php';
?>

  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="home.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>TCC</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>TrustedCargo</b></span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">


            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="<?php echo $_SESSION['my_user_picture']; ?> " class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?php echo $_SESSION['my_firstname'] . " " . $_SESSION['my_lastname']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="<?php echo $_SESSION['my_user_picture']; ?>" class="img-circle" alt="User Image">
                  <p>
                    <?php echo $_SESSION['my_firstname'] . " " . $_SESSION['my_lastname'] . " - " . $_SESSION['my_profile']; ?>
                    <small>Connecté : <?php echo $_SESSION['my_time']; ?></small>
                  </p>
                </li>


                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="reset_password.php" class="btn btn-default btn-flat">Mon Profile</a>
                  </div>

                  <div class="pull-left">
                    <a href="home.php?refresh=01x0" class="btn btn-default btn-flat"><i class="fa fa-refresh"></i></a>
                  </div>

                  <div class="pull-right">
                    <a href="<?= BASE_URL ?>index.php?page=deconnect"  class="btn btn-default btn-flat">Déconnexion</a>

                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->

          </ul>
        </div>
      </nav>
    </header>

    <aside class="main-sidebar">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?php echo $_SESSION['my_user_picture']; ?>" class="img-circle" alt="User Image">

          </div>
          <div class="pull-left info">
            <p><?php echo $_SESSION['my_firstname'] . " " . $_SESSION['my_lastname']; ?></p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle  <?php echo (1) ? "text-success" : "text-red"; ?>"></i><?php


                   ?></a>
          </div>
        </div>

        <?php
        include_once __DIR__ . '/../layouts/main_menu.php';
        ?>

      </section>

    </aside>

    