<?php
	//******************IDPAGE*****************
	$idpage=4;
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
$data_profile="";
$is_submittion=0;
//***********************Find Profile****************
//*************************Selection des informations du profile************************

if(isset($_GET['find'])){
	
		$edit=clean_in_integer($_GET['find']) ;

		$data_profile=get_profile_data($edit);
		if($data_profile['is_exist']==1){
			$backup=$data_profile['description'];
		   $_SESSION['my_m_profile']=$edit;
			
			}else{
				
			
				header("Location: home.php?error=ok&msg=Ce Profile n'existe pas, vous n'etes pas autorise à la page suivante");
				
				}
		
	}
if($_SESSION['my_m_profile']!="NA"){
	
		$edit=$_SESSION['my_m_profile'] ;

		$data_profile=get_profile_data($edit);
		if($data_profile['is_exist']==1){
			$backup=$data_profile['description'];

			
			}else{
				
			
			header("Location: home.php?error=ok&msg=Ce Profile n'existe pas, vous n'etes pas autorise à la page suivante");
				
				}
		
	}

$get_active_menu="profile";
	$page_titre="Editer Profile";
	$page_small_detail=$data_profile['name'];
	$page_location="Editer Profile".'  <a href="list_profile.php?close=ok"><i class="fa  fa-close"></i></a>';

if(isset($_GET['del']) && isset($_GET['menu'])){
	$_GET['del']=clean_in_integer($_GET['del']);
	$_GET['menu']=clean_in_text($_GET['menu']);
	
	include("php/param.php");
	if($_SESSION['my_m_profile']!="NA"){
		
		$sql_query3=$bdd->exec("delete from t_profile_content where idpc=".$_GET['del']." and ref_profile=".$_SESSION['my_m_profile']);
		
		if($sql_query3==1){
			
			add_notification("t_profile_content",0,"Menu : ".$_GET['menu'],"Menu : ".$_GET['menu'],$_SESSION['my_username'],"Suppression acces au profile");
			$success="yes";
			$success_message="Accès (".$_GET['menu'].") rétiré";

			
			}else{
				
				$error="yes";
			$error_message="Une erreur a survenu lors de la suppression de l'accès, veuillez signaler à l'administrateur";
				
				}
		
		
		}else{
			
			$error="yes";
			$error_message="Vous ne pouvez pas supprimer un accès sans selectionner au préalable un profile en mode edition";
				
			
			}
	
	
	
		
	
	}	
	
  if(isset($_GET['del']) && isset($_GET['statut'])){
    $_GET['del']=clean_in_integer($_GET['del']);
    $_GET['statut']=clean_in_text($_GET['statut']);
    
    include("php/param.php");
    if($_SESSION['my_m_profile']!="NA"){
      
      $sql_query3=$bdd->exec("delete from t_statu_dossier_profile where idt_statu_dossier_profile=".$_GET['del']." and ref_profile=".$_SESSION['my_m_profile']);
      
      if($sql_query3==1){
        
        add_notification("t_statut_profile",0,"Statut : ".$_GET['statut'],"Menu : ".$_GET['statut'],$_SESSION['my_username'],"Suppression acces au Statut");
        $success="yes";
        $success_message="Accès (".$_GET['statut'].") rétiré";
  
        
        }else{
          
          $error="yes";
        $error_message="Une erreur a survenu lors de la suppression de l'accès au statut, veuillez signaler à l'administrateur";
          
          }
      
      
      }else{
        
        $error="yes";
        $error_message="Vous ne pouvez pas supprimer un statut sans selectionner au préalable un profile en mode edition";
          
        
        }
    
    
    
      
    
    }	
    
	
