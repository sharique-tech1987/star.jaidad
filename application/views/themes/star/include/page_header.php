<div id="wrapper-content" class="clearfix ">
    <div class="page-top-section">
        <section class="page-title page-title-large page-title-background" style="padding-top:70px;padding-bottom:70px">
            <div class="page-title-background"
                 style="background-image: url(<?php echo asset_url('front/pages/' . $page->thumbnail); ?>)"></div>
            <div class="container">
                <div class="page-title-inner">
                    <div class="page-title-main-info">
                        <h4><?php echo $page->title; ?></h4>
                    </div>
                    <?php include "breadcrumb.php"; ?>
                </div>
            </div>
        </section>
        <?php include __DIR__ . "/../news_ticker.php";
        ?>
    </div>