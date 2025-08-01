<?php
	//******************IDPAGE*****************
	$idpage=16;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//****************location******************
	$set_pluggin_datatable="yes";
	$set_pluggin_selection_wise="yes";	
	$set_plugin_daterange="yes";	
	$get_active_menu="sms";
	$get_active_submenu="out";
	$page_titre="SMS";
	$page_small_detail="Web-sms";
	$page_location="Accueil > SMS > Boite d'Envoie";
	
$daterange="";
$date_from="";
$date_to="";
$sql_main_select="select t.*, z.name, z.surname, t_ministere.name as ministere, province from t_out t left join t_participant z on recipient=phone left join t_ministere on ref_ministere=idministere order by idout desc";
if(isset($_POST['Search'])  && $_POST['daterange']!=''){


		$daterange=$_POST['daterange'];
		$tempo=explode("-",$_POST['daterange']);
		$date_from=trim($tempo[0]);
		$date_to=trim($tempo[1]);
		
		$sql_main_select="select t.*, z.name, z.surname, t_ministere.name as ministere, province from t_out t left join t_participant z on recipient=phone left join t_ministere on ref_ministere=idministere
where (t.creationdate between '".$date_from."' and '".$date_to."') order by idout desc
";		
		
		
		
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
          <form class="form-horizontal" action="bulk_out.php"  method="post">
			 <div class="row">
 <?php 	include_once("php/menu_sub_sms.php");  	?>
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Boite d'Envoie</h3>
                  <div class="box-tools pull-right">
                    <div class="has-feedback">
                    <input type="text" class="form-control pull-right" id="date1" name="daterange" value="<?php echo $daterange; ?>" placeholder="Specifiez une date">

                      <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button onclick="exportTableToCSV('SmsOut.csv')" class="btn btn-default pull-left" ><i class="fa  fa-file-excel-o fa-download"> Exporter en CSV </i> <i class="fa fa-download"></i></button>
                    <button type="submit"  class="btn btn-info pull-right" name="Search" ><i class="fa   fa-tripadvisor"></i>Afficher</button>                    
                  </div>
                  <div class="table-responsive mailbox-messages">
                                 <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                              <th class="question"></th>
                                <th class="question">Identité</th>
                                <th class="question">Ministère</th>    
                           
                                <th class="question">Téléphone</th>
                                <th class="question">Texte</th>
                                <th class="question">Reçu le</th>	
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

$sql_main_query = mysql_query($sql_main_select);
$data[1]=array("Recipient","Text","Creation date","Created by");
  $index=0;
		  while($donnees = mysql_fetch_array($sql_main_query)){
		  $index++;
		  $data[$index+1]=array($donnees['recipient'],$donnees['text'],$donnees['creationdate'],$donnees['ref_user']);
	?>	
  <tr>
    <td><?php echo $index; ?></td>
    <td><?php echo $donnees['name']; ?></td>
    <td><?php echo $donnees['ministere']; ?></td>
     
    <td><?php echo $donnees['recipient']; ?></td>
    <td><?php echo $donnees['text']; ?></td>

    <td><?php echo $donnees['creationdate']; ?></td>
    </tr>
  <?php  
}
	?>	
    
 <?php
if(isset($_POST['Search'])  ){
$chemin_fich="fichier\/SmsOut.csv";

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
