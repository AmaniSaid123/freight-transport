<?php
	//******************IDPAGE*****************
	$idpage=35;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	//****************location******************
	$get_active_menu="comptabilite";
	$page_titre="Nouvelle Ecriture";
	$set_pluggin_selection_wise="yes";
	$page_small_detail="MyPASS";
	$page_location="Comptabilite > Nouvelle ecriture automatique";
	
$ref_type_compte="";
$ref_compte="";
$action="";
$ref_operation="";



if(isset($_POST['submit'])){


$ref_compte=$_POST['ref_compte'];
$action=$_POST['action'];
$ref_operation=$_POST['ref_operation'];


//$location=$_POST['location'];

	$feedback=add_ecriture($ref_compte,$action,$ref_operation);
	//echo $sql_query;
	
	if($feedback==1){
		
		add_notification("t_comptabilite",0,"NA","ref_type_compte : ".$ref_type_compte." / Action : ".$action,$_SESSION['my_username'],"Ajout Ecriture");
		
			$success="yes";
			$success_message="Ecriture ajouté avec succès : Compte --> ".$ref_compte." | Action : ".$action ;
		
		}else{
			add_notification("t_comptabilite",0,"NA","ref_type_compte : ".$ref_type_compte." / Action : ".$action,$_SESSION['my_username'],"Ajout Ecriture - Erreur");			
			$error="yes";
			$error_message="Erreur survenu lors de l'ajout de l'ecriture comptable, il se peut que l'ecriture soit double";
			}
	
	
	}else{
		
	
		
		
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
                <form  onsubmit="ShowLoading()" class="form-horizontal" action="add_ecriture_auto.php"  method="post">
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Compte</label>
                      <div class="col-sm-10">
                       
                      <select class="form-control  select2" name="ref_compte" >
                        <?php echo getcombo_compte($ref_compte); ?>
                      </select>
                      </div>
                    </div>
                    
                     <div class="form-group">
                      <label class="col-sm-2 control-label">Action</label>
                      <div class="col-sm-5">
                       
                      <select class="form-control" name="action">
                        <option value="C" <?php echo ($action=='C') ? 'selected' : ''; ?>>Créditer</option>
    					<option value="D" <?php echo ($action=='D') ? 'selected' : ''; ?>>Debiter</option>

                      </select>
                      </div>
                    </div>
                     
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Opération</label>
                      <div class="col-sm-10">
                       
                      <select class="form-control select2" name="ref_operation">
                        <?php echo getcombo_operation_paiement($ref_operation); ?>
                      </select>
                      </div>
                    </div>
                  </div><!-- /.box-body --> 
                  <div class="box-footer">

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
