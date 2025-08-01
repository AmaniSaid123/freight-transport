<?php 


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
$ref_agence = "";
$identite_pere="";
$lieu_naissance_pere="";
$date_naissance_pere="";
$identite_mere="";
$lieu_naissance_mere="";
$date_naissance_mere="";
$numero_telephone_secondaire = "";
$email_secondaire = "";

if (isset($_POST['submit_edit_statut'])) {
    $edit = $_SESSION['my_m_dossier'];
    
    $data_dossier_temp = get_dossier_data($edit);
    $statut_dossier_edit = $_POST['statut_dossier_edit'];
    $data_statut=get_statut_data_by_name($statut_dossier_edit);
    $notification_sms = 0;
    $notification_email = 0;
    $notification_email_secondaire = 0;
    $sms = (isset($_POST['notification_sms'])) ? "1" : "0";
    $email_1 = (isset($_POST['notification_email'])) ? "1" : "0";
    $email_2 = (isset($_POST['notification_email_secondaire'])) ? "1" : "0";
    $telephone = clean_in_text($_POST['feedback_phone']);
    $email = clean_in_text($_POST['feedback_email']);
    $feedback = update_statut_dossier($data_dossier_temp['idt_dossier'], $statut_dossier_edit);
    if ($feedback == 1) {
        $add_request_info = add_action_info($data_dossier_temp['idt_dossier'], 19, "", "", "", "", "Valide", $_SESSION['my_username'], "Oui", "Modification Statut Dossier a changé pour : " . $statut_dossier_edit, $sms, $email_1, $email_2);
        
        if (isset($_POST['notification_sms']) && $_POST['notification_sms'] == "oui" && get_parameter_value("enable_sms") == 1) {

            $data_dossier_paiement = get_dossier_data($edit);
            $review_telephone = $data_dossier_paiement['numero_telephone'];
            $review_telephone = str_ireplace("(", "", $review_telephone);
            $review_telephone = str_ireplace(")", "", $review_telephone);
            $review_telephone = str_ireplace("-", "", $review_telephone);
            $review_telephone = str_ireplace("_", "", $review_telephone);
            $review_telephone = str_ireplace(" ", "", $review_telephone);
            $text_message = $data_statut['message_client'].", Ancien statut : ".$data_dossier_temp['statut_dossier'].", Nouveau statut : " . $statut_dossier_edit ;
    
            send_sms($review_telephone, $text_message, "PASSPORT", "NA");
            $notification_sms = 1;
        }
        if ($add_request_info == 1 && isset($_POST['notification_email']) && $_POST['notification_email'] == "oui" && get_parameter_value("enable_email") == 1) {
        
            $text_message = $data_statut['mail_client']."<br>Ancien statut : ".$data_dossier_temp['statut_dossier']."<br>Nouveau statut : ".$statut_dossier_edit;
            $to_destination = $data_dossier_temp['email'];
            $sujet="Changement Statut Dossier : ".$statut_dossier_edit;
            $notification_email = 1;
            $notification_email_secondaire = 1;
            include("sendmail_info_client.php");
        }
        if ($add_request_info == 1 && isset($_POST['notification_email_secondaire']) && $_POST['notification_email_secondaire'] == "oui" && get_parameter_value("enable_email") == 1) {
        
            $text_message = $data_statut['mail_client']."<br>Ancien statut : ".$data_dossier_temp['statut_dossier']."<br>Nouveau statut : ".$statut_dossier_edit;
            $to_destination = $data_dossier_temp['email_secondaire'];
            $sujet="Changement Statut Dossier : ".$statut_dossier_edit;
            $notification_email = 1;
            $notification_email_secondaire = 1;
            include("sendmail_info_client.php");
        }
        add_notification("t_dossier", 0, "NA", "Modification Statut Dossier a changé: " . $statut_dossier_edit." | NID = ".$data_dossier_temp['ndel'], $_SESSION['my_username'], "Edition Statut Dossier");
        $success = "yes";
        $success_message = "Modification statut Dossier, NID :   " . $data_dossier_temp['ndel'] . " avec succès . SMS : ".$notification_sms." Email : ".$notification_email ." Email : ". $notification_email_secondaire;
    } else {
        $error = "yes";
        $error_message = "Erreur lors du changement du statut du dossier  ";
    }
}

