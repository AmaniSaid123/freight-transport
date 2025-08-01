<?php
//******************IDPAGE*****************
$idpage = 10;

//Session check****************************
include_once("php/session_check.php");
include_once("php/function.php");
//********************locally Additionnal Function*************
//*********************Get Profile Data*****
$set_pluggin_datatable = "yes";
$set_pluggin_selection_wise = "yes";

//***********************Find Profile****************
//*************************Selection des informations du profile************************



$active_export = "no";
//****************location******************
$cible = "vue_dossier.php";
$data_dossier = "";
$identite = "";
$date_naissance = "";
$data_agence = get_agence_data($_SESSION['my_agence']);
$contact = $data_agence['contact'];
function obfuscate_email($email)
{
    $em   = explode("@", $email);
    $name = implode('@', array_slice($em, 0, count($em) - 1));
    $len  = 3;
    return substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);
}
function hide_mobile_no($number)
{
    return substr($number, 0, 4) . '******' . substr($number, -2);
}
function hide_secret_no($number)
{
    return substr($number, 0, 1) . '******' . substr($number, -1);
}
include_once("action_zone_script.php");


$get_active_menu = "dossier";
$page_titre = "Vue sur Dossier : " . $data_dossier['identite'] . " NID : " . $data_dossier['nid_pp'];
$page_small_detail = "MyPASS";
$page_location = "Gestion Dossiers > Liste des Dossiers";
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

        <div id="light" class="white_content">
            <a onClick="hide_pop()" class="btn-danger"><i class="fa  fa-close">Fermer Ici</i></a>
            <?php include_once("vue_white_popup_zone.php"); ?>
        </div>
        <div id="fade" class="black_overlay"></div>
        <!-- Horizontal Form -->
        <?php include_once("zone_bouton_dossier.php"); ?>

        <form action="vue_dossier.php" method="post">

            <div class="box box-info" style="overflow-y: scroll;">
                <div class="box-header with-border">
                    <h3 class="box-title">1. IDENTITE DU CLIENT</h3>

                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Nom complet (tel que dans le passport) <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="identite" placeholder="Entrez votre nom tel dans le passport ici" value="<?php echo $data_dossier['identite']; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <font color="#FF0000">NID (*)------------------------------------------------------------------->></font>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="nid_pp" placeholder="Remplissez le NID si le frais de dossier est payé" value="<?php echo $data_dossier['ndel']; ?>" readonly="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <font color="#FF0000">PIN SECRET (*)-------------------------------------------------------->></font>
                        </label>
                        <div class="col-sm-6">

                            <?php

                            if (get_access(62, $_SESSION['my_idprofile']) == 1) {
                            ?>
                              <input type="text" class="form-control" name="pin_secret" placeholder="Remplissez le PIN Secret pour le Client" value="<?php echo $data_dossier['pin_secret']; ?>">
                            <?php
                            } else {
                            ?>
                                <input type="text" name="pin_secret" class="form-control" value="<?php echo hide_secret_no($data_dossier['pin_secret']); ?>" disabled>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label">Date de naissance <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" name="date_naissance" required class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask placeholder="Entrez votre date de naissance Jour-Mois-Année" value="<?php echo $data_dossier['date_naissance']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Sexe <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <select name="sexe" class="form-control select2">
                                <option value="Masculin" <?php echo ($data_dossier['sexe'] == "") ? "selected" : ""; ?>></option>
                                <option value="Masculin" <?php echo ($data_dossier['sexe'] == "Masculin") ? "selected" : ""; ?>>Masculin</option>
                                <option value="Feminin" <?php echo ($data_dossier['sexe'] == "Feminin") ? "selected" : ""; ?>>Feminin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Email <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <?php

                            if (get_access(62, $_SESSION['my_idprofile']) == 1) {
                            ?>
                                <input type="email" name="email" class="form-control" value="<?php echo $data_dossier['email']; ?>">
                            <?php
                            } else {
                            ?>
                                <input type="email" name="email" class="form-control" value="<?php echo obfuscate_email($data_dossier['email']); ?>" disabled>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Téléphone <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <?php

                            if (get_access(62, $_SESSION['my_idprofile']) == 1) {
                            ?>
                                <input type="text" name="telephone" required class="form-control" value="<?php echo $data_dossier['numero_telephone']; ?>" data-inputmask='"mask": "(999) 99-999-9999"' data-mask>
                            <?php
                            } else {
                            ?>
                                <input type="text" name="telephone" class="form-control" value="<?php echo hide_mobile_no($data_dossier['numero_telephone']); ?>" disabled>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Lieu de naissance <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" required class="form-control" name="lieu_naissance" value="<?php echo $data_dossier['lieu_naissance']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Nom complet de votre père biologique (tel que dans votre acte de naissance) <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="identite_pere" value="<?php echo $data_dossier['identite_pere']; ?>" placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans votre acte de naissance">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Lieu de naissance de votre père <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="lieu_naissance_pere" placeholder="Entrez le lieu de naissance" value="<?php echo $data_dossier['lieu_naissance_pere']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Date de naissance de votre père <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" name="date_naissance_pere" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" value="<?php echo $data_dossier['date_naissance_pere']; ?>" data-mask placeholder="Entrez la date de naissance de votre pere Année-Mois-Jour">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Nom complet de votre mère biologique (tel que dans votre acte de naissance) <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="identite_mere" value="<?php echo $data_dossier['identite_mere']; ?>" placeholder="Entrez votre Nom Postnom Prenom Exactement comme dans votre acte de naissance">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Lieu de naissance de votre mère <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="lieu_naissance_mere" value="<?php echo $data_dossier['lieu_naissance_mere']; ?>" placeholder="Entrez le lieu de naissance">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Date de naissance de votre mère <font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" name="date_naissance_mere" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" value="<?php echo $data_dossier['date_naissance_mere']; ?>" data-mask placeholder="Entrez la date de naissance de votre mère Année-Mois-Jour">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Adresse physique actuelle<font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" name="adresse" class="form-control" placeholder="Entrez votre adresse (num, av, quartier et commune)" value="<?php echo $data_dossier['adresse']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Ville et Pays de résidence actuelle<font color="#FF0000">*</font></label>
                        <div class="col-sm-6">
                            <input type="text" name="ville_pays" class="form-control" placeholder="Entrez votre ville et le pays (Ville , Pays)" value="<?php echo $data_dossier['ville_pays']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Vous etes issue d'une famille de combien d'enfants</label>
                        <div class="col-sm-6">
                            <select name="nbre_enfant_famille" class="form-control select2">
                                <?php for ($i = 0; $i < 40; $i++) { ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($i == $data_dossier['nbre_enfant_famille']) ? "selected" : ""; ?>><?php echo $i; ?></option>
                                <?php } ?>
                            </select>


                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label">Vous etes quantième dans la famille</label>
                        <div class="col-sm-6">
                            <select name="position_dans_famille" class="form-control select2">
                                <?php for ($i = 0; $i < 40; $i++) { ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($i == $data_dossier['position_dans_famille']) ? "selected" : ""; ?>><?php echo $i; ?></option>
                                <?php } ?>
                            </select>


                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Numéro Passeport </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="numero_passport" value="<?php echo $data_dossier['numero_passport']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Date d'expiration Passeport </label>
                        <div class="col-sm-6">

                            <input type="text" name="date_expiration_pp" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask placeholder="Entrez la date d'expiration de votre passport" value="<?php echo $data_dossier['date_expiration_pp']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">A quelle agence voulez-vous suivre le dossier ?</label>
                        <div class="col-sm-6">
                            <select name="ref_agence" class="form-control select2">

                                <?php echo getcombo_agence($data_dossier['ref_agence']); ?>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Comment avez-vous connu notre agence ?</label>
                        <div class="col-sm-6">
                            <input type="text" name="promoteur_agence" class="form-control" value="<?php echo $data_dossier['promoteur_agence']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">
                            <font color="#FF0000">Autre chose à nous informer? Merci de le mentionner ici (Max 200 caractères)---------> </font>
                        </label>
                        <div class="col-sm-6">
                            <textarea name="commentaire_client" cols="100%" rows="3" class="form-control"><?php echo $data_dossier['commentaire_client']; ?></textarea>

                        </div>
                    </div>





                </div><!-- /.box-body -->
                <div class="box-footer">
                    <input type="hidden" class="form-control" name="nid_pp" placeholder="Remplissez le NID si le frais de dossier est payé" value="<?php echo $data_dossier['ndel']; ?>" readonly="true">
                    <i class="fa fa-warning">Important à savoir</i><br>
                    <font color="#FF0000">*</font> : Champs conditionnées par un remplissage obligatoire
                    <button type="submit" class="btn btn-info pull-right" name="btn_edition_identite_client">Valider les Modifications de l'identité du Client</button>
                </div>

            </div>

        </form>
        <!-- /.box -->
        <form action="vue_dossier.php" method="post">
            <div class="box box-info" style="overflow-y: scroll;">
                <div class="box-header with-border">
                    <h3 class="box-title">2. PARCOURS D'ETUDES</h3>
                    <button type="submit" class="btn btn-info pull-right" name="btn_action" value="btn_add_secondaire"><i class="fa  fa-plus-circle">Ajouter un parcours Secondaire</i></button>
                    <button type="submit" class="btn btn-info pull-right" name="btn_action" value="btn_add_exetat"><i class="fa  fa-plus-circle">Ajouter un parcours EXETAT</i></button>
                    <button type="submit" class="btn btn-info pull-right" name="btn_action" value="btn_add_etude"><i class="fa  fa-plus-circle">Ajouter un parcours Post Secondaire</i></button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <h5>2.1. Votre Parcours Secondaire</h5>
                    <table class="table table-condensed">
                        <tr>
                            <th>#</th>
                            <th>Année</th>
                            <th>Etablissement</th>
                            <th>Option</th>
                            <th>Niveau</th>
                            <th>Résultats</th>
                            <th>Date Ajout</th>
                            <th>Actions</th>


                        </tr>
                        <?php
                        $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu='SECONDAIRE' and ref_dossier=" . $data_dossier['idt_dossier'] . " and view_doc=1";
                        //echo $sql_select1;

                        $sql_result1 = $bdd->query($sql_select1);

                        $index2 = 0;

                        while ($data1 = $sql_result1->fetch()) {
                            $index2++;
                        ?>
                            <tr>
                                <td><?php echo $index2; ?></td>
                                <td><?php echo $data1['annee']; ?> </td>
                                <td><?php echo $data1['institution']; ?></td>
                                <td><?php echo $data1['formation']; ?></td>
                                <td><?php echo $data1['niveau']; ?></td>
                                <td><?php echo $data1['resultat']; ?></td>
                                <td><?php echo $data1['creationdate']; ?></td>
                                <td>
                                    <?php echo (get_access(10, $_SESSION['my_idprofile']) == 1) ? '<a href="vue_dossier?action=edit_etude&idt_doc_study=' . $data1['idt_dossier_etude'] . '"><i class="fa  fa-edit"></i></a>' : ""; ?>
                                    <?php echo (get_access(10, $_SESSION['my_idprofile']) == 1) ? '<a href="vue_dossier?del_etude=yes&idt_doc_study=' . $data1['idt_dossier_etude'] . '" onClick="return confirm(' . "'Cette action va supprimer le cursus, Veuillez confirmer?'" . ')"><i class="fa  fa-cut"></i></a>' : ""; ?>
                                </td>

                            </tr>

                        <?php
                        }
                        ?>
                    </table>
                    <br>
                    <h5>2.2. Diplome d'Etat ou son équivalent</h5>
                    <table class="table table-condensed">
                        <tr>
                            <th></th>
                            <th>Année obtention</th>
                            <th>Ecole fréquentée</th>
                            <th>Option</th>
                            <th>Pourcentage</th>
                            <th>Pays d'obtention</th>
                            <th>Ville d'obtention</th>
                            <th>Date Ajout</th>
                            <th>Actions</th>


                        </tr>
                        <?php
                        $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu='EXETAT' and ref_dossier=" . $data_dossier['idt_dossier'] . " and view_doc=1";
                        //echo $sql_select1;

                        $sql_result1 = $bdd->query($sql_select1);

                        $index = 0;

                        while ($data1 = $sql_result1->fetch()) {
                        ?>
                            <tr>
                                <td></td>
                                <td>
                                    <?php echo $data1['annee']; ?>
                                </td>
                                <td><?php echo $data1['institution']; ?></td>
                                <td><?php echo $data1['formation']; ?></td>
                                <td><?php echo $data1['resultat']; ?></td>
                                <td><?php echo $data1['pays_obtention']; ?></td>
                                <td><?php echo $data1['ville_obtention']; ?></td>
                                <td><?php echo $data1['creationdate']; ?></td>
                                <td>
                                    <?php echo (get_access(10, $_SESSION['my_idprofile']) == 1) ? '<a href="vue_dossier?action=edit_dip_etat&idt_doc_study=' . $data1['idt_dossier_etude'] . '"><i class="fa  fa-edit"></i></a>' : ""; ?>
                                    <?php echo (get_access(10, $_SESSION['my_idprofile']) == 1) ? '<a href="vue_dossier?del_etude=yes&idt_doc_study=' . $data1['idt_dossier_etude'] . '" onClick="return confirm(' . "'Cette action va supprimer le cursus, Veuillez confirmer?'" . ')"><i class="fa  fa-cut"></i></a>' : ""; ?>


                                </td>


                            </tr>
                        <?php } ?>
                    </table>
                    <br>
                    <h5>2.3. Votre parcours post-secondaire (Remplir par l'année la plus recente)</h5>
                    <table class="table table-condensed">
                        <tr>
                            <th>#</th>
                            <th>Année</th>
                            <th>Etablissement</th>
                            <th>Intitulé de la formation</th>
                            <th>Niveau</th>
                            <th>Résultats</th>
                            <th>Diplome Obtenu</th>
                            <th>Date Ajout</th>
                            <th>Actions</th>


                        </tr>
                        <?php
                        $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu not in ('EXETAT','SECONDAIRE') and ref_dossier=" . $data_dossier['idt_dossier'] . " and view_doc=1";
                        //echo $sql_select1;

                        $sql_result1 = $bdd->query($sql_select1);

                        $index2 = 0;

                        while ($data1 = $sql_result1->fetch()) {
                            $index2++;
                        ?>
                            <tr>
                                <td><?php echo $index2; ?></td>
                                <td><?php echo $data1['annee']; ?> </td>
                                <td><?php echo $data1['institution']; ?></td>
                                <td><?php echo $data1['formation']; ?></td>
                                <td><?php echo $data1['niveau']; ?></td>
                                <td><?php echo $data1['resultat']; ?></td>
                                <td><?php echo $data1['diplome_obtenu']; ?></td>
                                <td><?php echo $data1['creationdate']; ?></td>
                                <td>
                                    <?php echo (get_access(10, $_SESSION['my_idprofile']) == 1) ? '<a href="vue_dossier.php?action=edit_etude&idt_doc_study=' . $data1['idt_dossier_etude'] . '"><i class="fa  fa-edit"></i></a>' : ""; ?>
                                    <?php echo (get_access(10, $_SESSION['my_idprofile']) == 1) ? '<a href="vue_dossier.php?del_etude=yes&idt_doc_study=' . $data1['idt_dossier_etude'] . '" onClick="return confirm(' . "'Cette action va supprimer le cursus, Veuillez confirmer?'" . ')"><i class="fa  fa-cut"></i></a>' : ""; ?>
                                </td>

                            </tr>

                        <?php
                        }
                        ?>
                    </table>





                </div><!-- /.box-body -->


            </div>
            <div class="box box-info" id="fichier" style="overflow-y: scroll;">
                <div class="box-header with-border">
                    <h3 class="box-title">FICHIERS TELECHARGES</h3>
                    <button type="submit" class="btn btn-info pull-right" name="btn_action" value="btn_add_file"><i class="fa  fa-plus-circle">Ajouter un document</i></button>
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">

                    <font color='red'>Vous pouvez ajouter vos diplomes, CV, Attestation de naissance, copie de passeport et autres ici</font>
                    <table class="table table-condensed">
                        <tr>
                            <th>#</th>
                            <th>Titre document</th>
                            <th>ajouté le </th>
                            <th>Type</th>
                            <th>Actions</th>



                        </tr>
                        <?php
                        $sql_select1 = "SELECT * FROM passport_bd.t_document_dossier where ref_dossier=" . $data_dossier['idt_dossier'] . " and view_doc=1";
                        //echo $sql_select1;

                        $sql_result1 = $bdd->query($sql_select1);

                        $index2 = 0;

                        while ($data1 = $sql_result1->fetch()) {
                            $index2++;
                        ?>
                            <tr>
                                <td><?php echo $index2; ?></td>
                                <td><?php echo $data1['titre_document']; ?> </td>
                                <td><?php echo $data1['creationdate']; ?></td>
                                <td><?php echo strtotime($data1['type_fichier']); ?></td>
                                <td>
                                    <a href="<?php echo $data1['url_document']; ?>" download=""><i class="fa  fa-download"></i></a>
                                    <?php echo (get_access(10, $_SESSION['my_idprofile']) == 1) ? '<a href="vue_dossier.php?del_doc=yes&idt_doc=' . $data1['idt_document_dossier'] . '" onClick="return confirm(' . "'Cette action va supprimer le fichier, Veuillez confirmer?'" . ')"><i class="fa  fa-cut"></i></a>' : ""; ?>
                                </td>



                            </tr>

                        <?php
                        }
                        ?>
                    </table>





                </div><!-- /.box-body -->


            </div>
            <form action="vue_dossier" method="post">
                <div class="box box-info" style="overflow-y: scroll;">
                    <div class="box-header with-border">
                        <h3 class="box-title">3. ACTIVITES PASSEES ET ACTUELLES</h3>

                    </div><!-- /.box-header -->
                    <!-- form start -->


                    <div class="box-body">
                        Parlez-nous de vos activités antérieures (emplois, professions, stages académiques / professionnels ou autres formations pertinentes ainsi que les mois et les années du début et de la fin. si applicable. N'hésitez pas d'être explicite)
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="nid_pp" placeholder="Remplissez le NID si le frais de dossier est payé" value="<?php echo $data_dossier['ndel']; ?>" readonly="true">
                            <div class="col-sm-6">
                                <textarea name="activite_passe_actuelle" cols="100%" rows="2" class="form-control"><?php echo $data_dossier['activite_passe_actuelle']; ?></textarea>

                            </div>
                        </div>


                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <i class="fa fa-warning">Important à savoir</i><br>
                        <font color="#FF0000">*</font> : Champs conditionnées par un remplissage obligatoire
                        <button type="submit" class="btn btn-info pull-right" name="btn_edition_emploi">Valider les Modifications</button>

                    </div><!-- /.box-footer -->

                </div>
            </form>

            <form action="vue_dossier.php" method="post">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">4. VOYAGE</h3>

                    </div><!-- /.box-header -->
                    <!-- form start -->


                    <div class="box-body">
                        <input type="hidden" class="form-control" name="nid_pp" placeholder="Remplissez le NID si le frais de dossier est payé" value="<?php echo $data_dossier['ndel']; ?>" readonly="true">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Où voulez-vous partir? <font color="#FF0000">*</font></label>
                            <div class="col-sm-6">

                                <input type="text" name="vo_destination" class="form-control" value="<?php echo $data_dossier['vo_destination']; ?>" readonly>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label"></label>
                            <div class="col-sm-6">


                                <select name="vo_destination_temp" class="form-control select2" disabled="true" id="vo_destination">
                                    <?php echo get_combo_liste_pays(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label"></label>
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>

                                        <input type="checkbox" name="chk_vo_destination" value="oui" class="minimal" onchange="document.getElementById('vo_destination').disabled = !this.checked;"> Cocher pour changer de pays
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-6 control-label">Raison du voyage </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="vo_raison_voyage" value="<?php echo $data_dossier['vo_raison_voyage']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Si pour études, qui prendra en charge ces études?</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="vo_charge_etude_parrain" value="<?php echo $data_dossier['vo_charge_etude_parrain']; ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Si pour études, quels domaines vous intéressent ? (donnez trois propositions des programmes)</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="vo_proposition_domaine" placeholder="quels domaines  vous intéressent ? (donnez trois propositions des programmes)" value="<?php echo $data_dossier['domaine_preference']; ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Avez-vous des ancien Visa?</label>
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        <input name="vo_ancien_visa" type="checkbox" value="oui" class="minimal" <?php echo ($data_dossier['vo_ancien_visa'] == 'oui') ? "checked" : ""; ?>>
                                    </label>
                                </div>
                            </div>


                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Si Oui, précisez vos anciens Visa</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="vo_ancien_visa_comment" value="<?php echo $data_dossier['vo_ancien_visa_comment']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Avez-vous déjà eu un refus de Visa?</label>
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        <input name="vo_refus_visa_chk" type="checkbox" value="oui" <?php echo ($data_dossier['vo_refus_visa'] == 'oui') ? "checked" : ""; ?>>
                                    </label>
                                </div>
                            </div>


                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Si Oui, précisez vos anciens refus</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="commentaire_refus_visa" value="<?php echo $data_dossier['vo_refus_visa_comment']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Avez-vous une famille à votre lieu de destination?</label>
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        <input name="vo_destination_famille_chk" type="checkbox" value="oui" <?php echo ($data_dossier['vo_destination_famille'] == 'oui') ? "checked" : ""; ?>>
                                    </label>
                                </div>
                            </div>


                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Si Oui, précisez</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="vo_destination_comment" value="<?php echo $data_dossier['vo_destination_comment']; ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-6 control-label">Avez-vous déjà tenté d'obtenir une inscription dans une université étrangère ? </label>
                            <div class="col-sm-1">
                                <input name="vo_obtention_chk" type="checkbox" value="oui" onchange="document.getElementById('universite').readOnly = !this.checked; document.getElementById('pays').readOnly = !this.checked;">
                            </div>
                            <label class="col-sm-5 control-label">Cochez pour modifier</label>


                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">De quelle Université s'agit il? </label>


                            <div class="col-sm-6">

                                <input type="text" id="universite" name="q_universite" class="form-control" placeholder="Entrez le nom de l'université" value="<?php echo $data_dossier['q_universite']; ?>" readonly>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Dans quel pays se trouve cette Université? </label>



                            <div class="col-sm-6">


                                <input type="text" id="pays" name="q_pays" class="form-control" placeholder="Entrez plusieurs noms si c'est plusieurs pays" value="<?php echo $data_dossier['q_pays']; ?>" readonly>
                            </div>
                        </div>


                    </div><!-- /.box-body -->
                    <!-- /.box-footer -->
                    <div class="box-footer">
                        <i class="fa fa-warning">Important à savoir</i><br>
                        <font color="#FF0000">*</font> : Champs conditionnées par un remplissage obligatoire
                        <button type="submit" class="btn btn-info pull-right" name="btn_edition_zone_voyage">Valider les Modifications</button>

                    </div><!-- /.box-footer -->
                </div>
            </form>
            <form action="vue_dossier.php" method="post">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">5. PRISE EN CHARGE</h3>

                    </div><!-- /.box-header -->
                    <!-- form start -->


                    <div class="box-body">
                        <input type="hidden" class="form-control" name="nid_pp" placeholder="Remplissez le NID si le frais de dossier est payé" value="<?php echo $data_dossier['ndel']; ?>" readonly="true">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Votre garant est qui pour vous?</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="pc_qualite_garant" value="<?php echo $data_dossier['pc_qualite_garant']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-6 control-label">Où travaille-t-il et quelle responsabilité a-t-il?</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="pc_lieu_travail_garant" value="<?php echo $data_dossier['pc_lieu_travail_garant']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Quel est son salaire mensuel?</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="pc_salaire_parrain" value="<?php echo $data_dossier['pc_salaire_parrain']; ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Possède-t-il une activité commerciale ou une entreprise?</label>
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        <input name="pc_activite_pro_chk" type="checkbox" value="oui" <?php echo $data_dossier['pc_activite_pro'] == "oui" ? "checked" : ""; ?>>
                                    </label>
                                </div>
                            </div>


                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Si Oui, quel est son nom?</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="pc_activite_pro_nom" value="<?php echo $data_dossier['pc_activite_pro_nom']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Si Oui, Quel revenu mensuel pour cette activité ou entreprise en $ (Estimation)?</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="pc_revenu_parrain" value="<?php echo $data_dossier['pc_revenu_parrain']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                .
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Combien de parcelles dispose-t-il ?</label>
                            <div class="col-sm-6">

                                <select name="pc_nbre_parcelle" class="form-control select2">
                                    <?php for ($j = 0; $j < 21; $j++) { ?>
                                        <option value="<?php echo $j; ?>" <?php echo ($j == $data_dossier['pc_nbre_parcelle']) ? "selected" : ""; ?>><?php echo $j; ?></option>
                                    <?php } ?>
                                </select>
                            </div>


                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Combien de véhicule dispose-t-il ?</label>
                            <div class="col-sm-6">

                                <select name="pc_nbre_vehicule" class="form-control select2">
                                    <?php for ($j = 0; $j < 21; $j++) { ?>
                                        <option value="<?php echo $j; ?>" <?php echo ($j == $data_dossier['pc_nbre_vehicule']) ? "selected" : ""; ?>><?php echo $j; ?></option>
                                    <?php } ?>
                                </select>
                            </div>


                        </div>
                        <div class="form-group">
                        <label class="col-sm-6 control-label">Email Facultatif</label>
                        <div class="col-sm-6">
                            <?php

                            if (get_access(62, $_SESSION['my_idprofile']) == 1) {
                            ?>
                                <input type="email" name="email_secondaire" class="form-control" value="<?php echo $data_dossier['email_secondaire']; ?>">
                            <?php
                            } else {
                            ?>
                                <input type="email" name="email_secondaire" class="form-control" value="<?php echo obfuscate_email($data_dossier['email_secondaire']); ?>" disabled>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Téléphone secondaire</label>
                        <div class="col-sm-6">
                            <?php

                            if (get_access(62, $_SESSION['my_idprofile']) == 1) {
                            ?>
                                <input type="text" name="numero_telephone_secondaire" required class="form-control" value="<?php echo $data_dossier['numero_telephone_secondaire']; ?>" data-inputmask='"mask": "(999) 99-999-9999"' data-mask>
                            <?php
                            } else {
                            ?>
                                <input type="text" name="numero_telephone_secondaire" class="form-control" value="<?php echo hide_mobile_no($data_dossier['numero_telephone_secondaire']); ?>" disabled>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    </div><!-- /.box-body -->
                    <!-- /.box-footer -->
                    <div class="box-footer">
                        <i class="fa fa-warning">Important à savoir</i><br>
                        <font color="#FF0000">*</font> : Champs conditionnées par un remplissage obligatoire
                        <button type="submit" class="btn btn-info pull-right" name="btn_edition_zone_charge">Valider les Modifications</button>

                    </div><!-- /.box-footer -->
                </div>
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
//include_once("php/export_to_csv_js.php");
?>
</body>

</html>