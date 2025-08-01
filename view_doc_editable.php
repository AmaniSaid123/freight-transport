<?php
//******************IDPAGE*****************
//Session check****************************
include_once("php/session_check_online.php");
include_once("php/function.php");
//********************locally Additionnal Function*************
//*********************Get Profile Data*****
$set_pluggin_datatable = "yes";
$set_pluggin_selection_wise = "yes";

//***********************Find Profile****************
//*************************Selection des informations du profile************************



$active_export = "no";
//****************location******************

$data_dossier = "";
$identite = "";
$date_naissance = "";

$telephone = "";

$lieu_naissance = "";
$nbre_enfant_famille = "";
$position_dans_famille = "";
$numero_passport = "";
$date_expiration_pp = "";
$ref_agence = "";
$promoteur_agence = "";
$activite_passe_actuelle = "";
$vo_destination = "";
$vo_raison_voyage = "";
$vo_charge_etude_parrain = "";
$vo_ancien_visa = "";
$vo_ancien_visa_comment = "";
$vo_refus_visa_chk = "";
$commentaire_refus_visa = "";
$vo_destination_famille_chk = "";
$vo_destination_comment = "";
$pc_qualite_garant = "";
$qualite_parain_autre = "";
$pc_lieu_travail_garant = "";
$pc_salaire_parrain = "";
$pc_activite_pro_chk = "";
$pc_activite_pro_nom = "";
$pc_revenu_parrain = "";
$pc_nbre_parcelle = "";
$pc_nbre_vehicule = "";
$email = "";
$sexe="";
$adresse="";
$ville_pays="";
$domaine_preference="";
$ref_agence = "";
$email_secondaire = "";
$numero_telephone_secondaire = "";

if (isset($_POST['submit_add_etude_sec'])) {
    $annee = $_POST['exetat_annee'];
    $ecole_frequenter = clean_in_text($_POST['ecole_frequenter']);
    $formation = clean_in_text($_POST['formation']);
    $resultat = clean_in_text($_POST['resultat']);
    
    $niveau = clean_in_text($_POST['niveau']);

    $feedback = add_dossier_etude($_SESSION['my_doc_online'], $annee, $ecole_frequenter, $formation, $niveau, $resultat, 'SECONDAIRE', '', '', '', $_SESSION['username_online']);
    if ($feedback == 1) {

        $success = "yes";
        $success_message = "Creation Cursus " . $formation . " fait avec succès " . add_action_no_request($_SESSION['my_doc_online'], 18, 'Valider', $_SESSION['username_online'], 'Oui', 'Ajout Etude Secondaire : ' . $niveau);
    } else {
        $error = "yes";
        $error_message = "Erreur lors de la creation du cursus  " . $formation;
    }
}

if (isset($_POST['submit_add_doc'])) {

    $url_fichier = "";
    $is_file_transafered = 0;
    $type_fichier = "";
    if (isset($_FILES['doc_file']) && $_FILES['doc_file']['name'] != '') {

        $value = explode(".", $_FILES['doc_file']['name']);
        $type_fichier = $value[1];
        $url_initial = "uploads/" . $_SESSION['my_doc_online'] . "_doc_" . date('s') . date('i') . "." . $value[1];
        $download_file = move_uploaded_file($_FILES['doc_file']['tmp_name'], $url_initial);
        $url_fichier = ($download_file == 1) ? $url_initial : $url_fichier;
        $is_file_transafered = ($download_file == 1) ? 1 : 0;
        $success_message = $success_message . " | -- Fichier Exetat ajouté";
    }

    $add_document = ($is_file_transafered == 1) ? add_document($_SESSION['my_doc_online'], $_SESSION['username_online'], $url_fichier, $type_fichier, $_POST['titre_document']) : 0;
    $success_message = ($add_document == 1) ? $success_message . " | - Document ajouté" . add_action_no_request($_SESSION['my_doc_online'], 6, 'Valider', $_SESSION['username_online'], 'Oui', 'Ajout Document : ' . $_POST['titre_document']) : " | - Erreur Ajout Document";
    if ($add_document == 1) {

        $success = "yes";
        //$success_message = "Zone prise en charge Client du dossier a été mise à jour avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur a survenu lors de l'ajout d'un document dans le  dossier";
    }
}
if (isset($_POST['btn_edition_zone_charge'])) {

    $pc_qualite_garant = (clean_in_text($_POST['pc_qualite_garant']) != "") ? clean_in_text($_POST['pc_qualite_garant']) : clean_in_text($_POST['pc_qualite_garant']);
    // $qualite_parain_autre=clean_in_text($_POST['qualite_parain_autre']);
    $pc_lieu_travail_garant = clean_in_text($_POST['pc_lieu_travail_garant']);
    $domaine_preference=clean_in_text($_POST['vo_proposition_domaine']);
    $pc_salaire_parrain = clean_in_text($_POST['pc_salaire_parrain']);
    $pc_activite_pro_chk = clean_in_text($_POST['pc_activite_pro_chk']);
    $pc_activite_pro_nom = clean_in_text($_POST['pc_activite_pro_nom']);
    $pc_revenu_parrain = clean_in_text($_POST['pc_revenu_parrain']);
    $pc_nbre_parcelle = clean_in_text($_POST['pc_nbre_parcelle']);
    $pc_nbre_vehicule = clean_in_text($_POST['pc_nbre_vehicule']);
    $numero_telephone_secondaire = clean_in_text($_POST['numero_telephone_secondaire']);
    $email_secondaire = clean_in_text($_POST['email_secondaire']);
  

    $feedback = update_details_zone_charge_front($_SESSION['my_doc_online'], $pc_qualite_garant, $pc_lieu_travail_garant, $pc_salaire_parrain, $pc_activite_pro_chk, $pc_activite_pro_nom, $pc_revenu_parrain, $pc_nbre_parcelle, $pc_nbre_vehicule,$numero_telephone_secondaire,$email_secondaire,$domaine_preference);

    if ($feedback == 1) {

        $success = "yes";
        $success_message = "Zone prise en charge Client du dossier a été mise à jour avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur mise à jour Zone prise en charge Client du dossier";
    }
}

if (isset($_POST['btn_edition_zone_voyage'])) {

    $vo_destination = (isset($_POST['chk_vo_destination']) && $_POST['chk_vo_destination'] == 'oui') ? clean_in_text($_POST['vo_destination_temp']) : clean_in_text($_POST['vo_destination']);
    $vo_raison_voyage = clean_in_text($_POST['vo_raison_voyage']);
    $domaine_preference=clean_in_text($_POST['vo_proposition_domaine']);
    $vo_charge_etude_parrain = clean_in_text($_POST['vo_charge_etude_parrain']);
    $vo_ancien_visa = (isset($_POST['vo_ancien_visa']) && $_POST['vo_ancien_visa'] == 'oui') ? clean_in_text($_POST['vo_ancien_visa']) : "";
    $vo_ancien_visa_comment = clean_in_text($_POST['vo_ancien_visa_comment']);
    $vo_refus_visa_chk = (isset($_POST['vo_refus_visa_chk']) && $_POST['vo_refus_visa_chk'] == 'oui') ? clean_in_text($_POST['vo_refus_visa_chk']) : "";
    $commentaire_refus_visa = clean_in_text($_POST['commentaire_refus_visa']);
    $vo_destination_famille_chk = (isset($_POST['vo_destination_famille_chk']) && $_POST['vo_destination_famille_chk'] == 'oui') ? clean_in_text($_POST['vo_destination_famille_chk']) : "";
    $vo_destination_comment = clean_in_text($_POST['vo_destination_comment']);
   
    $q_universite = clean_in_text($_POST['q_universite']);
$q_pays = clean_in_text($_POST['q_pays']);


    $feedback = update_details_zone_voyage($_SESSION['my_doc_online'], $vo_destination, $vo_raison_voyage, $vo_charge_etude_parrain, $vo_ancien_visa, $vo_ancien_visa_comment, $vo_refus_visa_chk, $commentaire_refus_visa, $vo_destination_famille_chk, $vo_destination_comment,$domaine_preference,$q_universite, $q_pays);

    if ($feedback == 1) {

        $success = "yes";
        $success_message = "Zone Voyage Client du dossier a été mise à jour avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur mise à jour Zone Voyage Client du dossier";
    }
}
if (isset($_POST['btn_edition_emploi'])) {

    $activite_passe_actuelle = clean_in_text($_POST['activite_passe_actuelle']);


    $feedback = update_details_emploi_passer($_SESSION['my_doc_online'], $activite_passe_actuelle);

    if ($feedback == 1) {

        $success = "yes";
        $success_message = "le détail sur les emplois passés a été mise à jour avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur mise à jour Details emploi passés";
    }
}

