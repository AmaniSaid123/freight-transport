<?php
	//******************IDPAGE*****************

	//Session check****************************
	

	include_once("php/function.php");
	$error="no";
$warning="no";
$success="no";
$information="no";

$error_message="Error on the page Errorcode=xx001Defaults";
$warning_message="This is a warning";
$success_message="Your request succeed";
$information_message="Welcome in Web-sms";
	//********************locally Additionnal Function*************
	
	//****************location******************


	$page_titre="Conditions d'adhésion";
	$page_small_detail="";
	$page_location="";
	
	//*************************************************************
if(isset($_POST['submit_privacy'])){
	
	
	
	
	}	
	
	?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Online MyPASS</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <!-- Ionicons 
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
    <!-- DataTables -->
    <?php	
	//*******************************Impotation des Dependences du pluggins Datatable********************
	$requirement_datatable=(isset($set_pluggin_datatable)) ? '<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">' : "";
	echo $requirement_datatable;
	
	
	?>
    <!-- date-range-picker -->
    <?php	
	//*******************************Impotation des Dependences du pluggins Select********************
	$requirement_selection_wise=(isset($set_pluggin_selection_wise)) ? '<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
	    <link rel="stylesheet" href="plugins/select2/select2.min.css">' : "";
	echo $requirement_selection_wise;
	
	
	?>
    
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="css/additional.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="css/additional_sheet.css">
        	<link rel="icon" type="image/png" href="../images/logo.png" />
	<!-- iCheck -->
   
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="hold-transition skin-blue sidebar-mini <?php	echo (isset($is_fixed)) ? "fixed" : ""; ?>">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="home.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>PASS</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>MYPASS</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          

          <!-- search form (Optional) -->
          
          <!-- /.search form -->

          <!-- Sidebar Menu -->
    
         
         <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        
        <!-- Main content -->
        <section class="content">
<?php  include_once("php/print_message.php"); ?>
          <!-- Your Page Content Here -->
 <!-- Horizontal Form -->
<img src="images/logo_passport.png" width="212" height="171" />
 <div class="box box-info">
  <div class="box-header with-border">
                  <h3 class="box-title">CONDITIONS GENERALES</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="dossier_online.php"  method="post">
                <div class="box-body">
                <ol type="I">
                <li>L’agence prendra avec ses partenaires toutes les dispositions nécessaires facilitant le voyage du client ; l’agence étant liée par l’obligation de moyen;</li>
                <li>Endéans 10 jours après l’arrivée d’une admission dont le client aura été informé, ce dernier est sensé avoir réuni tous les documents nécessaires pour le dépôt du dossier à l’ambassade conformément à la fiche sur la deuxième étape qui lui aura déjà été remise et expliquée minimum une semaine avant l’arrivée de cette admission ; L’explication de ladite fiche se fera au cours d’une réunion dont la présence des clients invités sera constatée par leur identité et leur signature dans une liste de présence ;</li>
                <li>Pour une raison dépendant du client lui-même (par exemple si le client n’a pas payé à temps les frais de la deuxième tranche ou n’a pas fourni à temps les documents de la deuxième étape des démarches ou autre raison ayant retardé l’avancement du dossier), le report de l’admission est sanctionné des frais de pénalités que ce client devra payer, allant de 250 USD à 550 USD selon les cas et les universités ;</li>
                <li>L’agence exécutera sa mission qu’une fois qu’un paiement total sera effectué par le client. Néanmoins, en cas de versement par le client d’une tranche comme paiement partiel exigé, celui – ci devra régler, dans un délai de 10 jours précédant la finition de premiers services rendus, la tranche suivante, selon les services à rendre, sous peine de mettre la société en droit de se déresponsabiliser de premiers services rendus au nom du client et l’acompte versé sera ainsi perdu ; 
</li>
                <li>La responsabilité de l’agence est dégagée en cas d’annulation de voyages, des modifications de trajet, des retards ou de changement de quelle que nature que ce soit relatif aux services de voyage et sous l’influence du client ou des circonstances de force majeure ;
</li>
                <li>La responsabilité de l’agence est dégagée si le client n’a pas fourni dans le délai les éléments exigés pour le voyage ou s’il a fourni d’éléments considérés de non authentiques et ayant conduit à l’échec de ses démarches de voyage ;</li>
                <li>En cas d’échec de la première tentative de délivrance d’un visa d’études, l’agence se réserve le droit de relancer, uniquement pour une seconde fois, les démarches à cet effet, sans que le client n’ait encore à débourser les frais de base (première et deuxième tranches) ayant déjà été payés aux démarches précédentes. Après deux refus de visas, l’unique option restante est celle de choisir une autre destination parmi celles qui seront proposées par l’agence ;
</li>
                <li>L’obtention d’un remboursement n’est pas possible pour un voyage ou pour des services non consommés ou ceux déjà en cours ;
</li>
                <li>Après paiement, PASSPORT SARL attribue à chaque client un Numéro d’Identification du Dossier (NID), lequel contient les informations et mises à jour relatives à son dossier. Le client est tenu de consulter régulièrement le site internet de PASSPORT afin de prendre connaissance, grâce à son NID, de l’évolution de son dossier et pouvoir faire le suivi lui-même. De ce fait, PASSPORT SARL ne saurait engager sa responsabilité pour tout préjudice découlant du fait que le CLIENT n’a pas consulté les informations pourtant disponibles dans son NID ;</li>
                <li>A l’obtention d’un visa d’études ou autre visa, il est d’obligation au client de participer à la prise des photos souvenirs avec l’équipe PASSPORT Sarl dans les locaux de l’Agence ou à son voisinage ou encore à tout autre endroit où l’agence aura choisi d’organiser une cérémonie de remise des visas et de prise des photos, et autorise, à cet effet, l’agence à utiliser, si bon lui semble, ces photos pour des raisons publicitaires saines ;</li>
                <li>A l’obtention du visa, le client ramène le passeport à l’agence pour la clôture du dossier, sans quoi le dossier ne peut être clôturé.  La date du voyage est fixée par l’agence en vue de permettre au client de s’accorder au processus de clôture du dossier qui doit être finalisé par l’agence. Le tout sans préjudicier le client par rapport à la date de rentrée des cours à son université ;</li>
                <li>A la signature de ce contrat, le client et tout membre de sa famille ou ses amis l’ayant accompagné et se retrouvant dans les photos prises par l’agence, autorise celle-ci à utiliser ces photos pour des raisons publicitaires conformément au point (X) précédent ;</li>
                <li>Pour des raisons politiques sur le plan national, régional ou mondial ou bien pour des raisons climatiques qui ne constituent pas une menace grave pour le déroulement du voyage, aucun montant ne sera remboursé ;</li>
                <li>Ce contrat s’applique à tout client l’ayant signé, que ses démarches de voyage aient commencé à l’agence PASSPORT SARL ou ailleurs ;</li>
                <li>Les présents termes s’appliquent également au mandant dont le mandataire a signé ce formulaire ;</li>
                <li>Le masculin est utilisé dans ce document pour représenter le genre humain sans restriction.</li>
                
                </ol>

                     
                
              </div>
              <div class="box-footer">
                    
                    <
                  </div>
              </form>
               </div>
               
              <!-- /.box -->
              
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
		    //include_once("php/tableau_controle.php");

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
