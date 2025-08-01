<?php
	//******************IDPAGE*****************
        //$require_caisse=1;
	$idpage=43;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	
	//*********************Get Profile Data*****
	$set_pluggin_datatable="yes";
	$set_pluggin_selection_wise="yes";	
	$set_plugin_daterange="yes";
//***********************Find Profile****************
//*************************Selection des informations du profile************************

$get_active_menu="op-oe";
	$page_titre="Ordre de Paiement";
	$page_small_detail="MyPASS";
	$page_location="Gestions des OP-OE > Ordre de Paiement";

//****************location******************
	
$param_search1=" and date(t.creationdate)=date(now())";
$daterange="";
$statut="";


if (isset($_POST['submit_operation']) && $_POST['montant'] != "" && $_POST['montant'] != "") {

	$code_transaction = "OC-" . time();

	$montant = clean_in_double($_POST['montant']);
	$libelle = clean_in_text($_POST['libelle']);
	$data_operation = get_operation_data($_POST['ref_operation']);
	$ref_operation = $data_operation['idt_operation'];
	$code_operation = $data_operation['label'];
	$ref_type_compte = $data_operation['ref_type_operation'];
    $statut_transaction="Soumis";
    $type_account="";
	switch ($data_operation['ref_type_operation']) {

		case 'OP':

			$statut_transaction = "Soumis";
			$type_account = "OP";
			$code_transaction = "OP-" . time();

			break;

		case 'OC':

			$statut_transaction = "Valide";
			$type_account = "OC";
			$code_transaction = "OC-" . time();

			break;

		case 'OE':

			$statut_transaction = "Soumis";
			$type_account = "OE";
			$code_transaction = "OE-" . time();

			break;
	}



	if (1) {

		$feedback_transaction = add_transaction_with_detail($ref_type_compte, $_POST['ref_devise'], $montant, "Agence web", 0, 0, 0, $code_transaction, $statut_transaction, 0, 0, $ref_operation, $code_operation, 0, 'NA', $type_account, $libelle);

		if ($feedback_transaction == 1) {
			$success = "yes";
			$action_compte = 0;
			$message_feedback = "---- Transaction executé avec succès, pour  " . $data_operation['label'] . ", montant de " . $montant . " " . $_POST['ref_devise'] . ", libellé : " . $libelle;

			$success_message = $message_feedback;
			//echo "Niveoooooooooooooooooooooooooooooooooo 0 : ".do_operation_get_ecriture($ref_operation)."  : ";

			if ($feedback_transaction == 1 && do_operation_get_ecriture($ref_operation)>=1 && 0) {

				//echo "Niveoooooooooooooooooooooooooooooooooo 1";

				$sql_ecriture = mysqli_query($bdd_i,"select * from t_ecriture where ref_operation=" . $ref_operation);
				$feedback_livre = 0;
				$ecriture_saved = 0;
				$ecriture_done = 0;
				$update_compte = 0;
				$update_compte_text = "";
				$update_solde = 0;
				$action_compte++;
				$i = 0;

				while ($data_ecriture = mysqli_fetch_array($sql_ecriture)) {
						$i++;
						//	echo "Niveoooooooooooooooooooooooooooooooooo 2";

						$montant_final = ($_POST['ref_devise'] == 'CDF') ? $montant : $montant * $_SESSION['mi_taux'];
						$montant_usd = ($_POST['ref_devise'] == 'USD') ? $montant : 0;

						$montant_cdf = ($_POST['ref_devise'] == 'CDF') ? $montant : 0;


						if ($data_ecriture['action'] == 'D') {
								$data_compte_parent = get_livre_compte_data($data_ecriture['ref_compte']);
								$feedback_livre = add_in_grand_journal($data_ecriture['ref_compte'], $_POST['ref_devise'], 0, $montant, $data_compte_parent['credit_final'], $data_compte_parent['debit_final'], $data_compte_parent['solde_final']+$montant_final, $code_transaction, $libelle, 0, 0, $ref_operation, $code_operation);
								$feedback_update_livre = update_livre_compte_debit($data_ecriture['ref_compte'], $montant_final, $montant_usd, $montant_cdf);
								$ecriture_done = $ecriture_done + $feedback_livre;
								$update_compte = $update_compte + $feedback_update_livre;
								$update_compte_text = $update_compte_text . $data_ecriture['ref_compte'] . " -->> Debiter : " . $montant . " " . $_POST['ref_devise'] . " | ";
							}

						if ($data_ecriture['action'] == 'C') {
								$data_compte_parent = get_livre_compte_data($data_ecriture['ref_compte']);
								$feedback_livre = add_in_grand_journal($data_ecriture['ref_compte'], $_POST['ref_devise'], $montant, 0, $data_compte_parent['credit_final'], $data_compte_parent['debit_final'], $data_compte_parent['solde_final']-$montant_final, $code_transaction, $libelle, 0, 0, $ref_operation, $code_operation);
								$feedback_update_livre = update_livre_compte_credit($data_ecriture['ref_compte'], $montant_final, $montant_usd, $montant_cdf);
								$ecriture_done = $ecriture_done + $feedback_livre;
								$update_compte = $update_compte + $feedback_update_livre;
								$update_compte_text = $update_compte_text . $data_ecriture['ref_compte'] . " -->> Crediter : " . $montant . " " . $_POST['ref_devise'] . " | ";
							}


						$feedback_update_livre = update_livre_compte_solde($data_ecriture['ref_compte']);


                    }
                    
						if ($feedback_transaction == 1) {


							$success = "yes";

							$message_feedback = $message_feedback . "<br>" . $update_compte_text . "";

							$success_message = $message_feedback;
						} else {

							$error = "yes";
							//$success="no";
							$error_message = $error_message . "<br>" . $i . ". " . $update_compte_text . "";


							//$error_message=$message_feedback;
						}
			}
		} else {

			$error = "yes";
			$error_message = "Une erreur a survenue lors de l'ecriture OP";
		}
	} else {

		$error = "yes";
		$error_message = "Une erreur a survenue lors de l'ecriture manuelle OP 2";
	}
} else {

	if (isset($_POST['submit_operation']) && is_double($_POST['montant'])) {

		$error = "yes";
		$error_message = "Une erreur a survenue lors  de l'ajout de l'OP, le montant n'est pas correct";
	}
}

