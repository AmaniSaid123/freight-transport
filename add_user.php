<?php
	//******************IDPAGE*****************
	$idpage=7;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	function getcombo_profile(){
	include("param.php");
	$content="";
		$sql_query=$bdd->query("select name,idprofile from t_profile where idprofile<>1  order by name asc");

while($result=$sql_query->fetch()) 		
{
	
			
			$content=$content.'<option value="'.$result['idprofile'].'">'.$result['name'].'</option>';
			
			
			
	}
$content=$content;
return $content;	
	
	}
	//****************location******************
	$get_active_menu="user";
	$page_titre="Nouvel Utilsateur";
	$set_pluggin_selection_wise="yes";
	$page_small_detail="MikroFin";
	$page_location="Gestion des Utilisateurs > Nouvel Utilisateur";
	
$username="";
$firstname="";
$lastname="";
$status="";
$profile="";
$ref_index="";
$ref_role="";
$ref_student="";
$ref_professor="";
$ref_agence="";

$reporting="";
$email="";



if(isset($_POST['submit']) && $_POST['username']!='' ){
$username=clean_in_text($_POST['username']);
$firstname=clean_in_text($_POST['firstname']);
$lastname=clean_in_text($_POST['lastname']);
$status=$_POST['status'];
$profile=$_POST['profile'];
$ref_agence=$_POST['ref_agence'];


$email=clean_in_text($_POST['email']);
$reporting=$_POST['reporting'];
$url_initial='images/profile_user/defaultuser.jpg';

//$location=$_POST['location'];

		if(isset($_FILES['photo']) && $_FILES['photo']['name']!=''){
			
			$url_initial='images/profile_user/'.date('Ymd')."-".$username."-".$_FILES['photo']['name'];
			$download_file=move_uploaded_file($_FILES['photo']['tmp_name'],$url_initial);
			$url_initial=($download_file==1) ? $url_initial : "images/profile_user/defaultuser.jpg";
							
		
		}


	$sql_query="insert into t_user(username,password,creationdate,lastupdate,ref_profile,status,reporting,email,ref_user,firstname,lastname,url_picture,ref_agence) values('".$username."','".$username.date('md')."',now(),now(),".$profile.",'".$status."','".$reporting."','".$email."','".$_SESSION['my_username']."','".$firstname."','".$lastname."','".$url_initial."',".$ref_agence.")";
	//echo $sql_query;
	$result_query=$bdd->exec($sql_query);
	
	if($result_query==1){
		
		add_notification("t_user",0,"NA","Login : ".$username." / Profile : ".$profile." / Email : ".$email." / Fisrtname : ".$firstname." / Lastname : ".$lastname." / Url picture : ".$url_initial." / ref_agence ".$ref_agence,$_SESSION['my_username'],"Ajout Utilisateur");
		
			$success="yes";
			$success_message="Utilisateur ".$firstname." ".$lastname." crée avec succès";
		
		}else{
			
			add_notification("t_user",0,"NA","Username : ".$username." / Reporting : ".$reporting." / Email : ".$email." / Fisrtname : ".$firstname." / Lastname : ".$lastname." / Url picture : ".$url_initial." / ref_agence ".$ref_agence,$_SESSION['my_username'],"Ajout Utilisateur - Erreur");			
			$error="yes";
			$error_message="Erreur survenu lors de la creation d'Utilisateur";
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
                <form class="form-horizontal" action="add_user.php"  method="post" enctype="multipart/form-data">
                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Login</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="username"  placeholder="Login" <?php  echo $pattern_text_only; ?>>
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Prenom</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="firstname"  placeholder="Prenom de l'utilisateur">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Nom</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="lastname"  placeholder="Nom de l'utilisateur">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="email"  placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Photo</label>
                      <div class="col-sm-10">
                        <input type="file" id="exampleInputFile" name="photo">
                        <p class="help-block">Veuillez choisir un photo si nécessaire de bonne qualité</p>
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
                      <div class="col-sm-5">
                       
                      <select class="form-control" name="status">
                        <option value="a" <?php echo ($status=='a') ? 'selected' : ''; ?>>Actif</option>
    					<option value="b" <?php echo ($status=='b') ? 'selected' : ''; ?>>Bloqué</option>

                      </select>
                      </div>
                    </div>
                     <div class="form-group">
                      <label class="col-sm-2 control-label">Rapport par mail ?</label>
                      <div class="col-sm-5">
                       
                      <select class="form-control" name="reporting">
                        <option value="non" <?php echo ($reporting=='non') ? 'selected' : ''; ?>>Non</option>
    					<option value="oui" <?php echo ($reporting=='oui') ? 'selected' : ''; ?>>Oui, Tous</option>
                        
                      </select>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="reset" class="btn btn-default" >Annuler</button>
                    <button type="submit"  class="btn btn-info pull-right" name="submit">Valider</button>
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
