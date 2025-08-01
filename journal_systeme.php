<?php
	//******************IDPAGE*****************
	$idpage=48;
	//Session check****************************
	include_once("php/session_check.php");
	include_once("php/function.php");
	//********************locally Additionnal Function*************
	
	//*********************Get Profile Data*****
$set_pluggin_datatable="yes";	
$set_pluggin_selection_wise="yes";
$set_plugin_daterange = "yes";

//***********************Find Profile****************
//*************************Selection des informations du profile************************

$get_active_menu="avance";
	$page_titre="Journal des Operations Systèmes";
	$page_small_detail="MyPASS";
	$page_location="Options Avancées > Journal des Operations Systèmes";

$active_export="no";
//****************location******************
	
	
$nid="";
$keyword="";
$ndel="";
$agence="";
$utilisateur="";
$description="";
$daterange=""; 

$param_query=" where date(t.creationdate)=date('".date('Y-m-d')."') ";
if(isset($_POST["submit"])){
	

$keyword=clean_in_text($_POST['keyword']);
$ndel=clean_in_text($_POST['ndel']);
$agence=$_POST['agence'];
$utilisateur=$_POST['utilisateur'];
$description=$_POST['description'];
$daterange=$_POST['daterange'];
   
$param_query=" where  1";


if (isset($_POST['daterange']) && $_POST['daterange'] != "") {
    //echo "oooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee";
    $tempo = explode("-", $_POST['daterange']);
    $daterange = $_POST['daterange'];
    $date_debut = trim($tempo[0]);
    $date_fin = trim($tempo[1]);
    $param_query = " where t.creationdate between '" . $date_debut . " 00:00:00' and  '" . $date_fin . " 23:59:59' ";
   
}
	
	
	if($keyword!=""){
		
		$param_query=$param_query." and sup_detail like '%".$keyword."%' ";
		
				}	
	
	if($ndel!=""){
		
		$param_query=$param_query." and id_element='".$ndel."' ";
		
		}
	
		if($agence!=""){
		
		$param_query=$param_query." and ref_agence_action=".$agence." ";
		
		}
		
		if($utilisateur!=""){
		
		$param_query=$param_query." and t.ref_user='".$utilisateur."' ";
		
		}
         
        if($description!=""){
		
            $param_query=$param_query." and description='".$description."' ";
            
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
 <form class="form-horizontal" action="journal_systeme.php"  method="post">
 	<div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">Criteres` de recherche</h3>
                  <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                

              </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                  <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Mot clés</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="keyword"  placeholder="Identité" value="<?php echo $keyword; ?>">
                        
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">NDEL</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="ndel"  placeholder="Votre NDEL" value="<?php echo $ndel; ?>">
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Utilisateur</label>
                      <div class="col-sm-4">
                        <select name="utilisateur" class="form-control select2">
                        <option value="" <?php echo ($utilisateur=='') ? 'selected' : ''; ?>>Tous les utilisateurs</option>                        
                        <?php echo  getcombo_username($utilisateur); ?>
                      </select>
                        
                      </div>
                    </div>
                      <div class="form-group">
                      <label  class="col-sm-2 control-label">Agence</label>
                      <div class="col-sm-4">
                        <select name="agence" class="form-control">
                        <option value="" <?php echo ($agence=='') ? 'selected' : 'selected'; ?>>Toutes les Agences</option>                        
                        <?php echo getcombo_agence($agence); ?>
                      </select>
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Action</label>
                      <div class="col-sm-4">
                        <select name="description" class="form-control select2">>
                        <option value="" <?php echo ($description=='') ? 'selected' : 'selected'; ?>>Toutes les actions</option>                        
                        <?php echo getcombo_description_notification($description); ?>
                      </select>
                        
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Période ciblée</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control pull-right" id="date1" name="daterange" value="<?php echo $daterange; ?>" placeholder="Specifiez une date">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Afficher Avant action commentaire</label>
                        <div class="col-sm-4">
                            <input type="checkbox" name="chk_limit_display" value="on" checked>

                        </div>
                    </div>
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
					<i class="fa  fa-warning"> Ce rapport a une limitation d'affichage de 2000 lignes </i>
                    <button type="submit"  class="btn btn-info pull-right" name="submit" >Trouver</button>
                  </div><!-- /.box-footer -->
                
              </div><!-- /.box -->
                
          </form>    
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Mode Liste</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="overflow-y: scroll;">
                
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                                            
                      <th>#</th>
                      <th width="10%">Date</th>
                      <th>Agence</th>
                      <th>Action</th>
                      <?php	if(isset($_POST['chk_limit_display'])) {?>
                      <th>Valeurs Avant</th>
                      <?php	} ?> 
                      <th width="50%">Commentaire Action</th>
                      
                      <th>Utilisateur</th>
                      <th></th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
		                        $sql_select1 = "SELECT t.*, x.label as agence from t_notification t join t_user v on v.username=t.ref_user join t_agence x on x.id_agence=v.ref_agence " . $param_query . " order by idn desc limit 0,20000";
                            //echo $sql_select1;
		
		$sql_result1 = $bdd->query($sql_select1);
		
  $index=0;

		  while($data1 = $sql_result1->fetch()){
            $index++;
		   
		  		
		  	?>	
                      <tr>
                      <td><?php	echo $index;?></td> 
                      <td><?php	echo $data1['creationdate'];?></td>   
                      <td><?php	echo $data1['agence'];?></td>   
                      <td><?php	echo $data1['description'];?></td>  
                      <?php	if(isset($_POST['chk_limit_display'])) {?>
                      <td><?php	echo $data1['before_event'];?></td>      
                      <?php	} ?>         
                      <td><?php	echo (isset($_POST['chk_limit_display'])) ? $data1['after_event'] : substr($data1['after_event'],0,200);?></td>
                      <td><?php	echo $data1['ref_user'];?></td>
                      
                      <td> </td>
                     
                 </tr>
                  <?php 
	
		  }
	
	 			?> 
   
                    </tbody>
                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           		
                       
          

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
			//include_once("php/export_to_csv_js.php");

        	?>
  </body>
</html>
