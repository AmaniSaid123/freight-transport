<?php
	//******************IDPAGE*****************
	$idpage=41;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//****************location******************
	$set_pluggin_datatable="yes";
	$set_pluggin_selection_wise="yes";	
	$set_plugin_daterange="yes";	
	$get_active_menu="sms";
	$get_active_submenu="draft";
	$page_titre="SMS";
	$page_small_detail="MYPASS";
	$page_location="Accueil > SMS > Brouillons";
	
$daterange="";
$date_from="";
$date_to="";
$sql_main_select="select * from t_draft_msg order by iddraft asc";
if(isset($_POST['Search'])  && $_POST['daterange']!=''){


		$daterange=$_POST['daterange'];
		$tempo=explode("-",$_POST['daterange']);
		$date_from=trim($tempo[0]);
		$date_to=trim($tempo[1]);
		
		$sql_main_select="select * from t_draft_msg
where (creationdate between '".$date_from."' and '".$date_to."') order by iddraft asc
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
          <form class="form-horizontal" action="bulk_draft.php"  method="post">
			 <div class="row">
 <?php 	include_once("php/menu_sub_sms.php");  	?>
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Brouillons</h3>
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
<a class="btn btn-default btn-sm" href="fichier/Smsdraft.csv"><i class="fa  fa-cloud-download"></i> Exporter en CSV</a>                   
                    <button type="submit"  class="btn btn-info pull-right" name="Search" ><i class="fa   fa-tripadvisor"></i>Afficher</button>                    
                  </div>
                  <div class="table-responsive mailbox-messages">
                                 <table id="example3" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                              <th class="question"></th>
                                <th class="question">Date Creation</th>
                                <th class="question">Message</th>    
                           
                                <th class="question">Créé par</th>
                                <th class="question"></th>
                                	
                      </tr>
                    </thead>
                    <tbody>
                     
 <?php 

$sql_main_query = mysql_query($sql_main_select);
$data[1]=array("Date creation","Texte","creer par");
  $index=0;
		  while($donnees = mysql_fetch_array($sql_main_query)){
		  $index++;
		  $data[$index+1]=array($donnees['creationdate'],$donnees['content'],$donnees['ref_user']);
	?>	
  <tr>
    <td><?php echo $index; ?></td>
    <td><?php echo $donnees['creationdate']; ?></td>
    <td><?php echo $donnees['content']; ?></td>

    <td><?php echo $donnees['ref_user']; ?></td>
    <td><a href="bulk_sms.php?read=<?php echo $donnees['iddraft']; ?>" ><i class="fa fa-fw fa-mail-forward"></i></a></td>
     
    </tr>
  <?php  
}
	?>	
    
  <?php
if(isset($_POST['Search'])  ){
$chemin_fich="fichier\/Smsdraft.csv";

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
