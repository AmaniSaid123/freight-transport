<?php
//******************IDPAGE*****************
$idpage = 33;
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
$page_titre = "Comptabilité - Captures Livre Journal";
$page_small_detail = "Capture Livre Journal";
$page_location = "Comptabilité > Capture Livre Journal";

//****************location******************

if (isset($_GET['action']) && $_GET['action'] == "set_extend" && isset($_GET['find'])) {

    $feedback_action = set_compte_display_value_capture(clean_in_text($_GET['find']), "Yes");
    if ($feedback_action == 1) {
        $success = "yes";
        $success_message = "Le vision multi dévise a été activer pour ce compte avec succès";
    } else {
        $error = "yes";
        $error_message = "Une erreur a survenue lors de l'activation de la vue multi-devise";
    }
}

if (isset($_GET['action']) && $_GET['action'] == "set_hidden" && isset($_GET['find'])) {

    $feedback_action = set_compte_display_value_capture(clean_in_text($_GET['find']), "No");
    if ($feedback_action == 1) {
        $success = "yes";
        $success_message = "Le vision multi dévise a été désactiver pour ce compte avec succès";
    } else {
        $error = "yes";
        $error_message = "Une erreur a survenue lors de la désactivation de la vue multi-devise";
    }
}


$agence = '';
$reference = '';
$param = ' && 0';
if (isset($_POST['submit_search'])) {

    $agence = $_POST['agence'];
    $reference = $_POST['reference'];
    $param = ' ';
    $param = ($agence == '') ? $param . '  ' : $param . ' and ref_agence='.$agence;
    $param = ($reference == '') ? $param . '' : $param . " and libelle='" . $reference. "'";
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
        <!-- Your Page Content Here -->
        <!-- Horizontal Form -->
        <div id="light" class="white_content">

<?php
//*******************************Modification creation compte epargne EAC ****************************
if (isset($_GET['compte']) && isset($_GET['action']) && $_GET['action'] == "add_compte" && 0) {
    ?>         
                <a onClick="hide_pop()"><i class="fa  fa-close">Fermer Ici</i></a>
                <form  onsubmit="ShowLoading()" class="form-horizontal"  action="livre_compte.php"  method="post">
                    <p align="center"><h4>Création d'un Compte</h4></p>
                    <div class="box-body">


                        <div class="form-group">
                            <label  class="col-sm-4 control-label">Numero de compte</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" value="" name="account_no"  placeholder="Entrez le numero de compte" <?php echo $pattern_number; ?>>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-4 control-label">Intitulé du compte</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="label"  placeholder="Entrez l'intitulé du compte" <?php echo $pattern_text; ?>>                      </div> 
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-4 control-label">Dévise</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="CDF" name="devise" readonly>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-4 control-label">Credit Balancé en CDF</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="credit_final" placeholder="Qu'avez vous comme crédit principal" <?php echo $pattern_currency_null_too; ?>>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-4 control-label">Debit Balancé en CDF</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="debit_final" placeholder="Qu'avez vous comme débit principal"<?php echo $pattern_currency_null_too; ?>>
                            </div> 
                        </div>
                        ***************************************Uniquement en CDF*****************************
                        <div class="form-group">
                            <label  class="col-sm-4 control-label">Crédit en CDF</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="credit_cdf" placeholder="Qu'avez vous comme crédit en CDF" <?php echo $pattern_currency_null_too; ?>>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-4 control-label">debit en CDF</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="debit_cdf" placeholder="Qu'avez vous comme débit en CDF" <?php echo $pattern_currency_null_too; ?>>
                            </div> 
                        </div>
                        **************************************Uniquement en USD*******************************
                        <div class="form-group">
                            <label  class="col-sm-4 control-label">Crédit en USD</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="credit_usd" placeholder="Qu'avez vous comme crédit en USD" <?php echo $pattern_currency_null_too; ?>>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-4 control-label">Debit en USD</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="" name="debit_usd" placeholder="Qu'avez vous comme débit en USD" <?php echo $pattern_currency_null_too; ?>>
                            </div> 
                        </div>
                        **************************************Information multi dévises*******************************
                        <div class="form-group">
                            <label  class="col-sm-4 control-label">Cochez pour l'affichage multi Devise</label>
                            <div class="col-sm-6">
                                <input name="display_sub" type="checkbox" value="on">
                            </div> 
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                        <button type="submit"  class="btn btn-info pull-right" name="submit_add_compte">Valider</button>
                    </div><!-- /.box-footer -->
                </form>


    <?php
}
?>                    
<?php
//*******************************Modification creation compte epargne EAC ****************************
if (isset($_GET['compte']) && isset($_GET['action']) && $_GET['action'] == "update_compte" && 0) {
    $data_livre_compte = get_livre_compte_data(clean_in_text($_GET['compte']));

    if ($data_livre_compte['is_exist'] == 1) {
        ?>         
                    <a onClick="hide_pop()"><i class="fa  fa-close">Fermer Ici</i></a>
                    <form  onsubmit="ShowLoading()" class="form-horizontal"  action="livre_compte.php"  method="post">
                        <p align="center"><h4>Mise a jour Compte : <?php echo $data_livre_compte['account_no'] . " - " . $data_livre_compte['label']; ?></h4></p>
                        <div class="box-body">


                            <div class="form-group">
                                <label  class="col-sm-4 control-label">Numero de compte</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['account_no']; ?>" name="account_no"  placeholder="Entrez le numero de compte" readonly>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">Intitulé du compte</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['label']; ?>" name="label_compte"  placeholder="Entrez l'intitulé du compte" <?php echo $pattern_text; ?>>                      </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">Dévise</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="CDF" name="devise" readonly>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">Credit Balancé en CDF</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['credit_final']; ?>" name="credit_final" placeholder="Qu'avez vous comme crédit principal" <?php echo $pattern_currency_null_too; ?>>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">Debit Balancé en CDF</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['debit_final']; ?>" name="debit_final" placeholder="Qu'avez vous comme débit principal" <?php echo $pattern_currency_null_too; ?>>
                                </div> 
                            </div>
                            ***************************************Uniquement en CDF*****************************
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">Crédit en CDF</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['credit_cdf']; ?>" name="credit_cdf" placeholder="Qu'avez vous comme crédit en CDF" <?php echo $pattern_currency_null_too; ?>>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">debit en CDF</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['debit_cdf']; ?>" name="debit_cdf" placeholder="Qu'avez vous comme débit en CDF" <?php echo $pattern_currency_null_too; ?>>
                                </div> 
                            </div>
                            **************************************Uniquement en USD*******************************
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">Crédit en USD</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['credit_usd']; ?>" name="credit_usd" placeholder="Qu'avez vous comme crédit en USD" <?php echo $pattern_currency_null_too; ?>>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">Debit en USD</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $data_livre_compte['debit_usd']; ?>" name="debit_usd" placeholder="Qu'avez vous comme débit en USD" <?php echo $pattern_currency_null_too; ?>>
                                </div> 
                            </div>




                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()" >Fermer cette fenetre</button>
                            <button type="submit"  class="btn btn-info pull-right" name="submit_update_compte">Valider</button>
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

        <form  onsubmit="ShowLoading()" class="form-horizontal" action="capture_bilan.php"  method="post">
            
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Criteres` de recherche</h3>
                    <div class="box-tools pull-right">

                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>


                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                <div class="box-body" style="overflow-y: scroll;">


                    <div class="form-group">
                        <label  class="col-sm-2 control-label">Reference</label>
                        <div class="col-sm-4">
                            <select name="reference" class="form-control select2">
                            <?php 
                            
                            echo getcombo_reference_capture($reference);
                            
                            ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-2 control-label">Agence</label>
                        <div class="col-sm-4"> 
                            <select name="agence" class="form-control select2">
                             <option value="" <?php echo ($agence == '') ? 'selected' : ''; ?>>Toutes Agences</option>
                                <?php 
                            
                            echo getcombo_agence($agence);
                            
                            ?>
                                </select>
                            

                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">

                    <button type="submit"  class="btn btn-info pull-right" name="submit_search" >Trouver</button>
                </div><!-- /.box-footer -->

            </div><!-- /.box -->

        </form>
        <form  onsubmit="ShowLoading()" action="#" method="post">    
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Mode Liste</h3>
                                <button onclick="exportTableToCSV('ExportFileLivreCompteCapturer.csv')" class="btn btn-success pull-right" ><i class="fa  fa-file-excel-o fa-download"> Exporter en CSV </i> <i class="fa fa-download"></i></button>      
                </div><!-- /.box-header -->
                <div class="box-body" style="overflow-y: scroll;">

                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Reference</th> 
                                <th>Numero Compte</th>                      
                                <th>libelle</th>
                                <th>Agence</th>
                                <th>Credit</th>
                                <th>Debit</th>
                                <th>Solde</th>
                                <th>Devise</th>
                                <th>USD/CDF</th>
                                <th></th>


                            </tr>
                        </thead>
                        <tbody>
<?php
$sql_select1 = "select t.*, t_agence.label as agence  from t_capture_bilan t join t_agence on ref_agence=id_agence where 1 " . $param;
$sql_result1 = mysqli_query($bdd_i,$sql_select1);
 //echo $sql_select1;
$index = 0;

while ($data1 = mysqli_fetch_array($sql_result1)) {
    $index++;

    if ($data1['display_sub'] == 'Yes') {
        ?>	
                                    <tr>
                                        <td><?php echo $data1['libelle']; ?></td>
                                        <td><?php echo $data1['account_no']; ?></td> 
                                        <td><?php echo $data1['label']; ?></td>                      
                                        <td><?php echo $data1['agence']; ?></td> 
                                        <td><?php echo $data1['credit_final']; ?></td>
                                        <td><?php echo $data1['debit_final']; ?></td>
                                        <td><?php echo $data1['solde_final']; ?></td>
                                        <td><?php echo $data1['ref_devise']; ?></td>
                                        <td>

        <?php echo ($data1['display_sub'] == 'Yes') ? '<i class="fa  fa-sort-amount-asc">Ouvert</i>' : '<i class="fa fa-lock">Fermé</i>'; ?>
        <?php
        if ($data1['display_sub'] == "Non") {
            ?>
                                            <a href="capture_bilan.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&action=set_extend&find=<?php echo $data1['account_no']; ?>" onClick="return confirm('Cette action va affiché Toutes le devises du compte, Vous confirmez')"><i class="fa fa-fw  fa-arrow-right"></i><i class="fa fa-fw  fa-refresh"></i> </a>

            <?php
        }
        ?>
        <?php
        if ($data1['display_sub'] == "Yes") {
            ?>
                                                <a href="capture_bilan.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&action=set_hidden&find=<?php echo $data1['account_no']; ?>" onClick="return confirm('Cette action va cacher les autres devises du compte, Vous confirmez')"><i class="fa fa-fw  fa-arrow-right"></i><i class="fa fa-fw  fa-refresh"></i> </a>

            <?php
        }
        ?>
                                        </td> 
                                        <td>
                                    
                                        </td>              


                                    </tr>
                                    <tr>
                                        <td><?php echo $data1['libelle']; ?></td>
                                        <td><?php echo $data1['account_no'] . '20*'; ?></td> 
                                        <td><?php echo $data1['label'] . " USD"; ?></td>      
                                        <td><?php echo $data1['agence']; ?></td>                  

                                        <td><?php echo $data1['credit_usd']; ?></td>
                                        <td><?php echo $data1['debit_usd']; ?></td>
                                        <td><?php echo $data1['solde_usd']; ?></td>
                                        <td><?php echo "USD"; ?></td>
                                        <td>Sub</td>
                                        <td></td>               


                                    </tr>
                                    <tr>
                                         <td><?php echo $data1['libelle']; ?></td>
                                        <td><?php echo $data1['account_no'] . '30*'; ?></td> 
                                        <td><?php echo $data1['label'] . " CDF"; ?></td>                      
                                        <td><?php echo $data1['agence']; ?></td>                  
                                        <td><?php echo $data1['credit_cdf']; ?></td>
                                        <td><?php echo $data1['debit_cdf']; ?></td>
                                        <td><?php echo $data1['solde_cdf']; ?></td>
                                        <td><?php echo "CDF"; ?></td>
                                        <td>Sub</td>              
                                        <td></td>

                                    </tr>
                                            <?php
                                        } else {
                                            ?> 
                                    <tr>
                                         <td><?php echo $data1['libelle']; ?></td>
                                        <td><?php echo $data1['account_no']; ?></td> 
                                        <td><?php echo $data1['label']; ?></td>                      
                                        <td><?php echo $data1['agence']; ?></td>                  
                                        <td><?php echo $data1['credit_final']; ?></td>
                                        <td><?php echo $data1['debit_final']; ?></td>
                                        <td><?php echo $data1['solde_final']; ?></td>
                                        <td><?php echo $data1['ref_devise']; ?></td>
                                        <td>
        <?php echo ($data1['display_sub'] == 'Yes') ? '<i class="fa  fa-sort-amount-asc">Ouvert</i>' : '<i class="fa fa-lock">Fermé</i>'; ?>
                                            <?php
                                            if ($data1['display_sub'] == "No") {
                                                ?>
                                            <a href="capture_bilan.php?bantalaium=jakudkiusjsjjs8568rgfddghjjkjh52s852z685s2zz2&xdeligirium=uejdid856712s55z82z55d5s2s52s45zoi&action=set_extend&find=<?php echo $data1['account_no']; ?>" onClick="return confirm('Cette action va affiché Toutes le devises du compte, Vous confirmez')"><i class="fa fa-fw  fa-arrow-right"></i><i class="fa fa-fw  fa-refresh"></i> </a>

            <?php
        }
        ?>


                                        </td>               
                                        <td>
        
                                        </td>                       

                                    </tr>
        <?php
    }
}
?> 

                        </tbody>
                        <tfoot>
                        <th>Reference</th>
                        <th>Numero Compte</th>                      
                        <th>libelle</th>
                        <th>Agence</th>
                        <th>Credit</th>
                        <th>Debit</th>
                        <th>Solde</th>
                        <th>Devise</th>
                        <th></th>
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
