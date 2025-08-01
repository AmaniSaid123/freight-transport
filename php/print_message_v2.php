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
		<h4> <i class="icon fa fa-check"></i> Salut <?php echo $_SESSION['my_firstname'] . " " . $_SESSION['my_lastname']; ?></h4>
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
	<div class="alert alert-danger alert-dismissible" role="alert">
		<h4 style="color: #fcfdfd;"> <i class="icon fa fa-check"></i> <?php echo "Erreur"; ?></h4>
		<?php echo $error_message; ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
<?php
}
?>


<?php
if ($success == 'yes') {
?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<h4 style="color: #fcfdfd;"> <i class="icon fa fa-check"></i> Notification</h4>
		<?php echo $success_message; ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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