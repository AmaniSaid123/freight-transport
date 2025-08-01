              <?php	if(1){ ?>
              <li class=" <?php	echo ($get_active_menu=="dossier_online") ? "active" : "" ;?> treeview">
              
              <a href="#">
                <i class="fa fa-globe"></i>
                <span>Dossier en ligne</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <?php	if(1){ ?>
                  <li><a href="dossier_online.php"><i class="fa fa-circle-o text-aqua"></i> Créer un dossier en ligne</a></li>
                <?php	
			    }
			    ?>
                

             
               
                
                 <?php	if(isset($_SESSION['my_doc_online'])){ ?>
                <li><a href="view_doc_editable.php"><i class="fa  fa-television text-aqua"></i> Apercu Dossier</a></li>
                <li><a href="journal_online.php"><i class="fa  fa-calendar-check-o text-aqua"></i> Journal du Dossier</a></li>
                <li><a href="print_manifeste.php" target="_blank"><i class="fa  fa-print text-aqua"></i> Page Imprimable</a></li>
                
                <?php	
			    }
			    ?>
                <?php	if(1){ ?>
                <li><a href="login.php"><?php	echo (isset($_SESSION['my_doc_online']) && $_SESSION['my_doc_online']!="NA") ? '<i class="fa  fa-close text-red"></i>Déconnexion' : '<i class="fa  fa-folder-open-o text-aqua"></i>Consulter un Dossier' ?> </a></li>
                <?php	
			    }
			    ?>  
                
                                 <?php	if(1){ ?>
                 
				<li><a href="#"><i class="fa fa-folder-open-o">  Liens utiles du site</i></a>
                <ul class="treeview-menu">
                 
                    <li><a href="https://passportsarl.voyage/index.php/etudier-a-letranger" target="_blank"><i class="fa  text-aqua"></i> Etudier à l'étranger</a></li>
                <li><a href="https://passportsarl.voyage/index.php/voyages-daffaires-de-tourismes-et-de-noce"><i class="fa  text-aqua"></i> Affaires et Tourismes</a></li>
                <li><a href="https://passportsarl.voyage/index.php/vente-des-billets-davion" target="_blank"><i class="fa  text-aqua"></i> Achat billets</a></li>
                <li><a href="https://passportsarl.voyage/index.php/autres-services" target="_blank"><i class="fa  text-aqua"></i> Autres services</a></li>
                
                
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
