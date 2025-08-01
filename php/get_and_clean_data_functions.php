<?php

//*************************************************************************************************************************************************
$pattern_currency = 'pattern="(0\.((0[1-9]{1})|([1-9]{1}([0-9]{1})?)))|(([1-9]+[0-9]*)(\.([0-9]{1,4}))?)?"';
$pattern_currency_null_too = 'pattern="(0\.((0[1-9]{1})|([1-9]{1}([0-9]{1})?)))|(([0-9]+[0-9]*)(\.([0-9]{1,4}))?)?"';
$pattern_text = 'pattern="[A-Za-z0-9\s-,]+"';
$pattern_text_only = 'pattern="[A-Za-z0-9]+"';
$pattern_taux = 'pattern="[0-9.]{1,}"';
$pattern_text_large = 'pattern="[]+"';
$pattern_number = 'pattern="[0-9]{1,}"';
$pattern_phone = 'pattern="[0-9,]+"';
$pattern_phone_drc = 'pattern="08[012459][0-9]{7}|09[01789][0-9]{7}"';

function clean_in_integer($value) {
    $value = intval($value);

    return $value;
}

function clean_in_double($value) {
    $value = doubleval($value);

    return $value;
}

function clean_in_text($value) {
    $value = addslashes(($value));

    return $value;
}

//**********************Function*******************************************************************************************************************
//*************************************************************************************************************************************************
//********************GLOBAL FUNCTION*******************
//******************************************************
//*******************Authentification*******************
//******************************************************

function get_access($ref, $userprofile) {
    include("param.php");
    //echo "select count(*) as valide from t_profile_content where  ref_content=".$ref." and ref_profile=".$userprofile."<br>";
    $resultat = $bdd->query("select count(idpc) as valide from t_profile_content join t_content on t_content.idcontent=t_profile_content.ref_content where t_content.status='a' and ref_content=" . $ref . " and ref_profile=" . $userprofile);
    //echo ($ref==32) ? "select count(idpc) as valide from t_profile_content join t_content on t_content.idcontent=t_profile_content.ref_content where t_content.status='a' and ref_content=" . $ref . " and ref_profile=" . $userprofile : "";
    //$resultat=$bdd->query("select  count(*) as valide from t_profile_content where  ref_content=".$ref." and ref_profile=".$userprofile);
    //echo "select count(idpc) as valide from t_profile_content,t_content where t_content.idcontent=t_profile_content.ref_content and t_content.status='a' and ref_content=".$ref." and ref_profile=".$userprofile;
    $donnee = $resultat->fetch();
    //echo $ref." = ".$donnee['valide']."<br>";
    return $donnee['valide'];
}

function get_total_user() {
    include("param.php");

    $resultat = $bdd->query("select count(*) as total from t_user");
    $data = $resultat->fetch();

    return $data['total'];
}

function get_taux() {
    include("param.php");

    $resultat = $bdd->query("select valeur,id_taux from t_taux where statut='a'");
    $data = $resultat->fetch();

    return $data;
}

function get_idprofile($name_profile) {
    include("param.php");

    $resultat = $bdd->query("select idprofile from t_profile t where t.name='" . $name_profile . "'");
    $data = $resultat->fetch();

    return $data['idprofile'];
}


function get_profile_data($idprofile) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_profile t where idprofile=" . $idprofile." group by idprofile");
    $data = $resultat->fetch();

    return $data;
}
function get_procedure_data($idprocedure) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_procedure t where idt_procedure=" . $idprocedure." group by idt_procedure");
    $data = $resultat->fetch();

    return $data;
}
function get_tache_data($idtache) {
    include("param.php");

    //echo "select t.*, count(*) as is_exist from t_tache t where idt_tache=" . $idtache." group by idt_tache";
    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_tache t where idt_tache=" . $idtache." group by idt_tache");
    $data = $resultat->fetch();

    return $data;
}
function get_statut_data($idstatut) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_statut_dossier t where idt_statut_dossier=" . $idstatut." group by idt_statut_dossier");
    $data = $resultat->fetch();

    return $data;
}
function get_statut_data_by_name($statut_name) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_statut_dossier t where label='" . $statut_name."' group by idt_statut_dossier");
    $data = $resultat->fetch();

    return $data;
}
function get_content_data($id_content) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_content t where idcontent=" . $id_content." group by idcontent");
    $data = $resultat->fetch();

    return $data;
}

