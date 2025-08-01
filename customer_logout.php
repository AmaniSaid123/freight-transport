<?php
include_once("php/function.php");

session_start ();


session_unset ();


session_destroy ();

header ('location:customer_home.php');



