



<form class="form-horizontal" action="<?php echo $cible ; ?>"  method="post">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Identité Dossier : <?php echo $data_dossier['identite'] . " | NID = " . $data_dossier['ndel'] . ' | <font color="GREEN">Statut Dossier = '.$data_dossier['statut_dossier'].'</font>'; ?></h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>


                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">

                <?php if (get_access(19, $_SESSION['my_idprofile']) == 1) { ?>
    <button type="submit" class="btn btn-app pull-left bg-light-blue" name="btn_action" value="btn_paiement"><i class="fa fa-dollar "></i>Enregitrer un Paiement</button>
<?php } ?>
<?php if (get_access(20, $_SESSION['my_idprofile']) == 1) { ?>
    <button type="submit" class="btn btn-app pull-left bg-purple-active" name="btn_action" value="btn_request_info"><i class="fa fa-info "></i>Demander une Information au Client</button>
<?php } ?>
<?php if (get_access(21, $_SESSION['my_idprofile']) == 1) { ?>
    <button type="submit" class="btn btn-app pull-left bg-light-blue" name="btn_action" value="btn_demande_doc"><i class="fa fa-folder-open"></i>Demander un Document au Client</button>
<?php } ?>
<?php if (get_access(22, $_SESSION['my_idprofile']) == 1) { ?>
    <button type="submit" class="btn btn-app pull-left bg-purple-active" name="btn_action" value="btn_commentaire_externe"><i class="fa fa-commenting"></i>Enregistrer un Commentaire pour le Client</button>
<?php } ?>
<?php if (get_access(23, $_SESSION['my_idprofile']) == 1) { ?>
    <button type="submit" class="btn btn-app pull-left bg-light-blue" name="btn_action" value="btn_commentaire_interne"><i class="fa  fa-comments-o"></i>Enregistrer Commentaire sur le Dossier en Interne</button>
<?php } ?>
<?php if (get_access(24, $_SESSION['my_idprofile']) == 1) { ?>
    <button type="submit" class="btn btn-app pull-left bg-purple-active" name="btn_action" value="btn_change_statut_dossier"><i class="fa fa-refresh "></i>Editer Statut Dossier</button>
<?php } ?>
<button type="submit"  class="btn btn-app pull-right bg-gray-active" name="submit_change_client_view"  value="submit_change_client_view" <?php echo (get_access(25, $_SESSION['my_idprofile']) == 1) ? "" : "disabled"; ?>><i class="fa  <?php echo ($data_dossier['allow_edit_for_client'] == 1) ? "fa-check-square-o" : "fa-close"; ?> "></i><?php echo ($data_dossier['allow_edit_for_client'] == 1) ? "Modification en ligne par client activée" : "Modification en ligne client désactivée"; ?></button>

                </div><!-- /.box-body -->
                <div class="box-footer">
                <?php if (get_access(53, $_SESSION['my_idprofile']) == 1) { ?>
                <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-plus"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Ordre Encaissement</span>
                  <span class="info-box-number"><?php  echo get_sum_oe("Valide","USD",$data_dossier['ndel'])." $";	?> </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-plus"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Ordre Encaissement</span>
                  <span class="info-box-number"><?php  echo get_sum_oe("Valide","CDF",$data_dossier['ndel'])." CDF";	?> </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-minus"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Ordre de Paiement</span>
                  <span class="info-box-number"><?php  echo get_sum_op("Decaisser","USD",$data_dossier['ndel'])." $";	?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-minus"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Ordre de Paiement</span>
                  <span class="info-box-number"><?php  echo get_sum_op("Decaisser","CDF",$data_dossier['ndel'])." CDF";	?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <?php } ?>
                </div><!-- /.box-footer
                -->

            </div><!-- /.box -->

        </form>   