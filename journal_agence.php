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
$set_plugin_daterange = "yes";

//***********************Find Profile****************
//*************************Selection des informations du profile************************

$get_active_menu="avance";
	$page_titre="Journal de l'Agence";
	$page_small_detail="MyPASS";
	$page_location="Options Avancées > Journal de l'Agence";

$active_export="no";
//****************location******************
	
	
$nid="";
$keyword="";
$ndel="";
$agence="";
$utilisateur="";
$daterange=""; 

$param_query=" where ref_type_operation not in ('OE','OP','OC')  order by idt_actions desc limit 0,500 ";
if(isset($_GET["del"])  && get_access(28,$_SESSION['my_idprofile'])==1){
    $idt_dossier= clean_in_integer($_GET["del"]);
    
    $feedback_deletion=delete_dossier($idt_dossier);
    
   if ($feedback_deletion == 1) {

        $success = "yes";
        $success_message = "Le dossier a été supprimé avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur de la suppression du dossier";
    }
    
    
    
}
if(isset($_GET['del']) && clean_in_integer($_GET['del'])>0){
	$item_action=clean_in_integer($_GET['del']);
	
	$action_affecte=get_actions_data($item_action);
	if($action_affecte['is_exist']==1){
		
		
		
		$sql_query3=$bdd->exec("delete from t_actions where idt_actions=".$item_action);
               // echo "delete from t_actions where idt_actions==".$item_action;
		if($sql_query3==1){
			
			add_notification("t_action",0,"NA","Commentaire supprimé : ".$action_affecte['commentaire'],$_SESSION['my_username'],"Suppression Action ")." ";
			$success="yes";
			$success_message="Le Commentaire --> ".$action_affecte['commentaire']." : supprimé avec succès";
		
			
			}
		
		}else{
				
			$error="yes";
			$error_message="Vous ne pouvez pas supprimer cette action,une erreur a survenu. Merci de réessayrer";
				
				}
		
		
		
	
	}
if(isset($_POST["submit"])){
	

$keyword=clean_in_text($_POST['keyword']);
$ndel=clean_in_text($_POST['ndel']);
$agence=$_POST['agence'];
$utilisateur=$_POST['utilisateur'];
$daterange=$_POST['daterange'];
   
$param_query=" where ref_type_operation not in ('OE','OP','OC') ";


if (isset($_POST['daterange']) && $_POST['daterange'] != "") {
    //echo "oooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee";
    $tempo = explode("-", $_POST['daterange']);
    $daterange = $_POST['daterange'];
    $date_debut = trim($tempo[0]);
    $date_fin = trim($tempo[1]);
    $param_query = " and  t.creationdate between '" . $date_debut . " 00:00:00' and  '" . $date_fin . " 23:59:59' ";
   
}
	
	
	if($keyword!=""){
		
		$param_query=$param_query." and commentaire like '%".$keyword."%' ";
		
				}	
	
	if($ndel!=""){
		
		$param_query=$param_query." and ndel like '".$ndel."%' ";
		
		}
	
		if($agence!=""){
		
		$param_query=$param_query." and ref_agence=".$agence." ";
		
		}
		
		if($utilisateur!=""){
		
		$param_query=$param_query." and ref_requester='".$utilisateur."' ";
		
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
 <form class="form-horizontal" action="journal_agence.php"  method="post">
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
                      <th>Initiateur</th>
                      <th>Commentaire</th>
                      <th>Operation</th>
                      <th>Notification</th>
                      <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
		                        $sql_select1 = "SELECT t.*,w.*, t.creationdate as date_to_use, label_icone, t_operation.label as operation, t_agence.label as agence, w.deletion_statut FROM passport_bd.t_actions t join t_operation on ref_operation=idt_operation
                            left join t_dossier w on idt_dossier=ref_dossier  left join t_agence on ref_agence=id_agence " . $param_query . " ";
                          //  echo $sql_select1;
		
		$sql_result1 = $bdd->query($sql_select1);
		
  $index=0;

		  while($data1 = $sql_result1->fetch()){
            $index++;
		   
		  		
		  	?>	
                      <tr>
                      <td><?php	echo $index;?></td> 
                      <td><?php	echo $data1['date_to_use'];?></td>   
                      <td><?php	echo $data1['agence'];?></td>                    
                      <td><?php	echo $data1['identite'];?></td>
                      <td><?php	echo $data1['ndel'];?></td>
                      <td><?php	echo $data1['statut_dossier'];?></td>
                      <td><?php	echo ($data1['ref_requester']=="online_user") ? $data1['identite']: $data1['ref_requester'];?></td>
                      <td><?php	echo $data1['commentaire'];?></td>
                      <td><?php	echo $data1['operation'];?></td>
                      <td><?php echo ($data1['notification_sms']=="1") ? '<i class="fa fa-wechat bg-blue">SMS</i>' : ''; 
                                    echo ($data1['notification_email']=="1") ? '<i class="fa fa-envelope bg-green">Mail</i>' : '';  echo ($data1['notification_appel']=="1") ? '<i class="fa fa-phone bg-red">Appel</i>' : ''; ?>
                                          
                      </td>
                      <td>
                      <?php 
	
						if(get_access(18,$_SESSION['my_idprofile'])==1){
	
                         ?>
                          <a href="journal_agence.php?del=<?php echo $data1['idt_actions']; ?>" onClick="return confirm('Cette action va supprimer ce commentaire definitivement, Veuillez confirmer?')" ><i class="fa  fa-cut"></i> </a>

                           
                           <?php 
	
                            }

                            ?>
                            <?php 
	
    if(get_access(10,$_SESSION['my_idprofile'])==1 && $data1['deletion_statut']==0){

?>
       <a href="vue_dossier.php?find=<?php echo $data1['idt_dossier']; ?>" ><i class="fa fa-fw fa-television"></i> </a>
       
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
