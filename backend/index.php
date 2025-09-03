  <?php
		if(isset($_SESSION['username']))
		{
			session_destroy();
			}
			
			
		
	?>




<!doctype html> 
<html>
	<head>
	<title>MyPASS Portal</title> 
	<link rel="stylesheet" href="css/Site.css"/>
	<link rel="icon" type="image/png" href="images/logo.png" />
	<style type="text/css">
<!--
.Style6 {color: #000000}
-->
    </style>
	</head>

	<body>
		<center>
		<header>
		<div></div>
		
		</header>
		
		<div id="welcome_box">
		<div id="bloc_entete">	<p>
		<h2>MyPASS Portal</h2>
		</p></div>
		<p>
<form method="post" action="authentification.php">
	

<p><table>
<tr>
	<td class="connexion"><span class="Style6">Login</span></td>
	<td class="connexion"><input type="text" name="login"></td>
</tr>
<tr>
	<td class="connexion"><span class="Style6">Mot de passe</span></td>
	<td class="connexion"><input type="password" name="pwd"></td>
</tr>
</table>

</p>
<center><p>
<input type="submit" value="Valider" name="valider">
</center>

</form>
		</div>
		
	<?php
	if(isset($_GET['try']) and $_GET['try']=='ok'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Mot de Passe ou nom d\'utilisateur incorrect");';
			echo "</SCRIPT>";
			
			}
	
	if(isset($_GET['error']) and $_GET['error']=='login'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Veuillez vous reconnecter d\'abord");';
			echo "</SCRIPT>";
			
			}
			
	if(isset($_GET['error']) and $_GET['error']=='inactivity'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Votre Session a pris fin pour non utilisation au dela de 3 heures");';
			echo "</SCRIPT>";
			
			}
if(isset($_GET['error']) and $_GET['error']=='autorisation'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Votre profile n\' a pas le droit d\'acceder a cette page, Reconnectez-vous!");';
			echo "</SCRIPT>";
			
			}

if(isset($_GET['error']) and $_GET['error']=='acces_caisse'){
			
			echo "<SCRIPT LANGUAGE='Javascript'>";
			echo 'alert("Désolé vous devez avoir un accès caisse pour acceder à cette page, Reconnectez-vous!");';
			echo "</SCRIPT>";
			
			}						
	
	
	?>	
	
    
		
		</center>
	</body> 
</html>