if (isset($_POST['btn_edition_identite_client'])) {

    $identite = clean_in_text($_POST['identite']);
    $nid = clean_in_text($_POST['nid_pp']);
    $date_naissance = clean_in_text($_POST['date_naissance']);
    $telephone = clean_in_text($_POST['telephone']);
    $lieu_naissance = clean_in_text($_POST['lieu_naissance']);
    $nbre_enfant_famille = clean_in_text($_POST['nbre_enfant_famille']);
    $position_dans_famille = clean_in_text($_POST['position_dans_famille']);
    $numero_passport = clean_in_text($_POST['numero_passport']);
    $date_expiration_pp = clean_in_text($_POST['date_expiration_pp']);
    $ref_agence = clean_in_text($_POST['ref_agence']);
    $promoteur_agence = clean_in_text($_POST['promoteur_agence']);
    $email = clean_in_text($_POST['email']);
    $pin_secret = clean_in_text($_POST['pin_secret']);
    $commentaire_client = clean_in_text($_POST['commentaire_client']);
    $identite_pere=clean_in_text($_POST['identite_pere']);
    $lieu_naissance_pere=clean_in_text($_POST['lieu_naissance_pere']);
    $date_naissance_pere=clean_in_text($_POST['date_naissance_pere']);
    $identite_mere=clean_in_text($_POST['identite_mere']);
    $lieu_naissance_mere=clean_in_text($_POST['lieu_naissance_mere']);
    $date_naissance_mere=clean_in_text($_POST['date_naissance_mere']);
    $sexe=$_POST['sexe'];
    $adresse=clean_in_text($_POST['adresse']);
    $ville_pays=clean_in_text($_POST['ville_pays']);
    $backup_client=get_dossier_data_by_ndel($nid);

    $feedback = update_section_identite_client($_SESSION['my_doc_online'], $identite, $nid, $date_naissance, $telephone, $email, $lieu_naissance, $nbre_enfant_famille, $position_dans_famille, $numero_passport, $date_expiration_pp, $ref_agence, $promoteur_agence, $pin_secret, $commentaire_client,$identite_pere,$lieu_naissance_pere,$date_naissance_pere,$identite_mere,$lieu_naissance_mere,$date_naissance_mere,$sexe,$adresse,$ville_pays);
    $backup_after=get_dossier_data_by_ndel($nid);
    if ($feedback == 1) {
        add_notification("t_dossier", $nid, json_encode($backup_client),json_encode($backup_after), $_SESSION['my_username'], "Edition Compte Dossier");
        $success = "yes";
        $success_message = "Zone identité Client du dossier a été mise à jour avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur mise à jour Zone identité Client du dossier";
    }
}

if (isset($_POST['submit_edit_exetat'])) {
    $annee = $_POST['exetat_annee'];
    $ecole_frequenter = clean_in_text($_POST['ecole_frequenter']);
    $formation = clean_in_text($_POST['formation']);
    $resultat = clean_in_text($_POST['resultat']);
    $ville_obtention = $_POST['ville_obtention'];
    $pays_obtention = (isset($_POST['chk_pays_edit']) && $_POST['chk_pays_edit'] == 'oui') ? $_POST['pays_obtention_edit'] : $_POST['pays_obtention'];

    $feedback = update_dossier_etude_exetat($_POST['idt_dossier_etude'], $annee, $ecole_frequenter, $formation, "EXETAT", $resultat, "EXETAT", $ville_obtention, $pays_obtention);

    if ($feedback == 1) {

        $success = "yes";
        $success_message = "Information sur EXETAT mise à jour avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur mise à jour des information sur EXETAT";
    }
}
if (isset($_POST['submit_add_exetat'])) {
    $annee = $_POST['exetat_annee'];
    $ecole_frequenter = clean_in_text($_POST['ecole_frequenter']);
    $formation = clean_in_text($_POST['formation']);
    $resultat = clean_in_text($_POST['resultat']);
    $ville_obtention = $_POST['ville_obtention'];
    $pays_obtention = $_POST['pays_obtention'];

    $feedback = add_dossier_etude($_SESSION['my_doc_online'], $annee, $ecole_frequenter, $formation, "EXETAT", $resultat, "EXETAT", '', $ville_obtention, $pays_obtention, $_SESSION['username_online']);


    if ($feedback == 1) {

        
        $success = "yes";
        $success_message = "Cursus EXETAT ajouté avec succès" . add_action_no_request($_SESSION['my_doc_online'], 18, 'Valider', $_SESSION['username_online'], 'Oui', 'Ajout Etude : EXETAT');
        ;
    } else {
        $error = "yes";
        $error_message = "Erreur misurvenue lors de l'ajout d'un cursus EXETAT";
    }
}
if (isset($_POST['submit_edit_etude'])) {
    $annee = $_POST['exetat_annee'];
    $ecole_frequenter = clean_in_text($_POST['ecole_frequenter']);
    $formation = clean_in_text($_POST['formation']);
    $resultat = clean_in_text($_POST['resultat']);
    $diplome_obtenu = clean_in_text($_POST['diplome_obtenu']);
    $niveau = clean_in_text($_POST['niveau']);

    $feedback = update_dossier_etude_exetat($_POST['idt_dossier_etude'], $annee, $ecole_frequenter, $formation, $niveau, $resultat, $diplome_obtenu, "", "");

    if ($feedback == 1) {

        $success = "yes";
        $success_message = "Information sur " . $formation . " mise à jour avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur mise à jour des information sur " . $formation;
    }
}
if (isset($_POST['submit_add_etude'])) {
    $annee = $_POST['exetat_annee'];
    $ecole_frequenter = clean_in_text($_POST['ecole_frequenter']);
    $formation = clean_in_text($_POST['formation']);
    $resultat = clean_in_text($_POST['resultat']);
    $diplome_obtenu = clean_in_text($_POST['diplome_obtenu']);
    $niveau = clean_in_text($_POST['niveau']);

    $feedback = add_dossier_etude($_SESSION['my_doc_online'], $annee, $ecole_frequenter, $formation, $niveau, $resultat, $diplome_obtenu, '', '', '', $_SESSION['username_online']);
    if ($feedback == 1) {

        $success = "yes";
        $success_message = "Creation Cursus " . $formation . " fait avec succès " . add_action_no_request($_SESSION['my_doc_online'], 18, 'Valider', $_SESSION['username_online'], 'Oui', 'Ajout Etude : ' . $niveau);
    } else {
        $error = "yes";
        $error_message = "Erreur lors de la creation du cursus  " . $formation;
    }
}


