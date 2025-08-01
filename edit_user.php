<?php
	//******************IDPAGE*****************
	$idpage=8;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
		
	
	function getcombo_profile($idprofile){
	include("php/param.php");
	$content="";
		$sql_query=$bdd->query("select name,idprofile from t_profile  order by name asc");

while($result=$sql_query->fetch()) 		
{
	
			if($result['idprofile']==$idprofile){
				
				$content=$content.'<option value="'.$result['idprofile'].'" selected>'.$result['name'].'</option>';
				
				}else{
					
				$content=$content.'<option value="'.$result['idprofile'].'" >'.$result['name'].'</option>';	
					}
				

			
			
			
	}
$content=$content;
return $content;	
	
	}
	//************************************************************************
	//****************location******************
	$get_active_menu="user";
	$page_titre="Edition Utilsateur";
	$page_small_detail="MyPASS";
	$page_location="Gestion des Utilisateurs > Edition Utilisateur ".'  <a href="list_user.php?close=ok"><i class="fa  fa-close"></i></a>';
	
$username="";
$firstname="";
$lastname="";
$status="";
$profile="";

$ref_agence=0;
$is_agent="";
$ref_code_membre="";
$ref_compte=""; 
$ref_compte_eav_salaire="";
$task="";

$reporting="";
$email="";
$backup="";
$url_charge="";
$data_user="";
    //*********************Chargement des Données******************************
if(isset($_GET['find'])){
	
		$edit=clean_in_integer($_GET['find']) ;

		$data_user=get_user_data($edit);
//					echo $edit;
		if($data_user['is_exist']==1){
			$backup=" Prenom : ".$data_user['firstname']." / Nom : ".$data_user['lastname']." / Status : ".$data_user['status']." / Profile : ".$data_user['ref_profile']." / Reporting : ".$data_user['reporting']." / Email : ".$data_user['email'];
		    $_SESSION['my_m_user']=$edit;

			$username=$data_user['username'];
			$firstname=$data_user['firstname'];
			$lastname=$data_user['lastname'];
			$status=$data_user['status'];
			$profile=$data_user['ref_profile'];
			$task=$data_user['task_list'];

			$is_agent=($data_user['ref_profile']==2 ? '1' : '0');
			$ref_agence=$data_user['ref_agence'];
					

			$reporting=$data_user['reporting'];
			$email=$data_user['email'];
			$url_charge=$data_user['url_picture'];
        	//$_SESSION['m_profile']=$edit;
			}else{
				
			// header("Location: home.php?error=ok&msg=Ce Profile n'existe pas, vous n'etes pas autorise à la page suivante");				
		
	}	
}

if($_SESSION['my_m_user']!="NA"){
	
						  $edit=$_SESSION['my_m_user'] ;

						  $data_user=get_user_data($edit);
						  if($data_user['is_exist']==1 && ($data_user['ref_profile']>=$_SESSION['my_idprofile'])){
							  $backup=" Prenom : ".$data_user['firstname']." / Nom : ".$data_user['lastname']." / Status : ".$data_user['status']." / Profile : ".$data_user['ref_profile']." / Reporting : ".$data_user['reporting']." / Email : ".$data_user['email'];
							 // $_SESSION['m_profile']=$edit;
							  $username=$data_user['username'];
							  $firstname=$data_user['firstname'];
							  $lastname=$data_user['lastname'];
							  $status=$data_user['status'];
							  $profile=$data_user['ref_profile'];
                $task=$data_user['task_list'];
							$is_agent=($data_user['ref_profile']==2 ? '1' : '0');
								$ref_agence=$data_user['ref_agence'];
								
							  					
								
					     	  $reporting=$data_user['reporting'];
							  $email=$data_user['email'];
							  $url_charge=$data_user['url_picture'];
							  }else{
								  
							  
							  header("Location: home.php?error=ok&msg=Ce Profile n'existe pas, vous n'etes pas autorise à la page suivante");
								  
								  }
		
	}
				
//*************************************Reset Password****************************************
if(isset($_POST['reset_password'])){
	$new_password=reset_password($_POST['username']);
	
	add_notification("t_user",0,"","username : ".$_POST['username'],$_SESSION['my_username'],"Reset Password");
	$success="yes";
			$success_message="Mot de Passe reinitialisé avec succès : ".$new_password;
	
	}				


