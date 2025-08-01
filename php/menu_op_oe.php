              <?php	if(get_access(42,$_SESSION['my_idprofile'])==1 || get_access(43,$_SESSION['my_idprofile'])==1 || get_access(44,$_SESSION['my_idprofile'])==1 || get_access(45,$_SESSION['my_idprofile'])==1){ ?>
              <li class=" <?php	echo ($get_active_menu=="op-oe") ? "active" : "" ;?> treeview">
              
              <a href="#">
                <i class="fa fa-exchange"></i>
                <span>Gestions OP-OE</span>
                <i class="fa fa-angle-left pull-right"></i>
               
              </a>
              <ul class="treeview-menu">

               <?php	if(get_access(43,$_SESSION['my_idprofile'])==1 || get_access(44,$_SESSION['my_idprofile'])==1 || get_access(45,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="ordre_paiement.php"><i class="fa fa-circle-o text-aqua"></i> Ordre de Paiement (OP)</a></li>

                <?php
			    }
			    ?>


                  <?php	if(0 && get_access(42,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="ordre_encaissement.php"><i class="fa fa-circle-o text-aqua"></i> Ordre d'Encaissement (OE)</a></li>
                <?php
			    }
          ?>
          <?php	if(get_access(42,$_SESSION['my_idprofile'])==1){ ?>
                <li><a href="ordre_encaissement_revamp.php"><i class="fa fa-circle-o text-aqua"></i> Ordre d'Encaissement (OE)</a></li>
                <?php
			    }
			    ?>
                  <?php	if(get_access(68,$_SESSION['my_idprofile'])==1 ){ ?>
                      <li><a href="ordre_online_payment.php"><i class="fa fa-circle-o text-aqua"></i> Ordre de Paiement en ligne</a></li>

                      <?php
                  }
                  ?>

              </ul>
            </li>
            <?php
			  }
			?>
