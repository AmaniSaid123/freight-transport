<?php
//******************IDPAGE*****************
$idpage = 41;
//Session check****************************
include_once("php/session_check.php");
include_once("php/function.php");
//********************locally Additionnal Function*************
//*********************Get Profile Data*****
$set_pluggin_datatable = "yes";
$set_pluggin_selection_wise = "yes";
$set_plugin_daterange = "yes";
//***********************Find Profile****************
//*************************Selection des informations du profile************************

$get_active_menu = "DG";
$page_titre = "Direction Générale >  Ajouter Banner";
$page_small_detail = "Ajouter Banner";
$page_location = "Direction Générale >  Ajouter Banner";
$agence = '';
$price = '';
$compte = '';
if (isset($_POST['submit_add'])) {

    $compte = $_POST['compte'];
    $agence = $_POST['agence'];
    $price = $_POST['price'];
    $feedback = add_banner($compte, $agence, $price);

    if ($feedback == 1) {
        $success = "yes";
        $success_message = "Banner créé avec succès";
    } else {
        $error = "yes";
        $error_message = "Erreur lors de création de banner";
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
<?php ?>
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
        <?php include_once("php/print_message.php"); ?>
        <!-- Your Page Content Here -->
        <!-- Horizontal Form -->
        <div id="light" class="white_content">



        </div>
        <div id="fade" class="black_overlay"></div>

        <form onsubmit="ShowLoading()" class="form-horizontal" action="add_banner.php" method="post">

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Ajouter Banner</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Compte</label>
                        <div class="col-sm-10">
                            <select class="form-control  select2" name="compte">
                                <?php echo getcombo_compte($compte); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Agence</label>
                        <div class="col-sm-10">
                            <select name="agence" class="form-control select2">
                                <option value="" <?php echo ($agence == '') ? 'selected' : ''; ?>>Toute l'entreprise</option>
                                <?php echo getcombo_agence($agence); ?>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Solde</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="price" placeholder="Saisir solde">
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">

                    <button type="submit" class="btn btn-info pull-right" name="submit_add">Ajouter</button>
                </div><!-- /.box-footer -->

            </div><!-- /.box -->

        </form>

        <div class="box" style="overflow-y: scroll;">
            <div class="box-header">
                <h3 class="box-title">Liste des banners</h3>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">

                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Compte</th>
                            <th>Agence</th>
                            <th>Solde</th>
                            <th>Date création</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_select1 = "select * from t_banners";
                        $sql_result1 = $bdd->query($sql_select1);

                        $index = 0;

                        while ($data1 = $sql_result1->fetch()) {


                            if (1) {
                                $index++;
                            }
                        ?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td>
                                    <?php echo getCompte($data1['compte'], $data1['agence']); ?>
                                </td>

                                <td>
                                    <?php echo getAgence($data1['agence']); ?>
                                </td>
                                <td><?php echo $data1['price']; ?></td>
                                <td><?php echo $data1['creationdate']; ?></td>
                                <td>
                                    
                                <a href="edit_banner.php?find=<?php echo $data1['id']; ?>" ><i class="fa fa-fw fa-pencil-square-o"></i> </a>
                            </td>

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
?>
</body>

</html>