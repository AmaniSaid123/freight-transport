<?php
	//******************IDPAGE*****************
	$idpage=27;
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

$get_active_menu="reporting";
	$page_titre="Rapport des SMS";
	$page_small_detail="MyPASS";
	$page_location="Menu SMS > Rapport de Caisse";

$active_export="no";
//****************location******************

	
$param_query="SELECT sum(nb_sms) as total, month(datecreation) as month_1, year(datecreation) as year_1 FROM t_sms where mobile_number not like '%@%' group by month(datecreation),year(datecreation);";	

if(isset($_POST["submit"])){
	
$search_btn_clicked=1;

$warning="yes";
$warning_message="Pour voir le résumé, défilez plus bas! ";
	
				if(isset($_POST['daterange']) && $daterange=$_POST['daterange']!=""){
					
					$tempo=explode("-",$_POST['daterange']);
					$date_debut=trim($tempo[0]);
					$date_fin=trim($tempo[1]);
			
				}
				
				if(isset($_POST['chk_export_csv']) && $daterange=$_POST['chk_export_csv']=="ok"){
					
					$active_export="yes";
			
				}
				
$daterange=$_POST['daterange'];
$ref_agent=$_POST['ref_agent'];
$caisse_activite=$_POST['caisse_activite'];

$param_query=" select t.*, label from t_grand_journal t join t_livre_compte on ref_compte=account_no where account_no='57' and ref_agence_action=".$_SESSION['my_agence']." ";
//$param_query1=" ";
		if($ref_agent!=""){
		
		$param_query=$param_query." and t.ref_user='".$ref_agent."' ";
		$caisse_activite="";
		
		}
		if($caisse_activite!=""){
		
		$param_query=$param_query." and ref_caisse='".$caisse_activite."'  ";
		$ref_agent="";
		
		}
					 		
		if($daterange!=""){
		
		$param_query=$param_query." and (t.creationdate between '".$date_debut." 00:00:00' and '".$date_fin." 23:59:59') ";
		
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
<form class="form-horizontal" action="report_sms.php"  method="post">
 	<div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">Résumé</h3>
                  <div class="box-tools pull-right">
                  
                              

              </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                  <div class="box-body">
                   
				    <div class="box-body">
                   
				    <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                    <h2><?php $total_sms= get_parameter_value("stock_sms"); echo $total_sms; ?><sup style="font-size: 20px">SMS</sup></h2>
                  <p></p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">Bundle de SMS achété <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red-active">
                <div class="inner">
                  <h2><?php echo get_total_SMS() ; ?><sup style="font-size: 20px">SMS</sup></h2>
                  <p></p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">SMS Déjà utilisé<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                   <h2><?php echo ($total_sms-get_total_SMS()); ?><sup style="font-size: 20px">SMS</sup></h2>
                  <p></p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">SMS restant <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <!-- ./col -->
          </div>
                </div>
                </div><!-- /.box-body -->
                  <div class="box-footer">
					
                  </div><!-- /.box-footer -->
                
              </div><!-- /.box -->
                
          </form>    
          <form method="post" action="v_report_journal_caisse.php" name="view_printable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Mode Liste</h3>
                  <div class="box-tools pull-right">
                   
                  <?php //echo ($active_export=="yes") ? '<a class="btn btn-success pull-right" href="fichier/ExportFileJournalCaisse_'.$_SESSION['my_username'].'.csv"><i class="fa  fa-file-excel-o fa-download"> Exporter en CSV </i> <i class="fa fa-download"></i></a>' : ''; ?>
                  
                  
                  
                </div><!-- /.box-header -->
                <div class="box-body">
    
               
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      <th>Mois </th>                      
                      <th>Total des SMS Envoyé</th>

                           
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
		
		$sql_result1 = $bdd->query($param_query);
		//echo $param_query;
		
  $index=1;
  				

		  while($data1 = $sql_result1->fetch()){
		  $index++;
		  
		 		  	
			
		  
		  	?>	
                      <tr>
                      <td><?php	echo $data1['month_1']."-".$data1['year_1'] ;?></td> 
                      <td><?php	echo $data1['total']." SMS";?></td>                      

                         
                                             
                 </tr>
                  <?php 
	
		  }
		  
		  
		 			?> 
                   
   
                    </tbody>
                    
                  </table>
                 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </form>
              
           		
                       
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
