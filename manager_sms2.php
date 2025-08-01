<?php
	//******************IDPAGE*****************
	$idpage=61;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");

	//****************location******************
	$set_pluggin_datatable="yes";
	$set_pluggin_selection_wise="yes";	
	$set_plugin_daterange="yes";	
	$get_active_menu="sms";
	$get_active_submenu="in";
	$page_titre="SMS-Anniversaire";
	$page_small_detail="MyPASS";
	$page_location="Accueil > SMS-Anniversaire > Anniversaires";
	
  $daterange="";
  $date_from="";
  $date_to="";
  $sql_main_select="select t.* , t_dossier.identite as client, t_dossier.date_naissance as anniversaire from t_statu_dossier_profile t right join t_dossier on idt_dossier=ref_statut_dossier where (statut_sms_authentification ='0' and statut_mail_authentification ='1') or (statut_sms_authentification ='1' and statut_mail_authentification ='0') ";

  $cible="manager_sms.php";

	
  //***********************NOUVEAU MESSAGE DE VOEU***************************//
	if(isset($_POST['add_message']))
  {

      $text_sms = clean_in_text($_POST['text_sms']);
      $text_mail = clean_in_text($_POST['text_mail']);
      $sujet = clean_in_text($_POST['sujet']);
      $ref_user =clean_in_text($_SESSION['my_username']);
      //$create_at = date('Y-m-d H:i:m');

      $statut = 1;
      $write_ = add_message($sujet, $text_sms, $text_mail, $statut, $ref_user);

      if($write_  == 1)
      {
              $success = 'yes';
              $success_message = "Le message a été écrit avec succes.";

              add_notification("t_message_souhait",0,"Ajout message de souhait","Text : ".$_POST['text_sms']." ",$_SESSION['my_username'],"Message souhait");
      }else{
            $error = "yes";
            $error_message = "Une erreur s'est produit lors de l'ecriture du message.";
      }

  }

  //***********************ON FAIT MODIFIER LES PARAMETRES DES MESSAGE***************************//
  if(isset($_POST['update_message']))
  {

      $idt_write = clean_in_integer($_POST['idt_write']);
      $text_sms = clean_in_text($_POST['text_sms']);
      $text_mail = clean_in_text($_POST['text_mail']);
      $sujet = clean_in_text($_POST['sujet']);

      $feedback = update_message_souhait($idt_write, $sujet, $text_sms, $text_mail);

      if($feedback == 1) {

          add_notification("t_message_souhait",0,"Modification messages souhait","Text : ".$_POST['text_sms']." ",$_SESSION['my_username'],"Message souhait");

          $success = "yes";
          $success_message = "Messages de souhait ont été changés avec succès.";
      }

}

  if(isset($_POST['valid_restric']))
  {

      $identifiant = '4';
      $valeur = $_POST['mdl_sht'];

      $feedback = update_parametre_souhait($identifiant, $valeur);

      if($feedback == 1)
      {

        add_notification("t_message_souhait",0,"Modification t_parametre messages souhait","Paramètre : ".$_POST['mdl_sht']." ",$_SESSION['my_username'],"t_parametre");

        $success = "yes";
        $success_message = "Paramètres de souhait ont été changés avec succès.";
      }

     if($_POST['restric_statut_sms'])
     {
        $identifiant = $_POST['idt_restric_statut_sms'];
        $valeur = $_POST['restric_statut_sms'];

        $feedback = update_parametre_souhait($identifiant, $valeur);

        if($feedback == 1){

          add_notification("t_message_souhait",0,"Modification t_parametre messages souhait","Paramètre : ".$_POST['restric_statut_sms']." ",$_SESSION['my_username'],"t_parametre");

          $success = "yes";
          $success_message = "Paramètres de souhait ont été changés avec succès.";
        }
     }

     if($_POST['restric_statut_dos'])
     {
        $identifiant = $_POST['idt_restric_statut_dos'];
        $valeur = $_POST['restric_statut_dos'];

        $feedback = update_parametre_souhait($identifiant, $valeur);

        if($feedback == 1) {

        add_notification("t_message_souhait",0,"Modification t_parametre messages souhait","Paramètre : ".$_POST['restric_statut_dos']." ",$_SESSION['my_username'],"t_parametre");

          $success = "yes";
          $success_message = "Paramètres de souhait ont été changés avec succès.";
        }
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
  <div id="light" class="white_content">
            <a onClick="hide_pop()" class="btn-danger"><i class="fa  fa-close">Fermer Ici</i></a>
            <?php include_once("vue_white_popup_zone.php"); ?>
  </div>
  <!-- Your Page Content Here -->
  <form class="form-horizontal" action="<?= $cible ?>"  method="post">
			 <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Mes Paramètres d'anniversaire</h3>
                  
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                 
                     <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-setting"></i></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
             
               <div class="box-body" >
                  <table class="table table-bordered table-striped">
                    <tr>
                        <th>Statut Module Souhait</th>
                        <th>Restriction Réception SMS</th>
                        <th>Restriction Statut – Souhait</th> 
                    </tr>

                    <tr>
                        <td>
                        <select name="mdl_sht" class="form-control select2">
                          <?= getcombo_statut_modul_souht("") ?>
                        </select>
                        </td>

                        <td>
                          <?php $restric_sms = get_param_restric_sms(); ?>
                          <input type="hidden" name="idt_restric_statut_sms" value="<?php echo  $restric_sms['idt_parametre']; ?>">
                          <input type="text" name="restric_statut_sms" class="form-control" value="<?php echo  $restric_sms['valeur']; ?>">
                        </td>

                        <td>
                          <?php $restric_statut = get_param_restric_statut(); ?>
                          <input type="hidden" name="idt_restric_statut_dos" value="<?php echo  $restric_statut['idt_parametre']; ?>">
                          <input type="text" name="restric_statut_dos" class="form-control" value="<?php echo  $restric_statut['valeur']; ?>">
                        </td>    
                    </tr>
                  </table>
                <button type="submit" name="valid_restric" onClick="return confirm('Cette action va modifier les paramètres de souhait, Veuillez confirmer?')" class="btn btn-info pull-right" >Validation des restrictions
                </button>
          </div>
        </div><!-- /.col -->
                
    </div><!-- /.col -->
  </div>
  <br>
  <div class="box box-primary">
      <?php
          $txt_anniv = get_manager_message();
      ?>
        <div class="box-body" >
          <input type="hidden" name="idt_write" value="<?php echo $txt_anniv['Idt_message_souhait'] ?>">
          <label>Sujet</label>
          <input type="text" class="form-control" name="sujet" value="<?php echo $txt_anniv['sujet'] ?>" placeholder="Tappez l'objet du mail ICI" >
       
        <label>Texte MAIL :</label>
        <textarea class="textarea" name="text_mail" required  id="zone" placeholder="Ecrivez un message de Souhait pour le sms ici" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
          <?php echo $txt_anniv['txt_mail'] ?>
        </textarea><br>

        <label>Texte SMS :</label>
        <textarea class="textarea" name="text_sms" required  placeholder="Ecrivez un message de Souhait pour le mail ici" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
          <?php echo $txt_anniv['txt_sms'] ?>
        </textarea><br>  
        <script type='text/javascript'>
          document.forms['Myform'].elements['message'].onkeyup=function(){
             document.forms['Myform'].elements['nbcaractere'].value=document.forms['Myform'].elements['message'].value.length;
          }
        </script>
      </div><!-- /.row -->
      <div class="box-footer">
        <?php if($txt_anniv):?>
            <button type="submit" onClick="return confirm('Cette action va modifier le SMS de souhait, Veuillez confirmer?')" class="btn btn-info pull-right" name="update_message"><i class="fa   fa-save"></i>
              Modifier MSG
            </button>
          <?php else: ?>
            <button type="submit" onClick="return confirm('Cette action va créer un SMS de souhait, Veuillez confirmer?')" class="btn btn-danger pull-right" name="add_message"><i class="fa   fa-save"></i>
              Ajouter MSG
            </button>
          <?php endif; ?> 
                         
      </div>
  </div><!-- /.box-body -->
</div>
</form>
          </div><!-- /.row -->
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

    <!-- REQUIRED JS SCRIPTS -->
<?php
		    include_once("php/importation_js.php");

        	?>
  </body>
</html>
