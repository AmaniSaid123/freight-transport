<?php
// Définir les accès pour le user
$userAccess = [
    'view' => get_access($bdd, 8, $_SESSION['my_idprofile']),
    'create' => get_access($bdd, 9, $_SESSION['my_idprofile']),
];

// Configuration du menu (centralisé)
$userMenu = [
    'title' => 'Gestion des Users',
    'icon' => 'fa fa-users',
    'items' => [
        'view' => [
            'label' => 'Users',
            'href' => BASE_URL . 'modules/users/views/list.php',
        ],
        'create' => [
            'label' => 'Nouveau User',
            'href' => BASE_URL . 'modules/users/views/add.php',
        ]
    ]
];

if ($userAccess['view'] || $userAccess['create']): ?>
    <li class="nav-item <?= ($get_active_menu === "user") ? "active" : ""; ?> treeview">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true"
            aria-controls="collapseUsers">
            <i class="fa fa-users"></i>
            <span><?= $userMenu['title'] ?></span>
        </a>

        <div id="collapseUsers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestion Utilisateurs:</h6>

                <?php if ($userAccess['view']): ?>
                    <a class="collapse-item" href="<?= $userMenu['items']['view']['href'] ?>">
                        <?= $userMenu['items']['view']['label'] ?>
                    </a>
                <?php endif; ?>

                <?php if ($userAccess['create']): ?>
                    <a class="collapse-item" href="<?= $userMenu['items']['create']['href'] ?>">
                        <?= $userMenu['items']['create']['label'] ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </li>
<?php endif; ?>
