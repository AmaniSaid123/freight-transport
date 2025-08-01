<?php 
include_once("function.php");
session_start();
if (isset($_SESSION['my_doc_online']) || (isset($_GET['val_ndel']))){
$use_login="";
$use_acces="";
}else
{
	$use_login="";
$use_acces="";
header("Location:login.php");
}
if((isset($_SESSION['my_doc_online'])) || (isset($_GET['val_ndel'])))
		{

			}else{
				header("Location:login.php");
				}
$TimeOutMinutes=180;//This is my time period in minute
$TimeOutSecondes=$TimeOutMinutes*60;//This is my time period in minute

if(isset($_SESSION['LAST_ACTIVITY']) && 0){
	$InactiveTime=time()-$_SESSION['LAST_ACTIVITY'];
	if($InactiveTime>=$TimeOutSecondes){
		$_SESSION['LAST_ACTIVITY']=time();
		header("Location:login.php");
		}
	
	
	}


/*if(isset($_SESSION['m_lock']) && $_SESSION['m_lock']!="NA" && $idpage!=1){
	$_SESSION['m_lock']="NA";
	header("Location:lockscreen.php?try=ok");
	
	}*/	
	

		
			
//*********************RESET SESSION START DATE*************
	$_SESSION['sessionstarttime_online']=time();		
//************Page actuel
$currentpage="No where";
//***************** Affichage de message******************
$error="no";
$warning="no";
$success="no";
$information="no";

$error_message="Error on the page Errorcode=xx001Defaults";
$warning_message="This is a warning";
$success_message="Your request succeed";
$information_message="Welcome in MyPASS";


//********************************************************
//******************Tableau de bord***********************


?>