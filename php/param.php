<?php 
$bdd_i="";
$bdd_i=mysqli_connect('p:127.0.0.1', 'passport_bd_user', '8plus8=SEIZE+0-1+1', 'passport_bd');
 
if (mysqli_connect_error()) {
 
$logMessage = 'MySQL Error: ' . mysqli_connect_error();
  // Call your logger here.
 
die('Could not connect to the database');
 
}  


$bdd="";
try
{
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=passport_bd;charset=utf8', 'passport_bd_user', '8plus8=SEIZE+0-1+1');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
?>
