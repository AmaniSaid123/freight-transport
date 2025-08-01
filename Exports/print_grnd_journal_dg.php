<?php  
	
	/*$phpWord = new PhpOffice\PhpWord\PhpWord;

	$section = $phpWord->addSection();

	header('Content-type: application/octet-stream');
	header('Content-Disposition: attachment;filename="Etats_financiers_MyPASS.doc"');

	$objWriter = \PhpWord\IOFactory::createWriter($phpWord, "Word2007");
	$objWriter->save('php://output');*/

	//require_once(\);

	 $idpage=9;
	 include_once("../php/session_check.php");
	 include_once("../php/function.php");

	 $export_action = "";

	 if(isset($_GET['print_word']) && $_GET['print_word']=='valid' && !$_SESSION['daterange'] == "")
	 {
	 	$limit=" ";

	 	$tempo=explode("-",$_SESSION['daterange']);
        $date_debut=trim($tempo[0]);
        $date_fin=trim($tempo[1]);

	 	$export_action  = 
	 			header("Content-type: application/vnd.ms-word");
	 			header("Content-Disposition: attachment;Filename=Etats_financiers_My.doc");

	 			echo "<html>";
				echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
	 			echo "<body>";
	 			echo "
	 				<div>
						<h1><b>PASSPORT sarl</b></h1>
						<h4>CD/KNG/RCCM/18-B-01378</h4>
						<h4>Id. Nat. : 01-9-N37238M</h4>
	 					<h4>Numero Impot : A1820041E</h4>
	 					<hr>
	 					<center><h2>ETATS FINANCIERS : DU ".$date_debut." AU ".$date_fin."</h2></center>
 					<hr>
					</div>
					<!--<div style='float: right;'><img src='../images/logo2.jpg' alt='Passport logo' style='float: right;'></div>-->
	 			";
	 			echo "<div style='width: 100%; height: 5; background-color: #343a40;'></div>";
	 			echo '<table cellpadding="0" cellspacing="3" border="0" width="100%">';
	 			echo '	<tr style="background-color: #343a40; color: white">
	 						<th>N°</th>
	 						<th>DATE DE <br> CREATION</th>
	 						<th>AGENCE</th>
	 						<th>OPERATIONS</th>
	 						<th>TRANSACTION </th>
	 						<th>COMPTE</th>
	 						<th>ENTREES</th>
							 <th>SORTIES</th>
							 <th>SOLDE CDF</th>
	 						<th>SOLDE USD</th>
	 						
	 						
	 					</tr>';

	 		        $sql_select1 = "select t.*, t_livre_compte.label, identite, t_agence.label as agence from t_grand_journal t join t_livre_compte on (ref_compte=account_no and ref_agence_action=t_livre_compte.ref_agence) left join t_dossier on idt_dossier=ref_id_source join t_agence on ref_agence_action=id_agence ".$_SESSION['_req']." order by id_grand_journal DESC ".$limit;
	 		        $sql_result1 = mysqli_query($bdd_i,$sql_select1);
	 		                      		 //echo $sql_select1;
	 		        $index=0;
	 		        while($data1 = mysqli_fetch_array($sql_result1)){
	 		        $index++;	  		
	 		        ?>	
	 		        <tr  style="background-color: #eee;"border="5" >
	 		                            <td><?php	echo $index ;?></td> 
 		                            	<td><?php	echo $data1['creationdate'] ;?></td> 
	 		                            <td><?php	echo $data1['agence'] ;?></td> 
	 		                            <td><?php	echo $data1['code_operation'] ;?></td>
			                            <td><?php	echo $data1['ref_transaction'] ;?></td>	
	 		                            <td><?php	echo $data1['ref_compte']." ".$data1['label'];?></td>                      
	 		                            
	 		                            <td align="righ"><?php	echo $data1['debit_action'] ;?></td>
										 <td align="righ"><?php   echo $data1['credit_action'];?></td>
										 <td align="righ"><?php	echo $data1['solde_parent']." Fc" ;?></td>
	 		                            <td align="righ"><?php	echo round($data1['solde_parent']/$_SESSION['my_taux'],0)." $" ;?></td>
 		                            		                         
	 		                            
			                                                                        
	 		                 </tr>
			                
				
 			<?php      } 
				
				 			        

	 			echo '</table>';
	 			echo "</body>";
				echo "</html>";
		;


	 	if(!$export_action == false)
	 	{

	 		header("Location: print_done.php");

	 	}else{

	 		// $error="yes";
	 		// $error_message="Un problème s'est produit lors de l'exportation du Grand Journal.";

	 		header("Location: ../grand_journal_dg.php");
	 	}


	 }else{

	 	header('Location: ../grand_journal_dg.php');
    }

?>