if(isset($_POST['submit_search'])){
	$param_search1="  ";
	if(isset($_POST['daterange']) && $daterange1=$_POST['daterange']!=""){
		$param_search1="  ";
		$tempo=explode("-",$_POST['daterange']);
		$date_debut=trim($tempo[0]);
		$date_fin=trim($tempo[1]);
		$daterange=$_POST['daterange'];
		
	
			$param_search1=$param_search1." and (t.creationdate between '".$date_debut." 00:00:00' and '".$date_fin." 23:59:59') ";		
	
	}
	if(isset($_POST['statut']) && $_POST['statut']!=""){

		$param_search1=$param_search1." and statut_transaction='".$_POST['statut']."' ";	
		$statut=$_POST['statut'];

	}

}
	if(isset($_POST['submit_validation'])){
$message_feedback="";
$total=$_POST['total'];
$error_message="";
$success_message="";


for($i=1;$i<=$total;$i++){
	
	if(isset($_POST['chk_btn'.$i]) && $_POST['action'.$i]!=""){

$idt_transaction=$_POST['idt_transaction'.$i];

$action=$_POST['action'.$i];

$data_transaction=get_transaction_data($idt_transaction);

if($data_transaction['is_exist'] && $data_transaction['statut_transaction']=='Soumis'){
	
	
		   
                       
                             $feedback_transaction=set_transaction_statut_validation($idt_transaction,$action);
							if($feedback_transaction==1){
							$success="yes";
							$success_message=$success_message.$i." Traitement fait avec succes <".$data_transaction['type_account']."> : ".$data_transaction['code_transaction']." | Montant : ".$data_transaction['montant']." ".$data_transaction['ref_devise']." -- >> ".$action."<br>-----";	
						
					
								
							}else{
								
						//$feedback_transaction=set_transaction_statut_validation($idt_transaction,$action);
							//update_ecriture_caisse($data_transaction['code_transaction'],$_SESSION['mi_caisse_open'],$_SESSION['mi_agence']);
							$error="yes";
				            $error_message=$error_message.$i." Erreur lors de la validation de l'OP : <".$data_transaction['type_account']."> : ".$data_transaction['code_transaction']." | Montant : ".$data_transaction['montant']." ".$data_transaction['ref_devise']."<br>";	
							//$success="yes";
							//$message_feedback=$message_feedback.$i." Traitement fait avec succes <".$data_transaction['type_account']."> : ".$data_transaction['code_transaction']." | Montant : ".$data_transaction['montant']." ".$data_transaction['ref_devise']." -- >> ".$action."<br>";	
							//$success_message=$message_feedback;

								
								}
								
			}else{

				$error="yes";
				$error_message=$error_message.$i." ne peut traiter car la transaction n'existe plus ou a deja été validé"."<br>";

				}
	   
	   	
	}
  }
	
}

