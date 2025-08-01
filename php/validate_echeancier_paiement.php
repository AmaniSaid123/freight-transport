<?php

if(isset($_POST['submit_add_paiement_valid']) && isset($_POST['idt_rmb_selectionner']) &&  $_POST['idt_rmb_selectionner']!=''){

$data_compte_credit=get_membre_credit_data($_SESSION['my_m_credit']);
$idt_all=$_POST['idt_rmb_selectionner'];
for($k=1;$k<=$data_compte_credit['echeance_valide'];$k++){
	
	if(isset($_POST['chk_box'.$j])){
	
$data_credit_echeancier=get_credit_echeancier_data_next($_SESSION['my_m_credit'],$k);

$error_message="";
$success_message="";
//echo "ghhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh : OK";
$commission_is_ok=0;
$commission=0;

$idt_echeancier=$data_credit_echeancier['idt_echeancier'];

$data_credit_echeancier_next=get_credit_echeancier_data_next($_SESSION['my_m_credit'],$data_credit_echeancier['rang_echeance']+1);
$idt_credit=$data_credit_echeancier['ref_credit'];
$data_compte_credit=get_membre_credit_data($idt_credit);

$montant=0;

$label_action="";
$ref_type_compte=11;


//******************************Variables*************
$credit_principal=$data_credit_echeancier['montant_credit'];
$credit_interet=$data_credit_echeancier['montant_interet'];
$credit_rembourser=$data_credit_echeancier['echeance_credit_rembourser'];
$interet_rembourser=$data_credit_echeancier['echeance_interet_rembourser'];
$montant_credit_reporter=$data_credit_echeancier['credit_heriter'];
$montant_interet_reporter=$data_credit_echeancier['interet_heriter'];
$credit_a_payer=$_POST['credit_pay'.$k];
$interet_a_payer=$_POST['interet_pay'.$k];
$retard=$data_credit_echeancier['retard'];
$montant_commission=$_POST['commission_pay'.$k];
$penalite=$_POST['penalite_pay'.$k];

$action_on_credit=0;
//echo "Credit à payer : ".$credit_a_payer." -- Interet : ".$interet_a_payer;
//echo "Commission : ".$montant_commission." -- penalite : ".$penalite;

for($j=1;$j<=4;$j++){
// echo "cherche : ".$j;
$can_passe=0;
$commission=0;
$data_compte_all=0;
$montant=0;
$code_transaction="";
$ref_operation=0;
mysql_close();
$data_compte_all=get_membre_rmb_data($idt_all);
$solde_rmb=$data_compte_all['solde'];
switch ($j) {
      case 1:
		 //echo "cherche : ".$j;
		//echo "---1--- aaaaaaaaaaaaaaaa : ".$interet_a_payer." bbb : ".$montant."  ccccc :".$data_compte_all['solde']." dddd : ".(floatval($data_compte_all['solde'])>=floatval($interet_a_payer));

		$code_operation='Remboursement Interet C.Ind - RMB';
		$ref_operation=57;		
//		$data_compte_all=get_membre_rmb_data($idt_all);
		$code_transaction="ri-cre".time()."-".$data_compte_credit['idt_credit_ind'];	
//		$montant=$interet_a_payer;					
		$montant=(floatval($data_compte_all['solde'])>=floatval($interet_a_payer)) ? $interet_a_payer : $data_compte_all['solde'];
		$label_action="Interet";	
		$can_passe=($interet_a_payer>0 && $data_compte_all['solde']>0) ? 1 : 0;
        break;
		
	case 2:
        $code_operation='Paiement penalite C.Ind - RMB';
		$ref_operation=58;		
	//	$data_compte_all=get_membre_rmb_data($idt_all);
		$code_transaction="rp-cre".time()."-".$data_compte_credit['idt_credit_ind'];	
//		$montant=$penalite;			
		 //echo "cherche : ".$j;
  		

		$montant=(floatval($data_compte_all['solde'])>=floatval($penalite)) ? $penalite : $data_compte_all['solde'];
		//echo "---2--- aaaaaaaaaaaaaaaa : ".$penalite." bbb : ".$montant."  ccccc :".$data_compte_all['solde']." dddd : ".(floatval($data_compte_all['solde'])>=floatval($penalite))." eeeeee : ".($data_compte_all['solde']>0)." fffff : ".($penalite>0);
		//echo "aaaaaaaaaaaaaaaa : ".$penalite." bbb : ".$montant."  ccccc :".$data_compte_all['solde']." dddd : ".(floatval($data_compte_all['solde'])>=floatval($penalite));
		$label_action="Penalite";		
		$can_passe=($penalite>0 && $data_compte_all['solde']>0) ? 1 : 0;
        break;
	case 3:
        
		$code_operation='Remboursement Dette C.Ind - RMB';
		$ref_operation=56;
		 //echo "cherche : ".$j;
		 //echo "---3--- aaaaaaaaaaaaaaaa : ".$credit_a_payer." bbb : ".$montant."  ccccc :".$data_compte_all['solde']." dddd : ".(floatval($data_compte_all['solde'])>=floatval($credit_a_payer));
		//$data_compte_all=get_membre_rmb_data($idt_all);
		$code_transaction="rd-cre".time()."-".$data_compte_credit['idt_credit_ind'];	
		$montant=(floatval($data_compte_all['solde'])>=floatval($credit_a_payer)) ? $credit_a_payer : $data_compte_all['solde'];
		//	echo "------------aaaaaaaaaaaaaaaa : ".$credit_a_payer." bbb : ".$montant."  ccccc :".$data_compte_all['solde']." dddd : ".(floatval($data_compte_all['solde'])>=floatval($credit_a_payer));
		$label_action="Credit";
		
		$can_passe=($credit_a_payer>0 && $data_compte_all['solde']>0) ? 1 : 0;
        break;
  
	case 4:
        $code_operation='Paiement Commission epargne C.Ind - RMB';
		$ref_operation=59;		
		//$data_compte_all=get_membre_rmb_data($idt_all);
		$code_transaction="rc-cre".time()."-".$data_compte_credit['idt_credit_ind'];	
//		$montant=$montant_commission;				
		// echo "cherche : ".$j;
		$montant=(floatval($data_compte_all['solde'])>=floatval($montant_commission)) ? $montant_commission : $data_compte_all['solde'];
		$label_action="Commission";		
		$can_passe=($montant_commission>0 && $data_compte_all['solde']>0) ? 1 : 0;		
        break;
	default:
        $code_operation="NA";
        
}	

//$texte="".json_encode($data_compte_all)." -- montant : ".$montant." -- Commision :".$commission." EAT : ".json_encode($data_compte_eat)." SOlde 2 ".$data_compte_all['solde'];



if($can_passe==1 && $data_compte_all['ref_devise']==$data_compte_credit['ref_devise'] && floatval($data_compte_all['solde'])>=floatval($montant) ){
	
	 //echo "Can passe : ".$j;
	 
	 			

$feedback_transaction=add_transaction_with_detail($ref_type_compte,$data_compte_credit['ref_devise'],$montant,"Agence web",0,0,0,$code_transaction,"valide",$data_compte_credit['ref_membre'],$idt_credit,$ref_operation,$code_operation,0,$data_compte_credit['idt_credit_ind'],'C.Ind','Paiement Credit');

//****************
add_transaction($ref_type_compte,$data_compte_all['ref_devise'],$montant,"Agence web",0,0,0,$code_transaction."*","valide",$data_compte_all['ref_membre'],$idt_all,$ref_operation,$code_operation,$data_compte_all['solde'],$data_compte_all['numero_compte'],'RMB Credit');

//*************************


			if($feedback_transaction==1){
				
				//****************
				//echo "ghhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh : OK3 ";
				$feedback_ea_all=0;
				$feedback_ea_all=update_retrait_rmb($idt_all,$montant,"Paiement ".$label_action." : ".$montant." ".$data_compte_all['ref_devise']." : Fait ");	
				$val_operation_echeance=0;
				$val_operation_credit=0;
				//*************************
				$action_on_credit=0;
				if($feedback_ea_all==1){
					
				  switch ($j) {
					 case 1:
				
						$val_operation_echeance=make_paiement_interet_echeance($idt_echeancier,$montant);
						$val_operation_credit=make_paiement_credit($idt_credit,0,$montant);
						$error=($val_operation_echeance==0) ? "yes" : "";
						$success=($val_operation_echeance==1) ? "yes" : "";	
						
						$success_message=($val_operation_echeance==1) ? $success_message." <br>Echeance ".$j." : ".$data_credit_echeancier['date_paiement']." Paiement Interet (".$val_operation_echeance.") : ".$montant." ".$data_compte_credit['ref_devise']." a reussi" : $success_message;
						
						$error_message=($val_operation_echeance!=1) ? $error_message." <br>Echeance ".$j." : ".$data_credit_echeancier['date_paiement']." Paiement Interet principal (".$val_operation_echeance.") : ".$montant." ".$data_compte_credit['ref_devise']." a échoué" : $error_message;
						
						$action_on_credit++;
						break;
					 case 2:
						
						$val_operation_echeance=make_paiement_penalite_echeance($idt_echeancier,$montant);
						$error=($val_operation_echeance==0) ? "yes" : "";
						$success=($val_operation_echeance==1) ? "yes" : "";
						
						$success_message=($val_operation_echeance==1) ? $success_message." <br>Echeance ".$k." : ".$data_credit_echeancier['date_paiement']." Paiement Penalité(".$val_operation_echeance.") : ".$montant." ".$data_compte_credit['ref_devise']." a reussi" : $success_message;
						
						$error_message=($val_operation_echeance!=1) ? $error_message." <br>Echeance ".$k." : ".$data_credit_echeancier['date_paiement']." Paiement Pénalité (".$val_operation_echeance.") : ".$montant." ".$data_compte_credit['ref_devise']." a échoué" : $error_message;
						$action_on_credit++;						
						
						break; 
					
					case 3:
						
						$val_operation_echeance=make_paiement_credit_echeance($idt_echeancier,$montant);
						$val_operation_credit=make_paiement_credit($idt_credit,$montant,0);
						$success_message=($val_operation_echeance==1) ? $success_message." <br>Echeance ".$k." : ".$data_credit_echeancier['date_paiement']." Paiement credit principal (".$val_operation_echeance.") : ".$montant." ".$data_compte_credit['ref_devise']." a reussi" : $success_message;
						
						$error_message=($val_operation_echeance!=1) ? $error_message." <br>Echeance ".$k." : ".$data_credit_echeancier['date_paiement']." Paiement credit principal (".$val_operation_echeance.") : ".$montant." ".$data_compte_credit['ref_devise']." a échoué" : $error_message;
						
						$error=($val_operation_echeance==0) ? "yes" : "";
						$success=($val_operation_echeance==1) ? "yes" : "";
				$action_on_credit++;						
						break;
					
					
					case 4:
					
						$val_operation_echeance=make_paiement_commission_echeance($idt_echeancier,$montant);
						$error=($val_operation_echeance==0) ? "yes" : "";
						$success=($val_operation_echeance==1) ? "yes" : "";
											
						$success_message=($val_operation_echeance==1) ? $success_message." <br>Echeance ".$k." : ".$data_credit_echeancier['date_paiement']." Paiement Commission(".$val_operation_echeance.") : ".$montant." ".$data_compte_credit['ref_devise']." a reussi" : $success_message;
						
						$error_message=($val_operation_echeance!=1) ? $error_message." <br>Echeance ".$k." : ".$data_credit_echeancier['date_paiement']." Paiement Commission (".$val_operation_echeance.") : ".$montant." ".$data_compte_credit['ref_devise']." a échoué" : $error_message;
						
						$action_on_credit++;								
						break;
					default:
						$code_operation="NA";
						
				}	

					
					
					}
			
			$feedback_ea_all=($feedback_ea_all==1)  ? update_paiement_credit($idt_credit,$montant,"Paiement ".$label_action." : ".$montant." ".$data_compte_all['ref_devise']." : Fait ") : 0;
							
			
							if($action_on_credit==1){
								//echo "select * from t_ecriture where ref_operation=".$ref_operation."<br>";
							$sql_ecriture=mysql_query("select * from t_ecriture where ref_operation=".$ref_operation);
							$feedback_livre=0;
												while($data_ecriture=mysql_fetch_array($sql_ecriture))
													{
														
														$montant_final=($data_compte_all['ref_devise']=='CDF') ? $montant : $montant*$_SESSION['my_taux'];
														$montant_usd=($data_compte_all['ref_devise']=='USD') ? $montant : 0;
														
														$montant_cdf=($data_compte_all['ref_devise']=='CDF') ? $montant : 0;
														
														$montant_final_commission=($data_compte_all['ref_devise']=='CDF') ? $commission : $commission*$_SESSION['my_taux'];
														$montant_usd_commission=($data_compte_all['ref_devise']=='USD') ? $commission : 0;
														
														$montant_cdf_commission=($data_compte_all['ref_devise']=='CDF') ? $commission : 0;
														
														
														if($data_ecriture['action']=='D')
														{
															$data_compte_parent=get_livre_compte_data($data_ecriture['ref_compte']);
															$feedback_livre=add_in_grand_journal($data_ecriture['ref_compte'],$data_compte_all['ref_devise'],0,$montant,$data_compte_parent['credit_final'],$data_compte_parent['debit_final'],$data_compte_parent['solde_final'],$code_transaction,"web operation",$data_compte_all['ref_membre'],$idt_credit,$ref_operation,$code_operation);	
															update_livre_compte_debit($data_ecriture['ref_compte'],$montant_final,$montant_usd,$montant_cdf);		
														}
														
														if($data_ecriture['action']=='C')
														{
															$data_compte_parent=get_livre_compte_data($data_ecriture['ref_compte']);
															$feedback_livre=add_in_grand_journal($data_ecriture['ref_compte'],$data_compte_all['ref_devise'],$montant,0,$data_compte_parent['credit_final'],$data_compte_parent['debit_final'],$data_compte_parent['solde_final'],$code_transaction,"web operation",$data_compte_all['ref_membre'],$idt_credit,$ref_operation,$code_operation);		
																		update_livre_compte_credit($data_ecriture['ref_compte'],$montant_final,$montant_usd,$montant_cdf);	
														}
													
													update_livre_compte_solde($data_ecriture['ref_compte']);	
													}
							
				if($feedback_transaction==1 && $feedback_ea_all==1 && $feedback_livre>=1){

								
						$success="yes";
						$success_message=$success_message."<br>--Paiement ".$label_action." de ".$montant." ".$data_compte_all['ref_devise']." via le compte RMB : ".$data_compte_all['numero_compte']."  effectué avec succès, Reference crédit : ".$data_compte_credit['code_credit'];


						/*$re = '/^[081,082,089,085,084,090,097,099,098,080][0-9]{9}/';
						$text="Transfert RMB dans : ".$data_compte_rmb['numero_compte']." du compte ".$choosed_compte." : ".$data_compte_all['numero_compte'].", Montant : ".$montant." ".$data_compte_rmb['ref_devise'].", le ".date("d-M-Y H:i:s")." Ref:".$code_transaction;
						
						if(preg_match($re,$data_compte_rmb['telephone'])){
							
						send_sms('243'.substr($data_compte_rmb['telephone'],1,9),$text,"GUILGAL",$data_compte_rmb['numero_compte'],"System","RMB");

						$warning="yes";
						$warning_message="SMS Envoyé";

							
							}else{
								
								$warning="yes";
								$warning_message="SMS Non Envoyé, Pas de numéro ou numéro pas correct";
								
								}
*/
						
						//refresh_flux_solde_caisse_sortie($_SESSION['my_caisse_open'],$montant_cdf+$montant_cdf_commission,$montant_usd+$montant_usd_commission);
						
			
					
					}else{
						
						$error="yes";
						$error_message="Une erreur a survenue lors du paiement, Transact=".$feedback_transaction." /  code=".$feedback_ea_all." / Livre de compte=".$feedback_livre;
						
				}

									
								
							}
								
			}else{

				$error="yes";
				$error_message=$error_message."<br> Une erreur a survenue lors  du Paiement de crédit";
	
				}

   }else{
	   
	// 		echo "ghhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh : OK 2";			
			
			
			
			
			
	   
	   }
	   

	   
  }//End For
  $success="yes";
  $success_message=$success_message."<br>Actualisation des Crédits : ".update_credit_data($_SESSION['my_m_credit']);
  
      }
	}
}else{//End IF 1
	
	//echo "ghhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh : OK 1";
	if(isset($_POST['submit_credit']) && (!isset($_POST['idt_rmb']) || !isset($_POST['idt_credit']))){
		
		$error="yes";
		$error_message="Une erreur a survenue lors  du depot RMB, le montant n'est pas correct, egale à zero ou le solde est inférieur";
		
		}
		
		
}

?>