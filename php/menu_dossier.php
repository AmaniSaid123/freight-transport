              <?php	if(get_access(9,$_SESSION['my_idprofile'])==1 
			  || get_access(10,$_SESSION['my_idprofile'])==1 
			  || get_access(11,$_SESSION['my_idprofile'])==1
			  || get_access(12,$_SESSION['my_idprofile'])==1
			  || get_access(13,$_SESSION['my_idprofile'])==1){ ?>
              <li class=" <?php	echo ($get_active_menu=="dossier") ? "active" : "" ;?> treeview">
              
              <a href="#">
                <i class="fa fa-folder"></i>
                <span>Gestion des Dossiers</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <?php	if(get_access(9,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="liste_dossier.php"><i class="fa fa-circle-o text-aqua"></i> Liste Dossiers</a></li>
                <?php	
			    }
			    ?>
                

             
               <?php	if(get_access(14,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="add_dossier.php"><i class="fa  fa-plus text-aqua"></i> Créer Dossier</a></li>
                <?php	
			    }
			    ?>
               
                              
 				<?php	if($_SESSION['my_m_dossier']!="NA"){ ?>
                 <small class="label pull-right bg-green">#</small>
				<li><a href="#"><i class="fa fa-folder-open-o"></i></a>
                <ul class="treeview-menu">
                 <?php	if(get_access(10,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="vue_dossier.php"><i class="fa  fa-television text-aqua"></i> Apercu Dossier</a></li>
                <li><a href="journal_timeline.php"><i class="fa  fa-calendar-check-o text-aqua"></i> Journal du Client</a></li>
                <li><a href="journal_interne.php"><i class="fa   fa-warning text-aqua"></i> Journal Interne</a></li>
               
                <li><a href="print_manifeste_dossier.php" target="_blank"><i class="fa  fa-print text-aqua"></i> Page Imprimable</a></li>
                <?php	
			    }
          ?>
          <?php	if(get_access(53,$_SESSION['my_idprofile'])==1){ ?>
                
                <li><a href="journal_ops_fin_dossier.php"><i class="fa   fa-calendar-check-o text-aqua"></i> Journal Financier</a></li>
               
                <?php	
			    }
          ?>
          <?php	if(get_access(58,$_SESSION['my_idprofile'])==1){ ?>
                
                <li><a href="checkup_list_dossier.php"><i class="fa  fa-check-square-o text-aqua"></i> Checkup taches de controle</a></li>
               
                <?php	
			    }
			    ?>
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
