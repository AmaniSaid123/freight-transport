<?php

//*************************************************************************************************************************************************
//**********************Function*******************************************************************************************************************
//*************************************************************************************************************************************************
//********************GLOBAL FUNCTION*******************
//******************************************************

function add_notification($ref_element, $id_element, $before, $after, $ref_user, $description) {
    include("param.php");

    $sql_query = $bdd->exec("insert into t_notification(ref_element,id_element,creationdate,before_event,after_event,ref_user,description) values('" . $ref_element . "','" . $id_element . "',now(),'" . $before . "','" . $after . "','" . $ref_user . "','" . $description . "')");

    return $sql_query;
}

function add_ecriture($ref_compte, $action, $ref_operation) {
    include("param.php");

    $resultat = $bdd->exec("insert into t_ecriture(ref_compte,ref_user,ref_operation,action,creationdate) values(" . $ref_compte . ",'" . $_SESSION['my_username'] . "'," . $ref_operation . ",'" . $action . "',now())");
//echo "insert into t_compte_eac(numero_compte,ref_user,ref_dossier,ref_devise,creationdate) values('".$numero_compte."','".$_SESSION['my_username']."',".$ref_dossier.",'".$ref_devise."',now())";

    return $resultat;
}

function add_taux($taux) {
    include("param.php");

    $resultat = $bdd->exec("insert into t_taux(valeur,creationdate) values(" . $taux . ",now())");
//echo "insert into t_taux(value,creationdate) values(".$taux.",now())";

    return $resultat;
}

function add_anniversaire(string $str1, string $str2, string $str3, string $str4, string $str5)
{
    include("param.php");
    
    $sql_query=$bdd->exec("insert into t_message_anniversaire(ref_dossier,message_sms,message_mail, datecreation,ref_user,statut) values('".$str1."','".$str2."','".$str3."',now(),'".$str4."','".$str5."')");

    return $sql_query;  
    
}

function add_message($sujet, $text_sms, $text_mail, $statut, $ref_user)
{
    include("param.php");
    $resultat = $bdd->exec("INSERT INTO t_message_souhait(sujet,txt_sms,txt_mail, statut,ref_user,date_creation) VALUES('".$sujet."','".$text_sms."','".$text_mail."','".$statut."','".$ref_user."',now())");
    
    return $resultat;
}