if(isset($_POST['submit_deletion'])){
  $message_feedback="";
  $total=$_POST['total'];
  $error_message="";
  $success_message="";
  
  
  for($i=1;$i<=$total;$i++){
    
    if(isset($_POST['chk_btn'.$i]) && $_POST['action_suppression'.$i]!=""){
  
  $idt_transaction=$_POST['idt_transaction'.$i];
  
  $action=$_POST['action_suppression'.$i];
  
  $data_transaction=get_transaction_data($idt_transaction);
  
  if($data_transaction['is_exist'] && ($data_transaction['statut_transaction']=='Soumis' || $data_transaction['statut_transaction']=='Valide' || $data_transaction['statut_transaction']=='Invalide')){
    
    
         
                         
                               $feedback_transaction=set_transaction_statut_validation($idt_transaction,$action);
                if($feedback_transaction==1){
                $success="yes";
                $success_message=$success_message.$i." suppression fait avec succes <".$data_transaction['type_account']."> : ".$data_transaction['code_transaction']." | Montant : ".$data_transaction['montant']." ".$data_transaction['ref_devise']." -- >> ".$action."<br>-----";	
              
            
                  
                }else{
                  
              //$feedback_transaction=set_transaction_statut_validation($idt_transaction,$action);
                //update_ecriture_caisse($data_transaction['code_transaction'],$_SESSION['mi_caisse_open'],$_SESSION['mi_agence']);
                $error="yes";
                      $error_message=$error_message.$i." Erreur lors de la suppression de l'OP : <".$data_transaction['type_account']."> : ".$data_transaction['code_transaction']." | Montant : ".$data_transaction['montant']." ".$data_transaction['ref_devise']."<br>";	
                //$success="yes";
                //$message_feedback=$message_feedback.$i." Traitement fait avec succes <".$data_transaction['type_account']."> : ".$data_transaction['code_transaction']." | Montant : ".$data_transaction['montant']." ".$data_transaction['ref_devise']." -- >> ".$action."<br>";	
                //$success_message=$message_feedback;
  
                  
                  }
                  
        }else{
  
          $error="yes";
          $error_message=$error_message.$i." ne peut traiter car la transaction n'existe plus ou a deja été validé"."<br>";
  
          }
       
         
    }
    }
    
  }

