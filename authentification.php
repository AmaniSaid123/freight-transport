<?php
//******************************************************
//************Fonction**********************************
//******************************************************
include_once("php/function.php");

if(isset($_POST['valider']) && isset($_POST['login']) && isset($_POST['login']) && $_POST['login']!="" && $_POST['pwd']!=""){
include("param.php");
$use_username= addslashes(htmlspecialchars($_POST['login']));

$use_mdp=addslashes(htmlspecialchars($_POST['pwd'])); 
 
 
//Ex&eacute;cution de la requete**************************************************


$resultat=$bdd->query("select count(*) as valide,v.name as profile,idprofile,t.* from t_user t join t_profile v on ref_profile=idprofile where username='".$use_username."' and password='".$use_mdp."' and status='a' group by username");
$donnee=$resultat->fetch();


echo "select count(*) as valide,v.name as profile,idprofile,t.* from t_user t join t_profile v on ref_profile=idprofile where username='".$use_username."' and password='".$use_mdp."' and status='a' group by username";
if ($donnee['valide']==1)
{
session_start(); // On d&eacute;marre la session AVANT toute chose

$data_taux=get_taux();
$msg_caisse="";
$_SESSION['my_username'] = strtolower($use_username);
$_SESSION['my_time']=strtolower(date('H:i:s d/m/Y'));
$_SESSION['my_firstname'] = $donnee['firstname'];
$_SESSION['my_userId'] = $donnee['iduser'];
$_SESSION['my_lastname'] = $donnee['lastname'];
$_SESSION['my_user_picture'] = $donnee['url_picture'];
$_SESSION['my_profile']=$donnee['profile'];
$_SESSION['my_idprofile']=$donnee['idprofile'];
$_SESSION['is_agent']=($donnee['idprofile']==2 ? '1' : '0');
$_SESSION['my_zone1']=0;
$_SESSION['my_zone2']=0;
$_SESSION['my_zone3']=0;
$_SESSION['my_agence']=$donnee['ref_agence'];



$_SESSION['my_taux']=$data_taux['valeur'];
$_SESSION['my_id_taux']=$data_taux['id_taux'];



$_SESSION['my_m_profile']="NA";
$_SESSION['my_m_procedure']="NA";
$_SESSION['my_m_user']="NA";
$_SESSION['my_m_dossier']="NA";
$_SESSION['my_m_dossier_ligne']="NA";


$_SESSION['my_m_lock']="NA";



$retour=update_user_lastlogon($use_username);

if($retour>0){
add_notification("t_user",$use_username,"Connexion ","Connexion ",$use_username,"Connexion a MyPASS");	


			
		//header("Location:home.php?erreur=0&fst=0x001&msg=".crypt($use_mdp)."--".$data_caisse_user['delai']);	
		header("Location:home.php?erreur=0&fst=0x001");	
	

//header("Location:starter.html");
}else{
header("Location:index.php?try=ok&tri=2&idr=1");

}

// echo 'sa marche';
}else 
{
header("Location:index.php?try=ok&tri=2&idr=2");
//echo "okkkkk  2";


}


}
?>
