<?php
//******************IDPAGE*****************
$idpage = 31;
//Session check****************************
include_once("php/session_check.php");
include_once("php/function.php");
//********************locally Additionnal Function*************
//*********************Get Profile Data*****
$set_pluggin_datatable = "yes";
$set_pluggin_selection_wise = "yes";
$set_plugin_daterange = "yes";
//***********************Find Profile****************
//*************************Selection des informations du profile************************

$get_active_menu = "comptabilite";
$page_titre = "Comptabilité - Livre Journal";
$page_small_detail = "Livre Journal";
$page_location = "Comptabilité > Livre Journal";

$resultat = $bdd->query("select solde_usd from t_livre_compte where account_no = 57 and ref_agence=" . $_SESSION['my_agence'] . " ");
$dataSolde = $resultat->fetch();
if (isset($dataSolde) && $dataSolde['solde_usd']) {
    $solde_final = $dataSolde['solde_usd'];
}
$resultat2 = $bdd->query("select price from t_banners where compte = 57 and agence=" . $_SESSION['my_agence'] . " ");
$dataPrice = $resultat2->fetch();
if (isset($dataPrice) && $dataPrice['price']) {
    $price = $dataPrice['price'];
}


//****************location******************

if (isset($_POST['submit_add_operation']) && $_POST['label'] != "") {



    $feedback_add_account = add_operation_finance(clean_in_text($_POST['label']), $_POST['ref_type_operation'], $_POST['is_ponctual_payment'], $_POST['day_payment']);
    if ($feedback_add_account == 1) {
        $success = "yes";
        $success_message = "L'opération financière " . $_POST['label'] . " a été ajouter avec succes ";
    } else {
        $error = "yes";
        $error_message = "Une erreur a survenue lors de l'ajout de l'operation financière";
    }
}

if (isset($_POST['submit_add_capture']) && clean_in_text($_POST['libelle']) != "") {

    $libelle = clean_in_text($_POST['libelle']);
    $sql_query_capture = mysqli_query($bdd_i, "select * from t_livre_compte where ref_agence=" . $_SESSION['my_agence'] . " ");
    $row = 0;

    while ($result = mysqli_fetch_array($sql_query_capture)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if (1) {
            $row++;
            add_livre_compte_capture($result['account_no'], $result['label'], $result['ref_devise'], $result['credit_final'], $result['debit_final'], $result['credit_cdf'], $result['debit_cdf'], $result['credit_usd'], $result['debit_usd'], $result['display_sub'], $result['ref_agence'], $libelle);
        }
    }

    if ($row > 0) {

        $success = "yes";
        $success_message = "Capture " . $libelle . " Créée avec succès, Total Compte = " . $row;
    } else {

        $error = "yes";
        $error_message = "Une erreur a survenue lors de la capture du bilan par agence";
    }
}

if (isset($_POST['submit_add_capture_general']) && clean_in_text($_POST['libelle']) != "") {

    $libelle = clean_in_text($_POST['libelle']);
    $sql_query_capture = mysqli_query($bdd_i, "select * from t_livre_compte ");
    $row = 0;

    while ($result = mysqli_fetch_array($sql_query_capture)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if (1) {
            $row++;
            add_livre_compte_capture($result['account_no'], $result['label'], $result['ref_devise'], $result['credit_final'], $result['debit_final'], $result['credit_cdf'], $result['debit_cdf'], $result['credit_usd'], $result['debit_usd'], $result['display_sub'], $result['ref_agence'], $libelle);
        }
    }

    if ($row > 0) {

        $success = "yes";
        $success_message = "Capture pour toutes les agences : " . $libelle . " Créée avec succès, Total Compte = " . $row;
    } else {

        $error = "yes";
        $error_message = "Une erreur a survenue lors de la capture du bilan par agence";
    }
}

if (isset($_GET['action_click']) && $_GET['action_click'] == "set_extend" && isset($_GET['find'])) {

    $feedback_action = set_compte_display_value(clean_in_text($_GET['find']), "Yes");
    if ($feedback_action == 1) {
        $success = "yes";
        $success_message = "Le vision multi dévise a été activer pour ce compte avec succès";
    } else {
        $error = "yes";
        $error_message = "Une erreur a survenue lors de l'activation de la vue multi-devise";
    }
}

