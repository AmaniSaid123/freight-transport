<?php
	//******************IDPAGE*****************
	$idpage=57;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	
	//*********************Get Profile Data*****
$set_pluggin_datatable="yes";	
$name="";
$description="";
$backup="";
$edit="";
$data_procedure="";
$is_submittion=0;
$cible="edit_procedure.php";
//***********************Find Profile****************
//*************************Selection des informations du profile************************

if(isset($_GET['find'])){
	
		$edit=clean_in_integer($_GET['find']) ;

		$data_procedure=get_procedure_data($edit);
		if($data_procedure['is_exist']==1){
			$backup=$data_procedure['description'];
		   $_SESSION['my_m_procedure']=$edit;
			
			}else{
				
			
				header("Location: home.php?error=ok&msg=Cette procedure n'existe pas, vous n'etes pas autorise à la page suivante");
				
				}
		
	}
if($_SESSION['my_m_procedure']!="NA"){
	
		$edit=$_SESSION['my_m_procedure'] ;

		$data_procedure=get_procedure_data($edit);
		if($data_procedure['is_exist']==1){
			$backup=$data_procedure['description'];

			
			}else{
				
			
			header("Location: home.php?error=ok&msg=Cette procedure n'existe pas, vous n'etes pas autorise à la page suivante");
				
				}
		
	}

$get_active_menu="procedure";
	$page_titre="Editer Procedure";
	$page_small_detail=$data_procedure['nom_procedure'];
	$page_location="Editer Procedure";

if(isset($_GET['action_local']) && isset($_GET['id_tache']) && ($_GET['action_local']=='tache_not_viewable' || $_GET['action_local']=='tache_viewable') && clean_in_integer($_GET['id_tache'])>0){
	$tache_id=clean_in_integer($_GET['id_tache']);
	$data_tache=get_tache_data($tache_id);
	
	if($data_tache['is_exist']==1){
        
        $statut=($data_tache['is_visible']==1) ? "0" : "1";
		$feedback=change_tache_visibilite($tache_id,$statut);
		if($feedback==1){
			
			add_notification("t_tache",0,"Tache  : ".$data_tache['titre_tache']." | Procedure : ".$data_procedure['nom_procedure']." | Visisiblite : ".$statut,"",$_SESSION['my_username'],"Edition Visibilite Tache");
			$success="yes";
			$success_message="Visibilité Tache  (".$data_tache['titre_tache'].") changée avec succès";

			
			}else{
				
				$error="yes";
			$error_message="Une erreur a survenu lors du changement de la viisibilité de la tache, veuillez signaler à l'administrateur";
				
				}
		
		
		}else{
			
			$error="yes";
			$error_message="Vous ne pouvez pas Changer de Visibilité, vous devez selectionner au préalable une procedure en mode edition";
				
			
			}
	
		
	}	
	
    
    
    
      
    


      if(isset($_POST['submit_add_tache'])){
        $nom_tache=clean_in_text($_POST['nom_tache']);
        $description=clean_in_text($_POST['description_tache']);

        $feedback=add_tache($nom_tache, $description,$_SESSION['my_m_procedure']);
        
        if($feedback==1){
            add_notification("t_procedure",0,$data_procedure['nom_procedure']." | Tache : ".$nom_tache." Description : ".$description,"",$_SESSION['my_username'],"Ajout Tache");
            $success="yes";
			$success_message="Tache (".$nom_tache.") Ajouté avec succès";
        }else{

            $error="yes";
			$error_message="Une erreur a survenu lors de l'ajout de la tache, veuillez signaler à l'administrateur";
				

        }



      }

      if(isset($_POST['submit_edit_tache'])){
        $id_tache=clean_in_integer($_POST['tache_id']);
        $description=clean_in_text($_POST['description_tache']);
        $data_tache=get_tache_data($id_tache);
        $feedback=update_tache_description($id_tache, $description);
        
        if($feedback==1){
            add_notification("t_tache",0,$data_tache['description']." | Tache ID: ".$id_tache,$description,$_SESSION['my_username'],"Edition Tache");
            $success="yes";
		      	$success_message="Tache (".$data_tache['titre_tache'].") est édité avec succès";
        }else{

            $error="yes";
		      	$error_message="Une erreur a survenu lors de l'ajout de la tache, veuillez signaler à l'administrateur";
				

        }



      }
