<?php
	//******************IDPAGE*****************
	
	//Session check****************************
        // On d&eacute;truit les variables de notre session   
session_start (); 
if (isset($_SESSION['my_doc_online'])){
        session_unset ();   

        // On d&eacute;truit notre session   
        session_destroy ();  
}
         
	
	
	//****************location******************
	
	$page_titre="MyPASS";
	$page_small_detail="Version 1.0";
	$page_location="ACCES AU DOSSIER";
        $get_active_menu="dossier_online";
	
$success="yes";
$success_message="Bienvenu à vous, connectez vous pour voir l'evolution de votre dossier";
$error="no";
$warning="no";
$success="no";
$information="no";

$error_message="Error on the page Errorcode=xx001Defaults";
$warning_message="This is a warning";
$success_message="Your request succeed";
$information_message="Welcome in MyPASS";	

	if(isset($_GET['try']) and $_GET['try']=='ok'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Mot de Passe ou nom d\'utilisateur incorrect");';
			echo "</SCRIPT>";
			
			}
	
	if(isset($_GET['error']) and $_GET['error']=='login'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Veuillez vous reconnecter d\'abord");';
			echo "</SCRIPT>";
			
			}
			
	if(isset($_GET['error']) and $_GET['error']=='inactivity'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Votre Session a pris fin pour non utilisation au dela de 30 minutes");';
			echo "</SCRIPT>";
			
			}
if(isset($_GET['error']) and $_GET['error']=='autorisation'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Votre profile n\' a pas le droit d\'acceder a cette page, Reconnectez-vous!");';
			echo "</SCRIPT>";
			
			}

if(isset($_GET['error']) and $_GET['error']=='acces_caisse'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Désolé vous devez avoir un accès caisse pour acceder à cette page, Reconnectez-vous!");';
			echo "</SCRIPT>";
			
			}						
	
	
	
	
	
	?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
    <?php
		include_once("php/header_online.php");

	?>
    <?php	?>
          <!-- Sidebar Menu -->
    <?php
		include_once("php/main_menu_online.php");

	?>
         
         <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <?php
		    include_once("php/titre_location.php");

        	?>
        </section>

        <!-- Main content -->
        <section class="content">
<?php  include_once("php/print_message.php"); ?>
          <!-- Your Page Content Here -->
<div id="light" class="white_content">
    <a onClick="hide_pop()" class="btn-danger"><i class="fa  fa-close">Fermer Ici</i></a>
   
     </div>
    <div id="fade" class="black_overlay"></div>      
 <a href="https://passportsarl.voyage" target="_blank"><img  src="images/logo_passport.png" width="212" height="171" /></a>    
    <form method="post" action="authentification_online.php">
    <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Connexion au Dossier</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">NID</label>
                      <div class="col-sm-10">
                          <input type="text" name ="nid_client" class="form-control" placeholder="Tappez votre code NID" value="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">PIN SECRET</label>
                      <div class="col-sm-10">
                          <input type="password" name ="pin_secret" class="form-control" value="">
                      </div>
                    </div>
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    
                    <button type="submit" class="btn btn-info pull-right" name="btn_valider">Accéder au dossier</button>
                  </div><!-- /.box-footer -->
                
              </div><!-- /.box -->

              </form>
              
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <?php
		    include_once("php/footer.php");

        	?>
      </footer>

      <!-- Control Sidebar -->
     
        
      <!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
<?php
		    include_once("php/importation_js.php");

        	?>
  </body>
</html>
