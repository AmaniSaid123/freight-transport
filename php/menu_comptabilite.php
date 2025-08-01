              <?php	if(get_access(31,$_SESSION['my_idprofile'])==1 || get_access(33,$_SESSION['my_idprofile'])==1 || get_access(34,$_SESSION['my_idprofile'])==1 || get_access(35,$_SESSION['my_idprofile'])==1 || get_access(38,$_SESSION['my_idprofile'])==1){ ?>
              <li class=" <?php	echo ($get_active_menu=="comptabilite") ? "active" : "" ;?> treeview">
              
              <a href="#">
                <i class="fa  fa-slack"></i>
                <span>Comptabilité</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                            
                              
 				<?php	if((get_access(35,$_SESSION['my_idprofile'])==1 || get_access(35,$_SESSION['my_idprofile'])==1)){ ?>
                 <small class="label pull-left bg-green">#Ecritures Automatiques</small>
				<li><a href="#"><i class="fa fa-folder-open-o"></i></a>
			<?php	if(get_access(35,$_SESSION['my_idprofile'])==1){ ?>

                <ul class="treeview-menu">
                    <li><a href="list_ecriture_auto.php"><i class="fa fa-circle-o text-red"></i>Liste des ecritures</a></li>
                </ul>
             <?php    }    ?>
             	<?php	if(get_access(35,$_SESSION['my_idprofile'])==1){ ?>

                <ul class="treeview-menu">
                    <li><a href="add_ecriture_auto.php"><i class="fa fa-circle-o text-red"></i>Configurer une ecriture</a></li>
                </ul>
             <?php    }    ?>
                </li>
                <?php	
			    }
                ?>      
                <?php	if((get_access(34,$_SESSION['my_idprofile'])==1)){ ?>
                 <small class="label pull-left bg-green">#Opérations Financières</small>
				<li><a href="#"><i class="fa fa-folder-open-o"></i></a>
			<?php	if(get_access(34,$_SESSION['my_idprofile'])==1){ ?>

                <ul class="treeview-menu">
                <a class="btn btn-adn" href="livre_compte.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&action=add_operation&compte=yes" ><i class="fa fa-fw  fa-arrow-right"></i>Ajouter une Opération<i class="fa fa-fw  fa-plus-square"></i> </a>                   
                </ul>
             <?php    }    ?>
             	<?php	if(get_access(16,$_SESSION['my_idprofile'])==1 && 0){ ?>

                <ul class="treeview-menu">
                    <li><a href="add_ecriture_auto.php"><i class="fa fa-circle-o text-red"></i>Configurer une ecriture</a></li>
                </ul>
             <?php    }    ?>
                </li>
                <?php	
			    }
			    ?>  
                
                            
             	<?php	if(get_access(37,$_SESSION['my_idprofile'])==1 || get_access(38,$_SESSION['my_idprofile'])==1){ ?>
                 <small class="label pull-left bg-green">#Ecritures Manuelles</small>
				<li><a href="#"><i class="fa fa-folder-open-o"></i></a>
			<?php	if(get_access(37,$_SESSION['my_idprofile'])==1){ ?>

                <ul class="treeview-menu">
                    <li><a href="ecriture_manuelle_compta.php"><i class="fa fa-circle-o text-red"></i>Passer les ecritures</a></li>
                </ul>
             <?php    }    ?>
             <?php	if(get_access(38,$_SESSION['my_idprofile'])==1 && 0){ ?>

<ul class="treeview-menu">
    <li><a href="ecriture_manuelle_compta_revamp.php"><i class="fa fa-circle-o text-red"></i>Passer les ecritures Deloc</a></li>
</ul>
<?php    }    ?>
             	
                </li>
                <?php	
			    }
			    ?>      

                                
 				<?php	if((get_access(31,$_SESSION['my_idprofile'])==1 || get_access(39,$_SESSION['my_idprofile'])==1)){ ?>
                 <small class="label pull-left bg-green">#Grand Journal</small>
				<li><a href="#"><i class="fa fa-folder-open-o"></i></a>
			<?php	if(get_access(38,$_SESSION['my_idprofile'])==1){ ?>

                <ul class="treeview-menu">
                    <li><a href="grand_journal.php"><i class="fa fa-circle-o text-red"></i>Grand Journal</a></li>
                </ul>
                <ul class="treeview-menu">
                    <li><a href="grand_journal_condensed.php"><i class="fa fa-circle-o text-red"></i>Grand Journal Condensé</a></li>
                </ul>
             <?php    }    ?>
             	<?php	if(get_access(31,$_SESSION['my_idprofile'])==1){ ?>

                <ul class="treeview-menu">
                    <li><a href="livre_compte.php"><i class="fa fa-circle-o text-red"></i>Livre des Comptes</a></li>
                    
                </ul>
             <?php    }    ?>
             <?php	if(get_access(33,$_SESSION['my_idprofile'])==1){ ?>

<ul class="treeview-menu">
    
    <li><a href="capture_bilan.php"><i class="fa fa-circle-o text-red"></i>Captures Bilan</a></li>
</ul>
<?php    }    ?>
             
                </li>
                <?php	
			    }
			    ?>  
                
                <?php	if((get_access(107,$_SESSION['my_idprofile'])==1 || get_access(107,$_SESSION['my_idprofile'])==1)){ ?>
                 <small class="label pull-left bg-green">#Referencement Comptable</small>
				<li><a href="#"><i class="fa fa-folder-open-o"></i></a>
			
             <?php	if(get_access(107,$_SESSION['my_idprofile'])==1){ ?>

                <ul class="treeview-menu">
                    <li><a href="referencement_reporting.php"><i class="fa fa-circle-o text-red"></i>Referencement des Comptes</a></li>
                  
                </ul>
             <?php    }    ?>
                </li>
                <?php	
			    }
			    ?>  

                             

              </ul>
           
            <?php	
			  }
			?>