if (isset($_SESSION['my_doc_online']) && intval($_SESSION['my_doc_online']) > 0 && $_SESSION['my_doc_online'] != "NA") {

    $edit = $_SESSION['my_doc_online'];

    $data_dossier = get_dossier_data($edit);
//					echo $edit;
    if ($data_dossier['is_exist'] == 1) {
        $_SESSION['my_doc_online'] = $edit;

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
          $ref_agence=$data_dossier['ref_agence']; */
    } else {


        header("Location: dossier_online.php?error=ok&msg=Ce Profile n'existe pas, vous n'etes pas autorise à la page suivante");
    }
}
$get_active_menu = "dossier_online";
$page_titre = "Vue sur Dossier : " . $data_dossier['identite'] . " NID : " . $data_dossier['nid_pp'];
$page_small_detail = "MyPASS";
$page_location = "Dossier en ligne > Liste des Dossiers";
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
    <?php ?>
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
              <li><a href="dossier_online.php"><i class="fa  fa-close"></i></a><a href="dossier_online.php"><i class="fa fa-dashboard"></i>Accueil |</a>Où suis-je</li>
            <li class="active"><?php echo $page_location;	?></li>
          </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php include_once("php/print_message.php"); ?>
        <!-- Your Page Content Here -->

        <div id="light" class="white_content">
            <a onClick="hide_pop()" class="btn-danger"><i class="fa  fa-close">Fermer Ici</i></a>
<?php
//*******************************Ajout Etude Secondaire****************************
            if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_add_secondaire" && $data_dossier['allow_edit_for_client'] == 1) {

                // $dossier_etude = get_dossier_etude_data(clean_in_integer($_GET['idt_doc_study']));
                if (1) {
                    ?>         

            <form class="form-horizontal"  action="view_doc_editable.php"  method="post">
                        <p align="center"><h4>Enregistrement d'un nouveau Cursus Secondaire</h4></p>
                        <div class="box-body">

                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Année d'obtention</label>
                                <div class="col-sm-6">

                                    <select name="exetat_annee" class="form-control select2">
                                        <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                            <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Ecole Frequentée</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="ecole_frequenter" value="" required>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Option</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="formation" value="" required>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Pourcentage</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="resultat" value="" required>
                                </div> 
                            </div>   
                            
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Niveau</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="niveau" placeholder="Ex : 6eme, 5eme ou 4eme" value="">
                                </div> 

                            </div>



                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                            <button type="submit"  class="btn btn-info pull-right" name="submit_add_etude_sec">Valider l'ajout</button>
                        </div><!-- /.box-footer -->
                    </form>



                    <?php
                } else {
                    
                }
            }
            ?>  
            <?php
//*******************************Editer Diplome ****************************
            if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_add_exetat" && $data_dossier['allow_edit_for_client'] == 1) {


                if (1) {
                    ?>         

                    <form class="form-horizontal"  action="view_doc_editable.php"  method="post">
                        <p align="center"><h4>Nouveau parcours Diplome d'Etat</h4></p>
                        <div class="box-body">

                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Année d'obtention</label>
                                <div class="col-sm-6">

                                    <select name="exetat_annee" class="form-control select2">
                                        <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                            <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Ecole Frequentée</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="ecole_frequenter" value="" required>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Intitulé de la formation</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="formation" value="" required>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Pourcentage</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="resultat" value="" required>
                                </div> 
                            </div>   
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Ville d'obtention</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="ville_obtention" value="">
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Pays</label>
                                <div class="col-sm-6">

                                    <select name="pays_obtention" class="form-control select2">
                                        <?php echo get_combo_liste_pays(); ?>
                                    </select>
                                </div> 

                            </div>



                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                            <button type="submit"  class="btn btn-info pull-right" name="submit_add_exetat">Ajouter la formation</button>
                        </div><!-- /.box-footer -->
                    </form>



                    <?php
                } else {

                    echo "Désolé mais cet enregistrement d'etude n'existe pas dans le système";
                }
            } else {

                if (isset($_POST['btn_action']) && $_POST['btn_action'] == "add_dip_etat") {

                    echo '<p align="center"><h4>Desole vous n avez pas le droit d ajouter une formmation</h4></p>';
                }
            }
            ?>   
            <?php
//*******************************Editer Diplome ****************************
            if (isset($_GET['action']) && $_GET['action'] == "edit_dip_etat" && $data_dossier['allow_edit_for_client'] == 1 && clean_in_integer($_GET['idt_doc_study']) > 0) {

                $dossier_etude = get_dossier_etude_data(clean_in_integer($_GET['idt_doc_study']));
                if ($dossier_etude['is_exist'] == 1) {
                    ?>         

                    <form class="form-horizontal"  action="view_doc_editable.php"  method="post">
                        <p align="center"><h4>Vous éditez l'information sur le Diplome d'Etat</h4></p>
                        <div class="box-body">

                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Année d'obtention</label>
                                <div class="col-sm-6">
                                    <input type="hidden" name='idt_dossier_etude' value="<?php echo $dossier_etude['idt_dossier_etude']; ?>">
                                    <select name="exetat_annee" class="form-control select2">
                                        <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                            <option value="<?php echo $i; ?>" <?php echo ($i == $dossier_etude['annee']) ? "selected" : ""; ?>><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Ecole Frequentée</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="ecole_frequenter" value="<?php echo $dossier_etude['institution']; ?>" required>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Intitulé de la formation</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="formation" value="<?php echo $dossier_etude['formation']; ?>" required>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Pourcentage</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="resultat" value="<?php echo $dossier_etude['resultat']; ?>" required>
                                </div> 
                            </div>   
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Ville d'obtention</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="ville_obtention" value="<?php echo $dossier_etude['ville_obtention']; ?>">
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Pays</label>
                                <div class="col-sm-6">
                                    <input type="text" name="pays_obtention" class="form-control"  value="<?php echo $dossier_etude['pays_obtention']; ?>" readonly>
                                    <select name="pays_obtention_edit" class="form-control select2" disabled="true" id="pays_obtention_edit">
                                        <?php echo get_combo_liste_pays(); ?>
                                    </select><input type="checkbox" name="chk_pays_edit" value="oui" onchange="document.getElementById('pays_obtention_edit').disabled = !this.checked;"> Cocher pour changer de pays
                                </div> 

                            </div>



                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                            <button type="submit"  class="btn btn-info pull-right" name="submit_edit_exetat">Valider les modifications</button>
                        </div><!-- /.box-footer -->
                    </form>



                    <?php
                } else {

                    echo "Désolé mais cet enregistrement d'etude n'existe pas dans le système";
                }
            } else {

                if (isset($_GET['action']) && $_GET['action'] == "edit_dip_etat") {

                    echo '<p align="center"><h4>Desole vous n avez pas le droit de modifier ces informations</h4></p>';
                }
            }
            ?>   
            <?php
//*******************************Editer Diplome ****************************
            if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_add_etude" && $data_dossier['allow_edit_for_client'] == 1) {

                // $dossier_etude = get_dossier_etude_data(clean_in_integer($_GET['idt_doc_study']));
                if (1) {
                    ?>         

                    <form class="form-horizontal"  action="view_doc_editable.php"  method="post">
                        <p align="center"><h4>Enregistrement d'un nouveau Cursus Post-Secondaire</h4></p>
                        <div class="box-body">

                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Année d'obtention</label>
                                <div class="col-sm-6">

                                    <select name="exetat_annee" class="form-control select2">
                                        <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                            <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Ecole Frequentée</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="ecole_frequenter" value="" required>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Option</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="formation" value="" required>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Pourcentage</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="resultat" value="" required>
                                </div> 
                            </div>   
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Diplome Obtenu</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="diplome_obtenu" value="">
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Niveau</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="niveau" value="">
                                </div> 

                            </div>



                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                            <button type="submit"  class="btn btn-info pull-right" name="submit_add_etude">Valider l'ajout du cursus</button>
                        </div><!-- /.box-footer -->
                    </form>



                    <?php
                } else {
                    
                }
            }
            ?> 
            <?php