if(isset($_POST['submit']) && $_POST['name']!=""){
$is_submittion=1;
$total=$_POST['total'];
$edit=$_SESSION['my_m_profile'];
$_POST['name']=clean_in_text($_POST['name']);
//echo $total;
$feedback=update_profile($_POST['name'],$_POST['description'],$_SESSION['my_m_profile']);
$data_profile=get_profile_data($_SESSION['my_m_profile']);
add_notification("t_profile",0,"Old Description : ".$backup." -->> New description : ".$description,"Old Description : ".$backup." -->> New description : ".$description,$_SESSION['my_username'],"Mise a Jour Profile");
//$nextkey=next_key();
			for($i=1;$i<=$total;$i++){
				
				if(isset($_POST['chk'.$i]) && $_POST['chk'.$i]=="on" && $feedback==1){
					
		$feedback=add_profile_content($_SESSION['my_m_profile'],$_POST['value'.$i],$_SESSION['my_username']);
          //echo $feedback;
          $data_content=get_content_data($_POST['value'.$i]);
				add_notification("t_profile_content",0,"NA","Profile : ".$data_profile['name']." | Ref profile = ".$_SESSION['my_m_profile']." |  ref_content =  : ".$_POST['value'.$i]." | Option : ".$data_content['name'],$_SESSION['my_username'],"Ajout Acces comme update Profile");	
					
					}
				
								
				}
		
		    $success="yes";
			$success_message="Modification sur le profile enregistrée avec succès";
		
		}else{
			
			
      }

      if(isset($_POST['submit_statut'])){
        $is_submittion=1;
        $total=$_POST['total'];
        $edit=$_SESSION['my_m_profile'];
      
        //echo $total;
        $data_profile=get_profile_data($_SESSION['my_m_profile']);
        add_notification("t_profile",0,"Old Description : ".$backup." -->> New description : ".$description,"Old Description : ".$backup." -->> New description : ".$description,$_SESSION['my_username'],"Mise a Jour Profile");
        //$nextkey=next_key();
              for($i=1;$i<=$total;$i++){
                
                if(isset($_POST['chk'.$i]) && $_POST['chk'.$i]=="on"){
                  
            $feedback=add_profile_statut($_SESSION['my_m_profile'],$_POST['value'.$i],$_SESSION['my_username']);
                  //echo $feedback;
                  if($feedback==1){
                      $data_content=get_statut_data($_POST['value'.$i]);
                      add_notification("t_statut_profile",0,"NA","Profile : ".$data_content['label']." | Ref profile = ".$_SESSION['my_m_profile']." |  ref_content =  : ".$_POST['value'.$i]." | Option : ".$data_content['label'],$_SESSION['my_username'],"Ajout Statut Dossier Profile");	
                      $success="yes";
              $success_message="Modification sur le profile enregistrée avec succès";
                         

                  }
                  
                  }
                
                        
                }
            
                
            }else{
              
              
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
 <!-- Horizontal Form -->
<form class="form-horizontal" action="edit_profile.php"  method="post">
 <div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">Mode Edition</h3>
                </div><!-- /.box-header -->
                <!-- form start -->

                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Nom du profile</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php  echo $data_profile['name']; ?>" name="name"  placeholder="identifiez le profile">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="description" placeholder="Descrivez le Ici ..."><?php  echo $data_profile['description']; ?></textarea>
                      </div>
                    </div>
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="reset" class="btn btn-default" >Annuler</button>
                    <button type="submit"  class="btn btn-info pull-right" name="submit" onClick="return confirm('Cette action va modifier les accès du profile, Veuillez confirmer?')">Valider</button>
                  </div><!-- /.box-footer -->
                
              </div><!-- /.box -->
                <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Les Droit d'Accès</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Menu</th>
                        <th>Fonctionnalité</th>
                        <th>Accordéé?</th>
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
		$sql_select1 = "select t_content.name as sous_menu,idcontent, ref_menu,idpc, 'Oui' as accorder from t_content,t_profile_content
where idcontent=ref_content and  ref_profile=".$edit."  

union 

select t_content.name as sous_menu, idcontent,ref_menu,'0', 'Non' as accorder from t_content
where display='y' and idcontent not in (select ref_content from t_profile_content
where ref_profile=".$edit.")  order by ref_menu desc";
		$sql_result1 = $bdd->query($sql_select1);
		$total_agent=get_total_user();
  $index=0;

		  while($data1 = $sql_result1->fetch()){
		  
		  
		  		if($data1['accorder']=="Non"){
					$index++;
					
					}
		  	?>	
                      <tr>
                        <td><?php  echo $data1['ref_menu']; ?></td>
                        <td><?php  echo $data1['sous_menu']; ?></td>
                        <td><?php  echo $data1['accorder']; ?></td>                      
                        <td>
                        <?php  
						if($data1['accorder']=="Non"){
							
						 ?>
                        <input name="value<?php  echo $index;?>" type="hidden" value="<?php  echo $data1['idcontent'];?>"><input name="chk<?php  echo $index;?>" type="checkbox" value="on">
                        <?php  
  							}else{
						 ?>
                         <a href="edit_profile.php?find=<?php  echo $_SESSION['my_m_profile']."&del=".$data1['idpc']."&menu=".$data1['sous_menu'];?>"><i class="fa  fa-cut"></i></a>

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
                      <tr>
                        <th>Menu</th>
                        <th>Fonctionnalité</th>
                        <th>Accordéé?</th>
                        <th>Cochez pour accorder</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                <input name="total" type="hidden" value="<?php echo $index; ?>">       
          </form>
          <form class="form-horizontal" action="edit_profile.php"  method="post">
 
                <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Les Droits de vision Statut dossier</h3>
                  <button type="submit"  class="btn btn-info pull-right" name="submit_statut" onClick="return confirm('Cette action va modifier les droits de vision des statuts, Veuillez confirmer?')">Valider</button>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>statut</th>
                        
                        <th>Accordéé?</th>
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
		$sql_select1 = "select label,idt_statut_dossier, idt_statu_dossier_profile, 'Oui' as accorder from t_statut_dossier join t_statu_dossier_profile on idt_statut_dossier=ref_statut_dossier 
where  ref_profile=".$edit."  

union 

select label,idt_statut_dossier,0,'Non' as accorder from t_statut_dossier
where idt_statut_dossier not in (select ref_statut_dossier from t_statu_dossier_profile
where ref_profile=".$edit.")  order by label desc";
//echo $sql_select1;
		$sql_result1 = $bdd->query($sql_select1);
		//$total_agent=get_total_user();
  $index_statut=0;

		  while($data1 = $sql_result1->fetch()){
		  
		  
		  		if($data1['accorder']=="Non"){
					$index_statut++;
					
					}
		  	?>	
                      <tr>
                        <td><?php  echo $data1['label']; ?></td>
                        
                        <td><?php  echo $data1['accorder']; ?></td>                      
                        <td>
                        <?php  
						if($data1['accorder']=="Non"){
							
						 ?>
                        <input name="value<?php  echo $index_statut;?>" type="hidden" value="<?php  echo $data1['idt_statut_dossier'];?>"><input name="chk<?php  echo $index_statut;?>" type="checkbox" value="on">
                        <?php  
  							}else{
						 ?>
                         <a href="edit_profile.php?find=<?php  echo $_SESSION['my_m_profile']."&del=".$data1['idt_statu_dossier_profile']."&statut=".$data1['label'];?>"><i class="fa  fa-cut"></i></a>

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
                      <tr>
                        <th>Statut</th>
                        
                        <th>Accordéé?</th>
                        <th>Cochez pour accorder</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                <input name="total" type="hidden" value="<?php echo $index_statut; ?>">       
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
