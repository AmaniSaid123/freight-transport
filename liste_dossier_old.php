<?php
	//******************IDPAGE*****************
	$idpage=9;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	
	//*********************Get Profile Data*****
$set_pluggin_datatable="yes";	
$set_pluggin_selection_wise="yes";

//***********************Find Profile****************
//*************************Selection des informations du profile************************

$get_active_menu="dossier";
	$page_titre="Liste des Dossiers";
	$page_small_detail="MyPASS";
	$page_location="Gestion Dossiers > Liste des Dossiers";

$active_export="no";
//****************location******************
	
	
$nid="";
$identite="";
$ndel="";
$destination="";
$statut_dossier="";
$ref_agence="";
$param_query=" where deletion_statut=0  order by idt_dossier desc limit 0,500";
if(isset($_GET["del"])  && get_access(28,$_SESSION['my_idprofile'])==1){
    $idt_dossier= clean_in_integer($_GET["del"]);
    $data_dossier_temp = get_dossier_data($idt_dossier);
    $feedback_deletion=delete_dossier($idt_dossier);
    
   if ($feedback_deletion == 1) {

    $add_request_info = add_action_info($data_dossier_temp['idt_dossier'], 29, "", "", "", "", "Valide", $_SESSION['my_username'], "Oui", "Suppression Dossier ", 0, 0);
        //$data_dossier_temp = get_dossier_data($edit);
        $success = "yes";
        $success_message = "Le dossier a été supprimé avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur de la suppression du dossier";
    }
    
    
    
}

if(isset($_POST["submit"])){
	

$identite=clean_in_text($_POST['identite']);
$ndel=clean_in_text($_POST['ndel']);
$destination=$_POST['destination'];
$statut_dossier=$_POST['statut_dossier'];
$ref_agence=$_POST['ref_agence'];
   
$param_query=" where deletion_statut=0 ";



	
	
	if($identite!=""){
		
		$param_query=$param_query." and t.identite like '%".$identite."%' ";
		
				}	
	
	if($ndel!=""){
		
		$param_query=$param_query." and t.ndel like '".$ndel."%' ";
		
		}
	
		if($destination!=""){
		
		$param_query=$param_query." and t.vo_destination='".$destination."' ";
		
		}
		
		if($statut_dossier!=""){
		
		$param_query=$param_query." and t.statut_dossier='".$statut_dossier."' ";
		
		}
                
                if($ref_agence!=""){
		
		$param_query=$param_query." and t.ref_agence=".$ref_agence." ";
		
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
 <form class="form-horizontal" action="liste_dossier.php"  method="post">
 	<div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">Criteres` de recherche</h3>
                  <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                

              </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Identite</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="identite"  placeholder="Identité" value="<?php echo $identite; ?>">
                        
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">NID</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="ndel"  placeholder="Votre NID" value="<?php echo $ndel; ?>">
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Statut Dossier</label>
                      <div class="col-sm-4">
                        <select name="statut_dossier" class="form-control select2">
                        <option value="" <?php echo ($statut_dossier=='') ? 'selected' : ''; ?>>Tous les statuts</option>                        
                        <?php echo getcombo_statut_dossier($statut_dossier); ?>
                      </select>
                        
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-2 control-label">Destination</label>
                      <div class="col-sm-4">
                        <select name="destination" class="form-control select2">
                        <option value="" <?php echo ($destination=='') ? 'selected' : 'selected'; ?>>Toutes les Destinations</option>                        
                        <?php echo get_combo_liste_pays_toutes($destination); ?>
                      </select>
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Agence en Charge</label>
                      <div class="col-sm-4">
                        <select name="ref_agence" class="form-control select2">
                            <option value="" <?php echo ($ref_agence=='') ? 'selected' : ''; ?>>Toutes les agences</option> 
                        <?php  echo getcombo_agence($ref_agence); ?>
                      </select>
                        
                      </div>
                    </div>
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
					<i class="fa  fa-warning"> Ce rapport a une limitation d'affichage de 2000 lignes </i>
                    <button type="submit"  class="btn btn-info pull-right" name="submit" >Trouver</button>
                  </div><!-- /.box-footer -->
                
              </div><!-- /.box -->
                
          </form>    
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Mode Liste</h3>
                  <?php //echo ($active_export=="yes") ? '<a class="btn btn-success pull-right" href="fichier/ExportFileListeMembre_'.$_SESSION['mi_username'].'.csv" target="_new"><i class="fa  fa-file-excel-o fa-download"> Exporter en CSV </i> <i class="fa fa-download"></i></a>' : ''; ?>
                  <button onclick="exportTableToCSV('ExportFileListeDossier.csv')" class="btn btn-info pull-right" ><i class="fa  fa-file-excel-o fa-download"> Exporter en CSV </i> <i class="fa fa-download"></i></button>
                </div><!-- /.box-header -->
                <div class="box-body" style="overflow-y: scroll;">
                
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      <th>#</th>                      
                      <th>Date creation</th>
                      <th>Identité</th>
                      <th>NID</th>
                      <th>Garant</th>
                      <th>Date naissance</th>                      
                      <th>Destination</th>
                      <th>Raison Voyage</th>
                      <th>Telephone</th>
                      <th>Email</th>
                      <th>Agence</th>
                      <th>Statut</th>
                      <th>Actions</th>
                      
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
		$sql_select1 = 'select t.* , t_agence.label as agence from t_dossier t join t_agence on ref_agence=id_agence '.$param_query." ";
		$sql_result1 = $bdd->query($sql_select1);
		//echo $sql_select1;
		
  $index=0;

		  while($data1 = $sql_result1->fetch()){
		  $index++;		  
		  
		  		
		  	?>	
                      <tr>
                      <td><?php	echo $index;?></td>  
                      <td><?php	echo $data1['creationdate'];?></td>  
                      <td><?php	echo $data1['identite'];?></td>  
                      <td><?php	echo $data1['ndel'];?></td>               
                      <td><?php	echo $data1['pc_qualite_garant'];?></td>
                      <td><?php	echo $data1['date_naissance'];?></td>                      
                      <td><?php	echo $data1['vo_destination'];?></td>
                      <td><?php	echo $data1['vo_raison_voyage'];?></td>
                      <td><?php	echo $data1['numero_telephone'];?></td>
                      <td><?php	echo $data1['email'];?></td>
                      <td><?php	echo $data1['agence'];?></td>
                      <td><?php	echo $data1['statut_dossier'];?></td>
                      <td>
                      <?php 
	
						if(get_access(10,$_SESSION['my_idprofile'])==1){
	
	 ?>
                           <a href="vue_dossier.php?find=<?php echo $data1['idt_dossier']; ?>" ><i class="fa fa-fw fa-television"></i> </a>
                           
                           <?php 
	
		}
	?>	
                    <?php 
	
						if(get_access(28,$_SESSION['my_idprofile'])==1){
	
	 ?>
                           <a href="liste_dossier.php?del=<?php echo $data1['idt_dossier']; ?>" ><i class="fa fa-fw  fa-cut" onClick="return confirm('Cette action va supprimer le dossier, Veuillez confirmer?')"></i> </a>
                           
                           <?php 
	
		}
	?>	
                         </td>                 
                 </tr>
                  <?php 
	
		  }
	
	 			?> 
   
                    </tbody>
                    
                  </table>
                </div><!-- /.box-body -->
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

    <?php
		    include_once("php/importation_js.php");
			//include_once("php/export_to_csv_js.php");

        	?>
  </body>
</html>
