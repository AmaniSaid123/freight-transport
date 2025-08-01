<?php

//*************************************************************************************************************************************************
//**********************Function*******************************************************************************************************************
//*************************************************************************************************************************************************
//********************GLOBAL FUNCTION*******************
//******************************************************
//*******************Authentification*******************
//******************************************************
function update_user_lastlogon($username) {
    include("param.php");

    $resultat = $bdd->exec("update t_user set lastlogon=now() where username='" . $username . "'");

    return $resultat;
}

function reset_password($username) {
    include("param.php");
//echo "select count(*) as total from t_student where ref_promotion=".$ref_promotion;
    $new_password = $username . date('i');
    $resultat = $bdd->exec("update t_user set password='" . $new_password . "' where username='" . $username . "'");


    return $new_password;
}

function set_off_taux() {
    include("param.php");

    $resultat = $bdd->exec("update t_taux set statut='b' where 1");


    return $resultat;
}

function del_ecriture_auto($idecriture) {
    include("param.php");

    $resultat = $bdd->exec("delete from t_ecriture where idecriture=" . $idecriture);

    return $resultat;
}

function update_profile($name, $description, $idprofile) {
    include("php/param.php");

    $sql_search = "update t_profile set name='" . $name . "', description='" . addslashes($description) . "', lastupdate=now() where idprofile=" . $idprofile;
    $sql_query = $bdd->exec($sql_search);
    //echo $sql_search;

    return $sql_query;
}

function update_statut($name, $description,$mail, $idstatut) {
    include("php/param.php");

    $sql_search = "update t_statut_dossier set label='" . $name . "', message_client='" . $description . "', mail_client='" . $mail . "' where idt_statut_dossier=" . $idstatut;
    $sql_query = $bdd->exec($sql_search);
    //echo $sql_search;

    return $sql_query;
}

function update_description($description, $idt_desc)
{
    include("php/param.php");

    $sql_search = "update t_procedure set description='" . $description . "' where idt_procedure=" . $idt_desc;
    $sql_query = $bdd->exec($sql_search);
    //echo $sql_search;

    return $sql_query;
}

function update_message_souhait($idt_write, $sujet, $text_sms, $text_mail, $statut)
{
    include("php/param.php");

    $sql_search = "update t_message_souhait set txt_sms='".$text_sms."', txt_mail='".$text_mail."', sujet ='".$sujet."', statut='".$statut."' where Idt_message_souhait=".$idt_write;
    $sql_query = $bdd->exec($sql_search);
    //echo $sql_search;

    return $sql_query;
}

function update_parametre_souhait($identifiant, $valeur)
{
    include("php/param.php");

    $sql_search = "update t_parametre set valeur='".$valeur."' where idt_parametre=".$identifiant;
    $sql_query = $bdd->exec($sql_search);
    //echo $sql_search;

    return $sql_query;
}

function update_auth_mail($mail_auth_action, $check_up_id)
{
    include("php/param.php");

    $sql_search = "update t_statu_dossier_profile set statut_mail_authentification='".$mail_auth_action."' where idt_statu_dossier_profile=".$check_up_id;
    $sql_query = $bdd->exec($sql_search);
    //echo $sql_search;

    return $sql_query;
}

function update_section_identite_client($idt_dossier,$identite,$nid,$date_naissance,$telephone,$email,$lieu_naissance,$nbre_enfant_famille,$position_dans_famille,$numero_passport,$date_expiration_pp,$ref_agence,$promoteur_agence,$pin_secret,$commentaire_client,$identite_pere,$lieu_naissance_pere,$datenaissance_pere,$identite_mere,$lieu_naissance_mere,$datenaissance_mere,$sexe,$adresse,$ville_pays) {
    include("php/param.php");

    $sql_search = "update t_dossier set identite='".$identite."', date_naissance='".$date_naissance."',numero_telephone='".$telephone."',email='".$email."',lieu_naissance='".$lieu_naissance."',nbre_enfant_famille='".$nbre_enfant_famille."',position_dans_famille='".$position_dans_famille."',"
            . "numero_passport='".$numero_passport."',date_expiration_pp='".$date_expiration_pp."',ref_agence='".$ref_agence."',promoteur_agence='".$promoteur_agence."',pin_secret='".$pin_secret."', commentaire_client='".$commentaire_client."' , identite_pere='".$identite_pere."' , lieu_naissance_pere='".$lieu_naissance_pere."' , date_naissance_pere='".$datenaissance_pere."', identite_mere='".$identite_mere."' , lieu_naissance_mere='".$lieu_naissance_mere."' , date_naissance_mere='".$datenaissance_mere."', sexe='".$sexe."', adresse='".$adresse."', ville_pays='".$ville_pays."'   where idt_dossier=" . $idt_dossier;
    $sql_query = $bdd->exec($sql_search);
    //echo $sql_search;

    return $sql_query;
}

