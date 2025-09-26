<li class=" <?php echo ($get_active_menu == "user") ? "active" : ""; ?> treeview">

  <a href="#">
    <i class="fa fa-user"></i>
    <span>Gestion des Utilisateurs</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>
  <ul class="treeview-menu">
    <li><a href="list_user.php"><i class="fa fa-circle-o text-aqua"></i> Liste des Utilisateurs</a></li>





    <li><a href="add_user.php"><i class="fa fa-circle-o text-aqua"></i> Ajouter Utilisateur</a></li>



    <small class="label pull-right bg-green">#</small>
    <li><a href="#"><i class="fa fa-folder-open-o"></i></a>
      <ul class="treeview-menu">
        <li><a href="edit_user.php"><i class="fa fa-circle-o text-yellow"></i> Editer Utilisateur</a></li>
      </ul>
    </li>


  </ul>
</li>