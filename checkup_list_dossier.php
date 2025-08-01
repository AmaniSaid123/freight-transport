<?php
	//******************IDPAGE*****************
	$idpage=58;
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

$get_active_menu="dossier";
	$page_titre="Check-up de Controle";
	$page_small_detail="MyPASS";
	$page_location="Dossier > Check-up de Controle";

$active_export="no";
//*************-ops_fin_dossier***location******************
$cible="checkup_list_dossier.php";	
	



include_once("action_zone_script.php");
if(isset($_POST['submit_set_procedure'])){
    $data_procedure=get_procedure_data($_POST['ref_procedure']);
    $feedback=set_procedure_dossier($data_dossier['idt_dossier'],$_POST['ref_procedure']);

    if($feedback==1){
        add_notification("t_dossier", $data_dossier['ndel'], "Configuration procedure de controle ".$data_procedure['nom_procedure'],"", $_SESSION['my_username'], "Configuration Procedure");
        $data_dossier=get_dossier_data($data_dossier['idt_dossier']);
        $success="yes";
        $success_message="Configuration de la procedure de controle fait avec succès";
    }else{

        $error="yes";
        $error_message="Une erreur a survenue lors de la configuration de la procedure de controle";


    }


}

if(isset($_POST['submit_change_procedure'])){
    $data_procedure=get_procedure_data($_POST['ref_procedure']);
    $data_procedure_backup=get_procedure_data($data_dossier['ref_procedure']);
    $feedback=set_procedure_dossier($data_dossier['idt_dossier'],$_POST['ref_procedure']);

    if($feedback==1){
        add_notification("t_dossier", $data_dossier['ndel'], "Configuration procedure de controle Ancien :  ".$data_procedure_backup['nom_procedure'],"Configuration procedure de controle Nouveau :  ".$data_procedure['nom_procedure'], $_SESSION['my_username'], "Configuration Procedure");
        $data_dossier=get_dossier_data($data_dossier['idt_dossier']);
        $success="yes";
        $success_message="Modification  de la procedure de controle fait avec succès";
    }else{

        $error="yes";
        $error_message="Une erreur a survenue lors de la modification de la procedure de controle";


    }


}

