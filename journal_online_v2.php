<?php
//******************IDPAGE*****************

//Session check****************************
include_once("php/session_check_online.php");
include_once("php/function.php");
//********************locally Additionnal Function*************
//*********************Get Profile Data*****
$set_pluggin_datatable = "yes";
$set_pluggin_selection_wise = "yes";

//***********************Find Profile****************
//*************************Selection des informations du profile************************



$active_export = "no";
//****************location******************

$data_dossier = "";

if (isset($_GET['find'])) {
    $edit = clean_in_integer($_GET['find']);
    $data_dossier = get_dossier_data($edit);
    if ($data_dossier['is_exist'] == 1) {
        $_SESSION['my_doc_online'] = $edit;
    } else {
    }
}
if ($_SESSION['my_doc_online'] != "NA") {

    $edit = $_SESSION['my_doc_online'];

    $data_dossier = get_dossier_data($edit);
    if ($data_dossier['is_exist'] == 1) {
        $_SESSION['my_doc_online'] = $edit;
    } else {
        header("Location: home.php?error=ok&msg=Ce Profile n'existe pas, vous n'etes pas autorise à la page suivante");
    }
}
$get_active_menu = "dossier_online";
$page_titre = "Journal Historique : " . $data_dossier['identite'] . " NID : " . $data_dossier['nid_pp'];
$page_small_detail = "MyPASS";
$page_location = "Gestion Dossiers > Journal Historique";
?>



<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="back/assets/" data-template="vertical-menu-template-free">

