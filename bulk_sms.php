<?php
	//******************IDPAGE*****************
	$idpage=26;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	include_once("php/function_sendsms.php");	
		
		
	

	//****************location******************
	$set_pluggin_datatable="yes";
	$set_pluggin_selection_wise="yes";	
	$set_plugin_daterange="yes";	
	$get_active_menu="sms";
	$get_active_submenu="";
	$page_titre="SMS";
	$page_small_detail="MyPASS";
	$page_location="Accueil > SMS > Envoyer un SMS";
	
		
		$broad="";
		$text="";
		
$constraint=0;
//********************************************************


//**************************************************************
if(isset($_POST['send'])){
	$telephone_to_use="";
	add_notification("t_bulk",0,"NA","Text : ".$_POST['message']. " A ".$_POST['total']." participants",$_SESSION['my_username'],"Ajout bulk");
$count_msg=0;	
		include("param.php");

if($_POST['total']>0){


for($i=1;$i<=$_POST['total'];$i++){

if(isset($_POST['chk'.$i]) && $_POST['chk'.$i]=='on'){

  
	$telephone_to_use=$telephone_to_use.','.$_POST['phone'.$i];
	//$sql_query=mysql_query("insert into t_out(recipient,text,creationdate,ref_bulk,ref_user) values('".$_POST['phone'.$i]."','".$_POST['message']."',now(),'bulk','".$_SESSION['username']."')");
	//send_sms($_POST['phone'.$i],$_POST['message'],"PASSPORT","NA","User","NA");
	$count_msg++;
	
	}
  if(($count_msg%480==0)  || ($count_msg%480>0 && $i==$_POST['total'] )){

    $telephone_to_use = substr($telephone_to_use, 1, strlen($telephone_to_use) - 1);
    send_sms($telephone_to_use, $_POST['message'], "PASSPORT", "NA", "User", "NA");
  
    $count_msg=0;
    $telephone_to_use="";
  
  }
   
   

}

}
add_action_info(0, 27, "", "", "", "", "Valide", $_SESSION['my_username'], "Non", "Destinations : ".$count_msg." | Message : ".$_POST['message'], 1, 0);
	$success="yes";
  $success_message="Bulk effectué, Messages envoyés : ".$count_msg."";
  
			
	}
