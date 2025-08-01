<?php   

	//$idpage=59;
	//Session check****************************
	//include_once("session_check.php");
	include_once("php/function.php");
	include_once("php/function_sendsms.php");

	if ($_SERVER['PHP_SELF'])
	{
		//echo "<br> - Activer";
		$text = "";
		$titre_param = "module_souhait_statut";
		$statut_from_parametre = get_param_souhait($titre_param);

		$telephone="";
		$messages_souhait = get_message_anniv_data();
		echo "<br> - ".$statut_from_parametre['valeur'];
		if($statut_from_parametre['valeur'] == 'activer')
		{
			echo "<br> - Activer";
			//****************VERIFICATION RESTRICTION STATUT*********************//
			$titre_param = "restrict_reception_statut_souhait"; 
			$statut_from_parametre =  get_param_souhait($titre_param);

			$day = explode("-", date('Y-m-d'));
			$req_anniversaire = "SELECT DISTINCT idt_dossier, statut_dossier, date_naissance, identite, email, numero_telephone FROM t_dossier WHERE deletion_statut=0 AND MONTH(date_naissance)='".$day[1]."' AND DAY(date_naissance)='".$day[2]."' AND statut_dossier not in ('".str_replace(",","','",$statut_from_parametre['valeur'])."')";


			//****************VERIFICATION RESTRICTION SMS*********************//
			$titre_param = "restrict_sms_send_souhait"; 
			$statut_from_parametre_sms =  get_param_souhait($titre_param);

			$sql = $bdd->query($req_anniversaire);
			$count_msg=0;
			$count_mail=0;

			$count_msg_add_action = 0;
			$count_mail_add_action = 0;
			
			while($data = $sql->fetch())
			{
			
				$statut_dossier = $data['statut_dossier'];
				$strpos = strpos($statut_from_parametre_sms['valeur'], $statut_dossier);
				echo "<br>".$data['identite'];
				if(validEmail($data['email']))
				{
					echo " | Envoie Mail ";
					$to_destination=$data['email'];
					$text_message =str_replace("@identite",$data['identite'],$messages_souhait['txt_mail']);
					$sujet=$messages_souhait['sujet'];
							        
					$mail_send = include("send_mail_bulk.php");
					$count_mail++;
					$count_mail_add_action = ($mail_send == 1) ? "1" : "0";			
				}

				if ($strpos === false)
				{
					echo " | numero  ";
					$telephone = $data['numero_telephone'];
					$telephone = str_ireplace("(", "", $telephone);
					$telephone = str_ireplace(")", "", $telephone);
					$telephone = str_ireplace("-", "", $telephone);
					$telephone = str_ireplace("_", "", $telephone);
					$telephone = trim(str_ireplace(" ", "", $telephone));
					echo " | numero  ".$telephone;
					if(strlen($telephone)>=12)
					{
						echo " | Envoie SMS ";
						$text_message =str_replace("@identite",$data['identite'],$messages_souhait['txt_sms']);
						
					    $sms_send = send_sms($telephone, $text_message, "PASSPORT", "NA", "User", "NA");
						$telephone="";		 
					 	$count_msg ++;
					 	$count_msg_add_action = ($sms_send == 1) ? "1" : "0";
					}

				}
			
				add_action_info($data['idt_dossier'], 118, "", "", "", "", "Valide", "system", "Oui", "", $count_msg_add_action, $count_mail_add_action);
				

			}

			add_notification("t_message_souhait",1,"Nbr SMS : ".$count_msg."","Nbr MAIL :".$count_mail." ",'system',"Message Souhait Anniversaire");
			send_sms("243814444577", "Rapport Souhait Anniversaire du ".date("d-m-Y").". Nbre SMS = ".$count_msg." | Nbre Mail = ".$count_mail, "PASSPORT", "NA", "User", "NA");
			send_sms("243815734275", "Rapport Souhait Anniversaire du ".date("d-m-Y").". Nbre SMS = ".$count_msg." | Nbre Mail = ".$count_mail, "PASSPORT", "NA", "User", "NA");
	}

}


?>
