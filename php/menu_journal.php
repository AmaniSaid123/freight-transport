<?php
$user_id = $_SESSION['my_userId'];
$sql_select1 = "SELECT `user_id`,`more_details` FROM t_journal_users
               WHERE DATE(date) = CURDATE() AND user_id = $user_id";
$sql_query1 = $bdd->query($sql_select1);
$data1 = $sql_query1->fetch();
?>
<li class=" <?php echo ($get_active_menu == "journal_user") ? "active" : ""; ?> treeview">
  <a href="#">
    <i class="fa fa-history" aria-hidden="true"></i>
    <span>Gestion des Journaux </span>
    <i class="fa fa-angle-left pull-right" aria-hidden="true"></i>
  </a>
  <ul class="treeview-menu">
    <?php if (get_access(64, $_SESSION['my_idprofile']) == 1) { ?>
    <li><a href="liste_journal.php">
        <i class="fa fa-circle-o text-aqua" aria-hidden="true"></i> Liste des journaux</a></li>
    <?php
    }
    ?>
    <li><a href="liste_my_journal.php?user_id=<?php echo $user_id; ?>">
        <i class="fa fa-circle-o text-aqua" aria-hidden="true"></i> Liste de mon Journal</a>
    </li>
    <?php if (empty($data1)) { ?>
    <li><a href="add_journal.php"><i class="fa fa-circle-o text-aqua" aria-hidden="true"></i> Ajouter Journal </a></li>
    <?php
    }
    ?>
    <?php if ((!isset($data1['more_details'])) && (isset($data1['user_id']))) { ?>
    <li><a href="ajouter_journal_details.php">

        <i class="fa fa-circle-o text-aqua" aria-hidden="true"></i> Ajouter Détail</a></li>
    <?php
    }
    ?>
  </ul>
</li>