if (isset($_POST['submit_change_client_view'])) {
    $edit = $_SESSION['my_m_dossier'];

    $data_dossier_temp = get_dossier_data($edit);
    $update_value = ($data_dossier_temp['allow_edit_for_client'] == 1) ? 0 : 1;
    $message_statut = ($update_value == 1) ? "Activé" : "Désactivé";
    $feedback = update_allow_edition($data_dossier_temp['idt_dossier'], $update_value);
    if ($feedback == 1) {

        add_notification("t_dossier", 0, "Modification Dossier a changé: " . $update_value." | NID = ".$data_dossier_temp['ndel'], "Modification Dossier a changé: " . $update_value." | NID = ".$data_dossier_temp['ndel'], $_SESSION['my_username'], "Statut Edition Dossier en Ligne");
        $success = "yes";
        $success_message = "Modification des informations en ligne par le client  " . $message_statut . " avec succès ";
    } else {
        $error = "yes";
        $error_message = "Erreur lors du changement du statut de la modification des informations en ligne par le client  " . $message_statut;
    }
}

if (isset($_POST['submit_add_etude_sec'])) {
    $annee = $_POST['exetat_annee'];
    $ecole_frequenter = clean_in_text($_POST['ecole_frequenter']);
    $formation = clean_in_text($_POST['formation']);
    $resultat = clean_in_text($_POST['resultat']);

    $niveau = clean_in_text($_POST['niveau']);

    $feedback = add_dossier_etude($_SESSION['my_m_dossier'], $annee, $ecole_frequenter, $formation, $niveau, $resultat, 'SECONDAIRE', '', '', '', $_SESSION['my_username']);
    if ($feedback == 1) {

        $success = "yes";
        $success_message = "Creation Cursus " . $formation . " fait avec succès " . add_action_no_request($_SESSION['my_m_dossier'], 18, 'Valider', $_SESSION['my_username'], 'Oui', 'Ajout Etude Secondaire : ' . $niveau);
    } else {
        $error = "yes";
        $error_message = "Erreur lors de la creation du cursus  " . $formation;
    }
}


if (isset($_POST['submit_commentaire_interne'])) {

    $ref_dossier = $_SESSION['my_m_dossier'];
    $ref_operation = clean_in_text($_POST['ref_operation']);
    $telephone = clean_in_text($_POST['feedback_phone']);
    $email = clean_in_text($_POST['feedback_email']);

    $commentaire = clean_in_text($_POST['commentaire']);
    $data_operation = get_operation_data($ref_operation);
    $sms = "0";
    $email = "0";
    $data_dossier_temp = get_dossier_data(clean_in_integer($_SESSION['my_m_dossier']));



    $add_request_info = add_action_info($ref_dossier, $ref_operation, "", "", "", "", "Valide", $_SESSION['my_username'], "Non", $commentaire, $sms, $email, 0);

    $notification_sms = 0;
    $notification_email = 0;

    if ($add_request_info == 1 && isset($_POST['notification_sms']) && $_POST['notification_sms'] == "oui" && get_parameter_value("enable_sms") == 1) {

        $data_dossier_paiement = get_dossier_data($ref_dossier);
        $review_telephone = $data_dossier_temp['numero_telephone'];
        $review_telephone = str_ireplace("(", "", $review_telephone);
        $review_telephone = str_ireplace(")", "", $review_telephone);
        $review_telephone = str_ireplace("-", "", $review_telephone);
        $review_telephone = str_ireplace("_", "", $review_telephone);
        $review_telephone = str_ireplace(" ", "", $review_telephone);
        $text_message = $data_operation['label'] . " : " . $commentaire . " Contactez nous au " . $telephone . " ou " . $email;
        $sms_message = $commentaire . " ," . $telephone . " ou " . $email;

       // send_sms($review_telephone, $text_message, "PASSPORT", "NA");
        $notification_sms = 0;
    }
    if ($add_request_info == 1 && isset($_POST['notification_email']) && $_POST['notification_email'] == "oui" && get_parameter_value("enable_email") == 1) {

        $notification_email = 0;
    }

    if ($add_request_info == 1) {

        $success = "yes";
        $success_message = "Enregistrement Commentaire Interne fait avec succès, SMS notification : " . $notification_sms . " | Email Notificaion : " . $notification_email . "  | NID : " . $data_dossier_temp['ndel'];
    } else {
        $error = "yes";
        $error_message = "Erreur a survenu lors de l'enregistrement d'un Commentaire Interne ";
    }
}

