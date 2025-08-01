<?php
	//******************IDPAGE*****************
	$idpage=15;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	//****************location******************
	$get_active_menu="sms";
	$page_titre="Menu SMS";
	$set_pluggin_selection_wise="yes";
	$page_small_detail="Envoyer SMS";
	$page_location="Menu SMS > Envoyer SMS";
		
	
$telephone="";
$text="";
$sender="";


if(isset($_GET['phone']) && $_GET['phone']!=""){
	
	$telephone=$_GET['phone'];
	
	
	}


if(isset($_POST['submit_send_sms']) && $_POST['telephone']!=""){
	
	
	$telephone=$_POST['telephone'];
	$telephone_to_use="";
	$telephone_to_reject="";
	$count_msg=0;
	$message=$_POST['message'];
	$is_ok_number=0;
	$re = '/08[012459][0-9]{7}|09[01789][0-9]{7}/';
	
	if(!strpos($telephone,",") && strlen($telephone)>11){
		
		$is_ok_number=1;
		$telephone_to_use=$_POST['telephone'];
		
		}else{
			
			if(strpos($telephone,",") && strlen($telephone)>11){
		
					$telephone_array=explode(",",$_POST['telephone']);	
					$total=sizeof($telephone_array);
					$count_msg=$total;
					for($i=0;$i<$total;$i++){
                                                                        //if(preg_match($re,$telephone_array[$i])){
									if(1){
		
										$is_ok_number++;
										$telephone_to_use=$telephone_to_use.','.$telephone_array[$i];
										
										}else{
											
											$telephone_to_reject=$telephone_to_reject." | ".$telephone_array[$i];
											
											}
			
							}
					$telephone_to_use=substr($telephone_to_use,1,strlen($telephone_to_use)-1);
					$telephone_to_reject=substr($telephone_to_reject,1,strlen($telephone_to_reject)-1);
					
		
				}else{
					
					$telephone_to_reject=$telephone;
					
					}
			}
			
			
	if($is_ok_number>=1){
				
				send_sms($telephone_to_use,$message,"PASSPORT","NA","User","NA");
				$success="yes";
				$success_message="SMS envoyé(s) avec succes aux destinations : ".$telephone_to_use;

				add_action_info(0, 27, "", "", "", "", "Valide", $_SESSION['my_username'], "Non", "Destinations : ".$count_msg." | Message : ".$message, 1, 0);
				
				
				$warning=($telephone_to_reject!="") ? "yes" : "";
				$warning_message="SMS non envoyé(e), numéro incorrect : ".$telephone_to_reject;
								
				
				}else{
					
					$error="yes";
					$error_message="Une erreur a survenu lors de l'envoi des SMS. veuillez contacter l'administrateur";
					
					
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
 <div class="box box-info" style="overflow-y: scroll;">
  <div class="box-header with-border">
                  <h3 class="box-title">Mode Envoi SMS</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="send_sms_personnaliser.php"  method="post" name="Myform">
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Destinateurs (s) </label>
                      <div class="col-sm-10">
                       <small class="label pull-left bg-green">#Exemple 24381346589,233823226564 pour un bulk et 24381346589 pour envoi simple</small><input type="text" class="form-control" name="telephone" <?php  echo $pattern_phone; ?>  placeholder="Tappez le numero ici! #Exemple 081346589,0823226564 pour un bulk et 081346589 pour envoi simple"  >
                      
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Sender</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="sender" value="PASSPORT" readonly>
                      </div>
                    </div>

                    <p align="left">
        <br>
 Nombre de caractere restant :   <input name="nbcaractere" type="text" readonly id="nbcaractere_id">  
        
</p>
<textarea id="compose-textarea" class="form-control" style="height: 150px" name="message" placeholder="Ecrivez votre SMS Ici" ></textarea>
                    <script type='text/javascript'>
document.forms['Myform'].elements['message'].onkeyup=function(){
   document.forms['Myform'].elements['nbcaractere'].value=document.forms['Myform'].elements['message'].value.length;
}
</script>

                    
                  </div><!-- /.box-body --> 
                  <div class="box-footer">

                    <button type="submit"  class="btn btn-info pull-right" name="submit_send_sms">Envoyer</button>
                  </div><!-- /.box-footer -->
                </form>
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

    <!-- REQUIRED JS SCRIPTS -->
<?php
		    include_once("php/importation_js.php");

        	?>
  </body>
</html>
