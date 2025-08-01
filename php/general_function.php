<?php

function repliquer_livre_compte_agence()
{
    include("param.php");
    $message_publish = "";
    $search_agency = mysqli_query($bdd_i,"select * from t_agence");
    $total = 0;
    while ($data_agence = mysqli_fetch_array($search_agency)) {

        //echo "select * from t_livre_compte where ref_agence<>".$data_agence['id_agence']." and account_no not in (select distinct account_no from t_livre_compte where ref_agence=".$data_agence['id_agence'].")";
        $mysql_livre_compte = mysqli_query($bdd_i,"select * from t_livre_compte where ref_agence<>" . $data_agence['id_agence'] . " and account_no not in (select distinct account_no from t_livre_compte where ref_agence=" . $data_agence['id_agence'] . ")");
        while ($data_compte = mysqli_fetch_array($mysql_livre_compte)) {


            $temp = add_livre_compte($data_compte['account_no'], $data_compte['label'], 'CDF', 0, 0, 0, 0, 0, 0, $data_compte['display_sub'], $data_agence['id_agence']);

            $total = $total + $temp;
        }

        $message_publish = $message_publish . "<br> Agence : " . $data_agence['label'] . " Copier : " . $total;
    }

    return $message_publish;
}


function make_entry_compta($ref_operation, $code_operation, $montant, $ref_devise, $code_transaction, $ref_dossier,$libelle,$ref_id_source)
{
    include("param.php");
    /*$value_to_be_return=array();
    $value_to_be_return[0]="no";
    $value_to_be_return[1]="no";
    $value_to_be_return[2]="no";
    $value_to_be_return[3]="no";*/
    $sql_ecriture = mysqli_query($bdd_i,"select * from t_ecriture where ref_operation=" . $ref_operation);
    $feedback_livre = 0;
    $ecriture_saved = 0;
    $ecriture_done = 0;
    $update_compte = 0;
    $update_compte_text = "";
    $error="no";
    $success="no";
    $error_message="";
    $success_message="";
    $message_feedback="";
    $feedback_update_livre=0;

    $update_solde = 0;
  
    $i = 0;

    while ($data_ecriture = mysqli_fetch_array($sql_ecriture)) {
        $i++;
        //	echo "Niveoooooooooooooooooooooooooooooooooo 2";

        $montant_final = ($ref_devise== 'CDF') ? $montant : $montant * $_SESSION['my_taux'];
        $montant_usd = ($ref_devise == 'USD') ? $montant : 0;

        $montant_cdf = ($ref_devise == 'CDF') ? $montant : 0;


        if ($data_ecriture['action'] == 'D') {
            $data_compte_parent = get_livre_compte_data($data_ecriture['ref_compte']);
            $feedback_livre = add_in_grand_journal($data_ecriture['ref_compte'], $ref_devise, 0, $montant, $data_compte_parent['credit_final'], $data_compte_parent['debit_final'], $data_compte_parent['solde_final'], $code_transaction, $libelle, $ref_dossier, $ref_id_source, $ref_operation, $code_operation);
            $feedback_update_livre = update_livre_compte_debit($data_ecriture['ref_compte'], $montant_final, $montant_usd, $montant_cdf);
            $ecriture_done = $ecriture_done + $feedback_livre;
            $update_compte = $update_compte + $feedback_update_livre;
            $update_compte_text = $update_compte_text . $data_ecriture['ref_compte'] . " -->> Debiter : " . $montant . " " . $ref_devise . " | ";
        }

        if ($data_ecriture['action'] == 'C') {
            $data_compte_parent = get_livre_compte_data($data_ecriture['ref_compte']);
            $feedback_livre = add_in_grand_journal($data_ecriture['ref_compte'], $ref_devise, $montant, 0, $data_compte_parent['credit_final'], $data_compte_parent['debit_final'], $data_compte_parent['solde_final'], $code_transaction, $libelle, $ref_dossier, $ref_id_source, $ref_operation, $code_operation);
            $feedback_update_livre = update_livre_compte_credit($data_ecriture['ref_compte'], $montant_final, $montant_usd, $montant_cdf);
            $ecriture_done = $ecriture_done + $feedback_livre;
            $update_compte = $update_compte + $feedback_update_livre;
            $update_compte_text = $update_compte_text . $data_ecriture['ref_compte'] . " -->> Crediter : " . $montant . " " . $ref_devise. " | ";
        }


        

        //*******************************Feedback to Send****************************** */


        if ($feedback_livre==$ecriture_done && $ecriture_done==$update_compte && $update_compte>=1) {

            $feedback_update_livre = update_livre_compte_solde($data_ecriture['ref_compte']);

        } else {

           // mysqli_query($bdd,"ROLLBACK");
            $feedback_update_livre =0;
        }
    }

    /*$value_to_be_return[0]=$error;
    $value_to_be_return[1]=$error_message;
    $value_to_be_return[2]=$success;
    $value_to_be_return[3]=$success_message;
    
    //var_dump($value_to_be_return);


   // return $value_to_be_return;*/
//echo $update_compte_text;

   return $feedback_update_livre;
}



?>