function update_dossier_etude_exetat($idt_dossier_exetat,$annee, $institution, $formation, $niveau, $resultat, $diplome_obtenu, $ville_obtention, $pays_obtention) {
    include("php/param.php");

    $sql_search = "update t_dossier_etude set annee='".$annee."',institution='".$institution."',formation='".$formation."',niveau='".$niveau."',resultat='".$resultat."',diplome_obtenu='".$diplome_obtenu."',ville_obtention='".$ville_obtention."',"
            . "pays_obtention='".$pays_obtention."'   where idt_dossier_etude=" . $idt_dossier_exetat;
    $sql_query = $bdd->exec($sql_search);
    //echo $sql_search;

    return $sql_query;
}

function set_dossier_etude_view($idt_dossier_exetat,$value) {
    include("php/param.php");

    $sql_search = "update t_dossier_etude set view_doc=".$value."  where idt_dossier_etude=" . $idt_dossier_exetat;
    $sql_query = $bdd->exec($sql_search);
    //echo $sql_search;

    return $sql_query;
}
function set_dossier_document_view($idt_doc,$value) {
    include("php/param.php");

    $sql_search = "update t_document_dossier set view_doc=".$value."  where idt_document_dossier=" . $idt_doc;
    $sql_query = $bdd->exec($sql_search);
    //echo $sql_search;

    return $sql_query;
}
function update_details_emploi_passer($idt_dossier,$valeur) {
    include("php/param.php");

    $sql_search = "update t_dossier set activite_passe_actuelle='".$valeur."'  where idt_dossier=" . $idt_dossier;
    $sql_query = $bdd->exec($sql_search);
    //echo $sql_search;

    return $sql_query;
}

function update_details_zone_voyage($idt_dossier,$vo_destination,$vo_raison_voyage,$vo_charge_etude_parrain,$vo_ancien_visa,$vo_ancien_visa_comment,$vo_refus_visa_chk,$commentaire_refus_visa,$vo_destination_famille_chk,$vo_destination_comment,$domaine_preference)
 {
    include("php/param.php");

    $sql_search = "update t_dossier set vo_destination='".$vo_destination."',vo_raison_voyage='".$vo_raison_voyage."',vo_charge_etude_parrain='".$vo_charge_etude_parrain."',vo_ancien_visa='".$vo_ancien_visa."',vo_ancien_visa_comment='".$vo_ancien_visa_comment."',vo_refus_visa='".$vo_refus_visa_chk."',vo_refus_visa_comment='".$commentaire_refus_visa."', vo_destination_famille='".$vo_destination_famille_chk."' ,vo_destination_comment='".$vo_destination_comment."', domaine_preference='".$domaine_preference."'  where idt_dossier=" . $idt_dossier;
    $sql_query = $bdd->exec($sql_search);
    //echo $sql_search;

    return $sql_query;
}
function update_details_zone_charge($idt_dossier,$pc_qualite_garant,$pc_lieu_travail_garant,$pc_salaire_parrain,$pc_activite_pro_chk,$pc_activite_pro_nom,$pc_revenu_parrain,$pc_nbre_parcelle,$pc_nbre_vehicule)
 {
    include("php/param.php");

    $sql_search = "update t_dossier set pc_qualite_garant='".$pc_qualite_garant."',pc_lieu_travail_garant='".$pc_lieu_travail_garant."',pc_salaire_parrain='".$pc_salaire_parrain."',pc_activite_pro='".$pc_activite_pro_chk."',pc_activite_pro_nom='".$pc_activite_pro_nom."',pc_revenu_parrain='".$pc_revenu_parrain."', pc_nbre_parcelle='".$pc_nbre_parcelle."' ,pc_nbre_vehicule='".$pc_nbre_vehicule."'   where idt_dossier=" . $idt_dossier;
    $sql_query = $bdd->exec($sql_search);
   //echo $sql_search;

    return $sql_query;
}       

