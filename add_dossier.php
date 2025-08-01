<?php
//******************IDPAGE*****************
//Session check****************************
$idpage = 14;
//Session check****************************
include_once("php/session_check.php");
include_once("php/function.php");
//********************locally Additionnal Function*************
//*********************Get Profile Data*****
$set_pluggin_datatable = "yes";
$set_pluggin_selection_wise = "yes";

//********************locally Additionnal Function*************
//****************location******************
$set_pluggin_selection_wise = "yes";
$requirement_datatable = "yes";
$get_active_menu = "dossier";
$page_titre = "Formulaire de Renseignement VISA Etude";
$page_small_detail = "1ère PARTIE : RENSEIGNEMENTS";
$page_location = "Formulaire de Renseignement VISA Etude";

//*************************************************************




if (isset($_POST['submit_dossier'])) {

    $identite = clean_in_text($_POST['identite']);
    $date_naissance = clean_in_text($_POST['date_naissance']);
    $telephone = str_ireplace(' ', '', str_ireplace('-', '', str_ireplace(')', '', str_ireplace('(', '', clean_in_text($_POST['telephone'])))));
    $lieu_naissance = clean_in_text($_POST['lieu_naissance']);
    $nbre_enfant_famille = clean_in_text($_POST['nbre_enfant_famille']);
    $position_dans_famille = clean_in_text($_POST['position_dans_famille']);
    $numero_passport = clean_in_text($_POST['numero_passport']);
    $date_expiration_pp = clean_in_text($_POST['date_expiration_pp']);
    $ref_agence = clean_in_text($_POST['ref_agence']);
    $promoteur_agence = clean_in_text($_POST['promoteur_agence']);
    $activite_passe_actuelle = clean_in_text($_POST['activite_passe_actuelle']);
    $vo_destination = clean_in_text($_POST['vo_destination']);
    $vo_raison_voyage = clean_in_text($_POST['vo_raison_voyage']);
    $vo_charge_etude_parrain = clean_in_text($_POST['vo_charge_etude_parrain']);
    $vo_ancien_visa = isset($_POST['vo_ancien_visa']) ? $_POST['vo_ancien_visa'] : '';
    $vo_ancien_visa_comment = clean_in_text($_POST['vo_ancien_visa_comment']);
    $vo_refus_visa_chk = isset($_POST['vo_refus_visa_chk']) ? $_POST['vo_refus_visa_chk'] : '';
    $commentaire_refus_visa = clean_in_text($_POST['commentaire_refus_visa']);
    $vo_destination_famille_chk = isset($_POST['vo_destination_famille_chk']) ? $_POST['vo_destination_famille_chk'] : '';
    $vo_destination_comment = clean_in_text($_POST['vo_destination_comment']);
    $pc_qualite_garant = ( clean_in_text($_POST['pc_qualite_garant']) != "") ? clean_in_text($_POST['pc_qualite_garant']) : clean_in_text($_POST['qualite_parain_autre']);
    $qualite_parain_autre = clean_in_text($_POST['qualite_parain_autre']);
    $pc_lieu_travail_garant = clean_in_text($_POST['pc_lieu_travail_garant']);
    $pc_salaire_parrain = clean_in_text($_POST['pc_salaire_parrain']);
    $pc_activite_pro_chk = isset($_POST['pc_activite_pro_chk']) ? $_POST['pc_activite_pro_chk'] : '';
    $pc_activite_pro_nom = clean_in_text($_POST['pc_activite_pro_nom']);
    $pc_revenu_parrain = clean_in_text($_POST['pc_revenu_parrain']);
    $pc_nbre_parcelle = clean_in_text($_POST['pc_nbre_parcelle']);
    $pc_nbre_vehicule = clean_in_text($_POST['pc_nbre_vehicule']);
    $email = clean_in_text($_POST['email']);
    $pin_secret = clean_in_text($_POST['pin_secret']);
    $nid = clean_in_text($_POST['nid']);
    $commentaire_client = isset($_POST['commentaire_client']) ? clean_in_text($_POST['commentaire_client']) : '';
    $identite_pere=clean_in_text($_POST['identite_pere']);
    $lieu_naissance_pere=clean_in_text($_POST['lieu_naissance_pere']);
    $date_naissance_pere=($identite_pere=="") ? "" : clean_in_text($_POST['date_naissance_pere']);
    $identite_mere=clean_in_text($_POST['identite_mere']);
    $lieu_naissance_mere=clean_in_text($_POST['lieu_naissance_mere']);
    $date_naissance_mere=($identite_mere=="") ? "" : clean_in_text($_POST['date_naissance_mere']);
    $sexe=$_POST['sexe'];
    $adresse=clean_in_text($_POST['adresse']);
    $ville_pays=clean_in_text($_POST['ville_pays']);
    $domaine_preference=clean_in_text($_POST['vo_proposition_domaine']);

    $q_universite = clean_in_text($_POST['q_universite']);
    $q_pays = clean_in_text($_POST['q_pays']);
    $numero_telephone_secondaire = str_ireplace(' ', '', str_ireplace('-', '', str_ireplace(')', '', str_ireplace('(', '', clean_in_text($_POST['numero_telephone_secondaire'])))));
    $email_secondaire = clean_in_text($_POST['email_secondaire']);


    $ndel = date('mdHis');
//$pin_secret=rand(10000,99999);
    $feedback_dossier = add_dossier($nid,$ndel, $identite, $lieu_naissance, $date_naissance,$email , $nbre_enfant_famille, $position_dans_famille, $numero_passport, $date_expiration_pp, $activite_passe_actuelle, $vo_destination, $vo_raison_voyage, $vo_charge_etude_parrain, $vo_ancien_visa, $vo_ancien_visa_comment, $telephone, $vo_refus_visa_chk, $commentaire_refus_visa, $vo_destination_famille_chk, $vo_destination_comment, $pc_qualite_garant, $pc_lieu_travail_garant, $pc_salaire_parrain, $pc_activite_pro_chk, $pc_activite_pro_nom, $pc_revenu_parrain, $pc_nbre_parcelle, $pc_nbre_vehicule, "Creer_en_ligne", $promoteur_agence, $ref_agence, $pin_secret, $_SESSION['my_username'],$commentaire_client,$identite_pere,$lieu_naissance_pere,$date_naissance_pere,$identite_mere,$lieu_naissance_mere,$date_naissance_mere,$sexe,$adresse,$ville_pays,$domaine_preference, $q_universite, $q_pays,$numero_telephone_secondaire,$email_secondaire);

    $success = "yes";

    $feedback_exetat = 0;


    if ($feedback_dossier == 1) {
        $data_dossier = get_dossier_data_by_ndel($ndel);
        $success_message = "Dossier en Ligne créé avec succès  <br>";
        add_action_no_request($data_dossier['idt_dossier'], 7, 'Valider', $_SESSION['my_username'], 'Oui', 'Ajout Dossier en Ligne');
        // Enregistremment Diplome
        $to_destination=$email;
                        $sujet="Dossier_Voyage_Creer";
                       include_once("sendmail_test.php");
        
        if ($_POST['exetat_annee'] != "" && $_POST['ecole_frequenter'] != "" && $_POST['option'] != "" && $_POST['pourcentage'] != "" && $_POST['pays'] != "" && $_POST['ville_obtention'] != "") {

            $feedback_exetat = add_dossier_etude($data_dossier['idt_dossier'], $_POST['exetat_annee'], $_POST['ecole_frequenter'], $_POST['option'], "EXETAT", $_POST['pourcentage'], "EXETAT", '', $_POST['ville_obtention'], $_POST['pays'], $_SESSION['my_username']);

            $success_message = ($feedback_exetat == 1) ? $success_message . "-> Exetat créé avec succès : " : $success_message ."-> Exetat non créé";

            $url_fichier = "";
            $is_file_transafered = 0;
            $type_fichier = "";
            //echo "je suiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiis la : ".(isset($_FILES['exetat_file'])  && $feedback_exetat == 1);
            if (0 && isset($_FILES['exetat_file']) && $_FILES['exetat_file']['name'] != '' && $feedback_exetat == 1) {
                   // echo "hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh";
                $value = explode(".", $_FILES['exetat_file']['name']);
                $type_fichier = $value[1];
                $url_initial = "uploads/" . $ndel . "_exetat_" . date('s') . "." . $value[1];
                $download_file = move_uploaded_file($_FILES['exetat_file']['tmp_name'], $url_initial);
                $url_fichier = ($download_file == 1) ? $url_initial : $url_fichier;
                $is_file_transafered = ($download_file == 1) ? 1 : 0;
                $success_message = $success_message . " | -- Fichier Exetat ajouté";
            }

            //$add_document = ($is_file_transafered == 1) ? add_document($data_dossier['idt_dossier'], $_SESSION['my_username'], $url_fichier, $type_fichier, 'EXETAT') : 0;

           // $success_message = ($add_document == 1) ? $success_message . " | - Document ajouté : " . add_action_no_request($data_dossier['idt_dossier'], 6, 'Valider', $_SESSION['my_username'], 'Oui', 'Ajout Document : Exetat') : $success_message ." | - Erreur Ajout Document";
        }
        //  Enregistrement données SECONDAIRE
        for ($i = 1; $i <= 3; $i++) {

            if ($_POST['exetat_annee_sec' . $i] != "" && $_POST['ecole_frequenter_sec' . $i] != "" && $_POST['option_sec' . $i] != "" && $_POST['niveau_sec' . $i] != "" && $_POST['pourcentage_sec' . $i] != "" ) {

                $feedback_exetat = add_dossier_etude($data_dossier['idt_dossier'], $_POST['exetat_annee_sec' . $i], $_POST['ecole_frequenter_sec' . $i], $_POST['option_sec' . $i], $_POST['niveau_sec' . $i], $_POST['pourcentage_sec' . $i], 'SECONDAIRE', '', '', '', $_SESSION['my_username']);

                $success_message = ($feedback_exetat == 1) ? $success_message . "<br>" . $i . "-> " . $_POST['niveau_sec' . $i] . " créé avec succès" : "<br>" . $i . "-> " . $_POST['niveau_sec' . $i] . " non crée";

                $url_fichier = "";
                $is_file_transfered = 0;
                $type_fichier = "";
                if (0 && isset($_FILES['diplome_file_sec'. $i]) && $_FILES['diplome_file_sec' . $i]['name'] != '' && $feedback_exetat == 1) {
                     
                    $value = explode(".", $_FILES['diplome_file_sec' . $i]['name']);
                    $type_fichier = $value[1];
                    $url_initial = "uploads/" . $ndel . "_doc2_" . date('s') . $i . "." . $value[1];
                    $download_file = move_uploaded_file($_FILES['diplome_file_sec' . $i]['tmp_name'], $url_initial);
                    $url_fichier = ($download_file == 1) ? $url_initial : $url_fichier;
                    $is_file_transfered = ($download_file == 1) ? 1 : 0;
                    $success_message = ($download_file == 1) ? $success_message . " | -- Fichier Secondaire ajouté" : $success_message . " | -- Fichier Secondaire Non ajouté";
                    
                    //echo "hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhdddddddddddddddddddddddddddddddddddddhhhhhhhhhhhhhhhhhhhhhhhhh : ".$download_file;
                }
                    
               // $add_document = ($is_file_transfered == 1) ? add_document($data_dossier['idt_dossier'], $_SESSION['my_username'], $url_fichier, $type_fichier, $_POST['niveau_sec' . $i]) : 0;

                //$success_message = ($add_document == 1) ? $success_message . " | - Document ajouté" . add_action_no_request($data_dossier['idt_dossier'], 6, 'Valider', $_SESSION['my_username'], 'Oui', 'Ajout Document : ' . $_POST['niveau_sec' . $i]) : $success_message ." | - Erreur Ajout Document";
            }
        }

        //  Enregistrement données POST SECONDAIRE
        for ($i = 1; $i <= 7; $i++) {

            if ($_POST['exetat_annee' . $i] != "" && $_POST['ecole_frequenter' . $i] != "" && $_POST['option' . $i] != "" && $_POST['niveau' . $i] != "" && $_POST['pourcentage' . $i] != "" && $_POST['diplome' . $i] != "") {

                $feedback_exetat = add_dossier_etude($data_dossier['idt_dossier'], $_POST['exetat_annee' . $i], $_POST['ecole_frequenter' . $i], $_POST['option' . $i], $_POST['niveau' . $i], $_POST['pourcentage' . $i], $_POST['diplome' . $i], '', '', '', $_SESSION['my_username']);

                $success_message = ($feedback_exetat == 1) ? $success_message . "<br>" . $i . "-> " . $_POST['diplome' . $i] . " créé avec succès" : "<br>" . $i . "-> " . $_POST['diplome' . $i] . " non crée";

                $url_fichier = "";
                $is_file_transafered = 0;
                $type_fichier = "";
                if (0 && isset($_FILES['diplome_file' . $i]) && $_FILES['diplome_file' . $i]['name'] != '' && $feedback_exetat == 1) {

                    $value = explode(".", $_FILES['diplome_file' . $i]['name']);
                    $type_fichier = $value[1];
                    $url_initial = "uploads/" . $ndel . "_doc_" . date('s') . $i . "." . $value[1];
                    $download_file = move_uploaded_file($_FILES['diplome_file' . $i]['tmp_name'], $url_initial);
                    $url_fichier = ($download_file == 1) ? $url_initial : $url_fichier;
                    $is_file_transafered = ($download_file == 1) ? 1 : 0;
                    $success_message = $success_message . " | -- Fichier Post Secondaire ajouté";
                }

                //$add_document = ($is_file_transafered == 1) ? add_document($data_dossier['idt_dossier'], $_SESSION['my_username'], $url_fichier, $type_fichier, $_POST['niveau' . $i]) : 0;

                //$success_message = ($add_document == 1) ? $success_message . " | - Document ajouté" . add_action_no_request($data_dossier['idt_dossier'], 6, 'Valider', $_SESSION['my_username'], 'Oui', 'Ajout Document : ' . $_POST['niveau' . $i]) : $success_message ." | - Erreur Ajout Document";
            }
        }

         if(0 && isset($_FILES['cv_file']) && $_FILES['cv_file']['name']!=''){
                                        
                                    if(isset($_FILES['cv_file']) && $_FILES['cv_file']['name']!=''){
								
								$value=explode(".",$_FILES['cv_file']['name']);
								$type_fichier=$value[1];
								$url_initial="uploads/".$ndel."_CV_".date('s').".".$value[1];
								$download_file=move_uploaded_file($_FILES['cv_file']['tmp_name'],$url_initial);
								$url_fichier=($download_file==1) ? $url_initial : $url_fichier;
								$is_file_transafered=($download_file==1) ? 1 : 0;
								$success_message=$success_message." | -- Fichier CV ajouté";
							
							}
				
				//$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],$_SESSION['my_username'],$url_fichier,$type_fichier,'CV') : 0;
				
				//$success_message=($add_document==1) ? $success_message." | - Document ajouté : ".add_action_no_request($data_dossier['idt_dossier'],6,'Valider',$_SESSION['my_username'],'Oui','Ajout Document : CV') : $success_message ." | - Erreur Ajout Document";
				
				
							
				}
        
                                if(0 && isset($_FILES['passeport_file']) && $_FILES['passeport_file']['name']!=''){
                                        
                                    if(isset($_FILES['passeport_file']) && $_FILES['passeport_file']['name']!=''){
								
								$value=explode(".",$_FILES['passeport_file']['name']);
								$type_fichier=$value[1];
								$url_initial="uploads/".$ndel."_passeport_".date('s').".".$value[1];
								$download_file=move_uploaded_file($_FILES['passeport_file']['tmp_name'],$url_initial);
								$url_fichier=($download_file==1) ? $url_initial : $url_fichier;
								$is_file_transafered=($download_file==1) ? 1 : 0;
								$success_message=$success_message." | -- Fichier Passeport ajouté";
							
							}
				
				//$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,'Passeport') : 0;
				
				//$success_message=($add_document==1) ? $success_message." | - Document ajouté : ".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : Passeport') : $success_message ." | - Erreur Ajout Document";
				
				
							
				}
                                
                                if(0 && isset($_FILES['attestaion_file']) && $_FILES['attestaion_file']['name']!=''){
                                        
                                    if(isset($_FILES['attestaion_file']) && $_FILES['attestaion_file']['name']!=''){
								
								$value=explode(".",$_FILES['attestaion_file']['name']);
								$type_fichier=$value[1];
								$url_initial="uploads/".$ndel."_Attestation_".date('s').".".$value[1];
								$download_file=move_uploaded_file($_FILES['attestaion_file']['tmp_name'],$url_initial);
								$url_fichier=($download_file==1) ? $url_initial : $url_fichier;
								$is_file_transafered=($download_file==1) ? 1 : 0;
								$success_message=$success_message." | -- Fichier Acte Naissance ajouté";
							
							}
				
				//$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,'Acte de naissance') : 0;
				
				//$success_message=($add_document==1) ? $success_message." | - Document ajouté : ".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : Acte de naissance') : $success_message ." | - Erreur Ajout Document";
				
				
							
				}
        header("Location:vue_dossier.php?ndel=".$ndel."&success=ok&msg=".$success_message.", Vous pouvez ajouter les fichiers dans la zone Fichier");			
    } else {
        $error = "yes";
        $error_message = "Une erreur a survenu lors de la creation de dossier";
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
        <h1>
<?php echo $page_titre; ?>
            <small><?php echo $page_small_detail; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="home.php?close=ok"><i class="fa  fa-close"></i></a><a href="home.php"><i class="fa fa-dashboard"></i>MyPassport |</a>Où suis-je</li>
            <li class="active"><?php echo $page_location; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <?php include_once("php/print_message.php"); ?>
        <!-- Your Page Content Here -->
        <!-- Horizontal Form -->
        <img src="images/logo_passport.png" width="212" height="171" />
        <form action="add_dossier.php"  method="post" enctype="multipart/form-data">
            <h3 class="box-title">NID : <?php echo date('mdHis'); ?></h3>
            <div class="box box-info">

                <div class="box-header with-border">
                    <h3 class="box-title">1. IDENTITE DU CLIENT</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>


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
                        <label  class="col-sm-6 control-label">Date de naissance <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" name="date_naissance" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask placeholder="Entrez votre date de naissance Année-Mois-Jour" required>
                        </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Sexe <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                      <select name="sexe" class="form-control select2" required="true">
                      <option value=""></option> 
                      <option value="Masculin">Masculin</option>
                       <option value="Feminin">Feminin</option>
                       </select>
                      </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Email <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="email" name="email" class="form-control" placeholder="Entrez votre adresse email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Téléphone <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" data-inputmask='"mask": "(999) 99-999-9999"' data-mask name="telephone" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Lieu de naissance <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="lieu_naissance"  placeholder="Où êtes-vous né(e)?" required>
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
                        <label  class="col-sm-6 control-label">Comment avez-vous connu notre agence ?<font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" name="promoteur_agence" class="form-control"  placeholder="Merci de donner tous les détails SVP. (Max 100 caractères)" required="true" size="100">
                        </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Nom complet de votre père biologique (tel que dans votre acte de naissance)</label>
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
                        <input type="text" name="date_naissance_mere" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask placeholder="Entrez la date de naissance de votre mère Année-Mois-Jour" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Adresse physique actuelle<font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                          <input type="text" name="adresse" class="form-control"  placeholder="Entrez votre adresse (num, av, quartier et commune)" required="true">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Ville et Pays de résidence actuelle<font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                          <input type="text" name="ville_pays" class="form-control"  placeholder="Entrez votre ville et le pays (Ville , Pays)" required="true">
                      </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Vous êtes issue d'une famille de combien d'enfants</label>
                        <div class="col-sm-6">
                            <select name="nbre_enfant_famille" class="form-control select2">
<?php for ($i = 0; $i < 40; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>

                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Vous êtes quantième enfant dans la famille?</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" name="position_dans_famille">
<?php for ($i = 0; $i < 40; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Où voulez-vous partir?  <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <select name="vo_destination" class="form-control select2">
                                <?php get_combo_liste_pays(); ?>
                            </select>
                        </div>
                    </div>
                    
                      
                      
                      
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">A quel bureau voulez-vous suivre le dossier ?</label>
                        <div class="col-sm-6">
                            <select name="ref_agence" class="form-control select2">

                                <?php echo getcombo_agence(0); ?>
                            </select>
                        </div>
                    </div>

                    <br><font color="#FF0000">----------------------------------------------------------------------------------------------------------------</font><br>

                    
                    <div class="form-group">
                        <label  class="col-sm-6 control-label"><font color="#FF0000">PIN SECRET (*)--->></font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="pin_secret"  placeholder="Remplissez le PIN Secret pour le Client" value="<?php echo rand(10000, 99999); ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label"><font color="#FF0000">NID old --->></font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="nid"  placeholder="Remplissez le NID" readonly="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label"><font color="#FF0000">Autre chose à nous informer? Merci de le mentionner ici (Max 200 caractères)---------> </font></label>
                        <div class="col-sm-6">
                            <textarea name="commentaire_client" cols="100%" rows="3" class="form-control"></textarea>

                        </div>
                    </div>                


                </div><!-- /.box-body -->
                <div class="box-footer">
                    <i class="fa fa-warning">Important à savoir</i><br>
                    <font color="#FF0000">*</font> : Champs conditionnés par un remplissage obligatoire

                    <!-- /.box-body -->

                    <button type="submit"  class="btn btn-info pull-right" name="submit_dossier" >Accepter les conditions et Enregistrer le Dossier à ce niveau</button>


                </div><!-- /.box-footer -->

            </div>
            <!-- /.box -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">2. PARCOURS D'ETUDES</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>


                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <br><?php $actual_year = clean_in_integer(date("Y")); //echo $actual_year;  ?>
                    <h5>2.1. Votre Parcours Secondaire (Les 3 dernieres années seulement)</h5>
                    <table class="table table-condensed">
                        <tr>
                            <th>#</th>
                            <th>Année d'obtention</th>
                            <th>Etablissement Frequenté</th>
                            <th>Option</th>
                            <th>Classe</th>
                            <th>Résultats</th>  

                                          

                        </tr>
<?php
for ($i = 1; $i <= 3; $i++) {
    //	echo $i;
    ?>	
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td width="10%"><select name="exetat_annee_sec<?php echo $i; ?>" class="form-control select2" >
                                        
                                        <option value=""></option>   
    <?php for ($j = $actual_year; $j > 1975; $j--) { ?>
                                            <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
    <?php } ?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="ecole_frequenter_sec<?php echo $i; ?>" ></td>
                                <td><input type="text" class="form-control" name="option_sec<?php echo $i; ?>"></td>
                                <td><input type="text" class="form-control" name="niveau_sec<?php echo $i; ?>"  placeholder="Ex : 6eme, 5eme ou 4eme" value="<?php echo (7 - $i) . "eme"; ?>"></td>                      
                                <td><input type="text" class="form-control" name="pourcentage_sec<?php echo $i; ?>" ></td> 

                                                   

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
                                                 

                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <select name="exetat_annee" class="form-control select2">
<option value=""></option>   
<?php for ($i = $actual_year; $i > 1975; $i--) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="ecole_frequenter" ></td>
                            <td><input type="text" class="form-control" name="option" ></td>
                            <td><input type="text" class="form-control" name="pourcentage" ></td>                      
                            <td><select name="pays" class="form-control select2">

                        <?php include("php/list_pays.php"); ?>
                                </select></td>  
                            <td><input type="text" class="form-control" name="ville_obtention"></td>
                            

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
                                         

                        </tr>
                                    <?php
                                    for ($i = 1; $i <= 10; $i++) {
                                        //	echo $i;
                                        ?>	
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td width="10%"><select name="exetat_annee<?php echo $i; ?>" class="form-control select2" >
                                        <option value=""></option>   
    <?php for ($j = $actual_year; $j > 1975; $j--) { ?>
                                            <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
    <?php } ?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="ecole_frequenter<?php echo $i; ?>" ></td>
                                <td><input type="text" class="form-control" name="option<?php echo $i; ?>"></td>
                                <td><input type="text" class="form-control" name="niveau<?php echo $i; ?>"  placeholder="Ex : G1,L1,D1,DEA,PHD, etc"></td>                      
                                <td><input type="text" class="form-control" name="pourcentage<?php echo $i; ?>" ></td> 
                                <td><input type="text" class="form-control" name="diplome<?php echo $i; ?>" ></td> 
                                                  

                            </tr>

    <?php
}
?>	    
                    </table>





                </div><!-- /.box-body -->
                <div class="box-footer">
                    <i class="fa fa-warning">Important à savoir</i><br>
                    <font color="#FF0000">*</font> : Tous les champs d'une ligne doivent etre rempli que la ligne soit enrégistrer.
                </div><!-- /.box-footer -->

            </div>

            <div class="box box-info">
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

                        <div class="col-sm-6">
                            <textarea name="activite_passe_actuelle" cols="100%" rows="2" class="form-control"></textarea>

                        </div>
                    </div>
                     

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <i class="fa fa-warning">Important à savoir</i><br>

                </div><!-- /.box-footer -->

            </div>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">4. VOYAGE</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>


                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">


                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Raison du voyage </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="vo_raison_voyage"  placeholder="C'est quoi la raison de votre voyage?">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Si pour études, qui prendra en charge ces études?</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="vo_charge_etude_parrain"  placeholder="Le nom du parain de vos études">

                        </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Si pour études, quels domaines  vous intéressent ? (donnez trois propositions des programmes)</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="vo_proposition_domaine"  placeholder="quels domaines  vous intéressent ? (donnez trois propositions des programmes)">
                       
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
                            <input type="text" class="form-control" name="vo_destination_comment" id="famille_destination"  placeholder="Précisez il s'agitk de qui et sa qualité pour vous" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Avez-vous déjà tenté d'obtenir une inscription dans une université étrangère ? </label>
                        <div class="col-sm-1">
                            <input name="vo_obtention_chk" type="checkbox" value="oui" onchange="document.getElementById('universite').readOnly = !this.checked; document.getElementById('pays').readOnly = !this.checked;"> 
                        </div>
                        <label  class="col-sm-5 control-label">Cochez pour Oui et décochez pour Non</label>
                       

                       
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">De quelle Université s'agit il? </label>
                       

	                    <div class="col-sm-6">
	             
	                        <input type="text" id="universite" name="q_universite" class="form-control"  placeholder="Entrez plusieurs noms si c'est plusieurs universités" readonly>
	                        
	                    </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Dans quel pays se trouve cette Université? </label>
                        
	                   

	                    <div class="col-sm-6">
	             
	                        
	                        <input type="text" id="pays" name="q_pays" class="form-control"  placeholder="Entrez plusieurs noms si c'est plusieurs pays" readonly>
	                    </div>
                    </div>


                </div><!-- /.box-body -->
                <div class="box-footer">
                    <i class="fa fa-warning">Important à savoir</i><br>
                    <font color="#FF0000">*</font> : Champs conditionnés par un remplissage obligatoire
                </div><!-- /.box-footer -->

            </div>
            <div class="box box-info">
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
                        <label  class="col-sm-6 control-label">Où travaille-t-il et quelle responsabilité a-t-il? <font color="#FF0000">*</font></label>
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
                        <label  class="col-sm-5 control-label">Cochez pour Oui et décochez pour Non</label>

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
<?php for ($j = 0; $j < 21; $j++) { ?>
                                    <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
<?php } ?>
                            </select>
                        </div>


                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Combien de véhicules dispose-t-il ?</label>
                        <div class="col-sm-6">
                            <select name="pc_nbre_vehicule" class="form-control select2">
<?php for ($j = 0; $j < 21; $j++) { ?>
                                    <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
<?php } ?>
                            </select>
                        </div>


                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Email Secondaire (Cette adresse email recevra les notifications habituelles sur le dossier)</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="email_secondaire"  placeholder="Entrer votre addresse email secondaire">

                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Numéro Facultatif (Ce numéro ne recevra pas les notifications habituelles et ne sera utilisé que si nécessaire)</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="numero_telephone_secondaire"  placeholder="Entrer votre numéro facultatif">

                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <i class="fa fa-warning">Important à savoir</i><br>
                    <font color="#FF0000">*</font> : Champs conditionnés par un remplissage obligatoire
                </div><!-- /.box-footer -->

            </div>

            <div class="box box-info">
                

                <div class="box-footer">
                    <button type="submit"  class="btn btn-info pull-right" name="submit_dossier" >Accepter les conditions et Enregistrer le Dossier </button>

                </div><!-- /.box-footer -->

            </div>
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

            <hr>
       </section>
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
