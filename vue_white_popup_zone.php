<?php
//*******************************Enregistrer un Commentaire pour le Client ****************************
if (isset($_GET['action_tache'])  && get_access(57, $_SESSION['my_idprofile']) == 1 && isset($_GET['tache_id']) && $_GET['action_tache'] == "edit_tache" && clean_in_integer($_GET['tache_id']) > 01) {



    $data_tache = get_tache_data(clean_in_integer($_GET['tache_id']));
    //
    if ($data_tache['is_exist'] == 1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post">
            <p align="center">
            <h4>Editer Tache : <?php echo $data_tache['titre_tache']; ?></h4>
            </p>
            <div class="box-body">




                <div class="form-group">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input type="hidden" value="<?php echo $data_tache['idt_tache']; ?>" name="tache_id">
                        <textarea class="form-control" rows="3" name="description_tache" placeholder="Descrivez le Ici ..."><?php echo $data_tache['description']; ?></textarea>
                    </div>
                </div>


            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_edit_tache">Valider la modification</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {

        echo "Désolé mais cette tache n'existe pas dans le système";
    }
}
?>


<?php
//*******************************Ajout Etude Secondaire****************************
if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_change_statut_dossier" && get_access(24, $_SESSION['my_idprofile']) == 1) {

    // $dossier_etude = get_dossier_etude_data($_SESSION['my_m_dossier']);
    if (1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post">
            <p align="center">
            <h4>Editer Statut du Dossier </h4>
            </p>
            <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-6 control-label">Statut du dossier </label>
                    <div class="col-sm-6">

                        <select name="statut_dossier_edit" class="form-control select2">

                            <?php echo getcombo_statut_dossier($data_dossier['statut_dossier']); ?>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label">Notification au client</label>
                    <div class="col-sm-6">
                        <?php

                        if (get_access(62, $_SESSION['my_idprofile']) == 1) {
                        ?>
                            SMS (<?php echo $data_dossier["numero_telephone"]; ?>)
                             <input type="checkbox" value="oui" name="notification_sms" <?php echo ($data_dossier["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true"> 
                             <br/>Email (<?php echo $data_dossier["email"]; ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($data_dossier["email"] == '') ? "disabled" : ""; ?> checked="true">
                             <br/>Email Facultatif (<?php echo $data_dossier["email_secondaire"]; ?>)<input type="checkbox" value="oui" name="notification_email_secondaire" <?php echo ($data_dossier["email_secondaire"] == '') ? "disabled" : ""; ?> checked="true">

                        <?php
                        } else {
                        ?>
                            SMS (<?php echo hide_mobile_no($data_dossier["numero_telephone"]); ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($data_dossier["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true">
                            <br/>Email (<?php echo obfuscate_email($data_dossier["email"]); ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($data_dossier["email"] == '') ? "disabled" : ""; ?> checked="true">
                            <br/>Email Facultatif (<?php echo obfuscate_email($data_dossier["email_secondaire"]); ?>)<input type="checkbox" value="oui" name="notification_email_secondaire" <?php echo ($data_dossier["email_secondaire"] == '') ? "disabled" : ""; ?> checked="true">

                        <?php
                        }
                        ?>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Contact reponse</label>
                    <div class="col-sm-6">
                        <select name="feedback_phone" class="form-control select2">

                            <option value="+243 82 7000 776">+243 82 7000 776</option>
                            <option value="+243 82 7000 755">+243 82 7000 755</option>
                            <option value="+243 85 0050 755">+243 85 0050 755</option>
                            <option value="+243 82 6999 755">+243 82 6999 755</option>
                            <option value="+243 81 8155 109">+243 81 8155 109</option>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Contact email</label>
                    <div class="col-sm-6">
                        <select name="feedback_email" class="form-control select2">

                            <option value="admin@passportsarl.voyage">admin@passportsarl.voyage</option>
                            <option value="info@passportsarl.voyage">info@passportsarl.voyage</option>
                            <option value="votreavis@passportsarl.voyage">votreavis@passportsarl.voyage</option>

                        </select>
                    </div>

                </div>





            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_edit_statut">Valider la modification</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {
    }
}
?>
<?php
//*******************************Ajout Etude Secondaire****************************
if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_add_secondaire" && get_access(11, $_SESSION['my_idprofile']) == 1) {

    // $dossier_etude = get_dossier_etude_data(clean_in_integer($_GET['idt_doc_study']));
    if (1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post">
            <p align="center">
            <h4>Enregistrement d'un nouveau Cursus Secondaire</h4>
            </p>
            <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-6 control-label">Année d'obtention</label>
                    <div class="col-sm-6">

                        <select name="exetat_annee" class="form-control select2" required="true">
                            <option value=""></option>
                            <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Ecole Frequentée</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="ecole_frequenter" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Option</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="formation" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Pourcentage</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="resultat" value="" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label">Niveau</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="niveau" placeholder="Ex : 6eme, 5eme ou 4eme" value="">
                    </div>

                </div>



            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_add_etude_sec">Valider l'ajout</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {
    }
}
?>
<?php
//*******************************Editer Diplome ****************************
if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_add_exetat" && get_access(11, $_SESSION['my_idprofile']) == 1) {


    if (1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post">
            <p align="center">
            <h4>Nouveau parcours Diplome d'Etat</h4>
            </p>
            <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-6 control-label">Année d'obtention</label>
                    <div class="col-sm-6">

                        <select name="exetat_annee" class="form-control select2" required="true">
                            <option value=""></option>
                            <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Ecole Frequentée</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="ecole_frequenter" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Intitulé de la formation</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="formation" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Pourcentage</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="resultat" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Ville d'obtention</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="ville_obtention" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Pays</label>
                    <div class="col-sm-6">

                        <select name="pays_obtention" class="form-control select2">
                            <?php echo get_combo_liste_pays_rdc(); ?>
                        </select>
                    </div>

                </div>



            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_add_exetat">Ajouter la formation</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {

        echo "Désolé mais cet enregistrement d'etude n'existe pas dans le système";
    }
} else {

    if (isset($_POST['btn_action']) && $_POST['btn_action'] == "add_dip_etat") {

        echo '<p align="center"><h4>Desole vous n avez pas le droit d ajouter une formmation</h4></p>';
    }
}
?>
<?php
//*******************************Editer Diplome ****************************
if (isset($_GET['action']) && $_GET['action'] == "edit_dip_etat" && get_access(11, $_SESSION['my_idprofile']) == 1 && clean_in_integer($_GET['idt_doc_study']) > 0) {

    $dossier_etude = get_dossier_etude_data(clean_in_integer($_GET['idt_doc_study']));
    if ($dossier_etude['is_exist'] == 1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post">
            <p align="center">
            <h4>Vous éditez l'information sur le Diplome d'Etat</h4>
            </p>
            <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-6 control-label">Année d'obtention</label>
                    <div class="col-sm-6">
                        <input type="hidden" name='idt_dossier_etude' value="<?php echo $dossier_etude['idt_dossier_etude']; ?>">
                        <select name="exetat_annee" class="form-control select2" required="true">
                            <option value=""></option>
                            <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php echo ($i == $dossier_etude['annee']) ? "selected" : ""; ?>><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Ecole Frequentée</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="ecole_frequenter" value="<?php echo $dossier_etude['institution']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Intitulé de la formation</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="formation" value="<?php echo $dossier_etude['formation']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Pourcentage</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="resultat" value="<?php echo $dossier_etude['resultat']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Ville d'obtention</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="ville_obtention" value="<?php echo $dossier_etude['ville_obtention']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Pays</label>
                    <div class="col-sm-6">
                        <input type="text" name="pays_obtention" class="form-control" value="<?php echo $dossier_etude['pays_obtention']; ?>" readonly>
                        <select name="pays_obtention_edit" class="form-control select2" disabled="true" id="pays_obtention_edit">
                            <?php echo get_combo_liste_pays_rdc(); ?>
                        </select><input type="checkbox" name="chk_pays_edit" value="oui" onchange="document.getElementById('pays_obtention_edit').disabled = !this.checked;"> Cocher pour changer de pays
                    </div>

                </div>



            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_edit_exetat">Valider les modifications</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {

        echo "Désolé mais cet enregistrement d'etude n'existe pas dans le système";
    }
} else {

    if (isset($_GET['action']) && $_GET['action'] == "edit_dip_etat") {

        echo '<p align="center"><h4>Desole vous n avez pas le droit de modifier ces informations</h4></p>';
    }
}
?>
<?php
//*******************************Ajout Etude ****************************
if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_add_etude" && get_access(11, $_SESSION['my_idprofile']) == 1) {

    // $dossier_etude = get_dossier_etude_data(clean_in_integer($_GET['idt_doc_study']));
    if (1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post">
            <p align="center">
            <h4>Enregistrement d'un nouveau Cursus Post-Secondaire</h4>
            </p>
            <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-6 control-label">Année d'obtention</label>
                    <div class="col-sm-6">

                        <select name="exetat_annee" class="form-control select2" required="true">
                            <option value=""></option>
                            <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Ecole Frequentée</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="ecole_frequenter" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Option</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="formation" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Pourcentage</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="resultat" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Diplome Obtenu</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="diplome_obtenu" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Niveau</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="niveau" value="">
                    </div>

                </div>



            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_add_etude">Valider l'ajout du cursus</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {
    }
}
?>
<?php
//*******************************Editer Diplome ****************************
if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_add_file" && get_access(11, $_SESSION['my_idprofile']) == 1) {

    // $dossier_etude = get_dossier_etude_data(clean_in_integer($_GET['idt_doc_study']));
    if (1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post" enctype="multipart/form-data">
            <p align="center">
            <h4>Ajouter un document au Dossier</h4>
            </p>
            <div class="box-body">


                <div class="form-group">
                    <label class="col-sm-6 control-label">Titre Document</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="titre_document" value="" required="true">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label">Attachez votre fichier Ici</label>
                    <div class="col-sm-6">
                        <input name="doc_file" type="file" accept=".jpeg,.jpg,.png,.pdf,.docx,.doc">
                    </div>

                </div>



            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_add_doc">Valider l'ajout du cursus</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {
    }
}
?>
<?php
//*******************************Editer Diplome ****************************
if (isset($_GET['action']) && $_GET['action'] == "edit_etude" && get_access(11, $_SESSION['my_idprofile']) == 1 && clean_in_integer($_GET['idt_doc_study']) > 0) {

    $dossier_etude = get_dossier_etude_data(clean_in_integer($_GET['idt_doc_study']));
    if ($dossier_etude['is_exist'] == 1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post">
            <p align="center">
            <h4>Vous éditez les informations un Cursus</h4>
            </p>
            <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-6 control-label">Année d'obtention</label>
                    <div class="col-sm-6">
                        <input type="hidden" name='idt_dossier_etude' value="<?php echo $dossier_etude['idt_dossier_etude']; ?>">
                        <select name="exetat_annee" class="form-control select2" required="true">
                            <option value=""></option>
                            <?php for ($i = 1950; $i < 2050; $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php echo ($i == $dossier_etude['annee']) ? "selected" : ""; ?>><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Ecole Frequentée</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="ecole_frequenter" value="<?php echo $dossier_etude['institution']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Option</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="formation" value="<?php echo $dossier_etude['formation']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Pourcentage</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="resultat" value="<?php echo $dossier_etude['resultat']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Diplome Obtenu</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="diplome_obtenu" value="<?php echo $dossier_etude['diplome_obtenu']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Niveau</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="niveau" value="<?php echo $dossier_etude['niveau']; ?>">
                    </div>

                </div>



            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_edit_etude">Valider les modifications</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {

        echo "Désolé mais cet enregistrement d'etude n'existe pas dans le système";
    }
} else {

    if (isset($_GET['action']) && $_GET['action'] == "edit_etude") {

        echo '<p align="center"><h4>Desole vous n avez pas le droit de modifier ces informations</h4></p>';
    }
}
?>
<?php
//*******************************Enregistrer un paiement ****************************
if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_paiement" && get_access(19, $_SESSION['my_idprofile']) == 1) {

    $dossier_etude = get_dossier_data(clean_in_integer($_SESSION['my_m_dossier']));
    if ($dossier_etude['is_exist'] == 1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post" enctype="multipart/form-data">
            <p align="center">
            <h4>Enregistrer un Paiement</h4>
            </p>
            <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-6 control-label">Date de paiement <font color="#FF0000">*</font></label>
                    <div class="col-sm-6">
                        <input type="text" name="date_paiement" class="form-control" id="date_payment" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Mode de paiement</label>
                    <div class="col-sm-6">
                        <select name="mode_paiement" class="form-control select2">
                            <option value="CHEQUE">CHEQUE</option>
                            <option value="ESPECE" selected="">ESPECE</option>
                            <option value="VIREMENT">VIREMENT</option>
                            <option value="TRANSFERT">TRANSFERT</option>
                            <option value="MPESA">MPESA</option>
                            <option value="ORANGE_MONEY">ORANGE_MONEY</option>
                            <option value="AIRTEL_MONEY">AIRTEL_MONEY</option>
                            <option value="">AUTRES</option>
                        </select>
                        <input type="text" class="form-control" name="mode_paiement_autre" placeholder="Précisez si element pas dans la liste">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Montant <font color="#FF0000">*</font></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="montant" placeholder="Montant payé" required>
                        <select name="devise" class="form-control select2">
                            <option value="USD">USD</option>
                            <option value="CDF">CDF</option>

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Operation</label>
                    <div class="col-sm-6">
                        <select name="ref_operation" class="form-control select2">
                            <?php echo getcombo_operation_paiement_dossier(''); ?>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Commentaire</label>
                    <div class="col-sm-6">
                        <textarea name="commentaire" cols="100%" rows="2" class="form-control"></textarea>

                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Notification au client</label>
                    <div class="col-sm-6">
                        <?php

                        if (get_access(62, $_SESSION['my_idprofile']) == 1) {
                        ?>
                            SMS (<?php echo $dossier_etude["numero_telephone"]; ?>)
                            <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true">
                           </br>Email (<?php echo $dossier_etude["email"]; ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> checked="true">
                           </br>Email Facultatif(<?php echo $dossier_etude["email_secondaire"]; ?>)<input type="checkbox" value="oui" name="notification_email_secondaire" <?php echo ($dossier_etude["email_secondaire"] == '') ? "disabled" : ""; ?> checked="true">

                       <?php
                        } else {
                        ?>
                            SMS (<?php echo hide_mobile_no($dossier_etude["numero_telephone"]); ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true"> 
                            </br> Email (<?php echo obfuscate_email($dossier_etude["email"]); ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> checked="true">
                            </br> Email Facultatif(<?php echo obfuscate_email($dossier_etude["email_secondaire"]); ?>)<input type="checkbox" value="oui" name="notification_email_secondaire" <?php echo ($dossier_etude["email_secondaire"] == '') ? "disabled" : ""; ?> checked="true">

                        <?php
                        }
                        ?>
                    </div>

                </div>



            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_add_paiement">Valider l'enregistrement du Paiement</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {

        echo "Désolé mais cet enregistrement n'existe pas dans le système";
    }
}
?>
<?php
//*******************************Demande Information ****************************
if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_request_info" && get_access(20, $_SESSION['my_idprofile']) == 1) {

    $dossier_etude = get_dossier_data(clean_in_integer($_SESSION['my_m_dossier']));
    if ($dossier_etude['is_exist'] == 1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post">
            <p align="center">
            <h4>Demander une information au Client</h4>
            </p>
            <div class="box-body">




                <div class="form-group">
                    <label class="col-sm-2 control-label">Operation</label>
                    <div class="col-sm-10">
                        <select name="ref_operation" class="form-control select2">
                            <?php echo getcombo_operation_groupement('Demande_information'); ?>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Commentaires</label>
                    <div class="col-sm-10">
                        <textarea name="commentaire" cols="100%" rows="2" class="form-control"></textarea>

                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Contact reponse</label>
                    <div class="col-sm-10">
                        <select name="feedback_phone" class="form-control select2">

                            <option value="+243 82 7000 776">+243 82 7000 776</option>
                            <option value="+243 82 7000 755">+243 82 7000 755</option>
                            <option value="+243 85 0050 755">+243 85 0050 755</option>
                            <option value="+243 82 6999 755">+243 82 6999 755</option>
                            <option value="+243 81 8155 109">+243 81 8155 109</option>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Contact email</label>
                    <div class="col-sm-10">
                        <select name="feedback_email" class="form-control select2">

                            <option value="admin@passportsarl.voyage">admin@passportsarl.voyage</option>
                            <option value="info@passportsarl.voyage">info@passportsarl.voyage</option>
                            <option value="votreavis@passportsarl.voyage">votreavis@passportsarl.voyage</option>

                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Notification au client</label>
                    <div class="col-sm-6">
                        <?php

                        if (get_access(62, $_SESSION['my_idprofile']) == 1) {
                        ?>
                            SMS (<?php echo $dossier_etude["numero_telephone"]; ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true">
                            </br> Email (<?php echo $dossier_etude["email"]; ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> checked="true">
                            </br> Email Facultatif (<?php echo $dossier_etude["email_secondaire"]; ?>)<input type="checkbox" value="oui" name="notification_email_secondaire" <?php echo ($dossier_etude["email_secondaire"] == '') ? "disabled" : ""; ?> checked="true">
                       <?php
                        } else {
                        ?>
                            SMS (<?php echo hide_mobile_no($dossier_etude["numero_telephone"]); ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true"> 
                            </br> Email (<?php echo obfuscate_email($dossier_etude["email"]); ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> checked="true">
                            </br> Email Facultatif (<?php echo obfuscate_email($dossier_etude["email_secondaire"]); ?>)<input type="checkbox" value="oui" name="notification_email_secondaire" <?php echo ($dossier_etude["email_secondaire"] == '') ? "disabled" : ""; ?> checked="true">

                        <?php
                        }
                        ?>
                    </div>

                </div>



            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_request_info">Valider la demande d'information</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {

        echo "Désolé mais cet enregistrement n'existe pas dans le système";
    }
}
?>
<?php
//*******************************Demande Document ****************************
if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_demande_doc" && get_access(21, $_SESSION['my_idprofile']) == 1) {

    $dossier_etude = get_dossier_data(clean_in_integer($_SESSION['my_m_dossier']));
    if ($dossier_etude['is_exist'] == 1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post">
            <p align="center">
            <h4>Demander un document au Client</h4>
            </p>
            <div class="box-body">




                <div class="form-group">
                    <label class="col-sm-2 control-label">Operation</label>
                    <div class="col-sm-10">
                        <select name="ref_operation" class="form-control select2">
                            <?php echo getcombo_operation_groupement('Demande_document'); ?>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Mode de reception</label>
                    <div class="col-sm-10">
                        <select name="mode_reception" class="form-control select2">
                            <option value="Depot Physique">Depot Physique</option>
                            <option value="Par Mail" selected="">Par Mail</option>
                            <option value="Par Mail" selected="">Par Mail et en Physique</option>

                        </select>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Date limite </label>
                    <div class="col-sm-10">
                        <input type="text" name="date_limite" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="Definissez la date avant laquelle ce docuument doit vous parvenir" required>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Commentaires</label>
                    <div class="col-sm-10">
                        <textarea name="commentaire" cols="100%" rows="2" class="form-control"></textarea>

                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Contact reponse</label>
                    <div class="col-sm-10">
                        <select name="feedback_phone" class="form-control select2">

                            <option value="+243 82 7000 776">+243 82 7000 776</option>
                            <option value="+243 82 7000 755">+243 82 7000 755</option>
                            <option value="+243 85 0050 755">+243 85 0050 755</option>
                            <option value="+243 82 6999 755">+243 82 6999 755</option>
                            <option value="+243 81 8155 109">+243 81 8155 109</option>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Contact email</label>
                    <div class="col-sm-10">
                        <select name="feedback_email" class="form-control select2">

                            <option value="admin@passportsarl.voyage">admin@passportsarl.voyage</option>
                            <option value="info@passportsarl.voyage">info@passportsarl.voyage</option>
                            <option value="votreavis@passportsarl.voyage">votreavis@passportsarl.voyage</option>

                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Notification au client</label>
                    <div class="col-sm-6">
                        <?php

                        if (get_access(62, $_SESSION['my_idprofile']) == 1) {
                        ?>
                            SMS (<?php echo $dossier_etude["numero_telephone"]; ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true">
                           </br> Email (<?php echo $dossier_etude["email"]; ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> checked="true">
                           </br> Email Facultatif (<?php echo $dossier_etude["email_secondaire"]; ?>)<input type="checkbox" value="oui" name="notification_email_secondaire" <?php echo ($dossier_etude["email_secondaire"] == '') ? "disabled" : ""; ?> checked="true">

                       <?php
                        } else {
                        ?>
                            SMS (<?php echo hide_mobile_no($dossier_etude["numero_telephone"]); ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true">
                            </br> Email (<?php echo obfuscate_email($dossier_etude["email"]); ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> checked="true">
                            </br> Email Facultatif(<?php echo obfuscate_email($dossier_etude["email_secondaire"]); ?>)<input type="checkbox" value="oui" name="notification_email_secondaire" <?php echo ($dossier_etude["email_secondaire"] == '') ? "disabled" : ""; ?> checked="true">

                        <?php
                        }
                        ?> 
                    </div>

                </div>



            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_request_doc">Valider la demande d'information</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {

        echo "Désolé mais cet enregistrement n'existe pas dans le système";
    }
}
?>
<?php
//*******************************Enregistrer un Commentaire pour le Client ****************************
if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_commentaire_externe" && get_access(22, $_SESSION['my_idprofile']) == 1) {

    $dossier_etude = get_dossier_data(clean_in_integer($_SESSION['my_m_dossier']));
    if ($dossier_etude['is_exist'] == 1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post">
            <p align="center">
            <h4>Enregistrer un Commentaire pour le Client</h4>
            </p>
            <div class="box-body">




                <div class="form-group">
                    <label class="col-sm-2 control-label">Operation</label>
                    <div class="col-sm-10">
                        <select name="ref_operation" class="form-control select2">
                            <?php echo getcombo_operation_groupement('Commentaire_externe'); ?>
                        </select>
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Commentaires</label>
                    <div class="col-sm-10">
                        <textarea name="commentaire" cols="100%" rows="2" class="form-control"></textarea>

                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Contact reponse</label>
                    <div class="col-sm-10">
                        <select name="feedback_phone" class="form-control select2">

                            <option value="+243 82 7000 776">+243 82 7000 776</option>
                            <option value="+243 82 7000 755">+243 82 7000 755</option>
                            <option value="+243 85 0050 755">+243 85 0050 755</option>
                            <option value="+243 82 6999 755">+243 82 6999 755</option>
                            <option value="+243 81 8155 109">+243 81 8155 109</option>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Contact email</label>
                    <div class="col-sm-10">
                        <select name="feedback_email" class="form-control select2">

                            <option value="admin@passportsarl.voyage">admin@passportsarl.voyage</option>
                            <option value="info@passportsarl.voyage">info@passportsarl.voyage</option>
                            <option value="votreavis@passportsarl.voyage">votreavis@passportsarl.voyage</option>

                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">Notification au client</label>
                    <div class="col-sm-6">
                        <?php

                        if (get_access(62, $_SESSION['my_idprofile']) == 1) {
                        ?>
                            SMS (<?php echo $dossier_etude["numero_telephone"]; ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true"> 
                          </br> Email (<?php echo $dossier_etude["email"]; ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> checked="true">
                          </br> Email Facultatif (<?php echo $dossier_etude["email_secondaire"]; ?>)<input type="checkbox" value="oui" name="notification_email_secondaire" <?php echo ($dossier_etude["email_secondaire"] == '') ? "disabled" : ""; ?> checked="true">
                        <?php
                        } else {
                        ?>
                            SMS (<?php echo hide_mobile_no($dossier_etude["numero_telephone"]); ?>) <input type="checkbox" value="oui" name="notification_sms" <?php echo ($dossier_etude["numero_telephone"] == '') ? "disabled" : ""; ?> checked="true">
                            </br> Email (<?php echo obfuscate_email($dossier_etude["email"]); ?>)<input type="checkbox" value="oui" name="notification_email" <?php echo ($dossier_etude["email"] == '') ? "disabled" : ""; ?> checked="true">
                            </br> Email Facultatif (<?php echo obfuscate_email($dossier_etude["email_secondaire"]); ?>)<input type="checkbox" value="oui" name="notification_email_secondaire" <?php echo ($dossier_etude["email_secondaire"] == '') ? "disabled" : ""; ?> checked="true">

                        <?php
                        }
                        ?> 
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_commentaire_client">Valider la demande d'information</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {

        echo "Désolé mais cet enregistrement n'existe pas dans le système";
    }
}
?>
<?php
//*******************************Enregistrer un Commentaire pour le Client ****************************
if (isset($_POST['btn_action']) && $_POST['btn_action'] == "btn_commentaire_interne" && get_access(23, $_SESSION['my_idprofile']) == 1) {

    $dossier_etude = get_dossier_data(clean_in_integer($_SESSION['my_m_dossier']));
    if ($dossier_etude['is_exist'] == 1) {
?>

        <form class="form-horizontal" action="<?php echo $cible; ?>" method="post">
            <p align="center">
            <h4>Enregistrer un Commentaire sur le Dossier en Interne</h4>
            </p>
            <div class="box-body">




                <div class="form-group">
                    <label class="col-sm-2 control-label">Operation</label>
                    <div class="col-sm-10">
                        <select name="ref_operation" class="form-control select2">
                            <?php echo getcombo_operation_groupement('Commentaire_interne'); ?>
                        </select>
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Commentaires</label>
                    <div class="col-sm-10">
                        <textarea name="commentaire" cols="100%" rows="2" class="form-control"></textarea>

                    </div>

                </div>



                <div class="form-group">
                    <label class="col-sm-2 control-label">Contact reponse</label>
                    <div class="col-sm-10">
                        <select name="feedback_phone" class="form-control select2">

                            <option value="+243 82 7000 776">+243 82 7000 776</option>
                            <option value="+243 82 7000 755">+243 82 7000 755</option>
                            <option value="+243 85 0050 755">+243 85 0050 755</option>
                            <option value="+243 82 6999 755">+243 82 6999 755</option>
                            <option value="+243 81 8155 109">+243 81 8155 109</option>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Contact email</label>
                    <div class="col-sm-10">
                        <select name="feedback_email" class="form-control select2">

                            <option value="admin@passportsarl.voyage">admin@passportsarl.voyage</option>
                            <option value="info@passportsarl.voyage">info@passportsarl.voyage</option>
                            <option value="votreavis@passportsarl.voyage">votreavis@passportsarl.voyage</option>

                        </select>
                    </div>

                </div>


            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="reset" class="btn btn-default pull-left" onClick="hide_pop()">Fermer cette fenetre</button>
                <button type="submit" class="btn btn-info pull-right" name="submit_commentaire_interne">Valider la demande d'information</button>
            </div><!-- /.box-footer -->
        </form>



<?php
    } else {

        echo "Désolé mais cet enregistrement n'existe pas dans le système";
    }
}
?>
