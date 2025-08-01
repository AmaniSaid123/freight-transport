<?php
//******************IDPAGE*****************

//Session check****************************

session_start();
include_once("php/function.php");

$error = "no";
$warning = "no";
$success = "no";
$information = "no";

$error_message = "Error on the page Errorcode=xx001Defaults";
$warning_message = "This is a warning";
$success_message = "Your request succeed";
$information_message = "Welcome in Web-sms";
//********************locally Additionnal Function*************

//****************location******************
$set_pluggin_selection_wise = "yes";
$requirement_datatable = "yes";
$get_active_menu = "ajout-dossier";
$page_location = "Formulaire de Renseignement VISA Etude";

//*************************************************************
$i = 1;

if ((isset($_POST['submit_dossier']) && isset($_POST['identite']) && $_POST['identite'] != ""
    && isset($_POST['date_naissance']) && $_POST['date_naissance'] != ""
    && isset($_POST['lieu_naissance']) && $_POST['lieu_naissance'] != ""
    && isset($_POST['email']) && $_POST['email'] != ""
    && isset($_POST['telephone']) && $_POST['telephone'] != ""
    && isset($_POST['promoteur_agence']) && $_POST['promoteur_agence'] != ""
    && isset($_POST['sexe']) && $_POST['sexe'] != ""
    && isset($_POST['adresse']) && $_POST['adresse'] != ""
    && isset($_POST['vo_destination']) && $_POST['vo_destination'] != ""
    && isset($_POST['ville_pays']) && $_POST['ville_pays'] != ""
    && isset($_POST['pc_qualite_garant']) && $_POST['pc_qualite_garant'] != ""
    && isset($_POST['pc_lieu_travail_garant']) && $_POST['pc_lieu_travail_garant'] != "")
  || (isset($_GET['identite']) && isset($_GET['date_naissance']) && isset($_GET['lieu_naissance']) && isset($_GET['email']) && isset($_GET['telephone'])
    && isset($_GET['promoteur_agence']) && isset($_GET['sexe']) && isset($_GET['adresse']) && isset($_GET['vo_destination']) && isset($_GET['ville_pays'])
    && isset($_GET['pc_qualite_garant']) && isset($_GET['pc_lieu_travail_garant']))
) {

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
  $vo_ancien_visa = (isset($_POST['vo_ancien_visa'])) ? clean_in_text($_POST['vo_ancien_visa']) :  "";
  $vo_ancien_visa_comment = clean_in_text($_POST['vo_ancien_visa_comment']);
  $vo_refus_visa_chk = isset($_POST['vo_refus_visa_chk']) ? clean_in_text($_POST['vo_refus_visa_chk']) : "";
  $commentaire_refus_visa = clean_in_text($_POST['commentaire_refus_visa']);
  $vo_destination_famille_chk = isset($_POST['vo_destination_famille_chk']) ? clean_in_text($_POST['vo_destination_famille_chk']) : "";
  $vo_destination_comment = clean_in_text($_POST['vo_destination_comment']);
  $pc_qualite_garant = (clean_in_text($_POST['pc_qualite_garant']) != "") ?  clean_in_text($_POST['pc_qualite_garant']) :  clean_in_text($_POST['qualite_parain_autre']);
  $qualite_parain_autre = clean_in_text($_POST['qualite_parain_autre']);
  $pc_lieu_travail_garant = clean_in_text($_POST['pc_lieu_travail_garant']);
  $pc_salaire_parrain = clean_in_text($_POST['pc_salaire_parrain']);
  $pc_activite_pro_chk = isset($_POST['pc_activite_pro_chk']) ? clean_in_text($_POST['pc_activite_pro_chk']) : "";
  $pc_activite_pro_nom = clean_in_text($_POST['pc_activite_pro_nom']);
  $pc_revenu_parrain = clean_in_text($_POST['pc_revenu_parrain']);
  $pc_nbre_parcelle = clean_in_text($_POST['pc_nbre_parcelle']);
  $pc_nbre_vehicule = clean_in_text($_POST['pc_nbre_vehicule']);
  $email = clean_in_text($_POST['email']);
  $pin_secret = clean_in_text($_POST['pin_secret']);
  $commentaire_client = isset($_POST['commentaire_client']) ? clean_in_text($_POST['commentaire_client']) : "";
  $identite_pere = clean_in_text($_POST['identite_pere']);
  $lieu_naissance_pere = clean_in_text($_POST['lieu_naissance_pere']);
  $date_naissance_pere = ($identite_pere == "") ? "" : clean_in_text($_POST['date_naissance_pere']);
  $identite_mere = clean_in_text($_POST['identite_mere']);
  $lieu_naissance_mere = clean_in_text($_POST['lieu_naissance_mere']);
  $date_naissance_mere = ($identite_mere == "") ? "" : clean_in_text($_POST['date_naissance_mere']);
  $sexe = clean_in_text($_POST['sexe']);
  $adresse = clean_in_text($_POST['adresse']);
  $ville_pays = clean_in_text($_POST['ville_pays']);
  $domaine_preference = clean_in_text($_POST['vo_proposition_domaine']);
  $q_universite = clean_in_text($_POST['q_universite']);
  $q_pays = clean_in_text($_POST['q_pays']);
  $numero_telephone_secondaire = str_ireplace(' ', '', str_ireplace('-', '', str_ireplace(')', '', str_ireplace('(', '', clean_in_text($_POST['numero_telephone_secondaire'])))));
  $email_secondaire = clean_in_text($_POST['email_secondaire']);


  $ndel = date('mdHis');

  //$pin_secret=rand(10000,99999);
  $feedback_dossier = add_dossier_new(
    '',
    $ndel,
    $identite,
    $lieu_naissance,
    $date_naissance,
    $email,
    $nbre_enfant_famille,
    $position_dans_famille,
    $numero_passport,
    $date_expiration_pp,
    $activite_passe_actuelle,
    $vo_destination,
    $vo_raison_voyage,
    $vo_charge_etude_parrain,
    $vo_ancien_visa,
    $vo_ancien_visa_comment,
    $telephone,
    $vo_refus_visa_chk,
    $commentaire_refus_visa,
    $vo_destination_famille_chk,
    $vo_destination_comment,
    $pc_qualite_garant,
    $pc_lieu_travail_garant,
    $pc_salaire_parrain,
    $pc_activite_pro_chk,
    $pc_activite_pro_nom,
    $pc_revenu_parrain,
    $pc_nbre_parcelle,
    $pc_nbre_vehicule,
    "Creer_en_ligne",
    $promoteur_agence,
    $ref_agence,
    $pin_secret,
    "online_user",
    $commentaire_client,
    $identite_pere,
    $lieu_naissance_pere,
    $date_naissance_pere,
    $identite_mere,
    $lieu_naissance_mere,
    $date_naissance_mere,
    $sexe,
    $adresse,
    $ville_pays,
    $domaine_preference,
    $q_universite,
    $q_pays,
    $numero_telephone_secondaire,
    $email_secondaire
  );

  $feedback_exetat = 0;

  if ($feedback_dossier == 1) {
    $success = "yes";
    $data_dossier = get_dossier_data_by_ndel($ndel);
    $success_message = "Dossier en Ligne créé avec succès  <br>";
    add_action_no_request($data_dossier['idt_dossier'], 7, 'Valider', 'online_user', 'Oui', 'Ajout Dossier en Ligne');
    // Envoi EMAIL
    $statut_dossier_edit = 'Creer_en_ligne_nouveau';
    $data_statut = get_statut_data_by_name($statut_dossier_edit);
    $text_message = $data_statut['mail_client'];
    if (isset($email)) {
      $to_destination = $email;
      $sujet = "Dossier_Voyage_Creer";
      include_once("sendmail_test.php");
    }
    if (isset($email_secondaire)) {
      $to_destination = $email_secondaire;
      $sujet = "Dossier_Voyage_Creer";
      include_once("sendmail_test.php");
    }
    // First table
    if (((!empty($_POST['exetat_annee_sec'])) && (!in_array("", $_POST['exetat_annee_sec'])))
      && ((!empty($_POST['ecole_frequenter_sec'])) && (!in_array("", $_POST['ecole_frequenter_sec'])))
      && ((!empty($_POST['option_sec'])) && (!in_array("", $_POST['option_sec'])))
      && ((!empty($_POST['niveau_sec'])) && (!in_array("", $_POST['niveau_sec'])))
      && ((!empty($_POST['pourcentage_sec'])) && (!in_array("", $_POST['pourcentage_sec'])))
    ) {
      $feedback_exetat = add_dossier_etude_new($data_dossier['idt_dossier'], $_POST['exetat_annee_sec'], $_POST['ecole_frequenter_sec'], $_POST['option_sec'], $_POST['niveau_sec'], $_POST['pourcentage_sec'], 'SECONDAIRE', '', '', '', "online_user");
    //  $success_message = ($feedback_exetat == 1) ? $success_message . "<br>" . $i . "-> " . $_POST['niveau_sec'] . " crée avec succès" : "<br>" . $i . "-> " . $_POST['niveau_sec'] . " non crée";
      $url_fichier = "";
      $is_file_transafered = 0;
      $type_fichier = "";
      /*if (0 && isset($_FILES['diplome_file_sec' . $i]) && $_FILES['diplome_file_sec' . $i]['name'] != '' && $feedback_exetat == 1) {

          $value = explode(".", $_FILES['diplome_file_sec' . $i]['name']);
          $type_fichier = $value[1];
          $url_initial = "uploads/" . $ndel . "_doc_" . date('s') . $i . "." . $value[1];
          $download_file = move_uploaded_file($_FILES['diplome_file_sec' . $i]['tmp_name'], $url_initial);
          $url_fichier = ($download_file == 1) ? $url_initial : $url_fichier;
          $is_file_transafered = ($download_file == 1) ? 1 : 0;
          $success_message = $success_message . " | -- Fichier Sec ajouté";
        }*/

      //$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,$_POST['niveau_sec'.$i]) : 0;

      //$success_message=($add_document==1) ? $success_message." | - Document ajouté".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : '.$_POST['niveau_sec'.$i]) : $success_message." | - Erreur Ajout Document";
    }

    // Second table
    if (((!empty($_POST['exetat_annee'])) && (!in_array("", $_POST['exetat_annee'])))
      && ((!empty($_POST['ecole_frequenter'])) && (!in_array("", $_POST['ecole_frequenter'])))
      && ((!empty($_POST['option'])) && (!in_array("", $_POST['option'])))
      && ((!empty($_POST['pourcentage'])) && (!in_array("", $_POST['pourcentage'])))
      && ((!empty($_POST['ville_obtention'])) && (!in_array("", $_POST['ville_obtention'])))
    ) {
      $feedback_exetat = add_dossier_etude_new($data_dossier['idt_dossier'], $_POST['exetat_annee'], $_POST['ecole_frequenter'], $_POST['option'], "EXETAT", $_POST['pourcentage'], "EXETAT", '', $_POST['ville_obtention'], $_POST['pays'], "online_user");
    //  $success_message = ($feedback_exetat == 1) ? $success_message . "-> Exetat créé avec succès : " : $success_message . "-> Exetat non créé";

      /*$url_fichier = "";
      $is_file_transafered = 0;
      $type_fichier = "";
      if (0 && isset($_FILES['exetat_file']) && $_FILES['exetat_file']['name'] != '' && $feedback_exetat == 1) {
     
        $value = explode(".", $_FILES['exetat_file']['name']);
        $type_fichier = $value[1];
        $url_initial = "uploads/" . $ndel . "_exetat_" . date('s') . "." . $value[1];
        $download_file = move_uploaded_file($_FILES['exetat_file']['tmp_name'], $url_initial);
        $url_fichier = ($download_file == 1) ? $url_initial : $url_fichier;
        $is_file_transafered = ($download_file == 1) ? 1 : 0;
        $success_message = $success_message . " | -- Fichier Exetat ajouté";
      }*/

      //$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,'EXETAT') : 0;

      //$success_message=($add_document==1) ? $success_message." | - Document ajouté : ".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : Exetat') : $success_message." | - Erreur Ajout Document Exetat  ";
    }
    //  Enregistrement données SECONDAIRE


    /*  if((!empty($_POST['exetat_annee_sec'])) && (!in_array("", $_POST['exetat_annee_sec']))) {
      echo "Given Array is not empty <br>";

    }*/


    //  Enregistrement données POST SECONDAIRE
    if (((!empty($_POST['exetat_annee_post'])) && (!in_array("", $_POST['exetat_annee_post'])))
      && ((!empty($_POST['ecole_frequenter_post'])) && (!in_array("", $_POST['ecole_frequenter_post'])))
      && ((!empty($_POST['option_post'])) && (!in_array("", $_POST['option_post'])))
      && ((!empty($_POST['niveau_post'])) && (!in_array("", $_POST['niveau_post'])))
      && ((!empty($_POST['pourcentage_post'])) && (!in_array("", $_POST['pourcentage_post'])))
      && ((!empty($_POST['diplome_post'])) && (!in_array("", $_POST['diplome_post'])))
    ) {
      $feedback_exetat = add_dossier_etude_new($data_dossier['idt_dossier'], $_POST['exetat_annee_post'], $_POST['ecole_frequenter_post'], $_POST['option_post'], $_POST['niveau_post'], $_POST['pourcentage_post'], $_POST['diplome_post'], '', '', '', "online_user");
      $success_message = ($feedback_exetat == 1) ? $success_message . "<br>" . $i . "-> " . $_POST['diplome_post'] . " crée avec succès" : "<br>" . $i . "-> " . $_POST['diplome_post'] . " non crée";

      $url_fichier = "";
      $is_file_transafered = 0;
      $type_fichier = "";
      if (0 && isset($_FILES['diplome_file' . $i]) && $_FILES['diplome_file' . $i]['name'] != '' && $feedback_exetat == 1) {

        $value = explode(".", $_FILES['diplome_file' . $i]['name']);
        $type_fichier = $value[1];
        $url_initial = "uploads/" . $ndel . "_doc2_" . date('s') . $i . "." . $value[1];
        $download_file = move_uploaded_file($_FILES['diplome_file' . $i]['tmp_name'], $url_initial);
        $url_fichier = ($download_file == 1) ? $url_initial : $url_fichier;
        $is_file_transafered = ($download_file == 1) ? 1 : 0;
        $success_message = $success_message . " | -- Fichier Post-secondaire ajouté";
      }

      //$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,$_POST['niveau'.$i]) : 0;

      //$success_message=($add_document==1) ? $success_message." | - Document ajouté".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : '.$_POST['niveau'.$i]) : $success_message." | - Erreur Ajout Document";

    }

    /*
    if (0 && isset($_FILES['cv_file']) && $_FILES['cv_file']['name'] != '') {

      if (isset($_FILES['cv_file']) && $_FILES['cv_file']['name'] != '') {

        $value = explode(".", $_FILES['cv_file']['name']);
        $type_fichier = $value[1];
        $url_initial = "uploads/" . $ndel . "_CV_" . date('s') . "." . $value[1];
        $download_file = move_uploaded_file($_FILES['cv_file']['tmp_name'], $url_initial);
        $url_fichier = ($download_file == 1) ? $url_initial : $url_fichier;
        $is_file_transafered = ($download_file == 1) ? 1 : 0;
        $success_message = $success_message . " | -- Fichier CV ajouté";
      }

      //$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,'CV') : 0;

      //$success_message=($add_document==1) ? $success_message." | - Document ajouté : ".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : CV') : " | - Erreur Ajout Document";



    }

    if (0 && isset($_FILES['passeport_file']) && $_FILES['passeport_file']['name'] != '') {

      if (isset($_FILES['passeport_file']) && $_FILES['passeport_file']['name'] != '') {

        $value = explode(".", $_FILES['passeport_file']['name']);
        $type_fichier = $value[1];
        $url_initial = "uploads/" . $ndel . "_passeport_" . date('s') . "." . $value[1];
        $download_file = move_uploaded_file($_FILES['passeport_file']['tmp_name'], $url_initial);
        $url_fichier = ($download_file == 1) ? $url_initial : $url_fichier;
        $is_file_transafered = ($download_file == 1) ? 1 : 0;
        $success_message = $success_message . " | -- Fichier Passeport ajouté";
      }

      //$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,'Passeport') : 0;

      //$success_message=($add_document==1) ? $success_message." | - Document ajouté : ".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : Passeport') : " | - Erreur Ajout Document";



    }

    if (0 && isset($_FILES['attestaion_file']) && $_FILES['attestaion_file']['name'] != '') {

      if (isset($_FILES['attestaion_file']) && $_FILES['attestaion_file']['name'] != '') {

        $value = explode(".", $_FILES['attestaion_file']['name']);
        $type_fichier = $value[1];
        $url_initial = "uploads/" . $ndel . "_Attestation_" . date('s') . "." . $value[1];
        $download_file = move_uploaded_file($_FILES['attestaion_file']['tmp_name'], $url_initial);
        $url_fichier = ($download_file == 1) ? $url_initial : $url_fichier;
        $is_file_transafered = ($download_file == 1) ? 1 : 0;
        $success_message = $success_message . " | -- Fichier Acte Naissance ajouté";
      }

      //$add_document=($is_file_transafered==1) ? add_document($data_dossier['idt_dossier'],"online_user",$url_fichier,$type_fichier,'Acte de naissance') : 0;

      //$success_message=($add_document==1) ? $success_message." | - Document ajouté : ".add_action_no_request($data_dossier['idt_dossier'],6,'Valider','online_user','Oui','Ajout Document : Acte de naissance') : " | - Erreur Ajout Document";



    }
*/

    header("Location:after-authentification.php?nid_client=" . $ndel . "&pin_secret=" . $pin_secret . "&msg=" . $success_message);
  } else {
    $error = "yes";
    $error_message = "Une erreur a survenu lors de la creation de dossier";
  }
  die;
}

