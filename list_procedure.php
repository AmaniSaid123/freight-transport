<?php
	//******************IDPAGE*****************
	$idpage=57;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//****************location******************
	$get_active_menu="procedure";
	$page_titre="Liste de Procedures ";
	$page_small_detail="des controle";
	$page_location="Gestion des Procedure > Liste de Procedures de controle";
	

	
if(isset($_GET['del'])){
	$_GET['del']=clean_in_integer($_GET['del']);
	//echo "delete from t_profile where idprofile=".$_GET['del'];
	$utilisateur_affecte=get_total_user_profile($_GET['del']);
	if($utilisateur_affecte==0){
		
		$data_profile_deleted=get_profile_data($_GET['del']);
		
		$sql_query3=$bdd->exec("delete from t_profile where idprofile=".$_GET['del']);
		if($sql_query3==1){
			
			add_notification("t_profile",0,"NA","Nom : ".$data_profile_deleted['name']." Description : ".$data_profile_deleted['description'],$_SESSION['my_username'],"Suppression Profile : ".$data_profile_deleted['name'])." avec 0 utilisateurs";
			$success="yes";
			$success_message="Le Profile ".$data_profile_deleted['name']." supprimé avec succès! Nombre d'utilsateur affecté = 0";
		
			
			}
		
		}else{
				
			$error="yes";
			$error_message="Vous ne pouvez pas supprimer ce profile car cela affectera des utilisateurs (".$utilisateur_affecte.")";
				
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
		<!-- Main content -->
        <?php  include_once("php/print_message.php"); ?>
           <div class="box" style="overflow-y: scroll;">
                <div class="box-header">
                  <h3 class="box-title">Mode lecture</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                
                  <table class="table table-condensed">
                    <tr>
                      <th style="width: 10px"></th>
                      <th>Procedure</th>
                     
                      <th>Description</th>
                      <th>Crée le</th>
                      <th>Auteur</th>                      
                      
                    </tr>
                     <?php 
		$sql_select1 = "select * from t_procedure ";
		$sql_result1 = $bdd -> query($sql_select1);
		$total_agent=get_total_user();
  $index=0;
		  while($data1 = $sql_result1 -> fetch()){
		  $index++;
		  	?>	
                    <tr>
                      <td><?php	echo $index;?></td>
                      <td><?php	echo $data1['nom_procedure'];?></td>
                      
                      <td><?php	echo $data1['description'];?></td>
                      <td><?php	echo $data1['creationdate'];?></td>                      
                      <td><?php	echo $data1['ref_user'];?></td>  
                                          
                      <?php 
	
						if(get_access(57,$_SESSION['my_idprofile'])==1){
	
	 ?>
                           <td><a href="edit_procedure.php?find=<?php echo $data1['idt_procedure']; ?>" ><i class="fa fa-fw fa-pencil-square-o"></i> </a>
                           
                           <?php 
	
		}
	
	 
     if(get_access(57,$_SESSION['my_idprofile'])==1 && 0){
	?>
	 
                           <a href="list_profile.php?del=<?php echo $data1['idt_procedure']; ?>" onClick="return confirm('Cette action va supprimer cette procedure, Veuillez confirmer?')" ><i class="fa  fa-cut"></i> </a></td>

     <?php 
	
		}
	
	 ?>
                    </tr>
               <?php  
					}
				?>	    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            

      <!-- Main content -->
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
