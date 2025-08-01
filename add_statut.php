<?php
	//******************IDPAGE*****************
	$idpage=56;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	
	
  //****************location******************
  $set_pluggin_datatable="yes";	
  
	$get_active_menu="avance";
	$page_titre="Nouveau statut et liste des statuts";
	$page_small_detail="";
	$page_location="Statuts Dossiers";
	
	if(isset($_POST['submit']) && $_POST['name']!='' && $_POST['description']!='' && $_POST['mail']!=''){
$name=addslashes($_POST['name']);
$description=addslashes($_POST['description']);
$mail_description=addslashes($_POST['mail']);

//echo $total;
$feedback=add_statut($name,$description,$mail_description);

add_notification("t_statut",0,"NA","Nom : ".$name." / Description : ".$description,$_SESSION['my_username'],"Creation Statut");
		if($feedback==1){
      $success="yes";
			$success_message="Statut créé avec succès";

    }else{
      $error="yes";
			$error_message="Erreur! Statut non créé, verifiez qu ce statutn'existe pas deja";

    }
			
		}else{
			if(isset($_POST['submit']) && ($_POST['name']=='' || $_POST['description']=='')){
							
			$error="yes";
			$error_message="Erreur! Statut non créé, veuillez remplir le champ nom et message au client";
			
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
 <div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">Mode Creation</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="add_statut.php"  method="post">
                  <div class="box-body"  style="overflow-y: scroll;">
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Intitulé du Statut</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="name"  placeholder="identifiez le statut">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Message SMS au Client</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="description" placeholder="Ecrivez le message  Ici ..."></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Message Mail au Client</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="mail"  id="zone" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="reset" class="btn btn-default" >Annuler</button>
                    <button type="submit"  class="btn btn-info pull-right" name="submit">Valider</button>
                  </div><!-- /.box-footer -->
                </form>
              </div><!-- /.box -->
              <div class="row">
            <div class="col-xs-12">
              
              <div class="box"  style="overflow-y: scroll;">
                <div class="box-header">
                  <h3 class="box-title">Les Droit d'Accès</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Statut</th>
                        <th>Message au client</th>
                        <th>Date creation</th>
                        <th></th>
                        
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
		$sql_select1 = "select * from t_statut_dossier";
		$sql_result1 = $bdd->query($sql_select1);
		
  $index=0;

		  while($data1 = $sql_result1->fetch()){
		  
		  
		  		if(1){
					$index++;
					
					}
		  	?>	
                      <tr>
                        <td><?php  echo $data1['label']; ?></td>
                        <td><?php  echo $data1['message_client']; ?></td>
                        <td><?php  echo $data1['creationdate']; ?></td>                      
                        <td><a href="edit_statut.php?find=<?php echo $data1['idt_statut_dossier']; ?>" ><i class="fa fa-fw fa-pencil-square-o"></i> </a></td>
                        
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