if (isset($_POST['submit_commentaire_client'])) {

    $ref_dossier = $_SESSION['my_m_dossier'];
    $ref_operation = clean_in_text($_POST['ref_operation']);
    $telephone = clean_in_text($_POST['feedback_phone']);
    $email = clean_in_text($_POST['feedback_email']);

    $commentaire = clean_in_text($_POST['commentaire']) . " | Contactez nous via " . $telephone . " ou " . $email;
    $data_operation = get_operation_data($ref_operation);
    $sms = (isset($_POST['notification_sms'])) ? "1" : "0";
    $email = (isset($_POST['notification_email'])) ? "1" : "0";
    $email_secondaire = (isset($_POST['notification_email_secondaire'])) ? "1" : "0";
    $data_dossier_temp = get_dossier_data(clean_in_integer($_SESSION['my_m_dossier']));



    $add_request_info = add_action_info($ref_dossier, $ref_operation, "", "", "", "", "Valide", $_SESSION['my_username'], "Oui", $commentaire, $sms, $email, $email_secondaire);

    $notification_sms = 0;
    $notification_email = 0;
    $notification_email_secondaire = 0;
    if ($add_request_info == 1 && isset($_POST['notification_sms']) && $_POST['notification_sms'] == "oui" && get_parameter_value("enable_sms") == 1) {

        $data_dossier_paiement = get_dossier_data($ref_dossier);
        $review_telephone = $data_dossier_paiement['numero_telephone'];
        $review_telephone = str_ireplace("(", "", $review_telephone);
        $review_telephone = str_ireplace(")", "", $review_telephone);
        $review_telephone = str_ireplace("-", "", $review_telephone);
        $review_telephone = str_ireplace("_", "", $review_telephone);
        $review_telephone = str_ireplace(" ", "", $review_telephone);
        $text_message = $data_operation['label'] . " : " . $commentaire;
        $sms_message = $commentaire ;

        send_sms($review_telephone, $sms_message, "PASSPORT", "NA");
        $notification_sms = 1;
    }
    if ($add_request_info == 1 && isset($_POST['notification_email']) && $_POST['notification_email'] == "oui" && get_parameter_value("enable_email") == 1) {
        $text_message = $commentaire ;
        $to_destination = $data_dossier_temp['email'];
        $sujet=$data_operation['label'];
        $notification_email = 1;
        include("sendmail_info_client.php");
    }
    if ($add_request_info == 1 && isset($_POST['notification_email_secondaire']) && $_POST['notification_email_secondaire'] == "oui" && get_parameter_value("enable_email") == 1) {
        $text_message = $commentaire ;
        $to_destination = $data_dossier_temp['email_secondaire'];
        $sujet=$data_operation['label'];
        $notification_email_secondaire = 1;
        include("sendmail_info_client.php");
    }
    if ($add_request_info == 1) {

        $success = "yes";
        $success_message = "Commentaire Client fait avec succès, SMS notification : " . $notification_sms . " | Email Notificaion : " . $notification_email . "  | NID : " . $data_dossier_temp['ndel'];
    } else {
        $error = "yes";
        $error_message = "Erreur a survenu lors de l'enregistrement du Commentaire Client ";
    }
}

