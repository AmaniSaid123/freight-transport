<?php
	//******************IDPAGE*****************
	$idpage=47;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	
	//*********************Get Profile Data*****
$set_pluggin_datatable="yes";	
$set_pluggin_selection_wise="yes";
$set_plugin_daterange = "yes";

//***********************Find Profile****************
//*************************Selection des informations du profile************************

$get_active_menu="avance";
	$page_titre="Journal des Operations financières";
	$page_small_detail="MyPASS";
	$page_location="Options Avancées > Journal des Operations financières";

$active_export="no";
//****************location******************
	
	
$nid="";
$keyword="";
$ndel="";
$agence="";
$utilisateur="";
$daterange=""; 

$param_query=" where 1 ";
if(isset($_POST["submit"])){
	

$keyword=clean_in_text($_POST['keyword']);
$ndel=clean_in_text($_POST['ndel']);
$agence=$_POST['agence'];
$utilisateur=$_POST['utilisateur'];
$daterange=$_POST['daterange'];
   
$param_query=" where 1 ";


if (isset($_POST['daterange']) && $_POST['daterange'] != "") {
    //echo "oooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee";
    $tempo = explode("-", $_POST['daterange']);
    $daterange = $_POST['daterange'];
    $date_debut = trim($tempo[0]);
    $date_fin = trim($tempo[1]);
    $param_query = " where t.creationdate between '" . $date_debut . " 00:00:00' and  '" . $date_fin . " 23:59:59' ";
   
}
	
	
	if($keyword!=""){
		
		$param_query=$param_query." and sup_detail like '%".$keyword."%' ";
		
				}	
	
	if($ndel!=""){
		
		$param_query=$param_query." and ndel like '".$ndel."%' ";
		
		}
	
		if($agence!=""){
		
		$param_query=$param_query." and ref_agence_action=".$agence." ";
		
		}
		
		if($utilisateur!=""){
		
		$param_query=$param_query." and t.ref_user='".$utilisateur."' ";
		
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
 <form class="form-horizontal" action="journal_ops_fin.php"  method="post">
 	<div class="box box-info" style="overflow-y: scroll;">
  <div class="box-header with-border">
                  <h3 class="box-title">Criteres` de recherche</h3>
                  <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                

              </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Mot clés</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="keyword"  placeholder="Identité" value="<?php echo $keyword; ?>">
                        
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">NID</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="ndel"  placeholder="Votre NID" value="<?php echo $ndel; ?>">
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Utilisateur</label>
                      <div class="col-sm-4">
                        <select name="utilisateur" class="form-control select2">
                        <option value="" <?php echo ($utilisateur=='') ? 'selected' : ''; ?>>Tous les utilisateurs</option>                        
                        <?php echo  getcombo_username($utilisateur); ?>
                      </select>
                        
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-2 control-label">Agence</label>
                      <div class="col-sm-4">
                        <select name="agence" class="form-control">
                        <option value="" <?php echo ($agence=='') ? 'selected' : 'selected'; ?>>Toutes les Agences</option>                        
                        <?php echo getcombo_agence($agence); ?>
                      </select>
                        
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Période ciblée</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control pull-right" id="date1" name="daterange" value="<?php echo $daterange; ?>" placeholder="Specifiez une date">

                        </div>
                    </div>
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
					<i class="fa  fa-warning"> Ce rapport a une limitation d'affichage de 2000 lignes </i>
                    <button type="submit"  class="btn btn-info pull-right" name="submit" >Trouver</button>
                  </div><!-- /.box-footer -->
                
              </div><!-- /.box -->
                
          </form>    
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Mode Liste</h3>
                  <button onclick="exportTableToCSV('ExportFileJournalOPSFin.csv')" class="btn btn-success pull-right" ><i class="fa  fa-file-excel-o fa-download"> Exporter en CSV </i> <i class="fa fa-download"></i></button>
									
                </div><!-- /.box-header -->
                <div class="box-body" style="overflow-y: scroll;">
                
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                                            
                      <th>#</th>
                      <th>Date</th>
                      <th>Agence</th>
                      <th>Client</th>
                      <th>NID</th>
                      <th>Statut</th>
                      <th>Nature</th>
                      <th>Montant</th>
                      <th>Devise</th>
                      <th>Initiateur</th>
                      <th>Libelle</th>
                      <th>Operation</th>
                      
                      <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
		                        $sql_select1 = "SELECT t.*,w.*, t.creationdate as date_to_use, t.ref_user as user_acting,
                                t_operation.label as operation, t_agence.label as agence, w.deletion_statut 
                                FROM passport_bd.t_transactions t join t_operation on ref_operation=idt_operation
                            left join t_dossier w on ndel=t.ref_dossier  join t_agence on ref_agence_action=id_agence " . $param_query . " order by idtransactions desc limit 0,20000";
                            //echo $sql_select1;
		
		$sql_result1 = $bdd->query($sql_select1);
		
  $index=0;

		  while($data1 = $sql_result1->fetch()){
            $index++;
            $type_account="";
        if($data1['type_account']=='OP'){
          $type_account="Sortie";

        }elseif ($data1['type_account']=='OE') {

          $type_account="Entree";
          # code...
        }else{
          $type_account=$data1['type_account'];

        }
		  		
		  	?>	
                      <tr>
                      <td><?php	echo $index;?></td> 
                      <td><?php	echo $data1['date_to_use'];?></td>   
                      <td><?php	echo $data1['agence'];?></td>                    
                      <td><?php	echo $data1['identite'];?></td>
                      <td><?php	echo $data1['ndel'];?></td>
                      <td><?php	echo $data1['statut_transaction'];?></td>
                      <td><?php	echo $type_account;?></td>
                      <td><?php	echo $data1['montant'];?></td>
                      <td><?php	echo $data1['ref_devise'];?></td>
                      <td><?php	echo $data1['user_acting'];?></td>
                      <td><?php	echo $data1['sup_detail'];?></td>
                      <td><?php	echo $data1['code_operation'];?></td>
                      
                      <td> <?php 
	
  if(get_access(10,$_SESSION['my_idprofile'])==1 && isset($data1['ndel'])){

?>
                 <a href="vue_dossier.php?find=<?php echo $data1['idt_dossier']; ?>" ><i class="fa fa-fw fa-television"></i> </a>
                 
                 <?php 

}
?>	</td>
                     
                 </tr>
                  <?php 
	
		  }
	
	 			?> 
   
                    </tbody>
                    <tfoot>
                    <th>#</th>
                      <th>Date</th>
                      <th>Agence</th>
                      <th>Client</th>
                      <th>NID</th>
                      <th>Statut</th>
                      <th>Nature</th>
                      <th>Montant</th>
                      <th>Devise</th>
                      <th>Initiateur</th>
                      <th>Libelle</th>
                      <th>Operation</th>
                      
                      <th>Actions</th>
                        </tfoot>
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