if(isset($_POST['submit']) && isset($_POST['username']) && $_POST['username']!='' ){
$username=clean_in_text($_POST['username']);
$firstname=clean_in_text($_POST['firstname']);
$lastname=clean_in_text($_POST['lastname']);
$status=$_POST['status'];
$profile=$_POST['profile'];
$email=$_POST['email'];
$task=clean_in_text($_POST['task']);

$is_agent=$data_user['is_agent'];
$ref_agence=$_POST['ref_agence'];

$reporting=$_POST['reporting'];
$url_initial=$_POST['url_charge'];

$param_photo="";

//$location=$_POST['location'];
$download_file=0;
		if(isset($_FILES['photo']) && $_FILES['photo']['name']!='' && $_POST['change_photo']=='on'){
			
			$url_initial='images/profile_user/'.date('Ymd')."-".$username."-".$_FILES['photo']['name'];
			$download_file=move_uploaded_file($_FILES['photo']['tmp_name'],$url_initial);
			$url_initial=($download_file==1) ? $url_initial : "images/profile_user/defaultuser.jpg";
							
		
		}else{
      $download_file=1;

    }


	$sql_query="update t_user set task_list='".$task."', ref_profile=".$profile.",status='".$status."',reporting='".$reporting."',email='".$email."',ref_user='".$_SESSION['my_username']."',firstname='".$firstname."',lastname='".$lastname."',url_picture='".$url_initial."', ref_agence=".$ref_agence."  where username='".$username."'";
	//echo $sql_query;
	$result_query=$bdd->exec($sql_query);
	
	if($download_file==1){
		
                $result_query=$bdd->exec($sql_query);
		add_notification("t_user",0,"NA","Username : ".$username." / Profile : ".$profile." / Reporting : ".$reporting." / Email : ".$email." / Fisrtname : ".$firstname." / Lastname : ".$lastname." / Url picture : ".$url_initial." / ",$_SESSION['my_username'],"Editer Utilisateur");
		
			$success="yes";
			$success_message="Utilisateur ".$firstname." ".$lastname." edité avec succès";
		
		}else{
						
			$error="yes";
			$error_message="Erreur survenu lors de la modification d'Utilisateur";
			}
	
	
	}else{
		
		if(isset($_POST['submit']) && ($_POST['username']=='' || ($_POST['email']!='' && $_POST['firstname']!='' && $_POST['lastname']!='' ))){
			
			$error="yes";
			$error_message="Veuillez remplir les champs obligatoire avant de valider";
			
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
                <form class="form-horizontal" action="edit_user.php"  method="post" enctype="multipart/form-data">
                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Login</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="username"  placeholder="Login" readonly value="<?php  echo $username; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Prenom</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="firstname"  placeholder="Prenom de l'utilisateur"  value="<?php  echo $firstname; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Nom</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="lastname"  placeholder="Nom de l'utilisateur"  value="<?php  echo $lastname; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="email"  placeholder="Email"  value="<?php  echo $email; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                    <input name="url_charge" type="hidden" value="<?php	echo $url_charge; ?>">
                      <label  class="col-sm-2 control-label">Photo</label>
                      <div class="col-sm-10">
                      <img src="<?php	echo $url_charge; ?>" width="50" class="img-circle" alt="User Image">
                        Modifier photo <input name="change_photo" type="checkbox" value="on">
                        <input type="file" id="exampleInputFile" name="photo">
                        <p class="help-block">Veuillez choisir un photo si vous voulez changer de photo</p>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Profile</label>
                      <div class="col-sm-10">
                       
                      <select class="form-control" name="profile">
                        <?php echo getcombo_profile($profile); ?>
                      </select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Agence</label>
                      <div class="col-sm-10">
                       
                      <select class="form-control" name="ref_agence">
                        <?php echo getcombo_agence($ref_agence); ?>
                      </select>
                      </div>
                    </div>
                     <div class="form-group">
                      <label class="col-sm-2 control-label">Statut</label>
                      <div class="col-sm-10">
                       
                      <select class="form-control" name="status">
                        <option value="a" <?php echo ($status=='a') ? 'selected' : ''; ?>>Actif</option>
    					<option value="b" <?php echo ($status=='b') ? 'selected' : ''; ?>>Bloqué</option>

                      </select>
                      </div>
                    </div>
                     <div class="form-group">
                      <label class="col-sm-2 control-label">Rapport par mail ?</label>
                      <div class="col-sm-10">
                       
                      <select class="form-control" name="reporting">
                        <option value="non" <?php echo ($reporting=='non') ? 'selected' : ''; ?>>Non</option>
    					<option value="oui" <?php echo ($reporting=='oui') ? 'selected' : ''; ?>>Oui, Tous</option>
                        
                      </select>
                      </div>
                    </div>
                    <div class="box-body" >
          
        <label  class="col-sm-2 control-label">Tappez la liste des taches a faire : </label>
        <div class="col-sm-10">
        <textarea class="textarea" name="task"   id="zone" placeholder="Ecrivez ICi" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $task; ?></textarea><br>
        </div>
        
      </div><!-- /.row -->
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="reset" class="btn btn-default" >Annuler</button>
                    <button type="submit"  class="btn btn-info pull-right" name="submit">Valider</button>
                    <button type="submit"  class="btn btn-block" name="reset_password"><i class="fa fa-refresh"></i><i class="fa fa-user-secret"></i>Reinitialiser Mot de Passe de l'utilisateur</button>
                    
                  </div><!-- /.box-footer -->
                </form>
              </div>
              
              
              <!-- /.box -->
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