//*******************************Editer Diplome ****************************
            if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_add_file" && $data_dossier['allow_edit_for_client'] == 1) {

                // $dossier_etude = get_dossier_etude_data(clean_in_integer($_GET['idt_doc_study']));
                if (1) {
                    ?>         

                    <form class="form-horizontal"  action="view_doc_editable.php"  method="post" enctype="multipart/form-data">
                        <p align="center"><h4>Ajouter un document au Dossier</h4></p>
                        <div class="box-body">


                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Titre Document</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="titre_document" value=""  required="true">
                                </div> 
                            </div>

                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Attachez votre fichier Ici</label>
                                <div class="col-sm-6">
                                    <input name="doc_file" type="file" accept=".jpeg,.jpg,.png,.pdf">
                                </div> 

                            </div>



                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                            <button type="submit"  class="btn btn-info pull-right" name="submit_add_doc">Valider l'ajout du cursus</button>
                        </div><!-- /.box-footer -->
                    </form>



                    <?php
                } else {
                    
                }
            }
            ?> 
            <?php
//*******************************Editer Diplome ****************************
            if (isset($_GET['action']) && $_GET['action'] == "edit_etude" && $data_dossier['allow_edit_for_client'] == 1 && clean_in_integer($_GET['idt_doc_study']) > 0) {

                $dossier_etude = get_dossier_etude_data(clean_in_integer($_GET['idt_doc_study']));
                if ($dossier_etude['is_exist'] == 1) {
                    ?>         

                    <form class="form-horizontal"  action="view_doc_editable.php"  method="post">
                        <p align="center"><h4>Vous éditez les informations un Cursus</h4></p>
                        <div class="box-body">

                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Année d'obtention</label>
                                <div class="col-sm-6">
                                    <input type="hidden" name='idt_dossier_etude' value="<?php echo $dossier_etude['idt_dossier_etude']; ?>">
                                    <select name="exetat_annee" class="form-control select2">
                                        <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                            <option value="<?php echo $i; ?>" <?php echo ($i == $dossier_etude['annee']) ? "selected" : ""; ?>><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Ecole Frequentée</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="ecole_frequenter" value="<?php echo $dossier_etude['institution']; ?>" required>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Option</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="formation" value="<?php echo $dossier_etude['formation']; ?>" required>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Pourcentage</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="resultat" value="<?php echo $dossier_etude['resultat']; ?>" required>
                                </div> 
                            </div>   
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Diplome Obtenu</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="diplome_obtenu" value="<?php echo $dossier_etude['diplome_obtenu']; ?>">
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Niveau</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="niveau" value="<?php echo $dossier_etude['niveau']; ?>">
                                </div> 

                            </div>



                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                            <button type="submit"  class="btn btn-info pull-right" name="submit_edit_etude">Valider les modifications</button>
                        </div><!-- /.box-footer -->
                    </form>



                    <?php
                } else {

                    echo "Désolé mais cet enregistrement d'etude n'existe pas dans le système";
                }
            } else {

                if (isset($_GET['action']) && $_GET['action'] == "edit_etude") {

                    echo '<p align="center"><h4>Desole vous n avez pas le droit de modifier ces informations</h4></p>';
                }
            }
            ?> 
            <?php
//*******************************Enregistrer un paiement ****************************
            if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_paiement" && $data_dossier['allow_edit_for_client'] == 1) {

                $dossier_etude = get_dossier_data(clean_in_integer($_SESSION['my_doc_online']));
                if ($dossier_etude['is_exist'] == 1) {
                    ?>         

                    <form class="form-horizontal"  action="view_doc_editable.php"  method="post" enctype="multipart/form-data">
                        <p align="center"><h4>Enregistrer un Paiement</h4></p>
                        <div class="box-body">

                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Date de paiement <font color="#FF0000">*</font></label>
                                <div class="col-sm-6">
                                    <input type="text" name="date_paiement" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask placeholder="Jour du paiement" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Mode de paiement</label>
                                <div class="col-sm-6">
                                    <select name="mode_paiement" class="form-control select2">
                                        <option value="CHEQUE">CHEQUE</option>
                                        <option value="ESPECE" selected="">ESPECE</option>
                                        <option value="VIREMENT">VIREMENT</option>
                                        <option value="MPESA">MPESA</option>
                                        <option value="ORANGE_MONEY">ORANGE_MONEY</option>
                                        <option value="AIRTEL_MONEY">AIRTEL_MONEY</option>
                                        <option value="">AUTRES</option>
                                    </select>
                                    <input type="text" class="form-control" name="mode_paiement_autre"  placeholder="Précisez si element pas dans la liste" >
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Montant <font color="#FF0000">*</font></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="montant"  placeholder="Montant payé" required>
                                    <select name="devise" class="form-control select2">
                                        <option value="USD">USD</option>
                                        <option value="CDF">CDF</option>

                                    </select>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Operation</label>
                                <div class="col-sm-6">
                                    <select name="ref_operation" class="form-control select2">
                                        <?php echo getcombo_operation_paiement(''); ?>
                                    </select>
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Commentaire</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="commentaire"  placeholder="Avez vous un commentaire?" >
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Notification au client</label>
                                <div class="col-sm-6">
                                    SMS (<?php echo $dossier_etude["numero_telephone"]; ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true"> | Email (<?php echo $dossier_etude["email"]; ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> checked="true">
                                </div> 

                            </div>



                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                            <button type="submit"  class="btn btn-info pull-right" name="submit_add_paiement">Valider l'enregistrement du Paiement</button>
                        </div><!-- /.box-footer -->
                    </form>



                    <?php
                } else {

                    echo "Désolé mais cet enregistrement n'existe pas dans le système";
                }
            }
            ?> 
            <?php
//*******************************Demande Information ****************************
            if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_request_info" && $data_dossier['allow_edit_for_client'] == 1) {

                $dossier_etude = get_dossier_data(clean_in_integer($_SESSION['my_doc_online']));
                if ($dossier_etude['is_exist'] == 1) {
                    ?>         

                    <form class="form-horizontal"  action="view_doc_editable.php"  method="post">
                        <p align="center"><h4>Demander une information au Client</h4></p>
                        <div class="box-body">




                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Operation</label>
                                <div class="col-sm-10">
                                    <select name="ref_operation" class="form-control select2">
                                        <?php echo getcombo_operation_groupement('Demande_information'); ?>
                                    </select>
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Commentaires</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="commentaire"  placeholder="Decrivez votre demande en 100 caractères" maxlength="110">
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Contact reponse</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="feedback_phone" value="0827000755"  placeholder="Precisez le numero a la quel le client doit repondre" >
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Contact email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="feedback_email" value="admin@passportsarl.voyage"  placeholder="Precisez l'email  a la quel le client doit repondre" >
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Notification au client</label>
                                <div class="col-sm-6">
                                    SMS (<?php echo $dossier_etude["numero_telephone"]; ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true"> | Email (<?php echo $dossier_etude["email"]; ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> checked="true">
                                </div> 

                            </div>



                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                            <button type="submit"  class="btn btn-info pull-right" name="submit_request_info">Valider la demande d'information</button>
                        </div><!-- /.box-footer -->
                    </form>



                    <?php
                } else {

                    echo "Désolé mais cet enregistrement n'existe pas dans le système";
                }
            }
            ?> 
            <?php
