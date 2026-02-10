<?php
// Définir les accès pour le profil
$parcelAccess = [
'view' => get_access($bdd, 26, $_SESSION['my_idprofile']),
    
];

// Configuration du menu (centralisé)
$statusMenu = [
    'title' => 'Gestion des Colis',
    'icon' => 'fas fa-fw fa-boxes',
    'items' => [
        'view' => [
            'label' => 'Colis',
            'href' => BASE_URL . 'modules/parcels/views/list.php',
        ]
    ]
];


if ($parcelAccess['view']): ?>
    <li class="nav-item <?= ($get_active_menu === "colis") ? "active" : ""; ?> treeview">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParcel" aria-expanded="true"
            aria-controls="collapseParcel">
            <i class="fas fa-fw fa-boxes"></i>
            <span><?= $statusMenu['title'] ?></span>
        </a>

        <div id="collapseParcel" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestion Colis:</h6>

                <?php if ($parcelAccess['view']): ?>
                    <a class="collapse-item" href="<?= $statusMenu['items']['view']['href'] ?>">
                        <?= $statusMenu['items']['view']['label'] ?>
                    </a>
                <?php endif; ?>


            </div>
        </div>
    </li>

<?php endif; ?>