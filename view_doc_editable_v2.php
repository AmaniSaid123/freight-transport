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
$sexe = "";
$adresse = "";
$ville_pays = "";
$domaine_preference = "";
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
    $domaine_preference = clean_in_text($_POST['vo_proposition_domaine']);
    $pc_salaire_parrain = clean_in_text($_POST['pc_salaire_parrain']);
    $pc_activite_pro_chk = clean_in_text($_POST['pc_activite_pro']);
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
    $domaine_preference = clean_in_text($_POST['vo_proposition_domaine']);
    $vo_charge_etude_parrain = clean_in_text($_POST['vo_charge_etude_parrain']);
    $vo_ancien_visa = (isset($_POST['vo_ancien_visa']) && $_POST['vo_ancien_visa'] == 'oui') ? clean_in_text($_POST['vo_ancien_visa']) : "";
    $vo_ancien_visa_comment = clean_in_text($_POST['vo_ancien_visa_comment']);
    $vo_refus_visa_chk = (isset($_POST['vo_refus_visa_chk']) && $_POST['vo_refus_visa_chk'] == 'oui') ? clean_in_text($_POST['vo_refus_visa_chk']) : "";
    $commentaire_refus_visa = clean_in_text($_POST['commentaire_refus_visa']);
    $vo_destination_famille_chk = (isset($_POST['vo_destination_famille_chk']) && $_POST['vo_destination_famille_chk'] == 'oui') ? clean_in_text($_POST['vo_destination_famille_chk']) : "";
    $vo_destination_comment = clean_in_text($_POST['vo_destination_comment']);

    $q_universite = clean_in_text($_POST['q_universite']);
    $q_pays = clean_in_text($_POST['q_pays']);


    $feedback = update_details_zone_voyage($_SESSION['my_doc_online'], $vo_destination, $vo_raison_voyage, $vo_charge_etude_parrain, $vo_ancien_visa, $vo_ancien_visa_comment, $vo_refus_visa_chk, $commentaire_refus_visa, $vo_destination_famille_chk, $vo_destination_comment, $domaine_preference, $q_universite, $q_pays);

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
    $identite_pere = clean_in_text($_POST['identite_pere']);
    $lieu_naissance_pere = clean_in_text($_POST['lieu_naissance_pere']);
    $date_naissance_pere = clean_in_text($_POST['date_naissance_pere']);
    $identite_mere = clean_in_text($_POST['identite_mere']);
    $lieu_naissance_mere = clean_in_text($_POST['lieu_naissance_mere']);
    $date_naissance_mere = clean_in_text($_POST['date_naissance_mere']);
    $sexe = $_POST['sexe'];
    $adresse = clean_in_text($_POST['adresse']);
    $ville_pays = clean_in_text($_POST['ville_pays']);
    $backup_client = get_dossier_data_by_ndel($nid);

    $feedback = update_section_identite_client($_SESSION['my_doc_online'], $identite, $nid, $date_naissance, $telephone, $email, $lieu_naissance, $nbre_enfant_famille, $position_dans_famille, $numero_passport, $date_expiration_pp, $ref_agence, $promoteur_agence, $pin_secret, $commentaire_client, $identite_pere, $lieu_naissance_pere, $date_naissance_pere, $identite_mere, $lieu_naissance_mere, $date_naissance_mere, $sexe, $adresse, $ville_pays);
    $backup_after = get_dossier_data_by_ndel($nid);
    if ($feedback == 1) {
        add_notification("t_dossier", $nid, json_encode($backup_client), json_encode($backup_after), $_SESSION['my_username'], "Edition Compte Dossier");
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
        $success_message = "Cursus EXETAT ajouté avec succès" . add_action_no_request($_SESSION['my_doc_online'], 18, 'Valider', $_SESSION['username_online'], 'Oui', 'Ajout Etude : EXETAT');;
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
$get_active_menu = "dossier_online_v2";
$page_titre = "Vue sur Dossier : " . $data_dossier['identite'] . " NID : " . $data_dossier['nid_pp'] . "MyPASS";
?>

<?php
function hide_mobile_no($number)
{
    return substr($number, 0, 4) . '******' . substr($number, -2);
}

$number = 243815426974;


function obfuscate_email($email)
{
    $em   = explode("@", $email);
    $name = implode('@', array_slice($em, 0, count($em) - 1));
    $len  = 3;
    return substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);
}
$email = "amanisaid740@gmail.com";

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="back/assets/" data-template="vertical-menu-template-free">

