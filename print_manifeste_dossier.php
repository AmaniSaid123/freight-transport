<?php  

$idpage = 9;
include_once("php/session_check.php");
include_once("php/function.php");
$data_dossier="";
if(isset($_GET['val_ndel']) && intval($_GET['val_ndel'])>0){
	
	$data_dossier=get_dossier_data_by_ndel(intval($_GET['val_ndel']));
	
	
	
	
	}
        
if(isset($_SESSION['my_doc_online']) && intval($_SESSION['my_doc_online'])>0){
	
	$data_dossier=get_dossier_data($_SESSION['my_doc_online']);
	
	
	
	}
        
if(isset($_SESSION['my_m_dossier']) && intval($_SESSION['my_m_dossier'])>0){
	
	$data_dossier=get_dossier_data($_SESSION['my_m_dossier']);
	
	
	
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<title>MyPASS-En ligne</title>
</head>

<body>
<img src="images/logo_passport.png" width="212" height="171" />
<h2 class="box-title">FORMULAIRE DE RENSEIGNEMENT ET  DE SUIVI DU DOSSIER </h2>
<?php  

if($data_dossier['is_exist']==1){

?>

<form action="dossier_online.php"  method="post" >
<h3 class="box-title">Reference d'enregistrement en Ligne (NID) : <?php  echo $data_dossier['ndel']; ?></h3>
 <div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">1. IDENTITE DU CLIENT</h3>
                  
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Nom complet (tel que dans le passport) <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="identite"  placeholder="Entrez votre nom tel dans le passport ici" value="<?php  echo $data_dossier['identite']; ?>" readonly="readonly">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Date de naissance <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" name="date_naissance" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="Entrez votre date de naissance Jour-Mois-Année" value="<?php  echo $data_dossier['date_naissance']; ?>" readonly="readonly">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Email <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" name="email" class="form-control" value="<?php  echo $data_dossier['email']; ?>" readonly="readonly">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Téléphone <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" value="<?php  echo $data_dossier['numero_telephone']; ?>" readonly="readonly">
                      </div>
                    </div>
                     <div class="form-group">
                      <label  class="col-sm-6 control-label">Lieu de naissance <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="lieu_naissance"  value="<?php  echo $data_dossier['lieu_naissance']; ?>" readonly="readonly">
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Nom complet de votre père biologique (tel que dans votre acte de naissance) <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                          <input type="text" class="form-control" name="identite_pere" value="<?php echo $data_dossier['identite_pere']; ?>"  placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans votre acte de naissance" readonly>
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Lieu de naissance de votre père <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="lieu_naissance_pere"  placeholder="Entrez le lieu de naissance" value="<?php echo $data_dossier['lieu_naissance_pere']; ?>" readonly>
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Date de naissance de votre père <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                          <input type="text" name="date_naissance_pere" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" value="<?php echo $data_dossier['date_naissance_pere']; ?>" data-mask placeholder="Entrez la date de naissance de votre pere Année-Mois-Jour" readonly>
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Nom complet de votre mère biologique (tel que dans votre acte de naissance) <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="identite_mere" value="<?php echo $data_dossier['identite_mere']; ?>"  placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans votre acte de naissance" readonly>
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Lieu de naissance de votre mère <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="lieu_naissance_mere" value="<?php echo $data_dossier['lieu_naissance_mere']; ?>"  placeholder="Entrez le lieu de naissance" readonly>
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Date de naissance de votre mère <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" name="date_naissance_mere" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" value="<?php echo $data_dossier['date_naissance_mere']; ?>" data-mask placeholder="Entrez la date de naissance de votre mère Année-Mois-Jour" readonly >
                      </div>
                    </div>
                    <div class="form-group">
                        
                      <label  class="col-sm-6 control-label">Vous etes issue d'une famille de combien d'enfants</label>
                      <div class="col-sm-6">
                       
                       <input type="text" class="form-control" name="lieu_naissance"  value="<?php  echo $data_dossier['nbre_enfant_famille']; ?>" readonly="readonly">
                       
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Vous etes quantième dans la famille</label>
                      <div class="col-sm-6">
                       
                       <input type="text" class="form-control" value="<?php  echo $data_dossier['position_dans_famille']; ?>" readonly="readonly">
                       
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Numéro Passeport <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" value="<?php  echo $data_dossier['numero_passport']; ?>" readonly="readonly">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Date d'expiration Passeport <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" name="date_expiration_pp" class="form-control" value="<?php  echo $data_dossier['date_expiration_pp']; ?>" readonly="readonly">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">A quelle agence voulez-vous suivre le dossier ?</label>
                      <div class="col-sm-6">
                        <select name="ref_agence" class="form-control select2" disabled="disabled">
                       
                       <?php  echo getcombo_agence($data_dossier['ref_agence']); ?>
                       </select>
                       
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Comment avez-vous connu notre agence ?</label>
                      <div class="col-sm-6">
                        <input type="text" name="promoteur_agence" class="form-control"  value="<?php  echo $data_dossier['promoteur_agence']; ?>" readonly="readonly">
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">PIN Secret</label>
                      <div class="col-sm-6">
                        <input type="text" name="promoteur_agence" class="form-control"  value="<?php  echo $data_dossier['pin_secret']; ?>" readonly="readonly">
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-6 control-label">Autre chose à nous informer? Merci de le mentionner ici (Max 200 caractères)---------> </label>
                      <div class="col-sm-6">
                          
                          <textarea name="commentaire_client" cols="100%" rows="10" class="form-control" readonly="readonly"><?php  echo $data_dossier['commentaire_client']; ?></textarea>
                        
                      </div>
                    </div>
                    
                    
                    
                   
                    
                  </div><!-- /.box-body -->
                  
               
              </div>
              <!-- /.box -->
              <div class="box box-info">
              <div class="box-header with-border">
  					 <h3 class="box-title">2. PARCOURS D'ETUDES</h3>
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                    <h5>2.1. Votre parcours Secondaire</h5>
                  <table class="table table-condensed">
                    <tr>
                      <th>#</th>
                      <th>Année</th>
                      <th>Etablissement</th>
                      <th>Intitulé de la formation</th>
                      <th>Niveau</th>
                      <th>Résultats</th>  
                     
                                      
                      
                    </tr>
                     <?php  
					 $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu='SECONDAIRE' and ref_dossier=".$data_dossier['idt_dossier']."";
		//echo $sql_select1;
		
		$sql_result1 = $bdd->query($sql_select1);
		
  $index2=0;

		  while($data1 = $sql_result1->fetch()){ 
		  $index2++;
		  ?>
                    <tr>
                      <td><?php	echo $index2;?></td>
                      <td><?php  echo $data1['annee']; ?> </td>
                      <td><?php  echo $data1['institution']; ?></td>
                      <td><?php  echo $data1['formation']; ?></td>
                      <td><?php  echo $data1['niveau']; ?></td>                      
                      <td><?php  echo $data1['resultat']; ?></td> 
                      
                                        
                      
                    </tr>
                    
               <?php  
					}
				?>	    
                  </table> 
                    <br></br>
                    <h5>2.2. Diplome d'Etat ou son équivalent</h5>
                    <table class="table table-condensed">
                    <tr>
                      <th></th>
                      <th>Année obtention</th>
                      <th>Ecole fréquentée</th>
                      <th>Option</th>
                      <th>Pourcentage</th>
                      <th>Pays d'obtention</th>  
                      <th>Ville d'obtention</th>
                                           
                      
                    </tr>
                     <?php  
					 $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu='EXETAT' and ref_dossier=".$data_dossier['idt_dossier']."";
		//echo $sql_select1;
		
		$sql_result1 = $bdd->query($sql_select1);
		
  $index=0;

		  while($data1 = $sql_result1->fetch()){ ?>
                    <tr>
                      <td></td>
                      <td>
					  <?php  echo $data1['annee']; ?>
                      </td>
                      <td><?php  echo $data1['institution']; ?></td>
                      <td><?php  echo $data1['formation']; ?></td>
                      <td><?php  echo $data1['resultat']; ?></td>                      
                      <td><?php  echo $data1['pays_obtention']; ?></td>  
                       <td><?php  echo $data1['ville_obtention']; ?></td>
                       
                                          
                     </tr>
                   <?php  } ?>
                  </table>
                  <br>
                  <h5>2.3. Votre parcours Post-secondaire</h5>
                  <table class="table table-condensed">
                    <tr>
                      <th>#</th>
                      <th>Année</th>
                      <th>Etablissement</th>
                      <th>Intitulé de la formation</th>
                      <th>Niveau</th>
                      <th>Résultats</th>  
                      <th>Diplome Obtenu</th>  
                                      
                      
                    </tr>
                     <?php  
					 $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu<>'EXETAT' and diplome_obtenu<>'SECONDAIRE' and ref_dossier=".$data_dossier['idt_dossier']."";
		//echo $sql_select1;
		
		$sql_result1 = $bdd->query($sql_select1);
		
  $index2=0;

		  while($data1 = $sql_result1->fetch()){ 
		  $index2++;
		  ?>
                    <tr>
                      <td><?php	echo $index2;?></td>
                      <td><?php  echo $data1['annee']; ?> </td>
                      <td><?php  echo $data1['institution']; ?></td>
                      <td><?php  echo $data1['formation']; ?></td>
                      <td><?php  echo $data1['niveau']; ?></td>                      
                      <td><?php  echo $data1['resultat']; ?></td> 
                      <td><?php  echo $data1['diplome_obtenu']; ?></td> 
                                        
                      
                    </tr>
                    
               <?php  
					}
				?>	    
                  </table>
                    
                    
                    
                   
                    
                  </div><!-- /.box-body -->
                 
               
              </div>
              <div class="box box-info">
              <div class="box-header with-border">
  					 <h3 class="box-title">FICHIER TELECHARGEES</h3>
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                    
                  
                  <table class="table table-condensed">
                    <tr>
                      <th>#</th>
                      <th>Titre document</th>
                      <th>ajouté le </th>
                      <th>Type</th>
                      
                                      
                      
                    </tr>
                     <?php  
					 $sql_select1 = "SELECT * FROM passport_bd.t_document_dossier where ref_dossier=".$data_dossier['idt_dossier']." and view_doc=1";
		//echo $sql_select1;
		
		$sql_result1 = $bdd->query($sql_select1);
		
  $index2=0;

		  while($data1 = $sql_result1->fetch()){ 
		  $index2++;
		  ?>
                    <tr>
                      <td><?php	echo $index2;?></td>
                      <td><?php  echo $data1['titre_document']; ?> </td>
                      <td><?php  echo $data1['creationdate']; ?></td>
                      <td><?php  echo $data1['type_fichier']; ?></td>
                      
                                        
                      
                    </tr>
                    
               <?php  
					}
				?>	    
                  </table>
                    
                    
                    
                   
                    
                  </div><!-- /.box-body -->
                 
               
              </div>
              <div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">3. ACTIVITES PASSEES ET ACTUELLES</h3>
                  
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                  Parlez-nous devos emplois ou professions passés et actuels ainsi que les années dudébut et de la fin. si application
                    <div class="form-group">
                      
                      <div class="col-sm-6">
                      <textarea name="activite_passe_actuelle" cols="100%" rows="10" class="form-control" readonly="readonly"><?php  echo $data_dossier['activite_passe_actuelle']; ?></textarea>
                        
                      </div>
                    </div>
                    
                    
                  </div><!-- /.box-body -->
                  <!-- /.box-footer -->
               
              </div>
              <div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">4. VOYAGE</h3>
                  
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Ou voulez-vous partir? <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                       <input type="text" name="promoteur_agence" class="form-control"  value="<?php  echo $data_dossier['vo_destination']; ?>" readonly="readonly">
                        
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Raison du voyage <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="vo_raison_voyage"  value="<?php  echo $data_dossier['vo_raison_voyage']; ?>" readonly="readonly">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Si pour études, qui prendra en charge ces études?</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="vo_charge_etude_parrain"  value="<?php  echo $data_dossier['vo_charge_etude_parrain']; ?>" readonly="readonly">
                       
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Avez-vous des ancien Visa?</label>
                      <div class="col-sm-6">
                       <input name="vo_ancien_visa" type="text" value="<?php  echo $data_dossier['vo_ancien_visa']; ?>" readonly="readonly"> 
                      </div>
                      
                      
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Si Oui, précisez os anciens Visa</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="vo_ancien_visa_comment" value="<?php  echo $data_dossier['vo_ancien_visa_comment']; ?>" readonly="readonly">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Avez-vous déjà eu un refus de Visa?</label>
                      <div class="col-sm-6">
                       <input name="vo_refus_visa_chk" type="text" value="<?php  echo $data_dossier['vo_refus_visa']; ?>" readonly="readonly"> 
                      </div>
                      
                      
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Si Oui, précisez os anciens Visa</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="commentaire_refus_visa" value="<?php  echo $data_dossier['vo_refus_visa_comment']; ?>" readonly="readonly">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Avez-vous une famille à votre lieu de destination?</label>
                      <div class="col-sm-6">
                       <input name="vo_destination_famille_chk" type="text" value="<?php  echo $data_dossier['vo_destination_famille']; ?>" readonly="readonly"> 
                      </div>
                      
                      
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Si Oui, précisez</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="vo_destination_commenvalue=" value="<?php  echo $data_dossier['vo_destination_comment']; ?>" readonly="readonly">
                      </div>
                    </div>
                    
                    
                    
                   
                    
                  </div><!-- /.box-body -->
                  <!-- /.box-footer -->
               
              </div>
              <div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">5. PRISE EN CHARGE</h3>
                  
                </div><!-- /.box-header -->
                <!-- form start -->

                
                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Votre garant est qui pour vous?<font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" value="<?php  echo $data_dossier['pc_qualite_garant']; ?>" readonly="readonly">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Ou travaille-t-il? <font color="#FF0000">*</font></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="pc_lieu_travail_garant"  value="<?php  echo $data_dossier['pc_lieu_travail_garant']; ?>" readonly="readonly">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Quel est son salaire mensuel?</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="pc_salaire_parrain"  value="<?php  echo $data_dossier['pc_salaire_parrain']; ?>" readonly="readonly">
                       
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Possède-t-il une activité commerciale ou une entreprise?</label>
                      <div class="col-sm-6">
                       <input name="pc_activite_pro_chk" type="text" value="<?php  echo $data_dossier['pc_activite_pro']; ?>" readonly="readonly"> 
                      </div>
                      
                      
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Si Oui, quel est son nom?</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="pc_activite_pro_nom" value="<?php  echo $data_dossier['pc_activite_pro_nom']; ?>" readonly="readonly">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Si Oui, Quel revenu mensuel pour cette activité ou entreprise en $ (Estimation)?</label>
                      <div class="col-sm-6">
                       <input type="text" class="form-control" name="pc_revenu_parrain" value="<?php  echo $data_dossier['pc_revenu_parrain']; ?>" readonly="readonly">
                      </div>
                    </div>
                    <div class="form-group">
                     <div class="col-sm-12">
                       .
                      </div>
                    </div>
                    <br>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Combien de parcelles dispose-t-il ?</label>
                      <div class="col-sm-6">
                      <input type="text" class="form-control" name="pc_revenu_parrain" value="<?php  echo $data_dossier['pc_nbre_parcelle']; ?>" readonly="readonly">
                      
                      </div>
                      
                      
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-6 control-label">Combien de véhicule dispose-t-il ?</label>
                      <div class="col-sm-6">
                      <input type="text" class="form-control" name="pc_revenu_parrain" value="<?php  echo $data_dossier['pc_nbre_vehicule']; ?>" readonly="readonly">
                      
                      </div>
                      
                      
                    </div>
                         
                    
                  </div><!-- /.box-body -->
                  <!-- /.box-footer -->
               
              </div>
              
              
               </form>

<?php  
}else{
	
	echo '<h4 class="box-title">Il n\'y a aucun dossier pour ce numero : '.$_GET['val_ndel'].' </h4>';
	
	}


 ?>

</body>
</html>