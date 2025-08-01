<?php
include_once("php/function.php");

if ($_SERVER['PHP_SELF']) {
  $allUsers = "select idprofile,iduser from t_user join t_profile t on ref_profile=idprofile
               where iduser NOT IN  (1,9,10,11,12,15,17,18,19,20,21,23,24,25,26,27,28,29,30,31,33)";
  $sql = $bdd->query($allUsers);
  while ($row = $sql->fetch()) {
    $iduser = $row['iduser'];
    $idprofile = $row['idprofile'];
    $dateNow = date("Y-m-d");
    $testCronJournal = get_cron_journal_users($iduser, $dateNow);
    if ((isset($testCronJournal['user_id']) && isset($testCronJournal['date']))) {
      echo "<br> exist .$iduser. $idprofile";
    } else {
      echo "<br> not . $iduser. $idprofile";
      $insert =  insert_journal($iduser, $idprofile, $dateNow);
      if ($insert == 1) {
        echo ('yes');
      }
    }
  }
}