if(isset($_POST['submit_decaissement'])){
    $message_feedback="";
    $total=$_POST['total'];
    $error_message="";
    $success_message="";
    
    
    for($i=1;$i<=$total;$i++){
        
        if(isset($_POST['chk_btn'.$i]) && $_POST['action_paiement'.$i]!=""){
           // echo 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh  -----';
    $idt_transaction=$_POST['idt_transaction'.$i];
    
    $action=$_POST['action_paiement'.$i];
    
    $data_transaction=get_transaction_data($idt_transaction);
    
    if($data_transaction['is_exist'] && $data_transaction['statut_transaction']=='Valide'){
        //echo 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh : '.$action;
        $montant=$data_transaction['montant'];
        $montant_usd=($data_transaction['ref_devise']=='USD') ? $montant : 0;
        $montant_cdf=($data_transaction['ref_devise']=='CDF') ? $montant : 0;
        $ref_operation=$data_transaction['ref_operation'];
        $code_operation=$data_transaction['code_operation'];
        $code_transaction=$data_transaction['code_transaction'];
        $libelle=$data_transaction['sup_detail'];
               
                           $action_compte=0;
                                if($action=='Decaisser'){
                                    //echo 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh';
                                $success="yes";
                                $message_feedback=$message_feedback.$i." Traitement fait avec succes <".$data_transaction['type_account']."> : ".$data_transaction['code_transaction']." | Montant : ".$data_transaction['montant']." ".$data_transaction['ref_devise']." -- >> ".$action."<br>-----";	
                                $sql_ecriture=mysqli_query($bdd_i,"select * from t_ecriture where ref_operation=".$ref_operation);
                                        $feedback_livre=0;
                                        $ecriture_saved=0;
                                        $ecriture_done=0;
                                        $update_compte=0;
                                        $update_compte_text="";
                                        $update_solde=0;
                                        $action_compte++;$j=0;
    
                                                    while($data_ecriture=mysqli_fetch_array($sql_ecriture))
                                                        {	
                                                            $j++;
                                                            $montant_final=($data_transaction['ref_devise']=='CDF') ? $montant : $montant*$_SESSION['my_taux'];
                                                            $montant_usd=($data_transaction['ref_devise']=='USD') ? $montant : 0;
                                                            
                                                            $montant_cdf=($data_transaction['ref_devise']=='CDF') ? $montant : 0;
                                                            
                                                            
                                                            if($data_ecriture['action']=='D')
                                                            {
                                                                $data_compte_parent=get_livre_compte_data($data_ecriture['ref_compte']);
                                                                $feedback_livre=add_in_grand_journal($data_ecriture['ref_compte'],$data_transaction['ref_devise'],0,$montant,$data_compte_parent['credit_final'],$data_compte_parent['debit_final'],$data_compte_parent['solde_final'],$code_transaction,$libelle,0,0,$ref_operation,$code_operation);	
                                                                $feedback_update_livre=update_livre_compte_debit($data_ecriture['ref_compte'],$montant_final,$montant_usd,$montant_cdf);		
                                                                        $ecriture_done=$ecriture_done+$feedback_livre;
                                                                        $update_compte=$update_compte+$feedback_update_livre;
                                                                        $update_compte_text=$update_compte_text.$data_ecriture['ref_compte']." -->> Debiter : ".$montant." ".$data_transaction['ref_devise']." | ";
                                                            }
                                                            
                                                            if($data_ecriture['action']=='C')
                                                            {
                                                                $data_compte_parent=get_livre_compte_data($data_ecriture['ref_compte']);
                                                                $feedback_livre=add_in_grand_journal($data_ecriture['ref_compte'],$data_transaction['ref_devise'],$montant,0,$data_compte_parent['credit_final'],$data_compte_parent['debit_final'],$data_compte_parent['solde_final'],$code_transaction,$libelle,0,0,$ref_operation,$code_operation);		
                                                                    $feedback_update_livre=update_livre_compte_credit($data_ecriture['ref_compte'],$montant_final,$montant_usd,$montant_cdf);	
                                                                    $ecriture_done=$ecriture_done+$feedback_livre;	
                                                                    $update_compte=$update_compte+$feedback_update_livre;
                                                                    $update_compte_text=$update_compte_text.$data_ecriture['ref_compte']." -->> Crediter : ".$montant." ".$data_transaction['ref_devise']." | ";
                                                                            
                                                                            
                                                            }
                                                        
                                                                                                        
                                                        $feedback_update_livre=update_livre_compte_solde($data_ecriture['ref_compte']);		
                                                        
                                                       
                                                        
                                                        
                                                                        
                                                        }
    
                    
                    
                    if($feedback_livre>=1){
                            
                                    
                            $success="yes";
                            $error="no";
                            $message_feedback=$message_feedback.$j.". Ecriture(s) executé avec succès, pour  ".$libelle.", montant de ".$montant." ".$data_transaction['ref_devise'].", libellé : ".$libelle."<br>***".$update_compte_text."<br>";
                            
                            $success_message=$message_feedback;
                            
                            $feedback_transaction=set_transaction_statut_decaisser($idt_transaction,$action);
                                 
                        
                        }else{
                            
                            $error="yes";
                            $success="no";
                            $message_feedback=$i.". erreur a survenue lors de l'ecriture ".$data_transaction['type_account']." :  "." / Livre de compte=".$feedback_livre."<br>".$update_compte_text."";
                                                                
                                                                
                                                                                                                                $error_message=$message_feedback;
                            
                    }
                        
                                    
                                }
                                    
                }else{
    
                    $error="yes";
                    $error_message=$error_message.$i." ne peut traiter car la transaction n'existe plus ou a deja été validé"."<br>";
    
                    }
           
               
        }
      }
        
    }
	
	?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
    <?php
		include_once("php/header.php");

	?>
    <?php	?>
          <!-- Sidebar Menu -->
    <?php
		include_once("php/main_menu.php");

	?>
         
         <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <?php
		    include_once("php/titre_location.php");

        	?>
        </section>

        <!-- Main content -->
        <section class="content">
