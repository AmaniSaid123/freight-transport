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
	$get_active_submenu="in";
	$page_titre="SMS";
	$page_small_detail="MyPASS";
	$page_location="Accueil > SMS > Boite de Reception";
	
$daterange="";
$date_from="";
$date_to="";
$sql_main_select="select * from t_sms order by idt_sms desc limit 0,500";
if(isset($_POST['Search']) && $_POST['daterange']!=''){


		$daterange=$_POST['daterange'];
		$tempo=explode("-",$_POST['daterange']);
		$date_from=trim($tempo[0]);
		$date_to=trim($tempo[1]);
		
		$sql_main_select="select t.* from t_sms
where (t.datecreation between '".$date_from."' and '".$date_to."') order by idt_sms desc
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
          <form class="form-horizontal" action="bulk_in.php"  method="post">
			 <div class="row">
 <?php 	include_once("php/menu_sub_sms.php");  	?>
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Boite Envoie</h3>
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
                              <td class="question"></td>
                                  
                                <th class="question">Sender</th>                                    
                                <th class="question">Destination</th>
                                <th class="question">Texte</th>
                                <th class="question">Statut</th>  
                                <th class="question">Reçu le</th>	
                                <th class="question">Nbre SMS(Dest mail)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

$sql_main_query = $bdd->query($sql_main_select);


  $index=0;
		  while($donnees = $sql_main_query->fetch()){
		  $index++;
		  
	?>	
  <tr>
    <td><?php echo $index; ?></td>
    <td><?php echo $donnees['sender']; ?></td>        
    <td><?php echo $donnees['mobile_number']; ?></td>
    <td   width="60%"><?php echo $donnees['message']; ?></td>
    <td><?php echo $donnees['statut']; ?></td>  
    <td><?php echo $donnees['datecreation']; ?></td>
    <td><?php echo $donnees['nb_sms']; ?></td>
    </tr>
  <?php  
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
