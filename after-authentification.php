<?php
//******************************************************
//************Fonction**********************************
//******************************************************
include_once("php/function.php");

if((isset($_POST['btn_valider']) && isset($_POST['nid_client']) && isset($_POST['nid_client']) && $_POST['nid_client']!="" && $_POST['pin_secret']!="") || (isset($_GET['pin_secret']) && isset($_GET['nid_client']))){
include("param.php");

$use_username=(isset($_POST['nid_client'])) ? addslashes(htmlspecialchars($_POST['nid_client'])) : addslashes(htmlspecialchars($_GET['nid_client']));
$use_mdp= (isset($_POST['pin_secret'])) ? addslashes(htmlspecialchars($_POST['pin_secret'])) : addslashes(htmlspecialchars($_GET['pin_secret'])); 
 
//Ex&eacute;cution de la requete**************************************************
//echo "select count(*) as valide,t.* from t_dossier  where nid_pp='".$use_username."' and pin_secret='".$use_mdp."'";

$resultat=$bdd->query("select count(*) as valide,t.* from t_dossier t  where (nid_pp='".$use_username."' or ndel='".$use_username."') and pin_secret='".$use_mdp."' and statut_dossier not in ('Clos_reussi','Clos_echec','Clos_Abandon','	
Paiement_incomplet') group by idt_dossier");
$donnee=$resultat->fetch();

if ($donnee['valide']==1)
{
session_start(); // On d&eacute;marre la session AVANT toute chose


$_SESSION['my_doc_online'] = $donnee['idt_dossier'];
$_SESSION['username_online'] = "online_user";
$_SESSION['sessionstarttime_online']=strtolower(date('H:i:s d/m/Y'));

//$retour=update_user_lastlogon($use_username);

if(1){
$emojie = "\u{1F600}";
add_notification("t_dossier",$use_username,"Connexion ","Connexion ",$use_username,"Connexion a MyPASS Online");	
    $message=(isset($_GET['msg'])) ? $_GET['msg'] : "Vous etes connecté à votre compte";
    if(isset($_POST['pin_secret'])){
	header("Location:modification-dossier.php?msg=".$message."&success=ok");	
    }else{
        header("Location:modification-dossier.php?msg=".$message."Votre dossier est créé avec succès $emojie, Un mail avec des directives importantes vous a également été envoyé !"."&success=ok");
        
    }
//header("Location:starter.html");
}else{
//header("Location:login.php?try=ok&tri=2&idr=1");

}

// echo 'sa marche';
}else 
{
header("Location:login.php?try=ok&tri=2&idr=2");
//echo "okkkkk  2";


}


}
?>