if(get_access(58,$_SESSION['my_idprofile'])==1 && isset($_GET['del']) && isset($_GET['menu'])){
	$_GET['del']=clean_in_integer($_GET['del']);
	$_GET['menu']=clean_in_text($_GET['menu']);
	
	
	if($data_dossier['idt_dossier']!="NA"){
		
		$sql_query3=$bdd->exec("delete from t_tache_dossier where idt_tache_dossier=".$_GET['del']." ");
		
		if($sql_query3==1){
			
			add_notification("t_dossier",$data_dossier['ndel'],"Tache : ".$_GET['menu'],"Tache : ".$_GET['menu'],$_SESSION['my_username'],"Suppression tache accomplie");
			$success="yes";
			$success_message="Accès (".$_GET['menu'].") rétiré del aliste des taches accomplies";

			
			}else{
				
				$error="yes";
			$error_message="Une erreur a survenu lors de la suppression de la tache, veuillez signaler à l'administrateur";
				
				}
		
		
		}else{
			
			$error="yes";
			$error_message="Vous ne pouvez pas supprimer un accès sans selectionner au préalable un dossier";
				
			
			}
	
	
	
		
	
	}	

    if(isset($_POST['submit_validation_tache'])){
        
        $total=$_POST['total'];
        $edit=$_SESSION['my_m_procedure'];
      
        //echo $total;
        $feedback=1;
        //$data_procedure=get_procedure_data($_SESSION['my_m_procedure']);
        
                    for($i=1;$i<=$total;$i++){
                        
                        if(isset($_POST['chk'.$i]) && $_POST['chk'.$i]=="on" && $feedback==1){
                            
                                $feedback=add_dossier_tache($data_dossier['idt_dossier'],$_POST['value'.$i]);
                                if($feedback==1){

                                    $data_tache=get_tache_data($_POST['value'.$i]);
                                    $success="yes";
                                    $success_message=$success_message." La tache ".$data_tache['titre_tache']." Ajouté avec succès<br>";
                                    add_notification("t_dossier",$data_dossier['ndel'],"NA","Tache : ".$data_tache['titre_tache'],$_SESSION['my_username'],"Tache accomplie");	
                       

                                }
                                 
                            
                            }
                        
                                        
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
<div id="light" class="white_content">
            <a onClick="hide_pop()" class="btn-danger"><i class="fa  fa-close">Fermer Ici</i></a>
            <?php include_once("vue_white_popup_zone.php"); ?>
        </div>
        <div id="fade" class="black_overlay"></div>
          <!-- Your Page Content Here -->
 <!-- Horizontal Form -->
 <?php include_once("zone_bouton_dossier.php"); ?>
    
          
          <form class="form-horizontal" action="checkup_list_dossier.php"  method="post">
 <div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">Mode Edition</h3>
                </div><!-- /.box-header -->
                <!-- form start -->

                  <div class="box-body">
                  <div class="form-group">
                      <label  class="col-sm-4 control-label">Check-up liste des taches</label>
                      <div class="col-sm-8">
                      <select name="ref_procedure" class="form-control select2" <?php echo (get_access(57,$_SESSION['my_idprofile'])==1) ? '' : 'disabled'; ?> required>
                        <option value="" <?php echo ($data_dossier['ref_procedure']=='') ? 'selected' : ''; ?>>Non Defini</option>                        
                        <?php echo  getcombo_liste_procedure($data_dossier['ref_procedure']); ?>
                      </select>
                      
                      </div>
                    </div>

                  </div><!-- /.box-body -->
                  <div class="box-footer">
                  <button type="submit"  class="btn btn-info pull-left" name="submit_change_procedure" onClick="return confirm('Cette action va modifier la procedure de controle, c est irreversible,  Veuillez confirmer?')" <?php echo ($data_dossier['ref_procedure']=='disabled') ? '' : ''; ?>>Modifier la procedure de controle pour ce Dossier</button>
                  <button type="submit"  class="btn btn-info pull-right" name="submit_set_procedure" onClick="return confirm('Cette action va configurer la procedure, Veuillez confirmer?')" <?php echo ($data_dossier['ref_procedure']=='') ? '' : 'disabled'; ?>>Configurer la procedure pour Ce Dossier</button>
                  </div><!-- /.box-footer -->
                
              </div><!-- /.box -->
                <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Les Droit d'Accès</h3>
                  <button type="submit"  class="btn btn-info pull-right" name="submit_validation_tache" onClick="return confirm('Cette action va considerer la tache fait, Veuillez confirmer?')">Valider les elements cochés</button>
                
                </div><!-- /.box-header -->
                <div class="box-body" style="overflow-y: scroll;">
                
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>tache</th>
                        <th>Description</th>
                        <th>date</th>
                        <th>Effectué?</th>
                        <th><input type="checkbox" onclick="toggle(this);" /></th>
                        <script>
                  function toggle(source) {

                    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                    for (var i = 0; i < checkboxes.length; i++) {
                      if (checkboxes[i] != source)
                        checkboxes[i].checked = source.checked;
                    }


                  }
                </script>
                        
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
    $sql_select1 = "select idt_tache_dossier,description,idt_tache,titre_tache, t.creationdate,  'Oui' as accorder 
    from t_tache_dossier t join t_tache on t.ref_tache=idt_tache where t.ref_dossier=".$data_dossier['idt_dossier']." 
 

union 

select 0 as idt_tache_dossier,description,idt_tache, titre_tache,'' as creationdate, 'Non' as accorder from t_tache
where ref_procedure=".$data_dossier['ref_procedure']." and is_visible=1 and idt_tache not in (select ref_tache from t_tache_dossier
where ref_dossier=".$data_dossier['idt_dossier'].")";

//echo $sql_select1;
		$sql_result1 = $bdd->query($sql_select1);
		
  $index=0;
if($data_dossier['ref_procedure']>0 || $data_dossier['statut_dossier']=="Cloc_echec" || $data_dossier['statut_dossier']=="Cloc_reussi" || $data_dossier['statut_dossier']=="Cloc_Abandon"){
		  while($data1 = $sql_result1->fetch()){
		  		  
		  		
					$index++;
                  
                    
					
		  	?>	
                      <tr>
                      <td><?php  echo $index; ?></td>  
                      <td><?php  echo $data1['titre_tache']; ?></td>
                      <td><?php  echo $data1['description']; ?></td>
                        <td><?php  echo $data1['creationdate']; ?></td>
                        <td><?php  echo $data1['accorder']; ?></td>                      
                        <td>
                        <?php  
						if($data1['accorder']=="Non" && get_access(59,$_SESSION['my_idprofile'])==1){
							
						 ?>
                        <input name="value<?php  echo $index;?>" type="hidden" value="<?php  echo $data1['idt_tache'];?>"><input name="chk<?php  echo $index;?>" type="checkbox" value="on">
                        <?php  
  							}else{

                  if(get_access(59,$_SESSION['my_idprofile'])==1){
						 ?>
                         <a href="checkup_list_dossier.php?<?php  echo "del=".$data1['idt_tache_dossier']."&menu=".$data1['titre_tache'];?>" onClick="return confirm('Cette action va supprimer l accomplissement de la tache, Veuillez confirmer?')"><i class="fa  fa-cut"></i></a>

                         <?php  
                  }
  							}
						 ?>
                        </td>
                        
                      </tr>
                  <?php 
                    }
                }
		  
	
	 			?> 
   
                    </tbody>
                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
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
			//include_once("php/export_to_csv_js.php");

        	?>
  </body>
</html>