<?php
include_once("php/layouts/head-v2-back.php");
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif
    }

    .container .table-wrap {
        margin: 20px auto;
        overflow-x: auto
    }

    .container .table-wrap::-webkit-scrollbar {
        height: 5px
    }

    .container .table-wrap::-webkit-scrollbar-thumb {
        border-radius: 5px;
        background-image: linear-gradient(to right, #5D7ECD, #0C91E6)
    }


    .btn.btn-primary.h-1 {
        background-color: #FB0778;
        color: white;
        font-size: 14px;
        border: none;
        padding: 2px 10px
    }

    .btn.btn-primary.h-1:hover {
        background-color: #ee1a7d
    }

    .btn.btn-primary.h-2 {
        background-color: #f8d303;
        color: white;
        font-size: 14px;
        border: none;
        padding: 2px 10px
    }

    .btn.btn-primary.h-2:hover {
        background-color: #c5b140
    }

    .btn.btn-primary.h-3 {
        background-color: #6f00ff;
        color: white;
        font-size: 14px;
        border: none;
        padding: 2px 10px
    }

    .btn.btn-primary.h-3:hover {
        background-color: #7638c9
    }

    .bg-pink {
        height: 10px;
        width: 10px;
        background-color: #ee1a7d
    }

    .bg-yellow {
        height: 10px;
        width: 10px;
        background-color: #f8d303
    }

    .bg-violet {
        height: 10px;
        width: 10px;
        background-color: #6f00ff
    }

    .btn.btn-secondary.pink {
        background-color: transparent;
        font-size: 12px;
        border: none;
        background-color: #f5cade;
        color: #ee1a7d;
        width: 100%;
        padding: 5px 15px
    }

    .btn.btn-secondary.violet {
        background-color: transparent;
        font-size: 12px;
        border: none;
        color: #7638c9;
        background-color: #d8c6f0;
        width: 100%;
        padding: 5px 15px
    }

    .btn.btn-secondary.yellow {
        background-color: transparent;
        font-size: 12px;
        border: none;
        background-color: #f7ecb1;
        color: #f88e03;
        width: 100%;
        padding: 5px 15px
    }

    @media(min-width: 992px) {
        .container .table-wrap {
            overflow: hidden
        }
    }
</style>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php
            include_once("php/layouts/menu-v2-back.php");
            ?>
            <div class="layout-page">
                <?php
                include_once("php/layouts/navbar-v2-back.php");
                ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?php include_once("php/print_message_front.php"); ?>
                        <h6 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dossier en ligne /</span> Journal Dossier</h6>

                        <div class="row">
                            <div class="col-xxl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0 style-h5">Historique Timeline du Dossier : <?php echo $data_dossier['identite'] . " | NID = " . $data_dossier['ndel']; ?>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <fieldset>
                                            <div class="form-card">
                                                <form class="form-horizontal" action="vue_dossier.php" method="post">
                                                    <div class="container bg-light">
                                                        <div class="table-wrap table-responsive">
                                                            <table class="table table-borderless">
                                                                <thead>
                                                                    <tr class="p-0">
                                                                        <td class="w350 p-0" scope="col"> <small class=" btn btn-primary h-1 px-2">HISTORIQUE</small> </td>
                                                                        <td class="text-center w100 p-0 py-2" scope="col"><small class="text-muted">DATE DE CRÉATION</small> </td>
                                                                        <td class="text-center w100 p-0 py-2" scope="col"><small class="text-muted">ACTION</small></td>
                                                                        <td class="text-center w100 p-0 py-2" scope="col"><small class="text-muted">NOTIFICATION</small> </td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    ?>

                                                                    <?php
                                                                    $sql_select1 = "SELECT t.*, label_icone, t_operation.label as operation FROM passport_bd.t_actions t join t_operation on ref_operation=idt_operation where ref_dossier=" . $_SESSION['my_doc_online'] . " and t.customer_viewable='Oui' order by idt_actions desc";
                                                                    //echo $sql_select1;

                                                                    $sql_result1 = $bdd->query($sql_select1);

                                                                    $index2 = 0;

                                                                    while ($data1 = $sql_result1->fetch()) {
                                                                        $index2++;
                                                                    ?>

                                                                        <tr class="border-bottom bg-white">
                                                                            <td class="row">
                                                                                <div class="d-flex align-items-center"> <span class="bg-pink mx-2"></span> <span><?php echo $data1['operation'] . " par ";
                                                                                                                                                                    echo ($data1['ref_requester'] == "online_user") ? $data_dossier['identite'] : "Administration"; ?></a> <?php echo ""; ?></span> </div>
                                                                            </td>
                                                                            <td class="text-center"><span class="far fa-calendar-alt text-muted"> <?php echo $data1['creationdate']; ?></span></td>
                                                                            <td class="text-center"><span class="btn btn-secondary pink"> <?php echo $data1['commentaire']; ?></span> </td>
                                                                            <td class="text-center"><span class="far fa-flag text-muted"><?php echo ($data1['notification_sms'] == "1") ? '<i class="fa fa-wechat bg-blue">SMS</i>' : '';
                                                                                                                                            echo ($data1['notification_email'] == "1") ? '<i class="fa fa-envelope bg-green">Mail</i>' : '';
                                                                                                                                            echo ($data1['notification_appel'] == "1") ? '<i class="fa fa-phone bg-red">Appel</i>' : ''; ?></span></td>
                                                                        </tr>

                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </form>
                                                <br>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <div class="form-card">
                                                <div style="overflow-x:auto;">
                                                    <div class="card">
                                                        <h5 class="mb-0 style-h5">Mode Liste
                                                        </h5>
                                                        <div class="card-body">
                                                            <div class="table-responsive text-nowrap">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Date creation</th>
                                                                            <th>Initiateur</th>
                                                                            <th>Commentaire</th>
                                                                            <th>Operation</th>
                                                                            <th>Notification</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>


                                                                        <?php
                                                                        $sql_select1 = "SELECT t.*, label_icone, t_operation.label as operation FROM passport_bd.t_actions t join t_operation on ref_operation=idt_operation where ref_dossier=" . $_SESSION['my_doc_online'] . " and t.customer_viewable='Oui' order by idt_actions desc";
                                                                        //echo $sql_select1;

                                                                        $sql_result1 = $bdd->query($sql_select1);

                                                                        $index = 0;

                                                                        while ($data1 = $sql_result1->fetch()) {


                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $index; ?></td>
                                                                                <td><?php echo $data1['creationdate']; ?></td>
                                                                                <td><?php echo ($data1['ref_requester'] == "online_user") ? $data_dossier['identite'] : 'Administrateur'; ?></td>
                                                                                <td><?php echo $data1['commentaire']; ?></td>
                                                                                <td><?php echo $data1['operation']; ?></td>
                                                                                <td><?php echo ($data1['notification_sms'] == "1") ? '<i class="fa fa-wechat bg-blue">SMS</i>' : '';
                                                                                    echo ($data1['notification_email'] == "1") ? '<i class="fa fa-envelope bg-green">Mail</i>' : '';
                                                                                    echo ($data1['notification_appel'] == "1") ? '<i class="fa fa-phone bg-red">Appel</i>' : ''; ?>

                                                                                </td>
                                                                            </tr>

                                                                        <?php
                                                                        }
                                                                        ?>


                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        include_once("php/layouts/footer-v2-back.php");
                        ?>

                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
                <div class="layout-overlay layout-menu-toggle"></div>
            </div>
            <?php
            include_once("php/layouts/script-v2-back.php");
            ?>
        </div>
    </div>
</body>

</html>