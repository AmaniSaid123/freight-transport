<?php
	//******************IDPAGE*****************
	$idpage=35;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	
	//*********************Get Profile Data*****
$set_pluggin_datatable="yes";	

//***********************Find Profile****************
//*************************Selection des informations du profile************************

$get_active_menu="comptabilite";
	$page_titre="Liste des Ecritures Auto";
	$page_small_detail="";
	$page_location="Comptabilité > Liste des Ecritures Auto";

//****************location******************

if(isset($_GET['del'])){
		$data_ecriture=get_ecriture_data(clean_in_integer($_GET['del']));
	$feedback=del_ecriture_auto(clean_in_integer($_GET['del']));

	if($feedback==1){
		
		$success="yes";
		$success_message="Ecriture automatique ".$_GET['del']." supprimée avec succès";
		add_notification("t_ecriture",0,"Operation : ".$data_ecriture['operation']." Compte : ".$data_ecriture['ref_compte']." | Action : ".$data_ecriture['action'],"Operation : ".$data_ecriture['operation']." Compte : ".$data_ecriture['ref_compte']." | Action : ".$data_ecriture['action'],$_SESSION['my_username'],"Suppression Ecriture");
		}else{
					$error="yes";
			$error_message="Erreur survenu lors de la suppression de l'ecriture automatique";
		
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
<form  onsubmit="ShowLoading()" class="form-horizontal" action="list_ecriture_auto.php"  method="post">
 
                <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Mode Liste</h3>
                  <button onclick="exportTableToCSV('ExportFileEcritureComptableAutom.csv')" class="btn btn-success pull-right" ><i class="fa  fa-file-excel-o fa-download"> Exporter en CSV </i> <i class="fa fa-download"></i></button>
                </div><!-- /.box-header -->
                <div class="box-body" style="overflow-y: scroll;">
                
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                                            
                      <th>Opération</th>
                      <th>Type Operation</th>
                      <th>Compte</th>
                      <th>Action</th>
                      <th>Date creation</th>
                      <th></th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
        $sql_select1 = 'select t_ecriture.idecriture, t_ecriture.action, t_ecriture.creationdate,
        t_operation.label as operation,concat(t_livre_compte.account_no," - ",t_livre_compte.label) as compte,ref_type_operation 
        from t_ecriture join t_operation on ref_operation = idt_operation 
join t_livre_compte on ref_compte = t_livre_compte.account_no where t_livre_compte.ref_agence='.$_SESSION['my_agence'];
		$sql_result1 = mysqli_query($bdd_i,$sql_select1);
		//echo $sql_select1;
  $index=0;

		  while($data1 = mysqli_fetch_array($sql_result1)){
		  
		  
		  		
		  	?>	
                      <tr>
                      <td><?php	echo $data1['operation'];?></td>                      
                      <td><?php	echo $data1['ref_type_operation'];?></td>
                      <td><?php	echo $data1['compte'];?></td>
                      <td><?php	echo $data1['action'];?></td>
                      <td><?php	echo $data1['creationdate'];?></td>                      

                         <td>                 
                      <?php 
	
						if(get_access(36,$_SESSION['my_idprofile'])==1){
	
	 ?>
                           <a href="list_ecriture_auto.php?del=<?php echo $data1['idecriture']; ?>" onClick="return confirm('Cette action va supprimer cette configuration critique, Veuillez confirmer?')" ><i class="fa fa-cut"></i> </a>
                           
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
                      <th>Opération</th>
                      <th>Type Operation</th>
                      <th>Compte</th>
                      <th>Action</th>
                      <th>Date creation</th>
                      <th></th>
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