function get_ecriture_data($id_ecriture) {
    include("param.php");

    $resultat = $bdd->query("select t.*,label as operation, count(*) as is_exist from t_ecriture t join t_operation on idt_operation=ref_operation where idecriture=" . $id_ecriture." group by idecriture");
    $data = $resultat->fetch();

    return $data;
}

function get_user_data($iduser) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_user t where iduser=" . $iduser." group by iduser");
    $data = $resultat->fetch();

    return $data;
}

function get_user_data_by_username($username) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_user t where username='" . $username ."' group by username");
    $data = $resultat->fetch();

    return $data;
}



function get_agence_data($id_agence) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_agence t where id_agence=" . $id_agence . ""." group by id_agence");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}
function validEmail($email){
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
            return false;
        }
    }
    if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
            return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                return false;
            }
        }
    }

    return true;
}
function get_dossier_data_by_ndel($ndel) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_dossier t where ndel='" . $ndel . "' and deletion_statut=0"." group by ndel");
//echo "select t.*, count(*) as is_exist from t_dossier t where ndel='" . $ndel . "' and deletion_statut=0";
    $data = $resultat->fetch();

    return $data;
}

function get_parameter_value($titre) {
    include("param.php");

    $resultat = $bdd->query("select valeur from t_parametre where titre='" . $titre . "'"." group by titre");
    $data = $resultat->fetch();
//echo "select count(*) as total from t_compte_eac where ref_membre=".$idmembre;
    return $data['valeur'];
}

