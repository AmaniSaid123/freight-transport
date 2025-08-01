<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="https://passportsarl.voyage" class="app-brand-link">
      <span class="app-brand-logo demo">

        <img src="images/logo_passport.png" width="auto" height="100" />
      </span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>
  <?php if (1) { ?>
    <ul class="menu-inner py-1">
      <li class="menu-header small text-uppercase <?php echo ($get_active_menu == "ajout-dossier") ? "active" : ""; ?>">
        <span class="menu-header-text">Dossier en ligne</span>
      </li>

      <?php if (isset($_SESSION['my_doc_online'])) { ?>
        <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-dock-top"></i>
            <div data-i18n="Account Settings">Dossier en ligne</div>
          </a>

          <ul class="menu-sub">
            <li class="menu-item">
              <a href="modification-dossier.php" class="menu-link">
                <div data-i18n="Connections">Aperçu Dossier</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="historique-dossier.php" class="menu-link">
                <div data-i18n="Account">Journal Du Dossier</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="imprission-dossier.php" class="menu-link">
                <div data-i18n="Notifications">Page Imprimable</div>
              </a>
            </li>

          </ul>
          <?php

          ?>
        </li>
      <?php
      } else {
      ?>
        <li class="menu-item" <?php echo ($get_active_menu == "ajout-dossier") ? "active" : ""; ?>">
          <a href="ajout-dossier.php" class="menu-link">
            <div data-i18n="Connections">Créer Dossier En ligne</div>
          </a>
        </li>

      <?php
      }
      ?>

    </ul>
  <?php
  }
  ?>
</aside>