//****************location******************
		
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
          <div id="light" class="white_content">
            <a onClick="hide_pop()" class="btn-danger"><i class="fa  fa-close">Fermer Ici</i></a>
            <?php include_once("vue_white_popup_zone.php"); ?>
        </div>
        <div id="fade" class="black_overlay"></div> 
 <!-- Horizontal Form -->
<form class="form-horizontal" action="edit_procedure.php"  method="post">
 <div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">Mode Edition</h3>
                </div><!-- /.box-header -->
                <!-- form start -->

                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Nom du Procedure</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php  echo $data_procedure['nom_procedure']; ?>" name="nom_procedure"  placeholder="identifiez la procedure" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="description" placeholder="Descrivez le Ici ..."><?php  echo $data_procedure['description']; ?></textarea>
                      </div>
                    </div>
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="reset" class="btn btn-default" >Annuler</button>
                    <button type="submit"  class="btn btn-info pull-right" name="submit" onClick="return confirm('Cette action va modifier les accès de la procedure, Veuillez confirmer?')">Valider</button>
                  </div><!-- /.box-footer -->
                
              </div>
              <div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">Ajouter une tache</h3>
                </div><!-- /.box-header -->
                <!-- form start -->

                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Titre de la tache</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="" name="nom_tache"  placeholder="Tappez le nom de la tache" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="description_tache" placeholder="Descrivez le Ici ..."></textarea>
                      </div>
                    </div>
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    
                    <button type="submit"  class="btn btn-info pull-right" name="submit_add_tache" onClick="return confirm('Cette action va ajouter une tache, Veuillez confirmer?')">Valider</button>
                  </div><!-- /.box-footer -->
                
              </div><!-- /.box -->
                <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Les Droit d'Accès</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="overflow-y: scroll;"> 
                
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>  
                        <th>Tache</th>
                        <th>Description</th>
                        <th>Affichée?</th>
                        <th>Auteur</th>
                        <th>Date creation</th>
                        <th><input type="checkbox" onclick="toggle(this);" /></th>
                        
                        
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
		$sql_select1 = "select * from t_tache where ref_procedure=".$edit."  ";
		$sql_result1 = $bdd->query($sql_select1);
		
        $index=0;

		  while($data1 = $sql_result1->fetch()){
		  
            $index++;
		  	?>	
                      <tr>
                        <td><?php  echo $index; ?></td>
                        <td><?php  echo $data1['titre_tache']; ?></td>
                        <td><?php  echo $data1['description']; ?></td>
                        <td><?php  echo ($data1['is_visible']=='1') ? "Oui" : 'Non'; ?></td>
                        <td><?php  echo $data1['ref_user']; ?></td>
                        <td><?php  echo $data1['creationdate']; ?></td> 
                        <td>
                        <?php
        if ($data1['is_visible']=='1') {
            ?>
                <a href="edit_procedure.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&action_local=tache_not_viewable&id_tache=<?php echo $data1['idt_tache']; ?>" onClick="return confirm('Cette action va désactiviter la visibilité de la tache, Vous confirmez')"><i class="fa fa-fw  fa-arrow-right"></i><i class="fa fa-fw  fa-refresh"></i> </a>

            <?php
        }else{
        ?>
               <a href="edit_procedure.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&action_local=tache_viewable&id_tache=<?php echo $data1['idt_tache']; ?>" onClick="return confirm('Cette action va activer la visibilité de la tache, Vous confirmez')"><i class="fa fa-fw  fa-arrow-right"></i><i class="fa fa-fw  fa-refresh"></i> </a>
 
        <?php
        }
        ?>
        <a href="edit_procedure.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&action_tache=edit_tache&tache_id=<?php echo $data1['idt_tache']; ?>" ><i class="fa fa-fw  fa-edit"></i></a>
 
                        </td>                      
                        
                        
                      </tr>
                  <?php 
	
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

        	?>
  </body>
</html>
