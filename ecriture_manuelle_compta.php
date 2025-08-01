<?php
	//******************IDPAGE*****************
$idpage = 37;
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
$page_titre = "Comptabilité";
$page_small_detail = "Ecritures Manuelles";
$page_location = "Comptabilité > Ecritures Manuelles";

//****************location******************

if (isset($_POST['submit_operation']) && $_POST['montant'] != "" && $_POST['montant'] != "") {

	$code_transaction = "OC-" . time();

	$montant = clean_in_double($_POST['montant']);
	$libelle = clean_in_text($_POST['libelle']);
	$data_operation = get_operation_data($_POST['ref_operation']);
	$ref_operation = $data_operation['idt_operation'];
	$code_operation = $data_operation['label'];
	$ref_type_compte = $data_operation['ref_type_operation'];
    $statut_transaction="Creer";
    $type_account=$data_operation['ref_type_operation'];
	switch ($data_operation['ref_type_operation']) {

		case 8:

			$statut_transaction = "Creer";
			$type_account = "OP";
			$code_transaction = "OP-" . time();

			break;

		case 9:

			$statut_transaction = "Valide";
			$type_account = "OC";
			$code_transaction = "OC-" . time();

			break;

		case 10:

			$statut_transaction = "Valide";
			$type_account = "OE";
			$code_transaction = "OE-" . time();

			break;
	}



	if (1) {

		$feedback_transaction = add_transaction_with_detail($ref_type_compte, $_POST['ref_devise'], $montant, "Agence web", 0, 0, 0, $code_transaction, $statut_transaction, 0, 0, $ref_operation, $code_operation, 0, 'NA', $type_account, $libelle);

		if ($feedback_transaction == 1) {
			$success = "yes";
			$action_compte = 0;
			$message_feedback = "---- Transaction executé avec succès, pour  " . $data_operation['label'] . ", montant de " . $montant . " " . $_POST['ref_devise'] . ", libellé : " . $libelle;

			$success_message = $message_feedback;
			//echo "Niveoooooooooooooooooooooooooooooooooo 0 : ".do_operation_get_ecriture($ref_operation)."  : ";

			if ($feedback_transaction == 1 && do_operation_get_ecriture($ref_operation)>=1) {

				//echo "Niveoooooooooooooooooooooooooooooooooo 1";

				$sql_ecriture = mysqli_query($bdd_i,"select * from t_ecriture where ref_operation=" . $ref_operation);
				$feedback_livre = 0;
				$ecriture_saved = 0;
				$ecriture_done = 0;
				$update_compte = 0;
				$update_compte_text = "";
				$update_solde = 0;
				$action_compte++;
				$i = 0;

				while ($data_ecriture = mysqli_fetch_array($sql_ecriture)) {
						$i++;
						//	echo "Niveoooooooooooooooooooooooooooooooooo 2";

						$montant_final = ($_POST['ref_devise'] == 'CDF') ? $montant : $montant * $_SESSION['my_taux'];
						$montant_usd = ($_POST['ref_devise'] == 'USD') ? $montant : 0;

						$montant_cdf = ($_POST['ref_devise'] == 'CDF') ? $montant : 0;


						if ($data_ecriture['action'] == 'D') {
								$data_compte_parent = get_livre_compte_data($data_ecriture['ref_compte']);
								$feedback_livre = add_in_grand_journal($data_ecriture['ref_compte'], $_POST['ref_devise'], 0, $montant, $data_compte_parent['credit_final'], $data_compte_parent['debit_final'], $data_compte_parent['solde_final']+$montant_final, $code_transaction, $libelle, 0, 0, $ref_operation, $code_operation);
								$feedback_update_livre = update_livre_compte_debit($data_ecriture['ref_compte'], $montant_final, $montant_usd, $montant_cdf);
								$ecriture_done = $ecriture_done + $feedback_livre;
								$update_compte = $update_compte + $feedback_update_livre;
								$update_compte_text = $update_compte_text . $data_ecriture['ref_compte'] . " -->> Debiter : " . $montant . " " . $_POST['ref_devise'] . " | ";
							}

						if ($data_ecriture['action'] == 'C') {
								$data_compte_parent = get_livre_compte_data($data_ecriture['ref_compte']);
								$feedback_livre = add_in_grand_journal($data_ecriture['ref_compte'], $_POST['ref_devise'], $montant, 0, $data_compte_parent['credit_final'], $data_compte_parent['debit_final'], $data_compte_parent['solde_final']-$montant_final, $code_transaction, $libelle, 0, 0, $ref_operation, $code_operation);
								$feedback_update_livre = update_livre_compte_credit($data_ecriture['ref_compte'], $montant_final, $montant_usd, $montant_cdf);
								$ecriture_done = $ecriture_done + $feedback_livre;
								$update_compte = $update_compte + $feedback_update_livre;
								$update_compte_text = $update_compte_text . $data_ecriture['ref_compte'] . " -->> Crediter : " . $montant . " " . $_POST['ref_devise'] . " | ";
							}


						$feedback_update_livre = update_livre_compte_solde($data_ecriture['ref_compte']);


                    }
                    
						if ($feedback_transaction == 1 && $feedback_livre >= 1) {


							$success = "yes";

							$message_feedback = $message_feedback . "<br>" . $update_compte_text . "";

							$success_message = $message_feedback;
						} else {

							$error = "yes";
							//$success="no";
							$error_message = $error_message . "<br>" . i . ". " . $update_compte_text . "";


							//$error_message=$message_feedback;
						}
			}
		} else {

			$error = "yes";
			$error_message = "Une erreur a survenue lors de l'ecriture manuelle";
		}
	} else {

		$error = "yes";
		$error_message = "Une erreur a survenue lors de l'ecriture manuelle 2";
	}
} else {

	if (isset($_POST['submit_operation']) && is_double($_POST['montant'])) {

		$error = "yes";
		$error_message = "Une erreur a survenue lors  de l'ecriture manuelle, le montant n'est pas correct";
	}
}

