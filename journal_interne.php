<?php
//******************IDPAGE*****************
$idpage = 9;
//Session check****************************
include_once("php/session_check.php");
include_once("php/function.php");
//********************locally Additionnal Function*************
//*********************Get Profile Data*****
$set_pluggin_datatable = "yes";
$set_pluggin_selection_wise = "yes";

//***********************Find Profile****************
//*************************Selection des informations du profile************************



$active_export = "no";
//****************location******************

$cible="journal_interne.php";
$data_dossier = "";
$identite = "";
$date_naissance = "";
$data_agence=get_agence_data($_SESSION['my_agence']);
$contact=$data_agence['contact'];

include_once("action_zone_script.php");
/*
if (isset($_GET['find'])) {

    $edit = clean_in_integer($_GET['find']);

    $data_dossier = get_dossier_data($edit);
//					echo $edit;
    if ($data_dossier['is_exist'] == 1) {
        $_SESSION['my_m_dossier'] = $edit;

        /* $identite=$data_dossier['identite'];
          $date_naissance=$data_dossier['date_naissance'];
          $telephone=$data_dossier['telephone'];
          $lieu_naissance=$data_dossier['lieu_naissance'];
          $nbre_enfant_famille=$data_dossier['nbre_enfant_famille'];
          $position_dans_famille=$data_dossier['position_dans_famille'];
          $numero_passport=$data_dossier['numero_passport'];
          $date_expiration_pp=$data_dossier['date_expiration_pp'];
          $ref_agence=$data_dossier['ref_agence'];
          $promoteur_agence=$data_dossier['promoteur_agence'];
          $activite_passe_actuelle=$data_dossier['activite_passe_actuelle'];
          $vo_destination=$data_dossier['vo_destination'];
          $vo_raison_voyage=$data_dossier['vo_raison_voyage'];
          $vo_charge_etude_parrain=$data_dossier['vo_charge_etude_parrain'];
          $vo_ancien_visa=$data_dossier['vo_ancien_visa'];
          $vo_ancien_visa_comment=$data_dossier['vo_ancien_visa_comment'];
          $vo_refus_visa_chk=$data_dossier['vo_refus_visa_chk'];
          $commentaire_refus_visa=$data_dossier['commentaire_refus_visa'];
          $vo_destination_famille_chk=$data_dossier['vo_destination_famille_chk'];
          $vo_destination_comment=$data_dossier['vo_destination_comment'];
          $pc_qualite_garant=($data_dossier['pc_qualite_garant']!="") ? $data_dossier['pc_qualite_garant'] : $data_dossier['qualite_parain_autre'];
          $qualite_parain_autre=$data_dossier['qualite_parain_autre'];
          $pc_lieu_travail_garant=$data_dossier['pc_lieu_travail_garant'];
          $pc_salaire_parrain=$data_dossier['pc_salaire_parrain'];
          $pc_activite_pro_chk=$data_dossier['pc_activite_pro_chk'];
          $pc_activite_pro_nom=$data_dossier['pc_activite_pro_nom'];
          $pc_revenu_parrain=$data_dossier['pc_revenu_parrain'];
          $pc_nbre_parcelle=$data_dossier['pc_nbre_parcelle'];
          $pc_nbre_vehicule=$data_dossier['pc_nbre_vehicule'];
          $email=$data_dossier['email'];
          $ref_agence=$data_dossier['ref_agence']; 



        //$_SESSION['m_profile']=$edit;
    } else {

        // header("Location: home.php?error=ok&msg=Ce Profile n'existe pas, vous n'etes pas autorise à la page suivante");				
    }
}

if ($_SESSION['my_m_dossier'] != "NA") {

    $edit = $_SESSION['my_m_dossier'];

    $data_dossier = get_dossier_data($edit);
//					echo $edit;
    if ($data_dossier['is_exist'] == 1) {
        $_SESSION['my_m_dossier'] = $edit;

        /* $identite=$data_dossier['identite'];
          $date_naissance=$data_dossier['date_naissance'];
          $telephone=$data_dossier['telephone'];
          $lieu_naissance=$data_dossier['lieu_naissance'];
          $nbre_enfant_famille=$data_dossier['nbre_enfant_famille'];
          $position_dans_famille=$data_dossier['position_dans_famille'];
          $numero_passport=$data_dossier['numero_passport'];
          $date_expiration_pp=$data_dossier['date_expiration_pp'];
          $ref_agence=$data_dossier['ref_agence'];
          $promoteur_agence=$data_dossier['promoteur_agence'];
          $activite_passe_actuelle=$data_dossier['activite_passe_actuelle'];
          $vo_destination=$data_dossier['vo_destination'];
          $vo_raison_voyage=$data_dossier['vo_raison_voyage'];
          $vo_charge_etude_parrain=$data_dossier['vo_charge_etude_parrain'];
          $vo_ancien_visa=$data_dossier['vo_ancien_visa'];
          $vo_ancien_visa_comment=$data_dossier['vo_ancien_visa_comment'];
          $vo_refus_visa_chk=$data_dossier['vo_refus_visa_chk'];
          $commentaire_refus_visa=$data_dossier['commentaire_refus_visa'];
          $vo_destination_famille_chk=$data_dossier['vo_destination_famille_chk'];
          $vo_destination_comment=$data_dossier['vo_destination_comment'];
          $pc_qualite_garant=($data_dossier['pc_qualite_garant']!="") ? $data_dossier['pc_qualite_garant'] : $data_dossier['qualite_parain_autre'];
          $qualite_parain_autre=$data_dossier['qualite_parain_autre'];
          $pc_lieu_travail_garant=$data_dossier['pc_lieu_travail_garant'];
          $pc_salaire_parrain=$data_dossier['pc_salaire_parrain'];
          $pc_activite_pro_chk=$data_dossier['pc_activite_pro_chk'];
          $pc_activite_pro_nom=$data_dossier['pc_activite_pro_nom'];
          $pc_revenu_parrain=$data_dossier['pc_revenu_parrain'];
          $pc_nbre_parcelle=$data_dossier['pc_nbre_parcelle'];
          $pc_nbre_vehicule=$data_dossier['pc_nbre_vehicule'];
          $email=$data_dossier['email'];
          $ref_agence=$data_dossier['ref_agence']; 
    } else {


        header("Location: home.php?error=ok&msg=Ce Profile n'existe pas, vous n'etes pas autorise à la page suivante");
    }
}
*/
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