if (isset($_POST['submit_request_doc'])) {

    $ref_dossier = $_SESSION['my_m_dossier'];
    $ref_operation = clean_in_text($_POST['ref_operation']);
    $telephone = clean_in_text($_POST['feedback_phone']);
    $email = clean_in_text($_POST['feedback_email']);
    $mode_reception = clean_in_text($_POST['mode_reception']);
    $date_limite = clean_in_text($_POST['date_limite']);
    $commentaire = clean_in_text($_POST['commentaire']) . " | Reception document : " . $mode_reception . " | Date limite pour envoyer : " . $date_limite . " | Contactez via " . $telephone . " ou " . $email;
    $data_operation = get_operation_data($ref_operation);
    $sms = (isset($_POST['notification_sms'])) ? "1" : "0";
    $email = (isset($_POST['notification_email'])) ? "1" : "0";
    $email_secondaire = (isset($_POST['notification_email_secondaire'])) ? "1" : "0";
    $data_dossier_temp = get_dossier_data(clean_in_integer($_SESSION['my_m_dossier']));



    $add_request_info = add_action_info($ref_dossier, $ref_operation, "", "", "", "", "Valide", $_SESSION['my_username'], "Oui", $commentaire, $sms, $email, $email_secondaire);

    $notification_sms = 0;
    $notification_email = 0;

    if ($add_request_info == 1 && isset($_POST['notification_sms']) && $_POST['notification_sms'] == "oui" && get_parameter_value("enable_sms") == 1) {

        //$data_dossier_paiement=get_dossier_data($ref_dossier);  
        $review_telephone = $data_dossier_temp['numero_telephone'];
        $review_telephone = str_ireplace("(", "", $review_telephone);
        $review_telephone = str_ireplace(")", "", $review_telephone);
        $review_telephone = str_ireplace("-", "", $review_telephone);
        $review_telephone = str_ireplace("_", "", $review_telephone);
        $review_telephone = str_ireplace(" ", "", $review_telephone);
        $text_message = $data_operation['label'] . " : " . $commentaire;
        $sms_message = $commentaire;

        send_sms($review_telephone, $sms_message, "PASSPORT", "NA");
        $notification_sms = 1;
    }
    if ($add_request_info == 1 && isset($_POST['notification_email']) && $_POST['notification_email'] == "oui" && get_parameter_value("enable_email") == 1) {
        
        $text_message = $commentaire;
        $sujet=$data_operation['label'];
        $to_destination = $data_dossier_temp['email'];
        $notification_email = 1;
        include("sendmail_info_client.php");
    }
    if ($add_request_info == 1 && isset($_POST['notification_email_secondaire']) && $_POST['notification_email_secondaire'] == "oui" && get_parameter_value("enable_email") == 1) {
        
        $text_message = $commentaire;
        $sujet=$data_operation['label'];
        $to_destination = $data_dossier_temp['email_secondaire'];
        $notification_email_secondaire = 1;
        include("sendmail_info_client.php");
    }

    if ($add_request_info == 1) {

        $success = "yes";
        $success_message = "Demande Document fait avec succès, SMS notification : " . $notification_sms . " | Email Notificaion : " . $notification_email . "  | NID : " . $data_dossier_temp['ndel'];
    } else {
        $error = "yes";
        $error_message = "Erreur a survenu lors de l'enregistrement de la demande Document";
    }
}