<?php
include_once("php/layouts/head-v2-back.php");
?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php
            include_once("php/layouts/menu-v2-back.php");
            ?>
            <div class="layout-page">
                <?php
                include_once("php/layouts/navbar-v2-back.php");
                ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?php include_once("php/print_message_front.php"); ?>
                        <h6 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dossier en ligne /</span> Aperçu Dossier</h6>

                        <div class="row">
                            <div class="col-xxl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0 style-h5"> <?php echo $page_titre;    ?>
                                        </h5>


                                    </div>
                                    <div class="card-body">
                                        <h6 class="box-title">Identité Dossier : <?php echo $data_dossier['identite'] . ' | <font color="GREEN">Statut Dossier = ' . $data_dossier['statut_dossier'] . '</font> | <font color="#FF0000">NID : ' . $data_dossier['ndel'] . '</font>'; ?></h6>

                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" id="msform">

                                            <ul id="progressbar">
                                                <li class="active" id="account"><strong>Identité du client</strong></li>
                                                <li id="personal"><strong>Parcours d'études</strong></li>
                                                <li id="payment"><strong>Activités passés et actuelles</strong></li>
                                                <li id="travel"><strong>Voyage</strong></li>
                                                <li id="charge"><strong>Prise en charge</strong></li>
                                            </ul>
                                            <fieldset>
                                                <div class="form-card">
                                                    <div class="row">
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Nom complet <span class="span-style">(tel que dans le passport) <span>
                                                                            <font color="#FF0000">*</font></label>
                                                                <input class="form-control" type="text" name="identite" placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans le Passeport" value="<?php echo $data_dossier['identite']; ?>">


                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Lieu de naissance <font color="#FF0000">*</font></label>
                                                                <input class="form-control" type="text" name="lieu_naissance" placeholder="Où êtes-vous né(e)?" value="<?php echo $data_dossier['lieu_naissance']; ?>">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label"> Date de naissance <font color="#FF0000">*</font></label>
                                                                <div id="datepicker" class="input-group date" data-date-format="yyyy/mm/dd">
                                                                    <input class="form-control" name="date_naissance" type="text" value="<?php echo $data_dossier['date_naissance']; ?>" />
                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label"> Numéro Passport </label>
                                                                <input class="form-control" type="text" name="numero_passport" placeholder="Entrez votre numero de passport ici" value="<?php echo $data_dossier['numero_passport']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Date d'expiration Passeport</label>
                                                                <input class="form-control" type="text" name="date_expiration_pp" placeholder="Entrez votre date d'expiration de votre passeport Jour-Mois-Année" value="<?php echo $data_dossier['date_expiration_pp']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label"> Sexe <font color="#FF0000">*</font></label>
                                                                <select name="sexe" class="form-select" placeholder="Sexe">
                                                                    <option value="Masculin" <?php echo ($data_dossier['sexe'] == "") ? "selected" : ""; ?>></option>
                                                                    <option value="Masculin" <?php echo ($data_dossier['sexe'] == "Masculin") ? "selected" : ""; ?>>Masculin</option>
                                                                    <option value="Feminin" <?php echo ($data_dossier['sexe'] == "Feminin") ? "selected" : ""; ?>>Feminin</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <label class="control-label">Email <font color="#FF0000">*</font></label>
                                                            <div class="form-group">
                                                                <input class="form-control" type="text" name="email" placeholder="Entrez votre adresse email" value="<?php echo $data_dossier['email']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Téléphone <span class="span-style">(commencez avec le code du pays 243 ou 33)</span>
                                                                    <font color="#FF0000">*</font>
                                                                </label>
                                                                <input type="text" class="form-control" name="telephone" placeholder="Téléphone" value="<?php echo $data_dossier['numero_telephone']; ?>">

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label"> Comment avez-vous connu notre agence ? <font color="#FF0000">*</font></label>
                                                                <input class="form-control" type="text" name="promoteur_agence" placeholder=" Merci de donner tous les détails SVP. (Max 100 caractères)" value="<?php echo $data_dossier['promoteur_agence']; ?>">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <label class="control-label">Nom complet de votre père biologique </label>
                                                            <div class="form-group">
                                                                <input class="form-control" type="text" name="identite_pere" placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans votre acte de naissance" value="<?php echo $data_dossier['identite_pere']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <label class="control-label">Lieu de naissance de votre père </label>
                                                            <div class="form-group">
                                                                <input class="form-control" type="text" name="lieu_naissance_pere" placeholder="Entrez le lieu de naissance" value="<?php echo $data_dossier['lieu_naissance_pere']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Date de naissance de votre père</label>
                                                                <input class="form-control" type="text" name="date_naissance_pere" placeholder="Entrez la date de naissance de votre pere Année-Mois-Jour" value="<?php echo $data_dossier['date_naissance_pere']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Nom complet de votre mère biologique</label>
                                                                <input class="form-control" type="text" name="identite_mere" placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans votre acte de naissance" value="<?php echo $data_dossier['identite_mere']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Lieu de naissance de votre mère </label>
                                                                <input class="form-control" type="text" name="lieu_naissance_mere" placeholder="Entrez le lieu de naissance" value="<?php echo $data_dossier['lieu_naissance_mere']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Date de naissance de votre mère</label>
                                                                <input class="form-control" type="text" name="date_naissance_mere" placeholder="Entrez la date de naissance de votre mère Année-Mois-Jour" value="<?php echo $data_dossier['date_naissance_mere']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Adresse physique actuelle <font color="#FF0000">*</font></label>
                                                                <input class="form-control" type="text" name="adresse" placeholder="Entrez votre adresse (num, av, quartier et commune)" value="<?php echo $data_dossier['adresse']; ?>">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Ville et Pays de résidence actuelle<font color="#FF0000">*</font></label>
                                                                <input class="form-control" type="text" name="ville_pays" placeholder="Entrez votre ville et le pays (Ville , Pays)" value="<?php echo $data_dossier['ville_pays']; ?>">

                                                            </div>
                                                        </div>


                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Vous êtes issue d'une famille de combien d'enfants </label>
                                                                <input class="form-control" type="number" name="nbre_enfant_famille" placeholder="Vous êtes issue d'une famille de combien d'enfants" value="<?php echo $data_dossier['nbre_enfant_famille']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Vous êtes quantième enfant dans la famille? </label>
                                                                <input class="form-control" type="number" name="position_dans_famille" placeholder="Vous êtes quantième enfant dans la famille?" value="<?php echo $data_dossier['position_dans_famille']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Où voulez-vous partir? <font color="#FF0000">*</font></label>
                                                                <select name="vo_destination" class="form-select" placeholder="Où voulez-vous partir?">
                                                                    <?php get_combo_liste_pays(); ?>
                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">A quel bureau voulez-vous suivre le dossier ?</label>

                                                                <select name="ref_agence" class="form-select" placeholder="A quel bureau voulez-vous suivre le dossier ? ">
                                                                    <?php echo getcombo_agence(0); ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    PIN SECRET <font color="#FF0000"> *</font>
                                                                </label>
                                                                <input type="text" class="form-control" name="pin_secret" placeholder="Remplissez le PIN Secret pour le Client" value="<?php echo $data_dossier['pin_secret']; ?>" readonly="true">

                                                            </div>
                                                        </div>


                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Autre chose à nous informer? Merci de le mentionner ici
                                                                </label>
                                                                <textarea name="commentaire_client" cols="100%" rows="3" class="form-control"><?php echo $data_dossier['commentaire_client']; ?></textarea>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <br>
                                                </div>
                                                <button type="submit" class="btn btn-info pull-right btn-submit-edit" name="btn_edition_identite_client">Valider les Modifications de l'identité du Client </button>
                                                <input type="button" name="next" class="next action-button" value="Suivant" />
                                            </fieldset>
                                            <fieldset>
                                                <div class="form-card">
                                                    <div style="overflow-x:auto;">
                                                        <?php $actual_year = clean_in_integer(date("Y")); //echo $actual_year; 
                                                        ?>
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#backDropModalSecondaire">
                                                            Parcours Secondaire
                                                        </button>

                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#backDropModal">
                                                            Parcours Post Secondaire
                                                        </button>
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#backDropModalEXETAT">
                                                            Parcours EXETAT
                                                        </button>
                                                        <button type="button" class="btn btn-primary" name="btn_action" data-bs-toggle="modal" data-bs-target="#backDropModalDoc" value="btn_add_file" <?php echo $data_dossier['allow_edit_for_client'] == 0 ? "disabled" : "" ?>>
                                                            Ajouter un document
                                                        </button>

                                                        <!-- Bordered Table -->
                                                        <div class="card">
                                                            <h6 class="card-header">2.1. Votre Parcours Secondaire (Les 3 dernieres années seulement)</h6>
                                                            <div class="card-body">
                                                                <div class="table-responsive text-nowrap">
                                                                    <table class="table table-bordered">
                                                                        <thead>
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
                                                                        </thead>
                                                                        <tbody>


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

                                                                                        <?php echo ($data_dossier['allow_edit_for_client'] == 1) ? '<a href="view_doc_editable_v2.php?action=edit_etude&idt_doc_study=' . $data1['idt_dossier_etude'] . '"><i class="bx bx-edit-alt me-1"></i></a>' : ""; ?>
                                                                                        <?php echo ($data_dossier['allow_edit_for_client'] == 1 && 0) ? '<a href="view_doc_editable_v2.php?del_etude=yes&idt_doc_study=' . $data1['idt_dossier_etude'] . '" onClick="return confirm(' . "'Cette action va supprimer le cursus, Veuillez confirmer?'" . ')"><i class="bx bx-trash me-1"></i></a>' : ""; ?>
                                                                                    </td>
                                                                                </tr>

                                                                            <?php
                                                                            }
                                                                            ?>


                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/ Bordered Table -->


                                                        <div class="card">
                                                            <h6 class="card-header">2.2. Diplome d'Etat ou son équivalent</h6>
                                                            <div class="card-body">
                                                                <div class="table-responsive text-nowrap">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Année obtention</th>
                                                                                <th>Ecole fréquentée</th>
                                                                                <th>Option</th>
                                                                                <th>Pourcentage</th>
                                                                                <th>Pays d'obtention</th>
                                                                                <th>Ville d'obtention</th>
                                                                                <th>Date Ajout</th>
                                                                                <th>Actions</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <?php
                                                                            $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu='EXETAT' and ref_dossier=" . $data_dossier['idt_dossier'] . " and view_doc=1";
                                                                            //echo $sql_select1;

                                                                            $sql_result1 = $bdd->query($sql_select1);

                                                                            $index2 = 0;


                                                                            while ($data1 = $sql_result1->fetch()) {
                                                                                $index2++;
                                                                            ?>
                                                                                <tr>

                                                                                    <td><?php echo $index2; ?></td>
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
                                                                                        <a href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> </a>
                                                                                        <a href="javascript:void(0);"><i class="bx bx-trash me-1"></i> </a>
                                                                                    </td>


                                                                                </tr>
                                                                            <?php } ?>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="card">
                                                            <h6 class="card-header">2.3. Votre parcours post-secondaire (Remplir par l'année la plus recente)</h6>
                                                            <div class="card-body">
                                                                <div class="table-responsive text-nowrap">
                                                                    <table class="table table-bordered">
                                                                        <thead>
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
                                                                        </thead>
                                                                        <tbody> <?php
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
                                                                                        <a href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> </a>
                                                                                        <a href="javascript:void(0);"><i class="bx bx-trash me-1"></i> </a>
                                                                                    </td>

                                                                                </tr>

                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="card">
                                                            <h6 class="card-header">FICHIERS TELECHARGES</h6>
                                                            <div class="card-body">
                                                                <div class="table-responsive text-nowrap">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Titre document</th>
                                                                                <th>Ajouté le </th>
                                                                                <th>Type</th>
                                                                                <th>Actions</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $sql_select1 = "SELECT * FROM passport_bd.t_document_dossier where ref_dossier=" . $data_dossier['idt_dossier'] . " and view_doc=1";
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
                                                                                        <?php echo ($data_dossier['allow_edit_for_client'] == 1 && 0) ? '<a href="view_doc_editable.php?del_doc=yes&idt_doc=' . $data1['idt_document_dossier'] . '" onClick="return confirm(' . "'Cette action va supprimer le fichier, Veuillez confirmer?'" . ')"><i class="bx bx-edit-alt me-1"></i></a>' : ""; ?>
                                                                                    </td>

                                                                                </tr>

                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <input type="button" name="previous" class="previous action-button-previous" value="Précédent" /> <input type="button" name="next" class="next action-button" value="Suivant" />
                                            </fieldset>
                                            <fieldset>
                                                <div class="form-card">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="story">Parlez-nous de vos activités antérieures (emplois, professions, stages académiques / professionnels ou autres formations pertinentes ainsi que les mois et les années du début et de la fin. si applicable. N'hésitez pas d'être explicite)</label>
                                                                <textarea name="activite_passe_actuelle" cols="100%" rows="5" class="form-control"><?php echo $data_dossier['activite_passe_actuelle']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <button type="submit"  class="btn btn-info pull-right btn-submit-edit" name="btn_edition_emploi" >Valider les Modifications</button>
                                                <input type="button" name="previous" class="previous action-button-previous" value="Précédent" />
                                                <input type="button" name="next" class="next action-button" value="Suivant" />
                                            </fieldset>
                                            <fieldset>
                                                <div class="form-card">
                                                    <div class="row">
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Raison du voyage</label>
                                                                <input class="form-control" type="text" name="vo_raison_voyage" value="<?php echo $data_dossier['vo_raison_voyage']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Si pour études, qui prendra en charge ces études?</label>
                                                                <input class="form-control" type="text" name="vo_charge_etude_parrain" value="<?php echo $data_dossier['vo_charge_etude_parrain']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Si pour études, quels domaines vous intéressent ? <span class="span-style">(donnez trois propositions des programmes)</span></label>

                                                                <input class="form-control" type="text" name="vo_proposition_domaine" value="<?php echo $data_dossier['domaine_preference']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label" for="vo_destination_famille_chk">Avez-vous une famille à votre lieu de destination?</label>
                                                                <input name="vo_destination_famille_chk" class="vo_destination_famille_chk" type="checkbox" value="oui" <?php echo ($data_dossier['vo_destination_famille'] == 'oui') ? "checked" : ""; ?>>
                                                                <span class="item-text">Oui</span>
                                                                <div class="form-group answer_destination_famille">
                                                                    <label class="control-label">Précisez il s'agit de qui et sa qualité pour vous</label>
                                                                    <input type="text" class="form-control" name="vo_destination_comment" value="<?php echo $data_dossier['vo_destination_comment']; ?>" placeholder="Précisez il s'agit de qui et sa qualité pour vous">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label for="vo_ancien_visa"> Avez-vous des ancien Visa?</label>
                                                                <input class="vo_ancien_visa" name="vo_ancien_visa" type="checkbox" value="oui" <?php echo ($data_dossier['vo_ancien_visa'] == 'oui') ? "checked" : ""; ?>>
                                                                <span class="item-text">Oui</span>
                                                                <div class="form-group answer_ancien_visa">
                                                                    <label class="control-label">Précisez vos anciens Visa</label>
                                                                    <input class="form-control" type="text" name="vo_ancien_visa_comment" id="vo_ancien_visa_comment" placeholder="Listez vos anciens visa" value="<?php echo $data_dossier['vo_ancien_visa_comment']; ?>">

                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label for="vo_refus_visa_chk"> Avez-vous déjà eu un refus de Visa?</label>
                                                                <input class="vo_refus_visa_chk" name="vo_refus_visa_chk" type="checkbox" value="oui" <?php echo ($data_dossier['vo_refus_visa'] == 'oui') ? "checked" : ""; ?>>

                                                                <span class="item-text">Oui</span>
                                                                <div class="form-group answer_refus_visa">
                                                                    <label class="control-label">Précisez vos anciens refus</label>
                                                                    <input class="form-control" type="text" name="commentaire_refus_visa" id="commentaire_refus_visa" placeholder="Si Oui, précisez vos anciens refus" value="<?php echo $data_dossier['vo_refus_visa_comment']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-12 row-style">
                                                            <div class="form-group">
                                                                <label for="vo_obtention_chk">Avez-vous déjà tenté d'obtenir une inscription dans une université étrangère ? </label>
                                                                <input class="vo_obtention_chk" type="checkbox" name="vo_obtention_chk" value="oui" />
                                                                <span class="item-text">Oui</span>

                                                                <div class="form-group answer_universite">
                                                                    <label class="control-label"> De quelle Université s'agit il? </label>
                                                                    <input class="form-control" type="text" name="q_universite" id="q_universite" placeholder="Entrez plusieurs noms si c'est plusieurs universités" value="<?php echo $data_dossier['q_universite']; ?>">

                                                                    <label class="control-label">Dans quel pays se trouve cette Université? </label>
                                                                    <input class="form-control" type="text" name="q_pays" id="q_pays" placeholder="Entrez plusieurs noms si c'est plusieurs pays" value="<?php echo $data_dossier['q_pays']; ?>">

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                <button type="submit" class="btn btn-info pull-right btn-submit-edit" name="btn_edition_zone_voyage">Valider les Modifications</button>
                                                <input type="button" name="previous" class="previous action-button-previous" value="Précédent" />
                                                <input type="button" name="next" class="next action-button" value="Suivant" />
                                            </fieldset>
                                            <fieldset>
                                                <div class="form-card">
                                                    <div class="row">
                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Votre garant est qui pour vous? <font color="#FF0000">*</font></label>
                                                                <input type="text" class="form-control" name="pc_qualite_garant" value="<?php echo $data_dossier['pc_qualite_garant']; ?>">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style" id="ifYes" style="display: none;">
                                                            <div class="form-group">
                                                                <label class="control-label">Autre </label>
                                                                <input class="form-control" type="text" name="qualite_parain_autre" placeholder="Pas dans la liste, autre">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Où travaille-t-il et quelle responsabilité a-t-il ?
                                                                    <font color="#FF0000">*</font>
                                                                </label>

                                                                <input class="form-control" type="text" name="pc_lieu_travail_garant" value="<?php echo $data_dossier['pc_lieu_travail_garant']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Quel est son salaire mensuel?</label>
                                                                <input class="form-control" type="text" name="pc_salaire_parrain" value="<?php echo $data_dossier['pc_salaire_parrain']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Combien de parcelles dispose-t-il ?</label>
                                                                <select name="pc_nbre_parcelle" class="form-control select2">
                                                                    <?php for ($j = 0; $j < 21; $j++) { ?>
                                                                        <option value="<?php echo $j; ?>" <?php echo ($j == $data_dossier['pc_nbre_parcelle']) ? "selected" : ""; ?>><?php echo $j; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Combien de véhicules dispose-t-il ?</label>
                                                                <select name="pc_nbre_vehicule" class="form-control select2">
                                                                    <?php for ($j = 0; $j < 21; $j++) { ?>
                                                                        <option value="<?php echo $j; ?>" <?php echo ($j == $data_dossier['pc_nbre_vehicule']) ? "selected" : ""; ?>><?php echo $j; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label>Possède-t-il une activité commerciale ou une entreprise? </label>
                                                                <br>
                                                                <input class="pc_activite_pro_chk" name="pc_activite_pro" type="checkbox" value="oui" <?php echo $data_dossier['pc_activite_pro'] == "oui" ? "checked" : ""; ?>>

                                                                <span class="item-text">Oui</span>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 row-style answer_activite">
                                                            <div class="form-group">
                                                                <label class="control-label">Quel revenu mensuel pour cette activité ou entreprise en USD?</label>

                                                                <input class="form-control" type="text" name="pc_revenu_parrain" id="pc_revenu_parrain" placeholder="Estimation en dollars américains des revenus mensuels" value="<?php echo $data_dossier['pc_revenu_parrain']; ?>">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="col-md-6 row-style answer_activite">
                                                            <div class="form-group">
                                                                <label class="control-label">Quel est son nom?</label>
                                                                <input class="form-control" type="text" name="pc_activite_pro_nom" id="pc_activite_pro_nom" placeholder="Le nom de l'activité et le domaine d'exploitation" value="<?php echo $data_dossier['pc_activite_pro_nom']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 row-style">
                                                            <label class="control-label">Email Facultatif </label>
                                                            <div class="form-group">
                                                                <input class="form-control" type="text" name="email_secondaire" placeholder="Entrez votre adresse email facultatif" value="<?php echo $data_dossier['email_secondaire']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 row-style">
                                                            <div class="form-group">
                                                                <label class="control-label">Téléphone Secondaire <span class="span-style">(commencez avec le code du pays 243 ou 33)</span>
                                                                
                                                                </label>
                                                                <input type="text" class="form-control" name="numero_telephone_secondaire" placeholder="Téléphone Secondaire" value="<?php echo $data_dossier['numero_telephone_secondaire']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-info pull-right btn-submit-edit" name="btn_edition_zone_charge">Valider les Modifications</button>

                                                <input type="button" name="previous" class="previous action-button-previous" value="Précédent" />

                                            </fieldset>
                                        </form>

                                        <!-- Modal -->
                                        <div class="modal fade" id="backDropModalSecondaire" data-bs-backdrop="static" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form class="modal-content" action="view_doc_editable_v2.php" method="post">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="backDropModalTitle">Enregistrement d'un nouveau Cursus Secondaire</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="emailBackdrop" class="form-label">Année d'obtention</label>
                                                                <select name="exetat_annee" class="form-select">
                                                                    <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                    <?php } ?>

                                                                </select>
                                                            </div>
                                                            <div class="col mb-0">
                                                                <label for="dobBackdrop" class="form-label">Ecole Frequentée</label>
                                                                <input type="text" id="dobBackdrop" class="form-control" name="ecole_frequenter" />
                                                            </div>
                                                        </div>


                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="emailBackdrop" class="form-label">Option</label>
                                                                <input type="text" id="emailBackdrop" class="form-control" name="formation" />
                                                            </div>
                                                            <div class="col mb-0">
                                                                <label for="dobBackdrop" class="form-label">Pourcentage</label>
                                                                <input type="text" id="dobBackdrop" class="form-control" name="resultat" />
                                                            </div>
                                                        </div>


                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="dobBackdrop" class="form-label">Niveau</label>
                                                                <input type="text" id="dobBackdrop" class="form-control" name="niveau" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                            Fermer
                                                        </button>
                                                        <button type="submit" class="btn btn-primary" name="submit_add_etude_sec">Valider l'ajout</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Modal -->


                                        <!-- Modal -->
                                        <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form class="modal-content" action="view_doc_editable_v2.php" method="post">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="backDropModalTitle">Enregistrement d'un nouveau Cursus Post-Secondaire</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="emailBackdrop" class="form-label">Année d'obtention</label>
                                                                <select name="exetat_annee" class="form-select">
                                                                    <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col mb-0">
                                                                <label for="dobBackdrop" class="form-label">Ecole Frequentée</label>
                                                                <input type="text" id="dobBackdrop" class="form-control" name="ecole_frequenter" />
                                                            </div>
                                                        </div>


                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="emailBackdrop" class="form-label">Option</label>
                                                                <input type="text" id="emailBackdrop" class="form-control" name="formation" />
                                                            </div>
                                                            <div class="col mb-0">
                                                                <label for="dobBackdrop" class="form-label">Pourcentage</label>
                                                                <input type="text" id="dobBackdrop" class="form-control" name="resultat" />
                                                            </div>
                                                        </div>


                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="emailBackdrop" class="form-label">Diplome Obtenu</label>
                                                                <input type="text" id="emailBackdrop" class="form-control" name="diplome_obtenu" />
                                                            </div>
                                                            <div class="col mb-0">
                                                                <label for="dobBackdrop" class="form-label">Niveau</label>
                                                                <input type="text" id="dobBackdrop" class="form-control" name="niveau" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                            Fermer
                                                        </button>
                                                        <button type="submit" class="btn btn-primary" name="submit_add_etude">Valider l'ajout du cursus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Modal -->

                                        <!-- Modal -->
                                        <div class="modal fade" id="backDropModalEXETAT" data-bs-backdrop="static" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form class="modal-content" action="view_doc_editable_v2.php" method="post">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="backDropModalTitle">Nouveau parcours Diplome d'Etat</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="emailBackdrop" class="form-label">Année d'obtention</label>
                                                                <select name="exetat_annee" class="form-select">
                                                                    <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col mb-0">
                                                                <label for="dobBackdrop" class="form-label">Ecole Frequentée</label>
                                                                <input type="text" id="dobBackdrop" class="form-control" name="ecole_frequenter" />
                                                            </div>
                                                        </div>


                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="emailBackdrop" class="form-label">Intitulé de la formation</label>
                                                                <input type="text" id="emailBackdrop" class="form-control" name="formation" />
                                                            </div>
                                                            <div class="col mb-0">
                                                                <label for="dobBackdrop" class="form-label">Pourcentage</label>
                                                                <input type="text" id="dobBackdrop" class="form-control" name="resultat" />
                                                            </div>
                                                        </div>


                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="emailBackdrop" class="form-label">Ville d'obtention</label>
                                                                <input type="text" id="emailBackdrop" class="form-control" name="ville_obtention" />
                                                            </div>
                                                            <div class="col mb-0">
                                                                <label for="dobBackdrop" class="form-label">Pays</label>
                                                                <select name="pays_obtention" class="form-control select2">
                                                                    <?php echo get_combo_liste_pays(); ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                            Fermer
                                                        </button>
                                                        <button type="submit" class="btn btn-primary" name="submit_add_exetat">Ajouter la formation</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Modal -->

                                        <!-- Modal -->
                                        <div class="modal fade" id="backDropModalDoc" data-bs-backdrop="static" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form class="modal-content" action="view_doc_editable_v2.php" method="post" enctype="multipart/form-data">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="backDropModalTitle">Ajouter un document au Dossier
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="emailBackdrop" class="form-label">Titre Document</label>
                                                                <input type="text" id="dobBackdrop" class="form-control" name="titre_document" />

                                                            </div>

                                                        </div>

                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="dobBackdrop" class="form-label">Attachez votre fichier Ici</label>
                                                                <input type="file" id="dobBackdrop" class="form-control" name="doc_file" accept=".jpeg,.jpg,.png,.pdf" />
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                            Fermer
                                                        </button>
                                                        <button type="submit" class="btn btn-primary" name="submit_add_doc">Ajouter le document</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Modal -->



                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        include_once("php/layouts/footer-v2-back.php");
                        ?>

                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
                <div class="layout-overlay layout-menu-toggle"></div>
            </div>
            <?php
            include_once("php/layouts/script-v2-back.php");
            ?>
        </div>
    </div>
</body>

</html>