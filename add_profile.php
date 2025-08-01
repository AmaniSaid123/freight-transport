<?php
	//******************IDPAGE*****************
	$idpage=5;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	function add_profile($nom, $description){
	include("param.php");
	
		$sql_search="insert into t_profile(name,description,creationdate,lastupdate,ref_user) values('".$nom."','".$description."',now(),now(),'".$_SESSION['my_username']."')";
			$sql_query=$bdd->exec($sql_search);
	

return $sql_query;	
	
	}
	
	//****************location******************
	$get_active_menu="profile";
	$page_titre="Nouveau Profile";
	$page_small_detail="Creation";
	$page_location="Nouveau Profile";
	
	if(isset($_POST['submit']) && $_POST['name']!=''){
$name=addslashes($_POST['name']);
$description=addslashes($_POST['description']);

//echo $total;
$feedback=add_profile($name,$description);

add_notification("t_profile",0,"NA","Nom : ".$name." / Description : ".$description,$_SESSION['my_username'],"Creation Profile");
$profile_code=get_idprofile($name);
$sql_select1="select idcontent,name from t_content t where t.default='y'";
$sql_query1=$bdd->query($sql_select1);
			while($data1= $sql_query1->fetch()){
				
									
		        add_profile_content($profile_code,$data1['idcontent']);
			
				add_notification("t_profile_content",0,"NA","Ref_profile : ".$profile_code." / ref_content =  : ".$data1['idcontent']." ".$name." le droit : ".$data1['idcontent'].", ID=".$data1['idcontent'],$_SESSION['my_username'],"Ajout au Profile");	
				
								
				}
		
			$success="yes";
			$success_message="Profile créé avec succès";
		}else{
			if(isset($_POST['submit']) && ($_POST['name']=='')){
							
			$error="yes";
			$error_message="Erreur! Profile non créé, veuillez remplir le champ nom";
			
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
                <form class="form-horizontal" action="add_profile.php"  method="post">
                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Nom du profile</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="name"  placeholder="identifiez le profile">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="description" placeholder="Descrivez le Ici ..."></textarea>
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
