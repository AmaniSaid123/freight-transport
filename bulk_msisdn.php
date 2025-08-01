<?php
	//******************IDPAGE*****************
	$idpage=17;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	
		
		
	//****************location******************
	$set_pluggin_datatable="yes";
	$set_pluggin_selection_wise="yes";	
	$set_plugin_daterange="yes";	
	$get_active_menu="sms";
	$get_active_submenu="broad";
	$page_titre="SMS";
	$page_small_detail="MyPASS";
	$page_location="Accueil > SMS > Repertoire des Numéros";
	
$daterange="";
$date_from="";
$date_to="";
$sql_main_select="select * from t_broadcast_list";

$url='uploads';
    $dateshort1=date('Ymd ');
	$heure=date('His');

//********************************************************
if(isset($_POST['submit']) && $_POST['name']!='' && isset($_FILES['attache1']) && $_FILES['attache1']['name']!=''){
	$add_broad=add_broadcast_list($_POST["name"],$_POST["description"]);
	$attache1=$url.'/'.$dateshort1.$heure.'-'.$_FILES['attache1']['name'];
	$name=$_POST["name"];
	$download_file=move_uploaded_file($_FILES['attache1']['tmp_name'],$attache1);
	//$sql_query=mysql_query("delete from t_customer where ref_base=".$_SESSION['base']);
	
	if($download_file==1 && $add_broad==1){
	$idbroadcast=get_broadcast_list($_POST["name"]);
$myfile = fopen($attache1, "r") or die("Unable to open file!");		
		$row = 0;
        while(!feof($myfile)) {
        	
  			$msisdn=fgets($myfile);

			if($msisdn!="" && strlen($msisdn)>=10){
			$sql_query="insert into t_msisdn(msisdn,creationdate,ref_broadcast_list,ref_user) values('".$msisdn."',now(),".$idbroadcast.",'".$_SESSION['username']."')";
			//echo $sql_query.";<br>";
                        $row++;
			
            $result_query=$bdd->exec($sql_query);
			
			}
	
      }
	  fclose($myfile);
		$sql_query=$bdd->exec("update t_broadcast_list set total_msisdn=".$row.", url_file='".$attache1."' where idbroadcast=".$idbroadcast);
		
		
				if($sql_query==1){
					
					//header("Location:bulk_msisdn.php?success=ok&msg=Le repertoire des numeros créés avec succès, Total numéro : ".$row);
					$success="yes";
		            $success_message="Le repertoire des numeros créés avec succès, Total numéro : ".$row;
						
					
					
					}else{
						
						$error="yes";
			            $error_message="Une Erreur a survenue lors de la creation du repertoire";
						
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
          <div id="light" class="white_content">

  <?php  
if(isset($_GET['idbroad']) && isset($_GET['action'])){
	?>         
    <a onClick="hide_pop()"><i class="fa  fa-close"></i>Fermer Ici</a>
    
                                 <table id="example4" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                              <th class="question">Numéro du repertoire : <?php echo $_GET['ref_name']; ?></th>
                               
                                	
                      </tr>
                    </thead>
                    <tbody>
                     
 <?php 

$sql_main_query1 = $bdd->query("select msisdn from t_msisdn where ref_broadcast_list=".$_GET['idbroad']);

  $index1=0;
		  while($donnees = $sql_main_query1->fetch()){
		  $index1++;
		  
	?>	
  <tr>

    <td><?php echo $donnees['msisdn']; ?></td>
   
     
    </tr>
  <?php  
}
	?>	
    
     
                    </tbody>
                   
                  </table>

  <?php  
}
	?>                  
          </div>
    <div id="fade" class="black_overlay"></div>
          <form class="form-horizontal" action="bulk_msisdn.php"  method="post" enctype="multipart/form-data">
			 
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
              <h3 class="box-title">Zone de Critère</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-10">
             
               <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Nom</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="name"  placeholder="Tapez ici le Nom repertoire">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="description"  placeholder="Ecriver votre description Ici">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Attaché les numéro</label>
                      <div class="col-sm-10">
                        <input type="file" id="exampleInputFile" name="attache1" accept=".txt,.csv">
                        <p class="help-block">Veuillez choisir le fichier contenant les numéros</p>
                      </div>
                    </div>

               
					</div>
                </div><!-- /.col -->
                
                </div><!-- /.col -->
              </div><!-- /.row -->
              <div class="box-footer">
                    <button type="reset" class="btn btn-default" >Annuler</button>
                    <button type="submit"  class="btn btn-info pull-right" name="submit">Valider</button>
                                     
                  </div>
            </div><!-- /.box-body -->

                  <div class="table-responsive mailbox-messages">
           
                                 <table id="example3" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                              <th class="question"></th>
                                <th class="question">Nom</th>
                                <th class="question">Description</th>  
                                <th class="question">Total Numéro</th>  
                                <th class="question">Créé le</th>                                                               
                                <th class="question">Créé par</th>
                                <th class="question"></th>
                      </tr>
                    </thead>
                    <tbody>
                     
 <?php 

$sql_main_query = $bdd->query($sql_main_select);
$data[1]=array("Nom","description","Total numero","creer le","Creer par");
  $index=0;
		  while($donnees = $sql_main_query->fetch()){
		  $index++;
		  $data[$index+1]=array($donnees['name'],$donnees['description'],$donnees['total_msisdn'],$donnees['creationdate'],$donnees['ref_user']);
	?>	
  <tr>
    <td><?php echo $index; ?></td>
    <td><?php echo $donnees['name']; ?></td>
    <td><?php echo $donnees['description']; ?></td>
    <td><?php echo $donnees['total_msisdn']; ?></td>    
    <td><?php echo $donnees['creationdate']; ?></td>    
    <td><?php echo $donnees['ref_user']; ?></td>
    <td><a href="bulk_msisdn.php?idbroad=<?php echo $donnees['idbroadcast']; ?>&ref_name=<?php echo $donnees['name']; ?>&action=yes"><i class="fa fa-television"></i></a></td>
     
    </tr>
  <?php  
}
	?>	
    
  <?php
if(isset($_POST['Search'])  ){
$chemin_fich="fichier\/Smsbroacast.csv";

if ($f = @fopen($chemin_fich, 'w')) {
  foreach ($data as $ligne) {
    fputcsv($f, $ligne);
    }
  fclose($f);
  }
}
?>
   
                    </tbody>
                   
                  </table>
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
