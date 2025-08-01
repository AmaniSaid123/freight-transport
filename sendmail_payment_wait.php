<?php
if (isset($to_destination) && isset($sujet) && validEmail($to_destination)) {

  $to = $to_destination;
  // subject
  $subject = $sujet;

  // message
  $message = '
<html>
<head>
<title>Un message de la part Passport SARL </title>
</head>
<body><p align="center">  <font color="midnightblue">
<img src="https://mypass.passportsarl.voyage/images/logo_passport.png" width="212" height="171" />
 

<p align="center">  Bonjour  ' . $data_dossier_temp['identite'] . '</p><br><br>

Veuillez conserver ce code unique référence de ce paiement dans le but des vérifications éventuelles auprès de PASSPORT SARL : '.$codeT.'<br>
' . $text_message . '<br>
<b>
NID : '.$data_dossier_temp['ndel'].'<br>
Pin secret : '.$data_dossier_temp['pin_secret'].'</b><br>
    
' . $text_content . '


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
10ème Niveau, Immeuble DIKIN TOWER <br>
144B, Boulevard du 30 Juin. Kinshasa/Gombe. Réf. : Immeuble FINI ONE & NAWAL, au milieu de Batetela et Royal. <br>
+243 82 7000 755 / +243 85 0050 755 <br>
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
  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'From: PassportSarl <noreply@passportsarl.voyage>' . "\r\n";
  $headers .= 'Content-Type: text/html; charset="UTF-8"' . "\n";
  $headers .= 'Content-Transfer-Encoding: 8bit';
  $headers .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n";


  $clean_message = stripslashes($message);
  // Mail it
//echo $message;
  $envoie_mail = mail($to, $subject, $clean_message, $headers);


}
