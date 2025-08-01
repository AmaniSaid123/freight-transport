              <?php if (get_access(15, $_SESSION['my_idprofile']) == 1 || get_access(16, $_SESSION['my_idprofile']) == 1 | get_access(17, $_SESSION['my_idprofile']) == 1 || get_access(26, $_SESSION['my_idprofile']) == 1) { ?>
                <li class=" <?php echo ($get_active_menu == "sms") ? "active" : ""; ?> treeview">
                  <a href="#">
                    <i class="fa fa-envelope-o" aria-hidden="true" /></i>
                    <span>Menu SMS & Mail</span>
                    <i class="fa fa-angle-left pull-right" aria-hidden="true" /></i>
                  </a>
                  <ul class="treeview-menu">
                    <?php if (get_access(15, $_SESSION['my_idprofile']) == 1 || get_access(16, $_SESSION['my_idprofile']) == 1 | get_access(17, $_SESSION['my_idprofile']) == 1 || get_access(26, $_SESSION['my_idprofile']) == 1) { ?>
                      <li><a href="bulk_in.php"><i class="fa fa-circle-o text-aqua" aria-hidden="true" /></i>In-Out-Ecrire-Broadcast</a></li>
                    <?php
                    }
                    ?>
                    <?php if (get_access(30, $_SESSION['my_idprofile']) == 1) { ?>
                      <li><a href="bulk_mail.php"><i class="fa fa-circle-o text-aqua" aria-hidden="true" /></i>Bulk Mail</a></li>
                    <?php
                    }
                    ?>
                    <?php if (get_access(61, $_SESSION['my_idprofile']) == 1) : ?>
                      <li><a href="manager_sms.php"><i class="fa fa-circle-o text-aqua" aria-hidden="true" /></i>Sms-Anniversaire</a></li>
                    <?php endif; ?>

                    <?php if (get_access(27, $_SESSION['my_idprofile']) == 1) { ?>
                      <li><a href="report_sms.php"><i class="fa fa-circle-o text-aqua" aria-hidden="true" /></i>Rapport SMS</a></li>
                    <?php
                    }
                    ?>
                    <?php if (get_access(67, $_SESSION['my_idprofile']) == 1) { ?>
                        <li><a href="mail_payment.php"><i class="fa fa-circle-o text-aqua" aria-hidden="true" /></i>Emails dynamiques</a></li>
                    <?php
                    }
                    ?>
                  </ul>
                </li>
              <?php
              }
              ?>