              <?php	if(get_access(6,$_SESSION['my_idprofile'])==1 || get_access(7,$_SESSION['my_idprofile'])==1 || get_access(8,$_SESSION['my_idprofile'])==1){ ?>
              <li class=" <?php	echo ($get_active_menu=="user") ? "active" : "" ;?> treeview">
              
              <a href="#">
                <i class="fa fa-user"></i>
                <span>Gestion des Utilisateurs</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <?php	if(get_access(6,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="list_user.php"><i class="fa fa-circle-o text-aqua"></i> Liste des Utilisateurs</a></li>
                <?php	
			    }
			    ?>
                

             
               <?php	if(get_access(7,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="add_user.php"><i class="fa fa-circle-o text-aqua"></i> Ajouter Utilisateur</a></li>
                <?php	
			    }
			    ?>
               
                              
 				<?php	if(get_access(9,$_SESSION['my_idprofile'])==1 && $_SESSION['my_m_user']!="NA"){ ?>
                 <small class="label pull-right bg-green">#</small>
				<li><a href="#"><i class="fa fa-folder-open-o"></i></a>
                <ul class="treeview-menu">
                    <li><a href="edit_user.php"><i class="fa fa-circle-o text-yellow"></i> Editer Utilisateur</a></li>
                </ul>
                </li>
                <?php	
			    }
			    ?>                

              </ul>
            </li>
            <?php	
			  }
			?>