//*********Initialisation****
$sql_main_select="";
$param_broad=" (select distinct msisdn as phone,'Inc' as name, 'Inc' as surname from t_msisdn where 0) ";
if(isset($_POST['Search'])){
	$constraint=1;
		
		
		
		$broad=$_POST['broad'];
		
		$param_broad=" select distinct numero_telephone as phone,identite as name, 'Inc' as surname from t_dossier where 1";		
		$compteur=0;
    
    
		
		
		
		
    if(isset($_POST['pays']) && $_POST['pays']!=''){
      $constraint=1;
      if($compteur==0){
        
        $param_broad=" select distinct numero_telephone as phone,identite as name, 'Inc' as surname from t_dossier where vo_destination='".$_POST['pays']."' ";$compteur++;
        
        }

}		

if(isset($_POST['statut']) && $_POST['statut']!=''){
	$constraint=1;
  if($compteur==0){
    
    $param_broad=" select distinct numero_telephone as phone,identite as name, 'Inc' as surname from t_dossier where statut_dossier='".$_POST['statut']."' ";$compteur++;
    
    }else{
    
    $param_broad=$param_broad."  and  statut_dossier='".$_POST['statut']."' ";$compteur++;
    
    }

}		
              

if(isset($_POST['agence']) && $_POST['agence']!=''){
	$constraint=1;
  if($compteur==0){
    
    $param_broad=" select distinct numero_telephone as phone,identite as name, 'Inc' as surname from t_dossier where ref_agence='".$_POST['agence']."' ";$compteur++;
    
    }else{
    
    $param_broad=$param_broad."  and ref_agence='".$_POST['agence']."' ";$compteur++;
    
    
    }

}		

	
if(isset($_POST['broad']) &&  $broad!='All' && $broad!='NA'){
  $constraint=1;		
										if($compteur==0){
									
									$param_broad=" (select distinct msisdn as phone,'Inc' as name, 'Inc' as surname  from t_msisdn where ref_broadcast_list=".$broad.") ";$compteur++;
									
									}else{
									
									$param_broad=$param_broad."  Union (select distinct msisdn as phone,'Inc' as name, 'Inc' as surname  from t_msisdn where ref_broadcast_list=".$broad.") ";$compteur++;
									
									
									}
		}									
if(isset($_POST['broad']) &&  $broad=='All'){
	$constraint=1;
								if($compteur==0){
									
									$param_broad=" (select distinct msisdn as phone,'Inc' as name, 'Inc' as surname from t_msisdn) ";$compteur++;
									
									}else{
									
									$param_broad=$param_broad."  Union (select distinct msisdn as phone,'Inc' as name, 'Inc' as surname  from t_msisdn) ";$compteur++;
									
									
									}
	
	}		


  $sql_main_select=$param_broad;
	
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
          <form class="form-horizontal" action="bulk_sms.php"  method="post" name="Myform">
			 <div class="row">
 <?php 	include_once("php/menu_sub_sms.php");  	?>
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Repertoire des Numéros Broadcast</h3>
                  
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                 
                     <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-filter"></i></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
             
               <div class="box-body" style="overflow-y: scroll;">
                
                     <table class="table table-bordered table-striped">
  <tr>
    
    <th class="question">Repertoire Broadcast</th>
    <th class="question">Client MyPASS selon Agence</th>
    <th class="question">Client MyPASS selon Destination</th>
    <th class="question">Client MyPASS selon statut Dossier</th>
    
    
  </tr>
  <tr>
    
  <td>
    <select name="broad" class="form-control select2">
    
    <?php  echo getcombo_broad($broad); ?></select></td>
    <td>
    <select name="agence" class="form-control select2">
      <option value="">Toutes les agences</option>
    <?php  echo getcombo_agence(""); ?></select></td>

    <td>
    <select name="pays" class="form-control select2">
    <option value="">Toutes les Pays</option>
    <?php  echo getcombo_pays_bd(""); ?></select></td>
    
    <td>
    <select name="statut" class="form-control select2">
    <option value="">Toutes les Statuts</option>
    <?php  echo getcombo_statut_dossier("")  ?></select></td>
    
        
  </tr>
</table>

               
					</div>
                </div><!-- /.col -->
                
                </div><!-- /.col -->
              </div><!-- /.row -->
              <div class="box-footer">
                    <button type="reset" class="btn btn-default" >Annuler</button>
                    <button type="submit"  class="btn btn-info pull-right" name="Search"><i class="fa   fa-tripadvisor"></i>Afficher</button>
                                     
                  </div>
            </div><!-- /.box-body -->

<div class="col-md-12">
           
           <div class="box-body" style="overflow-y: scroll;">
                 
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Sender</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" name="sender" value="PASSPORT" placeholder="Tappez Sender Ici" readonly="">
                      </div>
                    </div>
                  <div class="form-group">
                  <br><strong>Destinateurs <small class="label bg-red">Distinctes</small></strong>
        <div id="contact"  style="overflow-y: scroll;height : 300px; " >
        <?php
		$idx=0;
    //echo $sql_main_select;
		if($constraint>=1){
		$sql_main_query = $bdd->query($sql_main_select);
		//echo $sql_main_select; 
		 while($donnees = $sql_main_query->fetch() ){
			 $idx++;
			  $review_telephone = $donnees['phone'];
        $review_telephone = str_ireplace("(", "", $review_telephone);
        $review_telephone = str_ireplace(")", "", $review_telephone);
        $review_telephone = str_ireplace("-", "", $review_telephone);
        $review_telephone = str_ireplace("_", "", $review_telephone);
        $review_telephone = trim(str_ireplace(" ", "", $review_telephone));
      if(strlen($review_telephone)>=11){
        if($idx%2==0){
				  echo '<small class="label pull-right bg-blue"><input name="chk'.$idx.'" type="checkbox" value="on" checked="true"><input name="phone'.$idx.'" type="hidden" value="'.$review_telephone.'" >'.$review_telephone.'-'.$donnees['name'].'</small>';
				 }else{
					 
					  echo '<small class="label pull-right bg-green"><input name="chk'.$idx.'" type="checkbox" value="on" checked="true"><input name="phone'.$idx.'" type="hidden" value="'.$review_telephone.'" >'.$review_telephone.'-'.$donnees['name'].'</small>';
					 }
			 
          }
			 
			 }
         
		}
		 
		 ?>
         <input name="total" type="hidden" value="<?php echo $idx; ?>">
        </div>
        
        <br>
	    <p align="left"><strong><font color="#3300FF">Votre message à <?php echo $idx; ?> Destinateur(s)</font></strong><br>    &nbsp;  
        <br>
 Nombre de caractere restant :   <input name="nbcaractere" type="text" readonly id="nbcaractere_id">  
        
</p>

                    <textarea id="compose-textarea"  class="form-control" style="height: 150px" name="message" placeholder="Ecrivez votre SMS Ici" ></textarea>
                    <script type='text/javascript'>
document.forms['Myform'].elements['message'].onkeyup=function(){
   document.forms['Myform'].elements['nbcaractere'].value=document.forms['Myform'].elements['message'].value.length;
}
</script>
                  </div>
                  
                </div>
                <div class="box-footer">
                  <div class="pull-right">
                    
                    <button type="submit" class="btn btn-primary" name="send" onClick="return confirm('Cette action va envoyer un SMS à tous ces Numéros, Veuillez confirmer?')" <?php  echo ($constraint==1) ? "" : "disabled"  ?>> <i class="fa fa-envelope-o"></i> Envoyer</button>
                  </div>
                  <button class="btn btn-default" type="reset"><i class="fa fa-times"></i> Annuler</button>
                </div><!-- /.box-footer -->
                   <!-- /.table -->
                  </div><!-- /.mail-box-messages -->
                </div><!-- /.box-body -->
                
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
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

    <!-- REQUIRED JS SCRIPTS -->
<?php
		    include_once("php/importation_js.php");

        	?>
  </body>
</html>
