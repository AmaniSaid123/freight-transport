              <?php	if(get_access(29,$_SESSION['my_idprofile'])==1){ ?>
              <li class=" <?php	echo ($get_active_menu=="avance") ? "active" : "" ;?> treeview">
              
              <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Options avancées</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <?php	if(get_access(29,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="journal_agence.php"><i class="fa fa-circle-o text-aqua"></i> Journal de l'agence</a></li>
                <?php	
			    }
          ?>
           <?php	if(get_access(47,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="journal_ops_fin.php"><i class="fa fa-circle-o text-aqua"></i> Journal OPS FIN</a></li>
                <?php	
			    }
          ?>
           <?php	if(get_access(48,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="journal_systeme.php"><i class="fa fa-circle-o text-aqua"></i> Journal Système</a></li>
                <?php	
			    }
			    ?>
                

             
               
               
                              
 				<?php	if(get_access(56,$_SESSION['my_idprofile'])==1){ ?>
                 <small class="label pull-right bg-green"></small>
				<li><a href="#"><i class="fa fa-folder-open-o">    Gestion des Statuts</i></a>
                <ul class="treeview-menu">
                    <li><a href="add_statut.php"><i class="fa fa-circle-o text-yellow"></i> Tous les statuts</a></li>
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
