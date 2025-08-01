              <?php	if(get_access(2,$_SESSION['my_idprofile'])==1 || get_access(3,$_SESSION['my_idprofile'])==1 || get_access(4,$_SESSION['my_idprofile'])==1){ ?>
              <li class=" <?php	echo ($get_active_menu=="profile") ? "active" : "" ;?> treeview">
              
              <a href="#">
                <i class="fa fa-users"></i>
                <span>Gestion des Profiles</span>
                <i class="fa fa-angle-left pull-right"></i>
               
              </a>
              <ul class="treeview-menu">

               <?php	if(get_access(2,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="list_profile.php"><i class="fa fa-circle-o text-aqua"></i> Profiles des Utilisateurs</a></li>

                <?php	
			    }
			    ?>
                <?php	if(get_access(4,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="add_profile.php"><i class="fa fa-circle-o text-aqua"></i> Nouveau Profile</a></li>
                <?php	
			    }
			    ?>
                <?php	if(get_access(3,$_SESSION['my_idprofile'])==1 && $_SESSION['my_m_profile']!="NA"){ ?>
                <small class="label pull-right bg-green">#</small>                
				<li><a href="#"><i class="fa fa-folder-open-o"></i></a>
                <ul class="treeview-menu">
                    <li><a href="edit_profile.php"><i class="fa fa-circle-o text-yellow"></i> Editer un Profile</a></li>
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
