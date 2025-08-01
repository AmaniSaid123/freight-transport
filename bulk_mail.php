<?php
	//******************IDPAGE*****************
	$idpage=30;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	include_once("php/function_sendsms.php");	
	//include("param.php");	
		
	

	//****************location******************
	$set_pluggin_datatable="yes";
	$set_pluggin_selection_wise="yes";	
	$set_plugin_daterange="yes";	
	$get_active_menu="sms";
	$get_active_submenu="";
	$page_titre="Email Bulk";
	$page_small_detail="MyPASS";
	$page_location="Accueil > SMS & MAIL >  Bulk Mail";
	
		
		$broad="";
		$text="";
		
$constraint=0;
//********************************************************


//**************************************************************
if(isset($_POST['send2'])){

    $success="yes";
    $success_message=$_POST['message'];
    add_notification("t_bulk",0,"NA","Text : ".addslashes($_POST['message']). " participants",$_SESSION['my_username'],"Ajout bulk");

}



if(isset($_POST['send'])){
    $to_destination="";	
    $to_destination_all="";	
	add_notification("t_bulk",0,"NA","Text : ".addslashes($_POST['message']). " A ".$_POST['total']." Clients",$_SESSION['my_username'],"Ajout bulk");
$count_msg=0;	
		

if($_POST['total']>0){


for($i=1;$i<=$_POST['total'];$i++){

if(isset($_POST['chk'.$i]) && $_POST['chk'.$i]=='on' && validEmail($_POST['email'.$i])){
  $to_destination_all=($i==1) ? $_POST['email'.$i] : $to_destination.",".$_POST['email'.$i];
  $to_destination=$_POST['email'.$i];
	//$sql_query=mysql_query("insert into t_out(recipient,text,creationdate,ref_bulk,ref_user) values('".$_POST['phone'.$i]."','".$_POST['message']."',now(),'bulk','".$_SESSION['username']."')");
    //send_sms($_POST['phone'.$i],$_POST['message'],"PASSPORT","NA","User","NA");
        $text_message =str_replace("@identite",$_POST['identite'.$i],$_POST['message']) ;
        
        $sujet=$_POST['sujet'];
        
        include("send_mail_bulk.php");
    $count_msg++;
	
	}
 
   

}

        
	//$count_msg++;


}

add_action_info(0, 28, "", "", "", "", "Valide", $_SESSION['my_username'], "Non", "Destinations : ".$count_msg." | Message : ".addslashes($_POST['message']), 0, 1);
$query="INSERT INTO `t_sms` (`sender`, `mobile_number`, `message`, `datecreation`, `msg_id`, `statut`, `source_action`, `numero_compte`, `type_compte`, `ref_user`,nb_caractere,nb_sms) VALUES ('PASSPORT', '".$to_destination_all."', '".$_POST['message']."',now(), 'SENT', 'SENT', 'Mail', '', '', '".$_SESSION['my_username']."',".$count_msg.",".$count_msg.")";
$resultat=$bdd->exec($query);
$success="yes";
	$success_message="Bulk effectué, Messages envoyés : ".$count_msg."";
			
	}
//*********Initialisation****
$sql_main_select="select distinct email,identite as name, 'Inc' as surname from t_dossier where 0";
if(isset($_POST['Search'])){
	$constraint=1;
		
		
		
	
		
		$param_broad="select distinct email,identite as name, 'Inc' as surname from t_dossier where 1 ";		
		$compteur=0;
		
		
		
		
		
    if($_POST['pays']!=''){
        $constraint=1;
     
        
        $param_broad=$param_broad."   and  vo_destination='".$_POST['pays']."' ";$compteur++;
        
        
        

}		

if($_POST['statut']!=''){
	$constraint=1;
 
    
    $param_broad=$param_broad."    and statut_dossier='".$_POST['statut']."' ";$compteur++;
    
    

}		
              

if($_POST['agence']!=''){
	$constraint=1;

    $param_broad=$param_broad."   and  ref_agence='".$_POST['agence']."'";$compteur++;
    
    


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
          <form class="form-horizontal" action="bulk_mail.php"  method="post" name="Myform" style="overflow-y: scroll;" >
			 <div class="row">

            <div class="col-md-12">
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
             
               <div class="box-body" >
                
                     <table class="table table-bordered table-striped">
  <tr>
    
    
    <th class="question">Client MyPASS selon Agence</th>
    <th class="question">Client MyPASS selon Destination</th>
    <th class="question">Client MyPASS selon statut Dossier</th>
    
     
  </tr>
  <tr>
    
  
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
</form>
<form class="form-horizontal" action="bulk_mail.php"  method="post" name="Myform" style="overflow-y: scroll;" >
<div class="col-md-11">
           
           <div class="box-body" >
                 
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Objet du Mail</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" name="sujet" value="" placeholder="Tappez l'objet du mail ICI" >
                      </div>
                    </div>

                  <div class="form-group">
                  <br><strong>Destinateurs <small class="label bg-red">Distinctes</small></strong>
        <div id="contact"  style="overflow-y: scroll;height : 200px; " >
        <?php
		$idx=0;
        //echo $sql_main_select;
		if($constraint>=1){
		$sql_main_query = $bdd->query($sql_main_select." group by email,identite,'Inc'");
		//echo $sql_main_select;
		 while($donnees = $sql_main_query->fetch() ){
			
			  $mail = $donnees['email'];
        
      if(validEmail($mail)){
        $idx++;
        if($idx%2==0){
				  echo '<small class="label pull-right bg-blue"><input name="chk'.$idx.'" type="checkbox" value="on" checked="true"><input name="identite'.$idx.'" type="hidden" value="'.$donnees['name'].'" ><input name="email'.$idx.'" type="hidden" value="'.$mail.'" >'.$mail.'-'.$donnees['name'].'</small>';
				 }else{
					 
					  echo '<small class="label pull-right bg-green"><input name="chk'.$idx.'" type="checkbox" value="on" checked="true"><input name="identite'.$idx.'" type="hidden" value="'.$donnees['name'].'" ><input name="email'.$idx.'" type="hidden" value="'.$mail.'" >'.$mail.'-'.$donnees['name'].'</small>';
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

        
</p>

<textarea class="textarea" name="message" required  id="zone" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                  
                    <script type='text/javascript'>
document.forms['Myform'].elements['message'].onkeyup=function(){
   document.forms['Myform'].elements['nbcaractere'].value=document.forms['Myform'].elements['message'].value.length;
}
</script>
                  </div>
                  
                </div>
                <div class="box-footer">
                  <div class="pull-right">
                    
                    <button type="submit" class="btn btn-primary" name="send" onClick="return confirm('Vous etes sur le point d envoyer  un mail, Veuillez confirmer?')" <?php  echo ($constraint==1) ? "" : "disabled"  ?>><i class="fa fa-envelope-o"></i> Envoyer</button>
                    
                 
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
