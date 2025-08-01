<?php
	//******************IDPAGE*****************

	//Session check****************************
	
        session_start();
	include_once("php/function.php");
	$error="no";
$warning="no";
$success="no";
$information="no";

$error_message="Error on the page Errorcode=xx001Defaults";
$warning_message="This is a warning";
$success_message="Your request succeed";
$information_message="Welcome in Web-sms";
	//********************locally Additionnal Function*************
	
	//****************location******************
$set_pluggin_selection_wise="yes";
$requirement_datatable="yes";
$get_active_menu="dossier_online";
	$page_titre="Formulaire de Renseignement VISA Etude";
	$page_small_detail="1ère PARTIE : RENSEIGNEMENTS";
	$page_location="Formulaire de Renseignement VISA Etude";
	
	//*************************************************************
	
	if(!isset($_POST['submit_privacy'])){
	
	//header("Location:privacy_page.php");
		
	}	
	
	
	if(isset($_POST['submit_dossier'])){
		
$identite= clean_in_text($_POST['identite']);
$date_naissance= clean_in_text($_POST['date_naissance']);
$telephone=str_ireplace(' ','',str_ireplace('-','',str_ireplace(')','',str_ireplace('(','', clean_in_text($_POST['telephone'])))));
$lieu_naissance= clean_in_text($_POST['lieu_naissance']);
$nbre_enfant_famille= clean_in_text($_POST['nbre_enfant_famille']);
$position_dans_famille= clean_in_text($_POST['position_dans_famille']);
$numero_passport= clean_in_text($_POST['numero_passport']);
$date_expiration_pp= clean_in_text($_POST['date_expiration_pp']);
$ref_agence= clean_in_text($_POST['ref_agence']);
$promoteur_agence= clean_in_text($_POST['promoteur_agence']);
$activite_passe_actuelle= clean_in_text($_POST['activite_passe_actuelle']);
$vo_destination= clean_in_text($_POST['vo_destination']);
$vo_raison_voyage= clean_in_text($_POST['vo_raison_voyage']);
$vo_charge_etude_parrain= clean_in_text($_POST['vo_charge_etude_parrain']);
$vo_ancien_visa= (isset($_POST['vo_ancien_visa'])) ? clean_in_text($_POST['vo_ancien_visa']) :  "";
$vo_ancien_visa_comment= clean_in_text($_POST['vo_ancien_visa_comment']);
$vo_refus_visa_chk= isset($_POST['vo_refus_visa_chk']) ? clean_in_text($_POST['vo_refus_visa_chk']) : "";
$commentaire_refus_visa= clean_in_text($_POST['commentaire_refus_visa']);
$vo_destination_famille_chk= isset($_POST['vo_destination_famille_chk']) ? clean_in_text($_POST['vo_destination_famille_chk']) : "";
$vo_destination_comment= clean_in_text($_POST['vo_destination_comment']);
$pc_qualite_garant=( clean_in_text($_POST['pc_qualite_garant'])!="") ?  clean_in_text($_POST['pc_qualite_garant']) :  clean_in_text($_POST['qualite_parain_autre']);
$qualite_parain_autre= clean_in_text($_POST['qualite_parain_autre']);
$pc_lieu_travail_garant= clean_in_text($_POST['pc_lieu_travail_garant']);
$pc_salaire_parrain= clean_in_text($_POST['pc_salaire_parrain']);
$pc_activite_pro_chk= isset($_POST['pc_activite_pro_chk']) ? clean_in_text($_POST['pc_activite_pro_chk']) : "";
$pc_activite_pro_nom= clean_in_text($_POST['pc_activite_pro_nom']);
$pc_revenu_parrain= clean_in_text($_POST['pc_revenu_parrain']);
$pc_nbre_parcelle= clean_in_text($_POST['pc_nbre_parcelle']);
$pc_nbre_vehicule= clean_in_text($_POST['pc_nbre_vehicule']);
$email= clean_in_text($_POST['email']);
$pin_secret= clean_in_text($_POST['pin_secret']);
$commentaire_client= isset($_POST['commentaire_client']) ? clean_in_text($_POST['commentaire_client']) : "";
$identite_pere=clean_in_text($_POST['identite_pere']);
$lieu_naissance_pere=clean_in_text($_POST['lieu_naissance_pere']);
$date_naissance_pere=($identite_pere=="") ? "" : clean_in_text($_POST['date_naissance_pere']);
$identite_mere=clean_in_text($_POST['identite_mere']);
$lieu_naissance_mere=clean_in_text($_POST['lieu_naissance_mere']);
$date_naissance_mere=($identite_mere=="") ? "" : clean_in_text($_POST['date_naissance_mere']);



$ndel=date('mdHis');
//$pin_secret=rand(10000,99999);
$feedback_dossier=add_dossier('',$ndel,$identite,$lieu_naissance,$date_naissance,$email,$nbre_enfant_famille,$position_dans_famille,$numero_passport,$date_expiration_pp,$activite_passe_actuelle,$vo_destination,$vo_raison_voyage,$vo_charge_etude_parrain,$vo_ancien_visa,$vo_ancien_visa_comment,$telephone,$vo_refus_visa_chk,$commentaire_refus_visa,$vo_destination_famille_chk,$vo_destination_comment,$pc_qualite_garant,$pc_lieu_travail_garant,$pc_salaire_parrain,$pc_activite_pro_chk,$pc_activite_pro_nom,$pc_revenu_parrain,$pc_nbre_parcelle,$pc_nbre_vehicule,"Creer_en_ligne",$promoteur_agence,$ref_agence,$pin_secret,"online_user",$commentaire_client,$identite_pere,$lieu_naissance_pere,$date_naissance_pere,$identite_mere,$lieu_naissance_mere,$date_naissance_mere);

$success="yes";

$feedback_exetat=0;

		
		if($feedback_dossier==1){
			$data_dossier=get_dossier_data_by_ndel($ndel);
			$success_message="Dossier en Ligne créé avec succès  <br>";
			add_action_no_request($data_dossier['idt_dossier'],7,'Valider','online_user','Oui','Ajout Dossier en Ligne');
			// Envoi EMAIL
                        
                        $to_destination=$email;
                        $sujet="Dossier_Voyage_Creer";
                       include_once("sendmail_test.php");
                        
			if($_POST['exetat_annee']!="" && $_POST['ecole_frequenter']!="" && $_POST['option']!=""  && $_POST['pourcentage']!=""  && $_POST['ville_obtention']!=""){
				
				$feedback_exetat=add_dossier_etude($data_dossier['idt_dossier'],$_POST['exetat_annee'],$_POST['ecole_frequenter'],$_POST['option'],"EXETAT",$_POST['pourcentage'],"EXETAT",'',$_POST['ville_obtention'],$_POST['pays'],"online_user");
				
				$success_message=($feedback_exetat==1) ? $success_message."-> Exetat créé avec succès : " : $success_message."-> Exetat non créé";
				
				$url_fichier="";
				$is_file_transafered=0;
				$type_fichier="";
                                //echo "je suiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiis la : ".$feedback_exetat;
				if(isset($_FILES['exetat_file']) && $_FILES['exetat_file']['name']!='' && $feedback_exetat==1){
								//echo "je suiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiis la";
								$value=explode(".",$_FILES['exetat_file']['name']);
								$type_fichier=$value[1];
								$url_initial="uploads/".$ndel."_exetat_".date('s').".".$value[1];
								$download_file=move_uploaded_file($_FILES['exetat_file']['tmp_name'],$url_initial);
								$url_fichier=($download_file==1) ? $url_initial : $url_fichier;
								$is_file_transafered=($download_file==1) ? 1 : 0;
								$success_message=$success_message." | -- Fichier Exetat ajouté";
							
							}
				
				$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,'EXETAT') : 0;
				
				$success_message=($add_document==1) ? $success_message." | - Document ajouté : ".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : Exetat') : $success_message." | - Erreur Ajout Document Exetat  ";
				
				
							
				}
                                //  Enregistrement données SECONDAIRE
                                for($i=1;$i<=3;$i++){
					
						if($_POST['exetat_annee_sec'.$i]!="" && $_POST['ecole_frequenter_sec'.$i]!="" && $_POST['option_sec'.$i]!="" && $_POST['niveau_sec'.$i]!="" && $_POST['pourcentage_sec'.$i]!=""){
							
									$feedback_exetat=add_dossier_etude($data_dossier['idt_dossier'],$_POST['exetat_annee_sec'.$i],$_POST['ecole_frequenter_sec'.$i],$_POST['option_sec'.$i],$_POST['niveau_sec'.$i],$_POST['pourcentage_sec'.$i],'SECONDAIRE','','','',"online_user");
									
									$success_message=($feedback_exetat==1) ? $success_message."<br>".$i."-> ".$_POST['niveau_sec'.$i]." créé avec succès" : "<br>".$i."-> ".$_POST['niveau_sec'.$i]." non crée";
									
									$url_fichier="";
									$is_file_transafered=0;
									$type_fichier="";
									if(isset($_FILES['diplome_file_sec'.$i]) && $_FILES['diplome_file_sec'.$i]['name']!='' && $feedback_exetat==1){
													
													$value=explode(".",$_FILES['diplome_file_sec'.$i]['name']);
													$type_fichier=$value[1];
													$url_initial="uploads/".$ndel."_doc_".date('s').$i.".".$value[1];
													$download_file=move_uploaded_file($_FILES['diplome_file_sec'.$i]['tmp_name'],$url_initial);
													$url_fichier=($download_file==1) ? $url_initial : $url_fichier;
													$is_file_transafered=($download_file==1) ? 1 : 0;
													$success_message=$success_message." | -- Fichier Sec ajouté";
												
												}
									
									$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,$_POST['niveau_sec'.$i]) : 0;
									
									$success_message=($add_document==1) ? $success_message." | - Document ajouté".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : '.$_POST['niveau_sec'.$i]) : $success_message." | - Erreur Ajout Document";
									
									
									
										
							
							
							}
					
					}
                                
                                //  Enregistrement données POST SECONDAIRE
				for($i=1;$i<=7;$i++){
					
						if($_POST['exetat_annee'.$i]!="" && $_POST['ecole_frequenter'.$i]!="" && $_POST['option'.$i]!="" && $_POST['niveau'.$i]!="" && $_POST['pourcentage'.$i]!="" && $_POST['diplome'.$i]!=""){
							
									$feedback_exetat=add_dossier_etude($data_dossier['idt_dossier'],$_POST['exetat_annee'.$i],$_POST['ecole_frequenter'.$i],$_POST['option'.$i],$_POST['niveau'.$i],$_POST['pourcentage'.$i],$_POST['diplome'.$i],'','','',"online_user");
									
									$success_message=($feedback_exetat==1) ? $success_message."<br>".$i."-> ".$_POST['diplome'.$i]." créé avec succès" : "<br>".$i."-> ".$_POST['diplome'.$i]." non crée";
									
									$url_fichier="";
									$is_file_transafered=0;
									$type_fichier="";
									if(isset($_FILES['diplome_file'.$i]) && $_FILES['diplome_file'.$i]['name']!='' && $feedback_exetat==1){
													
													$value=explode(".",$_FILES['diplome_file'.$i]['name']);
													$type_fichier=$value[1];
													$url_initial="uploads/".$ndel."_doc2_".date('s').$i.".".$value[1];
													$download_file=move_uploaded_file($_FILES['diplome_file'.$i]['tmp_name'],$url_initial);
													$url_fichier=($download_file==1) ? $url_initial : $url_fichier;
													$is_file_transafered=($download_file==1) ? 1 : 0;
													$success_message=$success_message." | -- Fichier Post-secondaire ajouté";
												
												}
									
									$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,$_POST['niveau'.$i]) : 0;
									
									$success_message=($add_document==1) ? $success_message." | - Document ajouté".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : '.$_POST['niveau'.$i]) : $success_message." | - Erreur Ajout Document";
									
									
									
										
							
							
							}
					
					}
                                    
                                    if(isset($_FILES['cv_file']) && $_FILES['cv_file']['name']!=''){
                                        
                                    if(isset($_FILES['cv_file']) && $_FILES['cv_file']['name']!=''){
								
								$value=explode(".",$_FILES['cv_file']['name']);
								$type_fichier=$value[1];
								$url_initial="uploads/".$ndel."_CV_".date('s').".".$value[1];
								$download_file=move_uploaded_file($_FILES['cv_file']['tmp_name'],$url_initial);
								$url_fichier=($download_file==1) ? $url_initial : $url_fichier;
								$is_file_transafered=($download_file==1) ? 1 : 0;
								$success_message=$success_message." | -- Fichier CV ajouté";
							
							}
				
				$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,'CV') : 0;
				
				$success_message=($add_document==1) ? $success_message." | - Document ajouté : ".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : CV') : " | - Erreur Ajout Document";
				
				
							
				}
                                
                                if(isset($_FILES['passeport_file']) && $_FILES['passeport_file']['name']!=''){
                                        
                                    if(isset($_FILES['passeport_file']) && $_FILES['passeport_file']['name']!=''){
								
								$value=explode(".",$_FILES['passeport_file']['name']);
								$type_fichier=$value[1];
								$url_initial="uploads/".$ndel."_passeport_".date('s').".".$value[1];
								$download_file=move_uploaded_file($_FILES['passeport_file']['tmp_name'],$url_initial);
								$url_fichier=($download_file==1) ? $url_initial : $url_fichier;
								$is_file_transafered=($download_file==1) ? 1 : 0;
								$success_message=$success_message." | -- Fichier Passeport ajouté";
							
							}
				
				$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,'Passeport') : 0;
				
				$success_message=($add_document==1) ? $success_message." | - Document ajouté : ".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : Passeport') : " | - Erreur Ajout Document";
				
				
							
				}
                                
                                if(isset($_FILES['attestaion_file']) && $_FILES['attestaion_file']['name']!=''){
                                        
                                    if(isset($_FILES['attestaion_file']) && $_FILES['attestaion_file']['name']!=''){
								
								$value=explode(".",$_FILES['attestaion_file']['name']);
								$type_fichier=$value[1];
								$url_initial="uploads/".$ndel."_Attestation_".date('s').".".$value[1];
								$download_file=move_uploaded_file($_FILES['attestaion_file']['tmp_name'],$url_initial);
								$url_fichier=($download_file==1) ? $url_initial : $url_fichier;
								$is_file_transafered=($download_file==1) ? 1 : 0;
								$success_message=$success_message." | -- Fichier Acte Naissance ajouté";
							
							}
				
				$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,'Acte de naissance') : 0;
				
				$success_message=($add_document==1) ? $success_message." | - Document ajouté : ".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : Acte de naissance') : " | - Erreur Ajout Document";
				
				
							
				}
					
					
					//header("Location:print_manifeste.php?val_ndel=".$ndel);			
			
			}else{
				$error="yes";
				$error_message="Une erreur a survenu lors de la creation de dossier";
				
				
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
		include_once("php/header_online.php");

	?>
    <?php	?>
          <!-- Sidebar Menu -->
    <?php
		include_once("php/main_menu_online.php");

	?>
         
         <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
         <h1>
            <?php echo $page_titre;	?>
            <small><?php echo $page_small_detail;?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="home.php?close=ok"><i class="fa  fa-close"></i></a><a href="home.php"><i class="fa fa-dashboard"></i>MyPassport |</a>Où suis-je</li>
            <li class="active"><?php echo $page_location;	?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
<?php  include_once("php/print_message.php"); ?>
          <!-- Your Page Content Here -->
 <!-- Horizontal Form -->
 <a href="https://passportsarl.voyage" target="_blank"><img  src="images/logo_passport.png" width="212" height="171" /></a>
<form action="dossier_online.php"  method="post" enctype="multipart/form-data">
<h3 class="box-title">NDEL : <?php  echo date('mdHis'); ?></h3>

 <div class="box box-info">
     
  <div class="box-header with-border" id="section1">
                  <h3 class="box-title">1. IDENTITE DU CLIENT</h3>
                  <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <a href="#section_validation" class="btn btn-info pull-right" ><i class="fa  fa-arrow-right">ENREGISTRER POUR CONTINUER PLUS TARD</i></a>

              </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Nom complet (tel que dans le passport) <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="identite"  placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans le Passeport" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Lieu de naissance <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="lieu_naissance"  placeholder="Où êtes-vous né(e)?" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Date de naissance <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" name="date_naissance" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" value="1950/12/12" data-mask placeholder="Entrez votre date de naissance Année-Mois-Jour" required>
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Numéro Passeport </label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="numero_passport"  placeholder="Entrez votre numero de passport ici" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Date d'expiration Passeport </label>
                      <div class="col-sm-6">
                        <input type="text" name="date_expiration_pp" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask placeholder="Entrez votre date d'expiration de votre passeport Jour-Mois-Année" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Email <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" name="email" class="form-control" placeholder="Entrez votre adresse email" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Téléphone (commencez avec le code du pays 243 ou 33) <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" data-inputmask='"mask": "(999) 99-999-9999"' data-mask name="telephone" required>
                      </div>
                    </div>
                     <div class="form-group">
                      <label  class="col-sm-6 control-label">Comment avez-vous connu notre agence ?<font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                          <input type="text" name="promoteur_agence" class="form-control"  placeholder="Merci de donner tous les détails SVP. (Max 100 caractères)" required="true" size="100">
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Nom complet de votre père biologique (tel que dans votre acte de naissance) </label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="identite_pere"  placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans votre acte de naissance" >
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Lieu de naissance de votre père </label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="lieu_naissance_pere"  placeholder="Entrez le lieu de naissance" >
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Date de naissance de votre père </label>
                      <div class="col-sm-6">
                          <input type="text" name="date_naissance_pere" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'"  data-mask placeholder="Entrez la date de naissance de votre pere Année-Mois-Jour" >
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Nom complet de votre mère biologique (tel que dans votre acte de naissance) </label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="identite_mere"  placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans votre acte de naissance" >
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Lieu de naissance de votre mère </label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="lieu_naissance_mere"  placeholder="Entrez le lieu de naissance" >
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Date de naissance de votre mère </label>
                      <div class="col-sm-6">
                        <input type="text" name="date_naissance_mere" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'"  data-mask placeholder="Entrez la date de naissance de votre mère Année-Mois-Jour" >
                      </div>
                    </div>
                      
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Vous êtes issue d'une famille de combien d'enfants</label>
                      <div class="col-sm-6">
                       <select name="nbre_enfant_famille" class="form-control select2">
                       <?php  for($i=0;$i<40;$i++){ ?>
                       <option value="<?php  echo $i; ?>"><?php  echo $i; ?></option>
                       <?php  } ?>
                       </select>
                       
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Vous êtes quantième enfant dans la famille?</label>
                      <div class="col-sm-6">
                       <select class="form-control select2" name="position_dans_famille">
                       <?php  for($i=0;$i<40;$i++){ ?>
                       <option value="<?php  echo $i; ?>"><?php  echo $i; ?></option>
                       <?php  } ?>
                       </select>
                      </div>
                    </div>
                    
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Où voulez-vous partir? <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <select name="vo_destination" class="form-control select2">
                                              <?php  get_combo_liste_pays(); ?>
                       </select>
                      </div>
                    </div>
                      <div class="form-group">
                        <label  class="col-sm-6 control-label">Attachez une copie de votre Passeport</label>
                        <div class="col-sm-6">
                            <input name="passeport_file" type="file" accept=".jpeg,.jpg,.png,.pdf,.docx,.doc" ><p class="help-block">Attachez votre Passeport ici</p>
                        </div>
                    </div>
                      
                      
                      <div class="form-group">
                        <label  class="col-sm-6 control-label">Attachez votre acte de naissance</label>
                        <div class="col-sm-6">
                            <input name="attestaion_file" type="file" accept=".jpeg,.jpg,.png,.pdf,.docx,.doc" > <p class="help-block">Par Acte de Naissance, nous entendons l'un ou tous les documents suivants : Copie intégrale d'acte de naissance, Extrait d'acte de naissance ou Acte de Naissance tout court. L'attestation de naissance ou la fiche individuelle ne seront acceptées que provisoirement et perdront leur valeur chez nous après trois semaines de leur soumission</p>
                        </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">A quel bureau voulez-vous suivre le dossier ?</label>
                      <div class="col-sm-6">
                        <select name="ref_agence" class="form-control select2">
                       
                       <?php  echo getcombo_agence(0); ?>
                       </select>
                      </div>
                    </div>
                      <br><font color="#FF0000">----------------------------------------------------------------------------------------------------------------</font><br>
                    
                    
                    <div class="form-group">
                        <label  class="col-sm-6 control-label"><font color="#FF0000">PIN SECRET (*)------->></font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="pin_secret"  placeholder="Remplissez le PIN Secret pour le Client" value="<?php echo rand(10000,99999); ?>" readonly="true" >
                        </div>
                    </div>
                    <div class="form-group">
                       <label  class="col-sm-6 control-label"><font color="#FF0000">Autre chose à nous informer? Merci de le mentionner ici (Max 200 caractères)--> </font></label>
                      <div class="col-sm-6">
                      <textarea name="commentaire_client" cols="100%" rows="3" class="form-control"></textarea>
                        
                      </div>
                    </div>                
                    
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <i class="fa fa-warning">Important à savoir</i><br>
                    <font color="#FF0000">*</font> : Champs conditionnés par un remplissage obligatoire<br>
                    
                    <!-- /.box-body -->
                    <a href="#section2" class="btn btn-adn left" ><i class="fa  fa-arrow-right">Suivant</i></a>
                    
                    
                  
                  </div><!-- /.box-footer -->
               
              </div>
              <!-- /.box -->
              <div class="box box-info" id="section2">
              <div class="box-header with-border">
  					 <h3 class="box-title">2. PARCOURS D'ETUDES</h3>
                                         <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                

              </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                    <br><?php  $actual_year=clean_in_integer(date("Y")); //echo $actual_year; ?>
                  <h5>2.1. Votre Parcours Secondaire (Les 3 dernieres années seulement)</h5>
                  <table class="table table-condensed">
                    <tr>
                      <th>#</th>
                      <th>Année d'obtention</th>
                      <th>Etablissement Frequenté</th>
                      <th>Option</th>
                      <th>Classe</th>
                      <th>Résultats</th>  
                        
                      <th>Joindre le document</th>                   
                      
                    </tr>
                     <?php 
		
		 			for($i=1;$i<=3;$i++){
		 			//	echo $i;
		  	?>	
                    <tr>
                      <td><?php	echo $i;?></td>
                      <td width="10%"><select name="exetat_annee_sec<?php echo $i;?>" class="form-control select2" >
                       <?php  for($j=$actual_year;$j>1975;$j--){ ?>
                       <option value=""></option>       
                       <option value="<?php  echo $j; ?>"><?php  echo $j; ?></option>
                       <?php  } ?>
                       </select>
                       </td>
                      <td><input type="text" class="form-control" name="ecole_frequenter_sec<?php  echo $i; ?>" ></td>
                      <td><input type="text" class="form-control" name="option_sec<?php  echo $i; ?>"></td>
                      <td><input type="text" class="form-control" name="niveau_sec<?php  echo $i; ?>"  placeholder="Ex : 6eme, 5eme ou 4eme" value="<?php  echo (7-$i)."eme"; ?>"></td>                      
                      <td><input type="text" class="form-control" name="pourcentage_sec<?php  echo $i; ?>" ></td> 
                     
                      <td><input name="diplome_file_sec<?php  echo $i; ?>" type="file" accept=".jpeg,.jpg,.png,.pdf"></td>                   
                      
                    </tr>
                    
               <?php  
					}
				?>	    
                  </table>
                    <h5>2.2. Diplome d'Etat ou son équivalent</h5>
                    <table class="table table-condensed">
                    <tr>
                      <th></th>
                      <th>Année d'obtention</th>
                      <th>Ecole fréquentée</th>
                      <th>Option</th>
                      <th>Pourcentage</th>
                      <th>Pays d'obtention</th>  
                      <th>Ville d'obtention</th>
                      <th>Joindre un fichier</th>                      
                      
                    </tr>
                     
                    <tr>
                      <td></td>
                      <td>
					  <select name="exetat_annee" class="form-control select2">
                       
                       <?php  for($i=$actual_year;$i>1975;$i--){ ?>
                                              <option value=""></option>   
                       <option value="<?php  echo $i; ?>"><?php  echo $i; ?></option>
                       <?php  } ?>
                       </select>
                      </td>
                      <td><input type="text" class="form-control" name="ecole_frequenter" ></td>
                      <td><input type="text" class="form-control" name="option" ></td>
                      <td><input type="text" class="form-control" name="pourcentage" ></td>                      
                      <td><select name="pays" class="form-control select2">
                       
                       <?php  include("php/list_pays.php"); ?>
                       </select></td>  
                       <td><input type="text" class="form-control" name="ville_obtention"></td>
                       <td><input name="exetat_file" type="file" accept=".jpeg,.jpg,.png,.pdf"></td>
                                          
                     </tr>
                   
                  </table>
                  <br>
                  <h5>2.3. Votre parcours post-secondaire (Remplir par l'année la plus recente)</h5>
                  <table class="table table-condensed">
                    <tr>
                      <th>#</th>
                      <th>Année d'obtention</th>
                      <th>Etablissement Frequenté</th>
                      <th>Intitulé de la formation</th>
                      <th>Niveau d'étude</th>
                      <th>Résultats</th>  
                      <th>Diplome Obtenu <br>ou Attestation <br>ou Rélévé</th>  
                      <th>Joindre le document</th>                   
                      
                    </tr>
                     <?php 
		
		 			for($i=1;$i<=10;$i++){
		 			//	echo $i;
		  	?>	
                    <tr>
                      <td><?php	echo $i;?></td>
                      <td width="10%"><select name="exetat_annee<?php echo $i;?>" class="form-control select2" >
                       <?php  for($j=$actual_year;$j>1975;$j--){ ?>
                              <option value=""></option>   
                       <option value="<?php  echo $j; ?>"><?php  echo $j; ?></option>
                       <?php  } ?>
                       </select>
                       </td>
                      <td><input type="text" class="form-control" name="ecole_frequenter<?php  echo $i; ?>" ></td>
                      <td><input type="text" class="form-control" name="option<?php  echo $i; ?>"></td>
                      <td><input type="text" class="form-control" name="niveau<?php  echo $i; ?>"  placeholder="Ex : G1,L1,D1,DEA,PHD, etc"></td>                      
                      <td><input type="text" class="form-control" name="pourcentage<?php  echo $i; ?>" ></td> 
                      <td><input type="text" class="form-control" name="diplome<?php  echo $i; ?>" ></td> 
                       <td><input name="diplome_file<?php  echo $i; ?>" type="file" accept=".jpeg,.jpg,.png,.pdf"></td>                   
                      
                    </tr>
                    
               <?php  
					}
				?>	    
                  </table>
                    
                    
                    
                   
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <i class="fa fa-warning">Important à savoir</i><br>
                    <font color="#FF0000">*</font> : Tous les champs d'une ligne doivent etre rempli que la ligne soit enrégistrer.<br>
                    <a href="#section1" class="btn btn-adn left" ><i class="fa  fa-arrow-left">Précedent</i></a>
                    <a href="#section3" class="btn btn-adn left" ><i class="fa  fa-arrow-right">Suivant</i></a>
                    
                  </div><!-- /.box-footer -->
               
              </div>
              
              <div class="box box-info" id="section3">
  <div class="box-header with-border">
                  <h3 class="box-title">3. ACTIVITES PASSEES ET ACTUELLES</h3>
                  <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                

              </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                  Parlez-nous de vos activités antérieures (emplois, professions, stages académiques / professionnels ou autres formations pertinentes ainsi que les mois et les années du début et de la fin. si applicable. N'hésitez pas d'être explicite)
                    <div class="form-group">
                      
                      <div class="col-sm-12">
                      <textarea name="activite_passe_actuelle" cols="100%" rows="2" class="form-control"></textarea>
                        
                      </div>
                    </div>
                  
                  <div class="form-group">
                        <label  class="col-sm-6 control-label">Attachez votre CV </label>
                        <div class="col-sm-6">
                            <input name="cv_file" type="file" accept=".jpeg,.jpg,.png,.pdf,.docx,.doc"><p class="help-block">En format modifiable</p>
                        </div>
                    </div>
                    
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <i class="fa fa-warning">Important à savoir</i><br>
                    <a href="#section2" class="btn btn-adn left" ><i class="fa  fa-arrow-left">Précedent</i></a>
                    <a href="#section4" class="btn btn-adn left" ><i class="fa  fa-arrow-right">Suivant</i></a>
                    
                    
                  </div><!-- /.box-footer -->
               
              </div>
              <div class="box box-info" id="section4">
  <div class="box-header with-border">
                  <h3 class="box-title">4. VOYAGE</h3>
                  <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                

              </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                    
                    
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Raison du voyage</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="vo_raison_voyage"  placeholder="C'est quoi la raison de votre voyage?">
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Si pour études, qui prendra en charge ces études?</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="vo_charge_etude_parrain"  placeholder="Le nom au complet du parain de vos études (tel que repris dans sa pièce d'identité)">
                       
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Avez-vous une famille à votre lieu de destination?</label>
                      <div class="col-sm-1">
                       <input name="vo_destination_famille_chk" type="checkbox" value="oui" onchange="document.getElementById('famille_destination').readOnly = !this.checked;"> 
                      </div>
                      <label  class="col-sm-5 control-label">Cochez pour Oui et décochez pour Non</label>
                      
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Si Oui, précisez le lien de parenté</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="vo_destination_comment" id="famille_destination"  placeholder="Précisez il s'agit de qui et sa qualité pour vous" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Avez-vous des anciens Visa?</label>
                      <div class="col-sm-1">
                       <input name="vo_ancien_visa" type="checkbox" value="oui" onchange="document.getElementById('oui_visa').readOnly = !this.checked;"> 
                      </div>
                      <label  class="col-sm-5 control-label">Cochez pour Oui et décochez pour Non</label>
                      
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Si Oui, précisez les pays</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="vo_ancien_visa_comment" id="oui_visa"  placeholder="Listez vos anciens visa" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Avez-vous déjà eu un refus de Visa?</label>
                      <div class="col-sm-1">
                       <input name="vo_refus_visa_chk" type="checkbox" value="oui" onchange="document.getElementById('refus_visa').readOnly = !this.checked;"> 
                      </div>
                      <label  class="col-sm-5 control-label">Cochez pour Oui et décochez pour Non</label>
                      
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Si Oui, précisez vos anciens refus</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="commentaire_refus_visa" id="refus_visa"  placeholder="Si Oui, précisez vos anciens refus" readonly>
                      </div>
                    </div>
                    
                    
                    
                    
                    
                   
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <i class="fa fa-warning">Important à savoir</i><br>
                    
                    <font color="#FF0000">*</font> : Champs conditionnés par un remplissage obligatoire<br>
                    <a href="#section3" class="btn btn-adn left" ><i class="fa  fa-arrow-left">Précedent</i></a>
                    <a href="#section5" class="btn btn-adn left" ><i class="fa  fa-arrow-right">Suivant</i></a>
                    
                  </div><!-- /.box-footer -->
               
              </div>
              <div class="box box-info" id="section5">
  <div class="box-header with-border">
                  <h3 class="box-title">5. PRISE EN CHARGE</h3>
                  <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                

              </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Votre garant est qui pour vous?<font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <select name="pc_qualite_garant" class="form-control select2">
                           <option value="Pere">Père</option>
                           <option value="Mere">Mère</option>
                           <option value="Frere">Frère</option>
                           <option value="Soeur">Soeur</option>
                           <option value="Oncle">Oncle</option>
                           <option value="Tante">Tante</option>
                           <option value="Cousin">Cousin</option>
                           <option value="Cousine">Cousine</option>
                           <option value="Niece">Niece</option>
                           <option value="Neveu">Neveu</option>
                           <option value="Grand-pere">Grand-pere</option>
                           <option value="Grande-mere">Grande-mere</option>
                           <option value="Parrain de mariage">Parrain de mariage</option>
                           <option value="Filleule">Filleule</option>
                           <option value="Filleul">Filleul</option>
                           <option value="Beau-frere">Beau-frere</option>
                           <option value="Belle-mere">Belle-mere</option>
                           <option value="Beau-fils">Beau-fils</option>
                           <option value="Belle-fille">Belle-fille</option>
                           <option value="Ami">Ami(e)</option>
                           <option value="">Autre</option>
                       </select><input type="text" class="form-control" name="qualite_parain_autre"  placeholder="Pas dans la liste, autre">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Où travaille-t-il et quelle responsabilité a-t-il (Poste ou Fonction)? <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="pc_lieu_travail_garant"  placeholder="Dites -nous lenom de son employeur">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Quel est son salaire mensuel?</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="pc_salaire_parrain"  placeholder="Salaire exact ou estimatif mensuellement">
                       
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Possède-t-il une activité commerciale ou une entreprise?</label>
                      <div class="col-sm-1">
                       <input name="pc_activite_pro_chk" type="checkbox" value="oui" onchange="document.getElementById('nom_activite').readOnly = !this.checked;document.getElementById('revenu_activite').readOnly = !this.checked;"> 
                      </div>
                      <label  class="col-sm-6 control-label">Cochez pour Oui et décochez pour Non</label>
                      
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Si Oui, quel est son nom?</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="pc_activite_pro_nom" id="nom_activite"  placeholder="Le nom de l'activité et le domaine d'exploitation" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Si Oui, Quel revenu mensuel pour cette activité ou entreprise en USD (Estimation)?</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="pc_revenu_parrain" id="revenu_activite"  placeholder="Estimation en dollars américains des revenus mensuels" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                     <div class="col-sm-12">
                       .
                      </div>
                    </div>
                    <br>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Combien de parcelles dispose-t-il ?</label>
                      <div class="col-sm-6">
                      <select name="pc_nbre_parcelle" class="form-control select2">
                       <?php  for($j=0;$j<21;$j++){ ?>
                       <option value="<?php  echo $j; ?>"><?php  echo $j; ?></option>
                       <?php  } ?>
                       </select>
                      </div>
                      
                      
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Combien de véhicules dispose-t-il ?</label>
                      <div class="col-sm-6">
                      <select name="pc_nbre_vehicule" class="form-control select2">
                       <?php  for($j=0;$j<21;$j++){ ?>
                       <option value="<?php  echo $j; ?>"><?php  echo $j; ?></option>
                       <?php  } ?>
                       </select>
                      </div>
                      
                      
                    </div>
                         
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <i class="fa fa-warning">Important à savoir</i><br>
                    <font color="#FF0000">*</font> : Champs conditionnés par un remplissage obligatoire<br>
                    <a href="#section4" class="btn btn-adn left" ><i class="fa  fa-arrow-left">Précedent</i></a>
                    <a href="#section_validation" class="btn btn-adn left" ><i class="fa  fa-arrow-right">Suivant</i></a>
                    <a href="#section_validation" class="btn btn-info pull-right" ><i class="fa  fa-arrow-right">ENREGISTRER POUR CONTINUER PLUS TARD</i></a>
                  </div><!-- /.box-footer -->
               
              </div>
              
              <div class="box box-info" id="section_validation">
  <div class="box-header with-border">
                  <h3 class="box-title">Notez Bien</h3>
                  
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                  En signant ce formulaire, le client reconnait avoir fourni les renseignements sincères, exacts et vrais. Il reconnait
également avoir adhéré aux dispositions établies dans le contrat d'adhésion dont il a pris connaissance à l'amorce de ce processus. 
Par ce Formulaire, l'Agence sera en mesure d'estimer le pourcentage de réussite du dossier ainsi que
fournir les recommandations et conseils nécessaires au client pour le bon traitement de son dossier. L'usage de "IL" représente le genre humain, incluant le masculin ou le féminin selon le cas.
					<div class="form-group">
                      <label  class="col-sm-6 control-label" ><font color="#FF0000">J'ai pris connaissance de ce qui est dit ci-haut et des <a href="#condition">conditions générales</a> et j'y adhère</font></label>
                      <div class="col-sm-6">
                     <input name="chk_privacy" type="checkbox" value="on" onchange="document.getElementById('passnext2').disabled = !this.checked;">
                      </div>
                    </div>
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                      <a href="#section_validation" class="btn btn-adn left" ><i class="fa  fa-arrow-left">Précedent</i></a>
                    <button type="submit"  class="btn btn-info pull-right" name="submit_dossier" id="passnext2" disabled>Accepter les conditions et Enregistrer le Dossier </button>
                    
                  </div><!-- /.box-footer -->
               
              </div>
              <div class="box box-info" id="condition">
  <div class="box-header with-border">
                  <h3 class="box-title">CONDITIONS GENERALES POUR LES SERVICES DE VOYAGE A L’AGENCE PASSPORT SARL</h3>
                  
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                      
                      <ol type="I">
                          <li>L’agence prendra avec ses partenaires toutes les dispositions nécessaires facilitant le voyage du client ; l’agence étant liée par l’obligation de moyen ; </li>
<li>Endéans 10 jours après l’arrivée d’une admission dont le client aura été informé, ce dernier est sensé avoir réuni tous les documents nécessaires pour le dépôt du dossier à l’ambassade conformément à la fiche sur la deuxième étape qui lui aura déjà été remise et expliquée minimum une semaine avant l’arrivée de cette admission ; L’explication de ladite fiche se fera au cours d’une réunion dont la présence des clients invités sera constatée par leur identité et leur signature dans une liste de présence ; </li>
<li>L’agence exécutera sa mission qu’une fois qu’un paiement total sera effectué par le client. Néanmoins, en cas de versement par le client d’une tranche comme paiement partiel exigé, celui – ci devra régler, dans un délai de 10 jours précédant la finition de premiers services rendus, la tranche suivante, selon les services à rendre, sous peine de mettre la société en droit de se déresponsabiliser de premiers services rendus au nom du client et l’acompte versé sera ainsi perdu ; </li>
<li>La responsabilité de l’agence est dégagée en cas d’annulation de voyages, des modifications de trajet, des retards ou de changement de quelle que nature que ce soit relatif aux services de voyage et sous l’influence du client ou des circonstances de force majeure ; </li>
<li>La responsabilité de l’agence est dégagée si le client n’a pas fourni dans le délai les éléments exigés pour le voyage ou s’il a fourni d’éléments considérés de non authentiques et ayant conduit à l’échec de ses démarches de voyage ; </li>
<li>En cas d’échec de la première tentative de délivrance d’un visa d’études, l’agence se réserve le droit de relancer, uniquement pour une seconde fois, les démarches à cet effet, sans que le client n’ait encore à débourser les frais de base (première et deuxième tranches) ayant déjà été payés aux démarches précédentes. Après deux refus de visas, l’unique option restante est celle de choisir une autre destination parmi celles qui seront proposées par l’agence ; </li>
<li>L’obtention d’un remboursement n’est pas possible pour un voyage ou pour des services non consommés ou ceux déjà en cours ; </li>
<li>Après paiement, PASSPORT SARL attribue à chaque client un Numéro d’Identification du Dossier (NID), lequel contient les informations et mises à jour relatives à son dossier. Le client est tenu de consulter régulièrement le site internet de PASSPORT afin de prendre connaissance, grâce à son NID, de l’évolution de son dossier et pouvoir faire le suivi lui-même. De ce fait, PASSPORT SARL ne saurait engager sa responsabilité pour tout préjudice découlant du fait que le CLIENT n’a pas consulter les informations pourtant disponibles dans son NID. </li>
<li>A l’obtention d’un visa d’études ou autre visa, il est d’obligation au client de participer à la prise des photos souvenirs avec l’équipe PASSPORT Sarl dans les locaux de l’Agence ou à son voisinage ou encore à tout autre endroit où l’agence aura choisi d’organiser une cérémonie de remise des visas et de prise des photos, et autorise, à cet effet, l’agence à utiliser, si bon lui semble, ces photos pour des raisons publicitaires saines ; </li>
<li>A la signature de ce contrat, le client et tout membre de sa famille l’ayant accompagné et se retrouvant dans les photos prises par l’agence, autorise celle-ci à utiliser ces photos pour des raisons publicitaires conformément au point (IX) précédent ; </li>
<li>Pour des raisons politiques sur le plan national, régional ou mondial ou bien pour des raisons climatiques qui ne constituent pas une menace grave pour le déroulement du voyage, aucun montant ne sera remboursé ; </li>
<li>Ce contrat s’applique à tout client l’ayant signé, que ses démarches de voyage aient commencé à l’agence PASSPORT SARL ou ailleurs ; </li>
<li>Les présents termes s’appliquent également au mandant dont le mandataire a signé ce formulaire ; </li>
<li>Le masculin est utilisé dans ce document pour représenter le genre humain sans restriction. 	</li>
                    </ol>
                  </div><!-- /.box-body -->
                  <!-- /.box-footer -->
               
              </div>
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
		    //include_once("php/tableau_controle.php");

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
