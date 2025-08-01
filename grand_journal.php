<?php
	//******************IDPAGE*****************
	$idpage=40;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	
	//*********************Get Profile Data*****
	$set_pluggin_datatable="yes";
	$set_pluggin_selection_wise="yes";	
	$set_plugin_daterange="yes";
//***********************Find Profile****************
//*************************Selection des informations du profile************************

$get_active_menu="comptabilite";
	$page_titre="Comptabilité - Grand Journal";
	$page_small_detail="Grand Journal";
	$page_location="Comptabilité > Grand Journal";

//****************location******************
	
	
$ref_compte="";
$date_debut="";
$date_fin="";
$daterange="";
$ref_agent="";
$source_action='';
$code_operation="";


$param_query=" where ref_agence_action=".$_SESSION['my_agence']."  and date(t.creationdate)=date(now())";
$limit="  limit 0,500";



if(isset($_POST["submit"])){
	
	if(isset($_POST['daterange']) && $daterange=$_POST['daterange']!=""){
		
		$tempo=explode("-",$_POST['daterange']);
		$date_debut=trim($tempo[0]);
		$date_fin=trim($tempo[1]);

	}
	$limit="  ";
$daterange=$_POST['daterange'];
$ref_agent=$_POST['ref_agent'];
$ref_compte=$_POST['ref_compte'];
$source_action=$_POST['source_action'];
$code_operation=$_POST['code_operation'];



$param_query=" where ref_agence_action=".$_SESSION['my_agence']."  ";

	if($ref_compte!=""){
		
		$param_query=$param_query." and ref_compte='".$ref_compte."' ";
		
		}
	
	if($source_action!=""){
		
		$param_query=$param_query." and source_action='".$source_action."' ";
		
				}	
	
	if($code_operation!=""){
		
		$param_query=$param_query." and code_operation='".$code_operation."' ";
		
		}
	
		if($daterange!=""){
		
		$param_query=$param_query." and (t.creationdate between '".$date_debut." 00:00:00' and '".$date_fin." 23:59:59') ";
		
		}
		
		if($ref_agent!=""){
		
		$param_query=$param_query." and ref_user='".$ref_agent."' ";
		
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
 
          
<form  onsubmit="ShowLoading()" class="form-horizontal" action="grand_journal.php"  method="post">
 	<div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">Criteres` de recherche</h3>
                  <div class="box-tools pull-right">
                 
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                

              </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                  <div class="box-body" style="overflow-y: scroll;">
                     
                     <div class="form-group">
                      <label  class="col-sm-2 control-label">Période</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control pull-right" id="date2" name="daterange" value="<?php echo $daterange; ?>" placeholder="Specifiez une date">
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Compte</label>
                      <div class="col-sm-4">
                        <select name="ref_compte" class="form-control select2">
                        <option value="" <?php echo ($ref_compte=='') ? 'selected' : ''; ?>>Tous les comptes</option>                        
                        <?php echo getcombo_compte($ref_compte); ?>
                      </select>
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Agent</label>
                      <div class="col-sm-4">
                        <select name="ref_agent" class="form-control select2">
                        <option value="" <?php echo ($ref_agent=='') ? 'selected' : ''; ?>>Tous les agents</option>
                        <?php echo getcombo_user_login($ref_agent); ?>
                      </select>
                        
                      </div>
                    </div>
                     <div class="form-group">
                      <label  class="col-sm-2 control-label">Source de l'action</label>
                      <div class="col-sm-4">
                        <select name="source_action" class="form-control select2">
                        <option value="" <?php echo ($source_action=='') ? 'selected' : ''; ?>>Toutes les source d'action</option>
                        <?php echo getcombo_source_action($source_action); ?>
                      </select>
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Operation</label>
                      <div class="col-sm-4">
                        <select name="code_operation" class="form-control select2">
                        <option value="" <?php echo ($code_operation=='') ? 'selected' : ''; ?>>Toutes les Operations</option>
                        <?php echo getcombo_operation_code($code_operation); ?>
                      </select>
                        
                      </div>
                    </div>
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">

                    <button type="submit"  class="btn btn-info pull-right" name="submit" >Trouver</button>
                  </div><!-- /.box-footer -->
                
              </div><!-- /.box -->
                
          </form> 
          <form  onsubmit="ShowLoading()" action="#" method="post">    
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Mode Liste</h3>
                    <button onclick="exportTableToCSV('ExportFileGrandJournal.csv')" class="btn btn-success pull-right" ><i class="fa  fa-file-excel-o fa-download"> Exporter en CSV </i> <i class="fa fa-download"></i></button>                  
                </div><!-- /.box-header -->
                <div class="box-body" style="overflow-y: scroll;">
                
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      <th>#</th>  
                      <th>Cree le</th> 
                      <th>Agence</th>
                      <th>Membre</th>                    
                      <th>Compte</th>

                      <th>Credit</th>
                      <th>Debit</th>
                      <th>Solde</th>
                      <th>Devise</th>
                      
                      <th>Operation</th>
                      <th>Commentaire</th>
                      <th>Transaction</th>
                      
                      <th>Auteur</th>
                      <th>Solde CDF</th>
                      
      
                                            </tr>
                    </thead>
                    <tbody>
                     <?php 
		$sql_select1 = "select t.*, t_livre_compte.label, identite, t_agence.label as agence from t_grand_journal t join t_livre_compte on (ref_compte=account_no and ref_agence_action=t_livre_compte.ref_agence) left join t_dossier on idt_dossier=ref_id_source join t_agence on ref_agence_action=id_agence ".$param_query." order by id_grand_journal desc ".$limit;
		$sql_result1 = mysqli_query($bdd_i,$sql_select1);
		 //echo $sql_select1;
  $index=0;

		  while($data1 = mysqli_fetch_array($sql_result1)){
		  $index++;
		  
		  		
		  	?>	
                      <tr>
                      <td><?php	echo $index ;?></td> 
                      <td><?php	echo $data1['creationdate'] ;?></td> 
                      <td><?php	echo $data1['agence'] ;?></td> 
                      <td><?php	echo $data1['identite'] ;?></td>
                      <td><?php	echo $data1['ref_compte']." ".$data1['label'];?></td>                      

                      <td><?php	echo $data1['credit_action'];?></td>
                      <td><?php	echo $data1['debit_action'] ;?></td>
                      <td><?php	echo ($data1['ref_devise']=='USD') ? round($data1['solde_parent']/$_SESSION['my_taux'],0)." $" : $data1['solde_parent']." Fc" ;?></td>

                      <td><?php	echo $data1['ref_devise'] ;?></td>
                      
                      <td><?php	echo $data1['code_operation'] ;?></td>
                      <td><?php	echo $data1['source_action'] ;?></td>
                      <td><?php	echo $data1['ref_transaction'] ;?></td>
                      
                      <td><?php	echo $data1['ref_user'] ;?></td>   
                      <td><?php	echo $data1['solde_parent']." Fc" ;?></td>

                                        
                       
                                             
                 </tr>
                  <?php 
	
		  }
	
	 			?> 
   
                    </tbody>
                    <tfoot>
                    <th>#</th>  
                      <th>Cree le</th> 
                      <th>Agence</th>
                      <th>Membre</th>                    
                      <th>Compte</th>

                      <th>Credit</th>
                      <th>Debit</th>
                      <th>Solde</th>
                      <th>Devise</th>
                      
                      <th>Operation</th>
                      <th>Commentaire</th>
                      <th>Transaction</th>
                      
                      <th>Auteur</th>
                      <th>Solde CDF</th>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           
                             <input name="total" type="hidden" value="<?php echo $index; ?>">           
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