if (isset($_POST['submit_request_info'])) {

    $ref_dossier = $_SESSION['my_m_dossier'];
    $ref_operation = clean_in_text($_POST['ref_operation']);
    $telephone = clean_in_text($_POST['feedback_phone']);
    $email = clean_in_text($_POST['feedback_email']);

    $commentaire = clean_in_text($_POST['commentaire']) . " | Repondez via " . $telephone . " ou " . $email;
    $data_operation = get_operation_data($ref_operation);
    $sms = (isset($_POST['notification_sms'])) ? "1" : "0";
    $email = (isset($_POST['notification_email'])) ? "1" : "0";
    $email_secondaire = (isset($_POST['notification_email_secondaire'])) ? "1" : "0";
    $data_dossier_temp = get_dossier_data(clean_in_integer($_SESSION['my_m_dossier']));



    $add_request_info = add_action_info($ref_dossier, $ref_operation, "", "", "", "", "Valide", $_SESSION['my_username'], "Oui", $commentaire, $sms, $email, $email_secondaire);

    $notification_sms = 0;
    $notification_email = 0;
    $notification_email_secondaire = 0;

    if ($add_request_info == 1 && isset($_POST['notification_sms']) && $_POST['notification_sms'] == "oui" && get_parameter_value("enable_sms") == 1) {

        $data_dossier_paiement = get_dossier_data($ref_dossier);
        $review_telephone = $data_dossier_paiement['numero_telephone'];
        $review_telephone = str_ireplace("(", "", $review_telephone);
        $review_telephone = str_ireplace(")", "", $review_telephone);
        $review_telephone = str_ireplace("-", "", $review_telephone);
        $review_telephone = str_ireplace("_", "", $review_telephone);
        $review_telephone = str_ireplace(" ", "", $review_telephone);
        $text_message = $data_operation['label'] . " : " . $commentaire;
        $sms_message = $commentaire ;

        send_sms($review_telephone, $sms_message, "PASSPORT", "NA");
        $notification_sms = 1;
    }
    if ($add_request_info == 1 && isset($_POST['notification_email']) && $_POST['notification_email'] == "oui" && get_parameter_value("enable_email") == 1) {
        $text_message = $commentaire ;
        $to_destination = $data_dossier_temp['email'];
        $sujet=$data_operation['label'];
        $notification_email = 1;
        include("sendmail_info_client.php");
    }
    if ($add_request_info == 1 && isset($_POST['notification_email_secondaire']) && $_POST['notification_email_secondaire'] == "oui" && get_parameter_value("enable_email") == 1) {
        
        $text_message = $commentaire ;
        $to_destination = $data_dossier_temp['email_secondaire'];
        $sujet=$data_operation['label'];
        $notification_email_secondaire = 1;
        include("sendmail_info_client.php");
    }

    if ($add_request_info == 1) {

        $success = "yes";
        $success_message = "Demande d'information fait avec succès, SMS notification : " . $notification_sms . " | Email Notificaion : " . $notification_email . "  | NID : " . $data_dossier_temp['ndel'];
    } else {
        $error = "yes";
        $error_message = "Erreur a survenu lors de l'enregistrement de la demande d'information ";
    }
}