$get_active_menu = "dossier";
$page_titre = "Journal Historique Interne : " . $data_dossier['identite'] . " NID : " . $data_dossier['nid_pp'];
$page_small_detail = "MyPASS";
$page_location = "Gestion Dossiers > Journal Historique Interne";
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
<?php ?>
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
<?php include_once("php/print_message.php"); ?>
        <!-- Your Page Content Here -->

        <div id="light" class="white_content">
            <a onClick="hide_pop()" class="btn-danger"><i class="fa  fa-close">Fermer Ici</i></a>
            <?php include_once("vue_white_popup_zone.php"); ?>
        </div>
        <div id="fade" class="black_overlay"></div>    
        <!-- Horizontal Form -->
        <?php include_once("zone_bouton_dossier.php"); ?>
        <form class="form-horizontal" action="#"  method="post">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Historique Timeline du Dossier : <?php echo $data_dossier['identite']." | NID = ".$data_dossier['ndel']; ?></h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>


                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                <div class="box-body" style="overflow-y: auto;height: 700px;">
                    <ul class="timeline" >
 <?php
                        $sql_select1 = "SELECT t.*, label_icone, t_operation.label as operation FROM passport_bd.t_actions t join t_operation on ref_operation=idt_operation where ref_dossier=" . $_SESSION['my_m_dossier'] . "  order by idt_actions desc";
                        //echo $sql_select1;

                        $sql_result1 = $bdd->query($sql_select1);

                        $index2 = 0;

                        while ($data1 = $sql_result1->fetch()) {
                            $index2++;
                            ?>
                   

                        <!-- timeline time label -->
                        <li class="time-label">
                            <span class="bg-red">
                                <?php echo $data1['creationdate']; ?>
                            </span>
                        </li>
                        <!-- /.timeline-label -->

                        <!-- timeline item -->
                        <li>
                            <!-- timeline icon -->
                            <i class="fa <?php echo $data1['label_icone']; ?>"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> -</span>

                                <h3 class="timeline-header"><a href="#"><?php echo $data1['operation']." par ";echo ($data1['ref_requester']=="online_user") ? $data_dossier['identite']: $data1['ref_requester']; ?></a> <?php echo ""; ?></h3>

                                <div class="timeline-body">
                                    <?php echo $data1['commentaire']; ?>
                                </div>

                                <div class="timeline-footer">
                                    Notification : <?php echo ($data1['notification_sms']=="1") ? '<i class="fa fa-wechat bg-blue">SMS</i>' : ''; 
                                    echo ($data1['notification_email']=="1") ? '<i class="fa fa-envelope bg-green">Mail</i>' : '';  echo ($data1['notification_appel']=="1") ? '<i class="fa fa-phone bg-red">Appel</i>' : ''; ?>
                                </div>
                            </div>
                        </li>
                        <!-- END timeline item -->

                       

                    
                    <?php
                        }
                        ?>
                        </ul>



                </div><!-- /.box-body -->
                <div class="box-footer">

                    
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
                                            
                      <th>Date creation</th>
                      <th>Initiateur</th>
                      <th>Commentaire</th>
                      <th>Operation</th>
                      <th>Notification</th>
                      <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
		$sql_select1 = "SELECT t.*, label_icone, t_operation.label as operation FROM passport_bd.t_actions t join t_operation on ref_operation=idt_operation where ref_dossier=" . $_SESSION['my_m_dossier'] . " order by idt_actions desc";
                       //echo $sql_select1;
		
		$sql_result1 = $bdd->query($sql_select1);
		
  $index=0;

		  while($data1 = $sql_result1->fetch()){
		  
		   
		  		
		  	?>	
                      <tr>
                      <td><?php	echo $data1['creationdate'];?></td>                      
                      <td><?php	echo ($data1['ref_requester']=="online_user") ? $data_dossier['identite']: $data1['ref_requester'];?></td>
                      <td><?php	echo $data1['commentaire'];?></td>
                      <td><?php	echo $data1['operation'];?></td>
                      <td><?php echo ($data1['notification_sms']=="1") ? '<i class="fa fa-wechat bg-blue">SMS</i>' : ''; 
                                    echo ($data1['notification_email']=="1") ? '<i class="fa fa-envelope bg-green">Mail</i>' : '';  echo ($data1['notification_appel']=="1") ? '<i class="fa fa-phone bg-red">Appel</i>' : ''; ?>
                                          
                      </td>
                      <td>
                      <?php 
	
						if(get_access(18,$_SESSION['my_idprofile'])==1){
	
                         ?>
                          <a href="journal_interne.php?del=<?php echo $data1['idt_actions']; ?>" onClick="return confirm('Cette action va supprimer ce commentaire definitivement, Veuillez confirmer?')" ><i class="fa  fa-cut"></i> </a>

                           
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