//*******************************Demande Document ****************************
            if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_demande_doc" && $data_dossier['allow_edit_for_client'] == 1) {

                $dossier_etude = get_dossier_data(clean_in_integer($_SESSION['my_doc_online']));
                if ($dossier_etude['is_exist'] == 1) {
                    ?>         

                    <form class="form-horizontal"  action="view_doc_editable.php"  method="post">
                        <p align="center"><h4>Demander un document au Client</h4></p>
                        <div class="box-body">




                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Operation</label>
                                <div class="col-sm-10">
                                    <select name="ref_operation" class="form-control select2">
                                        <?php echo getcombo_operation_groupement('Demande_document'); ?>
                                    </select>
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Mode de reception</label>
                                <div class="col-sm-10">
                                    <select name="mode_reception" class="form-control select2">
                                        <option value="Depot Physique">Depot Physique</option>
                                        <option value="Par Mail" selected="">Par Mail</option>

                                    </select>

                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Date limite </label>
                                <div class="col-sm-10">
                                    <input type="text" name="date_limite" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="Definissez la date avant laquelle ce docuument doit vous parvenir" required>
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Commentaires</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="commentaire"  placeholder="Decrivez votre demande en 100 caractères" maxlength="110">
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Contact reponse</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="feedback_phone" value="0827000755"  placeholder="Precisez le numero a la quel le client doit repondre" >
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Contact email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="feedback_email" value="admin@passportsarl.voyage"  placeholder="Precisez l'email  a la quel le client doit repondre" >
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Notification au client</label>
                                <div class="col-sm-6">
                                    SMS (<?php echo $dossier_etude["numero_telephone"]; ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true"> | Email (<?php echo $dossier_etude["email"]; ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> checked="true">
                                </div> 

                            </div>



                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                            <button type="submit"  class="btn btn-info pull-right" name="submit_request_doc">Valider la demande d'information</button>
                        </div><!-- /.box-footer -->
                    </form>



                    <?php
                } else {

                    echo "Désolé mais cet enregistrement n'existe pas dans le système";
                }
            }
            ?> 
            <?php
//*******************************Enregistrer un Commentaire pour le Client ****************************
            if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_commentaire_externe" && $data_dossier['allow_edit_for_client'] == 1) {

                $dossier_etude = get_dossier_data(clean_in_integer($_SESSION['my_doc_online']));
                if ($dossier_etude['is_exist'] == 1) {
                    ?>         

                    <form class="form-horizontal"  action="view_doc_editable.php"  method="post">
                        <p align="center"><h4>Enregistrer un Commentaire pour le Client</h4></p>
                        <div class="box-body">




                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Operation</label>
                                <div class="col-sm-10">
                                    <select name="ref_operation" class="form-control select2">
                                        <?php echo getcombo_operation_groupement('Commentaire_externe'); ?>
                                    </select>
                                </div> 

                            </div>

                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Commentaires</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="commentaire"  placeholder="Decrivez votre demande en 100 caractères" maxlength="110">
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Contact reponse</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="feedback_phone" value="0827000755"  placeholder="Precisez le numero a la quel le client doit repondre" >
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Contact email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="feedback_email" value="admin@passportsarl.voyage"  placeholder="Precisez l'email  a la quel le client doit repondre" >
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Notification au client</label>
                                <div class="col-sm-6">
                                    SMS (<?php echo $dossier_etude["numero_telephone"]; ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true"> | Email (<?php echo $dossier_etude["email"]; ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> checked="true">
                                </div> 

                            </div>



                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                            <button type="submit"  class="btn btn-info pull-right" name="submit_commentaire_client">Valider la demande d'information</button>
                        </div><!-- /.box-footer -->
                    </form>



                    <?php
                } else {

                    echo "Désolé mais cet enregistrement n'existe pas dans le système";
                }
            }
            ?> 
            <?php
