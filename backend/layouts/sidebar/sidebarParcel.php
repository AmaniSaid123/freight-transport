<?php
// Définir les accès pour le profil
$parcelAccess = [
    'view' => get_access($bdd, 19, $_SESSION['my_idprofile']),
    
];

// Configuration du menu (centralisé)
$profileMenu = [
    'title' => 'Gestion des Colis',
    'icon' => 'fas fa-fw fa-envelope',
    'items' => [
        'view' => [
            'label' => 'Colis',
            'href' => BASE_URL . 'modules/parcels/views/list.php',
        ]
    ]
];


if ($parcelAccess['view']): ?>
    <li class="nav-item <?= ($get_active_menu === "contact") ? "active" : ""; ?> treeview">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParcel" aria-expanded="true"
            aria-controls="collapseParcel">
            <i class="fas fa-fw fa-envelope"></i>
            <span><?= $profileMenu['title'] ?></span>
        </a>

        <div id="collapseParcel" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestion Contact:</h6>

                <?php if ($parcelAccess['view']): ?>
                    <a class="collapse-item" href="<?= $profileMenu['items']['view']['href'] ?>">
                        <?= $profileMenu['items']['view']['label'] ?>
                    </a>
                <?php endif; ?>


            </div>
        </div>
    </li>

<?php endif; ?>