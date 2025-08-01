<?php	if(get_access(57,$_SESSION['my_idprofile'])==1 || get_access(57,$_SESSION['my_idprofile'])==1 || get_access(57,$_SESSION['my_idprofile'])==1){ ?>
              <li class=" <?php	echo ($get_active_menu=="procedure") ? "active" : "" ;?> treeview">
              
              <a href="#">
                <i class="fa fa-check-square"></i>
                <span>Procédure de Controle</span>
                <i class="fa fa-angle-left pull-right"></i>
               
              </a>
              <ul class="treeview-menu">

               <?php	if(get_access(57,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="list_procedure.php"><i class="fa fa-circle-o text-aqua"></i> Liste Procédure de Controle</a></li>

                <?php	
			    }
			    ?>
                <?php	if(get_access(57,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="add_procedure.php"><i class="fa fa-circle-o text-aqua"></i> Nouvelle Procedure</a></li>
                <?php	
			    }
			    ?>
                <?php	if(get_access(57,$_SESSION['my_idprofile'])==1 && $_SESSION['my_m_procedure']!="NA"){ ?>
                <small class="label pull-right bg-green">#</small>                
				<li><a href="#"><i class="fa fa-folder-open-o"></i></a>
                <ul class="treeview-menu">
                    <li><a href="edit_procedure.php"><i class="fa fa-circle-o text-yellow"></i> Editer une Procedure</a></li>
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