function add_dossier($nid,$ndel, $identite, $lieu_naissance, $date_naissance, $email, $nbre_enfant_famille, $position_dans_famille, $numero_passport, $date_expiration_pp, $activite_passe_actuelle, $vo_destination, $vo_raison_voyage, $vo_charge_etude_parrain, $vo_ancien_visa, $vo_ancien_visa_comment, $numero_telephone, $vo_refus_visa, $vo_refus_visa_comment, $vo_destination_famille, $vo_destination_comment, $pc_qualite_garant, $pc_lieu_travail_garant, $pc_salaire_parrain, $pc_activite_pro, $pc_activite_pro_nom, $pc_revenu_parrain, $pc_nbre_parcelle, $pc_nbre_vehicule, $statut_dossier, $promoteur_agence, $ref_agence, $pin_secret, $ref_user,$commentaire_client,$identite_pere,$lieu_naissance_pere,$datenaissance_pere,$identite_mere,$lieu_naissance_mere,$datenaissance_mere,$sexe,$adresse,$ville_pays,$domaine_preference) {
    include("param.php");

    $sql_query = "INSERT INTO `passport_bd`.`t_dossier`
(
`ndel`,nid_pp,
`creationdate`,
`identite`,
`lieu_naissance`,
`date_naissance`,
`nbre_enfant_famille`,
`position_dans_famille`,
`numero_passport`,
`date_expiration_pp`,
`activite_passe_actuelle`,
`vo_destination`,
`vo_raison_voyage`,
`vo_charge_etude_parrain`,
`vo_ancien_visa`,
`vo_ancien_visa_comment`,
`numero_telephone`,
`vo_refus_visa`,
`vo_refus_visa_comment`,
`vo_destination_famille`,
`vo_destination_comment`,
`pc_qualite_garant`,
`pc_lieu_travail_garant`,
`pc_salaire_parrain`,
`pc_activite_pro`,
`pc_activite_pro_nom`,
`pc_revenu_parrain`,
`pc_nbre_parcelle`,
`pc_nbre_vehicule`,
`statut_dossier`,
`promoteur_agence`,
`ref_agence`,
`pin_secret`,
 ref_user,email,
 commentaire_client,
 identite_pere,
 lieu_naissance_pere,
 date_naissance_pere,
 identite_mere,
 lieu_naissance_mere,
 date_naissance_mere,
 sexe,
 adresse,
 ville_pays,
 domaine_preference)
VALUES
(
'" . $ndel . "','" . $nid . "',
now(),
'" . $identite . "',
'" . $lieu_naissance . "',
'" . $date_naissance . "',
'" . $nbre_enfant_famille . "',
'" . $position_dans_famille . "',
'" . $numero_passport . "',
'" . $date_expiration_pp . "',
'" . $activite_passe_actuelle . "',
'" . $vo_destination . "',
'" . $vo_raison_voyage . "',
'" . $vo_charge_etude_parrain . "',
'" . $vo_ancien_visa . "',
'" . $vo_ancien_visa_comment . "',
'" . $numero_telephone . "',
'" . $vo_refus_visa . "',
'" . $vo_refus_visa_comment . "',
'" . $vo_destination_famille . "',
'" . $vo_destination_comment . "',
'" . $pc_qualite_garant . "',
'" . $pc_lieu_travail_garant . "',
'" . $pc_salaire_parrain . "',
'" . $pc_activite_pro . "',
'" . $pc_activite_pro_nom . "',
'" . $pc_revenu_parrain . "',
'" . $pc_nbre_parcelle . "',
'" . $pc_nbre_vehicule . "',
'" . $statut_dossier . "',
'" . $promoteur_agence . "',
'" . $ref_agence . "',
'" . $pin_secret . "',
'" . $ref_user . "',
'" . $email . "',
'" . $commentaire_client . "',"
            . "'" . $identite_pere . "',"
            . "'" . $lieu_naissance_pere . "',"
            . "'" . $datenaissance_pere . "',"
            . "'" . $identite_mere . "',"
            . "'" . $lieu_naissance_mere . "',"
            . "'" . $datenaissance_mere . "',"
            . "'" . $sexe . "',"
            . "'" . $adresse . "',"
            . "'" . $ville_pays . "',"
            . "'" . $domaine_preference . "' );";

    $resultat = $bdd->exec($sql_query);
//echo $sql_query;

    return $resultat;
}

function add_dossier_etude($ref_dossier, $annee, $institution, $formation, $niveau, $resultat, $diplome_obtenu, $url, $ville_obtention, $pays_obtention, $ref_user) {
    include("param.php");

    $resultat = $bdd->exec("INSERT INTO `passport_bd`.`t_dossier_etude`
(
`ref_dossier`,
`annee`,
`institution`,
`formation`,
`niveau`,
`resultat`,
`diplome_obtenu`,
`url`,
`ville_obtention`,
`pays_obtention`,
`creationdate`,ref_user)
VALUES
('" . $ref_dossier . "','" . $annee . "','" . $institution . "','" . $formation . "','" . $niveau . "','" . $resultat . "','" . $diplome_obtenu . "','','" . $ville_obtention . "','" . $pays_obtention . "',now(),'" . $ref_user . "')");

    return $resultat;
}

function add_document($ref_dossier, $ref_user, $url_document, $type_fichier,$titre) {
    include("param.php");

    $resultat = $bdd->exec("INSERT INTO `passport_bd`.`t_document_dossier`
(
`ref_dossier`,
`creationdate`,
`ref_user`,
`url_document`,
`type_fichier`,titre_document)
VALUES
('" . $ref_dossier . "',now(),'" . $ref_user . "','" . $url_document . "','" . $type_fichier . "','".$titre."')");
/*echo "INSERT INTO `passport_bd`.`t_document_dossier`
(
`ref_dossier`,
`creationdate`,
`ref_user`,
`url_document`,
`type_fichier`,titre_document)
VALUES
('" . $ref_dossier . "',now(),'" . $ref_user . "','" . $url_document . "','" . $type_fichier . "','".$titre."')";*/

    return $resultat;
}

function add_action_request($ref_dossier, $ref_operation, $delai, $mode_reception_1, $mode_reception_2, $mode_reception_3, $mode_reception_4, $notification_sms, $notification_email, $notification_appel, $statut, $ref_requester, $customer_viewable, $commentaire) {
    include("param.php");

    $resultat = $bdd->exec("NSERT INTO `passport_bd`.`t_actions`
(
`ref_dossier`,
`ref_operation`,
`debut_date`,
`fin_date`,
`delai_jours`,
`mode_reception_1`,
`mode_reception_2`,
`mode_reception_3`,
`notification_sms`,
`notification_email`,
`notification_appel`,
`statut`,
`creationdate`,

`ref_requester`,

`mode_reception_4`
,`customer_viewable`
,commentaire)
VALUES
(
'" . $ref_dossier . "',
'" . $ref_operation . "',
date(now()),
date(now())+" . $delai . ",
'" . $mode_reception_1 . "',
'" . $mode_reception_2 . "',
'" . $mode_reception_3 . "',
'" . $notification_sms . "',
'" . $notification_email . "',
'" . $notification_appel . "',
'" . $statut . "',
now(),
'" . $feedback_date . "',
'" . $ref_requester . "',
'" . $mode_reception_4 . "',
'" . $customer_viewable . "',
'" . $commentaire . "')");
//echo "insert into t_compte_eac(numero_compte,ref_user,ref_dossier,ref_devise,creationdate) values('".$numero_compte."','".$_SESSION['my_username']."',".$ref_dossier.",'".$ref_devise."',now())";

    return $resultat;
}

function add_action_no_request($ref_dossier, $ref_operation, $statut, $ref_requester, $customer_viewable, $commentaire) {
    include("param.php");

    $query = "INSERT INTO `passport_bd`.`t_actions`
(
`ref_dossier`,
`ref_operation`,
`statut`,
`creationdate`,
`ref_requester`,
`customer_viewable`,
commentaire)
VALUES
(
'" . $ref_dossier . "',
'" . $ref_operation . "',
'" . $statut . "',
now(),
'" . $ref_requester . "',
'" . $customer_viewable . "',
'" . $commentaire . "')";

    $resultat = $bdd->exec($query);
echo $query;
//echo "insert into t_compte_eac(numero_compte,ref_user,ref_dossier,ref_devise,creationdate) values('".$numero_compte."','".$_SESSION['my_username']."',".$ref_dossier.",'".$ref_devise."',now())";

    return $resultat;
}

function add_profile_content($ref_profile, $ref_content) {
    include("param.php");

    $sql_search = "insert into t_profile_content(ref_profile,ref_content,creationdate,ref_user) values(" . $ref_profile . ",'" . $ref_content . "',now(),'" . $_SESSION['my_username'] . "')";
    $sql_query = $bdd->exec($sql_search);


    return $sql_query;
}
function add_dossier_tache($ref_dossier, $ref_tache) {
    include("param.php");

    $sql_search = "insert into t_tache_dossier(ref_dossier,ref_tache,creationdate,ref_user) values(" . $ref_dossier . ",'" . $ref_tache . "',now(),'" . $_SESSION['my_username'] . "')";
    $sql_query = $bdd->exec($sql_search);


    return $sql_query;
}
function add_profile_statut($ref_profile, $ref_statut) {
    include("param.php");

    $sql_search = "insert into t_statu_dossier_profile(ref_profile,ref_statut_dossier,creationdate,ref_user) values(" . $ref_profile . ",'" . $ref_statut . "',now(),'" . $_SESSION['my_username'] . "')";
    $sql_query = $bdd->exec($sql_search);


    return $sql_query;
}
function add_action_paiement($ref_dossier, $ref_operation, $montant, $devise, $date_paiement,$mode_paiement, $statut,$ref_requester, $customer_viewable, $commentaire,$sms,$email) {
    include("param.php");

    $query ="INSERT INTO `passport_bd`.`t_actions`
(
`ref_dossier`,
`ref_operation`,
`debut_date`,
mode_paiement,
`montant`,
`devise`,
`statut`,
`creationdate`,
`ref_requester`,
`customer_viewable`
,commentaire,notification_sms,notification_email)
VALUES
(
'" . $ref_dossier . "',
'" . $ref_operation ."',"
. "'".$date_paiement."' ,
'" . $mode_paiement . "',"
. "'" .$montant . "',
'" . $devise . "',
'" . $statut . "',
now(),
'" . $ref_requester . "',
'".$customer_viewable."',
'" . $commentaire . "',
'" . $sms . "',
'" . $email . "')";
//echo $query;
    $resultat = $bdd->exec($query);
    return $resultat;
}
function add_action_info($ref_dossier, $ref_operation, $montant, $devise, $date_paiement,$mode_paiement, $statut,$ref_requester, $customer_viewable, $commentaire,$sms,$mail) {
    include("param.php");

    $query ="INSERT INTO `passport_bd`.`t_actions`
(
`ref_dossier`,
`ref_operation`,
`debut_date`,
mode_paiement,
`montant`,
`devise`,
`statut`,
`creationdate`,
`ref_requester`,
`customer_viewable`
,commentaire
,notification_sms
,notification_email)
VALUES
(
'" . $ref_dossier . "',
'" . $ref_operation ."',"
. "now() ,
'" . $mode_paiement . "',"
. "'" .$montant . "',
'" . $devise . "',
'" . $statut . "',
now(),
'" . $ref_requester . "',
'".$customer_viewable."',
'" . $commentaire . "',
'" . $sms . "',
'" . $mail . "')";
//echo $query;
    $resultat = $bdd->exec($query);
    return $resultat;
}
function add_broadcast_list($name,$description){
	include("param.php");
	$content="";
		$sql_query=$bdd->exec("insert into t_broadcast_list(name,description,creationdate,ref_user) values('".$name."','".$description."',now(),'".$_SESSION['my_username']."')");

return $sql_query;	
	
    }
    
    function add_livre_compte($account_no, $label, $devise, $credit_final, $debit_final, $credit_cdf, $debit_cdf, $credit_usd, $debit_usd, $display_sub, $ref_agence) {
        include("param.php");
    
        $resultat = mysqli_query($bdd_i,"insert into t_livre_compte(account_no,label,ref_devise,credit_final,debit_final,solde_final,credit_cdf,debit_cdf,solde_cdf,credit_usd,debit_usd,solde_usd,display_sub,creationdate,ref_user,ref_agence) values('" . $account_no . "','" . $label . "','" . $devise . "'," . $credit_final . "," . $debit_final . "," . ($debit_final - $credit_final) . "," . $credit_cdf . "," . $debit_cdf . "," . ($debit_cdf-$credit_cdf) . "," . $credit_usd . "," . $debit_usd . "," . ($debit_usd-$credit_usd) . ",'" . $display_sub . "',now(),'" . $_SESSION['my_username'] . "'," . $ref_agence . ")");
    //echo "insert into t_livre_compte(account_no,label,ref_devise,credit_final,debit_final,solde_final,credit_cdf,debit_cdf,solde_cdf,credit_usd,debit_usd,solde_usd,display_sub,creationdate,ref_user,ref_agence) values('".$account_no."','".$label."','".$devise."',".$credit_final.",".$debit_final.",".($credit_final-$debit_final).",".$credit_cdf.",".$debit_cdf.",".($credit_cdf-$debit_cdf).",".$credit_usd.",".$debit_usd.",".($credit_usd-$debit_usd).",'".$display_sub."',now(),'".$_SESSION['my_username']."',".$ref_agence.")";
    
        return $resultat;
    }

    function add_livre_compte_capture($account_no, $label, $devise, $credit_final, $debit_final, $credit_cdf, $debit_cdf, $credit_usd, $debit_usd, $display_sub, $ref_agence, $libelle) {
        include("param.php");
    
        $resultat = mysqli_query($bdd_i,"insert into t_capture_bilan(account_no,label,ref_devise,credit_final,debit_final,solde_final,credit_cdf,debit_cdf,solde_cdf,credit_usd,debit_usd,solde_usd,display_sub,creationdate,ref_user,ref_agence,libelle) values('" . $account_no . "','" . $label . "','" . $devise . "'," . $credit_final . "," . $debit_final . "," . ($credit_final - $debit_final) . "," . $credit_cdf . "," . $debit_cdf . "," . ($credit_cdf - $debit_cdf) . "," . $credit_usd . "," . $debit_usd . "," . ($credit_usd - $debit_usd) . ",'" . $display_sub . "',now(),'" . $_SESSION['my_username'] . "'," . $ref_agence . ",'" . $libelle . "')");
    //echo "insert into t_livre_compte(account_no,label,ref_devise,credit_final,debit_final,solde_final,credit_cdf,debit_cdf,solde_cdf,credit_usd,debit_usd,solde_usd,display_sub,creationdate,ref_user,ref_agence) values('".$account_no."','".$label."','".$devise."',".$credit_final.",".$debit_final.",".($credit_final-$debit_final).",".$credit_cdf.",".$debit_cdf.",".($credit_cdf-$debit_cdf).",".$credit_usd.",".$debit_usd.",".($credit_usd-$debit_usd).",'".$display_sub."',now(),'".$_SESSION['my_username']."',".$ref_agence.")";
    
        return $resultat;
    }

    function add_operation_finance($label,$ref_type_operation,$is_ponctual_payment,$day_reference) {
        include("param.php");
        $resultat=0;
        if($ref_type_operation=='DO'){
            $resultat = mysqli_query($bdd_i,"insert into t_operation(label,is_customer_request,customer_viewable,is_document_request,groupement,label_icone,is_finance_ops,ref_type_operation,is_ponctual_payment,day_reference,creationdate,ref_user) values('" . $label . "',1,1,1,'Demande_document','fa-folder-open bg-red',1,'" . $ref_type_operation . "','" . $is_ponctual_payment . "','" . $day_reference . "',now(),'" . $_SESSION['my_username'] . "')");
   

        }elseif($ref_type_operation=='INFO_Int'){
            $resultat = mysqli_query($bdd_i,"insert into t_operation(label,is_customer_request,customer_viewable,is_document_request,groupement,label_icone,is_finance_ops,ref_type_operation,is_ponctual_payment,day_reference,creationdate,ref_user) values('" . $label . "',1,1,0,'Commentaire_interne','fa-info-circle bg-blue',1,'" . $ref_type_operation . "','" . $is_ponctual_payment . "','" . $day_reference . "',now(),'" . $_SESSION['my_username'] . "')");
   
        }elseif($ref_type_operation=='INFO_Ext'){
            $resultat = mysqli_query($bdd_i,"insert into t_operation(label,is_customer_request,customer_viewable,is_document_request,groupement,label_icone,is_finance_ops,ref_type_operation,is_ponctual_payment,day_reference,creationdate,ref_user) values('" . $label . "',1,1,0,'Commentaire_externe','fa-info-circle bg-blue',1,'" . $ref_type_operation . "','" . $is_ponctual_payment . "','" . $day_reference . "',now(),'" . $_SESSION['my_username'] . "')");
   
        }elseif($ref_type_operation=='D_INFO'){
            $resultat = mysqli_query($bdd_i,"insert into t_operation(label,is_customer_request,customer_viewable,is_document_request,groupement,label_icone,is_finance_ops,ref_type_operation,is_ponctual_payment,day_reference,creationdate,ref_user) values('" . $label . "',1,1,0,'Demande_information','fa-info-circle bg-red',1,'" . $ref_type_operation . "','" . $is_ponctual_payment . "','" . $day_reference . "',now(),'" . $_SESSION['my_username'] . "')");
   
        }else          
            {
            $resultat = mysqli_query($bdd_i,"insert into t_operation(label,is_customer_request,customer_viewable,is_document_request,groupement,label_icone,is_finance_ops,ref_type_operation,is_ponctual_payment,day_reference,creationdate,ref_user) values('" . $label . "',0,1,0,'Paiement','fa-money bg-blue',1,'" . $ref_type_operation . "','" . $is_ponctual_payment . "','" . $day_reference . "',now(),'" . $_SESSION['my_username'] . "')");
   


        }
         //echo "insert into t_operation(label,is_customer_request,customer_viewable,is_document_request,groupement,label_icone,is_finance_ops,ref_type_operation,creationdate,ref_user) values('" . $label . "',0,0,0,'Paiement','fa-money bg-blue',1,'" . $ref_type_operation . "',now(),'" . $_SESSION['my_username'] . "')";
        return $resultat;
    }
    function add_transaction($ref_type_compte, $ref_devise, $montant, $type_transaction, $commission, $remuneration, $penalite, $code_transaction, $statut_transaction, $ref_dossier, $ref_id_source, $ref_operation, $code_operation, $solde_before, $numero_compte, $type_account) {
        include("param.php");
    
        $resultat = mysqli_query($bdd_i,"insert into t_transactions(ref_type_compte,ref_devise,montant,type_transaction,commission,remuneration,penalite,ref_user,creationdate,code_transaction,statut_transaction,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action,ref_zone_action,solde_before,ref_numero_compte,type_account) values('" . $ref_type_compte . "','" . $ref_devise . "'," . $montant . ",'" . $type_transaction . "'," . $commission . "," . $remuneration . "," . $penalite . ",'" . $_SESSION['my_username'] . "',now(),'" . $code_transaction . "','" . $statut_transaction . "','" . $ref_dossier . "'," . $ref_id_source . "," . $ref_operation . ",'" . $code_operation . "',''," . $_SESSION['my_agence'] . ",0," . $solde_before . ",'" . $numero_compte . "','" . $type_account . "')");
    //echo "insert into t_transactions(ref_type_compte,ref_devise,montant,type_transaction,commission,remuneration,penalite,ref_user,creationdate,code_transaction,statut_transaction,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action,ref_zone_action,solde_before,ref_numero_compte,type_account) values(".$ref_type_compte.",'".$ref_devise."',".$montant.",'".$type_transaction."',".$commission.",".$remuneration.",".$penalite.",'".$_SESSION['my_username']."',now(),'".$code_transaction."','".$statut_transaction."',".$ref_dossier.",".$ref_id_source.",".$ref_operation.",'".$code_operation."','".$_SESSION['mi_caisse_open']."',".$_SESSION['my_agence'].",".$_SESSION['mi_zone1'].",".$solde_before.",'".$numero_compte."','".$type_account."')";
    
        return $resultat;
    }
    
    function add_transaction_with_detail($ref_type_compte, $ref_devise, $montant, $type_transaction, $commission, $remuneration, $penalite, $code_transaction, $statut_transaction, $ref_dossier, $ref_id_source, $ref_operation, $code_operation, $solde_before, $numero_compte, $type_account, $sup_detail) {
        include("param.php");
    
        $resultat = mysqli_query($bdd_i,"insert into t_transactions(ref_type_compte,ref_devise,montant,type_transaction,commission,remuneration,penalite,ref_user,creationdate,code_transaction,statut_transaction,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action,ref_zone_action,solde_before,ref_numero_compte,type_account,sup_detail) values('" . $ref_type_compte . "','" . $ref_devise . "'," . $montant . ",'" . $type_transaction . "'," . $commission . "," . $remuneration . "," . $penalite . ",'" . $_SESSION['my_username'] . "',now(),'" . $code_transaction . "','" . $statut_transaction . "','" . $ref_dossier . "'," . $ref_id_source . "," . $ref_operation . ",'" . $code_operation . "',''," . $_SESSION['my_agence'] . ",0," . $solde_before . ",'" . $numero_compte . "','" . $type_account . "','" . addslashes($sup_detail) . "')");
    //echo "insert into t_transactions(ref_type_operation,ref_devise,montant,type_transaction,commission,remuneration,penalite,ref_user,creationdate,code_transaction,statut_transaction,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action,ref_zone_action,solde_before,ref_numero_compte,type_account,sup_detail) values('" . $ref_type_compte . "','" . $ref_devise . "'," . $montant . ",'" . $type_transaction . "'," . $commission . "," . $remuneration . "," . $penalite . ",'" . $_SESSION['my_username'] . "',now(),'" . $code_transaction . "','" . $statut_transaction . "'," . $ref_dossier . "," . $ref_id_source . "," . $ref_operation . ",'" . $code_operation . "',''," . $_SESSION['my_agence'] . ",0," . $solde_before . ",'" . $numero_compte . "','" . $type_account . "','" . addslashes($sup_detail) . "')";
    
        return $resultat;
    }
    
    function add_transaction_with_detail_date($ref_type_compte, $ref_devise, $montant, $type_transaction, $commission, $remuneration, $penalite, $code_transaction, $statut_transaction, $ref_dossier, $ref_id_source, $ref_operation, $code_operation, $solde_before, $numero_compte, $type_account, $sup_detail, $date) {
        include("param.php");
    
        $resultat = mysqli_query($bdd_i,"insert into t_transactions(ref_type_compte,ref_devise,montant,type_transaction,commission,remuneration,penalite,ref_user,creationdate,code_transaction,statut_transaction,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action,ref_zone_action,solde_before,ref_numero_compte,type_account,sup_detail) values('" . $ref_type_compte . "','" . $ref_devise . "'," . $montant . ",'" . $type_transaction . "'," . $commission . "," . $remuneration . "," . $penalite . ",'" . $_SESSION['my_username'] . "','" . $date . "','" . $code_transaction . "','" . $statut_transaction . "','" . $ref_dossier . "'," . $ref_id_source . "," . $ref_operation . ",'" . $code_operation . "',''," . $_SESSION['my_agence'] . ",0," . $solde_before . ",'" . $numero_compte . "','" . $type_account . "','" . addslashes($sup_detail) . "')");
    //echo "insert into t_transactions(ref_type_compte,ref_devise,montant,type_transaction,commission,remuneration,penalite,ref_user,creationdate,code_transaction,statut_transaction,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action,solde_before,ref_numero_compte,type_account,sup_detail) values(".$ref_type_compte.",'".$ref_devise."',".$montant.",'".$type_transaction."',".$commission.",".$remuneration.",".$penalite.",'".$_SESSION['my_username']."',now(),'".$code_transaction."','".$statut_transaction."',".$ref_dossier.",".$ref_id_source.",".$ref_operation.",'".$code_operation."','".$_SESSION['mi_caisse_open']."',".$_SESSION['my_agence'].",".$solde_before.",'".$numero_compte."','".$type_account."','".$sup_detail."')";
    
        return $resultat;
    }
    
    function add_transaction_with_date($ref_type_compte, $ref_devise, $montant, $type_transaction, $commission, $remuneration, $penalite, $code_transaction, $statut_transaction, $ref_dossier, $ref_id_source, $ref_operation, $code_operation, $solde_before, $numero_compte, $type_account, $date, $ref_agent) {
        include("param.php");
    
        $resultat = mysqli_query($bdd_i,"insert into t_transactions(ref_type_compte,ref_devise,montant,type_transaction,commission,remuneration,penalite,ref_user,ref_user_on_behalf,creationdate,code_transaction,statut_transaction,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action,ref_zone_action,solde_before,ref_numero_compte,type_account) values('" . $ref_type_compte . "','" . $ref_devise . "'," . $montant . ",'" . $type_transaction . "'," . $commission . "," . $remuneration . "," . $penalite . ",'" . $ref_agent . "','" . $_SESSION['my_username'] . "','" . $date . "','" . $code_transaction . "','" . $statut_transaction . "','" . $ref_dossier . "'," . $ref_id_source . "," . $ref_operation . ",'" . $code_operation . "',''," . $_SESSION['my_agence'] . ",0," . $solde_before . ",'" . $numero_compte . "','" . $type_account . "')");
    //echo "insert into t_transactions(ref_type_compte,ref_devise,montant,type_transaction,commission,remuneration,penalite,ref_user,creationdate,code_transaction,statut_transaction) values(".$ref_type_compte.",'".$ref_devise."',".$montant.",'".$type_transaction."',".$commission.",".$remuneration.",".$penalite.",'".$_SESSION['my_username']."',now(),'".$code_transaction."','".$statut_transaction."')";
    
        return $resultat;
    }
    
    function add_transaction_detail_without_date($ref_type_compte, $ref_devise, $montant, $type_transaction, $commission, $remuneration, $penalite, $code_transaction, $statut_transaction, $ref_dossier, $ref_id_source, $ref_operation, $code_operation, $solde_before, $numero_compte, $type_account, $ref_agent, $sup_detail) {
        include("param.php");
    
        $resultat = mysqli_query($bdd_i,"insert into t_transactions(ref_type_compte,ref_devise,montant,type_transaction,commission,remuneration,penalite,ref_user,ref_user_on_behalf,creationdate,code_transaction,statut_transaction,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action,ref_zone_action,solde_before,ref_numero_compte,type_account,sup_detail) values('" . $ref_type_compte . "','" . $ref_devise . "'," . $montant . ",'" . $type_transaction . "'," . $commission . "," . $remuneration . "," . $penalite . ",'" . $ref_agent . "','" . $_SESSION['my_username'] . "',now(),'" . $code_transaction . "','" . $statut_transaction . "','" . $ref_dossier . "'," . $ref_id_source . "," . $ref_operation . ",'" . $code_operation . "',''," . $_SESSION['my_agence'] . ",0," . $solde_before . ",'" . $numero_compte . "','" . $type_account . "','" . $sup_detail . "')");
    //echo "insert into t_transactions(ref_type_compte,ref_devise,montant,type_transaction,commission,remuneration,penalite,ref_user,ref_user_on_behalf,creationdate,code_transaction,statut_transaction,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action,ref_zone_action,solde_before,ref_numero_compte,type_account,sup_detail) values('" . $ref_type_compte . "','" . $ref_devise . "'," . $montant . ",'" . $type_transaction . "'," . $commission . "," . $remuneration . "," . $penalite . ",'" . $ref_agent . "','" . $_SESSION['my_username'] . "',now(),'" . $code_transaction . "','" . $statut_transaction . "'," . $ref_dossier . "," . $ref_id_source . "," . $ref_operation . ",'" . $code_operation . "',''," . $_SESSION['my_agence'] . ",0," . $solde_before . ",'" . $numero_compte . "','" . $type_account . "','" . $sup_detail . "')";
    
        return $resultat;
    }
     
function add_in_grand_journal($ref_compte, $ref_devise, $credit_action, $debit_action, $credit_parent, $debit_parent, $solde_parent, $ref_transaction, $source_action, $ref_dossier, $ref_id_source, $ref_operation, $code_operation) {
    include("param.php");

    $resultat = mysqli_query($bdd_i,"insert into t_grand_journal(ref_compte,ref_devise,credit_action,debit_action,credit_parent,debit_parent,solde_parent,ref_transaction,source_action,ref_user,creationdate,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action) values(" . $ref_compte . ",'" . $ref_devise . "'," . $credit_action . "," . $debit_action . "," . ($credit_parent) . "," . ($debit_parent) . "," . ($solde_parent) . ",'" . $ref_transaction . "','" . addslashes($source_action) . "','" . $_SESSION['my_username'] . "',now(),'" . $ref_dossier . "'," . $ref_id_source . "," . $ref_operation . ",'" . $code_operation . "',''," . $_SESSION['my_agence'] . ")");
    //echo "insert into t_grand_journal(ref_compte,ref_devise,credit_action,debit_action,credit_parent,debit_parent,solde_parent,ref_transaction,source_action,ref_user,creationdate,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action) values(" . $ref_compte . ",'" . $ref_devise . "'," . $credit_action . "," . $debit_action . "," . ($credit_parent+$credit_action) . "," . ($debit_parent+$debit_action) . "," . ($solde_parent+$credit_action-$debit_action) . ",'" . $ref_transaction . "','" . addslashes($source_action) . "','" . $_SESSION['my_username'] . "',now()," . $ref_dossier . "," . $ref_id_source . "," . $ref_operation . ",'" . $code_operation . "','" . $_SESSION['mi_caisse_open'] . "'," . $_SESSION['mi_agence'] . ")";

    return $resultat;
}

function add_in_grand_journal_date($ref_compte, $ref_devise, $credit_action, $debit_action, $credit_parent, $debit_parent, $solde_parent, $ref_transaction, $source_action, $ref_dossier, $ref_id_source, $ref_operation, $code_operation,$date_action) {
    include("param.php");

    $resultat = mysqli_query($bdd_i,"insert into t_grand_journal(ref_compte,ref_devise,credit_action,debit_action,credit_parent,debit_parent,solde_parent,ref_transaction,source_action,ref_user,creationdate,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action) values(" . $ref_compte . ",'" . $ref_devise . "'," . $credit_action . "," . $debit_action . "," . ($credit_parent) . "," . ($debit_parent) . "," . ($solde_parent) . ",'" . $ref_transaction . "','" . addslashes($source_action) . "','" . $_SESSION['my_username'] . "','".$date_action."','" . $ref_dossier . "'," . $ref_id_source . "," . $ref_operation . ",'" . $code_operation . "',''," . $_SESSION['my_agence'] . ")");
    //echo "insert into t_grand_journal(ref_compte,ref_devise,credit_action,debit_action,credit_parent,debit_parent,solde_parent,ref_transaction,source_action,ref_user,creationdate,ref_dossier,ref_id_source,ref_operation,code_operation,ref_caisse,ref_agence_action) values(" . $ref_compte . ",'" . $ref_devise . "'," . $credit_action . "," . $debit_action . "," . ($credit_parent+$credit_action) . "," . ($debit_parent+$debit_action) . "," . ($solde_parent+$credit_action-$debit_action) . ",'" . $ref_transaction . "','" . addslashes($source_action) . "','" . $_SESSION['my_username'] . "',now()," . $ref_dossier . "," . $ref_id_source . "," . $ref_operation . ",'" . $code_operation . "','" . $_SESSION['mi_caisse_open'] . "'," . $_SESSION['mi_agence'] . ")";

    return $resultat;
}

function add_statut($nom, $description,$mail){
	include("param.php");
	
		$sql_search="insert into t_statut_dossier(label,message_client,mail_client,creationdate,ref_user) values('".$nom."','".$description."','".$mail."',now(),'".$_SESSION['my_username']."')";
			$sql_query=$bdd->exec($sql_search);
	

return $sql_query;	
	
    }
    function add_procedure($nom, $description){
        include("param.php");
        
            $sql_search="insert into t_procedure(nom_procedure,description,creationdate,ref_user) values('".$nom."','".$description."',now(),'".$_SESSION['my_username']."')";
                $sql_query=$bdd->exec($sql_search);
               // echo $sql_search;
        
    
    return $sql_query;	
        
        }
    
        function add_tache($nom, $description,$ref_procedure){
            include("param.php");
            
                $sql_search="insert into t_tache(titre_tache,description,ref_procedure,creationdate,ref_user) values('".$nom."','".$description."','".$ref_procedure."',now(),'".$_SESSION['my_username']."')";
                    $sql_query=$bdd->exec($sql_search);
            
        
        return $sql_query;	
            
            }
?>