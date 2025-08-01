<?php
	//******************IDPAGE*****************
	$idpage=57;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	
	
	//****************location******************
	$get_active_menu="procedure";
	$page_titre="Creation Procedure";
	$page_small_detail="Creation";
	$page_location="Creation Procedure";
	
	if(isset($_POST['submit']) && $_POST['name']!=''){
$name=clean_in_text($_POST['name']);
$description=clean_in_text($_POST['description']);

//echo $total;
$feedback=add_procedure($name,$description);

add_notification("t_procedure",0,"NA","Nom : ".$name." / Description : ".$description,$_SESSION['my_username'],"Creation Procedure");

        
if($feedback==1){

    $success="yes";
    $success_message="Procedure créée avec succès";

}else{

    $error="yes";
    $error_message="Une erreur a survenue lors de l'ajout de la procedure";

}
			
            

		}else{
			if(isset($_POST['submit']) && ($_POST['name']=='')){
							
			$error="yes";
			$error_message="Erreur! Procedure non créée, veuillez remplir le champ nom";
			
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
                <form class="form-horizontal" action="add_procedure.php"  method="post">
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