//*******************************Enregistrer un Commentaire pour le Client ****************************
            if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_commentaire_interne" && $data_dossier['allow_edit_for_client'] == 1) {

                $dossier_etude = get_dossier_data(clean_in_integer($_SESSION['my_doc_online']));
                if ($dossier_etude['is_exist'] == 1) {
                    ?>         

                    <form class="form-horizontal"  action="view_doc_editable.php"  method="post">
                        <p align="center"><h4>Enregistrer un Commentaire sur le Dossier en Interne</h4></p>
                        <div class="box-body">




                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Operation</label>
                                <div class="col-sm-10">
                                    <select name="ref_operation" class="form-control select2">
                                        <?php echo getcombo_operation_groupement('Commentaire_interne'); ?>
                                    </select>
                                </div> 

                            </div>

                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Commentaires</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="commentaire"  placeholder="Decrivez votre demande en 100 caractères" maxlength="110">
                                </div> 

                            </div>


                            <div class="form-group">
                                <label  class="col-sm-6 control-label">Notification au client</label>
                                <div class="col-sm-6">
                                    SMS (<?php echo $dossier_etude["numero_telephone"]; ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> > | Email (<?php echo $dossier_etude["email"]; ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> >
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Contact reponse</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="feedback_phone" value="0827000755"  placeholder="Precisez le numero a la quel le client doit repondre" >
                                </div> 

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Contact email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="feedback_email" value="admin@passportsarl.voyage"  placeholder="Precisez l'email  a la quel le client doit repondre" >
                                </div> 

                            </div>


                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                            <button type="submit"  class="btn btn-info pull-right" name="submit_commentaire_interne">Valider la demande d'information</button>
                        </div><!-- /.box-footer -->
                    </form>



                    <?php
                } else {

                    echo "Désolé mais cet enregistrement n'existe pas dans le système";
                }
            }
            ?> 

        </div>
        <div id="fade" class="black_overlay"></div>    
        <!-- Horizontal Form -->
        <form class="form-horizontal" action="view_doc_editable.php"  method="post">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Identité Dossier : <?php echo $data_dossier['identite'] . ' | <font color="GREEN">Statut Dossier = '.$data_dossier['statut_dossier'].'</font> | <font color="#FF0000">NID : ' . $data_dossier['ndel'] . '</font>'; ?></h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>


                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">




                </div><!-- /.box-body -->
                <!-- /.box-footer -->

            </div><!-- /.box -->

        </form>   

        <form action="view_doc_editable.php"  method="post" >

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">1. IDENTITE DU CLIENT</h3>
                    <a href="#fichier" class="btn btn-adn left" ><i class="fa  fa-arrow-right">Téléverser mes Fichiers</i></a>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Nom complet (tel que dans le passport) <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="identite"  placeholder="Entrez votre nom tel dans le passport ici" value="<?php echo $data_dossier['identite']; ?>"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label"><font color="#FF0000">NID (*)------------------------------------------------------------------->></font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="nid_pp"  placeholder="Remplissez le NID si le frais de dossier est payé" value="<?php echo $data_dossier['ndel']; ?>" readonly="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label"><font color="#FF0000">PIN SECRET (*)-------------------------------------------------------->></font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="pin_secret"  placeholder="Remplissez le PIN Secret pour le Client" value="<?php echo $data_dossier['pin_secret']; ?>" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Date de naissance <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" name="date_naissance" required class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask placeholder="Entrez votre date de naissance Jour-Mois-Année" value="<?php echo $data_dossier['date_naissance']; ?>"  >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Lieu de naissance <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" required class="form-control" name="lieu_naissance"  value="<?php echo $data_dossier['lieu_naissance']; ?>"  >
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Numéro Passeport <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="numero_passport" value="<?php echo $data_dossier['numero_passport']; ?>"  >
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Date d'expiration Passeport <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">

                            <input type="text" name="date_expiration_pp"  class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask placeholder="Entrez la date d'expiration de votre passport" value="<?php echo $data_dossier['date_expiration_pp']; ?>"  >
                        </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Sexe <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                      <select name="sexe" class="form-control select2">
                      <option value="Masculin" <?php echo ($data_dossier['sexe']=="") ? "selected" : ""; ?>></option>
                      <option value="Masculin" <?php echo ($data_dossier['sexe']=="Masculin") ? "selected" : ""; ?>>Masculin</option>
                       <option value="Feminin" <?php echo ($data_dossier['sexe']=="Feminin") ? "selected" : ""; ?>>Feminin</option>
                       </select>
                      </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Email <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="email" name="email"  class="form-control" value="<?php echo $data_dossier['email']; ?>"  >
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Téléphone <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" name="telephone" required class="form-control" value="<?php echo $data_dossier['numero_telephone']; ?>"  data-inputmask='"mask": "(999) 99-999-9999"' data-mask >
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Comment avez-vous connu notre agence ?</label>
                        <div class="col-sm-6">
                            <input type="text" name="promoteur_agence"  required class="form-control"  value="<?php echo $data_dossier['promoteur_agence']; ?>"  >
                        </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Nom complet de votre père biologique (tel que dans votre acte de naissance) <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="identite_pere" value="<?php echo $data_dossier['identite_pere']; ?>"  placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans votre acte de naissance">
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Lieu de naissance de votre père <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="lieu_naissance_pere"  placeholder="Entrez le lieu de naissance" value="<?php echo $data_dossier['lieu_naissance_pere']; ?>">
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Date de naissance de votre père <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                          <input type="text" name="date_naissance_pere" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" value="<?php echo $data_dossier['date_naissance_pere']; ?>" data-mask placeholder="Entrez la date de naissance de votre pere Année-Mois-Jour" >
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Nom complet de votre mère biologique (tel que dans votre acte de naissance) <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="identite_mere" value="<?php echo $data_dossier['identite_mere']; ?>"  placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans votre acte de naissance" >
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Lieu de naissance de votre mère <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="lieu_naissance_mere" value="<?php echo $data_dossier['lieu_naissance_mere']; ?>"  placeholder="Entrez le lieu de naissance" >
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Date de naissance de votre mère <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" name="date_naissance_mere" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" value="<?php echo $data_dossier['date_naissance_mere']; ?>" data-mask placeholder="Entrez la date de naissance de votre mère Année-Mois-Jour" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Adresse physique actuelle<font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                          <input type="text" name="adresse" class="form-control"  placeholder="Entrez votre adresse (num, av, quartier et commune)" value="<?php echo $data_dossier['adresse']; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Ville et Pays de résidence actuelle<font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                          <input type="text" name="ville_pays" class="form-control"  placeholder="Entrez votre ville et le pays (Ville , Pays)" value="<?php echo $data_dossier['ville_pays']; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Vous etes issue d'une famille de combien d'enfants</label>
                        <div class="col-sm-6">
                            <select name="nbre_enfant_famille" class="form-control select2">
                                <?php for ($i = 0; $i < 40; $i++) { ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($i == $data_dossier['nbre_enfant_famille']) ? "selected" : ""; ?>><?php echo $i; ?></option>
                                <?php } ?>
                            </select>


                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Vous etes quantième dans la famille</label>
                        <div class="col-sm-6">
                            <select name="position_dans_famille" class="form-control select2">
                                <?php for ($i = 0; $i < 40; $i++) { ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($i == $data_dossier['position_dans_famille']) ? "selected" : ""; ?>><?php echo $i; ?></option>
                                <?php } ?>
                            </select>


                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">A quelle agence voulez-vous suivre le dossier ?</label>
                        <div class="col-sm-6">
                            <select name="ref_agence" class="form-control select2" >

                                <?php echo getcombo_agence($data_dossier['ref_agence']); ?>
                            </select>

                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label  class="col-sm-6 control-label"><font color="#FF0000">Autre chose à nous informer? Merci de le mentionner ici (Max 200 caractères)---------> </font></label>
                        <div class="col-sm-6">
                            <textarea name="commentaire_client" cols="100%" rows="3" class="form-control"><?php echo $data_dossier['commentaire_client']; ?></textarea>

                        </div>
                    </div>       




                </div><!-- /.box-body -->
                <div class="box-footer">
                    <i class="fa fa-warning">Important à savoir</i><br>
                    <font color="#FF0000">*</font> : Champs conditionnées par un remplissage obligatoire
                    <button type="submit"  class="btn btn-info pull-right" name="btn_edition_identite_client" <?php echo ($data_dossier['allow_edit_for_client'] == 0) ? 'disabled' : "" ?>>Valider les Modifications de l'identité du Client</button>
                </div>

            </div>

        </form>
        <!-- /.box -->
        <form action="view_doc_editable.php"  method="post" >
            <div class="box box-info" style="overflow-y: scroll;">
                <div class="box-header with-border">
                    <h3 class="box-title">2. PARCOURS D'ETUDES</h3>
                    <button type="submit"  class="btn btn-info pull-right" name="btn_action" value="btn_add_secondaire" <?php echo $data_dossier['allow_edit_for_client'] == 0 ? "disabled" : "" ?>><i class="fa  fa-plus-circle">Ajouter un parcours Secondaire</i></button>
                    <button type="submit"  class="btn btn-info pull-right" name="btn_action" value="btn_add_exetat" <?php echo $data_dossier['allow_edit_for_client'] == 0 ? "disabled" : "" ?>><i class="fa  fa-plus-circle">Ajouter un parcours EXETAT</i></button>
                    <button type="submit"  class="btn btn-info pull-right" name="btn_action" value="btn_add_etude" <?php echo $data_dossier['allow_edit_for_client'] == 0 ? "disabled" : "" ?>><i class="fa  fa-plus-circle">Ajouter un parcours Post Secondaire</i></button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <h5>2.1. Votre Parcours Secondaire</h5>
                    <table class="table table-condensed">
                        <tr>
                            <th>#</th>
                            <th>Année</th>
                            <th>Etablissement</th>
                            <th>Option</th>
                            <th>Niveau</th>
                            <th>Résultats</th>  
                            <th>Date Ajout</th>
                            <th>Actions</th>


                        </tr>
                        <?php
                        $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu='SECONDAIRE' and ref_dossier=" . $data_dossier['idt_dossier'] . " and view_doc=1";
                        //echo $sql_select1;

                        $sql_result1 = $bdd->query($sql_select1);

                        $index2 = 0;

                        while ($data1 = $sql_result1->fetch()) {
                            $index2++;
                            ?>
                            <tr>
                                <td><?php echo $index2; ?></td>
                                <td><?php echo $data1['annee']; ?> </td>
                                <td><?php echo $data1['institution']; ?></td>
                                <td><?php echo $data1['formation']; ?></td>
                                <td><?php echo $data1['niveau']; ?></td>                      
                                <td><?php echo $data1['resultat']; ?></td> 
                                <td><?php echo $data1['creationdate']; ?></td>
                                <td>
                                    <?php echo ($data_dossier['allow_edit_for_client'] == 1) ? '<a href="view_doc_editable.php?action=edit_etude&idt_doc_study=' . $data1['idt_dossier_etude'] . '"><i class="fa  fa-edit"></i></a>' : ""; ?>
                                    <?php echo ($data_dossier['allow_edit_for_client'] == 1 && 0) ? '<a href="view_doc_editable.php?del_etude=yes&idt_doc_study=' . $data1['idt_dossier_etude'] . '" onClick="return confirm(' . "'Cette action va supprimer le cursus, Veuillez confirmer?'" . ')"><i class="fa  fa-cut"></i></a>' : ""; ?>
                                </td>                  

                            </tr>

                            <?php
                        }
                        ?>	    
                    </table>
                    <br>
                    <h5>2.2. Diplome d'Etat ou son équivalent</h5>
                    <table class="table table-condensed">
                        <tr>
                            <th></th>
                            <th>Année obtention</th>
                            <th>Ecole fréquentée</th>
                            <th>Option</th>
                            <th>Pourcentage</th>
                            <th>Pays d'obtention</th>  
                            <th>Ville d'obtention</th>
                            <th>Date Ajout</th>
                            <th>Actions</th>


                        </tr>
                        <?php
                        $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu='EXETAT' and ref_dossier=" . $data_dossier['idt_dossier'] . " and view_doc=1";
//echo $sql_select1;

                        $sql_result1 = $bdd->query($sql_select1);

                        $index = 0;

                        while ($data1 = $sql_result1->fetch()) {
                            ?>
                            <tr>
                                <td></td>
                                <td>
                                    <?php echo $data1['annee']; ?>
                                </td>
                                <td><?php echo $data1['institution']; ?></td>
                                <td><?php echo $data1['formation']; ?></td>
                                <td><?php echo $data1['resultat']; ?></td>                      
                                <td><?php echo $data1['pays_obtention']; ?></td>  
                                <td><?php echo $data1['ville_obtention']; ?></td>
                                <td><?php echo $data1['creationdate']; ?></td>
                                <td>
                                    <?php echo ($data_dossier['allow_edit_for_client'] == 1) ? '<a href="view_doc_editable.php?action=edit_dip_etat&idt_doc_study=' . $data1['idt_dossier_etude'] . '"><i class="fa  fa-edit"></i></a>' : ""; ?>
                                    <?php echo ($data_dossier['allow_edit_for_client'] == 1 && 0) ? '<a href="view_doc_editable.php?del_etude=yes&idt_doc_study=' . $data1['idt_dossier_etude'] . '" onClick="return confirm(' . "'Cette action va supprimer le cursus, Veuillez confirmer?'" . ')"><i class="fa  fa-cut"></i></a>' : ""; ?>


                                </td>


                            </tr>
                        <?php } ?>
                    </table>
                    <br>
                    <h5>2.3. Votre parcours post-secondaire (Remplir par l'année la plus recente)</h5>
                    <table class="table table-condensed">
                        <tr>
                            <th>#</th>
                            <th>Année</th>
                            <th>Etablissement</th>
                            <th>Intitulé de la formation</th>
                            <th>Niveau</th>
                            <th>Résultats</th>  
                            <th>Diplome Obtenu</th> 
                            <th>Date Ajout</th>
                            <th>Actions</th>


                        </tr>
                        <?php
                        $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu not in ('EXETAT','SECONDAIRE')  and ref_dossier=" . $data_dossier['idt_dossier'] . " and view_doc=1";
//echo $sql_select1;

                        $sql_result1 = $bdd->query($sql_select1);

                        $index2 = 0;

                        while ($data1 = $sql_result1->fetch()) {
                            $index2++;
                            ?>
                            <tr>
                                <td><?php echo $index2; ?></td>
                                <td><?php echo $data1['annee']; ?> </td>
                                <td><?php echo $data1['institution']; ?></td>
                                <td><?php echo $data1['formation']; ?></td>
                                <td><?php echo $data1['niveau']; ?></td>                      
                                <td><?php echo $data1['resultat']; ?></td> 
                                <td><?php echo $data1['diplome_obtenu']; ?></td> 
                                <td><?php echo $data1['creationdate']; ?></td>
                                <td>
                                    <?php echo ($data_dossier['allow_edit_for_client'] == 1) ? '<a href="view_doc_editable.php?action=edit_etude&idt_doc_study=' . $data1['idt_dossier_etude'] . '"><i class="fa  fa-edit"></i></a>' : ""; ?>
                                    <?php echo ($data_dossier['allow_edit_for_client'] == 1 && 0) ? '<a href="view_doc_editable.php?del_etude=yes&idt_doc_study=' . $data1['idt_dossier_etude'] . '" onClick="return confirm(' . "'Cette action va supprimer le cursus, Veuillez confirmer?'" . ')"><i class="fa  fa-cut"></i></a>' : ""; ?>
                                </td>                  

                            </tr>

                            <?php
                        }
                        ?>	    
                    </table>





                </div><!-- /.box-body -->


            </div>
            <div class="box box-info" id="fichier" style="overflow: scroll;">
                <div class="box-header with-border">
                    <h3 class="box-title">FICHIERS TELECHARGES</h3>
                    <button type="submit"  class="btn btn-info pull-right" name="btn_action" value="btn_add_file" <?php echo $data_dossier['allow_edit_for_client'] == 0 ? "disabled" : "" ?>><i class="fa  fa-plus-circle">Ajouter un document</i></button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <font color='red'>Vous pouvez ajouter vos  diplomes, CV, Attestation de naissance, copie de passeport et autres ici</font>   

                    <table class="table table-condensed">
                        <tr>
                            <th>#</th>
                            <th>Titre document</th>
                            <th>ajouté le </th>
                            <th>Type</th>
                            <th>Actions</th>



                        </tr>
                        <?php
                        $sql_select1 = "SELECT * FROM passport_bd.t_document_dossier where ref_dossier=" . $data_dossier['idt_dossier'] . " and view_doc=1";
//echo $sql_select1;

                        $sql_result1 = $bdd->query($sql_select1);

                        $index2 = 0;

                        while ($data1 = $sql_result1->fetch()) {
                            $index2++;
                            ?>
                            <tr>
                                <td><?php echo $index2; ?></td>
                                <td><?php echo $data1['titre_document']; ?> </td>
                                <td><?php echo $data1['creationdate']; ?></td>
                                <td><?php echo strtotime($data1['type_fichier']); ?></td>
                                <td>
                                    <a href="<?php echo $data1['url_document']; ?>" download=""><i class="fa  fa-download"></i></a>
                                    <?php echo ($data_dossier['allow_edit_for_client'] == 1 && 0) ? '<a href="view_doc_editable.php?del_doc=yes&idt_doc=' . $data1['idt_document_dossier'] . '" onClick="return confirm(' . "'Cette action va supprimer le fichier, Veuillez confirmer?'" . ')"><i class="fa  fa-cut"></i></a>' : ""; ?>
                                </td>



                            </tr>

                            <?php
                        }
                        ?>	    
                    </table>





                </div><!-- /.box-body -->


            </div>
            <form action="view_doc_editable.php"  method="post" >
                <div class="box box-info" style="overflow: scroll;">
                    <div class="box-header with-border">
                        <h3 class="box-title">3. ACTIVITES PASSEES ET ACTUELLES</h3>

                    </div><!-- /.box-header -->
                    <!-- form start -->


                    <div class="box-body">
                        Parlez-nous de vos activités antérieures (emplois, professions, stages académiques / professionnels ou autres formations pertinentes ainsi que les mois et les années du début et de la fin. si applicable. N'hésitez pas d'être explicite)
                        <div class="form-group">

                            <div class="col-sm-6">
                                <textarea name="activite_passe_actuelle" cols="100%" rows="10" class="form-control"  ><?php echo $data_dossier['activite_passe_actuelle']; ?></textarea>

                            </div>
                        </div>


                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <i class="fa fa-warning">Important à savoir</i><br>
                        <font color="#FF0000">*</font> : Champs conditionnées par un remplissage obligatoire
                        <button type="submit"  class="btn btn-info pull-right" name="btn_edition_emploi" <?php echo $data_dossier['allow_edit_for_client'] == 0 ? "disabled" : "" ?>>Valider les Modifications</button>

                    </div><!-- /.box-footer -->

                </div>
            </form> 

            <form action="view_doc_editable.php"  method="post" >
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">4. VOYAGE</h3>

                    </div><!-- /.box-header -->
                    <!-- form start -->


                    <div class="box-body">
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Ou voulez-vous partir? <font color="#FF0000">*</font></label>
                            <div class="col-sm-6">

                                <input type="text" name="vo_destination" class="form-control"  value="<?php echo $data_dossier['vo_destination']; ?>" readonly>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label"></label>
                            <div class="col-sm-6">

                               
                                <select name="vo_destination_temp" class="form-control select2" disabled="true" id="vo_destination">
                                    <?php echo get_combo_liste_pays(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label"></label>
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>

                                <input type="checkbox" name="chk_vo_destination" value="oui" onchange="document.getElementById('vo_destination').disabled = !this.checked;"> Cocher pour changer de pays
                            </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Raison du voyage <font color="#FF0000">*</font></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="vo_raison_voyage"  value="<?php echo $data_dossier['vo_raison_voyage']; ?>"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Si pour études, qui prendra en charge ces études?</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="vo_charge_etude_parrain"  value="<?php echo $data_dossier['vo_charge_etude_parrain']; ?>"  >

                            </div>
                        </div>
                        <div class="form-group">
                      <label  class="col-sm-6 control-label">Si pour études, quels domaines  vous intéressent ? (donnez trois propositions des programmes)</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="vo_proposition_domaine"  placeholder="quels domaines  vous intéressent ? (donnez trois propositions des programmes)" value="<?php echo $data_dossier['domaine_preference']; ?>" >
                       
                      </div>
                    </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Avez-vous des ancien Visa?</label>
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                <input name="vo_ancien_visa" type="checkbox" value="oui"   <?php echo ($data_dossier['vo_ancien_visa'] == 'oui') ? "checked" : ""; ?> > 
                            </label>
                                </div>
                            </div>


                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Si Oui, précisez os anciens Visa</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="vo_ancien_visa_comment" value="<?php echo $data_dossier['vo_ancien_visa_comment']; ?>"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Avez-vous déjà eu un refus de Visa?</label>
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                <input name="vo_refus_visa_chk" type="checkbox" value="oui"  <?php echo ($data_dossier['vo_refus_visa'] == 'oui') ? "checked" : ""; ?> > 
                            </label>
                                </div>
                            </div>


                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Si Oui, précisez vos anciens refus</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="commentaire_refus_visa" value="<?php echo $data_dossier['vo_refus_visa_comment']; ?>"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Avez-vous une famille à votre lieu de destination?</label>
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                <input name="vo_destination_famille_chk" type="checkbox" value="oui"  <?php echo ($data_dossier['vo_destination_famille'] == 'oui') ? "checked" : ""; ?>> 
                            </label>
                                </div>
                            </div>


                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Si Oui, précisez</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="vo_destination_comment" value="<?php echo $data_dossier['vo_destination_comment']; ?>"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Avez-vous déjà tenté d'obtenir une inscription dans une université étrangère ? </label>
                            <div class="col-sm-1">
                                <input name="vo_obtention_chk" type="checkbox" value="oui" onchange="document.getElementById('universite').readOnly = !this.checked; document.getElementById('pays').readOnly = !this.checked;"> 
                            </div>
                            <label  class="col-sm-5 control-label">Cochez pour modifier</label>
                           

                        </div>
                        <div class="form-group">
                        <label  class="col-sm-6 control-label">De quelle Université s'agit il? </label>
                       

	                    <div class="col-sm-6">
	             
	                        <input type="text" id="universite" name="q_universite" class="form-control"  placeholder="Entrez plusieurs noms si c'est plusieurs universités" value="<?php echo $data_dossier['q_universite']; ?>" readonly>
	                        
	                    </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-6 control-label">Dans quel pays se trouve cette Université? </label>
                        
	                   

	                    <div class="col-sm-6">
	             
	                        
	                        <input type="text" id="pays" name="q_pays" class="form-control"  placeholder="Entrez plusieurs noms si c'est plusieurs pays" value="<?php echo $data_dossier['q_pays']; ?>" readonly>
	                    </div>
                    </div>




                    </div><!-- /.box-body -->
                    <!-- /.box-footer -->
                    <div class="box-footer">
                        <i class="fa fa-warning">Important à savoir</i><br>
                        <font color="#FF0000">*</font> : Champs conditionnées par un remplissage obligatoire
                        <button type="submit"  class="btn btn-info pull-right" name="btn_edition_zone_voyage" <?php echo $data_dossier['allow_edit_for_client'] == 0 ? "disabled" : "" ?>>Valider les Modifications</button>

                    </div><!-- /.box-footer -->
                </div>
            </form>
            <form action="view_doc_editable.php"  method="post" >
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">5. PRISE EN CHARGE</h3>

                    </div><!-- /.box-header -->
                    <!-- form start -->


                    <div class="box-body">
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Votre garant est qui pour vous?<font color="#FF0000">*</font></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="pc_qualite_garant" value="<?php echo $data_dossier['pc_qualite_garant']; ?>"  >
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Où travaille-t-il et quelle responsabilité a-t-il? <font color="#FF0000">*</font></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="pc_lieu_travail_garant"  value="<?php echo $data_dossier['pc_lieu_travail_garant']; ?>"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Quel est son salaire mensuel?</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="pc_salaire_parrain"  value="<?php echo $data_dossier['pc_salaire_parrain']; ?>"  >

                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Possède-t-il une activité commerciale ou une entreprise?</label>
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                <input name="pc_activite_pro_chk" type="checkbox" value="oui" <?php echo $data_dossier['pc_activite_pro'] == "oui" ? "checked" : ""; ?>  > 
                            </label>
                                </div>
                            </div>



                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Si Oui, quel est son nom?</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="pc_activite_pro_nom" value="<?php echo $data_dossier['pc_activite_pro_nom']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Si Oui, Quel revenu mensuel pour cette activité ou entreprise en $ (Estimation)?</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="pc_revenu_parrain" value="<?php echo $data_dossier['pc_revenu_parrain']; ?>"  >
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
                                        <option value="<?php echo $j; ?>" <?php echo ($j == $data_dossier['pc_nbre_parcelle']) ? "selected" : ""; ?>><?php echo $j; ?></option>
                                    <?php } ?>
                                </select>
                            </div>


                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Combien de véhicule dispose-t-il ?</label>
                            <div class="col-sm-6">

                                <select name="pc_nbre_vehicule" class="form-control select2">
                                    <?php for ($j = 0; $j < 21; $j++) { ?>
                                        <option value="<?php echo $j; ?>" <?php echo ($j == $data_dossier['pc_nbre_vehicule']) ? "selected" : ""; ?>><?php echo $j; ?></option>
                                    <?php } ?>
                                </select>
                            </div>


                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Email Facultatif</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="email_secondaire"  value="<?php echo $data_dossier['email_secondaire']; ?>" > 

                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-6 control-label">Téléphone Secondaire</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="numero_telephone_secondaire"  value="<?php echo $data_dossier['numero_telephone_secondaire']; ?>" >

                            </div>
                        </div>


                    </div><!-- /.box-body -->
                    <!-- /.box-footer -->
                    <div class="box-footer">
                        <i class="fa fa-warning">Important à savoir</i><br>
                        <font color="#FF0000">*</font> : Champs conditionnées par un remplissage obligatoire
                        <button type="submit"  class="btn btn-info pull-right" name="btn_edition_zone_charge" <?php echo $data_dossier['allow_edit_for_client'] == 0 ? 'disabled="true"' : "" ?> >Valider les Modifications</button>

                    </div><!-- /.box-footer -->
                </div>
            </form>


        </form>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<footer class="main-footer">
    <?php
    include_once("php/footer.php");
    ?>
</footer>

</div>

<?php
include_once("php/importation_js.php");
//include_once("php/export_to_csv_js.php");
?>
</body>
</html>