if (isset($_POST['submit_ecriture'])) {
	$message_feedback = "";

	$message_feedback = "";
	$total_debit_usd = 0;
	$total_debit_cdf = 0;
	$total_credit_usd = 0;
	$total_credit_cdf = 0;

	for ($i = 1; $i <= 10; $i++) {

		if (isset($_POST['chk_btn' . $i]) && $_POST['chk_btn' . $i] == 'ok') {

			$total_debit_usd = ($_POST['ref_devise' . $i] == 'USD' && $_POST['action' . $i] == 'D') ? $total_debit_usd + $_POST['montant' . $i] : $total_debit_usd;
			$total_debit_cdf = ($_POST['ref_devise' . $i] == 'CDF' && $_POST['action' . $i] == 'D') ? $total_debit_cdf + $_POST['montant' . $i] : $total_debit_cdf;
			$total_credit_usd = ($_POST['ref_devise' . $i] == 'USD' && $_POST['action' . $i] == 'C') ? $total_credit_usd + $_POST['montant' . $i] : $total_credit_usd;
			$total_credit_cdf = ($_POST['ref_devise' . $i] == 'CDF' && $_POST['action' . $i] == 'C') ? $total_credit_cdf + $_POST['montant' . $i] : $total_credit_cdf;
		}
	}


	if ($total_credit_cdf == $total_debit_cdf && $total_credit_usd == $total_debit_usd) {
		for ($i = 1; $i <= 10; $i++) {

			if (isset($_POST['chk_btn' . $i]) && $_POST['chk_btn' . $i] == 'ok') {

				$code_transaction = "OG-" . time();

				$montant = clean_in_double($_POST['montant' . $i]);
				$libelle = clean_in_text($_POST['libelle' . $i]);
				$ref_devise = $_POST['ref_devise' . $i];
				$action = $_POST['action' . $i];
				$ref_compte = $_POST['ref_compte' . $i];

				$code_operation = "Operation Comptable";
				$ref_operation = 37;
				$ref_type_compte = "9";
				$statut_transaction = "valide";
				$type_account = $_POST['type_account' . $i];

				switch ($type_account) {

					case 'OP':

						$statut_transaction = "ouvert";
						$type_account = "OP";
						$code_transaction = "OP-" . time() . $i;
						$ref_type_compte = "8";



						break;

					case 'OC':

						$statut_transaction = "valide";
						$type_account = "OC";
						$code_transaction = "OC-" . time() . $i;
						$ref_type_compte = "9";

						break;

					case 'OE':

						$statut_transaction = "ouvert";
						$type_account = "OE";
						$code_transaction = "OE-" . time() . $i;
						$ref_type_compte = "10";

						break;
				}





				//$feedback_transaction = add_transaction_with_detail($ref_type_compte, $ref_devise, $montant, "Agence web", 0, 0, 0, $code_transaction, $statut_transaction, 0, 0, $ref_operation, $code_operation, 0, 'NA', $type_account, $libelle);
				//echo "eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee: ".$feedback_transaction;
				if (1) {


					$feedback_livre = 0;
					$ecriture_saved = 0;
					$ecriture_done = 0;
					$update_compte = 0;
					$update_compte_text = "";
					$update_solde = 0;


					$montant_final = ($ref_devise == 'CDF') ? $montant : $montant * $_SESSION['my_taux'];
					$montant_usd = ($ref_devise == 'USD') ? $montant : 0;

					$montant_cdf = ($ref_devise == 'CDF') ? $montant : 0;


					if ($action == 'D') {
							$data_compte_parent = get_livre_compte_data($ref_compte);
							$feedback_livre = add_in_grand_journal($ref_compte, $ref_devise, 0, $montant, $data_compte_parent['credit_final'], $data_compte_parent['debit_final']+$montant, $data_compte_parent['solde_final']+$montant_final, $code_transaction, $libelle, 0, 0, $ref_operation, $code_operation);
							$feedback_update_livre = update_livre_compte_debit($ref_compte, $montant_final, $montant_usd, $montant_cdf);

							$update_compte_text = $update_compte_text . $i . ". " . $ref_compte . " -->> Debiter : de " . $montant . " " . $ref_devise . " | libelle : " . $libelle . " | Type action : " . $type_account . "<br> ";
						}

					if ($action == 'C') {
							$data_compte_parent = get_livre_compte_data($ref_compte);
							$feedback_livre = add_in_grand_journal($ref_compte, $ref_devise, $montant, 0, $data_compte_parent['credit_final']+$montant, $data_compte_parent['debit_final'], $data_compte_parent['solde_final']-$montant_final, $code_transaction, $libelle, 0, 0, $ref_operation, $code_operation);
							$feedback_update_livre = update_livre_compte_credit($ref_compte, $montant_final, $montant_usd, $montant_cdf);

							$update_compte_text = $update_compte_text . $i . ". " . $ref_compte . " -->> Créditer : " . $montant . " " . $ref_devise . " | libelle : " . $libelle . " | Type action : " . $type_account . " <br> ";
						}


					$feedback_update_livre = update_livre_compte_solde($ref_compte);




					if ($feedback_livre >= 1) {


						$success = "yes";
						$error = "no";
						$message_feedback = $message_feedback . $update_compte_text . "";

						$success_message = $message_feedback;
					} else {

						$error = "yes";
						$success = "no";
						$message_feedback = $message_feedback . $i . ". erreur a survenue lors de l'ecriture " . $type_account . " :  " . " , Transact=" . $feedback_transaction . " / Livre de compte=" . $feedback_livre . "<br>" . $update_compte_text . "";


						$error_message = $message_feedback;
					}
				} else {

					$error = "yes";
					$error_message = "Une erreur a survenue lors de l'ecriture manuelle " . $i;
				}
			} else {

				if (isset($_POST['chk_btn' . $i]) && $_POST['chk_btn' . $i] == "ok") {

					$error = "yes";
					$success = "no";
					$error_message = $message_feedback . "Une erreur a survenue lors  de l'ecriture manuelle, le montant n'est pas correct à la ligne " . $i;
				}
			}
		}
	} else {

		$error = "yes";
		$error_message = "Une erreur a survenue lors de l'ecriture manuelle, Votre ecriture n'est pas équilibré, Total CDF (Credit = " . $total_credit_cdf . " Fc vs Debit = " . $total_debit_cdf . " Fc) et Total en USD (Credit = " . $total_credit_usd . " $ vs Debit = " . $total_debit_usd . " $)";
	} //End If of equilibre ecriture
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
<?php	 ?>
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
						if (isset($_GET['compte']) && isset($_GET['action']) && $_GET['action'] == "add_compte") {

							?>
            <a onClick="hide_pop()"><i class="fa  fa-close">Fermer Ici</i></a>



            <?php 
					}
					?>

        </div>
        <div id="fade" class="black_overlay"></div>


        <form onsubmit="ShowLoading()" action="ecriture_manuelle_compta.php" method="post">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Ecritures Automatiques pré-enrégistrées --->>></h3>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div><!-- /.box-header -->
                <div class="box-body" style="overflow-y: scroll;">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Opération</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="ref_operation">
                                <?php echo getcombo_operation_comptable_with_ecriture_oc(0); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Montant</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="" name="montant"> <select class="form-control" name="ref_devise">
                                <option value="USD">USD</option>
                                <option value="CDF">CDF</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Libelle</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="" name="libelle" <?php echo $pattern_text; ?>>
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">

                    <button type="submit" class="btn btn-info pull-right" name="submit_operation">Valider</button>
                </div><!-- /.box-footer -->
            </div><!-- /.box -->


        </form>


        <form onsubmit="ShowLoading()" action="ecriture_manuelle_compta.php" method="post">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Valider Ici --->>></h3>
                    <button type="submit" class="btn btn-success pull-right" name="submit_ecriture">Valider</button>
                    <button type="submit" class="btn btn-info pull-right" name="view_ecriture">Afficher Ecritures</button>
                </div><!-- /.box-header -->
                <div class="box-body" style="overflow-y: scroll;">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Opération</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="ref_operation_2">
                                <?php echo getcombo_operation_comptable_with_ecriture_oc(0); ?>
                            </select>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Compte</th>
                                <th>Montant</th>

                                <th>Devise</th>
                                <th>Action</th>
                                <th>Type</th>
                                <th>Libellé</th>
                                <th><i class="fa fa-check-square-o"></i></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
														$i = 0;

														if (isset($_POST['view_ecriture'])) {

															$data_operation = get_operation_data($_POST['ref_operation_2']);
															$sql_ecriture = mysqli_query($bdd_i,"select * from t_ecriture where ref_operation=" . $data_operation['idt_operation']);


															while ($data_ecriture = mysqli_fetch_array($sql_ecriture)) {
																	$i++;

																	?>
                            <tr>
                                <td width="35%">
                                    <select name="ref_compte<?php echo $i; ?>" class="form-control select2">

                                        <?php	echo getcombo_compte_detail_new($data_ecriture['ref_compte']); ?>
                                    </select>
                                </td>
                                <td width="7%">
                                    <input type="text" size="8" class="form-control" value="" name="montant<?php echo $i; ?>">
                                </td>
                                <td width="10%">
                                    <select class="form-control" name="ref_devise<?php echo $i; ?>">
                                        <option value="USD">USD</option>
                                        <option value="CDF">CDF</option>
                                    </select>
                                </td>
                                <td width="10%">
                                    <select class="form-control" name="action<?php echo $i; ?>">
                                        <option value="C" <?php echo ($data_ecriture['action'] == "C") ? "selected" : ""; ?>>Crediter</option>
                                        <option value="D" <?php echo ($data_ecriture['action'] == "D") ? "selected" : ""; ?>>Debiter</option>
                                    </select>

                                </td>
                                <td width="10%">

                                    <select class="form-control" name="type_account<?php echo $i; ?>">

                                        <option value="OC">OC</option>

                                    </select>
                                </td>
                                <td width="20%">
                                    <input type="text" class="form-control" value="<?php echo $data_operation['label']; ?>" name="libelle<?php echo $i; ?>">
                                </td>
                                <td width="5%">
                                    <input name="chk_btn<?php echo $i; ?>" type="checkbox" value="ok" checked>
                                </td>




                            </tr>

                            <?php 
													}
											}


											?>

                            <?php 
														// echo $sql_select1;
														$i++;
														$index = $i;
														$loop = $i;




														while ($loop <= 10) {
															$index++;


															?>
                            <tr>
                                <td width="35%">
                                    <select name="ref_compte<?php echo $loop; ?>" class="form-control select2">

                   
                                        <?php	echo getcombo_compte_detail_new(0); ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" size="8" class="form-control" value="" name="montant<?php echo $loop; ?>">
                                </td>
                                <td>
                                    <select class="form-control" name="ref_devise<?php echo $loop; ?>">
                                        <option value="USD">USD</option>
                                        <option value="CDF">CDF</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="action<?php echo $loop; ?>">
                                        <option value="C">Crediter</option>
                                        <option value="D">Debiter</option>
                                    </select>

                                </td>
                                <td>

                                    <select class="form-control" name="type_account<?php echo $loop; ?>">

                                        <option value="OC">OC</option>

                                    </select>
                                </td>
                                <td width="20%">
                                    <input type="text" class="form-control" value="" name="libelle<?php echo $loop; ?>">
                                </td>
                                <td>
                                    <input name="chk_btn<?php echo $loop; ?>" type="checkbox" value="ok">
                                </td>




                            </tr>
                            <?php	
														$loop++;
													}

													?>

                        </tbody>

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