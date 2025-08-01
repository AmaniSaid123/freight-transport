<?php 
include_once("function.php");
session_start();
if (isset($_SESSION['my_username'])){
$use_login="";
$use_acces="";
}else
{
     $use_login="";
     $use_acces="";
header("Location:index.php?error=login");
}
if(!(isset($_SESSION['my_username'])))
		{
header("Location:index.php?error=login");
			}else{
				
				}
$TimeOutMinutes=180;//This is my time period in minute
$TimeOutSecondes=$TimeOutMinutes*60;//This is my time period in minute

if(isset($_SESSION['LAST_ACTIVITY'])){
	$InactiveTime=time()-$_SESSION['LAST_ACTIVITY'];
	if($InactiveTime>=$TimeOutSecondes){
		$_SESSION['LAST_ACTIVITY']=time();
		header("Location:lockscreen.php?lock=yes&error=inactivity");
		}
	
	
	}


/*if(isset($_SESSION['m_lock']) && $_SESSION['m_lock']!="NA" && $idpage!=1){
	$_SESSION['m_lock']="NA";
	header("Location:lockscreen.php?try=ok");
	
	}*/	
	
if(get_access($idpage,$_SESSION['my_idprofile'])==1){
		
	
	}else{
			header("Location:index.php?error=autorisation");  
		}
		
			
//*********************RESET SESSION START DATE*************
$_SESSION['LAST_ACTIVITY']=time();		
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