?>
<?php

// define variables and set to empty values
$identiteError = $lieuNaissanceError = $dateNaissanceError = $sexeError =  $emailError = $telephoneError = $promoteurAgenceError = $adresseError = $voDestinationError = $villePaysError = $pcQualiteGarantError = $pcLieuTravailGrantError = "";
$identite = $lieu_naissance = $date_naissance = $sexe = $email = $telephone = $promoteur_agence = $adresse = $vo_destination = $ville_pays = $pc_qualite_garant = $pc_lieu_travail_garant = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["identite"])) {
    $identiteError = "Noms au complet obligatoire";
  } else {
    $identite = test_input($_POST["identite"]);
  }

  if (empty($_POST["lieu_naissance"])) {
    $lieuNaissanceError = "Lieu de naissance obligatoire";
  } else {
    $lieu_naissance = test_input($_POST["lieu_naissance"]);
  }

  if (empty($_POST["date_naissance"])) {
    $dateNaissanceError = "Date de naissance obligatoire";
  } else {
    $date_naissance = test_input($_POST["date_naissance"]);
  }

  if (empty($_POST["sexe"])) {
    $sexeError = "Sexe obligatoire";
  } else {
    $sexe = test_input($_POST["sexe"]);
  }

  if (empty($_POST["email"])) {
    $emailError = "Email obligatoire";
  } else {
    $email = test_input($_POST["email"]);
  }

  if (empty($_POST["telephone"])) {
    $telephoneError = "Téléphone obligatoire";
  } else {
    $telephone = test_input($_POST["telephone"]);
  }

  if (empty($_POST["promoteur_agence"])) {
    $promoteurAgenceError = "Promoteur Agence obligatoire";
  } else {
    $promoteur_agence = test_input($_POST["promoteur_agence"]);
  }

  if (empty($_POST["adresse"])) {
    $adresseError = "Addresse obligatoire";
  } else {
    $adresse = test_input($_POST["adresse"]);
  }

  if (empty($_POST["vo_destination"])) {
    $voDestinationError = "Destination obligatoire";
  } else {
    $vo_destination = test_input($_POST["vo_destination"]);
  }

  if (empty($_POST["ville_pays"])) {
    $villePaysError = "Ville et Pays obligatoire";
  } else {
    $ville_pays = test_input($_POST["ville_pays"]);
  }
  if ((empty($_POST["pc_qualite_garant"]))) {
    $pcQualiteGarantError = "Garant obligatoire";
  } else {
    $pc_qualite_garant = test_input($_POST["pc_qualite_garant"]);
  }
  if ((empty($_POST["pc_lieu_travail_garant"]))) {
    $pcLieuTravailGrantError = "Travail et responsabilité obligatoire";
  } else {
    $pc_lieu_travail_garant = test_input($_POST["pc_lieu_travail_garant"]);
  }
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

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
            <h6 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dossier en ligne /</span> Créer Dossier</h6>
            <div class="row">
              <div class="col-xxl">
                <div class="card mb-4">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 style-h5">FORMULAIRE DE RENSEIGNEMENTS VISA ETUDE
                    </h5>
                    <small class="text-muted float-end">NID : <?php echo date('mdHis'); ?></small>
                  </div>
                  <div class="card-body">
                    <form method="post" onsubmit="ShowLoading()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" id="msform">
                      <ul id="progressbar">
                        <li class="active" id="account"><strong>Identité du client</strong></li>
                        <li id="personal"><strong>Parcours d'études</strong></li>
                        <li id="payment"><strong>Activités passés et actuelles</strong></li>
                        <li id="travel"><strong>Voyage</strong></li>
                        <li id="charge"><strong>Prise en charge</strong></li>
                        <li id="confirm"><strong>Fin</strong></li>
                      </ul>


                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Noms au complet <span class="span-style">(tel que dans le passport) <span>
                                      <font color="#FF0000">*</font></label>
                                <input class="form-control" type="text" name="identite" <?php if (!empty($_POST['identite'])) {
                                                                                          echo "value=\"" . $_POST["identite"] . "\"";
                                                                                        } ?> placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans le Passeport">
                                <span class="error" align=right"> <?php echo $identiteError; ?></span>

                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Lieu de naissance <font color="#FF0000">*</font></label>
                                <input class="form-control" type="text" name="lieu_naissance" <?php if (!empty($_POST['lieu_naissance'])) {
                                                                                                echo "value=\"" . $_POST["lieu_naissance"] . "\"";
                                                                                              } ?> placeholder="Où êtes-vous né(e)?">
                                <span class="error" align=right"> <?php echo $lieuNaissanceError; ?></span>

                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label"> Date de naissance <font color="#FF0000">*</font></label>
                                <div id="datepicker" class="input-group date" data-date-format="yyyy/mm/dd">
                                  <input class="form-control" name="date_naissance" <?php if (!empty($_POST['date_naissance'])) {
                                                                                      echo "value=\"" . $_POST["date_naissance"] . "\"";
                                                                                    } ?> type="text" readonly />
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                                <span class="error" align=right"> <?php echo $dateNaissanceError; ?></span>

                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label"> Numéro Passport </label>
                                <input class="form-control" type="text" name="numero_passport" placeholder="Entrez votre numero de passport ici">
                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Date d'expiration Passeport</label>
                                <div id="datepicker_expiration" class="input-group date" data-date-format="yyyy/mm/dd">
                                  <input class="form-control" name="date_expiration_pp" type="text" readonly />
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label"> Sexe <font color="#FF0000">*</font></label>
                                <select name="sexe" class="form-select" <?php if (!empty($_POST['sexe'])) {
                                                                          echo "value=\"" . $_POST["sexe"] . "\"";
                                                                        } ?> placeholder="Sexe">
                                  <option value="Masculin">Masculin</option>
                                  <option value="Feminin">Feminin</option>
                                </select>
                                <span class="error" align=right"> <?php echo $sexeError; ?></span>
                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <label class="control-label">Email <font color="#FF0000">*</font></label>
                              <div class="form-group">
                                <input class="form-control" type="text" name="email" <?php if (!empty($_POST['email'])) {
                                                                                        echo "value=\"" . $_POST["email"] . "\"";
                                                                                      } ?> placeholder="Entrez votre adresse email">
                                <span class="error" align=right"> <?php echo $emailError; ?></span>
                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Téléphone <span class="span-style">(commencez avec le code du pays 243 ou 33)</span>
                                  <font color="#FF0000">*</font>
                                </label>
                                <input type="text" class="form-control" name="telephone" <?php if (!empty($_POST['telephone'])) {
                                                                                            echo "value=\"" . $_POST["telephone"] . "\"";
                                                                                          } ?> placeholder="Téléphone">
                                <span class="error" align=right"> <?php echo $telephoneError; ?></span>

                              </div>
                            </div>

                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label"> Comment avez-vous connu notre agence ? <font color="#FF0000">*</font></label>
                                <input class="form-control" type="text" name="promoteur_agence" <?php if (!empty($_POST['promoteur_agence'])) {
                                                                                                  echo "value=\"" . $_POST["promoteur_agence"] . "\"";
                                                                                                } ?> placeholder=" Merci de donner tous les détails SVP. (Max 100 caractères)">
                                <span class="error" align=right"> <?php echo $promoteurAgenceError; ?></span>

                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <label class="control-label">Noms au complet de votre père biologique </label>
                              <div class="form-group">
                                <input class="form-control" type="text" name="identite_pere" placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans votre acte de naissance">
                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <label class="control-label">Lieu de naissance de votre père </label>
                              <div class="form-group">
                                <input class="form-control" type="text" name="lieu_naissance_pere" placeholder="Entrez le lieu de naissance">
                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Date de naissance de votre père</label>
                                <div id="datepicker_naissance_pere" class="input-group date" data-date-format="yyyy/mm/dd">
                                  <input class="form-control" name="date_naissance_pere" type="text" readonly />
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Noms au complet de votre mère biologique</label>
                                <input class="form-control" type="text" name="identite_mere" placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans votre acte de naissance">
                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Lieu de naissance de votre mère </label>
                                <input class="form-control" type="text" name="lieu_naissance_mere" placeholder="Entrez le lieu de naissance">
                              </div>
                            </div>

                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Date de naissance de votre mère</label>
                                <div id="date_naissance_mere" class="input-group date" data-date-format="yyyy/mm/dd">
                                  <input class="form-control" name="date_naissance_mere" type="text" readonly />
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Adresse physique actuelle <font color="#FF0000">*</font></label>
                                <input class="form-control" type="text" name="adresse" <?php if (!empty($_POST['adresse'])) {
                                                                                          echo "value=\"" . $_POST["adresse"] . "\"";
                                                                                        } ?> placeholder="Entrez votre adresse (num, av, quartier et commune)">
                                <span class="error" align=right"> <?php echo $adresseError; ?></span>

                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Ville et Pays de résidence actuelle<font color="#FF0000">*</font></label>
                                <input class="form-control" type="text" name="ville_pays" <?php if (!empty($_POST['ville_pays'])) {
                                                                                            echo "value=\"" . $_POST["ville_pays"] . "\"";
                                                                                          } ?> placeholder="Entrez votre ville et le pays (Ville , Pays)">
                                <span class="error" align=right"> <?php echo $villePaysError; ?></span>

                              </div>
                            </div>


                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Vous êtes issue d'une famille de combien d'enfants </label>
                                <input class="form-control" type="number" name="nbre_enfant_famille" placeholder="Vous êtes issue d'une famille de combien d'enfants">
                              </div>
                            </div>

                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Vous êtes quantième enfant dans la famille? </label>
                                <input class="form-control" type="number" name="position_dans_famille" placeholder="Vous êtes quantième enfant dans la famille?">
                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Où voulez-vous partir? <font color="#FF0000">*</font></label>
                                <select name="vo_destination" class="form-select" <?php if (!empty($_POST['vo_destination'])) {
                                                                                    echo "value=\"" . $_POST["vo_destination"] . "\"";
                                                                                  } ?> placeholder="Où voulez-vous partir?">
                                  <?php get_combo_liste_pays(); ?>
                                </select>
                                <span class="error" align=right"> <?php echo $voDestinationError; ?></span>

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
                                <input type="text" class="form-control" name="pin_secret" placeholder="Remplissez le PIN Secret pour le Client" value="<?php echo rand(10000, 99999); ?>" readonly="true">

                              </div>
                            </div>

                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Autre chose à nous informer? Merci de le mentionner ici
                                </label>
                                <textarea name="commentaire_client" cols="100%" rows="3" class="form-control"></textarea>
                              </div>
                            </div>

                          </div>

                          <br>
                        </div>

                        <input type="button" name="next" class="next action-button" value="Suivant" />
                      </fieldset>

                      <fieldset>
                        <div class="form-card">
                          <div style="overflow-x:auto;">
                            <?php $actual_year = clean_in_integer(date("Y")); //echo $actual_year; 
                            ?>
                            <h6>2.1. Votre Parcours Secondaire (Les 3 dernieres années seulement)</h6>
                            <table class="table table-hover small-text" id="tb1">

                              <tr>
                                <th>Année d'obtention</th>
                                <th>Etablissement Frequenté</th>
                                <th>Option</th>
                                <th>Classe</th>
                                <th>Résultats</th>
                                <th><a href="javascript:void(0);" id="addMoreTb1"> <span class="fa-stack ">
                                      <i class="fa fa-circle fa-stack-2x"></i>
                                      <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                                    </span> </a></th>
                              <tr>
                                <td><select name="exetat_annee_sec[]" class="form-control select2">
                                    <?php for ($j = $actual_year; $j > 1975; $j--) { ?>
                                      <option value=""></option>
                                      <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
                                    <?php  } ?>
                                  </select></td>
                                <td><input type="text" name="ecole_frequenter_sec[]" class="form-control"></td>
                                <td><input type="text" name="option_sec[]" class="form-control"></td>
                                <td><input type="text" name="niveau_sec[]" class="form-control"></td>
                                <td><input type="text" name="pourcentage_sec[]" class="form-control"></td>
                                <td><a href='javascript:void(0);' class='remove'>
                                    <span class="fa-stack ">
                                      <i class="fa fa-circle fa-stack-2x"></i>
                                      <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                    </span>
                                  </a>
                                </td>
                              </tr>
                            </table>

                            </br>
                            </br>

                            <h6>2.2. Diplome d'Etat ou son équivalent</h6>
                            <table class="table table-hover small-text" id="tb2">

                              <tr>
                                <th>Année d'obtention</th>
                                <th>Ecole fréquentée</th>
                                <th>Option</th>
                                <th>Pourcentage</th>
                                <th>Pays d'obtention</th>
                                <th>Ville d'obtention</th>
                                <th><a href="javascript:void(0);" id="addMoreTb2"> <span class="fa-stack ">
                                      <i class="fa fa-circle fa-stack-2x"></i>
                                      <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                                    </span> </a></th>
                              <tr>
                                <td> <select name="exetat_annee[]" class="form-control select2">

                                    <?php for ($i = $actual_year; $i > 1975; $i--) { ?>
                                      <option value=""></option>
                                      <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php  } ?>
                                  </select></td>

                                <td><input type="text" name="ecole_frequenter[]" class="form-control"></td>
                                <td><input type="text" name="option[]" class="form-control"></td>
                                <td><input type="text" name="pourcentage[]" class="form-control"></td>
                                <td><select name="pays[]" class="form-control select2">
                                    <?php include("php/list_pays.php"); ?>
                                  </select></td>
                                <td><input type="text" name="ville_obtention[]" class="form-control"></td>
                                <td><a href='javascript:void(0);' class='remove'>
                                    <span class="fa-stack ">
                                      <i class="fa fa-circle fa-stack-2x"></i>
                                      <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                    </span>
                                  </a></td>
                              </tr>
                            </table>

                            </br>
                            </br>

                            <h6>2.3. Votre parcours post-secondaire (Remplir par l'année la plus recente)</h6>

                            <table class="table table-hover small-text" id="tb3">
                              <tr>
                                <th>Année d'obtention</th>
                                <th>Etablissement Frequenté</th>
                                <th>Intitulé de la formation</th>
                                <th>Niveau d'étude</th>
                                <th>Résultats</th>
                                <th>Diplome Obtenu <br>ou Attestation <br>ou Rélévé</th>

                                <th><a href="javascript:void(0);" id="addMoreTb3"> <span class="fa-stack ">
                                      <i class="fa fa-circle fa-stack-2x"></i>
                                      <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                                    </span> </a></th>
                              <tr>
                                <td><select name="exetat_annee_post[]" class="form-control select2">
                                    <?php for ($j = $actual_year; $j > 1975; $j--) { ?>
                                      <option value=""></option>
                                      <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
                                    <?php  } ?>
                                  </select></td>

                                <td><input type="text" name="ecole_frequenter_post[]" class="form-control"></td>
                                <td><input type="text" name="option_post[]" class="form-control"></td>
                                <td><input type="text" name="niveau_post[]" class="form-control"></td>
                                <td><input type="text" name="pourcentage_post[]" class="form-control"></td>
                                <td><input type="text" name="diplome_post[]" class="form-control"></td>
                                <td><a href='javascript:void(0);' class='remove'>
                                    <span class="fa-stack ">
                                      <i class="fa fa-circle fa-stack-2x"></i>
                                      <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                    </span>
                                  </a></td>
                              </tr>
                            </table>
                          </div>
                        </div>

                        <input type="button" name="previous" class="previous action-button-previous" value="Précédent" />
                        <input type="button" name="next" class="next action-button" value="Suivant" />
                      </fieldset>


                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="story">Parlez-nous de vos activités antérieures (emplois, professions, stages académiques / professionnels ou autres formations pertinentes ainsi que les mois et les années du début et de la fin. si applicable. N'hésitez pas d'être explicite)</label>
                                <textarea name="activite_passe_actuelle" cols="100%" rows="2" class="form-control"></textarea>
                              </div>
                            </div>
                          </div>

                        </div>

                        <input type="button" name="previous" class="previous action-button-previous" value="Précédent" />
                        <input type="button" name="next" class="next action-button" value="Suivant" />
                      </fieldset>
                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Raison du voyage</label>
                                <input class="form-control" type="text" name="vo_raison_voyage" placeholder="C'est quoi la raison de votre voyage?">
                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Si pour études, qui prendra en charge ces études?</label>
                                <input class="form-control" type="text" name="vo_charge_etude_parrain" placeholder="Le nom au complet du parain de vos études (tel que repris dans sa pièce d'identité)">
                              </div>
                            </div>

                            <div class="col-md-12 row-style">
                              <div class="form-group">
                                <label class="control-label">Si pour études, quels domaines vous intéressent ? <span class="span-style">(donnez trois propositions des programmes)</span></label>
                                <input class="form-control" type="text" name="vo_proposition_domaine" placeholder="Quels domaines  vous intéressent ? (donnez trois propositions des programmes)">
                              </div>
                            </div>

                            <div class="col-md-12 row-style">
                              <div class="form-group">
                                <label class="control-label" for="vo_destination_famille_chk">Avez-vous une famille à votre lieu de destination?</label>
                                <input class="vo_destination_famille_chk" type="checkbox" name="vo_destination_famille_chk" value="oui" />
                                <span class="item-text">Oui</span>

                                <div class="form-group answer_destination_famille">
                                  <label class="control-label">Précisez il s'agit de qui et sa qualité pour vous</label>
                                  <input type="text" class="form-control" name="vo_destination_comment" placeholder="Précisez il s'agit de qui et sa qualité pour vous">
                                </div>
                              </div>
                            </div>


                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label for="vo_ancien_visa"> Avez-vous des anciens Visa?</label>
                                <input class="vo_ancien_visa" type="checkbox" name="vo_ancien_visa" value="oui" />
                                <span class="item-text">Oui</span>
                                <div class="form-group answer_ancien_visa">
                                  <label class="control-label">Précisez les pays</label>
                                  <input class="form-control" type="text" name="vo_ancien_visa_comment" id="vo_ancien_visa_comment" placeholder="Listez vos anciens visa">
                                </div>
                              </div>
                            </div>


                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label for="vo_refus_visa_chk"> Avez-vous déjà eu un refus de Visa?</label>
                                <input class="vo_refus_visa_chk" type="checkbox" name="vo_refus_visa_chk" value="oui" />
                                <span class="item-text">Oui</span>
                                <div class="form-group answer_refus_visa">
                                  <label class="control-label">Précisez vos anciens refus</label>
                                  <input class="form-control" type="text" name="commentaire_refus_visa" id="commentaire_refus_visa" placeholder="Si Oui, précisez vos anciens refus">
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
                                  <input class="form-control" type="text" name="q_universite" id="q_universite" placeholder="Entrez plusieurs noms si c'est plusieurs universités">

                                  <label class="control-label">Dans quel pays se trouve cette Université? </label>
                                  <input class="form-control" type="text" name="q_pays" id="q_pays" placeholder="Entrez plusieurs noms si c'est plusieurs pays">

                                </div>
                              </div>
                            </div>

                          </div>

                        </div>

                        <input type="button" name="previous" class="previous action-button-previous" value="Précédent" />
                        <input type="button" name="next" class="next action-button" value="Suivant" />
                      </fieldset>
                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Votre garant est qui pour vous? <font color="#FF0000">*</font></label>
                                <select name="pc_qualite_garant" class="form-select" onchange="yesnoCheck(this);">
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
                                  <option value="Autre">Autre</option>
                                </select>
                                <span class="error" align=right"> <?php echo $pcQualiteGarantError; ?></span>

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
                                <input class="form-control" type="text" name="pc_lieu_travail_garant" <?php if (!empty($_POST['pc_lieu_travail_garant'])) {
                                                                                                        echo "value=\"" . $_POST["pc_lieu_travail_garant"] . "\"";
                                                                                                      } ?> placeholder="Dites -nous lenom de son employeur">
                                <span class="error" align=right"> <?php echo $pcLieuTravailGrantError; ?></span>

                              </div>
                            </div>

                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Quel est son salaire mensuel?</label>
                                <input class="form-control" type="text" name="pc_salaire_parrain" placeholder="Salaire exact ou estimatif mensuellement">
                              </div>
                            </div>

                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Combien de parcelles dispose-t-il ?</label>
                                <input class="form-control" type="number" name="pc_nbre_parcelle">
                              </div>
                            </div>

                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Combien de véhicules dispose-t-il ?</label>
                                <input class="form-control" type="number" name="pc_nbre_vehicule">
                              </div>
                            </div>

                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label for="pc_activite_pro_chk">Possède-t-il une activité commerciale ou une entreprise?</label>
                                <br>
                                <input class="pc_activite_pro_chk" type="checkbox" name="pc_activite_pro_chk" value="oui" />
                                <span class="item-text">Oui</span>

                              </div>
                            </div>
                            <div class="col-md-6 row-style answer_activite">
                              <div class="form-group">
                                <label class="control-label">Quel revenu mensuel pour cette activité ou entreprise en USD?</label>

                                <input class="form-control" type="text" name="pc_revenu_parrain" id="pc_revenu_parrain" placeholder="Estimation en dollars américains des revenus mensuels">
                              </div>
                            </div>
                            <br>
                            <div class="col-md-6 row-style answer_activite">
                              <div class="form-group">
                                <label class="control-label">Quel est son nom?</label>
                                <input class="form-control" type="text" name="pc_activite_pro_nom" id="pc_activite_pro_nom" placeholder="Le nom de l'activité et le domaine d'exploitation">
                              </div>
                            </div>

                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Email Facultatif <span class="span-style">
                                    Cette adresse email recevra les notifications habituelles sur le dossier
                                  </span></label>
                                <input class="form-control" type="text" name="email_secondaire" placeholder="Entrez votre adresse email facultatif">
                              </div>
                            </div>
                            <div class="col-md-6 row-style">
                              <div class="form-group">
                                <label class="control-label">Téléphone Secondaire <span class="span-style">(Ce numéro ne recevra pas les notifications habituelles et ne sera utilisé que si nécessaire)</span>
                                </label>
                                <input type="text" class="form-control" name="numero_telephone_secondaire" placeholder="Téléphone">

                              </div>
                            </div>

                          </div>
                        </div>
                        <input type="button" name="previous" class="previous action-button-previous" value="Précédent" />
                        <input type="button" name="next" class="next action-button" value="Suivant" />
                      </fieldset>
                      <fieldset>
                        <div class="form-card">
                          <p>En signant ce formulaire, le client reconnait avoir fourni les renseignements sincères, exacts et vrais. Il reconnait également avoir adhéré aux dispositions établies dans le contrat d'adhésion dont il a pris connaissance à l'amorce de ce processus. Par ce Formulaire, l'Agence sera en mesure d'estimer le pourcentage de réussite du dossier ainsi que fournir les recommandations et conseils nécessaires au client pour le bon traitement de son dossier. L'usage de "IL" représente le genre humain, incluant le masculin ou le féminin selon le cas.
                          </p>

                          <div>

                            <input name="chk_privacy" type="checkbox" value="on" onchange="document.getElementById('passnext2').disabled = !this.checked;">

                            <label for="subscribeNews">
                              J'ai pris connaissance de ce qui est dit ci-haut et des <a href="#" data-bs-toggle="modal" data-bs-target="#modalLong">conditions générales</a> et j'y adhère</label>
                          </div>
                          <!-- Modal -->
                          <div class="modal fade card-live" id="modalLong" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog  modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalLongTitle">CONDITIONS GENERALES</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <ol type="I">
                                    <li>
                                      <p>L’agence prendra avec ses partenaires toutes les dispositions nécessaires facilitant le voyage du client ; l’agence étant liée par l’obligation de moyen;</p>
                                    </li>
                                    <li>
                                      <p>Endéans 10 jours après l’arrivée d’une admission dont le client aura été informé, ce dernier est sensé avoir réuni tous les documents nécessaires pour le dépôt du dossier à l’ambassade conformément à la fiche sur la deuxième étape qui lui aura déjà été remise et expliquée minimum une semaine avant l’arrivée de cette admission ; L’explication de ladite fiche se fera au cours d’une réunion dont la présence des clients invités sera constatée par leur identité et leur signature dans une liste de présence ;</p>
                                    </li>
                                    <li>
                                      <p>Pour une raison dépendant du client lui-même (par exemple si le client n’a pas payé à temps les frais de la deuxième tranche ou n’a pas fourni à temps les documents de la deuxième étape des démarches ou autre raison ayant retardé l’avancement du dossier), le report de l’admission est sanctionné des frais de pénalités que ce client devra payer, allant de 250 USD à 550 USD selon les cas et les universités ;</p>
                                    </li>
                                    <li>
                                      <p>L’agence exécutera sa mission qu’une fois qu’un paiement total sera effectué par le client. Néanmoins, en cas de versement par le client d’une tranche comme paiement partiel exigé, celui – ci devra régler, dans un délai de 10 jours précédant la finition de premiers services rendus, la tranche suivante, selon les services à rendre, sous peine de mettre la société en droit de se déresponsabiliser de premiers services rendus au nom du client et l’acompte versé sera ainsi perdu ;
                                      </p>
                                    </li>
                                    <li>
                                      <p>La responsabilité de l’agence est dégagée en cas d’annulation de voyages, des modifications de trajet, des retards ou de changement de quelle que nature que ce soit relatif aux services de voyage et sous l’influence du client ou des circonstances de force majeure ;
                                      </p>
                                    </li>
                                    <li>
                                      <p>La responsabilité de l’agence est dégagée si le client n’a pas fourni dans le délai les éléments exigés pour le voyage ou s’il a fourni d’éléments considérés de non authentiques et ayant conduit à l’échec de ses démarches de voyage ;
                                    </li>
                                    </p>
                                    </li>
                                    <p>En cas d’échec de la première tentative de délivrance d’un visa d’études, l’agence se réserve le droit de relancer, uniquement pour une seconde fois, les démarches à cet effet, sans que le client n’ait encore à débourser les frais de base (première et deuxième tranches) ayant déjà été payés aux démarches précédentes. Après deux refus de visas, l’unique option restante est celle de choisir une autre destination parmi celles qui seront proposées par l’agence ;
                                    </p>
                                    </li>
                                    <li>
                                      <p>L’obtention d’un remboursement n’est pas possible pour un voyage ou pour des services non consommés ou ceux déjà en cours ;
                                      </p>
                                    </li>
                                    <li>
                                      <p>Après paiement, PASSPORT SARL attribue à chaque client un Numéro d’Identification du Dossier (NID), lequel contient les informations et mises à jour relatives à son dossier. Le client est tenu de consulter régulièrement le site internet de PASSPORT afin de prendre connaissance, grâce à son NID, de l’évolution de son dossier et pouvoir faire le suivi lui-même. De ce fait, PASSPORT SARL ne saurait engager sa responsabilité pour tout préjudice découlant du fait que le CLIENT n’a pas consulté les informations pourtant disponibles dans son NID ;
                                      </p>
                                    </li>
                                    <li>
                                      <p>A l’obtention d’un visa d’études ou autre visa, il est d’obligation au client de participer à la prise des photos souvenirs avec l’équipe PASSPORT Sarl dans les locaux de l’Agence ou à son voisinage ou encore à tout autre endroit où l’agence aura choisi d’organiser une cérémonie de remise des visas et de prise des photos, et autorise, à cet effet, l’agence à utiliser, si bon lui semble, ces photos pour des raisons publicitaires saines ;
                                      </p>
                                    </li>
                                    <li>
                                      <p>A l’obtention du visa, le client ramène le passeport à l’agence pour la clôture du dossier, sans quoi le dossier ne peut être clôturé. La date du voyage est fixée par l’agence en vue de permettre au client de s’accorder au processus de clôture du dossier qui doit être finalisé par l’agence. Le tout sans préjudicier le client par rapport à la date de rentrée des cours à son université ;
                                      </p>
                                    </li>
                                    <li>
                                      <p>A la signature de ce contrat, le client et tout membre de sa famille ou ses amis l’ayant accompagné et se retrouvant dans les photos prises par l’agence, autorise celle-ci à utiliser ces photos pour des raisons publicitaires conformément au point (X) précédent ;
                                      </p>
                                    </li>
                                    <li>
                                      <p>Pour des raisons politiques sur le plan national, régional ou mondial ou bien pour des raisons climatiques qui ne constituent pas une menace grave pour le déroulement du voyage, aucun montant ne sera remboursé ;
                                      </p>
                                    </li>
                                    <li>
                                      <p>Ce contrat s’applique à tout client l’ayant signé, que ses démarches de voyage aient commencé à l’agence PASSPORT SARL ou ailleurs ;
                                      </p>
                                    </li>
                                    <li>
                                      <p>Les présents termes s’appliquent également au mandant dont le mandataire a signé ce formulaire ;
                                      </p>
                                    </li>
                                    <li>
                                      <p>Le masculin est utilisé dans ce document pour représenter le genre humain sans restriction.
                                      </p>
                                    </li>
                                  </ol>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Fermer
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>


                        </div>
                        <input type="button" name="previous" class="previous action-button-previous" value="Précédent" />
                        <button type="submit" class="btn btn-info pull-right" name="submit_dossier" id="passnext2" disabled>Accepter les conditions et Enregistrer le Dossier </button>

                      </fieldset>
                    </form>
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
      <?php
      include_once("php/loading.php");
      ?>
</body>

</html>