if (isset($_GET['action_click']) && $_GET['action_click'] == "set_hidden" && isset($_GET['find'])) {

    $feedback_action = set_compte_display_value(clean_in_text($_GET['find']), "No");
    if ($feedback_action == 1) {
        $success = "yes";
        $success_message = "Le vision multi dévise a été désactiver pour ce compte avec succès";
    } else {
        $error = "yes";
        $error_message = "Une erreur a survenue lors de la désactivation de la vue multi-devise";
    }
}

if (isset($_POST['submit_add_compte']) && $_POST['label'] != "") {

    $display_sub = (isset($_POST['display_sub'])) ? "Yes" : "No";

    $feedback_add_account = add_livre_compte(clean_in_text($_POST['account_no']), clean_in_text($_POST['label']), clean_in_text($_POST['devise']), clean_in_double($_POST['credit_final']), clean_in_double($_POST['debit_final']), clean_in_double($_POST['credit_cdf']), clean_in_double($_POST['debit_cdf']), clean_in_double($_POST['credit_usd']), clean_in_double($_POST['debit_usd']), $display_sub, $_SESSION['my_agence']);
    if ($feedback_add_account == 1) {
        add_notification("t_user", "NA", "Connexion ", "Compte  " . clean_in_text($_POST['account_no']) . " | Label : " . clean_in_text($_POST['label']) . " | CF : " . clean_in_double($_POST['credit_final']) . " | DF : " . clean_in_double($_POST['debit_final']) . " | C CDF :" . clean_in_double($_POST['credit_cdf']) . " | D CDF :" . clean_in_double($_POST['debit_cdf']) . " | C USD :" . clean_in_double($_POST['credit_usd']) . " | D USD :" . clean_in_double($_POST['debit_usd']) . " | Agence : " . $_SESSION['my_agence'], $_SESSION['my_username'], "Ajout Compte dans Livre");

        $replication = repliquer_livre_compte_agence();
        $success = "yes";
        $success_message = "Le compte a été ajouter avec succes <br>Replication sur Autre agence : <br>" . $replication;
    } else {
        $error = "yes";
        $error_message = "Une erreur a survenue lors de l'ajout du compte ";
    }
}

if (isset($_POST['submit_update_compte'])) {

    $data_compte_before = get_livre_compte_data2(clean_in_text($_POST['account_no']));
    $feedback_update_account = update_livre_compte(clean_in_text($_POST['account_no']), clean_in_text($_POST['label_compte']), clean_in_double($_POST['credit_final']), clean_in_double($_POST['debit_final']), clean_in_double($_POST['credit_cdf']), clean_in_double($_POST['debit_cdf']), clean_in_double($_POST['credit_usd']), clean_in_double($_POST['debit_usd']));
    $data_compte_after = get_livre_compte_data2(clean_in_text($_POST['account_no']));
    if ($feedback_update_account == 1) {
        $commentaire_edit = " COMPTE : " . $_POST['account_no'] . " , Agence : " . $_SESSION['my_agence'] . " || Solde Final Avant CDF : " . $data_compte_before['solde_final'] . " --> " . $data_compte_after['solde_final'] . " | 
        " . ",Solde Avant CDF : " . $data_compte_before['solde_cdf'] . " --> " . $data_compte_after['solde_cdf'] . " | " .
            ",Credit Avant CDF : " . $data_compte_before['credit_cdf'] . " --> " . $data_compte_after['credit_cdf'] .
            ",Debit Avant CDF : " . $data_compte_before['debit_cdf'] . " --> " . $data_compte_after['debit_cdf'] .
            ",Solde Avant USD : " . $data_compte_before['solde_usd'] . " --> " . $data_compte_after['solde_usd'] .
            ",Credit Avant USD : " . $data_compte_before['credit_usd'] . " --> " . $data_compte_after['credit_usd'] .
            ",Debit Avant USD : " . $data_compte_before['credit_usd'] . " --> " . $data_compte_after['credit_usd'];
        add_notification("t_livre_compte", "NA", $commentaire_edit, $commentaire_edit, $_SESSION['my_username'], "Edition Compte dans Livre");

        $success = "yes";
        $success_message = "Le compte a été mise a jour avec succes";
    } else {
        $error = "yes";
        $error_message = "Une erreur a survenue lors de la mise a jour du compte " . $feedback_update_account;
    }
}

