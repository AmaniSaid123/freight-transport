<?php
require_once __DIR__ . '/../../../php/function.php';

session_start();
if (isset($_SESSION['my_username'])) {
	$use_login = "";
	$use_acces = "";
} else {
	$use_login = "";
	$use_acces = "";
	header("Location:dashborad.php?error=login");
}
if (!(isset($_SESSION['my_username']))) {
	header("Location:dashborad.php?error=login");
} else {

}
$TimeOutMinutes = 180;//This is my time period in minute
$TimeOutSecondes = $TimeOutMinutes * 60;//This is my time period in minute

if (isset($_SESSION['LAST_ACTIVITY'])) {
	$InactiveTime = time() - $_SESSION['LAST_ACTIVITY'];
	if ($InactiveTime >= $TimeOutSecondes) {
		$_SESSION['LAST_ACTIVITY'] = time();
		header("Location:lockscreen.php?lock=yes&error=inactivity");
	}


}




if (get_access($bdd,$idpage, $_SESSION['my_idprofile']) == 1) {


} else {
	header("login.php?error=autorisation");
}


//*********************RESET SESSION START DATE*************
$_SESSION['LAST_ACTIVITY'] = time();
//************Page actuel
$currentpage = "No where";
//***************** Affichage de message******************
$error = "no";
$warning = "no";
$success = "no";
$information = "no";

$error_message = "Error on the page Errorcode=xx001Defaults";
$warning_message = "This is a warning";
$success_message = "Your request succeed";
$information_message = "Welcome in MyPASS";


//********************************************************
//******************Tableau de bord***********************


?>