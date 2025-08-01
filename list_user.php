<?php
	//******************IDPAGE*****************
	$idpage=6;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	
	//*********************Get Profile Data*****
$set_pluggin_datatable="yes";	

//***********************Find Profile****************
//*************************Selection des informations du profile************************

$get_active_menu="user";
	$page_titre="Liste des Utilisateurs ";
	$page_small_detail="du système";
	$page_location="Gestion des Utilisateurs > Liste des Utilisateurs";

//****************location******************
if(isset($_GET['close']) && $_GET['close']=="ok"){
	
	$_SESSION['mi_m_user']="NA";
	$success="yes";
    $success_message="Profile fermé avec succès";
	
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
<form class="form-horizontal" action="edit_profile.php"  method="post">
 
                <div class="row">
            <div class="col-xs-12">
              
              <div class="box" style="overflow-y: scroll;">
                <div class="box-header">
                  <h3 class="box-title">Mode Liste</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                                            
                      <th>Login</th>
                      <th>Nom</th>
                      <th>Prenom</th>
                      <th>Profile</th>
                      <th>Dernière Connexion</th>
                      <th>Créé par</th>
                      
                      <th style="width: 10px"></th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
		$sql_select1 = "select t.name as profile, idprofile,lastlogon, firstname, lastname, t_user.ref_user, iduser, username   from t_user  join t_profile t on ref_profile=idprofile where viewable=1  order by firstname";
		//echo $sql_select1;
		
		$sql_result1 = $bdd->query($sql_select1);
		
  $index=0;

		  while($data1 = $sql_result1->fetch()){
		  
		   
		  		
		  	?>	
                      <tr>
                      <td><?php	echo $data1['username'];?></td>                      
                      <td><?php	echo $data1['firstname'];?></td>
                      <td><?php	echo $data1['lastname'];?></td>
                      <td><?php	echo $data1['profile'];?></td>
                      <td><?php	echo $data1['lastlogon'];?></td>                      
                      <td><?php	echo $data1['ref_user'];?></td>  
                      
                                          
                      <?php 
	
						if(get_access(8,$_SESSION['my_idprofile'])==1){
	
	 ?>
                           <td><a href="edit_user.php?find=<?php echo $data1['iduser']; ?>" ><i class="fa fa-fw fa-pencil-square-o"></i> </a>
                           
                           <?php 
	
		}
	?>	
	 
     </td>

                 </tr>
                  <?php 
	
		  }
	
	 			?> 
   
                    </tbody>
                    <tfoot>
                      <th>Login</th>
                      <th>Nom</th>
                      <th>Prenom</th>
                      <th>Profile</th>
                      <th>Dernière Connexion</th>
                      <th>Créé par</th>
                      
                      <th style="width: 10px"></th>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                       
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
     
        <?php
		    include_once("php/tableau_controle.php");

        	?>
      <!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      
    </div><!-- ./wrapper -->

    <?php
		    include_once("php/importation_js.php");

        	?>
  </body>
</html>