function update_allow_edition($idt_dossier,$value)
 {
    include("php/param.php");

    $sql_search = "update t_dossier set allow_edit_for_client=".$value."  where idt_dossier=" . $idt_dossier;
    $sql_query = $bdd->exec($sql_search);
   //echo $sql_search;

    return $sql_query;
}  

function update_statut_dossier($idt_dossier,$value)
 {
    include("php/param.php");

    $sql_search = "update t_dossier set statut_dossier='".$value."'  where idt_dossier=" . $idt_dossier;
    $sql_query = $bdd->exec($sql_search);
   //echo $sql_search;

    return $sql_query;
}  

function delete_dossier($idt_dossier, $action_click)
 {
    include("php/param.php");

    $sql_search = "update t_dossier set deletion_statut='".$action_click."', date_delettion=now(), ref_user_deletion='".$_SESSION['my_username']."'  where idt_dossier=" . $idt_dossier;
    $sql_query = $bdd->exec($sql_search);
   //echo $sql_search;

    return $sql_query;
} 
        
function set_compte_display_value($account_no,$value){
    include("param.php");
    
    $resultat=mysqli_query($bdd_i,"update t_livre_compte set display_sub='".$value."' where account_no='".$account_no."' and ref_agence=".$_SESSION['my_agence']);
    
    //echo "update t_caisse_activite set statut='s' where code_activite_caisse='".$code_caisse_activite."'";
    
    return $resultat;
    
    }
    function set_compte_display_value_dg($account_no,$value){
        include("param.php");
        
        $resultat=mysqli_query($bdd_i,"update t_livre_compte set display_sub='".$value."' where account_no='".$account_no."' ");
        
        //echo "update t_caisse_activite set statut='s' where code_activite_caisse='".$code_caisse_activite."'";
        
        return $resultat;
        
        }

    function update_livre_compte($account_no,$label,$credit_final,$debit_final,$credit_cdf,$debit_cdf,$credit_usd,$debit_usd){
        include("param.php");
        
        $resultat=mysqli_query($bdd_i,"update t_livre_compte set label='".$label."',credit_final=".$credit_final.", debit_final=".$debit_final.",solde_final=".($debit_final-$credit_final).", credit_cdf=".$credit_cdf.", debit_cdf=".$debit_cdf.",solde_cdf=".($debit_cdf-$credit_cdf).",credit_usd=".$credit_usd.", debit_usd=".$debit_usd.",solde_usd=".($debit_usd-$credit_usd)." where account_no='".$account_no."'and ref_agence=".$_SESSION['my_agence']);
        
        //echo "update t_caisse_activite set statut='s' where code_activite_caisse='".$code_caisse_activite."'";
        
        return $resultat;
        
        }
        
function update_livre_compte_debit($account_no,$debit_final,$debit_usd,$debit_cdf){
    include("param.php");
    
    $resultat=mysqli_query($bdd_i,"update t_livre_compte set debit_final=debit_final+".$debit_final.", debit_usd=debit_usd+".$debit_usd.", debit_cdf=debit_cdf+".$debit_cdf."  where account_no=".$account_no." and ref_agence=".$_SESSION['my_agence']);
    
    //echo "update t_adresse set ref_commune".$ref_commune.", quartier='".$quartier."', avenue='".$avenue."', numero_avenue=".$numero.", reference='".$reference."' where idadresse=".$idadresse;
    
    return $resultat;
    
    }
    function update_livre_compte_debit_soustraction($account_no,$debit_final,$debit_usd,$debit_cdf){
    include("param.php");
    
    $resultat=mysqli_query($bdd_i,"update t_livre_compte set debit_final=".$debit_final."-debit_final, debit_usd=".$debit_usd."-debit_usd, debit_cdf=".$debit_cdf."-debit_cdf  where account_no=".$account_no." and ref_agence=".$_SESSION['my_agence']);
    
    //echo "update t_adresse set ref_commune".$ref_commune.", quartier='".$quartier."', avenue='".$avenue."', numero_avenue=".$numero.", reference='".$reference."' where idadresse=".$idadresse;
    
    return $resultat;
    
    }
    function update_livre_compte_solde($account_no){
    include("param.php");
    
    $resultat=mysqli_query($bdd_i,"update t_livre_compte set solde_final=debit_final-credit_final, solde_usd=debit_usd-credit_usd, solde_cdf=debit_cdf-credit_cdf  where account_no=".$account_no." and ref_agence=".$_SESSION['my_agence']);
    
    //echo "update t_adresse set ref_commune".$ref_commune.", quartier='".$quartier."', avenue='".$avenue."', numero_avenue=".$numero.", reference='".$reference."' where idadresse=".$idadresse;
    
    return $resultat;
    
    }
    
