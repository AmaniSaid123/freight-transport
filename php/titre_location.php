          <h1>
            <a href="<?php echo $_SERVER['PHP_SELF'];	?>" class="btn btn-box-tool" ><i class="fa fa-refresh"></i></a>
              <?php echo $page_titre;	?>
              
            <small><?php echo $page_small_detail;?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="https://passportsarl.voyage/MyPASS/home.php"><i class="fa  fa-close"></i></a><a href="https://passportsarl.voyage/MyPASS/home.php"><i class="fa fa-dashboard"></i>Accueil |</a>Où suis-je</li>
            <li class="active"><?php echo $page_location;	?></li>
          </ol>