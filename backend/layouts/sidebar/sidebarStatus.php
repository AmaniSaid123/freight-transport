<?php
// Définir les accès pour le status
$statusAccess = [
    'view' => get_access($bdd, 22, $_SESSION['my_idprofile']),
    'create' => get_access($bdd, 23, $_SESSION['my_idprofile']),
];

// Configuration du menu (centralisé)
$statusMenu = [
    'title' => 'Gestion des Status',
    'icon' => 'fa fa-tasks',
    'items' => [
        'view' => [
            'label' => 'Status',
            'href' => BASE_URL . 'modules/status/views/list.php',
        ],
        'create' => [
            'label' => 'Nouveau Statut',
            'href' => BASE_URL . 'modules/status/views/add.php',
        ]
    ]
];

if ($statusAccess['view'] || $statusAccess['create']): ?>
    <li class="nav-item <?= ($get_active_menu === "status") ? "active" : ""; ?> treeview">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStatues" aria-expanded="true"
            aria-controls="collapseStatues">
            <i class="fa fa-tasks"></i>
            <span><?= $statusMenu['title'] ?></span>
        </a>

        <div id="collapseStatues" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestion Status:</h6>

                <?php if ($statusAccess['view']): ?>
                    <a class="collapse-item" href="<?= $statusMenu['items']['view']['href'] ?>">
                        <?= $statusMenu['items']['view']['label'] ?>
                    </a>
                <?php endif; ?>

                <?php if ($statusAccess['create']): ?>
                    <a class="collapse-item" href="<?= $statusMenu['items']['create']['href'] ?>">
                        <?= $statusMenu['items']['create']['label'] ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </li>
<?php endif; ?>
