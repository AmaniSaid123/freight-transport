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
$data_statut="";
$is_submittion=0;
//***********************Find Profile****************
//*************************Selection des informations du profile************************

if(isset($_GET['find']) || isset($_POST['find'])){
	
		$edit=(isset($_GET['find'])) ? clean_in_integer($_GET['find']) : clean_in_integer($_POST['find']);

		$data_statut=get_statut_data($edit);
		if($data_statut['is_exist']==1){
			$backup=$data_statut['label']." - SMS message : ".$data_statut['message_client']." - Mail message : ".$data_statut['mail_client'];
		
			
			}else{
				
			
				header("Location: home.php?error=ok&msg=Ce statut n'existe pas, vous n'etes pas autorise à la page suivante");
				
				}
		
	}
$get_active_menu="avance";
	$page_titre="Editer Statut";
	$page_small_detail=$data_statut['label'];
	$page_location="Editer Statut";

	
	

if(isset($_POST['submit']) && $_POST['name']!="" && $data_statut['is_exist']==1){


$description=addslashes($_POST['description']);
$mail=addslashes($_POST['mail']);
$name=clean_in_text($_POST['name']);
//echo $total;
$feedback=update_statut($name,$description,$mail,$edit);
$data_statut=get_statut_data($edit);
add_notification("t_statut",0,"Old Description : ".$backup."","New description SMS : ".$description." || New description Mail : ".$mail,$_SESSION['my_username'],"Edition Statut");
//$nextkey=next_key();
    
  if($feedback==1){

      $success="yes";
			$success_message="Modification sur le profile enregistrée avec succès";

  }else{

    $error="yes";
    $error_message="Une erreur a survenu lors de la modification du statut";

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
 <!-- Horizontal Form -->
<form class="form-horizontal" action="edit_statut.php"  method="post">
 <div class="box box-info"  style="overflow-y: scroll;">
  <div class="box-header with-border">
                  <h3 class="box-title">Mode Edition</h3>
                </div><!-- /.box-header -->
                <!-- form start -->

                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Nom du profile</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php  echo $data_statut['label']; ?>" name="name"  placeholder="identifiez le profile" readonly>
                        <input type="hidden" name="find" value="<?php  echo $data_statut['idt_statut_dossier']; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Message SMS au Client</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="description" placeholder="Ecrivez le SMS ICI..."><?php  echo $data_statut['message_client']; ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Message Mail au Client</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="mail"  id="zone" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php  echo $data_statut['mail_client']; ?></textarea>
                      </div>
                    </div>
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="reset" class="btn btn-default" >Annuler</button>
                    <button type="submit"  class="btn btn-info pull-right" name="submit" onClick="return confirm('Cette action va modifier le message destiné au client, Veuillez confirmer?')">Valider</button>
                  </div><!-- /.box-footer -->
                
              </div><!-- /.box -->
                    
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