if (isset($_POST['submit_add_paiement'])) {

    $ref_dossier = $_SESSION['my_m_dossier'];
    $ref_operation = clean_in_text($_POST['ref_operation']);
    $montant = clean_in_double($_POST['montant']);
    $devise = clean_in_text($_POST['devise']);
    $data_operation = get_operation_data($ref_operation);
    $type_account = $data_operation['ref_type_operation'];
    $montant_usd=($devise=='USD') ? $montant : $montant/$_SESSION['my_taux'];
    $date_paiement = clean_in_text($_POST['date_paiement']);
    $mode_paiement = clean_in_text($_POST['mode_paiement']);
    $commentaire = clean_in_text($_POST['commentaire'] . " | Montant : " . $montant . " " . $devise . " | Date paiement : " . $date_paiement . " | mode de paiement : " . $mode_paiement);
    $sms = (isset($_POST['notification_sms'])) ? "1" : "0";
    $email = (isset($_POST['notification_email'])) ? "1" : "0";
    $email_2 = (isset($_POST['notification_email_secondaire'])) ? "1" : "0";
    $data_dossier_temp = get_dossier_data(clean_in_integer($_SESSION['my_m_dossier']));
    $code_transaction = $data_operation['ref_type_operation']."-" . time();

    switch ($data_operation['ref_type_operation']) {

		case 'OP':

			$statut_transaction = "Soumis";
			$type_account = "OP";
            $code_transaction = "OP-" . time();
            

			break;

		case 'OC':

			$statut_transaction = "Valide";
			$type_account = "OC";
            $code_transaction = "OC-" . time();
            

			break;

		case 'OE':

			$statut_transaction = "Soumis";
			$type_account = "OE";
            $code_transaction = "OE-" . time();
            

			break;
	}

    
    $code_operation=$data_operation['label'];
    $type_account=$data_operation['ref_type_operation'];
    $libelle=$data_dossier_temp['identite']." : ".$data_dossier_temp['ndel'];
    $limit_encaissement=$data_dossier_temp['limit_encaissement'];
    $total_oe=get_sum_oe("Valide",'USD',$data_dossier_temp['ndel'])+(get_sum_oe("Valide",'CDF',$data_dossier_temp['ndel'])/$_SESSION['my_taux']);
    $total_oe=$total_oe+0;
    //echo " kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk : ".$total_oe;

    $add_paiement = ($type_account=='OP' || ($type_account=='OE' && $limit_encaissement==0) || ($type_account=='OE' && $limit_encaissement>0 && $limit_encaissement>=($montant_usd+$total_oe))) ? add_action_paiement($ref_dossier, $ref_operation, $montant, $devise, $date_paiement, $mode_paiement, $statut_transaction, $_SESSION['my_username'], "Oui", $commentaire, $sms, $email) : 0;
    $feedback_transaction =($add_paiement==0) ? 0 : add_transaction_with_detail($data_operation['ref_type_operation'], $devise , $montant, "Agence web", 0, 0, 0, $code_transaction, $statut_transaction, $data_dossier_temp['ndel'], 0, $ref_operation, $code_operation, 0, 'NA', $type_account, $libelle);
    $feedback_compta =1;
    $notification_sms = 0;
    $notification_email = 0;
    $notification_email_secondaire = 0;
    if ($add_paiement == 1 && $feedback_transaction== 1 && $feedback_compta>= 1) {
        if (isset($_POST['notification_sms']) && $_POST['notification_sms'] == "oui" && get_parameter_value("enable_sms") == 1) {

            $data_dossier_paiement = get_dossier_data($ref_dossier);
            $review_telephone = $data_dossier_paiement['numero_telephone'];
            $review_telephone = str_ireplace("(", "", $review_telephone);
            $review_telephone = str_ireplace(")", "", $review_telephone);
            $review_telephone = str_ireplace("-", "", $review_telephone);
            $review_telephone = str_ireplace("_", "", $review_telephone);
            $review_telephone = str_ireplace(" ", "", $review_telephone);
            $text_message = "Un paiement de " . $montant . " " . $devise . " vient d'etre enregistrer sur le dossier  ";
    
            send_sms($review_telephone, $text_message, "PASSPORT", "NA");
            $notification_sms = 1;
        }
        if (isset($_POST['notification_email']) && $_POST['notification_email'] == "oui" && get_parameter_value("enable_email") == 1) {
            
            $text_message = $commentaire ;
            $to_destination=$data_dossier_temp['email'];
            $sujet=$data_operation['label'];
            include("sendmail_info_client.php");
            $notification_email = 1;
        }
        if (isset($_POST['notification_email_secondaire']) && $_POST['notification_email_secondaire'] == "oui" && get_parameter_value("enable_email") == 1) {
            
            $text_message = $commentaire ;
            $to_destination=$data_dossier_temp['email_secondaire'];
            $sujet=$data_operation['label'];
            include("sendmail_info_client.php");
            $notification_email_secondaire = 1;
        }
        $success = "yes";
        $success_message = "Paiement enregistré avec succès, SMS notification : " . $notification_sms . " | Email Notificaion : " . $notification_email."<br>";
    } else {
        $error = "yes";
        $error_message = "Erreur a survenu lors du paiement <br>";

        if(($type_account=='OE' && $limit_encaissement>0 && $limit_encaissement<($montant_usd+$total_oe))){
            $error_message=$error_message."Vous ne pouvez effectuer un versement car la limite en USD ".$limit_encaissement." sera depassé avec cette encaissement de ".$montant." ".$devise.'<br>La total actuel en USD est deja de '.round($total_oe,0);


        }
    }
}