function get_dossier_data($idt_dossier){
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_dossier t where idt_dossier=" . $idt_dossier . " and deletion_statut=0"." group by idt_dossier");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}

function get_description_data($idt_procedure) {
    include("param.php");

    $resultat = $bdd->query("select * from t_procedure where idt_procedure=" . $idt_procedure . " LIMIT 0,1");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}

function get_anniv_data($ref_statut_dossier)
{
    include("param.php");

    $resultat = $bdd->query("SELECT t.* , t_dossier.identite AS client, t_dossier.date_naissance AS anniversaire from t_statu_dossier_profile t JOIN t_dossier ON idt_dossier=ref_statut_dossier WHERE ref_statut_dossier=".$ref_statut_dossier."  LIMIT 0,1");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}

function get_message_anniv_data()
{
    include("param.php");
    $resultat = $bdd->query("SELECT * FROM t_message_souhait WHERE statut= '1' ORDER BY Idt_message_souhait DESC LIMIT 0,1");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}

function get_manager_message()
{
    include("param.php");
    $resultat = $bdd->query("SELECT * FROM t_message_souhait ORDER BY Idt_message_souhait DESC LIMIT 0,1");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}


function get_param_souhait($titre_param)
{
    include("param.php");

    $resultat = $bdd->query("select * from t_parametre where titre ='".$titre_param."' ");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}

function get_param_restric_sms()
{
    include("param.php");
    $resultat = $bdd->query("SELECT * FROM t_parametre WHERE titre ='restrict_sms_send_souhait' ");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}

function get_param_restric_statut()
{
    include("param.php");
    $resultat = $bdd->query("SELECT * FROM t_parametre WHERE titre ='restrict_reception_statut_souhait' ");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}


function get_dossier_etude_data($idt_dossier_etude) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_dossier_etude t where idt_dossier_etude=" . $idt_dossier_etude . ""." group by idt_dossier_etude");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}
function get_document_data($idt_document) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_document_dossier t where idt_document_dossier=" . $idt_document . ""." group by idt_document_dossier");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}
function get_operation_data($idt_operation) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_operation t where idt_operation=" . $idt_operation . ""." group by idt_operation");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}

function get_broadcast_list($broad){
	include("param.php");
	$content="";
		$sql_query=$bdd->query("select idbroadcast from t_broadcast_list where name='".$broad."'");
		$donnee=$sql_query->fetch();

return $donnee['idbroadcast'];	
	
	}
        
function get_actions_data($idt_actions) {
    include("param.php");

    $resultat = $bdd->query("select t.*, count(*) as is_exist from t_actions t where idt_actions=" . $idt_actions . ""." group by idt_actions");
//echo "select t.*, count(*) as is_exist from t_agence t where id_agence=".$id_agence."";
    $data = $resultat->fetch();

    return $data;
}

function get_total_SMS(){
include("param.php");

$resultat=$bdd->query("select sum(nb_sms) as total from t_sms t  where mobile_number not like '%@%'");
$data=$resultat->fetch();

return $data['total'];

}

function get_total_user_profile($idprofile){
include("param.php");

$resultat=$bdd->query("select count(*) as total from t_user where ref_profile=".$idprofile." group by refprofile");
$data=$resultat->fetch();

return $data['total'];

}

function get_livre_compte_data2($account_no){
    include("param.php");
    
    $resultat=mysqli_query($bdd_i,"select t.*, count(*) as is_exist from t_livre_compte t where account_no='".$account_no."' and ref_agence=".$_SESSION['my_agence']." group by account_no");
    $data=mysqli_fetch_array($resultat);
    
    return $data;
    
    }

    function get_livre_compte_data($account_no){
        include("param.php");
        
        $resultat=mysqli_query($bdd_i,"select t.*, count(*) as is_exist from t_livre_compte t where account_no='".$account_no."' and ref_agence=".$_SESSION['my_agence']." group by account_no");
        $data=mysqli_fetch_array($resultat);
        
        return $data;
        
        }

        function do_operation_get_ecriture($ref_operation)
        {
            include("param.php");
            
            $resultat=mysqli_query($bdd_i,"select count(*) as is_exist from t_ecriture t where ref_operation=".$ref_operation." group by ref_operation");
            $data=mysqli_fetch_array($resultat);
            
            return $data['is_exist'];
            
        }

        function get_transaction_data($idtransaction)
        {
            include("param.php");
                
            $resultat=mysqli_query($bdd_i,"select t.*, count(*) as is_exist from t_transactions t  where idtransactions=".$idtransaction." group by idtransactions");
            $data=mysqli_fetch_array($resultat);
                
            return $data;
                
        }

         function get_grand_journal_data($idjournal)
        {
            include("param.php");
                
            $resultat=mysqli_query($bdd_i,"select t.*, count(*) as is_exist from t_transactions t  where idtransactions=".$idtransaction." group by idtransactions");
            $data=mysqli_fetch_array($resultat);
                
            return $data;
                
        }


        
        function get_transaction_data_code($code_transaction)
        {
            include("param.php");
                
            $resultat=mysqli_query($bdd_i,"select t.*, count(*) as is_exist from t_transactions t  where code_transaction='".$code_transaction."'"." group by code_transaction");
            //ECHO "select t.*, count(*) as is_exist from t_transactions t  where code_transaction='".$code_transaction."'";
            $data=mysqli_fetch_array($resultat);
                
            return $data;
                
        }

function get_total_next_operation()
{
    include("param.php");

    $resultat = mysqli_query($bdd_i, "select count(*) as total from t_operation t  where day_reference-DAYOFMONTH(now())>=0 and day_reference-DAYOFMONTH(now())<=7 and is_ponctual_payment=1" . " ");
    //ECHO "select t.*, count(*) as is_exist from t_transactions t  where code_transaction='".$code_transaction."'";
    $data = mysqli_fetch_array($resultat);

    return $data['total'];
}

function get_total_pending_po()
{
    include("param.php");

    $resultat = mysqli_query($bdd_i, 'select  count(*) as total from t_transactions t where datediff(now(),creationdate)>=1 and datediff(now(),creationdate)<20 and type_account="OP" and statut_transaction="Soumis"  order by creationdate desc');
    //ECHO "select t.*, count(*) as is_exist from t_transactions t  where code_transaction='".$code_transaction."'";
    $data = mysqli_fetch_array($resultat);

    return $data['total'];
}

function get_transaction_data_for_print($idtransaction)
{
    include("param.php");

    $resultat = mysqli_query($bdd_i, "select '1' as No,code_operation,montant, ref_devise from t_transactions t  where idtransactions=" . $idtransaction . " group by idtRansactions");
    // $data=mysqli_fetch_array($resultat);
    //echo "select '1' as No,code_operation,sup_detail, montant, ref_devise from t_transactions t  where idtransactions=".$idtransaction." group by idtansactions";

    return $resultat;
}
function get_sum_oe($statut, $devise, $ref_dossier)
{
    include("param.php");

    $resultat = mysqli_query($bdd_i, 'select  sum(montant) as total from t_transactions t where type_account="OE" and statut_transaction="' . $statut . '" and ref_devise="' . $devise . '" and ref_dossier="' . $ref_dossier . '"');
    //ECHO 'select  sum(montant) as total from t_transactions t where type_account="OE" and statut_transaction="'.$statut.'" and ref_devise="'.$devise.'" and ref_dossier='.$ref_dossier;
    $data = mysqli_fetch_array($resultat);

    return $data['total'];
}
function get_sum_op($statut, $devise, $ref_dossier)
{
    include("param.php");

    $resultat = mysqli_query($bdd_i, 'select  sum(montant) as total from t_transactions t where type_account="OP" and statut_transaction="' . $statut . '" and ref_devise="' . $devise . '" and ref_dossier="' . $ref_dossier . '"');
    //ECHO "select t.*, count(*) as is_exist from t_transactions t  where code_transaction='".$code_transaction."'";
    $data = mysqli_fetch_array($resultat);

    return $data['total'];
}
function get_banner_data($id) {
    include("param.php");
    $resultat = $bdd->query("select * from t_banners where id=" . $id." ");
    $data = $resultat->fetch();
    return $data;
}
function get_journal_data($id, $date_debut, $date_fin)
{
    include("param.php");
    $resultat = $bdd->query("SELECT t_journal_users.date, arriving_time, exit_time, more_details,t_journal_users.id as idJournal,
     t_journal_users.description as descriptionJournal,t_profile.name AS profile , t_user.firstname ,
      t_user.lastname , t_user.lastlogon, t_user.iduser FROM t_journal_users INNER JOIN t_profile 
      ON t_journal_users.profile_id = t_profile.idprofile INNER JOIN t_user ON t_journal_users.user_id = t_user.iduser
       WHERE t_journal_users.user_id =" . $id . " and t_journal_users.date between '" . $date_debut . "' and '" . $date_fin . "'");

    $data = $resultat->fetch();

    return $data;
}
function get_journal_comment_data($userId)
{
    include("param.php");
    $resultat = $bdd->query("SELECT comment , reaction, date_comment , comment_by  FROM t_journal_users WHERE t_journal_users.id =" . $userId . "");
    $data = $resultat->fetch();
    return $data;
}
function get_cron_journal_users($iduser, $dateNow)
{
    include("param.php");
    $resultat = $bdd->query("select date,user_id from t_journal_users where user_id = $iduser and date =  '$dateNow'");
    $data = $resultat->fetch();
    return $data;
}
function getMessageEmailData($code)
{
    include("param.php");
    $resultat = $bdd->query("SELECT txt_mail FROM t_email WHERE code=  '" . $code . "'");
    $content = $resultat->fetch();
    return $content;
}


?>