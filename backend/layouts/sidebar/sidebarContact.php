<?php
// Définir les accès pour le profil
$contactAccess = [
    'view' => get_access($bdd, 2, $_SESSION['my_idprofile']),
    
];

// Configuration du menu (centralisé)
$profileMenu = [
    'title' => 'Gestion des Contacts',
    'icon' => 'fas fa-fw fa-envelope',
    'items' => [
        'view' => [
            'label' => 'Contacts',
            'href' => BASE_URL . 'modules/contacts/views/list.php',
        ]
    ]
];


if ($contactAccess['view']): ?>
    <li class="nav-item <?= ($get_active_menu === "contact") ? "active" : ""; ?> treeview">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseContact" aria-expanded="true"
            aria-controls="collapseContact">
            <i class="fas fa-fw fa-envelope"></i>
            <span><?= $profileMenu['title'] ?></span>
        </a>

        <div id="collapseContact" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestion Contact:</h6>

                <?php if ($contactAccess['view']): ?>
                    <a class="collapse-item" href="<?= $profileMenu['items']['view']['href'] ?>">
                        <?= $profileMenu['items']['view']['label'] ?>
                    </a>
                <?php endif; ?>


            </div>
        </div>
    </li>

<?php endif; ?>