if (isset($_POST['submit_add_doc'])) {

    $url_fichier = "";
    $is_file_transafered = 0;
    $type_fichier = "";
    if (isset($_FILES['doc_file']) && $_FILES['doc_file']['name'] != '') {

        $value = explode(".", $_FILES['doc_file']['name']);
        $type_fichier = $value[1];
        $url_initial = "uploads/" . $_SESSION['my_m_dossier'] . "_doc_" . date('s') . date('i') . "." . $value[1];
        $download_file = move_uploaded_file($_FILES['doc_file']['tmp_name'], $url_initial);
        $url_fichier = ($download_file == 1) ? $url_initial : $url_fichier;
        $is_file_transafered = ($download_file == 1) ? 1 : 0;
        $success_message = $success_message . " | -- Fichier Exetat ajouté";
    }

    $add_document = ($is_file_transafered == 1) ? add_document($_SESSION['my_m_dossier'], $_SESSION['my_username'], $url_fichier, $type_fichier, $_POST['titre_document']) : 0;
    $success_message = ($add_document == 1) ? $success_message . " | - Document ajouté" . add_action_no_request($_SESSION['my_m_dossier'], 6, 'Valider', $_SESSION['my_username'], 'Oui', 'Ajout Document : ' . $_POST['titre_document']) : " | - Erreur Ajout Document";
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
  
    $backup_client=get_dossier_data_by_ndel($nid);

    $feedback = update_details_zone_charge_front($_SESSION['my_m_dossier'], $pc_qualite_garant, $pc_lieu_travail_garant, $pc_salaire_parrain, $pc_activite_pro_chk, $pc_activite_pro_nom, $pc_revenu_parrain, $pc_nbre_parcelle, $pc_nbre_vehicule,$numero_telephone_secondaire,$email_secondaire,$domaine_preference);
    $backup_after=get_dossier_data_by_ndel($nid);
    if ($feedback == 1) {
        add_notification("t_dossier", $nid, json_encode($backup_client),json_encode($backup_after), $_SESSION['my_username'], "Edition Zone Charge");
        
        $success = "yes";
        $success_message = "Zone prise en charge Client du dossier a été mise à jour avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur mise à jour Zone prise en charge Client du dossier";
    }
}

