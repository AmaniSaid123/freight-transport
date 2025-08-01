<?php if (get_access(41, $_SESSION['my_idprofile']) == 1) { ?>
    <li class=" <?php echo ($get_active_menu == "DG") ? "active" : ""; ?> treeview">

        <a href="#">
            <i class="fa fa-slack" aria-hidden="true" /></i>
            <span>Direction Générale</span>
            <i class="fa fa-angle-left pull-right" aria-hidden="true" /></i>
        </a>
        <ul class="treeview-menu">
            <?php if (get_access(41, $_SESSION['my_idprofile']) == 1 && 0) { ?>
                <small class="label pull-left bg-green">#Comptabilité</small>
                <li><a href="#"><i class="fa fa-folder-open-o" aria-hidden="true"></i></a>
                    <?php if (get_access(109, $_SESSION['my_idprofile']) == 1) { ?>

                        <ul class="treeview-menu">
                            <li><a href="grand_journal_condensed_general.php"><i class="fa fa-circle-o text-red" aria-hidden="true" /></i>Grand Journal
                                    Condensé</a></li>
                        </ul>
                    <?php } ?>
                    <?php if (get_access(41, $_SESSION['my_idprofile']) == 1 && 0) { ?>

                        <ul class="treeview-menu">
                            <li><a href="add_ecriture_auto.php"><i class="fa fa-circle-o text-red" aria-hidden="true" /></i>Configurer une ecriture</a>
                            </li>
                        </ul>
                    <?php } ?>
                </li>
            <?php
            }
            ?>


            <?php if (get_access(109, $_SESSION['my_idprofile']) == 1 && 0) { ?>
                <small class="label pull-left bg-green">#Ecritures Manuelles</small>
                <li><a href="#"><i class="fa fa-folder-open-o" aria-hidden="true" /></i></a>
                    <?php if (get_access(41, $_SESSION['my_idprofile']) == 1) { ?>
                        <ul class="treeview-menu">
                            <li><a href="ecriture_manuelle_compta.php"><i class="fa fa-circle-o text-red" aria-hidden="true" /></i>Passer les
                                    ecritures</a></li>
                        </ul>
                    <?php } ?>

                </li>
            <?php
            }
            ?>


            <?php if (get_access(41, $_SESSION['my_idprofile']) == 1) { ?>
                <small class="label pull-left bg-green">#Grand Journal</small>
                <li><a href="#"><i class="fa fa-folder-open-o" aria-hidden="true" /></i></a>
                    <?php if (get_access(41, $_SESSION['my_idprofile']) == 1) { ?>

                        <ul class="treeview-menu">
                            <li><a href="grand_journal_dg.php"><i class="fa fa-circle-o text-red" aria-hidden="true" /></i>Grand Journal</a></li>
                        </ul>
                        <ul class="treeview-menu">
                            <li><a href="grand_journal_condensed_general.php"><i class="fa fa-circle-o text-red" aria-hidden="true" /></i>Grand Journal
                                    Condensé</a></li>
                        </ul>
                        <ul class="treeview-menu">
                            <li><a href="livre_compte_dg.php"><i class="fa fa-circle-o text-red" aria-hidden="true" /></i>Livre des Comptes</a></li>
                        </ul>
                        <ul class="treeview-menu">
                            <li><a href="add_banner.php"><i class="fa fa-circle-o text-red" aria-hidden="true" /></i>Banners</a></li>
                        </ul>
                     
                     
                    <?php } ?>
                    <?php if (get_access(109, $_SESSION['my_idprofile']) == 1 && 0) { ?>
                        <ul class="treeview-menu">
                            <li><a href="livre_compte.php">
                                    <i class="fa fa-circle-o text-red" aria-hidden="true" /></i>
                                    Livre des Comptes</a>
                            </li>
                            <li><a href="capture_bilan.php">
                                    <i class="fa fa-circle-o text-red" aria-hidden="true" /></i>
                                    Captures Bilan</a>
                            </li>
                        </ul>
                    <?php } ?>

                </li>
            <?php
            }
            ?>




        </ul>

    <?php
}
    ?>