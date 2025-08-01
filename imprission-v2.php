<?php
include_once("php/session_check_online.php");
include_once("php/function.php");
$data_dossier = "";


if (isset($_SESSION['my_doc_online']) && intval($_SESSION['my_doc_online']) > 0) {

    $data_dossier = get_dossier_data($_SESSION['my_doc_online']);
}

if (isset($_SESSION['my_m_dossier']) && intval($_SESSION['my_m_dossier']) > 0) {

    $data_dossier = get_dossier_data($_SESSION['my_m_dossier']);
}
if (isset($_GET['val_ndel']) && intval($_GET['val_ndel']) > 0) {

    $data_dossier = get_dossier_data_by_ndel($_GET['val_ndel']);
    //echo "hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh";
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="back/assets/" data-template="vertical-menu-template-free">

<?php
include_once("php/layouts/head-v2-back.php");

?>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="back/assets/css/invoice3.css">

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
                        <h6 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dossier en ligne /</span> Page Imprimable</h6>
                        <div class="row">
                            <div class="col-xxl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0 style-h5">FORMULAIRE DE RENSEIGNEMENT ET DE SUIVI DU DOSSIER
                                        </h5>
                                    </div>
                                    <?php
                                    if ($data_dossier['is_exist'] == 1) {

                                    ?>
                                        <section class="front">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="front-invoice-wrapper">
                                                            <div class="front-invoice-top">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="front-invoice-top-left">
                                                                            <h2><?php echo $data_dossier['identite']; ?></h2>
                                                                            <h3>Référence d'enregistrement en Ligne : <?php echo $data_dossier['ndel']; ?></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="front-invoice-top-right">
                                                                            <img src="images/logo_passport.png" width="auto" height="100" />

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <h1 class="service-name">FORMULAIRE DE RENSEIGNEMENT ET DE SUIVI DU DOSSIER</h1>
                                                                        <h6 class="date">NID :<?php echo $data_dossier['ndel'] . " et PIN : " . $data_dossier['pin_secret']; ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="front-invoice-bottom">
                                                                <div class="row">
                                                                    <div class="col-xs-12">
                                                                        <h6 class="specs">1. IDENTITE DU CLIENT</h6>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12">
                                                                        <table class="table borderless custom-table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="style-td">Nom complet</td>
                                                                                    <td><?php echo $data_dossier['identite']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Date de naissance</td>
                                                                                    <td><?php echo $data_dossier['date_naissance']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Email</td>
                                                                                    <td><?php echo $data_dossier['email']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Téléphone</td>
                                                                                    <td><?php echo $data_dossier['numero_telephone']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Lieu de naissance</td>
                                                                                    <td><?php echo $data_dossier['lieu_naissance']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Nom complet de votre père biologique</td>
                                                                                    <td><?php echo $data_dossier['identite_pere']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Lieu de naissance de votre père</td>
                                                                                    <td><?php echo $data_dossier['lieu_naissance_pere']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Date de naissance de votre père </td>
                                                                                    <td><?php echo $data_dossier['date_naissance_pere']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Nom complet de votre mère biologique</td>
                                                                                    <td><?php echo $data_dossier['identite_mere']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Lieu de naissance de votre mère</td>
                                                                                    <td><?php echo $data_dossier['lieu_naissance_mere']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Date de naissance de votre mère</td>
                                                                                    <td><?php echo $data_dossier['date_naissance_mere']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Nombre d'enfants dans votre famille</td>
                                                                                    <td><?php echo $data_dossier['nbre_enfant_famille']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Le quantième dans la famille</td>
                                                                                    <td><?php echo $data_dossier['position_dans_famille']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Numéro Passeport</td>
                                                                                    <td><?php echo $data_dossier['numero_passport']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Date d'expiration Passeport</td>
                                                                                    <td><?php echo $data_dossier['date_expiration_pp']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Le nom de votre agence</td>
                                                                                    <td>
                                                                                        <?php

                                                                                        if ($data_dossier['ref_agence'] == 1) {
                                                                                        ?>
                                                                                            Kinshasa
                                                                                        <?php
                                                                                        } else {
                                                                                        ?>
                                                                                            Lubumbashi
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Promoteur de l'agence</td>
                                                                                    <td><?php echo $data_dossier['promoteur_agence']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">PIN Secret</td>
                                                                                    <td><?php echo $data_dossier['pin_secret']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Information supplémentaire</td>
                                                                                    <td><?php echo $data_dossier['commentaire_client']; ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="bottom-bar"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </section>
                                        <section class="front">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="front-invoice-wrapper">
                                                            <div class="front-invoice-top front-invoice-top-perso">

                                                            </div>
                                                            <div class="front-invoice-bottom">
                                                                <div class="row">
                                                                    <div class="col-xs-12">
                                                                        <h6 class="specs"> 2. PARCOURS D'ETUDES</h6>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <h5 class="specs"> 2.1. Votre parcours Secondaire</h5>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <table class="table borderless custom-table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Année</th>
                                                                                    <th>Etablissement</th>
                                                                                    <th>Intitulé de la formation</th>
                                                                                    <th>Niveau</th>
                                                                                    <th>Résultats</th>
                                                                                </tr>
                                                                                <?php
                                                                                $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu='SECONDAIRE' and ref_dossier=" . $data_dossier['idt_dossier'] . "";
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
                                                                                    </tr>

                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <h6 class="specs"> 2.2. Diplome d'Etat ou son équivalent</h6>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <table class="table borderless custom-table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Année obtention</th>
                                                                                    <th>Ecole fréquentée</th>
                                                                                    <th>Option</th>
                                                                                    <th>Pourcentage</th>
                                                                                    <th>Pays d'obtention</th>
                                                                                    <th>Ville d'obtention</th>
                                                                                </tr>
                                                                                <?php
                                                                                $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu='EXETAT' and ref_dossier=" . $data_dossier['idt_dossier'] . "";
                                                                                //echo $sql_select1;

                                                                                $sql_result1 = $bdd->query($sql_select1);

                                                                                $index = 0;

                                                                                while ($data1 = $sql_result1->fetch()) { ?>
                                                                                    <tr>
                                                                                        <td><?php echo $index; ?></td>
                                                                                        <td><?php echo $data1['annee']; ?></td>
                                                                                        <td><?php echo $data1['institution']; ?></td>
                                                                                        <td><?php echo $data1['formation']; ?></td>
                                                                                        <td><?php echo $data1['resultat']; ?></td>
                                                                                        <td><?php echo $data1['pays_obtention']; ?></td>
                                                                                        <td><?php echo $data1['ville_obtention']; ?></td>


                                                                                    </tr>
                                                                                <?php  } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <h6 class="specs"> 2.3. Votre parcours Post-secondaire</h6>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <table class="table borderless custom-table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Année</th>
                                                                                    <th>Etablissement</th>
                                                                                    <th>Intitulé de la formation</th>
                                                                                    <th>Niveau</th>
                                                                                    <th>Résultats</th>
                                                                                    <th>Diplome Obtenu</th>
                                                                                </tr>
                                                                                <?php
                                                                                $sql_select1 = "SELECT * FROM passport_bd.t_dossier_etude where diplome_obtenu not in ('EXETAT','SECONDAIRE') and ref_dossier=" . $data_dossier['idt_dossier'] . "";
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


                                                                                    </tr>

                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <h6 class="specs"> FICHIER TELECHARGEES</h6>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <table class="table borderless custom-table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Titre document</th>
                                                                                    <th>ajouté le </th>
                                                                                    <th>Type</th>
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
                                                                                        <td><?php echo $data1['type_fichier']; ?></td>


                                                                                    </tr>

                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="bottom-bar"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </section>
                                        <section class="front">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="front-invoice-wrapper">
                                                            <div class="front-invoice-top front-invoice-top-perso">

                                                            </div>
                                                            <div class="front-invoice-bottom">
                                                                <div class="row">
                                                                    <div class="col-xs-12">
                                                                        <h6 class="specs"> 3. ACTIVITES PASSEES ET ACTUELLES</h6>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12">
                                                                        <table class="table borderless custom-table">
                                                                            <tbody>

                                                                                <tr>
                                                                                    <td class="style-td">Votre Activités passés et actuelles</td>
                                                                                    <td><?php echo $data_dossier['activite_passe_actuelle']; ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <h6 class="specs"> 4. VOYAGE </h6>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12">

                                                                        <table class="table borderless custom-table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="style-td">Votre destination </td>
                                                                                    <td><?php echo $data_dossier['vo_destination']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Raison du voyage </td>
                                                                                    <td><?php echo $data_dossier['vo_raison_voyage']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Personne qui prendra en charge ces études</td>
                                                                                    <td><?php echo $data_dossier['vo_charge_etude_parrain']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Vos ancien Visa </td>
                                                                                    <td><?php echo $data_dossier['vo_ancien_visa']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td"> Liste des anciens Visa </td>
                                                                                    <td><?php echo $data_dossier['vo_ancien_visa_comment']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td"> Vos refus Visa</td>
                                                                                    <td><?php echo $data_dossier['vo_refus_visa']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Liste des anciens Visa refus</td>
                                                                                    <td><?php echo $data_dossier['vo_refus_visa_comment']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Votre famille à votre lieu de destination</td>
                                                                                    <td><?php echo $data_dossier['vo_destination_famille']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Le nom de votre famille de lieu de destination</td>
                                                                                    <td><?php echo $data_dossier['vo_destination_comment']; ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <h6 class="specs">5. PRISE EN CHARGE</h6>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12">

                                                                        <table class="table borderless custom-table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="style-td"> Votre garant</td>
                                                                                    <td><?php echo $data_dossier['pc_qualite_garant']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Travail de votre garant</td>
                                                                                    <td><?php echo $data_dossier['pc_lieu_travail_garant']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Son salaire mensuel</td>
                                                                                    <td><?php echo $data_dossier['pc_salaire_parrain']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Son activité commerciale ou une entreprise </td>
                                                                                    <td><?php echo $data_dossier['pc_activite_pro']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Le nom de l'activité </td>
                                                                                    <td><?php echo $data_dossier['pc_activite_pro_nom']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Revenu mensuel pour cette activité ou entreprise en $(Estimation) </td>
                                                                                    <td><?php echo $data_dossier['pc_revenu_parrain']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Nombre de parcelles</td> 
                                                                                    <td><?php echo $data_dossier['pc_nbre_parcelle']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Nombre de véhicule </td>
                                                                                    <td><?php echo $data_dossier['pc_nbre_vehicule']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Email Facultatif</td>
                                                                                    <td><?php echo $data_dossier['email_secondaire']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="style-td">Téléphone Secondaire</td>
                                                                                    <td><?php echo $data_dossier['numero_telephone_secondaire']; ?></td>
                                                                                </tr>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="bottom-bar"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </section>
                                    <?php
                                    } else {

                                        echo '<h4 class="box-title">Il n\'y a aucun dossier pour ce numero : ' . $_GET['val_ndel'] . ' </h4>';
                                    }
                                    ?>
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
</body>

</html>