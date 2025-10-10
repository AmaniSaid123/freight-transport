<?php
// Définir les accès pour le profil
$profileAccess = [
    'view' => get_access($bdd, 3, $_SESSION['my_idprofile']),
    'create' => get_access($bdd, 4, $_SESSION['my_idprofile']),
];

// Configuration du menu (centralisé)
$profileMenu = [
    'title' => 'Gestion des Profils',
    'icon' => 'fa fa-users',
    'items' => [
        'view' => [
            'label' => 'Profiles',
            'href' => BASE_URL . 'modules/profiles/views/list.php',
        ],
        'create' => [
            'label' => 'Nouveau Profil',
            'href' => BASE_URL . 'modules/profiles/views/add.php',
        ]
    ]
];


if ($profileAccess['view'] || $profileAccess['create']): ?>
    <li class="nav-item <?= ($get_active_menu === "profile") ? "active" : ""; ?> treeview">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fa fa-users"></i>
            <span><?= $profileMenu['title'] ?></span>
        </a>

        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestion Profils:</h6>

                <?php if ($profileAccess['view']): ?>
                    <a class="collapse-item" href="<?= $profileMenu['items']['view']['href'] ?>">
                        <?= $profileMenu['items']['view']['label'] ?>
                    </a>
                <?php endif; ?>


                <?php if ($profileAccess['create']): ?>
                    <a class="collapse-item" href="<?= $profileMenu['items']['create']['href'] ?>">
                        <?= $profileMenu['items']['create']['label'] ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </li>

<?php endif; ?>