$valeur_solde = '';
$compte = '';
$param = '';
if (isset($_POST['submit_search'])) {

    $valeur_solde = $_POST['valeur_solde'];
    $compte = $_POST['compte'];
    $param = ($valeur_solde == '0') ? $param . '  ' : $param . ' and solde_final<>0 ';
    $param = ($compte == '') ? $param . '' : $param . " and account_no like '" . clean_in_integer($compte) . "%'";
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
        <?php
        include_once("php/titre_location.php");
        ?>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php include_once("php/print_message.php"); ?>

        <?php if (get_access(63, $_SESSION['my_idprofile']) == 1) { ?>
            <?php
            if ((isset($solde_final) && isset($price)) && ((int)$solde_final >= (int)$price)) {
            ?>
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4> <i class="icon fas fa-exclamation"></i>
                        Attention ! Le solde actuel de la caisse dépasse le montant recommandé. Veuillez faire les OP prévus, ensuite le dépôt à la banque le plus tôt possible.
                    </h4>
                </div>
            <?php
            }
            ?>

        <?php } ?>


        <!-- Your Page Content Here -->
        <!-- Horizontal Form -->
        <div id="light" class="white_content">
            <?php
            //*******************************Modification creation compte epargne EAC ****************************
            if (isset($_GET['compte']) && isset($_GET['action']) && $_GET['action'] == "add_operation") {

            ?>
                <a onClick="hide_pop()"><i class="fa  fa-close">Fermer Ici</i></a>
                <form class="form-horizontal" action="livre_compte.php" method="post">
                    <p align="center">
                    <h4>Création Opération Financière</h4>
                    </p>
                    <div class="box-body">



                        <div class="form-group">
                            <label class="col-sm-4 control-label">Intitulé de l'opération</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="label" placeholder="Entrez l'intitulé de l'opération" <?php echo $pattern_text; ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Type d'operation</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="ref_type_operation">
                                    <?php echo getcombo_type_operation(''); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Operation Récurrente</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="is_ponctual_payment">
                                    <option value="0">Non</option>
                                    <option value="1">Oui</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Operation Récurrente</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="day_payment">
                                    <?php for ($i = 1; $i <= 25; $i++) {
                                        echo '<option value="' . $i . '">Chaque ' . $i . ' du mois</option>';
                                    }
                                    ?>



                                </select>
                            </div>
                        </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                        <button type="submit" class="btn btn-info pull-right" name="submit_add_operation">Valider</button>
                    </div><!-- /.box-footer -->
                </form>


            <?php

            }
            ?>
            <?php
            //*******************************Modification creation compte epargne EAC ****************************
            if (isset($_GET['compte']) && isset($_GET['action']) && $_GET['action'] == "add_compte") {
            ?>
                <a onClick="hide_pop()"><i class="fa  fa-close">Fermer Ici</i></a>
                <form onsubmit="ShowLoading()" class="form-horizontal" action="livre_compte.php" method="post">
                    <p align="center">
                    <h4>Création d'un Compte</h4>
                    </p>
                    <div class="box-body">


                        <div class="form-group">
                            <label class="col-sm-4 control-label">Numero de compte</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" value="" name="account_no" placeholder="Entrez le numero de compte" <?php echo $pattern_number; ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Intitulé du compte</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="label" placeholder="Entrez l'intitulé du compte" <?php echo $pattern_text; ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Dévise</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="CDF" name="devise" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Credit Balancé en CDF</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="credit_final" placeholder="Qu'avez vous comme crédit principal" <?php echo $pattern_currency_null_too; ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Debit Balancé en CDF</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="debit_final" placeholder="Qu'avez vous comme débit principal" <?php echo $pattern_currency_null_too; ?>>
                            </div>
                        </div>
                        ***************************************Uniquement en CDF*****************************
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Crédit en CDF</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="credit_cdf" placeholder="Qu'avez vous comme crédit en CDF" <?php echo $pattern_currency_null_too; ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">debit en CDF</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="debit_cdf" placeholder="Qu'avez vous comme débit en CDF" <?php echo $pattern_currency_null_too; ?>>
                            </div>
                        </div>
                        **************************************Uniquement en USD*******************************
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Crédit en USD</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="credit_usd" placeholder="Qu'avez vous comme crédit en USD" <?php echo $pattern_currency_null_too; ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Debit en USD</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="debit_usd" placeholder="Qu'avez vous comme débit en USD" <?php echo $pattern_currency_null_too; ?>>
                            </div>
                        </div>
                        **************************************Information multi dévises*******************************
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cochez pour l'affichage multi Devise</label>
                            <div class="col-sm-6">
                                <input name="display_sub" type="checkbox" value="on">
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                        <button type="submit" class="btn btn-info pull-right" name="submit_add_compte">Valider</button>
                    </div><!-- /.box-footer -->
                </form>


            <?php
            }
            ?>
            <?php
            //*******************************Modification creation compte epargne EAC ****************************
            if (isset($_GET['compte']) && isset($_GET['action']) && $_GET['action'] == "update_compte") {
                $data_livre_compte = get_livre_compte_data(clean_in_text($_GET['compte']));

                if ($data_livre_compte['is_exist'] == 1) {
            ?>
                    <a onClick="hide_pop()"><i class="fa  fa-close">Fermer Ici</i></a>
                    <form onsubmit="ShowLoading()" class="form-horizontal" action="livre_compte.php" method="post">
                        <p align="center">
                        <h4>Mise a jour Compte : <?php echo $data_livre_compte['account_no'] . " - " . $data_livre_compte['label']; ?></h4>
                        </p>
                        <div class="box-body">


                            <div class="form-group">
                                <label class="col-sm-4 control-label">Numero de compte</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['account_no']; ?>" name="account_no" placeholder="Entrez le numero de compte" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Intitulé du compte</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['label']; ?>" name="label_compte" placeholder="Entrez l'intitulé du compte" <?php echo $pattern_text; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Dévise</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="CDF" name="devise" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Credit Balancé en CDF</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['credit_final']; ?>" name="credit_final" placeholder="Qu'avez vous comme crédit principal" <?php echo $pattern_currency_null_too; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Debit Balancé en CDF</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['debit_final']; ?>" name="debit_final" placeholder="Qu'avez vous comme débit principal" <?php echo $pattern_currency_null_too; ?>>
                                </div>
                            </div>
                            ***************************************Uniquement en CDF*****************************
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Crédit en CDF</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['credit_cdf']; ?>" name="credit_cdf" placeholder="Qu'avez vous comme crédit en CDF" <?php echo $pattern_currency_null_too; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">debit en CDF</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['debit_cdf']; ?>" name="debit_cdf" placeholder="Qu'avez vous comme débit en CDF" <?php echo $pattern_currency_null_too; ?>>
                                </div>
                            </div>
                            **************************************Uniquement en USD*******************************
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Crédit en USD</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['credit_usd']; ?>" name="credit_usd" placeholder="Qu'avez vous comme crédit en USD" <?php echo $pattern_currency_null_too; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Debit en USD</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['debit_usd']; ?>" name="debit_usd" placeholder="Qu'avez vous comme débit en USD" <?php echo $pattern_currency_null_too; ?>>
                                </div>
                            </div>




                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                            <button type="submit" class="btn btn-info pull-right" name="submit_update_compte">Valider</button>
                        </div><!-- /.box-footer -->
                    </form>







            <?php
                } else {

                    $error = "yes";
                    $error_message = "désolé ce compte n'existe pas, veuillez selectionner un existant ";
                }
            }
            ?>

        </div>
        <div id="fade" class="black_overlay"></div>

        <form onsubmit="ShowLoading()" class="form-horizontal" action="livre_compte.php" method="post">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Capturer le Bilan a la date d'aujourdh'hui</h3>
                    <div class="box-tools pull-right">

                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>


                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                <div class="box-body" style="overflow-y: scroll;">


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Libéllé</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="libelle" placeholder="Tapez un nom identifiant votre capture" value="">

                        </div>
                    </div>



                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-left" name="submit_add_capture_general" <?php echo (get_access(33, $_SESSION['my_idprofile']) == 1) ? '' : 'disabled="True"'; ?>>Créer la Capture de toute les agences</button>
                    <button type="submit" class="btn btn-info pull-right" name="submit_add_capture" <?php echo (get_access(33, $_SESSION['my_idprofile']) == 1) ? '' : 'disabled="True"'; ?>>Créer la Capture de l'agence</button>
                </div><!-- /.box-footer -->

            </div>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Criteres` de recherche</h3>
                    <div class="box-tools pull-right">

                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>


                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Compte commencant par</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="compte" placeholder="Compte commencant par xxx " value="<?php echo $compte; ?>">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Valeur solde</label>
                        <div class="col-sm-4">
                            <select name="valeur_solde" class="form-control select2">
                                <option value="0" <?php echo ($valeur_solde == '0') ? 'selected' : ''; ?>>Toutes Valeurs</option>
                                <option value="" <?php echo ($valeur_solde == '') ? 'selected' : ''; ?>>Non nulle</option>

                            </select>

                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">

                    <button type="submit" class="btn btn-info pull-right" name="submit_search">Trouver</button>
                </div><!-- /.box-footer -->

            </div><!-- /.box -->

        </form>
        <form onsubmit="ShowLoading()" action="#" method="post">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Mode Liste</h3>
                    <a class="btn btn-adn" href="livre_compte.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&action=add_compte&compte=yes"><i class="fa fa-fw  fa-arrow-right"></i>Ajouter un Compte<i class="fa fa-fw  fa-plus-square"></i> </a> <button onclick="exportTableToCSV('ExportFileLivreCompte.csv')" class="btn btn-success pull-right"><i class="fa  fa-file-excel-o fa-download"> Exporter en CSV </i> <i class="fa fa-download"></i></button>
                </div><!-- /.box-header -->
                <div class="box-body" style="overflow-y: scroll;">

                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Numero Compte</th>
                                <th>libelle</th>
                                <th>Agence</th>
                                <th>Credit</th>
                                <th>Debit</th>
                                <th>Solde</th>
                                <th>Devise</th>
                                <th>Solde USD</th>
                                <th>USD/CDF</th>
                                <th></th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_select1 = "select t.*, t_agence.label as agence  from t_livre_compte t join t_agence on ref_agence=id_agence where ref_agence=" . $_SESSION['my_agence'] . " " . $param;
                            $sql_result1 = mysqli_query($bdd_i, $sql_select1);
                            //echo $sql_select1;
                            $index = 0;

                            while ($data1 = mysqli_fetch_array($sql_result1)) {
                                $index++;

                                if ($data1['display_sub'] == 'Yes') {
                            ?>
                                    <tr>
                                        <td><?php echo $data1['account_no']; ?></td>
                                        <td><?php echo $data1['label']; ?></td>
                                        <td><?php echo $data1['agence']; ?></td>
                                        <td><?php echo $data1['credit_final']; ?></td>
                                        <td><?php echo $data1['debit_final']; ?></td>
                                        <td><?php echo $data1['solde_final']; ?></td>
                                        <td><?php echo $data1['ref_devise']; ?></td>
                                        <td><?php echo round($data1['solde_final'] / $_SESSION['my_taux'], 0) . " $"; ?></td>
                                        <td>

                                            <?php echo ($data1['display_sub'] == 'Yes') ? '<i class="fa  fa-sort-amount-asc">Ouvert</i>' : '<i class="fa fa-lock">Fermé</i>'; ?>
                                            <?php
                                            if ($data1['display_sub'] == "Non") {
                                            ?>
                                                <a href="livre_compte.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&action=set_extend&find=<?php echo $data1['account_no']; ?>" onClick="return confirm('Cette action va affiché Toutes le devises du compte, Vous confirmez')"><i class="fa fa-fw  fa-arrow-right"></i><i class="fa fa-fw  fa-refresh"></i> </a>

                                            <?php
                                            }
                                            ?>
                                            <?php
                                            if ($data1['display_sub'] == "Yes") {
                                            ?>
                                                <a href="livre_compte.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&action_click=set_hidden&find=<?php echo $data1['account_no']; ?>" onClick="return confirm('Cette action va cacher les autres devises du compte, Vous confirmez')"><i class="fa fa-fw  fa-arrow-right"></i><i class="fa fa-fw  fa-refresh"></i> </a>

                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (get_access(32, $_SESSION['my_idprofile']) == 1) {
                                            ?>
                                                <a href="livre_compte.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&compte=<?php echo $data1['account_no']; ?>&action=update_compte"><i class="fa fa-fw  fa-edit"></i> </a>

                                            <?php
                                            }
                                            ?>
                                        </td>


                                    </tr>
                                    <tr>
                                        <td><?php echo $data1['account_no'] . '-USD'; ?></td>
                                        <td><?php echo $data1['label'] . " USD"; ?></td>
                                        <td><?php echo $data1['agence']; ?></td>

                                        <td><?php echo $data1['credit_usd']; ?></td>
                                        <td><?php echo $data1['debit_usd']; ?></td>
                                        <td><?php echo $data1['solde_usd']; ?></td>
                                        <td><?php echo "USD"; ?></td>
                                        <td><?php echo "-" ?></td>
                                        <td>Sub</td>
                                        <td></td>


                                    </tr>
                                    <tr>
                                        <td><?php echo $data1['account_no'] . '-CDF'; ?></td>
                                        <td><?php echo $data1['label'] . " CDF"; ?></td>
                                        <td><?php echo $data1['agence']; ?></td>
                                        <td><?php echo $data1['credit_cdf']; ?></td>
                                        <td><?php echo $data1['debit_cdf']; ?></td>
                                        <td><?php echo $data1['solde_cdf']; ?></td>
                                        <td><?php echo "CDF"; ?></td>
                                        <td><?php echo "-" ?></td>
                                        <td>Sub</td>
                                        <td></td>

                                    </tr>
                                <?php
                                } else {
                                ?>
                                    <tr>
                                        <td><?php echo $data1['account_no']; ?></td>
                                        <td><?php echo $data1['label']; ?></td>
                                        <td><?php echo $data1['agence']; ?></td>
                                        <td><?php echo $data1['credit_final']; ?></td>
                                        <td><?php echo $data1['debit_final']; ?></td>
                                        <td><?php echo $data1['solde_final']; ?></td>
                                        <td><?php echo $data1['ref_devise']; ?></td>
                                        <td><?php echo "-" ?></td>
                                        <td>
                                            <?php echo ($data1['display_sub'] == 'Yes') ? '<i class="fa  fa-sort-amount-asc">Ouvert</i>' : '<i class="fa fa-lock">Fermé</i>'; ?>
                                            <?php
                                            if ($data1['display_sub'] == "No") {
                                            ?>
                                                <a href="livre_compte.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&action_click=set_extend&find=<?php echo $data1['account_no']; ?>" onClick="return confirm('Cette action va affiché Toutes le devises du compte, Vous confirmez')"><i class="fa fa-fw  fa-arrow-right"></i><i class="fa fa-fw  fa-refresh"></i> </a>

                                            <?php
                                            }
                                            ?>


                                        </td>
                                        <td>
                                            <?php
                                            if (get_access(32, $_SESSION['my_idprofile']) == 1) {


                                            ?>
                                                <a href="livre_compte.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&compte=<?php echo $data1['account_no']; ?>&action=update_compte"><i class="fa fa-fw  fa-edit"></i> </a>

                                            <?php
                                            }
                                            ?>
                                        </td>

                                    </tr>
                            <?php
                                }
                            }
                            ?>

                        </tbody>
                        <tfoot>
                            <th>Numero Compte</th>
                            <th>libelle</th>
                            <th>Agence</th>
                            <th>Credit</th>
                            <th>Debit</th>
                            <th>Solde</th>
                            <th>Devise</th>
                            <th>Solde USD</th>
                            <th>USD/CDF</th>
                            <th></th>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            <input name="total" type="hidden" value="<?php echo $index; ?>">
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
include_once("php/tableau_controle.php");
?>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->

</div><!-- ./wrapper -->

<?php
include_once("php/importation_js.php");
?>
</body>

</html>