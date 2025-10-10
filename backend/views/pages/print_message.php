<?php
$success = "";
$error = "";
$information = "";
$warning = "";
if (isset($_GET['success']) && $_GET['success'] == "ok") {

	$success = "yes";
	$success_message = $_GET['msg'];
}
if (isset($_GET['error']) && in_array($_GET['error'], ['update_failed', 'auth_failed', 'system_error'])) {

	$error = "yes";
	$error_message = $_GET['msg'];
}
if (isset($_GET['info']) && $_GET['info'] == "ok") {

	$information = "yes";
	//$information_message = $_GET['msg'];
}
if (isset($_GET['warning']) && $_GET['warning'] == "ok") {

	$warning = "yes";
	//$warning_message = $_GET['msg'];
}
if (isset($_GET['fst']) && $_GET['fst'] == '0x001') {
	?>

<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4> <i class="icon fa fa-check"></i> Salut
        <?php echo $_SESSION['my_firstname'] . " " . $_SESSION['my_lastname']; ?>
    </h4>
    <?php echo "Bienvenu dans TCC."; ?>
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