function update_livre_compte_credit($account_no,$credit_final,$credit_usd,$credit_cdf){
    include("param.php");
    
    $resultat=mysqli_query($bdd_i,"update t_livre_compte set credit_final=credit_final+".$credit_final.", credit_usd=credit_usd+".$credit_usd.", credit_cdf=credit_cdf+".$credit_cdf."  where account_no=".$account_no." and ref_agence=".$_SESSION['my_agence']);
    
    //echo "update t_adresse set ref_commune".$ref_commune.", quartier='".$quartier."', avenue='".$avenue."', numero_avenue=".$numero.", reference='".$reference."' where idadresse=".$idadresse;
    
    return $resultat;
    
    }
    function update_livre_compte_credit_soustraction($account_no,$credit_final,$credit_usd,$credit_cdf){
    include("param.php");
    
    $resultat=mysqli_query($bdd_i,"update t_livre_compte set credit_final=".$credit_final."-credit_final, credit_usd=".$credit_usd."-credit_usd, credit_cdf=".$credit_cdf."-credit_cdf  where account_no=".$account_no." and ref_agence=".$_SESSION['my_agence']);
    
    //echo "update t_adresse set ref_commune".$ref_commune.", quartier='".$quartier."', avenue='".$avenue."', numero_avenue=".$numero.", reference='".$reference."' where idadresse=".$idadresse;
    
    return $resultat;
    
    }

    function set_transaction_statut_validation($idt_transaction,$action){
        include("param.php");
        
        $resultat=mysqli_query($bdd_i,"update t_transactions set statut_transaction='".$action."', validation_date=now(), validated_by='".$_SESSION['my_username']."' where idtransactions=".$idt_transaction);
        
        //echo "update t_adresse set ref_commune".$ref_commune.", quartier='".$quartier."', avenue='".$avenue."', numero_avenue=".$numero.", reference='".$reference."' where idadresse=".$idadresse;
        
        return $resultat;
        
        }
        function set_transaction_statut_decaisser($idt_transaction,$action){
            include("param.php");
            
            $resultat=mysqli_query($bdd_i,"update t_transactions set statut_transaction='".$action."', decaissement_date=now(), decaissement_by='".$_SESSION['my_username']."' where idtransactions=".$idt_transaction);
            
            //echo "update t_adresse set ref_commune".$ref_commune.", quartier='".$quartier."', avenue='".$avenue."', numero_avenue=".$numero.", reference='".$reference."' where idadresse=".$idadresse;
            
            return $resultat;
            
            }
            function set_dossier_limit($idt_dossier,$valeur){
                include("param.php");
                
                $resultat=mysqli_query($bdd_i,"update t_dossier set limit_encaissement=".$valeur."  where idt_dossier=".$idt_dossier."");
                
                //echo "update t_adresse set ref_commune".$ref_commune.", quartier='".$quartier."', avenue='".$avenue."', numero_avenue=".$numero.", reference='".$reference."' where idadresse=".$idadresse;
                
                return $resultat;
                
                }
                function change_tache_visibilite($idt_tache,$valeur){
                    include("param.php");
                    
                    $resultat=mysqli_query($bdd_i,"update t_tache set is_visible=".$valeur."  where idt_tache=".$idt_tache."");
                   
                    return $resultat;
                    
                    }
                    function set_procedure_dossier($idt_dossier,$ref_procedure){
                        include("param.php");
                        
                        $resultat=mysqli_query($bdd_i,"update t_dossier set ref_procedure=".$ref_procedure."  where idt_dossier=".$idt_dossier."");
                       
                        return $resultat;
                        
                        }
        ?>