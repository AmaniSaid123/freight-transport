<?php
include_once("php/function.php");
// On d&eacute;marre la session 
session_start (); 
add_notification("t_user",$_SESSION['username'],"Deconnexion MyPASS","Deconnexion MyPASS",$_SESSION['username'],"Deconnexion MyPASS");
  
  
// On d&eacute;truit les variables de notre session   


session_unset ();   

// On d&eacute;truit notre session   
session_destroy ();   

// On redirige le visiteur vers la page d'accueil   
header ('location:index.php');   

?> 