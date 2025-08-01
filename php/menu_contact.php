<li class=" <?php echo ($get_active_menu == "contact") ? "active" : ""; ?> treeview">
  <a href="#">
    <i class="fa fa-envelope" aria-hidden="true"></i>
    <span>Gestion des Contacts </span>
    <i class="fa fa-angle-left pull-right" aria-hidden="true"></i>
  </a>
  <ul class="treeview-menu">
    <?php if (get_access(64, $_SESSION['my_idprofile']) == 1) { ?>
    <li><a href="list_contact.php">
        <i class="fa fa-circle-o text-aqua" aria-hidden="true"></i> Liste des contacts</a></li>
    <?php
    }
    ?>
  </ul>
</li>