if (isset($_POST['btn_edition_zone_voyage'])) {

    $edit = $_SESSION['my_m_dossier'];

    $data_dossier_temp = get_dossier_data($edit);

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
    $backup_client=get_dossier_data_by_ndel($data_dossier_temp['ndel']);
    $nid=$data_dossier_temp['ndel'];
    $q_universite = clean_in_text($_POST['q_universite']);
    $q_pays = clean_in_text($_POST['q_pays']);

    $feedback = update_details_zone_voyage($_SESSION['my_m_dossier'], $vo_destination, $vo_raison_voyage, $vo_charge_etude_parrain, $vo_ancien_visa, $vo_ancien_visa_comment, $vo_refus_visa_chk, $commentaire_refus_visa, $vo_destination_famille_chk, $vo_destination_comment,$domaine_preference,$q_universite, $q_pays);
    $backup_after=get_dossier_data_by_ndel($nid);
    if ($feedback == 1) {
        add_notification("t_dossier", $nid, json_encode($backup_client),json_encode($backup_after), $_SESSION['my_username'], "Edition Zone Voyage");
        
        $success = "yes";
        $success_message = "Zone Voyage Client du dossier a été mise à jour avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur mise à jour Zone Voyage Client du dossier";
    }
}
if (isset($_POST['btn_edition_emploi'])) {

    $activite_passe_actuelle = clean_in_text($_POST['activite_passe_actuelle']);
    $backup_client=get_dossier_data_by_ndel($nid);

    $feedback = update_details_emploi_passer($_SESSION['my_m_dossier'], $activite_passe_actuelle);
    $backup_after=get_dossier_data_by_ndel($nid);
    if ($feedback == 1) {
        add_notification("t_dossier", $nid, json_encode($backup_client),json_encode($backup_after), $_SESSION['my_username'], "Edition Emploi dossier");
       
        $success = "yes";
        $success_message = "le détail sur les emplois passés a été mise à jour avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur mise à jour Details emploi passés";
    }
}
if (isset($_GET['del_doc']) && get_access(10, $_SESSION['my_idprofile']) == 1 && clean_in_integer($_GET['idt_doc']) > 0) {

    $feedback = set_dossier_document_view(clean_in_integer($_GET['idt_doc']), 0);
    $data_doc = get_document_data(clean_in_integer($_GET['idt_doc']));

    if ($feedback == 1) {

        $success = "yes";
        $success_message = "Suppression fichier fait avec succès " . add_action_no_request($_SESSION['my_m_dossier'], 16, 'Valider', $_SESSION['my_username'], 'Oui', 'Suppression Cursus : ' . $data_doc['niveau']);
    } else {
        $error = "yes";
        $error_message = "Erreur survenue lors de la suppression du fichier ";
    }
}
if (isset($_GET['del_etude']) && get_access(10, $_SESSION['my_idprofile']) == 1 && clean_in_integer($_GET['idt_doc_study']) > 0) {

    $feedback = set_dossier_etude_view(clean_in_integer($_GET['idt_doc_study']), 0);
    $data_etude = get_dossier_etude_data(clean_in_integer($_GET['idt_doc_study']));
    if ($feedback == 1) {

        $success = "yes";
        $success_message = "Enregistrement Etude supprimé avec succès" . add_action_no_request($_SESSION['my_m_dossier'], 17, 'Valider', $_SESSION['my_username'], 'Oui', 'Suppression Document : ' . $data_doc['titre_document']);
        ;
    } else {
        $error = "yes";
        $error_message = "Erreur survenue lors de la suppression de l'enregistrement ";
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

    $feedback = update_section_identite_client($_SESSION['my_m_dossier'], $identite, $nid, $date_naissance, $telephone, $email, $lieu_naissance, $nbre_enfant_famille, $position_dans_famille, $numero_passport, $date_expiration_pp, $ref_agence, $promoteur_agence, $pin_secret, $commentaire_client,$identite_pere,$lieu_naissance_pere,$date_naissance_pere,$identite_mere,$lieu_naissance_mere,$date_naissance_mere,$sexe,$adresse,$ville_pays);
    $backup_after=get_dossier_data_by_ndel($nid);
    if ($feedback == 1) {
        add_notification("t_dossier", $nid, json_encode($backup_client),json_encode($backup_after), $_SESSION['my_username'], "Edition identite Client");
        
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

    $feedback = add_dossier_etude($_SESSION['my_m_dossier'], $annee, $ecole_frequenter, $formation, "EXETAT", $resultat, "EXETAT", '', $ville_obtention, $pays_obtention, $_SESSION['my_username']);


    if ($feedback == 1) {

        $success = "yes";
        $success_message = "Cursus EXETAT ajouté avec succès" . add_action_no_request($_SESSION['my_m_dossier'], 18, 'Valider', $_SESSION['my_username'], 'Oui', 'Ajout Etude : EXETAT');
        ;
    } else {
        $error = "yes";
        $error_message = "Erreur  survenue lors de l'ajout d'un cursus EXETAT";
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

    $feedback = add_dossier_etude($_SESSION['my_m_dossier'], $annee, $ecole_frequenter, $formation, $niveau, $resultat, $diplome_obtenu, '', '', '', $_SESSION['my_username']);
    if ($feedback == 1) {

        $success = "yes";
        $success_message = "Creation Cursus " . $formation . " fait avec succès " . add_action_no_request($_SESSION['my_m_dossier'], 18, 'Valider', $_SESSION['my_username'], 'Oui', 'Ajout Etude : ' . $niveau);
    } else {
        $error = "yes";
        $error_message = "Erreur lors de la creation du cursus  " . $formation;
    }
}

if (isset($_GET['ndel'])) {

    $edit = clean_in_text($_GET['ndel']);

    $data_dossier = get_dossier_data_by_ndel($edit);
				//	echo "dddddddddddddddddddddddddddddddddddddddddddddddd : ".$data_dossier['is_exist'];
    if ($data_dossier['is_exist'] == 1) {
        $_SESSION['my_m_dossier'] = $data_dossier['idt_dossier'];

        
    } else {

        // header("Location: home.php?error=ok&msg=Ce Profile n'existe pas, vous n'etes pas autorise à la page suivante");				
    }
}
if (isset($_GET['find'])) {

    $edit = clean_in_integer($_GET['find']);

    $data_dossier = get_dossier_data($edit);
//					echo $edit;
    if ($data_dossier['is_exist'] == 1) {
        $_SESSION['my_m_dossier'] = $edit;

        
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

        
    } else {


       // header("Location: home.php?error=ok&msg=Ce Profile n'existe pas, vous n'etes pas autorise à la page suivante");
    }
}

?>