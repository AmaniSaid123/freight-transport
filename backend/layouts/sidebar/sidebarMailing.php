<?php
// Définir les accès pour le profil
$mailingAccess = [
    'view' => get_access($bdd, 2, $_SESSION['my_idprofile']),
    'create' => get_access($bdd, 3, $_SESSION['my_idprofile']),
];

// Configuration du menu (centralisé)
$profileMenu = [
    'title' => 'Gestion des Mailings',
    'icon' => 'fas fa-fw fa-envelope',
    'items' => [
        'view' => [
            'label' => 'Mailing',
            'href' => BASE_URL . 'modules/mailing/views/list.php',
        ],
        'create' => [
            'label' => 'Nouveau mailing',
            'href' => BASE_URL . 'modules/mailing/views/add.php',
        ]
    ]
];


if ($mailingAccess['view'] || $mailingAccess['create']): ?>
    <li class="nav-item <?= ($get_active_menu === "mailing") ? "active" : ""; ?> treeview">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMailing" aria-expanded="true"
            aria-controls="collapseMailing">
            <i class="fas fa-fw fa-envelope"></i>
            <span><?= $profileMenu['title'] ?></span>
        </a>

        <div id="collapseMailing" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestion Mailings:</h6>

                <?php if ($mailingAccess['view']): ?>
                    <a class="collapse-item" href="<?= $profileMenu['items']['view']['href'] ?>">
                        <?= $profileMenu['items']['view']['label'] ?>
                    </a>
                <?php endif; ?>


                <?php if ($mailingAccess['create']): ?>
                    <a class="collapse-item" href="<?= $profileMenu['items']['create']['href'] ?>">
                        <?= $profileMenu['items']['create']['label'] ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </li>

<?php endif; ?>