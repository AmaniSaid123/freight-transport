<div class="col-md-3">
             <?php	if(get_access(15,$_SESSION['my_idprofile'])==1){ ?>
              <a href="send_sms_personnaliser.php" class="btn btn-primary btn-block margin-bottom">Envoyer SMS</a>
              
               <?php	
			    }
			    ?>
                 <?php	if(get_access(26,$_SESSION['my_idprofile'])==1){ ?>
              
              <a href="bulk_sms.php" class="btn btn-primary btn-block margin-bottom">Envoyer SMS Bulk</a>
               <?php	
			    }
          ?>
          <?php	if(get_access(30,$_SESSION['my_idprofile'])==1){ ?>
              
              <a href="bulk_mail.php" class="btn btn-primary btn-block margin-bottom">Envoyer Mail Bulk</a>
               <?php	
			    }
			    ?>
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Dossier</h3>
                  <div class="box-tools">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                   
                      <?php	if(get_access(16,$_SESSION['my_idprofile'])==1){ ?>
                    <li class="<?php	echo ($get_active_submenu=="out") ? "active" : "" ;?>"><a href="bulk_in.php"><i class="fa  fa-send-o"></i> Boite d'Envoie <small class="label pull-right bg-green">Out</small></a></li>
                    <?php	
			    }
			    ?>
                     
                 <?php	if(get_access(17,$_SESSION['my_idprofile'])==1){ ?>
                    <li class="<?php	echo ($get_active_submenu=="broad") ? "active" : "" ;?>"><a href="bulk_msisdn.php"><i class="fa fa-database"></i>Numéros Broadcast</a></li>
                    <?php	
			    }
			    ?>
                     
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
              
            </div><!-- /.col -->