<?php



if(isset($to_destination) && $data_dossier['is_exist']==1 && isset($sujet) && validEmail($to_destination)){
// multiple recipients
$to  = $to_destination; // note the comma
//$to .= 'xydelprice@gmail.com';

// subject
$subject = $sujet.' : '.$data_dossier['ndel'];

// message
$message = '
<html>
<head>
  <title>Création Dossier chez Passport SARL </title>
</head>
<body><p align="center">  <font color="midnightblue">  
<img src="https://mypass.passportsarl.voyage/images/logo_passport.png" width="212" height="171" />
<p>Votre dossier a ete cree avec succes.</p>
Nous avons bien recu les elements de votre dossier dans votre portail MyPASS et nous vous contacterons incessamment. <br><br>
<B>Bonjour '.$identite.'</B><br>
Pour vous connecter, suivre l\'evolution de vos demarches dans le "Journal du Dossier" ou pour modifier ou completer les informations que vous venez de fournir, merci d\'utiliser votre Numero d\'Identification du Dossier (NID) ainsi que votre PIN SECRET ci-dessous : <br><br>
<b>
NID : '.$data_dossier['ndel'].'<br>
Pin secret : '.$data_dossier['pin_secret'].'
</b><br><br>
Si ce n\'est pas encore fait, priere de vous reconnecter dans votre dossier pour televerser les documents exigEs selon la fiche des conditions concernant la destination que vous venez de choisir (vous pouvez voir les conditions de toutes nos destinations dans la rubrique <a href="https://passportsarl.voyage/#services">"Nos Services"</a> de notre site internet).
<br><br>Lorsque vous serez assiste(e) par l\'un de nos agents au telephone ou au bureau, nous vous prions de nous dire vos remarques positives ou negatives sur la maniere dont vous avez ete servi(e) afin de nous aider a nous ameliorer en nous ecrivant sur votreavis@passportsarl.voyage 
<br><font color="RED">Sentez-vous surtout a l aise de tout dire.</font>
<br><br>Sachez que la creation de votre dossier en ligne materialise votre adhesion a <a href="https://passportsarl.voyage/MyPASS/privacy_page.php">nos Conditions Generales</a> de Fonctionnement que vous pouvez relire <a href="https://passportsarl.voyage/MyPASS/privacy_page.php">ici</a>.

<br><br><br>
<a href="https://mypass.passportsarl.voyage/authentification-user.php">Aller au portail MyPass</a><br>
<a href="https://passportsarl.voyage">Cliquez ici pour aller au site</a><br>


    
Merci d\'avoir choisi PASSPORT Sarl, l\'Architecte des Voyages sur Mesure !<br><br>

PASSPORT SARL <br>   
Architecte des Voyages sur Mesure <br>   
__ <br>   
Horaire de Service <br>   
De 08h30 à 16h30, du lundi à vendredi, <br>   
De 08h45 à 13h00 le samedi <br>   

__<br>   
ADRESSES <br>   

Siège National à Kinshasa : <br>   
14, Avenue Sergent Moke, Commune de Ngaliema, Kinshasa <br>   
A l\'intérieur de la concession SAFRICAS, proche du Rond-point Haute Cour Militaire/GB. <br>   
+243 82 7000 755  <br>  
__ <br>   
Bureau de Lubumbashi : <br>   
Bâtiment Hypnose 2ème Niveau <br>   
826, Avenue Mama Yemo, Ville de Lubumbashi <br>   
+243 82 6999 755 / +243 97 0639 702 <br>   
__ <br>   
Contact uniquement pour les dossiers déjà en cours de traitement : <br>   
+243 82 7000 776 <br>   
admin@passportsarl.voyage <br> 

</font>
</p>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'From: PassportSarl <noreply@passportsarl.voyage>' . "\r\n";
$headers .='Content-Type: text/html; charset="UTF-8"'."\n";
$headers .='Content-Transfer-Encoding: 8bit';
$headers .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n";

// Additional headers
//$headers .= 'To: Lionel <lionlok.and@gmail.com>, Kelly <xydelprice@gmail.com>' . "\r\n";

//$headers .= 'Cc: birthdayarchive@eyano.com' . "\r\n";
//$headers .= 'Bcc: birthdaycheck@eyano.com' . "\r\n";
$clean_message = stripslashes ($message);

// Mail it
//echo $message;
$envoie_mail= mail($to, $subject, $clean_message, $headers);

}

//echo file_get_contents($_GET['page_cible']);
?>