<?php  include_once("php/print_message.php"); ?>
          <!-- Your Page Content Here -->
 <!-- Horizontal Form -->
 <div id="light" class="white_content">

  <?php  
  //*******************************Modification creation compte epargne EAC ****************************
if(isset($_GET['compte']) && isset($_GET['action']) && $_GET['action']=="add_compte"){

	?>         
    <a onClick="hide_pop()"><i class="fa  fa-close">Fermer Ici</i></a>
     

                                       
   <?php  

}
	?>                    

     </div>
    <div id="fade" class="black_overlay"></div>          
      
 
          
          
    <form onsubmit="ShowLoading()" action="ordre_paiement.php" method="post">
            <div class="box box-info" style="overflow-y: scroll;">
                <div class="box-header with-border">
                    <h3 class="box-title">Ecritures Automatiques pré-enrégistrées --->>></h3>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Opération</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="ref_operation">
                                <?php echo getcombo_operation_comptable_with_ecriture_op(0); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Montant</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="" name="montant"> <select class="form-control" name="ref_devise">
                                <option value="USD">USD</option>
                                <option value="CDF">CDF</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Libelle</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="" name="libelle" <?php echo $pattern_text; ?>>
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">

                    <button type="submit" class="btn btn-info pull-right" name="submit_operation">Valider</button>
                </div><!-- /.box-footer -->
            </div><!-- /.box -->


        </form>
          <form  onsubmit="ShowLoading()"  action="ordre_paiement.php" method="post">    
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title"><<------ Actions Ici</h3>
                   <button onclick="exportTableToCSV('ExportFileOrdrePaiement.csv')" class="btn btn-success pull-right" ><i class="fa  fa-file-excel-o fa-download"> Exporter en CSV </i> <i class="fa fa-download"></i></button>
					 <button type="submit"  class="btn btn-info pull-right" name="submit_search" >Afficher Le resultat</button>	 	
                     <button type="submit"  class="btn btn-info pull-left" name="submit_validation"  <?php  echo (get_access(44,$_SESSION['my_idprofile'])!=1) ? "disabled" : ""	?>  onClick="return confirm('Cette action de validation ou invlidation  est irreversible, Veuillez confirmer?')">Valider | Invalider  OP</button>
                     <button type="submit"  class="btn btn-danger pull-left" name="submit_deletion"  <?php  echo (get_access(51,$_SESSION['my_idprofile'])!=1) ? "disabled" : ""	?>  onClick="return confirm('Cette action de suppression est irreversible, Veuillez confirmer?')">Supprimer  OP</button> 
                     <button type="submit"  class="btn btn-success pull-left" name="submit_decaissement"  <?php  echo (get_access(45,$_SESSION['my_idprofile'])!=1) ? "disabled" : ""	?>  onClick="return confirm('Cette action de decaissement est irreversible, Veuillez confirmer?')">Decaisser OP</button>                   
                </div><!-- /.box-header -->
                <div class="box-body" style="overflow-y: scroll;height : 600px; " >
								<div class="form-group">
                      <label  class="col-sm-4 control-label">Période</label>
                      <div class="col-sm-8">
                      <input type="text" class="form-control pull-right" id="date2" name="daterange" value="<?php echo $daterange; ?>" placeholder="Specifiez une date">
                      </div>
										</div>  
										<div class="form-group">
                      <label  class="col-sm-4 control-label">Statut</label>
                      <div class="col-sm-8">
											<select  class="form-control" name="statut">
											
											<option value="" <?php  echo ($statut=='') ? "selected" : ""; ?>>Toutes</option>
                                            <option value="Soumis" <?php  echo ($statut=='Soumis') ? "selected" : ""; ?>>Soumis</option>
                                            <option value="Valide" <?php  echo ($statut=='Valide') ? "selected" : ""; ?>>Valide</option>
                                            <option value="Decaisser" <?php  echo ($statut=='Decaisser') ? "selected" : ""; ?>>Decaisser</option>
                                            <option value="Invalide" <?php  echo ($statut=='Invalide') ? "selected" : ""; ?>>Invalide</option>
											
                      
                      </select>	
										</div>
										</div> 
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                                         
                      
                      <th>#</th>
                      <th>Date</th>
                      <th>Agence</th>  
                      <th>Code</th>
                      <th>Operation</th> 
                      <th>Libellé</th>                      
                      <th>Montant</th>
                      <th>Statut</th>
                      <th>Initateur</th>
                      <th>Validateur</th>
                      <th>Valider le</th>
                      <th>Decaisser le</th>
                      <th>Decaiser par </th>
                      <th>Validation</th>
                      <th>Suppression</th>
                      <th>Decaissement</th>
                      <th><input type="checkbox" onclick="toggle(this);" /><br /></th>
                <script>
                  function toggle(source) {

                    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                    for (var i = 0; i < checkboxes.length; i++) {
                      if (checkboxes[i] != source)
                        checkboxes[i].checked = source.checked;
                    }


                  }
                </script></th>  
                      <th></th>                     
                      
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
        $contrainte_agence=(get_access(41,$_SESSION['my_idprofile'])!=1) ? "and ref_agence_action=".$_SESSION['my_agence'] : "";
		$sql_select1 = "select t.*, t_operation.label, t_agence.label as agence from t_transactions t join t_operation on ref_operation=idt_operation join t_agence on id_agence=ref_agence_action where type_account in ('OP') and statut_transaction not in ('deleted','Supprimer')  ".$contrainte_agence."  ".$param_search1."  order by creationdate desc limit 0,500";
		$sql_result1 = mysqli_query($bdd_i,$sql_select1);
		//echo $sql_select1;
   $index=0;

		  while($data1 = mysqli_fetch_array($sql_result1)){
		  
		  $index++;
		  		
		  	?>	
                      <tr>      
                      <td><?php	echo $index;?></td> 
                      <td><?php	echo $data1['creationdate'];?></td>  
                      <td><?php	echo $data1['agence'];?></td> 
					            <td><?php	echo $data1['code_transaction'];?></td>                      
                      <td><?php	echo $data1['label'];?></td> 
                      <td><?php	echo $data1['sup_detail'];?></td> 
                      <td><?php	echo $data1['montant']." ".$data1['ref_devise'];?></td>
                      <td><?php	echo $data1['statut_transaction'];?></td>
                      <td><?php	echo $data1['ref_user'] ;?></td>
                      <td><?php	echo $data1['validated_by'] ;?></td>
                      <td><?php	echo $data1['validation_date'] ;?></td>
                      <td><?php	echo $data1['decaissement_by'] ;?></td>
                      <td><?php	echo $data1['decaissement_date'] ;?></td>
                      <td>
                      <input name="idt_transaction<?php  echo $index; ?>"  type="hidden" value="<?php	echo $data1['idtransactions'] ;?>" >
					            <select  class="form-control" name="action<?php  echo $index; ?>" <?php  echo ($data1['statut_transaction']!='Soumis') ? "disabled" : ""; ?>>
                      <option value="" >--Action--</option>
                      <option value="Valide" <?php  echo ($data1['statut_transaction']=='Valide') ? "selected" : ""; ?>>Valide</option>
                      <option value="Invalide" <?php  echo ($data1['statut_transaction']=='Invalide') ? "selected" : ""; ?>>Invalide</option>
                      </select>
                      </td>   
                      <td>
                      
                      <select  class="form-control" name="action_suppression<?php  echo $index; ?>" <?php  echo ($data1['statut_transaction']=='Decaisser') ? "disabled" : ""; ?>>
                                <option value="" selected>--Action--</option>
                                
                                <option value="Supprimer" <?php  echo ($data1['statut_transaction']=='Valide' || $data1['statut_transaction']=='Soumis' || $data1['statut_transaction']=='Invalide') ? "" : ""; ?>>Supprimer</option>
                                
                                </select>
                                </td> 
                      <td>
                      
					  <select  class="form-control" name="action_paiement<?php  echo $index; ?>" <?php  echo ($data1['statut_transaction']!='Valide') ? "disabled" : ""; ?>>
                      <option value="" >--Action--</option>
                      
                      <option value="Decaisser" <?php  echo ($data1['statut_transaction']=='Decaisser') ? "selected" : ""; ?>>Decaisser</option>
                      
                      </select>
                      </td>     
                                        
                      <td><input name="chk_btn<?php  echo $index; ?>"type="checkbox" value="ok" <?php  echo ($data1['statut_transaction']=='Soumis' || $data1['statut_transaction']=='Valide') ? "" : "disabled"; ?>></td>                      
                      <td>
                      <?php  
                      
                      if(get_access(46,$_SESSION['my_idprofile'])==1 && $data1['statut_transaction']=='Valide'){
                       
                      ?>
                            <a href="print_po.php?print_pdf=ok&idt_all=<?php echo $data1['idtransactions']; ?>" target="_blank"><i class="fa   fa-file-pdf-o"></i> </a>
                      <?php  
                        }
                            ?>
                             <?php  
                      
                      if(get_access(46,$_SESSION['my_idprofile'])==1 && $data1['statut_transaction']=='Decaisser'){
                       
                      ?>
                            <a href="print_facture.php?print_pdf=ok&idt_all=<?php echo $data1['idtransactions']; ?>" target="_blank"><i class="fa   fa-file-pdf-o"></i> </a>
                     <?php  
                        }
                            ?>                  
                      </td>
                                       </tr>
                  <?php 
	
		  }
	
		 			?> 
                     <input name="total" type="hidden" value="<?php	echo $index ;?>">
                    </tbody>
                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           
                             <input name="total" type="hidden" value="<?php echo $index; ?>">           
          </form>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <?php
		    include_once("php/footer.php");

        	?>
      </footer>

      <!-- Control Sidebar -->
     
        <?php
		    include_once("php/tableau_controle.php");

        	?>
      <!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      
    </div><!-- ./wrapper -->

    <?php
		    include_once("php/importation_js.php");

        	?>
  </body>
</html>
