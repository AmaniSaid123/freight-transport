<?php 
$bdd_i="";
$bdd_i = mysqli_connect('127.0.0.1', 'root', 'root', 'passport');

if (mysqli_connect_error()) {
 
$logMessage = 'MySQL Error: ' . mysqli_connect_error();
  // Call your logger here.
 
die('Could not connect to the database');
 
}  


$bdd="";
try
{
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=passport;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
?>
