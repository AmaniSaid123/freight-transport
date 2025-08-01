<?php
	//******************IDPAGE*****************
	$idpage=1;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	function get_pwd($login_entre){
include("param.php");
$valeur="";
$sql_select = "select password from t_user where username='".$login_entre."'";
$sql_result = $bdd->query($sql_select);
$valeur=$sql_result->fetch();

return $valeur['password'];
}
function changer_mdp($login_change,$old_mdp,$mdp1,$mdp2){

include("param.php");
$valeur="";
$sql_select = "update t_user set password='".$mdp1."' where username='".$login_change."'";
$sql_result = $bdd->exec($sql_select);
return $sql_result;
}
	
	//****************location******************
	$get_active_menu="";
	$set_pluggin_selection_wise="yes";
	
	$set_plugin_daterange="yes";
	$page_titre="Mon Compte";
	$page_small_detail="Changer Mot de passe";
	$page_location="Mon Compte > Changer Mot de passe";

if(isset($_POST['save'])){

		if($_POST['old_pwd']==get_pwd($_POST['login_change'])){
		
				if($_POST['new_pwd1']==$_POST['new_pwd2']){
				
					changer_mdp($_POST['login_change'],$_POST['old_pwd'],$_POST['new_pwd1'],$_POST['new_pwd2']);

add_notification("t_user",0," Old pwd lenght = ".strlen($_POST['old_pwd'])," New pwd lenght = ".strlen($_POST['new_pwd2']),$_SESSION['my_username'],"Change password");

					
					$success="yes";
					$success_message="Mot de passechangé avec succès";
				
				}else
				{
				
				$error="yes";
		     	$error_message="Désolé, le mot de passe ne correspond pas";
				}
		}else{
		
		
				$error="yes";
		     	$error_message="Mot de passe incorrect";
		}



}
	
	
	?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
    <?php
		include_once("php/header.php");

	?>
    <?php	?>
          <!-- Sidebar Menu -->
    <?php
		include_once("php/main_menu.php");

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
 <!-- Horizontal Form -->
 <div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">Mode Creation</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="reset_password.php"  method="post">
                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Login</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="login_change"  value="<?php echo $_SESSION['my_username']; ?>" readonly>
                      </div>
                    </div>
                    
                     <div class="form-group">
                      <label  class="col-sm-4 control-label">Mot de passe actuel</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" name="old_pwd"  placeholder="Entrez votre mot de passe actuel">
                      </div>
                    </div>
                    
                     <div class="form-group">
                      <label  class="col-sm-4 control-label">Nouveau Mot de passe</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" name="new_pwd1"  placeholder="Entrez votre nouveau mot de passe">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Re-saisissez le Mot de passe</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" name="new_pwd2"  placeholder="Saisissez encore le mot de passe ci-dessus">
                      </div>
                    </div>
                    
                    
                                      
                    
                   
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="reset" class="btn btn-default" >Annuler</button>
                    <button type="submit"  class="btn btn-info pull-right" name="save">Valider</button>
                  </div><!-- /.box-footer -->
                </form>
              </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <?php
		    include_once("php/footer.php");

        	?>
      </footer>

      <!-- Control Sidebar -->
     
        <?php
		    include_once("php/tableau_controle.php");

        	?>
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
