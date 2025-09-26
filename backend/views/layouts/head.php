<?php
// Inclure le fichier de configuration des constantes
    require_once __DIR__ . '/../../../config/constants.php';  
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TrustedCargo</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->


    <link href="<?= BASE_URL ?>assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= BASE_URL ?>assets/css/font-awesome/font-awesome.min.css" rel="stylesheet">


    <link href="<?= BASE_URL ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet">





    <!-- DataTables -->
    <?php
    //*******************************Impotation des Dependences du pluggins Datatable********************
    $requirement_datatable = (isset($set_pluggin_datatable)) ? '<link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/datatables/dataTables.bootstrap.css">' : "";
    echo $requirement_datatable;

    $total_notification = 0;
    ?>
    <!-- date-range-picker -->
    <?php
    //*******************************Impotation des Dependences du pluggins Select********************
    $requirement_selection_wise = (isset($set_pluggin_selection_wise)) ?
        '<link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/daterangepicker/daterangepicker-bs3.css">
	    <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/select2/select2.min.css">' : "";
    echo $requirement_selection_wise;


    ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/datepicker/datepicker3.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/additional.css">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets//css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/additional_sheet.css">
    <link rel="icon" type="image/png" href="../images/logo.png" />

</head>