<?php
if (isset($_GET['success']) && $_GET['success'] == "ok") {

	$success = "yes";
	$success_message = $_GET['msg'];
}
if (isset($_GET['error']) && $_GET['error'] == "ok") {

	$error = "yes";
	$error_message = $_GET['msg'];
}
if (isset($_GET['info']) && $_GET['info'] == "ok") {

	$information = "yes";
	$information_message = $_GET['msg'];
}
if (isset($_GET['warning']) && $_GET['warning'] == "ok") {

	$warning = "yes";
	$warning_message = $_GET['msg'];
}
if (isset($_GET['fst']) && $_GET['fst'] == '0x001') {
?>

	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4> <i class="icon fa fa-check"></i> Salut
		 <?php echo $_SESSION['my_firstname'] . " " . $_SESSION['my_lastname']; ?></h4>
		<?php echo "Bienvenu dans Passport SARL."; ?>
	</div>
<?php
}
?>

<?php
if ($information == 'yes') {
?>

	<div class="alert alert-info alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-info"></i> Pour ton Information!</h4>
		<?php echo $information_message; ?>
	</div>
<?php
}
?>


<?php
if ($error == 'yes') {
?>

	<div class="callout callout-danger">
		<h4><?php echo "Erreur"; ?></h4>
		<p><?php echo $error_message; ?></p>
	</div>
<?php
}
?>


<?php
if ($success == 'yes') {
?>

	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4> <i class="icon fa fa-check"></i> Notification</h4>
		<?php echo $success_message; ?>
	</div>
<?php
}
?>

<?php
if ($warning == 'yes') {
?>

	<div class="callout callout-warning">
		<h4>Attention!</h4>
		<p><?php echo $warning_message; ?></p>
	</div>
<?php
}
?>

<?php
if (isset($_GET['success']) && $_GET['success'] == "ajout_journal") {
?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4> <i class="icon fa fa-check"></i> Votre rapport de la journée a bien été enregistré. 
		<h5>Votre hiérarchie va également comparer vos heures d'entrée et de sortie avec les heures qui seront mentionnées dans la Pointeuse biométrique.</h5>
		</h4>
	</div>
<?php
}
?>
<?php
if (isset($_GET['success']) && $_GET['success'] == "add_holiday") {
?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4> <i class="icon fa fa-check"></i> Votre journée OFF a bien été enregistré. 
		</h4>
	</div>
<?php
}
?>
