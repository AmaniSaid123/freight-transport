<!DOCTYPE html>
<html lang="en">

<?php
session_start();

require_once __DIR__ . '/../../includes/translation.php';

?>


<?php include(__DIR__ . '/../layouts/head.php'); ?>


<body>

    <?php include(__DIR__ . '/../layouts/topbar.php'); ?>

    <?php include(__DIR__ . '/../layouts/menu.php'); ?>

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h3 class="display-7 mb-4 wow fadeInDown" data-wow-delay="0.1s"><?= t('terms_title') ?> </h1>
                <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="homepage.php"><?= t('home') ?></a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active text-black"><?= t('terms_title') ?></li>
                </ol>
        </div>
    </div>
    <!-- Header End -->



    <div class="container">

        <div class="terms-content">
            <h6 style="text-align:center"><?= t('terms_intro') ?>
            </h6>
            <div id="article1" class="article">
                <div class="article-header">
                    <div class="article-number">1</div>
                    <h2 class="article-title"><?= t('terms_title1') ?></h2>
                </div>
                <div class="article-content">
                    <p><?= t('terms_title1_content') ?></p>
                    <div class="highlight">
                        <?= t('terms_title1_content_highlight') ?>
                    </div>
                    <p><?= t('terms_title1_content1') ?></p>
                </div>
            </div>

            <div id="article2" class="article">
                <div class="article-header">
                    <div class="article-number">2</div>
                    <h2 class="article-title"><?= t('terms_title2') ?></h2>
                </div>
                <div class="article-content">
                    <p><?= t('terms_title2_content') ?></p>
                </div>
            </div>

            <div id="article3" class="article">
                <div class="article-header">
                    <div class="article-number">3</div>
                    <h2 class="article-title"><?= t('terms_title3') ?></h2>
                </div>
                <div class="article-content">
                    <div class="sub-article">
                        <h3><?= t('terms_title3_content_sub_article_title1') ?></h3>
                        <p><?= t('terms_title3_content_sub_article_text1') ?></p>
                    </div>

                    <div class="sub-article">
                        <h3><?= t('terms_title3_content_sub_article_title2') ?></h3>
                        <ol>
                            <li><?= t('terms_title3_content_sub_article_text2_list1') ?></li>
                            <li><?= t('terms_title3_content_sub_article_text2_list2') ?></li>
                        </ol>
                        <p><?= t('terms_title3_content_sub_article_text2') ?>
                        </p>
                    </div>
                </div>
            </div>

            <div id="article4" class="article">
                <div class="article-header">
                    <div class="article-number">4</div>
                    <h2 class="article-title"><?= t('terms_title4') ?></h2>
                </div>
                <div class="article-content">
                    <p><?= t('terms_title4_content1') ?></p>
                    <p><?= t('terms_title4_content2') ?></p>
                    <p><?= t('terms_title4_content3') ?></p>
                </div>
            </div>

            <div id="article5" class="article">
                <div class="article-header">
                    <div class="article-number">5</div>
                    <h2 class="article-title"><?= t('terms_title5') ?></h2>
                </div>
                <div class="article-content">
                    <p><?= t('terms_title5_content1') ?></p>
                    <p><?= t('terms_title5_content2') ?></p>
                </div>
            </div>

            <div id="article6" class="article">
                <div class="article-header">
                    <div class="article-number">6</div>
                    <h2 class="article-title"><?= t('terms_title6') ?></h2>
                </div>
                <div class="article-content">
                    <p><?= t('terms_title6_content1') ?></p>
                    <p><?= t('terms_title6_content2') ?></p>
                    <p><?= t('terms_title6_content3') ?></p>
                    <div class="highlight">
                        <p><?= t('terms_title6_content_highlight') ?></p>
                    </div>
                    <p><?= t('terms_title6_content4') ?></p>
                </div>
            </div>

            <div id="article7" class="article">
                <div class="article-header">
                    <div class="article-number">7</div>
                    <h2 class="article-title"><?= t('terms_title7') ?></h2>
                </div>
                <div class="article-content">
                    <p><?= t('terms_title7_content1') ?> </p>
                    <p><?= t('terms_title7_content2') ?></p>
                    <div class="highlight">
                        <p><?= t('terms_title7_content_highlight') ?></p>
                    </div>
                </div>
            </div>

            <div id="article8" class="article">
                <div class="article-header">
                    <div class="article-number">8</div>
                    <h2 class="article-title"><?= t('terms_title8') ?></h2>
                </div>
                <div class="article-content">
                    <p><?= t('terms_title8_content') ?></p>
                </div>
            </div>

            <div id="article9" class="article">
                <div class="article-header">
                    <div class="article-number">9</div>
                    <h2 class="article-title"><?= t('terms_title9') ?></h2>
                </div>
                <div class="article-content">
                    <p><?= t('terms_title9_content1') ?></p>
                    <p><?= t('terms_title9_content2') ?></p>
                </div>
            </div>

            <div id="article10" class="article">
                <div class="article-header">
                    <div class="article-number">10</div>
                    <h2 class="article-title"><?= t('terms_title10') ?></h2>
                </div>
                <div class="article-content">
                    <p><?= t('terms_title10_content') ?></p>
                </div>
            </div>

            <div id="article11" class="article">
                <div class="article-header">
                    <div class="article-number">11</div>
                    <h2 class="article-title"><?= t('terms_title11') ?></h2>
                </div>
                <div class="article-content">
                    <p><?= t('terms_title11_content1') ?></p>
                    <p><?= t('terms_title11_content2') ?></p>
                </div>
            </div>

            <div id="article12" class="article">
                <div class="article-header">
                    <div class="article-number">12</div>
                    <h2 class="article-title"><?= t('terms_title12') ?></h2>
                </div>
                <div class="article-content">
                    <p><?= t('terms_title12_content1') ?></p>
                    <p><?= t('terms_title12_content2') ?></p>
                    <div class="highlight">
                        <p><?= t('terms_title12_content_highlight') ?></p>
                    </div>
                </div>
            </div>


        </div>
    </div>


    <?php include(__DIR__ . '/../layouts/footer.php'); ?>


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>


    <?php include(__DIR__ . '/../layouts/js.php'); ?>





</body>

</html>